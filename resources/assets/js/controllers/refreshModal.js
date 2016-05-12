angular.module('app.controllers')
    .controller('RefreshModalController', [
        '$rootScope',
        '$scope',
        '$location',
        'OAuth',
        'OAuthToken',
        '$modalInstance',
        'authService',
        '$interval',
        function ($rootScope, $scope, $location, OAuth, OAuthToken, $modalInstance, authService, $interval) {

            $scope.$on('event:auth-loginConfirmed', function () {
                $rootScope.loginModalOpened = false;
                $modalInstance.close();
            });

            $scope.$on('$routeChangeStart', function () {
                $rootScope.loginModalOpened = false;
                $modalInstance.dismiss('cancel');
            });

            $scope.$on('event:auth-loginCancelled', function () {
                OAuthToken.removeToken();
            });


            OAuth.getRefreshToken().then(function () {
                $interval(function () {
                    authService.loginConfirmed();
                }, 3000);
            }, function (data) {
                $scope.cancel();
            });


            $scope.cancel = function () {
                authService.loginCancelled();
                $location.path('login');
            };


        }]);
