<?php

namespace App;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Favorite
 * @package App
 * @property int    user_id
 * @property int    favoritable_id
 * @property string favoritable_type
 */
class Favorite extends Model
{
    use RecordsActivity;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'favoritable_id',
        'favoritable_type',
    ];

    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    public function favoritable()
    {
        return $this->morphTo();
    }
}
