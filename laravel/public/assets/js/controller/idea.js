angular.module('ecaApp')
.controller('ideaController', ['$scope', '$rootScope', '$state', 'User', 'API',
    function($scope, $rootScope, $state, User, API) {
        $scope.loading = true;
        $scope.editingIdea = false;
        $scope.creatingIdea = true;
        $scope.idea = API.Idea.get();

        $scope.idea.$promise.then(function(idea) {
            if (!idea) {
                $scope.creatingIdea = true;
                $scope.idea = new API.Idea();
            }
            $scope.loading = false;
        });

        $scope.editIdea = function() {
            $scope.editingIdea = true;
        }

        $scope.submitIdea = function() {
            $scope.loading = true;
            $scope.error = null;
            if ($scope.ideaForm.$valid){
                if ($scope.editingIdea) {
                    $scope.idea.$update()
                        .then(function ok(response) {
                            $scope.loading = false;
                            $scope.editingIdea = false;
                        }, function err(response) {
                            $scope.error = "Error saving the idea";
                        });
                } else {
                    $scope.idea.$save()
                        .then(function ok(response) {
                            $scope.loading = false;
                            $scope.creatingIdea = false;
                        }, function err(response) {
                            $scope.error = "Error saving the idea";
                        });
                }
            }
        }
    }
])
