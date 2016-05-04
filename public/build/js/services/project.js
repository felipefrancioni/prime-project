angular.module('app.services').service('Project', ['$resource', 'appConfig',
    function ($resource, appConfig) {
        return $resource(appConfig.baseUrl + '/project/:projectId', {projectId: '@projectId'},
            {
                update: {
                    method: 'PUT'
                },
                get: {
                    method: 'GET',
                    transformResponse: function (data, headers) {
                        var transformedResponse = appConfig.utils.transformResponse(data, headers);
                        if (angular.isObject(transformedResponse) && transformedResponse.hasOwnProperty('due_date')) {
                            var arrayDate = transformedResponse.due_date.split('-');
                            transformedResponse.due_date = new Date(arrayDate[0], arrayDate[1], arrayDate[2]);
                        }
                        return transformedResponse;
                    }
                }

            }
        );
    }]);
