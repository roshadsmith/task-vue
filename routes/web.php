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

Route::get('/', [
    'uses' => 'TaskController@index',
    'as' => 'home'
]);

Route::get('/tasks', [
    'uses' => 'TaskController@getTasks',
    'as' => 'tasks'
]);

Route::post('/store', [
    'uses' => 'TaskController@store',
    'as' => 'store'
]);

Route::post('/update/{id}', [
    'uses' => 'TaskController@edit'
]);

Route::get('/remove/{id}', [
    'uses' => 'TaskController@destroy'
]);

Route::get('/completed/{id}', [
    'uses' => 'TaskController@update'
]);
