(function() {

    'use strict';

    angular
        .module('app', ['ui.router', 'satellizer','ngMessages'])
        .config(function($stateProvider, $urlRouterProvider, $authProvider) {

            // Satellizer configuration that specifies which API
            // route the JWT should be retrieved from
            $authProvider.loginUrl = '/api/authenticate';

            // Redirect to the auth state if any other states
            // are requested other than users
            $urlRouterProvider.otherwise('/auth');
            
            $stateProvider
                .state('auth', {
                    url: '/auth',
                    templateUrl: 'scripts/email/views/login.html',
                    controller: 'loginController'
                })
                .state('email', {
                    url: '/email',
                    templateUrl: 'scripts/email/views/email-main.html',
                    controller: 'personalEmailController'
                });
        });
})();