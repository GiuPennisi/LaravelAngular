(function () {
'use strict';
angular
.module('app')
.controller('loginController', function ($scope, $location, emailService, $auth, $state) {
  var login = {};
  login.isActive = function (viewLocation) {
    return viewLocation === $location.path();
  };
  login.goTo = function() {
    $location.url('');
  };
  login.logIn = function () {
    $auth.login(login.userInfo).then(function(data) {
      // If login is successful, redirect to the users state
      $state.go('main', {});
    });
  };
  login.test="hola";
  $scope.login = login;
});
})();
