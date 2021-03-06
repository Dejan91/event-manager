<?php

namespace App;

use Carbon\Carbon;
use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @package App
 * @property int    user_id
 * @property int    event_id
 * @property string body
 * @property User   owner
 */
class Comment extends Model
{
    use Favoritable,
        RecordsActivity;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'body',
    ];

    /**
     * @var array
     */
    protected $with = [
        'owner',
        'favorites',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'favoritesCount',
        'isFavorited',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return mixed
     */
    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    /**
     * @return mixed
     */
    public function mentionedUsers()
    {
        preg_match_all('/\@([^\s\.]+)/', $this->body, $matches);

        return $matches[1];
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->event->path() . "#comment-{$this->id}";
    }
}
