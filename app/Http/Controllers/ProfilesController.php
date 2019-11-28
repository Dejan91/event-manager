<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProfilesController
 * @package App\Http\Controllers
 */
class ProfilesController extends Controller
{
    /**
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('profiles.edit', compact('user'));
    }

    /**
     * @param User $user
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(User $user)
    {
        $this->authorize('update', $user);

        request()->validate(
            [
                'name'  => 'required',
                'email' => 'required|email',
            ]
        );

        $user->update(request()->all());

        return back()->withFlash('Profile updated');
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function changePassword(User $user)
    {
        request()->validate(
            [
                'new_password'    => 'required|min:5',
                'repeat_password' => 'required|same:new_password',
            ]
        );

        $user->update(
            [
                'password' => Hash::make(request('new_password')),
            ]
        );

        return back()->withFlash('Password Changed');
    }
}
