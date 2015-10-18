angular.module('pleem.frontend')

.controller('ProfileCtrl', ['$scope', '$state', 'User', 'API',
    function($scope, $state, User, API) {
        User.userPromise().then(function(response) {
            $scope.user = response.data;
        });
        $scope.group = API.Group.get({ groupId: 2 });
    }
])