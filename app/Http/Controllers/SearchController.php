<?php

namespace App\Http\Controllers;

use App\Event;

class SearchController extends Controller
{
    public function show($query = '')
    {
        return Event::search($query)->get();
    }
}
