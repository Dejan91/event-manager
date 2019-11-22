<?php

Route::get('/', function () {
    return view('welcome');
});

// Auth
Auth::routes(['verify' => true]);

// Home
Route::get('/home', 'HomeController@index')->name('home');

// Sociallite
Route::get('login/{driver}', 'Auth\SocialAuthController@redirectToProvider')->name('social.oauth');
Route::get('login/{driver}/callback', 'Auth\SocialAuthController@handleProviderCallback')->name('social.callback');

// Events
Route::get('event', 'EventsController@index')->middleware('auth');
Route::get('event/create', 'EventsController@create')->middleware(['auth', 'verified', 'role:Super Admin|Event Manager']);
Route::get('event/{event}', 'EventsController@show')->middleware('auth');
Route::get('/event/edit/{event}', 'EventsController@edit')->middleware(['auth', 'verified', 'role:Super Admin|Event Manager']);
Route::post('event', 'EventsController@store')->middleware(['auth', 'verified', 'role:Super Admin|Event Manager']);
Route::put('event/update/{event}', 'EventsController@update')->middleware(['auth', 'verified', 'role:Super Admin|Event Manager']);
Route::delete('event/{event}', 'EventsController@destroy')->middleware(['auth', 'verified', 'role:Super Admin|Event Manager']);

// Roles
Route::get('role', 'RoleController@index')->middleware(['auth', 'verified', 'role:Client']);
Route::post('role/update', 'RoleController@update')->middleware(['auth', 'verified', 'role:Client']);

// Countries
Route::get('country', 'CountriesController@index')->middleware(['auth', 'verified', 'role:Super Admin|Event Manager']);

// Comments
Route::get('/event/{event}/comments', 'CommentsController@index')->middleware('auth');
Route::post('/event/{event}/comments', 'CommentsController@store')->middleware('auth', 'verified');
Route::patch('/comments/{comment}', 'CommentsController@update')->middleware('auth', 'verified');
Route::delete('/comments/{comment}', 'CommentsController@destroy')->middleware('auth', 'verified');

// Favorites
Route::post('/favorite/{model}/{id}', 'FavoritesController@store')->middleware(['auth', 'verified', 'role:Client']);
Route::delete('/favorite/{model}/{id}', 'FavoritesController@destroy')->middleware(['auth', 'verified', 'role:Client']);

// Event Subscriptions
Route::post('/event/{event}/subscription', 'EventSubscriptionController@store')->middleware('auth', 'verified');
Route::delete('/event/{event}/subscription', 'EventSubscriptionController@destroy')->middleware('auth', 'verified');

// Users Profile
Route::get('/users/{user}/profile/edit', 'UsersController@edit')->middleware('auth', 'verified')->name('profile.edit');

// Event Mail Preferences
Route::get('/users/{user}/mails/edit', 'MailPreferenceController@show')->middleware('auth', 'verified')->name('profile.mail.edit');
Route::post('/users/{user}/mails/update', 'MailPreferenceController@update')->middleware('auth', 'verified')->name('profile.mail.update');