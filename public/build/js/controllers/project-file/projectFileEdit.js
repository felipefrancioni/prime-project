angular.module('app.controllers')
    .controller('ProjectFileEditController', ['$scope', '$location', '$routeParams', 'ProjectFile', function ($scope, $location, $routeParams, ProjectFile) {
        $scope.projectFile = ProjectFile.get({
            projectId: null,
            fileId: $routeParams.fileId
        });

        $scope.save = function () {
            if ($scope.form.$valid) {
                ProjectFile.update({
                    projectId: null,
                    fileId: $scope.projectFile.id
                }, $scope.projectFile, function () {
                    $location.path('/projects/' + $scope.projectFile.project_id + '/files');
                });
            }
        }
    }]);