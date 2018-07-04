(function () {
  'use strict';
  angular
    .module('app')
    .controller('sendMessageController', function ($scope, $location, emailService) {
      var sendMessage = {};
      emailService.getUsers().then(function (data) {
        sendMessage.users = data.data.data;
      });

      sendMessage.isActive = function (viewLocation) {
        return viewLocation === $location.path();
      };
      sendMessage.goTo = function () {
        $location.url('');
      };
      sendMessage.send = function () {
        emailService.sendEmail(sendMessage.email, sendMessage.attachment).then(function (response) {
          swal("Perfecto!", "Su email ha sido enviado!", "success");
        }).catch(function (response) {
          swal("Oh no!", "Sucedio lo impensable..un error! trate nuevamente mas tarde", "error");
        });

        $location.url('');
      };
      $scope.sendMessage = sendMessage;
    });
})();
