menuCtrl = ['$scope', '$window', function ($scope, $window) {
    $scope.hasGeo = navigator.geolocation;

    $scope.useLocation = function (position) {
        if (typeof position.coords.latitude !== "undefined" && typeof position.coords.longitude !== "undefined") {
            $window.location.href = '/' + position.coords.latitude + '/' + position.coords.longitude;
        }
    };

    $scope.promptLocation = function ($event) {
        navigator.geolocation.getCurrentPosition($scope.useLocation);
        $event.stopPropagation();
    };
}];
app.controller('menuCtrl', menuCtrl);