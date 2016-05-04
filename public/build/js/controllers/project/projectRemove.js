angular.module('app.controllers')
    .controller('ProjectRemoveController', ['$scope', '$location', '$routeParams', 'Project', function ($scope, $location, $routeParams, Project) {
        $scope.project = Project.get({
            projectId: $routeParams.projectId
        });

        $scope.remove = function () {
            $scope.project.$delete({
                    projectId: $scope.project.id
                }
            ).then(function () {
                $location.path('/projects');
            });
        }
    }]);