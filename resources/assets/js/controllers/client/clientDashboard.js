angular.module('app.controllers')
    .controller('ClientDashboardController', ['$scope', 'Client', function ($scope, Client) {

        $scope.clientData = {};

        Client.query({
            orderBy: 'created_at',
            sortedBy: 'desc',
            limit: 8
        }, function (response) {
            $scope.clients = response.data;
        });

        $scope.showClient = function (client) {
            $scope.clientData = client;
        };

    }]);
