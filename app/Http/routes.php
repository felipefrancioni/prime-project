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

Route::get('client', 'ClientController@index');
Route::post('client', 'ClientController@store');
Route::get('client/{id}', 'ClientController@show');
Route::put('client/{id}', 'ClientController@update');
Route::delete('client/{id}', 'ClientController@destroy');

Route::get('project', 'ProjectController@index');
Route::post('project', 'ProjectController@store');
Route::post('project/{id}/member', 'ProjectController@storeNewMember');
Route::get('project/{id}', 'ProjectController@show');
Route::put('project/{id}', 'ProjectController@update');
Route::delete('project/{id}', 'ProjectController@destroy');
Route::delete('project/{idProject}/member/{idMember}', 'ProjectController@destroyMember');
Route::get('project/{id}/members', 'ProjectController@showMembers');
Route::get('project/{idProject}/member/{idMember}', 'ProjectController@isMember');


Route::get('projectTask', 'ProjectTaskController@index');
Route::post('projectTask', 'ProjectTaskController@store');
Route::get('projectTask/{idTask}', 'ProjectTaskController@show');
Route::put('projectTask/{idTask}', 'ProjectTaskController@update');
Route::delete('projectTask/{idTask}', 'ProjectTaskController@destroy');
