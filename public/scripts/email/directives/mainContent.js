(function () {
'use strict';
angular
.module('app')
.directive('mainContent', function () {
  return {
    templateUrl: 'scripts/email/views/main-content.html',
    controller: function ($scope, $location, sharedData) {
      var content = this;
      content.showEmail = function(email) {
        sharedData.setEmail(email);
        $location.url('email');
      };
      content.emails = sharedData.getAllEmails();
      $scope.content = content;
    },
  };
});
})();
