<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Trending
{
    public function get()
    {
        return array_map('json_decode', Redis::zrevrange($this->cacheKey(), 0, 9));
    }

    public function push($event)
    {
        Redis::zincrby($this->cacheKey(), 1, json_encode([
            'title' => $event->title,
            'path'  => $event->path(),
        ]));
    }

    protected function cacheKey()
    {
        return 'trendint_events';
    }
}