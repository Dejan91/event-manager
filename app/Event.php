<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'image_path', 'start_date', 'end_date'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getImagePathAttribute($image)
    {
        return asset($image ? 'storage/' . $image : 'images/event_images/default.png');
    }

}
