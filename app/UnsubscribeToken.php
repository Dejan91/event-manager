<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UnsubscribeToken extends Model
{
    protected $fillable = ['user_id', 'token'];

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateFor(User $user)
    {
        if ($user->unsubscribeToken()->exists()) {
            $user->unsubscribeToken()->delete();
        }

        return static::create([
            'user_id' => $user->id,
            'token' => Str::random(50),
        ]);
    }
}
