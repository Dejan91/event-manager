<?php

namespace App\Observers;

use App\Event;
use Illuminate\Support\Facades\Storage;

class EventObserver
{
    /**
     * Handle the event "deleted" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function deleting(Event $event)
    {
        Storage::delete('public/' . $event->getOriginal('image_path'));
    }
}
