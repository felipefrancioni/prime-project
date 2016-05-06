angular.module('app.controllers')
    .controller('ProjectMemberListController', ['$scope', '$routeParams', 'ProjectMember', 'appConfig', function ($scope, $routeParams, ProjectMember, appConfig) {
        $scope.projectMember = new ProjectMember();

        $scope.save = function() {
            if ($scope.form.$valid) {
                $scope.projectMember.$save({projectId: $routeParams.projectId}).then(function () {
                    $scope.projectMember = new ProjectMember();
                    $scope.loadTask();
                });
            }
        };

        $scope.loadTask = function() {
            $scope.projectMembers = ProjectMember.query({
                projectId: $routeParams.projectId,
                orderBy: 'project_id',
                sortedBy: 'desc'
            });
        };

        $scope.loadTask();
    }]);
