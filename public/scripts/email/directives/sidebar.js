(function () {
'use strict';
angular
.module('app')
.directive('sidebar', function () {
  return {
    templateUrl: 'scripts/email/views/sidebar.html',
    controller: function ($rootScope, $scope, $timeout, sharedData, emailService) {
      var sidebar = this;
      sidebar.folders = sharedData.getFolders();
      var folderObject = {
          folder: "Inbox"
      }
      emailService.getFolderContent(folderObject).then(function(data){
          if(data)
            if(!!data.data.emails[0])
              $rootScope.$broadcast('changeMailContent', data.data.emails);
            else
              $rootScope.$broadcast('changeMailContent', null);
        });

      sidebar.getFolderContent = function(folder) {
        folderObject.folder = folder;

        emailService.getFolderContent(folderObject).then(function(data){
          if(data)
            if(!!data.data.emails[0])
              $rootScope.$broadcast('changeMailContent', data.data.emails);
            else
              $rootScope.$broadcast('changeMailContent', null);
        });
      }

      if(!!!sidebar.folders){
        sidebar.folders = [];
      }
      sidebar.showAddInput = function () {
        sidebar.showFolder = true;
      }
      sidebar.newFolderName = "";

      sidebar.cancel = function() {
        sidebar.nameError = false;
        sidebar.alreadyError = false;
        sidebar.showFolder = false;
        sidebar.newFolderName = "";
      }

      function findFolder(folder) {
        var aux = false;
        angular.forEach(sidebar.folders, function(value, key) {
          if(folder === value.name)
            aux = true;
        });
        return aux;
      }
      sidebar.addFolder =function() {
        sidebar.nameError = false;
        sidebar.alreadyError = false;
        if(!!sidebar.newFolderName && !findFolder(sidebar.newFolderName)){
          var folder = {
            "name" : sidebar.newFolderName,
            "emails": [{

            }]
          };
          sidebar.showFolder = false;
          sidebar.folders.push(folder);
          sharedData.setFolders(sidebar.folders);
        }
        else {
          if(!!sidebar.newFolderName === false){
            sidebar.nameError = true;
          }
          else {
            sidebar.alreadyError = true;
          }
        }
        sidebar.newFolderName = "";

      }

      sidebar.removeFolder =function(folder) {
        angular.forEach(sidebar.folders, function(value, key) {
          if(folder === value.name)
            sidebar.folders.splice(key, 1);
        });
      }
      $scope.sidebar = sidebar;
    },
  };
});
})();
