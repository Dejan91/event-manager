<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redis;

trait RecordsVisits
{
    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());

        return $this;
    }

    public function visits()
    {
        return Redis::get($this->visitsCacheKey()) ?? 0;
    }

    protected function visitsCacheKey()
    {
        return "events.{$this->id}.visits";
    }

    public function getVisitsCountAttribute()
    {
        return $this->visits();
    }
}