<?php

namespace App\Traits;

use App\EventSubscription;

/**
 * Trait SubscribeToEvent
 * @package App\Traits
 */
trait SubscribeToEvent
{
    /**
     *
     */
    public function subscribe()
    {
        if (!$this->isSubscribed) {
            $this->subscription()->create(['user_id' => auth()->id()]);
        }
    }

    /**
     *
     */
    public function unsubscribe()
    {
        $this->subscription()->where('user_id', auth()->id())->delete();
    }

    /**
     * @return mixed
     */
    public function getIsSubscribedAttribute()
    {
        return $this->subscription()->where('user_id', auth()->id())->exists();
    }

    /**
     * @return mixed
     */
    public function getSubscribersCountAttribute()
    {
        return $this->subscription->count();
    }

    /**
     * @return mixed
     */
    public function subscription()
    {
        return $this->hasMany(EventSubscription::class);
    }
}
