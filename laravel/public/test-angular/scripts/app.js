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
                        console.log("Authed!");
                    },
                    function notAuthed() {
                        console.log("NOT Authed!");
                        //return to signin page
                        $state.go('signin');
                    }
                )
            }
        ];

        // router
        $stateProvider
            .state('signin', {
                url: '/signin',
                templateUrl: 'views/auth/signin.html',
                controller: 'AuthCtrl'
            })
            .state('signup', {
                url: '/signup',
                templateUrl: 'views/auth/signup.html'
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