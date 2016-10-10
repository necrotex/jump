<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('/login', ['as' => 'auth.login', 'uses' => 'AuthController@login']);
Route::get('/sso/callback', ['as' => 'auth.callback', 'uses' => 'AuthController@callback']);
Route::get('/logout', ['as' => 'auth.logout', 'uses' => 'AuthController@logout']);
