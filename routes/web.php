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


Route::redirect('/', '/threads');

//Route::resource('threads', 'ThreadsController');
Route::get('threads','ThreadsController@index');
Route::get('threads/create','ThreadsController@create');
Route::get('threads/{channel}/{thread}','ThreadsController@show');
Route::post('threads','ThreadsController@store');
Route::post('/threads/{channel}/{thread}/replies','RepliesController@store');

Auth::routes();

