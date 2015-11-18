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

// Landing
Route::get('/', function () {
    return view('landing');
});

// Password reset link request
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// ContentTools save
Route::post('x/save-page', 'ContentToolsController@savePage');

// View CV
Route::get('cv/{userId}', 'MemberController@showCV');
Route::post('cv/{userId}', 'MemberController@uploadCV');

// API
Route::group(array('prefix' => 'api/v1'), function() {

    Route::get('/csrf-token', function() {
        return response()->json([ 'token' => Session::token() ]);
    });

    // Authentication
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');
    Route::get('auth/user', 'Auth\AuthController@getUser');

    Route::resource('member', 'MemberController',
                    ['except' => ['index', 'show', 'create', 'edit']]);
    Route::resource('group', 'GroupController',
                    ['except' => ['create', 'edit']]);
    Route::resource('group.member', 'GroupMemberController',
                    ['only' => ['index', 'show', 'store', 'destroy']]);
    Route::resource('group.score', 'GroupScoreController',
                    ['only' => ['index', 'show', 'store', 'destroy']]);
    Route::resource('idea', 'IdeaController',
                    ['except' => ['create', 'edit']]);

    Route::resource('config', 'ConfigController',
                    ['only' => ['index', 'store']]);

});
