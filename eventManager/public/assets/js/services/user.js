angular.module('ecaApp')
.factory('User', ['$q', '$resource', '$http',
    function($q, $resource, $http) {

        var user = null;

        var userPromise = $http.get('/api/v1/auth/user');

        userPromise.then(function(response) {
            if (response.data && !angular.equals({}, response.data)) {
                user = response.data;
            }
        });

        return {
            login: function(email, password, remember) {
                var deferred = $q.defer();
                $http.post('/api/v1/auth/login', {
                    email: email,
                    password: password,
                    remember: remember
                }).then(function ok(response) {
                    userPromise = $q.resolve(response);
                    user = response.data;
                    deferred.resolve(user);
                }, function err(response){
                    deferred.reject(response);
                });
                return deferred.promise;
            },
            logout: function() {
                var deferred = $q.defer();
                if (!user) {
                    deferred.reject('not logged in');
                }
                $http.get('/api/v1/auth/logout')
                    .then(function ok(response) {
                        user = null;
                        userPromise = $q.resolve({ data: {} });
                        deferred.resolve(response);
                    }, function err(response) {
                        deferred.reject(response);
                    });
                return deferred.promise;
            },
            user: function() {
                return user;
            },
            userPromise: function() {
                return userPromise;
            },
            checkAuth: function() {
                var deferred = $q.defer();
                userPromise.then(function(response) {
                    if (response.data && !angular.equals({}, response.data)) {
                        deferred.resolve();
                    }
                    else
                        deferred.reject();
                });
                return deferred.promise;
            }
        }
    }
])
