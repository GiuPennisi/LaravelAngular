(function () {
'use strict';
angular
.module('app')
.controller('personalEmailController', function ($scope, $location, sharedData, $auth, $state) {
  var personal = {};
  personal.email =  sharedData.getEmail();
  personal.isActive = function (viewLocation) {
    return viewLocation === $location.path();
  };
  personal.return = function() {
    $state.go('main', {});
  };
  $scope.personal = personal;
});
})();
