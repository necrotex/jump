<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/systems/autocomplete', ['as' => 'api.systems.autocomplete', 'uses' => 'Api\SystemController@autocomplete']);
Route::post('/systems/range', ['as' => 'api.systems.range', 'uses' => 'Api\SystemController@systemsInRange']);

Route::get('/crest/location', ['as' => 'api.crest.location', 'uses' => 'Api\CrestController@getLocation']);
Route::post('/crest/waypoint', ['as' => 'api.crest.waypoint', 'uses' => 'Api\CrestController@setWaypoint']);

