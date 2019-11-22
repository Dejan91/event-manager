<?php

namespace App\Http\Controllers;

use App\User;

class UsersController extends Controller
{
    public function edit(User $user)
    {
        return view('profiles.edit', compact('user'));
    }
}
