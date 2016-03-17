<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Posts;

class ViewThrottleFilter
{
    private $session;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $this->session = $request->session();
        $this->filter(); // Throttle view count based on every hour so page refreshes don't automatically increment count

        return $next($request); // let the request follows its flow
    }

    public function filter()
    {
        $posts = $this->getViewedPosts();

        if ( ! is_null($posts))
        {
            $posts = $this->cleanExpiredViews($posts);

            $this->storePosts($posts);
        }
    }

    private function getViewedPosts()
    {
        // Get all the viewed posts from the session. If no
        // entry in the session exists, default to null.
        return $this->session->get('viewed_posts', null);
    }

    private function cleanExpiredViews($posts)
    {
        $time = time();

        // Let the views expire after one hour.
        $throttleTime = 3600;

        // Filter through the post array. The argument passed to the
        // function will be the value from the array, which is the
        // timestamp in our case.
        return array_filter($posts, function ($timestamp) use ($time, $throttleTime)
        {
            // If the view timestamp + the throttle time is
            // still after the current timestamp the view
            // has not expired yet, so we want to keep it.
            return ($timestamp + $throttleTime) > $time;
        });
    }

    private function storePosts($posts)
    {
        $this->session->put('viewed_posts', $posts);
    }
}
