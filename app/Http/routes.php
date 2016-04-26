<?php


Route::get('/', function () {
    return view('app');
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
        Route::post('{projectId}/member', 'ProjectController@storeNewMember');//ok
        Route::delete('{projectId}/member/{idMember}', 'ProjectController@destroyMember');//ok
        Route::get('{projectId}/members', 'ProjectController@showMembers'); //ok
        Route::get('{projectId}/member/{idMember}', 'ProjectController@isMember'); //ok

        Route::get('{projectId}/tasks', 'ProjectTaskController@index'); //ok
        Route::post('{projectId}/task', 'ProjectTaskController@store'); //ok
        Route::get('{projectId}/task/{idTask}', 'ProjectTaskController@show'); //ok
        Route::put('{projectId}/task/{idTask}', 'ProjectTaskController@update'); //ok
        Route::delete('{projectId}/task/{idTask}', 'ProjectTaskController@destroy');//ok

        Route::post('file', 'ProjectFileController@store');//ok
        Route::delete('{projectId}/file/{fileId}', 'ProjectFileController@destroy');//ok
    });

});


