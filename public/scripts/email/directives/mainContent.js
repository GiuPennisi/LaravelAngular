(function () {
'use strict';
angular
.module('app')
.directive('mainContent', function () {
  return {
    templateUrl: 'scripts/email/views/main-content.html',
    controller: function ($scope, $location, sharedData, emailService) {
      var content = this;
      content.showEmail = function(email) {
        sharedData.setEmail(email);
        $location.url('email');
      };
       emailService.getEmails().then(function(data) {
        content.emails = data.data.emails;
      });
      $scope.content = content;
    },
  };
});
})();
