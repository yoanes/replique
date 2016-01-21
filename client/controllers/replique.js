angular.module('replique', ['ngRoute'])
.config(function($routeProvider, $locationProvider) {
  $routeProvider.when('/register', { templateUrl: './views/register.html' });
  $routeProvider.otherwise({ templateUrl: './views/mainContent.html' });
  //$routeProvider.otherwise({ templateUrl: './views/register.html' });
})

.config(['$httpProvider', function ($httpProvider) {
  //$httpProvider.defaults.useXDomain = true;
  //delete $httpProvider.defaults.headers.common["X-Requested-With"];
  //$httpProvider.defaults.headers.common["Access-Control-Allow-Origin"] = "*";
  //$httpProvider.defaults.headers.common["Content-Type"] = "application/json";
  //$httpProvider.defaults.headers.common = {};
  $httpProvider.defaults.headers.post = {};
}])

.constant('loginUrl', 'http://localhost:8765/users/login')
.constant('loginRequestMethod', 'POST')
.controller('repliqueCtrl', function ($scope, $http, loginUrl, loginRequestMethod) {
  $scope.repliqueTest = 'Hello Replique!';

  $scope.responseStatusCode = 'INITIAL_VALUE';

  $scope.login = function(currentUser) {
    $http({
      url: loginUrl,
      method: loginRequestMethod,
      //headers: { 'Content-Type': 'application/json' },
      //headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      data: currentUser
    })
    .then(
      function successCallback(response) {
        $scope.responseStatusCode = response.status;
      },
      function errorCallback(response) {
        $scope.responseStatusCode = response.status;
      }
    );    
  };
})
;
