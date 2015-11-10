angular.module('ecaApp')
.controller ('headerController', ['$scope', '$rootScope', '$state', '$location', '$anchorScroll', 'User', 'API',
function($scope, $rootScope, $state, $location, $anchorScroll, User, API){

    $rootScope.loggedin = false;

    User.userPromise().then(function(response) {
        $scope.user = response.data;
        if ($scope.user.id) {
            $rootScope.loggedin = true;
        }
    });

    $scope.logout = function() {
        User.logout()
                .then(function ok() {
                    $rootScope.loggedin = false;
                    $state.go('login');
                }, function err(msg) {
                    throw msg;
                })
    }

    $scope.scrollTo = function(id) {
		$location.hash(id);
     	$anchorScroll();
	}
}])
