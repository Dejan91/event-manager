<?php

namespace App\Http\Controllers;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
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

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        request()->validate(
            [
                'cardNumber'  => 'digits:8',
                'expiryMonth' => 'digits:2',
                'expiryYear'  => 'digits:4',
                'cvCode'      => 'digits:4',
            ]
        );

        auth()->user()->assignRole('Event Manager');
        auth()->user()->removeRole('Client');

        return redirect()->route('home')
            ->withFlash('Upgraded to Event Manager');
    }
}
