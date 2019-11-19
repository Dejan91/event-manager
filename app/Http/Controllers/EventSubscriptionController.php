<?php

namespace App\Http\Controllers;

use App\Event;

class EventSubscriptionController extends Controller
{
    public function store(Event $event)
    {
        $event->subscribe();
    }

    public function destroy(Event $event)
    {
        $event->unsubscribe();
    }
        
}