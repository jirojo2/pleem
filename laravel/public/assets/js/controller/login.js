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
					$rootScope.group = user.group.id;
	                $state.go('authed.team');
	            }, function err(msg) {
					console.log(msg.data);
	                $scope.error = msg.data.email;
	            })
		}
    };

}])
