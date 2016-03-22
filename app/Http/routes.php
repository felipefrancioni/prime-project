<?php


Route::get('/', function () {
    return view('welcome');
});

Route::post('oauth/access_token', function () {
    return Response::jSon(Authorizer::issueAccessToken());
});

Route::group(['middleware' => 'oauth'], function () {
    Route::resource('client', 'ClientController', [
        'except' => [
            'create',
            'edit'
        ]
    ]);

    Route::resource('project', 'ProjectController', [
        'except' => [
            'create',
            'edit'
        ]
    ]);

    //    Route::group(['middleware' => 'CheckProjectOwner'], function () {
    //
    //    });

    Route::group(['prefix' => 'project'], function () {
        Route::post('{id}/member', 'ProjectController@storeNewMember');
        Route::delete('{idProject}/member/{idMember}', 'ProjectController@destroyMember');
        Route::get('{id}/members', 'ProjectController@showMembers');
        Route::get('{idProject}/member/{idMember}', 'ProjectController@isMember');

        Route::get('{idProject}/tasks', 'ProjectTaskController@index');
        Route::post('{idProject}/task', 'ProjectTaskController@store');
        Route::get('{idProject}/task/{idTask}', 'ProjectTaskController@show');
        Route::put('{idProject}/task/{idTask}', 'ProjectTaskController@update');
        Route::delete('{idProject}/task/{idTask}', 'ProjectTaskController@destroy');
    });

});


