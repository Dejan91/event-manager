<?php

namespace App\Traits;

use App\Favorite;

/**
 * Trait Favoritable
 * @package App\Traits
 */
trait Favoritable
{
    /**
     * @return mixed
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    /**
     *
     */
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->isFavorited()) {
            $this->favorites()->create($attributes);
        }
    }

    /**
     *
     */
    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->delete();
    }

    /**
     * @return bool
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    /**
     * @return bool
     */
    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * @return mixed
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
