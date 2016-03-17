<?php

namespace App\Listeners;

use App\Events\ViewPostHandler;
use App\Models\Posts;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ViewPostListener
{
    private $session;
    private $post;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(ViewPostHandler $handler)
    {
        $this->post = $handler->post;
        $this->session = $handler->session;

        // Check if session doesn't already just viewed this post
        if ( ! $this->isPostViewed($this->post))
        {
            $this->post->increment('view_counter');
            $this->post->view_counter += 1;

            $this->storePost($this->post);
        }
    }

    private function isPostViewed($post)
    {
        // Get all the viewed posts from the session. If no
        // entry in the session exists, default to an
        // empty array.
        $viewed = $this->session->get('viewed_posts', []);

        // Check if the post id exists as a key in the array.
        return array_key_exists($post->id, $viewed);
    }

    private function storePost($post)
    {
        // First make a key that we can use to store the timestamp
        // in the session. Laravel allows us to use a nested key
        // so that we can set the post id key on the viewed_posts
        // array.
        $key = 'viewed_posts.' . $post->id;

        // Then set that key on the session and set its value
        // to the current timestamp.
        $this->session->put($key, time());
    }
}
