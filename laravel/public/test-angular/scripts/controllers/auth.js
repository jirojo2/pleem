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

.controller('SignupCtrl', ['$scope', '$state', 'User',
    function($scope, $state, User) {

        $scope.config = {
            maxTeamMembers: 3
        };

        $scope.members = [];

        $scope.addMember = function(member) {
            $scope.members.push(member);
        }

        $scope.removeMember = function(member) {
            $scope.members.splice(member);
        }
    }
])