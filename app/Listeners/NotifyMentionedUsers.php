<?php

namespace App\Listeners;

use App\User;
use App\Events\EventReceivedNewComment;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  EventReceivedNewComment  $event
     * @return void
     */
    public function handle(EventReceivedNewComment $event)
    {
        User::whereIn('name', $event->comment->mentionedUsers())
            ->get()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWereMentioned($event->comment));
            });
    }
}
