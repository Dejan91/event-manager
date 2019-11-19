<?php

namespace App;

use App\Country;
use App\Traits\Favoritable;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use Favoritable;

    protected $fillable = ['user_id', 'country_id', 'title', 'description', 'image_path', 'start_date', 'end_date'];
    
    protected $with = ['creator', 'favorites', 'subscription'];

    protected $dates = ['start_date', 'end_date'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('commentCount', function ($builder) {
            $builder->withCount('comments');
        });
    }

    public function getImagePathAttribute($image)
    {
        return asset($image ? 'storage/' . $image : 'images/event_images/default.png');
    }

    public function path()
    {
        return "/event/{$this->id}";
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function addComment($comment)
    {
        return $this->comments()->create($comment);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe()
    {
        if (! $this->isSubscribed()) {
            $this->subscription()->create(['user_id' => auth()->id()]);   
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
