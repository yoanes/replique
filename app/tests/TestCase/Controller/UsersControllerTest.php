<?php

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;

class UsersControllerTest extends IntegrationTestCase {

	public $fixtures = ['app.users', 'app.inactives'];
	
	public function testRegisterSuccessful() {
		
		$data = [
			'username' => 'test789',
			'password' => 'password',
			'passwordConfirmation' => 'password',
			'email' => 'test789@example.com'
		];
		
		$this->configRequest([
			'headers' => ['Accept' => 'application/json']
		]);
		
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
	
		$this->configRequest([
			'headers' => ['Accept' => 'application/json']
		]);
	
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
		
		$this->configRequest([
			'headers' => ['Accept' => 'application/json']
		]);

		$this->post('/users/register', $data);
		$this->assertResponseCode('400');
		$this->assertResponseContains('Supplied email already taken.');
		$this->assertResponseContains('Supplied username already taken.');
	}
}