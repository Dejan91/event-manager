<?php

use Illuminate\Http\Request;

// Authentication
Route::post('/register', 'Api\Auth\AuthController@register')->middleware('api');
Route::post('/login', 'Api\Auth\AuthController@login')->middleware('api');

// Search
Route::get('/events', 'Api\EventsController@index')->middleware('auth:api');
Route::get('/event/search/{query?}', 'SearchController@show')->middleware('auth:api');

// Events
Route::get('/events/{event}', 'Api\EventsController@show')->middleware('auth:api');

// Comments
Route::get('/events/{event}/comments', 'Api\CommentsController@index')->middleware('auth:api');
Route::post('/events/{event}/comments', 'Api\CommentsController@store')->middleware('auth:api');
Route::patch('/comments/{comment}', 'Api\CommentsController@update')->middleware('auth:api');
Route::delete('/comments/{comment}', 'Api\CommentsController@destroy')->middleware('auth:api');

// Users
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return new \App\Http\Resources\UserResource($request->user());
});
