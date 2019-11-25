<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;

class ProfilesController extends Controller
{
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user);

        request()->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user->update(request()->all());

        return back()
            ->withFlash('Profile updated');
    }

    public function changePassword(User $user)
    {
        request()->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'repeat_password' => 'required|same:new_password',
        ]);

        if (! Hash::check(request('old_password'), $user->password)) {
            return back()
                ->withErrors('Wrong password', 'old_password');
        }

        $user->update([
            'password' => request('new_password'),
        ]);

        return back()
            ->withFlash('Password Changed');
    }
}
