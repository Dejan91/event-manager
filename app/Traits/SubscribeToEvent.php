<?php

namespace App\Traits;

use App\EventSubscription;

trait SubscribeToEvent
{
    public function subscribe()
    {
        if (! $this->isSubscribed) {
            $subscription = $this->subscription()
                ->create(['user_id' => auth()->id()]);

            $this->subscribeUserToEventMails($subscription);
    
        }
    }

    public function unsubscribe()
    {
        $this->unsubscribeUserFromEventMails();        

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

    public function subscribeUserToEventMails($subscription)
    {
        $subscription->user->mailTypes()->attach([
            'mail_type_id' => 1,
        ]);

        $subscription->user->mailTypes()->attach([
            'mail_type_id' => 2,
        ]);
    }

    public function unsubscribeUserFromEventMails()
    {
        $this->subscription()
            ->where('user_id', auth()->id())
            ->first()
            ->user
            ->mailTypes()
            ->detach();
    }

}