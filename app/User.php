<?php

namespace App;

use App\Traits\PreferMails;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles, PreferMails;

    protected $with = ['roles'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path', 'thumb_path', 'provider_id', 'provider', 'access_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarPathAttribute($avatar)
    {
        return asset($avatar ? 'storage/' . $avatar : 'images/users_avatars/default.png');
    }

    public function getThumbPathAttribute($thumb)
    {
        return asset($thumb ? 'storage/' . $thumb : 'images/users_thumbs/default.png');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function unsubscribeToken()
    {
        return $this->hasMany(UnsubscribeToken::class);
    }

}
