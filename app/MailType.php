<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MailType
 * @package App
 * @property string name
 * @property User   users
 */
class MailType extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
