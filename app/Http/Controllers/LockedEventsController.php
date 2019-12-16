<?php

namespace App\Http\Controllers;

use App\Event;

class LockedEventsController extends Controller
{
    public function store(Event $event)
    {
        $event->update(['locked' => true]);
    }

    public function destroy(Event $event)
    {
        $event->update(['locked' => false]);
    }
}
