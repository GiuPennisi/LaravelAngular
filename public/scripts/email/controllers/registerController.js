(function () {
'use strict';
angular
.module('app')
.controller('registerController', function ($scope, $location, emailService) {
  var register = {};
  register.isActive = function (viewLocation) {
    return viewLocation === $location.path();
  };
  register.goTo = function() {
    $location.url('');
  };
  register.register = function () {
    emailService.register(register.userInfo);
    $location.url('');
  };
  $scope.register = register;
});
})();
