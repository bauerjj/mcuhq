<?php

namespace Hazzard\Comments;

use RuntimeException;
use Hazzard\Comments\Comment;
use Illuminate\Support\Facades\Auth;
use OpenClassrooms\Akismet\Services\AkismetService;
use OpenClassrooms\Akismet\Client\Impl\ApiClientImpl;
use OpenClassrooms\Akismet\Models\Impl\CommentBuilderImpl;
Use OpenClassrooms\Akismet\Services\Impl\AkismetServiceImpl;
use Hazzard\Comments\Contracts\Formatter as FormatterContract;

class Moderator implements Contracts\Moderator
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Hazzard\Comments\Contracts\Formatter
     */
    protected $formatter;

    /**
     * @var \OpenClassrooms\Akismet\Services\AkismetService
     */
    protected $akismetService;

    /**
     * Create a new moderator instance.
     *
     * @param  array $config
     * @param  \Hazzard\Comments\Contracts\Formatter $formatter
     * @return void
     */
    public function __construct(array $config, FormatterContract $formatter)
    {
        $this->config = $config;
        $this->formatter = $formatter;
    }

    /**
     * Determine the comment status.
     *
     * @param  \Hazzard\Comments\Comment $comment
     * @return string
     */
    public function determineStatus($comment)
    {
        if (Auth::check() && Auth::user()->can('moderate', Comment::class)) {
            return Comment::STATUS_APPROVED;
        }

        if ($this->config['moderation']) {
            return Comment::STATUS_PENDING;
        }

        if ($this->contains($comment, 'blacklist_keys')) {
            return Comment::STATUS_SPAM;
        }

        if ($this->contains($comment, 'moderation_keys')) {
            return Comment::STATUS_PENDING;
        }

        if ($this->hasTooManyLinks($comment)) {
            return Comment::STATUS_PENDING;
        }

        if ($this->isSpam($comment)) {
            return Comment::STATUS_SPAM;
        }

        return Comment::STATUS_APPROVED;
    }

    /**
     * Check if contains specific keys.
     *
     * @param  \Hazzard\Comments\Comment $comment
     * @param  string $type
     * @return bool
     */
    protected function contains($comment, $type)
    {
        $fields = $comment->toArray();

        foreach ($this->config[$type] as $key) {
            if (empty($key)) {
                continue;
            }

            foreach ($fields as $field) {
                if (is_string($field) && preg_match('/\b'.$key.'\b/', $field)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if the comment content contains too many links.
     *
     * @param  \Hazzard\Comments\Comment $comment
     * @return bool
     */
    protected function hasTooManyLinks($comment)
    {
        if (! $this->config['max_links']) {
            return false;
        }

        $xml = $this->formatter->parse($comment->content);

        $html = $this->formatter->render($xml);

        $found = preg_match_all('/<a [^>]*href/i', $html);

        return $found >= $this->config['max_links'];
    }

    /**
     * Determine if the if the comment input is spam using Akismet.
     *
     * @param  \Hazzard\Comments\Comment $comment
     * @return bool
     */
    protected function isSpam($comment)
    {
        if (! $this->config['akismet']) {
            return false;
        }

        $com = (new CommentBuilderImpl)->create()
              ->withUserIp($comment->author_ip)
              ->withUserAgent($comment->user_agent)
              ->withReferrer($comment->referrer)
              ->withPermalink($comment->permalink)
              ->withAuthorName($comment->author_name)
              ->withAuthorEmail($comment->author_email)
              ->withContent($comment->content)
              ->build();

        return $this->getAkismetService()->commentCheck($com);
    }

    /**
     * Get the Akismet service.
     *
     * @return \OpenClassrooms\Akismet\Services\AkismetService
     */
    protected function getAkismetService()
    {
        if (isset($this->akismetService)) {
            return $this->akismetService;
        }

        $key = config('services.akismet_key');

        if (empty($key)) {
            throw new RuntimeException(
                'You must set the "akismet_key" in config/services.php.'
            );
        }

        return tap(new AkismetServiceImpl, function ($service) use ($key) {
            $service->setApiClient(new ApiClientImpl($key, url('/')));
        });
    }

    /**
     * Set the Akismet service.
     *
     * @param \OpenClassrooms\Akismet\Services\AkismetService $service
     */
    public function setAkismetService(AkismetService $service)
    {
        $this->akismetService = $service;
    }
}
