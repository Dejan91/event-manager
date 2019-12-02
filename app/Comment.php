<?php

namespace App;

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
     * @return string
     */
    public function path()
    {
        return "/comment/{$this->id}";
    }
}
