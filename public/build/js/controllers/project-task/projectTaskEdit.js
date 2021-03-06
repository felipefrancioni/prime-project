angular.module('app.controllers')
    .controller('ProjectTaskEditController', ['$scope', '$location', '$routeParams', 'ProjectTask', 'appConfig', function ($scope, $location, $routeParams, ProjectTask, appConfig) {
        $scope.projectTask = ProjectTask.get({
            projectId: $routeParams.projectId,
            taskId: $routeParams.taskId
        });

        $scope.status = appConfig.projectTask.status;

        $scope.start_date = {
            status: {
                opened: false
            }
        };

        $scope.due_date = {
            status: {
                opened: false
            }
        };

        $scope.openStartDatePicker = function($event) {
            $scope.start_date.status.opened = true;
        };

        $scope.openDueDatePicker = function($event) {
            $scope.due_date.status.opened = true;
        };

        $scope.save = function () {
            if ($scope.form.$valid) {
                console.log($scope.projectTask);
                ProjectTask.update({
                    projectId: $scope.projectTask.project_id,
                    taskId: $scope.projectTask.id
                }, $scope.projectTask, function () {
                    $location.path('/project/' + $routeParams.projectId + '/tasks');
                });
            }
        }
    }]);