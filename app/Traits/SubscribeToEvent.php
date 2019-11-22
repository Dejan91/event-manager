<?php

namespace App\Traits;

use App\EventSubscription;

trait SubscribeToEvent
{
    public function subscribe()
    {
        if (! $this->isSubscribed) {
            $this->subscription()
                ->create(['user_id' => auth()->id()]);
        }
    }

    public function unsubscribe()
    {    
        $this->subscription()
            ->where('user_id', auth()->id())
            ->delete();
    }

    public function getIsSubscribedAttribute()
    {
        return $this->subscription()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function getSubscribersCountAttribute()
    {
        return $this->subscription->count();
    }
    
    public function subscription()
    {
        return $this->hasMany(EventSubscription::class);
    }

}