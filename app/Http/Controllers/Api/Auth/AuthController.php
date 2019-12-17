<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function register()
    {
        $credintials = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $credintials['password'] = bcrypt(request('password'));

        $user = User::create($credintials);

        $user->assignRole('Client');

        $success['token'] = $user->createToken('Event-Manager')->accessToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User registered successfully');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        request()->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if (Auth::attempt(['email' => request()->email, 'password' => request()->password])) {
            $user = auth()->user();

            $success['token'] = $user->createToken('Event-Manager')->accessToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User loged in successfully');
        } else {
            return $this->sendError('Unauthorised', ['message' => 'Email/Password did not match']);
        }
    }
}
