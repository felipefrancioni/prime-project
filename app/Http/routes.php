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
        Route::post('{projectId}/member', 'ProjectController@storeNewMember');
        Route::delete('{projectId}/member/{idMember}', 'ProjectController@destroyMember');
        Route::get('{projectId}/members', 'ProjectController@showMembers'); //ok
        Route::get('{projectId}/member/{idMember}', 'ProjectController@isMember'); //ok

        Route::get('{projectId}/tasks', 'ProjectTaskController@index');
        Route::post('{projectId}/task', 'ProjectTaskController@store');
        Route::get('{projectId}/task/{idTask}', 'ProjectTaskController@show');
        Route::put('{projectId}/task/{idTask}', 'ProjectTaskController@update');
        Route::delete('{projectId}/task/{idTask}', 'ProjectTaskController@destroy');
    });

});


