angular.module('ecaApp')
.factory('API', ['$q', '$resource', '$http',
    function($q, $resource, $http) {
        return {
            Group: $resource('/api/v1/event/:eventId/group/:groupId',
                {
                    'eventId': 1,
                    'groupId': '@id'
                },
                {
                    'get':    { method:'GET' },
                    'save':   { method:'POST' },
                    'query':  { method:'GET', isArray:true },
                    'remove': { method:'DELETE' },
                    'delete': { method:'DELETE' }
                }
            )
        }
    }
])
