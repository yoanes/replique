<?php

namespace App\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class UsersTableTest extends TestCase {
	
	private $validEmail = 'testuser1@test.com';
	
	public $fixtures = ['app.users', 'app.inactives'];
	
	public function setup() {
		$this->usersTable = TableRegistry::get('Users');
	}
	
	public function tearDown() {
		TableRegistry::clear();
	}
	
	public function testFindByEmail() {
		$user = $this->usersTable->findByEmail($this->validEmail);
		
		$this->assertNotEquals($user, null, "User should be populated.");
		$this->assertNotEquals($user->inactive, null, "This particular user shoud have inactive record.");
		$this->assertEquals($user->isActive(), false, "User is inactive.");
		
		$nonExistentUser = $this->usersTable->findByEmail();
		$this->assertEquals($nonExistentUser, null, "User should be null.");
	}
}