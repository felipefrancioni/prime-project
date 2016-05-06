angular.module('app.controllers')
    .controller('ProjectNoteRemoveController', ['$scope', '$location', '$routeParams', 'ProjectNote', function ($scope, $location, $routeParams, ProjectNote) {
        $scope.projectNote = ProjectNote.get({
            projectId: $routeParams.projectId,
            noteId: $routeParams.noteId
        });

        $scope.remove = function () {
            $scope.projectNote.$delete({
                    projectId: $scope.projectNote.project_id,
                    noteId: $scope.projectNote.id
                }
            ).then(function () {
                $location.path('/project/' + $routeParams.projectId + '/notes');
            });
        }
    }]);