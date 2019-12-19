<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Trending;
use App\Http\Controllers\Controller;
use App\Http\Resources\Events\EventResource;

class EventsController extends Controller
{
    /**
     * @param Event $event
     * @param Trending $trending
     * @return EventResource
     */
    public function show(Event $event, Trending $trending)
    {
        $trending->push($event);

        $event->recordVisit();

        return new EventResource($event);
    }
}
