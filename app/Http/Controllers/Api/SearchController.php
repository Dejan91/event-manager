<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * @param string $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function show($query = '')
    {
        return Event::search($query)->get();
    }
}
