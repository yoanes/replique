describe('Login Test', function() {
  var mockScope = {};
  var controller;
  var backend;
  
  var validLogin = { email: 'email1@email.com', password: 'password1' };
  var invalidLogin = {};
  
  beforeEach(angular.mock.module('replique'));
  
  beforeEach(angular.mock.inject(function($controller, $rootScope, $httpBackend) {
    mockScope = $rootScope.$new();
    controller = $controller('repliqueCtrl', { $scope: mockScope});
    backend = $httpBackend;
  }));

  it('should receive response status code 200 when user data is all correct', function() {
    backend.expect(mockScope.requestMethod, controller.targetUrl, validLogin).respond(200, '');
    mockScope.login(validLogin);
    backend.flush();
    expect(mockScope.responseStatusCode).toEqual(200);
  });
  
  it('should receive response status code 400 when user login is not correct', function() {
    backend.expect(mockScope.requestMethod, controller.targetUrl, invalidLogin).respond(400, '');
    mockScope.login(invalidLogin);
    backend.flush();
    expect(mockScope.responseStatusCode).toEqual(400);
  });
    
});