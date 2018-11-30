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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/create', 'HomeController@CreateConersation');
Route::POST('/reconnect', 'HomeController@reconnect');
Route::post('/send', 'HomeController@send');
Route::post('/receive', 'HomeController@receive');
Route::post('/close', 'HomeController@close');

