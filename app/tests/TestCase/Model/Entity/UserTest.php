<?php

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\User;
use App\Model\Entity\Inactive;
use Cake\TestSuite\TestCase;

class UserTest extends TestCase {
	
	public function setup() {
		parent::setup();
		$this->user = new User(['id' => 1]);
		$this->user->inactive = new Inactive(['user_id' => 1]);
	}
	
	public function testKeyGeneration() {
		$this->assertNotEquals($this->user->private_key, null, "Key should be populated on creation.");
	}
	
	public function testHashPassword() {
		$this->user->hashPassword("password");
		$this->assertNotEquals($this->user->salt, null, "Salt should be populated.");
		$this->assertNotEquals($this->user->password, 'password', "Password should be hashed.");
	}
	
	public function testIsActive() {
		$this->assertEquals($this->user->isActive(), false, "Inactive user since it hasn't been activated.");
		
		#activate user by deleting inactive record.
		$this->user->inactive = null;
		$this->assertEquals($this->user->isActive(), true, "Active user since it has been activated.");
	}
}