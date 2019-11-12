<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Show form for upgrading to role Event Manager
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('role.index');
    }

    public function update()
    {
        // Proccess payment

        auth()->user()->assignRole('Event Manager');
        auth()->user()->removeRole('Client');

        return redirect()->route('home');
    }

}
