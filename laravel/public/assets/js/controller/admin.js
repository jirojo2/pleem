angular.module('ecaApp')
.controller('AdminDashboardController', ['$scope', '$rootScope', '$state', 'User', 'API',
    function($scope, $rootScope, $state, User, API) {
        // TODO
    }
])
.controller('AdminConfigController', ['$scope', '$rootScope', '$state', 'User', 'API',
    function($scope, $rootScope, $state, User, API) {
        $scope.config = API.Config.get();

        $scope.countdown20sec = function() {
            $scope.config.countdown = new Date(Date.now()+20000);
        }
    }
])
