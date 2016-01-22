forecastCtrl = ['$scope', function ($scope) {

    $scope.more = false;
    $scope.longMsg = false;

    $scope.toggleMore = function () {
        $scope.more = !$scope.more;
    };

    $scope.toggleSummaryMsg = function () {
        $scope.longMsg = !$scope.longMsg;
    };
}];
app.controller('forecastCtrl', forecastCtrl);