angular.module('ecaApp')
.controller('ideaController', ['$scope', '$rootScope', '$state', 'User', 'API',
    function($scope, $rootScope, $state, User, API) {
        $scope.submitted = false;
        $scope.name = '';
        $scope.description = '';

        User.userPromise().then(function(response) {
            $scope.user = response.data;
            API.Group.get({ groupId: $scope.user.group.id }, function(response){
                $scope.idea = response.idea;
            });
        });

        $scope.submitIdea = function() {
            $scope.submitted = true;

            if ($scope.ideaForm.$valid){
                var newIdea = new API.Idea({ name: $scope.name, description: $scope.description });
                newIdea.$save()
                    .then(function ok(response) {
                        console.log('yay');
                        API.Group.get({ groupId: $scope.user.group.id }, function(response){
                            $scope.idea = response.idea;
                        });
                    }, function err(response) {
                        //do error stuff here
                    });
            }
        }
    }
])
