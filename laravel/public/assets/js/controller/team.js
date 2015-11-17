angular.module('ecaApp')
.controller('teamController', ['$scope', '$rootScope', '$state', 'User', 'API',
    function($scope, $rootScope, $state, User, API) {
        User.userPromise().then(function(response) {
            $scope.user = response.data;
            API.Group.get({ groupId: $scope.user.groups[0].id }, function(response){
                $scope.team = response;
                console.log($scope.team);
                $rootScope.teamName = $scope.team.name;
            });
        });
    }
])
