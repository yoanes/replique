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
	
	public function testIsActive() {
		$this->assertEquals($this->user->isActive(), false, "Inactive user since it hasn't been activated.");
		
		#activate user by deleting inactive record.
		$this->user->inactive = null;
		$this->assertEquals($this->user->isActive(), true, "Active user since it has been activated.");
	}
	
	public function testGetToken() {
		$this->assertNotEquals($this->user->token, null, "Token should be populated for inactive user.");
		
		#activate user by deleting inactive record.
		$this->user->inactive = null;
		$this->assertEquals($this->user->token, null, "Token should be null for activated user.");
	}
	
	public function testGenerateResetPasswordToken() {
		$this->assertEquals($this->user->generateResetPasswordToken(), false, "Inactive user should not be able to reset password.");
		
		// activate user
		$this->user->inactive = null;
		$token = $this->user->generateResetPasswordToken();
		$this->assertNotEquals($token, false, "Reset password token should be generated.");
	}
	
	public function testValidateResetPasswordToken() {
		// activate user and generate the token
		$this->user->inactive = null;
		$token = $this->user->generateResetPasswordToken();
		
		// validate a real token. In generic user's scenario, urldecode() will be performed by the browser
		$this->assertEquals($this->user->validateResetPasswordToken(urldecode($token)), true, "Token validation should return true.");
		
		// empty token should return false
		$this->assertEquals($this->user->validateResetPasswordToken(), false, "Empty token must return false.");
	}
}