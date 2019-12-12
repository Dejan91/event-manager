<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redis;

trait RecordsVisits
{
    public function recordVisit()
    {
        if (! $this->userVisitedEvent()) {
            Redis::incr($this->userCacheKey());
            Redis::incr($this->visitsCacheKey());
        }
    }

    public function visits()
    {
        return Redis::get($this->visitsCacheKey()) ?? 0;
    }

    protected function visitsCacheKey()
    {
        return "events.{$this->id}.visits";
    }

    protected function userCacheKey()
    {
        return 'user.' . auth()->id() . 'event.' . $this->id;
    }

    public function userVisitedEvent()
    {
        return Redis::get($this->userCacheKey()) >= 1;
    }

    public function getVisitsCountAttribute()
    {
        return $this->visits();
    }
    
}