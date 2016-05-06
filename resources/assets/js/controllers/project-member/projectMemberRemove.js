angular.module('app.controllers')
    .controller('ProjectMemberRemoveController', ['$scope', '$location', '$routeParams', 'ProjectMember', function ($scope, $location, $routeParams, ProjectMember) {
        $scope.projectMember = ProjectMember.get({
            projectId: $routeParams.projectId,
            memberId: $routeParams.memberId
        });

        $scope.remove = function () {
            $scope.projectMember.$delete({
                    projectId: $scope.projectMember.project_id,
                    memberId: $scope.projectMember.user.user_id
                }
            ).then(function () {
                $location.path('/project/' + $routeParams.projectId + '/members');
            });
        }
    }]);