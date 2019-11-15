<?php

namespace App;

use App\Traits\Favoritable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Favoritable;

    protected $fillable = ['user_id', 'event_id', 'body'];

    protected $with = ['owner', 'favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function path()
    {
        return "/comment/{$this->id}";
    }
}