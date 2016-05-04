angular.module('app.controllers')
    .controller('ProjectEditController', [
        '$scope', '$location', 'Project', 'Client', 'appConfig', '$cookies', '$routeParams',
        function ($scope, $location, Project, Client, appConfig, $cookies, $routeParams) {
            Project.get({projectId: $routeParams.projectId}, function (data) {
                $scope.project = data;
                $scope.clientSelected = data.client;
            });
            $scope.status = appConfig.project.status;

            $scope.due_date = {
                status: {
                    opened: false
                }
            };

            $scope.open = function ($event) {
                $scope.due_date.status.opened = true;
            };


            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.project.owner_id = $cookies.getObject('user').id
                    Project.update({projectId: $routeParams.projectId}, $scope.project, function () {
                        $location.path('/projects');
                    });
                }
            };

            $scope.formatName = function (model) {
                if (model) {
                    return model.name;
                }
                return '';
            };

            $scope.getClients = function (name) {
                return Client.query({
                    search: name,
                    searchFields: 'name:like'
                }).$promise;
            };

            $scope.selectClient = function (item) {
                $scope.project.client_id = item.id;
            };

        }]);