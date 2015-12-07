angular.module('replique')
.constant('targetUrl', '/users/register')
.constant('requestMethod', 'POST')
.controller('registerCtrl', function($scope, $http, targetUrl, requestMethod) {
  $scope.registerTest = 'Hello Register!';

  $scope.responseStatusCode = 'INITIAL_VALUE';
  $scope.requestMethod = requestMethod;

  $scope.register = function(newUser) {
    $http({
      url: targetUrl,
      method: requestMethod,
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
