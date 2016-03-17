<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Posts;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Session\Store;


class ViewPostHandler extends Event
{
    use SerializesModels;

    public $post;
    public $session;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Posts $post, Store $session)
    {
        $this->post = $post;
        $this->session = $session;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
