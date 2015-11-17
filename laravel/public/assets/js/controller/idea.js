angular.module('ecaApp')
.controller('ideaController', ['$scope', '$rootScope', '$state', 'User', 'API',
    function($scope, $rootScope, $state, User, API) {
        $scope.submitted = false;
        $scope.idea = '';
        $scope.ideadescription = '';

        $scope.submitIdea = function() {
            $scope.submitted = true;

            if ($scope.ideaForm.$valid){
                //do stuff here
            }
        }
    }
])
