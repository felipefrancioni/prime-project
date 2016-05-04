angular.module('app.services').service('ProjectNote', ['$resource', 'appConfig',
    function ($resource, appConfig) {
        return $resource(
            appConfig.baseUrl + '/project/:projectId/note/:noteId',
            {
                projectId: '@projectId',
                noteId: '@noteId'
            },
            {
                update: {
                    method: 'PUT'
                }
            }
        );
    }]);
