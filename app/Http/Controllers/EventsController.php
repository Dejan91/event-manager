<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EventsController extends Controller
{
    /**
     * Return all events
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
       $events = Event::all();

       return response()->json($events);
    }

    /**
     * Show form for creating new event
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('modal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'title' => 'required|min:2',
            'description' => 'required|min:10',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $attributes['user_id'] = auth()->id();

        $event = Event::create($attributes);

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
        return view('modal.edit', compact('event'));
    }

    /**
     * Update existing resource in storage.
     *
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Event $event)
    {
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
        $event->delete();

        return response()->json([
            'success' => 'Event Deleted',
        ]);
    }
}
