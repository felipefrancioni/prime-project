angular.module('app.controllers')
    .controller('ProjectFileEditController', ['$scope', '$location', '$routeParams', 'ProjectFile', function ($scope, $location, $routeParams, ProjectFile) {
        $scope.projectFile = ProjectFile.get({
            projectId: $routeParams.projectId,
            fileId: $routeParams.fileId
        });

        $scope.save = function () {
            if ($scope.form.$valid) {
                ProjectFile.update({
                    projectId: $scope.projectFile.project_id,
                    fileId: $scope.projectFile.id
                }, $scope.projectFile, function () {
                    $location.path('/project/' + $scope.projectFile.project_id + '/files');
                });
            }
        }
    }]);