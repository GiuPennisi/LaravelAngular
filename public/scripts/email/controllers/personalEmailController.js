(function () {
'use strict';
angular
.module('app')
.controller('personalEmailController', function ($scope, $location, sharedData) {
  var personal = {};
  personal.email =  sharedData.getEmail();
  personal.isActive = function (viewLocation) {
    return viewLocation === $location.path();
  };
  personal.return = function() {
    $location.url('');
  };
  $scope.personal = personal;
});
})();
