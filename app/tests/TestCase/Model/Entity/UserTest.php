<?php

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\User;
use Cake\TestSuite\TestCase;

class UserTest extends TestCase {
	
	public function setup() {
		parent::setup();
		$this->user = new User();
	}
	
	public function testSetKey() {
		$this->assertNotEquals($this->user->userkey, null, "Key should be populated.");
	}
	
	public function testHashPassword() {
		$this->user->hashPassword("password");
		$this->assertNotEquals($this->user->salt, null, "Salt should be populated.");
		$this->assertNotEquals($this->user->password, 'password', "Password should be hashed.");
	}
}