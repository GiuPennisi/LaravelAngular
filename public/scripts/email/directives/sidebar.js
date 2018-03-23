(function() {
'use strict';
angular
.module('app')
.directive('sideBar', function() {
  return {
    templateUrl: 'scripts/email/views/sidebar.html',
    controller: function($rootScope, $scope, sharedData, emailService) {
      var sidebar = this;

      getFolders();

      var folderObject = {
          folder: "Inbox"
      }
      emailService.getFolderContent(folderObject).then(function(data){
          if(data)
            if(!!data.data.emails[0]){
              $rootScope.$broadcast('changeMailContent', data.data.emails);
            }
            else
              $rootScope.$broadcast('changeMailContent', null);
        });

      sidebar.getFolderContent = function(folder) {
        folderObject.folder = folder;
        sharedData.setCurrentTab(folder);
        $rootScope.$broadcast('changeCurrentTab');
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
      sidebar.showAddInput = function() {
        sidebar.showNewFolder = true;
      }
      sidebar.showDeleteSelect = function() {
        sidebar.showDeleteFolder = true;
      }

      sidebar.deleteFolder = function() {
        emailService.deleteFolder(sidebar.selectedFolder);
        getFolders();
      }
      
      sidebar.newFolderName = "";
      
      sidebar.cancelDelete = function() {
        sidebar.showDeleteFolder = false;
      }
      sidebar.cancel = function() {
        sidebar.nameError = false;
        sidebar.alreadyError = false;
        sidebar.showNewFolder = false;
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
          sidebar.showNewFolder = false;
          sidebar.folders.push(folder);
          emailService.addFolder(folder);
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
      $scope.sidebar = sidebar;

      function getFolders() {
        emailService.getFolders().then(function(response) {
          sidebar.folders = response.data.folders;
       });
      }
    },
  };
});
})();
