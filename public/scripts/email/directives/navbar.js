(function () {
'use strict';
angular
.module('app')
.directive('navbar', function (emailService,sharedData) {
  return {
    templateUrl: 'scripts/email/views/navbar.html',
    controller: function ($scope, $location) {
      var navbar = this;
      navbar.currentTab = 'Inbox';
      sharedData.setCurrentTab('Inbox');
      $scope.$on('changeCurrentTab', function(event, args) {
        navbar.currentTab = sharedData.getCurrentTab();
      });
      navbar.logOut = function () {
        localStorage.clear();
        $location.url('login');
      };
      $scope.navbar = navbar;
    },
  };
});
})();
