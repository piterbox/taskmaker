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

Route::get('/', ['uses' => 'TaskController@index']);
Route::get('/tasks', ['uses' => 'TaskController@gettasks']);
Route::post('/add', ['uses' => 'TaskController@add']);
Route::get('/create', ['uses' => 'TaskController@create']);
Route::get('/information', ['uses' => 'TaskController@information']);
Route::get('/tasks/{id}/edit', ['uses' => 'TaskController@edit'])->where('id', '[0-9]+');
Route::get('/gettask/{id}', ['uses' => 'TaskController@gettask'])->where('id', '[0-9]+');
Route::put('/tasks/{id}/update', ['uses' => 'TaskController@update'])->where('id', '[0-9]+');
Route::delete('/tasks/{id}/delete', ['uses' => 'TaskController@delete'])->where('id', '[0-9]+');
Route::post('/tasks/info', ['uses' => 'TaskController@getInfo']);
Auth::routes();

Route::get('/cabinet', 'CabinetController@index')->name('cabinet');
Route::post('/cabinet/update', ['uses' => 'CabinetController@update'])->name('cabinetupdate');
//Route::get('/cabinet/update', ['uses' => 'CabinetController@update']);
