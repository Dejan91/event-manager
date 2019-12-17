<?php

use Illuminate\Http\Request;

// Authentication
Route::post('register', 'Api\Auth\AuthController@register');
Route::post('login', 'Api\Auth\AuthController@login');

// Comments
Route::middleware('auth:api')->post('/event/{event}/comments', 'Api\CommentsController@store');
Route::middleware('auth:api')->delete('/comments/{comment}', 'Api\CommentsController@destroy');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
