angular.module('replique')
.constant('activeSelectorClass', 'btn-primary')
.constant('maxProductsPerPage', 2)
.controller('mainContentCtrl',
  function ($scope/*, $filter*/, activeSelectorClass, maxProductsPerPage) {
    $scope.mainContentTest = 'Hello Main Content!';
    var selectedCategory = null;

    $scope.selectedPage = 1;
    $scope.maxProductsPerPage = maxProductsPerPage;

    $scope.selectCategory = function (category) {
      selectedCategory = category;
      $scope.selectedPage = 1;
    };
    $scope.filterByCategory = function (product) {
      return !selectedCategory || product.category === selectedCategory;
    };
    $scope.getCategoryClass = function (category) {
      return ((!category && !selectedCategory) || category === selectedCategory) ? activeSelectorClass : '';
    };

    $scope.selectPage = function (page) {
      $scope.selectedPage = page;
    };
    $scope.getPageClass = function (page) {
      return (page === $scope.selectedPage) ? activeSelectorClass : '';
    };
    
  }
)
;
