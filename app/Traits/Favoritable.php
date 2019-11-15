<?php

namespace App\Traits;

use App\Favorite;

trait Favoritable
{
    /**
     * Get all of the post's comments.
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function favorite()
    {
        if (! $this->isFavorited()) {
            $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}