angular.module('app.controllers')
    .controller('ProjectFileListController', ['$scope', '$routeParams', 'ProjectFile', function ($scope, $routeParams, ProjectFile) {
        $scope.projectFiles = ProjectFile.query({projectId: $routeParams.projectId});
    }]);
