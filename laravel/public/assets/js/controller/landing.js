angular.module('ecaApp')
.controller ('LandingLayoutController', ['$scope', '$rootScope', '$state', '$location', '$anchorScroll', 'User', 'API',
function($scope, $rootScope, $state, $location, $anchorScroll, User, API){

    $rootScope.loggedin = false;

    User.userPromise().then(function(response) {
        $scope.user = response.data;
        if ($scope.user.id) {
            $rootScope.loggedin = true;
        }

        if($scope.user.admin == 1) {
            // Enable Content Tools
        	var editor = ContentTools.EditorApp.get();
        	editor.init('*[data-editable]', 'data-name');
            // Listen for save events
        	editor.bind('save', function (regions, calledBy) {
        		var name, onStateChange, payload, xhr;

        		// Set the editor as busy while we save our changes
        		if (calledBy !== 'autoSave') {
        			this.busy(true);
        		}

        		// Collect the contents of each region into a FormData instance
        		payload = new FormData();
        		payload.append('__page__', 'home.html');
        		for (name in regions) {
        			payload.append(name, regions[name]);
        		}

        		// Send the update content to the server to be saved
        		onStateChange = function(ev) {
        			// Check if the request is finished
        			if (ev.target.readyState == 4) {
        				editor.busy(false);
        				if (ev.target.status == '200') {
        					// Save was successful, notify the user with a flash
        					if (calledBy !== 'autoSave') {
        						new ContentTools.FlashUI('ok');
        					}
        				} else {
        					// Save failed, notify the user with a flash
        					new ContentTools.FlashUI('no');
        				}
        			}
        		};

        		xhr = new XMLHttpRequest();
        		xhr.addEventListener('readystatechange', onStateChange);
        		xhr.open('POST', '/x/save-page');
        		xhr.setRequestHeader('X-CSRF-TOKEN', getCookie('XSRF-TOKEN'));
        		xhr.send(payload);
        	});
        }
    });

    $scope.logout = function() {
        User.logout()
                .then(function ok() {
                    $rootScope.loggedin = false;
                    $state.go('login');
                }, function err(msg) {
                    throw msg;
                })
    }

    $scope.scrollTo = function(id) {
        if ($state.current.name !== 'home') {
            $state.go('home').then(function() {
                $location.hash(id);
             	$anchorScroll();
            });
        }
		$location.hash(id);
     	$anchorScroll();
	}
}])
