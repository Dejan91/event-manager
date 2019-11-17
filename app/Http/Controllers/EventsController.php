<?php

namespace App\Http\Controllers;

use App\Event;
use App\Filters\EventFilters;
use App\Http\Requests\Events\StoreEvent;

class EventsController extends Controller
{
    /**
     * Return all events
     *
     * @return \Illuminate\Http\JsonResponse
     * @return \Illuminate\Http\Response
     */
    public function index(EventFilters $filters)
    {
        $events = $this->getEvents($filters);

        if (request()->wantsJson()) {
            return $events;
        }

        return view('event.index', compact('events'));
    }

    /**
     * Return single event
     *
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Event $event)
    {
        return view('event.show', [
            'event' => $event,
            'comments' => $event->comments()->paginate(10)
        ]);
    }

    /**
     * Show form for creating new event
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('event.modal.create');
    }

    /**
     * Store a newly created event in database.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEvent $request)
    {
        $image_path = null;

        if (request()->hasFile('event_image')) {
            $image_path = request()->file('event_image')->store('event_images', 'public');
        }

        $event = Event::create([
            'user_id' => auth()->id(),
            'title' => request('title'),
            'country_id' => request('country'),
            'description' => request('description'),
            'image_path' => $image_path,
            'start_date' => request('start_date'),
            'end_date' => request('end_date')
        ]);

        return response()->json([
            'success' => 'Event Created',
            'event' => $event,
        ], 200);
    }

    /**
     * Show pre populated form for editing event
     *
     * @param Event $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Event $event)
    {
        return view('event.modal.edit', compact('event'));
    }

    /**
     * Update existing resource in storage.
     *
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Event $event)
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Event $event)
    {
        $this->authorize('update', $event);

        $event->delete();

        return response()->json([
            'success' => 'Event Deleted',
        ]);
    }

    public function getEvents($filters)
    {
        $events = Event::latest()->filter($filters);

        return $events->get();
    }
}
