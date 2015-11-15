angular.module('ecaApp')
.controller ('loginController', ['$scope', '$rootScope', '$state', 'User',
	function($scope, $rootScope, $state, User){

	$scope.submitted = false;

	$scope.login = function() {
		$scope.submitted = true;
		if ($scope.loginForm.$valid){
	        User.login($scope.email, $scope.password, true)
	            .then(function ok(user) {
					$rootScope.loggedin = true;
	                $state.go('authed.team');
	            }, function err(msg) {
	                $scope.error = msg.data;
	            })
		}
    };

}])
