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

Route::get('/member', function () {
    return view('group.member');
});

Route::get('/', function () {
    return view('group.index');
});

Route::resource('personnel', 'Personnel\PersonnelController');


//group
//Route::resource('/group', 'Group\GroupController')->except(['show','destroy','edit']) ->middleware('loginAuth');
Route::resource('/group', 'Group\GroupController')->except(['show', 'destroy', 'edit']);
//Route::post('/group/update/{id}', 'Group\GroupController@update')->middleware('loginAuth');
Route::post('/group/update/{id}', 'Group\GroupController@update');

//groupMember
//Route::resource('/group/member', 'Group\GroupMemberController')->except(['show','destroy','edit'])->middleware('loginAuth');
Route::resource('/group/member', 'Group\GroupMemberController')->except(['show', 'destroy', 'edit', 'create']);


//Route::resource('/channel', 'Channel\ChannelController')->except(['show','destroy','edit'])->middleware('loginAuth');
Route::resource('/channel', 'Channel\ChannelController')->except(['show', 'destroy', 'edit']);
//Route::post('/channel/update/{id}', 'Channel\ChannelController@update')->middleware('loginAuth');
Route::post('/channel/update/{id}', 'Channel\ChannelController@update');


//auth
Route::get('/auth/login', 'AuthBack\LoginController@login')->name('auth.login');
Route::get('/auth/login/haBook/login-as-haBook', 'AuthBack\LoginController@loginAsHaBook')->name('auth.login.haBook');
Route::get('/auth/login/callback-haBook', 'AuthBack\LoginController@callbackHaBook')->name('auth.login.callbackHaBook');
Route::get('/auth/logout/HaBook', 'AuthBack\LoginController@logout')->name('auth.logout.haBook');
Route::get('/auth/logout/chang-callback', 'AuthBack\LoginController@changCallbackUrl')->name('auth.chang.callback');
