angular.module('app.services').service('ProjectTask', ['$resource', '$filter', 'appConfig',
    function ($resource, $filter, appConfig) {
        return $resource(appConfig.baseUrl + '/project/:projectId/task/:taskId',
            {
                projectId: '@projectId',
                taskId: '@taskId'
            },
            {
                get: {
                    method: 'GET',
                    transformResponse: function (data, headers) {
                        var transformedResponse = appConfig.utils.transformResponse(data, headers);

                        if (angular.isObject(transformedResponse) && transformedResponse.hasOwnProperty('start_date') && transformedResponse.start_date) {
                            var arrayDate = transformedResponse.start_date.split('-');
                            transformedResponse.start_date = new Date(arrayDate[0], parseInt(arrayDate[1]) - 1, arrayDate[2]);
                        }

                        if (angular.isObject(transformedResponse) && transformedResponse.hasOwnProperty('due_date') && transformedResponse.due_date) {
                            var arrayDate = transformedResponse.due_date.split('-');
                            transformedResponse.due_date = new Date(arrayDate[0], parseInt(arrayDate[1]) - 1, arrayDate[2]);
                        }
                        return transformedResponse;
                    }
                },
                save: {
                    method: 'POST'
                },
                update: {
                    method: 'PUT'
                }
            }
        );
    }]);
