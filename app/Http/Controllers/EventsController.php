<?php

namespace App\Http\Controllers;

use App\Event;
use Exception;
use App\Trending;
use Illuminate\View\View;
use App\Filters\EventFilters;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\Events\StoreEvent;
use Illuminate\Auth\Access\AuthorizationException;

class EventsController extends Controller
{
    /**
     * Return all events
     *
     * @param EventFilters $filters
     * @param Trending $trending
     * @return Factory|View|array
     */
    public function index(EventFilters $filters, Trending $trending)
    {
        $events = Event::latest()->filter($filters)->get();

        if (request()->expectsJson()) {
            return [
                'events' => $events,
                'trending' => $trending->get(),
            ];
        }

        return view('event.index');
    }

    /**
     * Return single event
     *
     * @param Event $event
     *
     * @param Trending $trending
     * @return Factory|View
     */
    public function show(Event $event, Trending $trending)
    {
        $trending->push($event);

        $event->recordVisit();

        return view('event.show', [
                'event' => $event->append(['isSubscribed', 'subscribersCount']),
            ]);
    }

    /**
     * Show form for creating new event
     *
     * @return Factory|View
     */
    public function create()
    {
        $startDate = request('start_date');

        return view('event.modal.create', compact('startDate'));
    }

    /**
     * Store a newly created event in database.
     *
     * @param StoreEvent $request
     * @return JsonResponse
     */
    public function store(StoreEvent $request)
    {
        $image_path = null;

        if (request()->hasFile('event_image')) {
            $image_path = request()->file('event_image')->store('event_images', 'public');
        }

        $event = $request->persist($image_path);

        return response()->json([
                'success' => 'Event Created',
                'event'   => $event,
            ],200);
    }

    /**
     * Show pre populated form for editing event
     *
     * @param Event $event
     *
     * @return Factory|View
     */
    public function edit(Event $event)
    {
        return view('event.modal.edit', compact('event'));
    }

    /**
     * Update existing resource in storage.
     *
     * @param Event $event
     *
     * @param StoreEvent $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Event $event, StoreEvent $request)
    {
        $this->authorize('update', $event);

        $event->update(request()->all());

        return response()->json([
                'success' => 'Event Updated',
            ], 204);
    }

    /**
     * Delete existing resource in storage.
     *
     * @param Event $event
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Event $event)
    {
        $this->authorize('update', $event);

        $event->delete();

        return response()->json([
                'success' => 'Event Deleted',
            ]);
    }

}
