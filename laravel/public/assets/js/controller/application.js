angular.module('ecaApp')
.controller('applicationController', ['$scope', '$rootScope', '$state', 'User', 'API',
    function($scope, $rootScope, $state, User, API) {
        $scope.loading = true;
        $scope.creatingApplication = true;
        $scope.application = {
            name: "",
            description: "",
        };


        $scope.submitApp = function() {
            $scope.loading = true;
            $scope.error = null;
            if ($scope.applicationForm.$valid){
                //do stuff
            }
        }
    }
])
