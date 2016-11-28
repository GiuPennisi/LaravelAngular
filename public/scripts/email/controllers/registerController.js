(function () {
'use strict';
angular
.module('app')
.controller('registerController', function ($scope, $location, emailService, $state) {
  var register = {};

  emailService.getCountries().then(function(data) {
    register.countries = data.data.data;    
  });

  register.getProvinces = function () {
    emailService.getProvinces(register.selectedCountrie).then(function(data) {
      register.provinces = data.data.data;    
    });
  };

  register.getCities = function () {
    emailService.getCities(register.selectedProvince).then(function(data) {
        register.cities = data.data.data;    
    });
  }

  register.isActive = function (viewLocation) {
    return viewLocation === $location.path();
  };

  register.goTo = function() {
    $location.url('');
  };
  register.cancel = function() {
    $state.go('login', {});
  };

  register.register = function () {
    emailService.register(register.userInfo).then(function(users) {
      $state.go('main', {});
    }),(function(error) {
      $state.go('login', {});
    });
  };

  $scope.register = register;
});
})();
