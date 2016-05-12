angular.module('app.controllers')
    .controller('ProjectDashboardController', ['$scope', 'Project', function ($scope, Project) {

        $scope.projectData = {};

        Project.query({
            orderBy: 'created_at',
            sortedBy: 'desc',
            limit: 5
        }, function (response) {
            $scope.projects = response.data;
        });

        $scope.showProject = function (project) {
            $scope.projectData = project;
        };

    }]);
