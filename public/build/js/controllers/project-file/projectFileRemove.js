angular.module('app.controllers')
    .controller('ProjectFileRemoveController', ['$scope', '$location', '$routeParams', 'ProjectFile', function ($scope, $location, $routeParams, ProjectFile) {
        $scope.projectFile = ProjectFile.get({
            projectId: $routeParams.projectId,
            fileId: $routeParams.fileId
        });

        $scope.remove = function () {
            $scope.projectFile.$delete({
                    projectId: $scope.projectFile.project_id,
                    fileId: $scope.projectFile.id
                }
            ).then(function () {
                $location.path('/project/' + $scope.projectFile.project_id + '/files');
            });
        }
    }]);