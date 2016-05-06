angular.module('app.controllers')
    .controller('ProjectTaskRemoveController', ['$scope', '$location', '$routeParams', 'ProjectTask', function ($scope, $location, $routeParams, ProjectTask) {
        $scope.projectTask = ProjectTask.get({
            projectId: $routeParams.projectId,
            taskId: $routeParams.taskId
        });

        $scope.remove = function () {
            $scope.projectTask.$delete({
                    projectId: $scope.projectTask.project_id,
                    taskId: $scope.projectTask.id
                }
            ).then(function () {
                $location.path('/project/' + $routeParams.projectId + '/tasks');
            });
        }
    }]);