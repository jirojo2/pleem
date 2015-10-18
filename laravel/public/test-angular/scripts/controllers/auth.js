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

.controller('SignupCtrl', ['$scope', '$state', 'User', 'API',
    function($scope, $state, User, API) {

        $scope.config = {
            maxTeamMembers: 3
        };

        $scope.members = [{}];

        $scope.addMember = function() {
            $scope.members.push({});
        }

        $scope.removeMember = function(member) {
            $scope.members.splice(member);
        }

        $scope.signup = function(name, members) {
            var group = new API.Group({ name: name });
            group.members = members;
            group.$save()
                .then(function ok(response) {
                    $state.go('signin');
                }, function err(response) {
                    // TODO: parse validator response
                    console.log(response)
                });
        }
    }
])