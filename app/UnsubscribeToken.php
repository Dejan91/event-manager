<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UnsubscribeToken
 * @package App
 * @property int    user_id
 * @property string token
 */
class UnsubscribeToken extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token',
    ];

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'token';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    public static function generateFor(User $user)
    {
        if ($user->unsubscribeToken()->exists()) {
            $user->unsubscribeToken()->delete();
        }

        return static::create(
            [
                'user_id' => $user->id,
                'token'   => Str::random(50),
            ]
        );
    }
}
