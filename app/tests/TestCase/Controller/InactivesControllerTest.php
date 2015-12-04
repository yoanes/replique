<?php

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;

class InactivesControllerTest extends IntegrationTestCase {
	
	public $fixtures = ['app.users', 'app.inactives'];
	
	public function testActivateFailure() {
		$this->configRequest([
			'headers' => ['Accept' => 'application/json']
		]);
		
		$this->get('/inactives/activate/invalid_token_nonexistent_user');
		$this->assertResponseCode('404');
		$this->assertResponseContains('Not Found');
		
		$this->get('/inactives/activate/nonexistent_token');
		$this->assertResponseCode('404');
		$this->assertResponseContains('Not Found');
	}
	
	public function testActivate() {
		
		$this->configRequest([
			'headers' => ['Accept' => 'application/json']
		]);
		
		$this->get('/inactives/activate/abcdef12345');
		$this->assertResponseCode('302');
		$this->assertSession(1, 'Auth.User.id');
		$this->assertRedirect('http://repliqueministry.org');
	}
}