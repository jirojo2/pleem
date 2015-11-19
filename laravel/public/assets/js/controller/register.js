angular.module('ecaApp')
.controller ('registerController', ['$scope', '$state', '$http', 'User', 'API', function($scope, $state, $http, User, API){

    $scope.config = {
        maxTeamMembers: 3
    };

    $scope.appConfig = API.Config.get();

    $scope.name = '';
    $scope.submitted = false;
    $scope.submitted2 = false;
    $scope.submitted3 = false;
    $scope.countries = [];

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

    $scope.member2 = {
        first_name: '',
        last_name: '',
        birthdate: '',
        sex:'',
        country: '',
        email: '',
        password: '',
        password_confirmation: ''
    }

    $scope.member3 = {
        first_name: '',
        last_name: '',
        birthdate: '',
        sex:'',
        country: '',
        email: '',
        password: '',
        password_confirmation: ''
    }

    $http.get('https://restcountries-v1.p.mashape.com/region/europe', {headers: {
        'X-Mashape-Key': 'yhNwA5NusOmshGvY4U4Q0WBGXQS4p17AkD7jsnzl6zSzE44h5w',
        'Accept': 'application/json'
    }}).then(function(response) {
        $scope.countries = response.data;
    });


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

        if (!$scope.appConfig.registration_enabled) {
            return window.alert('Registration is currently closed!');
        }

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

    // File input

    var fileExtentionRange = '.pdf';
    var MAX_SIZE = 30; // MB

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this);

        if (navigator.appVersion.indexOf("MSIE") != -1) { // IE
            var label = input.val();
            var id = input.attr('id');
            validateFile(id, label, 0);
        } else {
            var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            var size = input.get(0).files[0].size;
            var id = input.attr('id');
            validateFile(id, label, size);
        }
    });

    function validateFile(id, l, s) {
        var postfix = l.substr(l.lastIndexOf('.'));
        if (fileExtentionRange.indexOf(postfix.toLowerCase()) > -1) {
            if (s > 1024 * 1024 * MAX_SIZE ) {
                alert('Max size for file is ' + MAX_SIZE);
                $('#'+id).val('');
                $('._'+id).val('');
            } else {
                $('._'+id).val(l);
            }
        } else {
            alert('File type must be ' + fileExtentionRange);
            $('#'+id).val('');
            $('._'+id).val('');
        }
    }
}])
