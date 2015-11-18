angular.module('ecaApp', [
    'ui.router',
	'ngResource'
])
.config(['$stateProvider', '$urlRouterProvider', '$httpProvider',
    function($stateProvider, $urlRouterProvider,$httpProvider) {

        // use this uncommon header to make Laravel happy
        $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"

        // fallback to auth.signin
        $urlRouterProvider.otherwise('/');

        // utils
        var requireAuth = ['$stateParams', '$state', 'User',
            function($stateParams, $state, User) {
                User.checkAuth().then(
                    function authed() {
                        // ok!
                    },
                    function notAuthed() {
                        //return to signin page
                        $state.go('login');
                    }
                )
            }
        ];

        var requireNoAuth = ['$stateParams', '$state', 'User',
            function($stateParams, $state, User) {
                User.checkAuth().then(
                    function authed() {
                        //return to profile page
                        //$state.go('authed.team');
                    },
                    function notAuthed() {
                        // ok!
                    }
                )
            }
        ];

        var requireAdmin = ['$stateParams', '$state', 'User',
            function($stateParams, $state, User) {
                User.checkAuth().then(
                    function authed() {
                        if (!User.user().admin) {
                            //return to home page
                            $state.go('home');
                        }
                        else {
                            // ok!
                        }
                    },
                    function notAuthed() {
                        //return to signin page
                        $state.go('login');
                    }
                )
            }
        ];

        // router
        $stateProvider
			.state('home', {
				url: '/',
				templateUrl: 'templates/home.html',
				onEnter: requireNoAuth
			})
            .state('login', {
                url: '/login',
                templateUrl: 'templates/login.html',
                onEnter: requireNoAuth
            })
            .state('register', {
                url: '/register',
                templateUrl: 'templates/register.html',
                onEnter: requireNoAuth
            })
            .state('authed', {
                abstract: true,
                templateUrl: 'templates/authed.layout.html',
                onEnter: requireAuth
            })
            .state('authed.team', {
                url: '/team',
                templateUrl: 'templates/team.html',
				onEnter: requireAuth
            })
            .state('authed.idea', {
                url: '/idea',
                templateUrl: 'templates/idea.html',
				onEnter: requireAuth
            })
            .state('admin', {
                abstract: true,
                templateUrl: 'templates/admin.layout.html',
                onEnter: requireAdmin
            })
            .state('admin.config', {
                url: '/admin/config',
                templateUrl: 'templates/admin.config.html',
                onEnter: requireAdmin
            })
            .state('admin.dashboard', {
                url: '/admin',
                templateUrl: 'templates/admin.dashboard.html',
                onEnter: requireAdmin
            });
    }
])
