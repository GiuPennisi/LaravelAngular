(function() {

    'use strict';

    angular
        .module('app', ['ui.router', 'satellizer','ngMessages'])
        .config(function($stateProvider, $urlRouterProvider, $authProvider, $httpProvider) {

            // Satellizer configuration that specifies which API
            // route the JWT should be retrieved from
            $httpProvider.interceptors.push('authInterceptor');
            $authProvider.loginUrl = '/api/authenticate';

            // Redirect to the auth state if any other states
            // are requested other than users
            $urlRouterProvider.otherwise('/login');
            
            $stateProvider
                .state('login', {
                    url: '/login',
                    templateUrl: 'scripts/email/views/login.html',
                    controller: 'loginController',
                    authenticate: false
                })
                .state('main', {
                    url: '/',
                    templateUrl: 'scripts/email/views/email-main.html',
                    controller: 'personalEmailController',
                    authenticate: true
                })
                .state('email',{
                     url: '/email',
                    templateUrl: "scripts/email/views/personal-email.html",
                    controller: "personalEmailController",
                    authenticate: true
                })
                .state('register',{
                    url: '/register',
                    templateUrl: "scripts/email/views/register.html",
                    controller: "registerController",
                    authenticate: false
                })
                .state('sendMessage',{
                    url: '/sendMessage',
                    templateUrl: "scripts/email/views/send-message.html",
                    controller: "sendMessageController",
                    authenticate: true
                })
        })
        .run(['$rootScope','$state', run]);
        function run($rootScope, $state) {
            $rootScope.$on("$stateChangeStart", function(event, toState, toParams, fromState, fromParams){
                if (toState.authenticate && !localStorage.getItem('token')) {
                    $state.transitionTo("login");
                    event.preventDefault();
                } else if (toState.name === "login" && !!localStorage.getItem('token')){
                    $state.transitionTo("main");
                    event.preventDefault();
                }
            });
        }
})();