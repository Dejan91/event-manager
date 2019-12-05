<?php

namespace App\Http\Controllers;

use App\Event;
use Exception;
use Illuminate\View\View;
use Illuminate\Http\Response;
use App\Events\EventsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\Events\StoreEvent;
use Illuminate\Auth\Access\AuthorizationException;

class EventsController extends Controller
{
    /**
     * Return all events
     *
     * @param EventsRepository $repository
     * @return Event|Factory|\Illuminate\Database\Eloquent\Builder|View
     */
    public function index(EventsRepository $repository)
    {
        $events = Event::latest()->filter($repository);

        if (request()->expectsJson()) {
            return $events;
        }

        return view('event.index');
    }

    /**
     * Return single event
     *
     * @param Event $event
     *
     * @return Factory|View
     */
    public function show(Event $event)
    {
        return view(
            'event.show',
            [
                'event' => $event->append(['isSubscribed', 'subscribersCount']),
            ]
        );
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
     * @return JsonResponse
     */
    public function store(StoreEvent $request)
    {
        $image_path = null;

        if (request()->hasFile('event_image')) {
            $image_path = request()->file('event_image')->store('event_images', 'public');
        }

        $event = Event::create(
            [
                'user_id'     => auth()->id(),
                'title'       => request('title'),
                'country_id'  => request('country'),
                'description' => request('description'),
                'image_path'  => $image_path,
                'start_date'  => request('start_date'),
                'end_date'    => request('end_date'),
            ]
        );

        return response()->json(
            [
                'success' => 'Event Created',
                'event'   => $event,
            ],
            200
        );
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
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Event $event)
    {
        $this->authorize('update', $event);

        $event->update(request()->all());

        return response()->json(
            [
                'success' => 'Event Updated',
            ],
            204
        );
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

        return response()->json(
            [
                'success' => 'Event Deleted',
            ]
        );
    }
}
