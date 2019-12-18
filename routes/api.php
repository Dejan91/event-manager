<?php

use Illuminate\Http\Request;

// Authentication
Route::post('/register', 'Api\Auth\AuthController@register')->middleware('api');
Route::post('/login', 'Api\Auth\AuthController@login')->middleware('api');

// Comments
Route::get('/event/{event}/comments', 'Api\CommentsController@index')->middleware('auth:api');
Route::post('/event/{event}/comments', 'Api\CommentsController@store')->middleware('auth:api');
Route::delete('/comments/{comment}', 'Api\CommentsController@destroy')->middleware('auth:api');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return new \App\Http\Resources\UserResource($request->user());
});
