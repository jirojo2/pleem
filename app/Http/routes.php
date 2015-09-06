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

Route::group(array('prefix' => 'api/v1'), function() {

    Route::get('/csrf-token', function() {
        return response()->json([ 'token' => Session::token() ]);
    });

    Route::resource('lc', 'LCController',
                    ['except' => ['create', 'edit']]);
    Route::resource('event', 'EventController',
                    ['only' => ['index', 'show']]);
    Route::resource('member', 'MemberController',
                    ['except' => ['create', 'edit']]);

    Route::resource('lc.event', 'LCEventController',
                    ['except' => ['create', 'edit']]);
    Route::resource('event.group', 'EventGroupController',
                    ['except' => ['create', 'edit']]);
    Route::resource('event.member', 'EventMemberController',
                    ['only' => ['index', 'show']]);
    Route::resource('event.group.member', 'EventGroupMemberController',
                    ['only' => ['index', 'show', 'store', 'destroy']]);

});
