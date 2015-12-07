describe('Register Test', function() {
  var mockScope = {};
  var controller;
  var newUser = { username: 'username1', email: 'email1@email.com', password: 'password1', passwordConfirmation: 'password1' };
  var invalidUser = {};
  
  beforeEach(angular.mock.module('replique'));
  
  beforeEach(angular.mock.inject(function($controller, $rootScope, $http) {
    mockScope = $rootScope.$new();
    controller = $controller('registerCtrl', { $scope: mockScope, $http: $http });
  }));

  it('should receive response status code 201 when user data is all correct', function() {
    mockScope.register(newUser);
    expect(mockScope.responseStatusCode).toEqual(201);
  });
  
  it('should receive response status code 400 when user data is not correct', function() {
    mockScope.register(invalidUser);
    expect(mockScope.responseStatusCode).toEqual(400);
  });
});