summaryCtrl = ['$scope', function ($scope) {

    $scope.longMsg = false;

    $scope.toggleSummaryMsg = function () {
        $scope.longMsg = !$scope.longMsg;
    }
}];
app.controller('summaryCtrl', summaryCtrl);