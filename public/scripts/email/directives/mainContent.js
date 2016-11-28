(function () {
'use strict';
angular
.module('app')
.directive('mainContent', function () {
  return {
    templateUrl: 'scripts/email/views/main-content.html',
    controller: function ($scope, $location, sharedData, emailService) {
      var content = this;
      $scope.$on('changeMailContent', function(event, args) {
        content.emails = args;
      });
      content.showEmail = function(email) {
        sharedData.setEmail(email);
        $location.url('email');
      };
  
      $scope.content = content;
    },
  };
});
})();
