(function () {
  'use strict';
  angular
    .module('app')
    .controller('personalEmailController', function ($scope, $location, sharedData, emailService, $auth, $state) {
      var personal = {};
      personal.showMove = false;
      personal.folders = [];

      emailService.getFolders().then(function (response) {
        personal.folders = response.data.folders;
      });

      personal.email = sharedData.getEmail();

      personal.isActive = function (viewLocation) {
        return viewLocation === $location.path();
      };

      personal.return = function () {
        $state.go('main', {});
      };

      personal.move = function () {
        personal.showMove = true;
      };

      personal.moveToAnotherFolder = function () {
        emailService.moveToAnotherFolder(personal.selectedFolder, personal.email.id).then(function (response) {
          swal("Perfecto!", "Su email ha sido transladado!", "success");
        }).catch(function (response) {
          swal("Oh no!", "Sucedio lo impensable..un error! trate nuevamente mas tarde", "error");
        });
      };

      personal.deleteEmail = function () {
        emailService.deleteEmail(personal.email.id).then(function (response) {
          swal("Perfecto!", "Su email ha sido eliminado!", "success");
          personal.return();
        }).catch(function (response) {
          swal("Oh no!", "Sucedio lo impensable..un error! trate nuevamente mas tarde", "error");
        });
      };

      $scope.personal = personal;
    });
})();
