angular.module('ecaApp')
.controller ('headerController', ['$scope', '$state', 'User', 'API', function($scope, $state, User, API){

    $scope.loggedin = false;

    User.userPromise().then(function(response) {
        $scope.user = response.data;
        if ($scope.user.id) {
                $scope.loggedin = true;
        }
    });

    $scope.logout = function() {
        User.logout()
                .then(function ok() {
                    $scope.loggedin = false;
                    $state.go('login');
                }, function err(msg) {
                    throw msg;
                })
    }
}])
