forecastCtrl = ['$scope', function ($scope) {

    $scope.more = false;

    $scope.toggleMore = function () {
        $scope.more = !$scope.more;
    }
}];
app.controller('forecastCtrl', forecastCtrl);