<?php

namespace App;

use App\Traits\PreferMails;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @package App
 * @property string name
 * @property string email
 * @property string password
 * @property string avatar_path
 * @property string thumb_path
 * @property int provider_id
 * @property string provider
 * @property string access_token
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,
        HasRoles,
        PreferMails;

    /**
     * @var array
     */
    protected $with = ['roles'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path',
        'thumb_path',
        'provider_id',
        'provider',
        'access_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param $avatar
     *
     * @return string
     */
    public function getAvatarPathAttribute($avatar)
    {
        return asset($avatar ? 'storage/' . $avatar : 'images/users_avatars/default.png');
    }

    /**
     * @param $thumb
     *
     * @return string
     */
    public function getThumbPathAttribute($thumb)
    {
        return asset($thumb ? 'storage/' . $thumb : 'images/users_thumbs/default.png');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unsubscribeToken()
    {
        return $this->hasMany(UnsubscribeToken::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}
