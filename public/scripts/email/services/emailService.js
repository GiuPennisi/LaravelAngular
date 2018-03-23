angular
.module('app')
.factory('emailService', [
  '$log',
  '$http',
  '$auth',
  emailService,
]);

function emailService($log, $http, $auth) {
  function logIn(userInfo) {
    return $auth.login(userInfo);
  }

  function getCountries() {
    return $http.post('api/countries');
  }

  function getProvinces(countrie) {
    return $http({ method: "POST", url: 'api/provinces/', data: countrie, cache: false });
  }

  function getCities(province) {
    return $http({ method: "POST", url: 'api/cities/', data: province, cache: false });
  }

  function sendEmail(email, attachment) {
    var fd = new FormData();
    if (attachment.length) {
      fd.append('attachment', attachment[0].lfFile);
    }
    fd.append('email',JSON.stringify(email));
    return $http({ method: "POST", url: 'api/crearmensaje/', withCredentials : false, headers : {'Content-Type' : undefined}, transformRequest : angular.identity, data: fd});
  }

  function getEmails() {
    return $http.post('api/getemail');
  }

  function getUsers() {
    return $http.get('api/getUsers');
  }

  function getFolderContent(folder) {
    return $http({ method: "POST", url: 'api/getFolderContent', data: folder, cache: false });
  }

  function addFolder(folder) {
    return $http({ method: "POST", url: 'api/createfolder', data: folder, cache: false });
  }

  function getFolders() {
    return $http({ method: "GET", url: 'api/getFolders', cache: false });
  }

  function moveToAnotherFolder(selectedFolderId, emailId) {
    return $http({ method: "POST", url: 'api/moveToAnotherFolder', data: {selectedFolderId, emailId}, cache: false });
  }

  function register(userInfo) {
    return $http({ method: "POST", url: 'api/signup', data: userInfo, cache: false });
  }

  function deleteFolder(folderId) {
    return $http({ method: "POST", url: 'api/deleteFolder', data: {id: folderId}, cache: false });
  }
  
  function deleteEmail(emailId) {
    return $http({ method: "POST", url: 'api/deleteEmail', data: {id: emailId}, cache: false });
  }

  const service = {
    logIn,
    getCountries,
    getProvinces,
    getCities,
    sendEmail,
    getEmails,
    getUsers,
    getFolderContent,
    addFolder,
    getFolders,
    moveToAnotherFolder,   
    register,
    deleteFolder,
    deleteEmail
  };

  return service;
}
