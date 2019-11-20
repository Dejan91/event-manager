<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailType extends Model
{
    public function users()
    {
        $this->belongsToMany(User::class);
    }
    
}
