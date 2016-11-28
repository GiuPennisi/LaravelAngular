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

  function sendEmail(email) {
    return $http({ method: "POST", url: 'api/crearmensaje/', data: email, cache: false });
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

  function register(userInfo) {
    return $http({ method: "POST", url: 'api/signup', data: userInfo, cache: false });
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
    register,
  };

  return service;
}
