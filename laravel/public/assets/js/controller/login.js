angular.module('ecaApp')
.controller ('loginController', ['$scope', '$state', 'User', function($scope, $state, User){

	$scope.submitted = false;

	$scope.login = function() {
		$scope.submitted = true;
		if ($scope.loginForm.$valid){
	        User.login($scope.email, $scope.password, true)
	            .then(function ok(user) {
	                $state.go('team');
	            }, function err(msg) {
	                $scope.error = msg.data;
	            })
		}
    };
}])
