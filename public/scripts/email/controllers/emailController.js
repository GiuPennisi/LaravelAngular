(function () {
'use strict';
angular
.module('app')
.controller('emailController', function ($scope, $location) {
  var email = {};
  email.isActive = function (viewLocation) {
    return viewLocation === $location.path();
  };
  email.test="hola";
  $scope.email = email;
});
})();
