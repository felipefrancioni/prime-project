angular.module('app.directives').directive('projectFileDownloads', ['$timeout', 'ProjectFile', 'appConfig',
    function ($timeout, ProjectFile, appConfig) {
        return {
            restrict: 'E',
            templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
            link: function (scope, element, attr) {
                scope.$on('salvar-arquivo', function (event, data) {
                    var anchor = element.children()[0];
                    $(anchor).removeClass('disabled');
                    $(anchor).text('Save File');
                    $(anchor).attr({
                        href: 'data:application-octet-stream;base64,' + data.file,
                        download: data.name
                    });

                    $timeout(function () {
                        scope.downloadFile = function () {
                        };
                        $(anchor)[0].click();
                    })
                });
            },
            controller: ['$scope', '$attrs', '$element', function ($scope, $attrs, $element) {
                $scope.downloadFile = function () {
                    var anchor = $element.children()[0];
                    $(anchor).addClass('disabled');
                    $(anchor).text('Loadind...');
                    ProjectFile.download({projectId: $attrs.projectId, fileId: $attrs.fileId}, function (data) {
                        $scope.$emit('salvar-arquivo', data);
                    });
                }
            }]
        };

    }]);
