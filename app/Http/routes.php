<?php


    Route::get('/', function () {
        return view('app');
    });

    Route::post('oauth/access_token', function () {
        return Response::jSon(Authorizer::issueAccessToken());
    });

    Route::group(['middleware' => 'oauth'], function () {

        Route::resource('project.member', 'ProjectMemberController', [
            'except' => [
                'create',
                'edit',
                'update'
            ]
        ]);

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

        Route::group(['middleware' => 'check-project-permission', 'prefix' => 'project'], function () {
            Route::post('{projectId}/member', 'ProjectController@storeNewMember');//ok
            Route::delete('{projectId}/member/{idMember}', 'ProjectController@destroyMember');//ok
            Route::get('{projectId}/member', 'ProjectController@showMembers'); //ok
            Route::get('{projectId}/member/{idMember}', 'ProjectController@isMember'); //ok

            Route::get('{projectId}/task', 'ProjectTaskController@index'); //ok
            Route::post('{projectId}/task', 'ProjectTaskController@store'); //ok
            Route::get('{projectId}/task/{idTask}', 'ProjectTaskController@show'); //ok
            Route::put('{projectId}/task/{idTask}', 'ProjectTaskController@update'); //ok
            Route::delete('{projectId}/task/{idTask}', 'ProjectTaskController@destroy');//ok

            Route::get('{projectId}/note', 'ProjectNoteController@index'); //ok
            Route::post('{projectId}/note', 'ProjectNoteController@store'); //ok
            Route::get('{projectId}/note/{noteId}', 'ProjectNoteController@show'); //ok
            Route::put('{projectId}/note/{noteId}', 'ProjectNoteController@update'); //ok
            Route::delete('{projectId}/note/{noteId}', 'ProjectNoteController@destroy');//ok

            Route::get('{projectId}/file', 'ProjectFileController@index');//
            Route::get('{projectId}/file/{fileId}', 'ProjectFileController@show');//ok
            Route::get('{projectId}/file/{fileId}/download', 'ProjectFileController@showFile');//ok
            Route::post('{projectId}/file', 'ProjectFileController@store');//ok
            Route::put('{projectId}/file/{fileId}', 'ProjectFileController@update');//ok
            Route::delete('{projectId}/file/{fileId}', 'ProjectFileController@destroy');//ok
        });

        Route::get('user/authenticated', 'UserController@authenticated');
        Route::resource('user', 'UserController', ['except' => ['create', 'edit']]);
    });


