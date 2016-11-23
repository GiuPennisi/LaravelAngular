(function () {
'use strict';
angular
.module('app')
.controller('loginController', function ($scope, $location, emailService, $state, localStorageService) {
  var login = {};
  login.isActive = function (viewLocation) {
    return viewLocation === $location.path();
  };
  login.goTo = function() {
    $location.url('');
  };
  login.logIn = function () {
   emailService.logIn(login.userInfo).then(function(data) {
      // If login is successful, redirect to the users state
      localStorageService.token = data.data.token;
      $state.go('main', {});
    });
  };
  $scope.login = login;
});
})();
