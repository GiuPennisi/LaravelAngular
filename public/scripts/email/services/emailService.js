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
    return $http({ method: "POST", url: 'api/signup', data: userInfo, cache: false });
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
