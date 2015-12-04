<?php

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;

class UsersControllerTest extends IntegrationTestCase {

	public $fixtures = ['app.users', 'app.inactives'];
	
	public function setup() {
		parent::setup();
		
		// set all initial request to json
		// further json request will need to be declared in the method
		$this->configRequest([
			'headers' => ['Accept' => 'application/json']
		]);
	}
	
	public function testRegisterSuccessful() {
		
		$data = [
			'username' => 'test789',
			'password' => 'password',
			'passwordConfirmation' => 'password',
			'email' => 'test789@example.com'
		];
		
		$this->post('/users/register', $data);
		$this->assertResponseOk();
		$this->assertResponseEquals("\"ok\"");
	}
	
	public function testRegisterWithValidationErrors() {
	
		$data = [
			'username' => 'test789',
			'password' => 'password',
			'passwordConfirmation' => 'password_typo',
			'email' => 'test789example.com'
		];
	
		$this->post('/users/register', $data);
		$this->assertResponseCode('400');
		$this->assertResponseContains('Confirmation password');
		$this->assertResponseContains('Email format is incorrect');
	}
	
	public function testRegisterWithDuplicateEntry() {
		
		$data = [
			'username' => 'testuser1',
			'password' => 'password',
			'passwordConfirmation' => 'password',
			'email' => 'testuser1@test.com'
		];

		$this->post('/users/register', $data);
		$this->assertResponseCode('400');
		$this->assertResponseContains('Supplied email already taken.');
		$this->assertResponseContains('Supplied username already taken.');
	}
	
	public function testLoginSuccessful() {
		$data = [
			'email' => 'testuser3@test.com',
			'password' => 'password'
		];
		
		$this->post('/users/login', $data);
		$this->assertResponseOk();
		$this->assertResponseEquals("\"ok\"");
		$this->assertSession(3, 'Auth.User.id');
	}
	
	public function testLoginFailureForInactiveUser() {
		$data = [
			'email' => 'testuser1@test.com',
			'password' => 'password'
		];
	
		$this->post('/users/login', $data);
		$this->assertResponseCode('400');
		$this->assertResponseContains('Credential supplied is invalid.');
	}
	
	public function testLoginFailureForNonExistentUser() {
		$data = [
			'email' => 'nonexistentuser@test.com',
			'password' => 'password'
		];
	
		$this->post('/users/login', $data);
		$this->assertResponseCode('400');
		$this->assertResponseContains('Credential supplied is invalid.');
	}
	
	public function testLogoutWhenUserNotLoggedIn() {		
		$this->get('/users/logout');
		
		$this->assertResponseOk();
		$this->assertResponseEquals("\"ok\"");
	}
	
	public function testLogoutAfterUserLoggedIn() {
		// log user in first
		$data = [
			'email' => 'testuser3@test.com',
			'password' => 'password'
		];
		
		$this->post('/users/login', $data);
		$this->assertSession(3, 'Auth.User.id');
		
		// and test the logout
		$this->configRequest([
			'headers' => ['Accept' => 'application/json']
		]);
		
		$this->get('/users/logout');
		
		$this->assertResponseOk();
		$this->assertResponseEquals("\"ok\"");
		$this->assertSession(null, 'Auth.User.id');
	}
	
	public function testResetPasswordRequestSuccessful() {
		$data = ['email' => 'testuser3@test.com'];
		
		$this->post('/users/resetPasswordRequest', $data);
		$this->assertResponseOk();
		$this->assertResponseEquals("\"ok\"");
	}
	
	public function testResetPasswordRequestFailureForNonExistentUser() {
		$data = ['email' => 'nonexistentuser@test.com'];
		
		$this->post('/users/resetPasswordRequest', $data);
		$this->assertResponseCode('404');
		$this->assertResponseContains('Not Found');
	}
	
	public function testResetPasswordRequestFailureForInactiveUser() {
		$data = ['email' => 'testuser1@test.com'];
	
		$this->post('/users/resetPasswordRequest', $data);
		$this->assertResponseCode('400');
		$this->assertResponseContains('User not allowed to reset password.');
	}
}