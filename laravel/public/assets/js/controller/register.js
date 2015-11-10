angular.module('ecaApp')
.controller ('registerController', ['$scope', '$state', 'User', 'API', function($scope, $state, User, API){

    $scope.config = {
        maxTeamMembers: 3
    };

    $scope.name = '';
    $scope.submitted = false;

    $scope.member1 = {
        first_name: '',
        last_name: '',
        birthdate: '',
        sex:'',
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

    $scope.members = [];

    $scope.addMember = function() {
        $scope.members.push({});
    }

    $scope.removeMember = function(member) {
        $scope.members.splice(member);
    }

    $scope.signup = function() {
        $scope.submitted = true;
        if((!myEl1.hasClass('dimmed'))&&($scope.member2Form.$valid)){
            $scope.members.push($scope.member2)
        }
        if((!myEl2.hasClass('dimmed'))&&($scope.member3Form.$valid)){
            $scope.members.push($scope.member3)
        }
        if (($scope.nameForm.$valid)||($scope.member1Form.$valid)){
            $scope.members.push($scope.member1)
            var group = new API.Group({ name: $scope.name });
            group.members = $scope.members;
            group.$save()
                .then(function ok(response) {
                    $state.go('team');
                }, function err(response) {
                    // TODO: parse validator response
                    console.log(response)
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
