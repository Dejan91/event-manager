<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $user->mailTypes()->attach([
            'mail_type_id' => 1,
        ]);

        $user->mailTypes()->attach([
            'mail_type_id' => 2,
        ]);
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        $user->mailTypes()
            ->detach();
    }

}
