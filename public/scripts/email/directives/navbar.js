(function () {
'use strict';
angular
.module('app')
.directive('navbar', function (emailService) {
  return {
    templateUrl: 'scripts/email/views/navbar.html',
    controller: function ($scope, $location) {
      var navbar = this;
      navbar.logOut = function () {
        emailService.logIn();
        $location.url('login');
      };
      $scope.navbar = navbar;
    },
  };
});
})();
