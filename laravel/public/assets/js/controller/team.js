angular.module('ecaApp')
.controller('teamController', ['$scope', '$rootScope', '$state', 'User', 'API',
    function($scope, $rootScope, $state, User, API) {
        User.userPromise().then(function(response) {
            $scope.user = response.data;
            API.Group.get({ groupId: $scope.user.group.id }, function(response){
                $scope.team = response;
                $rootScope.teamName = $scope.team.name;
            });
        });
    }
])
