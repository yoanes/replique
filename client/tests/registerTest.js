describe('Register Test', function() {
  var mockScope = {};
  var controller;
  var backend;
  
  var validUser = { username: 'username1', email: 'email1@email.com', password: 'password1', passwordConfirmation: 'password1' };
  var invalidUser = {};
  
  beforeEach(angular.mock.module('replique'));
  
  beforeEach(angular.mock.inject(function($controller, $rootScope, $httpBackend) {
    mockScope = $rootScope.$new();
    controller = $controller('registerCtrl', { $scope: mockScope});
    backend = $httpBackend;
  }));

  it('should receive response status code 201 when user data is all correct', function() {
    backend.expect(mockScope.requestMethod, controller.targetUrl, validUser).respond(201, '');
    mockScope.register(validUser);
    backend.flush();
    expect(mockScope.responseStatusCode).toEqual(201);
  });
  
  it('should receive response status code 400 when user data is not correct', function() {
    backend.expect(mockScope.requestMethod, controller.targetUrl, invalidUser).respond(400, '');
    mockScope.register(invalidUser);
    backend.flush();
    expect(mockScope.responseStatusCode).toEqual(400);
  });
});