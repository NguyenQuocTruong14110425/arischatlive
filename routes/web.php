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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@home');
Route::get('/get-profile', 'HomeController@getProfile');
Route::get('/get-list-friend', 'HomeController@getListFriend');
Route::get('/get-list-friend-invite', 'HomeController@getListFriendInvite');
Route::get('/invite-aplication', 'HomeController@inviteAplication');
Route::get('/get-flowers', 'HomeController@getFlowers');
Route::get('/send-message', 'HomeController@sendMessToFriend');
Route::get('/webhook', 'HomeController@webhook');
Route::POST('/send', 'HomeController@SendMessage');
