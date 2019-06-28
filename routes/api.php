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

Route::get('group', 'Api\GroupController@getGroupAll');
Route::get('group/user', 'Api\GroupController@getGroupUserAll');
Route::get('group/user/exist', 'Api\GroupController@getMemberGroupExist');
Route::get('users', 'Api\UserController@getUserAll');
