angular.module('ecaApp')
.controller ('loginController', ['$scope', '$rootScope', '$state', 'User',
	function($scope, $rootScope, $state, User){

	$scope.submitted = false;

	$scope.loginOnEnter = function(keyEvent) {
		if (keyEvent.which === 13)
			$scope.login();
	}

	$scope.login = function() {
		$scope.submitted = true;
		if ($scope.loginForm.$valid){
	        User.login($scope.email, $scope.password, true)
	            .then(function ok(user) {
					$rootScope.loggedin = true;
					$rootScope.group = user.group.id;
	                $state.go('authed.team');
	            }, function err(msg) {
	                $scope.error = msg.data.email;
	            })
		}
    };

}])
