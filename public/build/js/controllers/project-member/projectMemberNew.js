angular.module('app.controllers')
    .controller('ProjectTaskNewController', ['$scope', '$location', '$routeParams', 'ProjectTask', 'appConfig', function ($scope, $location, $routeParams, ProjectTask, appConfig) {
        $scope.projectTask = new ProjectTask();

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
                ProjectTask.save({
                    projectId: $routeParams.projectId
                }, $scope.projectTask, function () {
                    $location.path('/project/' + $routeParams.projectId + '/tasks');
                });
            }
        }
    }]);