mainCtrl = ['$scope', function ($scope) {

    $scope.toggleMenu = function () {
        console.log('toggle');
        $('.overlay').toggle();
        $('.menu').toggle();
    };
}];
app.controller('mainCtrl', mainCtrl);