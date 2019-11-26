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

Route::get('/', 'AppController@index')->name('index');

Route::post('/', 'AppController@login')->name('login');

Route::get('/logout', 'AppController@logout');

Route::get('/chatroom', 'AppController@chatroom')->name('chatroom');
