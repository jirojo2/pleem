<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('lc', 'LCController');
Route::resource('event', 'EventController');
Route::resource('group', 'GroupController');
Route::resource('member', 'MemberController');

Route::resource('event.member', 'EventMemberController');
Route::resource('event.group', 'EventGroupController');
Route::resource('event.group.member', 'EventGroupMemberController');
