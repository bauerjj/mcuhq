<?php

namespace Hazzard\Comments\Tests;

use Hazzard\Comments\Comment;
use Hazzard\Comments\Contracts\Formatter as FormatterContract;

class ModeratorTest extends TestCase
{
    protected function moderator(array $config = [], $formatter = null)
    {
        return new \Hazzard\Comments\Moderator(
            array_merge(config('comments'), $config), $formatter ?: new FormatterFake
        );
    }

    /** @test */
    public function it_can_determine_the_comment_status()
    {
        $status = $this->moderator()->determineStatus(new Comment(['content' => 'foo']));
        $this->assertEquals(Comment::STATUS_APPROVED, $status);

        $status = $this->moderator(['moderation' => true])->determineStatus(new Comment(['content' => 'foo']));
        $this->assertEquals(Comment::STATUS_PENDING, $status);
    }

    /** @test */
    public function it_can_determine_if_contains_moderation_keys()
    {
        $comment = new Comment(['content' => 'Putting apples in an applepie.']);
        $status = $this->moderator(['moderation_keys' => ['apple.*']])->determineStatus($comment);
        $this->assertEquals(Comment::STATUS_PENDING, $status);
    }

    /** @test */
    public function it_can_determine_if_contains_blacklist_keys()
    {
        $comment = new Comment(['content' => 'Putting apples in an applepie.']);
        $status = $this->moderator(['blacklist_keys' => ['apple.*']])->determineStatus($comment);
        $this->assertEquals(Comment::STATUS_SPAM, $status);
    }

    /** @test */
    public function it_can_determine_if_has_too_many_links()
    {
        $text = 'http://example.org/link1 http://example.org/link2';
        $html = '<a href="http://example.org/link1">http://example.org/link1</a> <a href="http://example.org/link2">http://example.org/link2</a>';

        $formatter = \Mockery::mock(FormatterContract::class);
        $formatter->shouldReceive('parse')->once()->with($text)->andReturn('xml')
                ->shouldReceive('render')->once()->with('xml')->andReturn($html);

        $status = $this->moderator(['max_links' => 2], $formatter)->determineStatus(new Comment(['content' => $text]));
        $this->assertEquals(Comment::STATUS_PENDING, $status);
    }

    /** @test */
    public function it_can_determine_if_is_spam_using_akismet()
    {
        $akismetService = \Mockery::mock(\OpenClassrooms\Akismet\Services\AkismetService::class);
        $akismetService->shouldReceive('commentCheck')->once()->andReturn(true);

        $moderator = $this->moderator(['akismet' => true]);
        $moderator->setAkismetService($akismetService);

        $status = $moderator->determineStatus(new Comment(['content' => 'foo']));
        $this->assertEquals(Comment::STATUS_SPAM, $status);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function it_throws_exception_if_akismet_ket_is_not_set()
    {
        $status = $this->moderator(['akismet' => true])->determineStatus(new Comment(['content' => 'foo']));
        $this->assertEquals(Comment::STATUS_SPAM, $status);
    }
}
