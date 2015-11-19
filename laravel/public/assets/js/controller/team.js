angular.module('ecaApp')
.controller('teamController', ['$scope', '$rootScope', '$http', '$state', 'User', 'API',
    function($scope, $rootScope, $http, $state, User, API) {
        $http.get('https://restcountries-v1.p.mashape.com/region/europe', {headers: {
            'X-Mashape-Key': 'yhNwA5NusOmshGvY4U4Q0WBGXQS4p17AkD7jsnzl6zSzE44h5w',
            'Accept': 'application/json'
        }}).then(function(response) {
            $scope.countries = response.data;
        });

        $scope.member1 = {
            first_name: '',
            last_name: '',
            birthdate: '',
            sex:'',
            country: '',
            email: '',
            password: '',
            password_confirmation: ''
        }

        User.userPromise().then(function(response) {
            $scope.user = response.data;
            API.Group.get({ groupId: $scope.user.group.id }, function(response){
                $scope.team = response;
                $rootScope.teamName = $scope.team.name;
            });
        });

        $scope.addMember = function() {

            if ($scope.member1Form.$valid) {
                $http.post('/group/'+$scope.user.group.id+'/member/', $scope.member1)
                    .then(function(response) {
                        API.Group.get({ groupId: $scope.user.group.id }, function(response){
                            $scope.team = response;
                            $rootScope.teamName = $scope.team.name;
                        });
                        $('#add-user-modal').modal('hide');
                    })
            }
        }
    }

])
