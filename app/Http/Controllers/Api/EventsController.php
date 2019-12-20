<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Filters\EventFilters;
use App\Http\Resources\Events\EventsCollectionResource;
use App\Http\Resources\ResourceIncludes\EventResourceIncludes;
use App\Trending;
use App\Http\Controllers\Controller;
use App\Http\Resources\Events\EventResource;

/**
 * Class EventsController
 * @package App\Http\Controllers\Api
 */
class EventsController extends Controller
{
    /**
     * @var EventResourceIncludes
     */
    protected $includes;

    /**
     * EventsController constructor.
     * @param EventResourceIncludes $includes
     */
    public function __construct(EventResourceIncludes $includes)
    {
        $this->includes = $includes;
    }

    /**
     * @param EventFilters $filters
     * @param Trending $trending
     * @return EventsCollectionResource
     */
    public function index(EventFilters $filters, Trending $trending)
    {
        $events = Event::latest()->filter($filters);

        return new EventsCollectionResource(
            $events->paginate(10), $trending
        );
    }

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
