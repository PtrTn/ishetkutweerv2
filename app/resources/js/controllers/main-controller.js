mainCtrl = ['$scope', function ($scope) {

    $scope.toggleMenu = function () {
        $('.overlay').toggle();
        $('.menu').toggle();
    };

}];
app.controller('mainCtrl', mainCtrl);