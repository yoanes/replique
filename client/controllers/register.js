angular.module('replique')
.constant('baseUrl', '/users/register')
.controller('registerCtrl', function($scope, $http, baseUrl) {
  $scope.registerTest = 'Hello Register!';

  $scope.responseStatusCode = 'INITIAL_VALUE';

  $scope.register = function(newUser) {
    $http({
      url: baseUrl,
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      data: newUser
    })
    .then(
      function successCallback(response) {
        $scope.responseStatusCode = response.status;
      },
      function errorCallback(response) {
        $scope.responseStatusCode = response.status;
      }
    );
  }
})
;
