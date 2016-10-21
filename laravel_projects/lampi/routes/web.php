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

Route::get('/', function () {
    return view('welcome');
});

Route::get('user', 'UserController@index');

Route::get('user/store', 'UserController@store');

Route::get('user/update', 'UserController@update');
Route::get('user/create', 'UserController@create');

Route::get('user/del', 'UserController@del');


