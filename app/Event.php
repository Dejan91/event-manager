<?php

namespace App;

use App\Country;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['user_id', 'country_id', 'title', 'description', 'image_path', 'start_date', 'end_date'];

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
        $this->comments()->create($comment);
    }

}
