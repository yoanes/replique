angular.module('replique', ['ngRoute'])
.config(function($routeProvider, $locationProvider) {
  $routeProvider.when('/register', { templateUrl: './views/register.html' });
  $routeProvider.otherwise({ templateUrl: './views/mainContent.html' });
  //$routeProvider.otherwise({ templateUrl: './views/register.html' });
})
//.constant('dataUrl', 'http://localhost:5500/products')
.controller('repliqueCtrl',
  function ($scope, $http) {
    $scope.repliqueTest = 'Hello Replique!';
    /*
    $scope.data = {
      products: [
        { name: 'Product #1', description: 'A product', category: 'Category #1', price: 100 },
        { name: 'Product #2', description: 'A product', category: 'Category #1', price: 110 },
        { name: 'Product #3', description: 'A product', category: 'Category #2', price: 210 },
        { name: 'Product #4', description: 'A product', category: 'Category #3', price: 202 },
      ]
    }
    */
    $scope.data = {};

    //$http.get(dataUrl)
    //.success(function (data) { $scope.data.products = data; })
    //.error(function (error) { $scope.data.error = error; });
  }
)
;
