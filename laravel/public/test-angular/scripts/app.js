angular.module('pleem.frontend', [
    'ui.router',
    'ui.bootstrap',
    'ngResource'
])
.config(['$stateProvider', '$urlRouterProvider', '$httpProvider',
    function($stateProvider, $urlRouterProvider,$httpProvider) {

        // use this uncommon header to make Laravel happy
        $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"

        // fallback to auth.signin
        $urlRouterProvider.otherwise('/signin');

        // utils
        var requireAuth = ['$stateParams', '$state', 'User',
            function($stateParams, $state, User) {
                User.checkAuth().then(
                    function authed() {
                        // ok!
                    },
                    function notAuthed() {
                        //return to signin page
                        $state.go('signin');
                    }
                )
            }
        ];

        var requireNoAuth = ['$stateParams', '$state', 'User',
            function($stateParams, $state, User) {
                User.checkAuth().then(
                    function authed() {
                        //return to profile page
                        $state.go('authed.profile');
                    },
                    function notAuthed() {
                        // ok!
                    }
                )
            }
        ];

        // router
        $stateProvider
            .state('signin', {
                url: '/signin',
                templateUrl: 'views/auth/signin.html',
                controller: 'AuthCtrl',
                onEnter: requireNoAuth
            })
            .state('signup', {
                url: '/signup',
                templateUrl: 'views/auth/signup.html',
                controller: 'SignupCtrl',
                onEnter: requireNoAuth
            })
            .state('authed', {
                abstract: true,
                templateUrl: 'views/authed.layout.html',
                onEnter: requireAuth
            })
            .state('authed.profile', {
                url: '/profile',
                templateUrl: 'views/profile/profile.html',
                controller: 'ProfileCtrl'
            });
    }
])