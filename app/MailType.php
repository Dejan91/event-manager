<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailType extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
        $this->belongsToMany(User::class);
    }
    
}