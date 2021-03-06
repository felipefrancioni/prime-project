angular.module('app.controllers')
    .controller('ProjectNoteEditController', ['$scope', '$location', '$routeParams', 'ProjectNote', function ($scope, $location, $routeParams, ProjectNote) {
        $scope.projectNote = ProjectNote.get({
            projectId: $routeParams.projectId,
            noteId: $routeParams.noteId
        });

        $scope.save = function () {
            if ($scope.form.$valid) {
                ProjectNote.update({
                    projectId: $scope.projectNote.project_id,
                    noteId: $scope.projectNote.id
                }, $scope.projectNote, function () {
                    $location.path('/project/' + $routeParams.projectId + '/notes');
                });
            }
        }
    }]);