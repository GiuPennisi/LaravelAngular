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
            $urlRouterProvider.otherwise('/login');
            
            $stateProvider
                .state('login', {
                    url: '/login',
                    templateUrl: 'scripts/email/views/login.html',
                    controller: 'loginController'
                })
                .state('main', {
                    url: '/',
                    templateUrl: 'scripts/email/views/email-main.html',
                    controller: 'personalEmailController'
                })
                .state('email',{
                     url: '/email',
                    templateUrl: "scripts/email/views/personal-email.html",
                    controller: "personalEmailController",
                })
                .state('register',{
                    url: '/register',
                    templateUrl: "scripts/email/views/register.html",
                    controller: "registerController",
                })
                .state('sendMessage',{
                    url: '/sendMessage',
                    templateUrl: "scripts/email/views/send-message.html",
                    controller: "sendMessageController",
                })
        });
})();