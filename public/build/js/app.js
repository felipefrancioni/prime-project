var app = angular.module('app', [
    'ngRoute',
    'app.controllers',
    'angular-oauth2',
    'app.services',
    'app.filters',
    'app.directives',
    'ui.bootstrap.typeahead',
    'ui.bootstrap.tpls',
    'ui.bootstrap.modal',
    'ui.bootstrap.datepicker',
    'ngFileUpload',
    'http-auth-interceptor',
    'angularUtils.directives.dirPagination',
    'ui.bootstrap.dropdown',
    'pusher-angular',
    'ui-notification'
]);

angular.module('app.controllers', ['ngMessages', 'angular-oauth2']);
angular.module('app.directives', []);
angular.module('app.filters', []);
angular.module('app.services', ['ngResource']);


app.provider('appConfig', function () {
    var config = {
        baseUrl: 'http://localhost:8000',
        pusherKey: 'c7eb71dfa12343fa4f42',
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
                    if (dataJson.hasOwnProperty('data') && Object.keys(dataJson).length == 1) {
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
    $httpProvider.interceptors.splice(0, 1);
    $httpProvider.interceptors.splice(0, 1);
    $httpProvider.interceptors.push('oauthFixInterceptor');
    $routeProvider
        .when('/login', {
            templateUrl: 'build/views/login.html',
            controller: 'LoginController'
        })
        .when('/logout', {
            resolve: {
                logout: ['$location', 'OAuthToken', function ($location, OAuthToken) {
                    OAuthToken.removeToken();
                    return $location.path('login');
                }]
            }
        })
        .when('/home', {
            templateUrl: 'build/views/home.html',
            controller: 'HomeController',
            title: 'Projetos'
        })
        .when('/clients', {
            templateUrl: 'build/views/client/list.html',
            controller: 'ClientListController',
            title: 'Clients'
        })
        .when('/clients/dashboard', {
            templateUrl: 'build/views/client/dashboard.html',
            controller: 'ClientDashboardController',
            title: 'Clients'
        })
        .when('/client/new', {
            templateUrl: 'build/views/client/new.html',
            controller: 'ClientNewController',
            title: 'Clients'
        })
        .when('/client/:id/edit', {
            templateUrl: 'build/views/client/edit.html',
            controller: 'ClientEditController',
            title: 'Clients'
        })
        .when('/client/:id/remove', {
            templateUrl: 'build/views/client/remove.html',
            controller: 'ClientRemoveController',
            title: 'Clients'
        })
        .when('/projects/dashboard', {
            templateUrl: 'build/views/project/dashboard.html',
            controller: 'ProjectDashboardController',
            title: 'Projects'
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
        .when('/project/:projectId/members', {
            templateUrl: 'build/views/project-member/list.html',
            controller: 'ProjectMemberListController'
        })
        .when('/project/:projectId/member/:memberId/show', {
            templateUrl: 'build/views/project-member/show.html',
            controller: 'ProjectMemberShowController'
        })
        .when('/project/:projectId/member/new', {
            templateUrl: 'build/views/project-member/new.html',
            controller: 'ProjectMemberNewController'
        })
        .when('/project/:projectId/member/:memberId/edit', {
            templateUrl: 'build/views/project-member/edit.html',
            controller: 'ProjectMemberEditController'
        })
        .when('/project/:projectId/member/:memberId/remove', {
            templateUrl: 'build/views/project-member/remove.html',
            controller: 'ProjectMemberRemoveController'
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

app.run(['$rootScope', '$location', '$http', 'OAuth', '$modal', 'httpBuffer', '$pusher', '$cookies', 'appConfig', 'Notification',
    function ($rootScope, $location, $http, OAuth, $modal, httpBuffer, $pusher, $cookies, appConfig, Notification) {

        $rootScope.$on('pusher-build', function (event, data) {
            if (data.next.$$route.originalPath != '/login') {
                if (OAuth.isAuthenticated()) {
                    if (!window.client) {
                        window.client = new Pusher(appConfig.pusherKey);
                        var pusher = $pusher(window.client);
                        var channel = pusher.subscribe('user.' + $cookies.getObject('user').id);
                        channel.bind('SdcProject\\Events\\TaskWasIncluded',
                            function (data) {
                                var name = data.task.name
                                Notification.success('Tarefa ' + name + ' foi incluida!');
                            }
                        );
                    }
                }
            }
        });

        $rootScope.$on('pusher-destroy', function (event, data) {
            if (data.next.$$route.originalPath == '/login') {
                if (window.client) {
                    window.client.disconnect();
                    window.client = null;
                }
            }
        });

        $rootScope.$on('$routeChangeStart', function (event, next, current) {
            if (next.$$route.originalPath != '/login') {
                if (!OAuth.isAuthenticated()) {
                    $location.path('login');
                }
            }
            $rootScope.$emit('pusher-build', {next: next});
            $rootScope.$emit('pusher-destroy', {next: next});

        });

        $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
            $rootScope.pageTitle = current.$$route.title;
        });

        $rootScope.$on('oauth:error', function (event, data) {
            // Ignore `invalid_grant` error - should be catched on `LoginController`.
            if ('invalid_grant' === data.rejection.data.error) {
                return;
            }

            // Refresh token when a `invalid_token` error occurs.
            if ('access_denied' === data.rejection.data.error) {
                httpBuffer.append(data.rejection.config, data.deferred);
                if (!$rootScope.loginModalOpened) {
                    var modalInstance = $modal.open({
                        templateUrl: 'build/views/templates/refreshModal.html',
                        controller: 'RefreshModalController'
                    });
                    $rootScope.loginModalOpened = true;
                }
                return;
            }

            // Redirect to `/login` with the `error_reason`.
            return $location.path('login');
        });
    }]);