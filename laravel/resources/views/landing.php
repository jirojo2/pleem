<!DOCTYPE html>
<html>

    <head>
        <!-- Standard Meta -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Site Properities -->
        <title>ECA 2015-2016</title>

        <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
        <link rel="stylesheet" type="text/css" href="assets/lib/content-tools/content-tools.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/eca.css">
    </head>

    <body ng-app="ecaApp">
        <div class="ui top fixed borderless menu" ng-controller="headerController">
            <div class="ui grid container">
                <div class="ui computer tablet only row">
                    <a ui-sref="home" class="header down item">
                        <img class="ui small fluid image" src="assets/images/logo.png">
                    </a>
                    <div class="right small menu">
                        <a ui-sref="home" class="item">Home</a>
                        <a ng-click="scrollTo('about')" class="item">About</a>
                        <a ng-click="scrollTo('rules')" class="item">Rules</a>
                        <a ng-click="scrollTo('prizes')" class="item">Prizes</a>
                        <a ng-click="scrollTo('people')" class="item">People</a>
                        <a ng-click="scrollTo('contact')" class="item">Contact</a>
                        <div class="item" ng-show="!loggedin">
                            <a ui-sref="login" class="ui green button">
                                <i class="user icon"></i> Log in
                            </a>
                        </div>
                        <div class="ui dropdown item" ng-show="loggedin">
							Account <i class="dropdown icon"></i>
							<div class="menu">
								<a class="item" ui-sref="authed.team">
									<i class="users icon"></i> My Team
								</a>
								<a class="item" ng-click="logout()" ui-sref="login">
									<i class="log out icon"></i> Log out
								</a>
							</div>
						</div>
                    </div>
                </div>
                <div class="ui mobile only row">
                    <a ui-sref="home" class="header item">
                        <img class="ui small fluid image" src="assets/images/logo.png">
                    </a>
                    <div class="right menu open">
                        <div class="item" ng-show="!loggedin">
                            <a ui-sref="login" class="ui green button">
                                <i class="user icon"></i>
                            </a>
                        </div>
                        <div class="ui dropdown item" ng-show="loggedin">
							Account <i class="dropdown icon"></i>
							<div class="menu">
								<a class="item" ui-sref="authed.team">
									<i class="users icon"></i> My Team
								</a>
								<a class="item" ng-click="logout()" ui-sref="login">
									<i class="log out icon"></i> Log out
								</a>
							</div>
						</div>
                        <a class="toggle item">
                            <i class="green sidebar icon"></i>
                        </a>
                    </div>
                    <div class="ui inverted green vertical navbar menu hidden fluid">
                        <a ui-sref="home" class="item">Home</a>
                        <a ng-click="scrollTo('about')" class="item">About</a>
                        <a ng-click="scrollTo('rules')" class="item">Rules</a>
                        <a ng-click="scrollTo('prizes')" class="item">Prizes</a>
                        <a ng-click="scrollTo('people')" class="item">People</a>
                        <a ng-click="scrollTo('contact')" class="item">Contact</a>
                    </div>
                </div>
            </div>
        </div>

        <div ui-view></div>

        <div class="ui green inverted vertical footer bottom segment row">
            <div class="ui center aligned container">
                <div class="ui stackable divided grid">
                    <div class="four wide column">
                        <h4 class="ui invertedheader">Group 1</h4>
                        <div class="ui inverted link list">
                            <a ui-sref="#" class="item">Link One</a>
                            <a ui-sref="#" class="item">Link Two</a>
                            <a ui-sref="#" class="item">Link Three</a>
                            <a ui-sref="#" class="item">Link Four</a>
                        </div>
                    </div>
                    <div class="four wide column">
                        <h4 class="ui inverted header">Group 2</h4>
                        <div class="ui inverted link list">
                            <a ui-sref="#" class="item">Link One</a>
                            <a ui-sref="#" class="item">Link Two</a>
                            <a ui-sref="#" class="item">Link Three</a>
                            <a ui-sref="#" class="item">Link Four</a>
                        </div>
                    </div>
                    <div class="four wide column">
                        <h4 class="ui inverted header">Group 3</h4>
                        <div class="ui inverted link list">
                            <a ui-sref="#" class="item">Link One</a>
                            <a ui-sref="#" class="item">Link Two</a>
                            <a ui-sref="#" class="item">Link Three</a>
                            <a ui-sref="#" class="item">Link Four</a>
                        </div>
                    </div>
                    <div class="four wide column">
                        <h4 class="ui inverted header">Group 4</h4>
                        <div class="ui inverted link list">
                            <a ui-sref="#" class="item">Link One</a>
                            <a ui-sref="#" class="item">Link Two</a>
                            <a ui-sref="#" class="item">Link Three</a>
                            <a ui-sref="#" class="item">Link Four</a>
                        </div>
                    </div>
                </div>
                <div class="ui inverted section divider"></div>
                <div class="ui horizontal inverted small">
                    <span>&copy; 2015-2016 EESTEC</span>
                </div>
            </div>
        </div>

        <script src="assets/lib/jquery-2.1.4.min.js"></script>
        <script src="assets/lib/jquery-observe.js"></script>
        <script src="semantic/dist/semantic.min.js"></script>
        <script src="assets/lib/angular.min.js"></script>
        <script src="assets/lib/angular-resource.js"></script>
        <script src="assets/lib/angular-ui-router.min.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="assets/js/controller/login.js"></script>
        <script src="assets/js/controller/register.js"></script>
        <script src="assets/js/controller/header.js"></script>
        <script src="assets/js/controller/team.js"></script>
        <script src="assets/js/controller/idea.js"></script>
        <script src="assets/js/services/user.js"></script>
        <script src="assets/js/services/api.js"></script>
        <script src="assets/lib/content-tools/content-tools.min.js"></script>
        <script src="assets/js/eca.js"></script>
    </body>

</html>
