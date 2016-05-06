angular.module('app.controllers')
    .controller('ProjectFileNewController', ['$scope', '$location', '$routeParams', 'Url', 'appConfig', 'Upload', function ($scope, $location, $routeParams, Url, appConfig, Upload) {
        $scope.save = function () {
            if ($scope.form.$valid) {
                var url = appConfig.baseUrl + Url.getUrlFromUrlSymbol(appConfig.urls.projectFile, {
                        projectId: $routeParams.projectId,
                        fileId: ''
                    });
                Upload.upload({
                    url: url,
                    fields: {
                        name: $scope.projectFile.name,
                        description: $scope.projectFile.description,
                        project_id: $routeParams.projectId
                    },
                    file: $scope.projectFile.file
                }).success(function (data, status, headers, config) {
                    $location.path('/project/' + $routeParams.projectId + '/files');
                });
            }
        }
    }]);