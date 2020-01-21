<?php

namespace App\Listeners;

use Hazzard\Comments\Comments\Comment;
use Hazzard\Comments\Events\CommentWasPosted;

class HandleCommentWasNotification
{
   /**
    * Handle the event.
    *
    * @param  CommentWasPosted $event
    * @return void
    */
   public function handle(CommentWasPosted $event)
   {
       // Access the comment using $event->comment...
   }
}