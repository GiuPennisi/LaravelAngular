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
         if(data)
          if(!!data.data.emails[0])
            content.emails = data.data.emails;
          else
            content.emails = null;
      });
      $scope.content = content;
    },
  };
});
})();
