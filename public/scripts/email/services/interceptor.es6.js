(function () {
'use strict';

angular
    .module('app')
    .factory('authInterceptor', [
        '$q', 
        'localStorageService',
        authInterceptor
    ]);


function authInterceptor ($q, localStorageService) {
  return {
    request: function (config) {
      config.headers = config.headers || {};
      if (localStorageService.token) {
        config.headers['X-Auth-Token'] = localStorageService.token;
      }
      return config;
    },
    response: function (response) {
      if (response.status === 401 && response.status === 400) {
        localStorageService.$reset();
      }
      return response || $q.when(response);
    }
  };
}

})();