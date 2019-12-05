<?php

namespace App;

use App\Notifications\EventWasUpdated;
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

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function notify($comment)
    {
        $this->user->notify(new EventWasUpdated($this->event, $comment));
    }
}
