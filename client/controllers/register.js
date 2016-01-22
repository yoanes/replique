angular.module('replique')
.constant('registerUrl', 'http://localhost:8765/users/register')
.constant('registerRequestMethod', 'POST')
.controller('registerCtrl', function($scope, $http, registerUrl, registerRequestMethod) {
  $scope.registerTest = 'Hello Register!';

  $scope.responseStatusCode = 'INITIAL_VALUE';
  
  // $scope.registerRequestMethod below is required to pass karma test.
  $scope.registerRequestMethod = registerRequestMethod;

  $scope.register = function(newUser) {
    ////var manualData = {'username' : 'test789', 'email' : 'test789@example.com', 'password' : 'password', 'passwordConfirmation' : 'password'};
    ////newUser = manualData;
    ////alert(newUser['email']);
    $http({
      url: registerUrl,
      method: registerRequestMethod,
      //headers: { 'Content-Type': 'application/json' },
      //headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      data: newUser
    })
    .then(
      function successCallback(response) {
        $scope.responseStatusCode = response.status;
      },
      function errorCallback(response) {
        alert(response.data);
        $scope.responseStatusCode = response.status;
      }
    );
  };
})
.directive('passwordConfirmation', function() {
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function(scope, element, attrs, ngModel) {
            if(!ngModel) return;
            
            var validate = function() {
              var val1 = ngModel.$viewValue;
console.log(val1);
              var val2 = attrs.passwordConfirmation;
console.log(val2);
              ngModel.$setValidity('passwordConfirmation', val1 === val2 || !val1 || !val2);
            };

            scope.$watch(attrs.ngModel, function() {
              validate();
console.log('watcher');
            });
            
            attrs.$observe('passwordConfirmation', function() {
              validate();
console.log('observer\n\r----------');
            });
            
          }
  };
})
;
