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

// Search
Route::get('/event/search/{query?}', 'SearchController@show')->middleware('auth');

// Events
Route::get('/event', 'EventsController@index')->middleware('auth')->name('event.index');
Route::get('event/create', 'EventsController@create')->middleware(['auth', 'verified', 'role:Super Admin|Event Manager'])->name('event.create');
Route::get('event/{event}', 'EventsController@show')->middleware('auth')->name('event.show');
Route::get('/event/edit/{event}', 'EventsController@edit')->middleware(['auth', 'verified', 'role:Super Admin|Event Manager']);
Route::post('event', 'EventsController@store')->middleware(['auth', 'verified', 'role:Super Admin|Event Manager']);
Route::put('event/update/{event}', 'EventsController@update')->middleware(['auth', 'verified', 'role:Super Admin|Event Manager']);
Route::delete('event/{event}', 'EventsController@destroy')->middleware(['auth', 'verified', 'role:Super Admin|Event Manager']);

// Roles
Route::get('role', 'RoleController@index')->middleware(['auth', 'verified', 'role:Client']);
Route::post('role/update', 'RoleController@update')->middleware(['auth', 'verified', 'role:Client']);

// Countries
Route::get('country', 'CountriesController@index')->middleware(['auth', 'verified']);

// Comments
Route::get('/event/{event}/comments', 'CommentsController@index')->middleware('auth');
Route::post('/event/{event}/comments', 'CommentsController@store')->middleware('auth', 'verified');
Route::patch('/comments/{comment}', 'CommentsController@update')->middleware('auth', 'verified');
Route::delete('/comments/{comment}', 'CommentsController@destroy')->middleware('auth', 'verified');

// Favorites
Route::post('/favorite/{model}/{id}', 'FavoritesController@store')->middleware('auth', 'verified');
Route::delete('/favorite/{model}/{id}', 'FavoritesController@destroy')->middleware('auth', 'verified');

// Event Subscriptions
Route::post('/event/{event}/subscription', 'EventSubscriptionController@store')->middleware('auth', 'verified');
Route::delete('/event/{event}/subscription', 'EventSubscriptionController@destroy')->middleware('auth', 'verified');

// Users Profile
Route::get('/users/{user}/profile', 'ProfilesController@show')->middleware('auth', 'verified')->name('profile.show');
Route::get('/users/{user}/profile/edit', 'ProfilesController@edit')->middleware('auth', 'verified')->name('profile.edit');
Route::post('/users/{user}/profile/update', 'ProfilesController@update')->middleware('auth', 'verified')->name('profile.update');
Route::post('/users/{user}/password/update', 'ProfilesController@changePassword')->middleware('auth', 'verified')->name('profile.changePassword');

// Users Notifications
Route::get('/users/{user}/profile/notifications', 'UserNotificationsController@index')->middleware('auth', 'verified')->name('notification.index');
Route::delete('/users/{user}/profile/notifications/{notification}', 'UserNotificationsController@destroy')->middleware('auth', 'verified')->name('notification.delete');

// Profile Avatars
Route::patch('/users/{user}/avatar/update', 'ProfilesAvatarController@update')->middleware('auth', 'verified')->name('profile.changeAvatar');

// Event Mail Preferences
Route::get('/users/{user}/mails/edit', 'MailPreferenceController@edit')->middleware('auth', 'verified')->name('profile.mail.edit');
Route::post('/users/{user}/mails/update', 'MailPreferenceController@update')->middleware('auth', 'verified')->name('profile.mail.update');
Route::get('/users/{user}/mails/delete/{unsubscribeToken}', 'MailPreferenceController@destroy')->middleware('auth', 'verified')->name('profile.mail.delete');

// Users Controller
Route::get('api/users', 'Api\UsersController@index');

// Locked Events
Route::post('/locked-events/{event}', 'LockedEventsController@store')->middleware('auth', 'verified', 'role:Super Admin')->name('locked-event.store');
Route::delete('/locked-events/{event}', 'LockedEventsController@destroy')->middleware('auth', 'verified', 'role:Super Admin')->name('locked-event.delete');
