describe('Register Test', function() {
  var mockScope = {};
  var controller;
  var backend;
  
  var validUser = { username: 'username1', email: 'email1@email.com', password: 'password1', passwordConfirmation: 'password1' };
  var invalidUser = {};
  
  var formPasswordAndConfirmation;
  
  beforeEach(angular.mock.module('replique'));
  
  beforeEach(angular.mock.inject(function($controller, $rootScope, $httpBackend) {
    mockScope = $rootScope.$new();
    controller = $controller('registerCtrl', { $scope: mockScope});
    backend = $httpBackend;
  }));

  beforeEach(angular.mock.inject(function($compile) {
    mockScope.model = {
      data: { newUser: { 
        password: null,
        passwordConfirmation: null
      } }
    };
    
    var elementPasswordAndConfirmation = angular.element(
      "<form name='formPasswordAndConfirmation'>"
      + "<input class='form-control' id='registerPassword' maxlength='50' name='registerPassword' ng-model='data.newUser.password' placeholder='Please enter your password' required type='password' />"
      + "<input class='form-control' id='registerPasswordConfirmation' maxlength='50' name='registerPasswordConfirmation' ng-model='data.newUser.passwordConfirmation' password-confirmation='{{data.newUser.password}}' placeholder='Please confirm your passord' required type='password' />"
      + "</form>"
    );
    
    var compiledPasswordAndConfirmation = $compile(elementPasswordAndConfirmation)(mockScope);
    formPasswordAndConfirmation = mockScope.formPasswordAndConfirmation;
  }));

  it('should receive response status code 201 when user data is all correct', function() {
    backend.expect(mockScope.registerRequestMethod, controller.registerUrl, validUser).respond(201, '');
    mockScope.register(validUser);
    backend.flush();
    expect(mockScope.responseStatusCode).toEqual(201);
  });
  
  it('should receive response status code 400 when user data is not correct', function() {
    backend.expect(mockScope.registerRequestMethod, controller.registerUrl, invalidUser).respond(400, '');
    mockScope.register(invalidUser);
    backend.flush();
    expect(mockScope.responseStatusCode).toEqual(400);
  });
  
  it('should set password confirmation to valid when it matches the password', function() {
    formPasswordAndConfirmation.registerPassword.$setViewValue('c');
    formPasswordAndConfirmation.registerPasswordConfirmation.$setViewValue('c');
    mockScope.$digest();
    console.log(formPasswordAndConfirmation.registerPassword.$viewValue);
    console.log(formPasswordAndConfirmation.registerPasswordConfirmation.$viewValue);
    expect(formPasswordAndConfirmation.registerPasswordConfirmation.$valid).toBe(true);
  });
  
  it('should set password confirmation to invalid when it does not match the password', function() {
    formPasswordAndConfirmation.registerPassword.$setViewValue('c');
    formPasswordAndConfirmation.registerPasswordConfirmation.$setViewValue('d');
    mockScope.$digest();
    console.log(formPasswordAndConfirmation.registerPassword.$viewValue);
    console.log(formPasswordAndConfirmation.registerPasswordConfirmation.$viewValue);
    expect(formPasswordAndConfirmation.registerPasswordConfirmation.$valid).toBe(false);
  });
  
});