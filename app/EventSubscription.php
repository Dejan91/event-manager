<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EventSubscription
 * @package App
 *
 * @property int  user_id
 * @property int  event_id
 * @property User user
 */
class EventSubscription extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'event_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
