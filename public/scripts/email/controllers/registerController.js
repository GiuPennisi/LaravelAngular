(function () {
'use strict';
angular
.module('app')
.controller('registerController', function ($scope, $location, emailService, $state) {
  var register = {};
  register.isActive = function (viewLocation) {
    return viewLocation === $location.path();
  };
  register.goTo = function() {
    $location.url('');
  };
  register.register = function () {
    emailService.register(register.userInfo).success(function(users) {
      $state.go('main', {});
    }).error(function(error) {
      $state.go('login', {});
    });
  };
  $scope.register = register;
});
})();
