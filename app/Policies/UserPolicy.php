<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the event.
     *
     * @param User $authUser
     * @param \App\User $user
     * @return mixed
     */
    public function update(User $authUser, User $user)
    {
        return $authUser->id === $user->id;
    }
}
