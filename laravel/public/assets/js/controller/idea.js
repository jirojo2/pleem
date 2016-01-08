angular.module('ecaApp')
.controller('ideaController', ['$scope', '$rootScope', '$state', 'User', 'API',
    function($scope, $rootScope, $state, User, API) {
        $scope.loading = true;
        $scope.creatingIdea = true;
        $scope.editingIdea = false;
        $scope.idea = {};

        User.userPromise().then(function(response) {
            $scope.user = response.data;
            API.Group.get({ groupId: $scope.user.group.id }, function(response) {
                if (response.idea) {
                    $scope.creatingIdea = false;
                    $scope.idea = response.idea || {};
                }
                $scope.loading = false;
            });
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
