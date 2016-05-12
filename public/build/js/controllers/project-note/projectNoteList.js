angular.module('app.controllers')
    .controller('ProjectNoteListController', ['$scope','$http', '$timeout', '$compile', '$window' ,'$routeParams', 'ProjectNote', function ($scope, $http, $timeout, $compile, $window, $routeParams, ProjectNote) {
        $scope.projectNotes = ProjectNote.query({projectId: $routeParams.projectId});

        $scope.print = function (note) {
            $http.get('/build/views/templates/projectNoteShow.html').then(function(response) {
                console.log(note);
                $scope.note = note;
                var div = $('<div/>');
                div.html($compile(response.data)($scope));
                $timeout(function() {
                    var frame = $window.open('', '_BLANK', 'width=500,height=500');
                    frame.document.open();
                    frame.document.write(div.html());
                    frame.document.close();
                });
            });
        };

    }]);
