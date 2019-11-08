<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role: Event Manager']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'description' => 'required|min:10',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $attributes['user_id'] = auth()->id();

        Event::create($attributes);

        return response()->json(['success' => 'Event Created'], 200);
    }
}
