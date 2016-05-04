angular.module('app.controllers')
    .controller('ProjectFileRemoveController', ['$scope', '$location', '$routeParams', 'ProjectFile', function ($scope, $location, $routeParams, ProjectFile) {
        $scope.projectFile = ProjectFile.get({
            projectId: null,
            fileId: $routeParams.fileId
        });

        $scope.remove = function () {
            $scope.projectFile.$delete({
                    projectId: null,
                    fileId: $scope.projectFile.id
                }
            ).then(function () {
                $location.path('/projects/' + $scope.projectFile.project_id + '/files');
            });
        }
    }]);