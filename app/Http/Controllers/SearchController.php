<?php

namespace App\Http\Controllers;

use App\Event;

class SearchController extends Controller
{
    public function show()
    {
        $search = request('q');

        return Event::search($search)->get();
    }
}
