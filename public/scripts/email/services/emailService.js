angular
.module('app')
.factory('emailService', [
  '$log',
  '$http',
  emailService,
]);

function emailService($log, $http) {
  function logIn(userInfo) {
    return $http.post('api/login/' + userInfo);
  }

  function logOut() {
    return $http.get('api/logout');
  }

  function sendEmail(email) {
    return $http.post('api/crearmensaje/' + email);
  }

  function getEmails() {
    return $http.post('api/getemail');
  }

  function register(userInfo) {
    return $http.post('api/register/' + userInfo);
  }

  const service = {
    logIn,
    logOut,
    sendEmail,
    getEmails,
    register,
  };

  return service;
}
