angular.module('pleem.frontend')

.controller('AuthCtrl', ['$scope', '$state', 'User',
    function($scope, $state, User) {

        $scope.login = function(email, password, remember) {
            User.login(email, password, remember)
                .then(function ok(user) {
                    $state.go('authed.profile');
                }, function err(msg) {
                    $scope.error = msg.data;
                })
        };

        $scope.logout = function() {
            User.logout()
                .then(function ok() {
                    $state.go('signin');
                }, function err(msg) {
                    throw msg;
                })
        }
    }
])