angular.module('ecaApp')
.factory('API', ['$q', '$resource', '$http',
    function($q, $resource, $http) {
        return {
            Group: $resource('/api/v1/group/:groupId',
                {
                    'groupId': '@id'
                },
                {
                    'get':    { method:'GET' },
                    'save':   { method:'POST' },
                    'query':  { method:'GET', isArray:true },
                    'remove': { method:'DELETE' },
                    'delete': { method:'DELETE' }
                }
            ),
            Config: $resource('/api/v1/config',
                {
                },
                {
                    'get':  { method:'GET' },
                    'save': { method:'POST'}
                }
            ),
            Idea: $resource('/api/v1/idea/:ideaId',
                {
                    'ideaId': '@id'
                },
                {
                    'get':    { method:'GET' },
                    'save':   { method:'POST' },
                    'update': { method:'PUT' }
                }
            )
        }
    }
])
