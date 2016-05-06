angular.module('app.services').service('ProjectMember', ['$resource', 'appConfig',
    function ($resource, appConfig) {
        return $resource(
            appConfig.baseUrl + '/project/:projectId/member/:memberId',
            {
                projectId: '@projectId',
                memberId: '@memberId'
            },
            {
                update: {
                    method: 'PUT'
                }
            }
        );
    }]);
