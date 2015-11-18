angular.module('ecaApp')
.controller ('registerController', ['$scope', '$state', 'User', 'API', function($scope, $state, User, API){

    $scope.config = {
        maxTeamMembers: 3
    };

    $scope.name = '';
    $scope.submitted = false;
    $scope.submitted2 = false;
    $scope.submitted3 = false;

    $scope.member1 = {
        first_name: '',
        last_name: '',
        birthdate: '',
        sex: '',
        cv: '',
        email: '',
        password: '',
        password_confirmation: ''
    }

    $scope.member2 = {
        first_name: '',
        last_name: '',
        birthdate: '',
        sex:'',
        email: '',
        password: '',
        password_confirmation: ''
    }

    $scope.member3 = {
        first_name: '',
        last_name: '',
        birthdate: '',
        sex:'',
        email: '',
        password: '',
        password_confirmation: ''
    }

    var myEl1 = angular.element( document.querySelector( '.member2' ) );
    var myEl2 = angular.element( document.querySelector( '.member3' ) );

    $scope.addMember = function() {
        $scope.members.push({});
    }

    $scope.checkDirty = function() {
        console.log('Changed');
    }

    $scope.removeMember = function(member) {
        $scope.members.splice(member);
    }

    $scope.signup = function() {
        $scope.members = [];
        $scope.error = "";
        $scope.submitted = true;
        if(!myEl1.hasClass('dimmed')) {
            if ($scope.member2Form.$valid){
                $scope.members.push($scope.member2)
            } else {
                $scope.submitted2 = true;
            }
        }
        if(!myEl2.hasClass('dimmed')) {
            if ($scope.member3Form.$valid){
                $scope.members.push($scope.member3)
            } else {
                $scope.submitted3 = true;
            }
        }
        if (($scope.nameForm.$valid)||($scope.member1Form.$valid)){
            $scope.members.push($scope.member1)
            var group = new API.Group({ name: $scope.name });
            group.members = $scope.members;
            group.$save()
                .then(function ok(response) {
                    $state.go('authed.team');
                }, function err(response) {
                    if (response.data['name']){
                        $scope.error = response.data['name'][0];
                    }
                    if (response.data['members.0.password']){
                        $scope.error = response.data['members.0.password'][0];
                    }
                    if (response.data['members.1.password']){
                        $scope.error = response.data['members.1.password'][0];
                    }
                    if (response.data['members.2.password']){
                        $scope.error = response.data['members.2.password'][0];
                    }
                });
        }
    }

    $('.circular.icon.button').on('click', function() {
        $(this).parents('.segment').dimmer('hide');
    });

    $('.bottom.buttons > .button').on('click', function() {
        $(this).parents('.segment').dimmer('show');
    });
}])
