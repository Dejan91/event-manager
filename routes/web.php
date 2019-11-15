<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth
Auth::routes();

// Home
Route::get('/home', 'HomeController@index')->name('home');

// Sociallite
Route::get('login/{driver}', 'Auth\SocialAuthController@redirectToProvider')->name('social.oauth');
Route::get('login/{driver}/callback', 'Auth\SocialAuthController@handleProviderCallback')->name('social.callback');

// Events
Route::get('event', 'EventsController@index')->middleware('auth');
Route::get('event/create', 'EventsController@create')->middleware(['auth', 'role:Super Admin|Event Manager']);
Route::get('event/{event}', 'EventsController@show')->middleware('auth');
Route::get('/event/edit/{event}', 'EventsController@edit')->middleware(['auth', 'role:Super Admin|Event Manager']);
Route::post('event', 'EventsController@store')->middleware(['auth', 'role:Super Admin|Event Manager']);
Route::put('event/update/{event}', 'EventsController@update')->middleware(['auth', 'role:Super Admin|Event Manager']);
Route::delete('event/{event}', 'EventsController@destroy')->middleware(['auth', 'role:Super Admin|Event Manager']);

// Roles
Route::get('role', 'RoleController@index')->middleware(['auth', 'role:Client']);
Route::post('role/update', 'RoleController@update')->middleware(['auth', 'role:Client']);

// Countries
Route::get('country', 'CountriesController@index')->middleware(['auth', 'role:Super Admin|Event Manager']);

// Comments
Route::post('/event/{event}/comments', 'CommentsController@store')->middleware('auth');
Route::put('/comments/edit/{comment}', 'CommentsController@update')->middleware('auth');
Route::delete('/comments/delete/{comment}', 'CommentsController@destroy')->middleware('auth');

// Favorites
Route::post('/comment/{comment}/favorite', 'FavoritesController@store');