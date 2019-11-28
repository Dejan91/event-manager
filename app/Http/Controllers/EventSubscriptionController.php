<?php

namespace App\Http\Controllers;

use App\Event;

/**
 * Class EventSubscriptionController
 * @package App\Http\Controllers
 */
class EventSubscriptionController extends Controller
{
    /**
     * @param Event $event
     */
    public function store(Event $event)
    {
        $event->subscribe();
    }

    /**
     * @param Event $event
     */
    public function destroy(Event $event)
    {
        $event->unsubscribe();
    }
}
