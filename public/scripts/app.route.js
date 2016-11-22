var app = angular.module('app.routes',['ngRoute']);

app.config(['$routeProvider',function($routeProvider){
  $routeProvider
    .when('/',{
      templateUrl: "scripts/email/views/email-main.html",
      controller: "emailController",
    })
    .when('/email',{
      templateUrl: "scripts/email/views/personal-email.html",
      controller: "personalEmailController",
    })
    .when('/register',{
      templateUrl: "scripts/email/views/register.html",
      controller: "registerController",
    })
    .when('/login',{
      templateUrl: "scripts/email/views/login.html",
      controller: "loginController",
    })
    .when('/sendMessage',{
      templateUrl: "scripts/email/views/send-message.html",
      controller: "sendMessageController",
    })

}]);
