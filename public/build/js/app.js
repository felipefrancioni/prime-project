var app = angular.module('app', [
    'ngRoute',
    'app.controllers',
    'angular-oauth2',
    'app.services',
    'app.filters',
    'app.directives',
    'ui.bootstrap.typeahead',
    'ui.bootstrap.tpls',
    'ui.bootstrap.datepicker',
    'ngFileUpload'
]);

angular.module('app.controllers', ['ngMessages', 'angular-oauth2']);
angular.module('app.directives', []);
angular.module('app.filters', []);
angular.module('app.services', ['ngResource']);


app.provider('appConfig', function () {
    var config = {
        baseUrl: 'http://localhost:8000',
        project: {
            status: [
                {value: 1, label: 'Não iniciado'},
                {value: 2, label: 'Iniciado'},
                {value: 3, label: 'Concluído'}
            ]
        },
        projectTask: {
            status: [
                {value: 1, label: 'Incompleta'},
                {value: 2, label: 'Completa'}
            ]
        },
        urls: {
            projectFile: '/project/{{projectId}}/file/{{fileId}}'
        },
        utils: {
            transformResponse: function (data, headers) {
                var headerGetter = headers();
                if (headerGetter['content-type'] == 'application/json' || headerGetter['content-type'] == 'text/json') {
                    var dataJson = JSON.parse(data);
                    if (dataJson.hasOwnProperty('data')) {
                        return dataJson.data;
                    }
                    return dataJson;
                }
                return data;
            }
        }
    };
    return {
        config: config,
        $get: function () {
            return config;
        }
    }
})


app.config(['$routeProvider', '$httpProvider', 'OAuthProvider', 'OAuthTokenProvider', 'appConfigProvider', function ($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider) {
    $httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;
    $routeProvider
        .when('/login', {
            templateUrl: 'build/views/login.html',
            controller: 'LoginController'
        })
        .when('/home', {
            templateUrl: 'build/views/home.html',
            controller: 'HomeController'
        })
        .when('/clients', {
            templateUrl: 'build/views/client/list.html',
            controller: 'ClientListController'
        })
        .when('/client/new', {
            templateUrl: 'build/views/client/new.html',
            controller: 'ClientNewController'
        })
        .when('/client/:id/edit', {
            templateUrl: 'build/views/client/edit.html',
            controller: 'ClientEditController'
        })
        .when('/client/:id/remove', {
            templateUrl: 'build/views/client/remove.html',
            controller: 'ClientRemoveController'
        })
        .when('/project/:projectId/notes', {
            templateUrl: 'build/views/project-note/list.html',
            controller: 'ProjectNoteListController'
        })
        .when('/project/:projectId/note/:noteId/show', {
            templateUrl: 'build/views/project-note/show.html',
            controller: 'ProjectNoteShowController'
        })
        .when('/project/:projectId/note/new', {
            templateUrl: 'build/views/project-note/new.html',
            controller: 'ProjectNoteNewController'
        })
        .when('/project/:projectId/note/:noteId/edit', {
            templateUrl: 'build/views/project-note/edit.html',
            controller: 'ProjectNoteEditController'
        })
        .when('/project/:projectId/note/:noteId/remove', {
            templateUrl: 'build/views/project-note/remove.html',
            controller: 'ProjectNoteRemoveController'
        })
        .when('/project/:projectId/tasks', {
            templateUrl: 'build/views/project-task/list.html',
            controller: 'ProjectTaskListController'
        })
        .when('/project/:projectId/task/:taskId/show', {
            templateUrl: 'build/views/project-task/show.html',
            controller: 'ProjectTaskShowController'
        })
        .when('/project/:projectId/task/new', {
            templateUrl: 'build/views/project-task/new.html',
            controller: 'ProjectTaskNewController'
        })
        .when('/project/:projectId/task/:taskId/edit', {
            templateUrl: 'build/views/project-task/edit.html',
            controller: 'ProjectTaskEditController'
        })
        .when('/project/:projectId/task/:taskId/remove', {
            templateUrl: 'build/views/project-task/remove.html',
            controller: 'ProjectTaskRemoveController'
        })
        .when('/projects', {
            templateUrl: 'build/views/project/list.html',
            controller: 'ProjectListController'
        })
        .when('/project/new', {
            templateUrl: 'build/views/project/new.html',
            controller: 'ProjectNewController'
        })
        .when('/project/:projectId/edit', {
            templateUrl: 'build/views/project/edit.html',
            controller: 'ProjectEditController'
        })
        .when('/project/:projectId/remove', {
            templateUrl: 'build/views/project/remove.html',
            controller: 'ProjectRemoveController'
        })
        .when('/project/:projectId/files', {
            templateUrl: 'build/views/project-file/list.html',
            controller: 'ProjectFileListController'
        })
        .when('/project/:projectId/file/new', {
            templateUrl: 'build/views/project-file/new.html',
            controller: 'ProjectFileNewController'
        })
        .when('/project/:projectId/file/:fileId/edit', {
            templateUrl: 'build/views/project-file/edit.html',
            controller: 'ProjectFileEditController'
        })
        .when('/project/:projectId/file/:fileId/remove', {
            templateUrl: 'build/views/project-file/remove.html',
            controller: 'ProjectFileRemoveController'
        });


    OAuthProvider.configure({
        baseUrl: appConfigProvider.config.baseUrl,
        clientId: 'appPrime01',
        clientSecret: 'prime#prime', // optional
        grantPath: 'oauth/access_token'
    });

    OAuthTokenProvider.configure({
        'name': 'token',
        'options': {
            'secure': false
        }
    });

}])

app.run(['$rootScope', '$window', 'OAuth', function ($rootScope, $window, OAuth) {
    $rootScope.$on('oauth:error', function (event, rejection) {
        // Ignore `invalid_grant` error - should be catched on `LoginController`.
        if ('invalid_grant' === rejection.data.error) {
            return;
        }

        // Refresh token when a `invalid_token` error occurs.
        if ('invalid_token' === rejection.data.error) {
            return OAuth.getRefreshToken();
        }

        // Redirect to `/login` with the `error_reason`.
        return $window.location.href = '/login?error_reason=' + rejection.data.error;
    });
}]);