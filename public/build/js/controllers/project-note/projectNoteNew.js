angular.module('app.controllers')
    .controller('ProjectNoteNewController', ['$scope', '$location', '$routeParams', 'ProjectNote', function ($scope, $location, $routeParams, ProjectNote) {
        $scope.projectNote = new ProjectNote();
        $scope.projectNote.project_id = $routeParams.projectId;
        $scope.save = function () {
            if ($scope.form.$valid) {
                $scope.projectNote.$save({projectId: $routeParams.projectId}).then(function () {
                    $location.path('/project/' + $routeParams.projectId + '/notes');
                });
            }
        }
    }]);