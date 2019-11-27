<?php

namespace App;

use App\Country;
use App\Traits\Favoritable;
use App\Traits\SubscribeToEvent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 * @package App
 *
 * @property int user_id
 */
class Event extends Model
{
    use Favoritable, SubscribeToEvent;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'country_id', 'title', 'description', 'image_path', 'start_date', 'end_date'];

    /**
     * @var array
     */
    protected $with = ['creator', 'favorites', 'subscription'];

    protected $appends = ['favoritesCount', 'isFavorited', 'subscribersCount'];

    /**
     * @var array
     */
    protected $dates = ['start_date', 'end_date'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('commentCount', function ($builder) {
            $builder->withCount('comments');
        });
    }

    /**
     * @param $image
     * @return string
     */
    public function getImagePathAttribute($image)
    {
        return asset($image ? 'storage/' . $image : 'images/event_images/default.png');
    }

    /**
     * @return string
     */
    public function path()
    {
        return "/event/{$this->id}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @param $comment
     * @return Model
     */
    public function addComment($comment)
    {
        return $this->comments()->create($comment);
    }

    /**
     * @param $query
     * @param $filters
     * @return mixed
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

}
