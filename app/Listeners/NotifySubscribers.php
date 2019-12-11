<?php

namespace App\Listeners;

use App\Events\EventReceivedNewComment;

class NotifySubscribers
{
    /**
     * Handle the event.
     *
     * @param  EventReceivedNewComment  $event
     * @return void
     */
    public function handle(EventReceivedNewComment $event)
    {
        $event->comment->event->subscription
            ->where('user_id', '!=', $event->comment->user_id)
            ->each
            ->notify($event->comment);
    }
}
