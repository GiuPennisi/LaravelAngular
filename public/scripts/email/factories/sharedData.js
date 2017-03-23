(function () {
'use strict';
angular
.module('app')
.factory('sharedData', [
  sharedData,
]);

function sharedData() {
  var email;
  var folders;
  var currentTab;

  return {
    getEmail: getEmail,
    setEmail: setEmail,
    getFolders: getFolders,
    setFolders: setFolders,
    getAllEmails: getAllEmails,
    setAllEmails: setAllEmails,
    getCurrentTab: getCurrentTab,
    setCurrentTab: setCurrentTab,
  };
  function getEmail() {
    return email;
  }
  function setEmail(newEmail) {
    email = newEmail;
  }
  function getFolders() {
    return folders;
  }
  function setFolders(newFoldersList) {
    folders = newFoldersList;
  }
  function getAllEmails() {
    return allEmails;
  }
  function setAllEmails(newEmailList) {
    allEmails = newEmailList;
  }
  function getCurrentTab() {
    return currentTab;
  }
  function setCurrentTab(newTab) {
    currentTab = newTab;
  }
};
})();
