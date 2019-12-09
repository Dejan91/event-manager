<?php

namespace App;

use App\Traits\Favoritable;
use Laravel\Scout\Searchable;
use App\Traits\RecordsActivity;
use App\Traits\SubscribeToEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Event
 * @package App
 *
 * @property int user_id
 * @property int country_id
 * @property string title
 * @property string description
 * @property string image_path
 * @property string start_date
 * @property string end_date
 * @property User creator
 * @property Country country
 *
 * @method static Builder|$this latest()
 * @method static Builder|$this filter($repository)
 */
class Event extends Model
{
    use Favoritable,
        SubscribeToEvent,
        RecordsActivity,
        Searchable;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'country_id',
        'title',
        'description',
        'image_path',
        'start_date',
        'end_date',
    ];

    /**
     * @var array
     */
    protected $with = [
        'creator',
        'favorites',
        'subscription',
    ];

    protected $appends = [
        'favoritesCount',
        'isFavorited',
        'subscribersCount',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'start_date',
        'end_date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('commentCount', function ($builder) {
            $builder->withCount('comments');
        });

        static::deleting(function ($event) {
            $event->comments->each->delete();
        });
    }

    /**
     * @param $image
     *
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
     *
     * @return Model
     */
    public function addComment($comment)
    {
        $comment =  $this->comments()->create($comment);

        $this->notifySubscribers($comment);

        return $comment;
    }

    protected function notifySubscribers($comment)
    {
        $this->subscription
            ->where('user_id', '!=', $comment->user_id)
            ->each
            ->notify($comment);
    }

    /**
     * @param $query
     * @param $filters
     *
     * @return mixed
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
