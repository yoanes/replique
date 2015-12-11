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
