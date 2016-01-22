forecastCtrl = ['$scope', function ($scope) {

    $scope.toggleMore = function () {
        $('.forecast .extra').fadeToggle();
        $scope.toggleIcon($('.forecast .more i'));
        $scope.toggleText($('.forecast .more span'));
        return false;
    };

    $scope.toggleSummaryMsg = function () {
        $('.text-summary .short-msg').slideToggle();
        $('.text-summary .long-msg').slideToggle();
        $scope.toggleText($('.text-summary .more span'));
        $scope.toggleIcon($('.text-summary .more i'));
        return false;
    };

    $scope.toggleIcon = function (element) {
        element.toggleClass('fa-angle-right');
        element.toggleClass('fa-angle-up');
    };

    $scope.toggleText = function (element) {
        var text = element.text();
        element.text(text == "Meer" ? "Minder" : "Meer");
    };
}];
app.controller('forecastCtrl', forecastCtrl);