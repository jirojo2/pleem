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
            faculty: '',
            study_level: '',
            years_study: '',
            email: '',
            password: '',
            password_confirmation: '',
            agrees: false
        }

        $scope.submitted = false;

        User.userPromise().then(function(response) {
            $scope.user = response.data;
            if ($scope.user.group)
                API.Group.get({ groupId: $scope.user.group.id }, function(response) {
                    $scope.team = response;
                    $rootScope.teamName = $scope.team.name;
                });
            else
                $rootScope.teamName = '?';
        });

        $scope.addMember = function() {
            $scope.submitted = true;
            if ($scope.member1Form.$valid) {
                $http.post('api/v1/group/'+$scope.user.group.id+'/member', $scope.member1)
                    .then(function(response) {
                        API.Group.get({ groupId: $scope.user.group.id }, function(response){
                            $scope.team = response;
                            $rootScope.teamName = $scope.team.name;
                        });
                        $('#add-user-modal').modal('hide');
                    })
            }
        }

        $scope.saveMember = function(member) {
            $scope.submitted3 = true;
            if ($scope.editMemberForm.$valid) {
                $http.put('api/v1/member/'+member.id, member)
                    .then(function(response) {
                        $('#edit-user-modal').modal('hide');
                    })
                    .catch(function(err) {
                        alert("Error saving member, please contact ECA team for additional support");
                    })
            }
        }

        $scope.edit = function(member) {
            $scope.member = member;
            $scope.submitted3 = false;
            $('#edit-user-modal').modal('show');
        }
    }

])
