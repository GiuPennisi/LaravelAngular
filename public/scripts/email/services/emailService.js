angular
.module('app')
.factory('emailService', [
  '$log',
  '$http',
  emailService,
]);

function emailService($log, $http) {
  function logIn(userInfo) {
    return $http.post('localhost:8080/login/' + userInfo);
  }

  function logOut() {
    return $http.get('localhost:8080/logout');
  }

  function sendEmail(email) {
    return $http.post('localhost:8080/crearmensaje/' + email);
  }

  function getEmails() {
    return $http.post('localhost:8080/getemail');
  }

  function register(userInfo) {
    return $http.post('localhost:8080/register/' + userInfo);
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
