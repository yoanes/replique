<?php

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Inactive;
use App\Model\Entity\User;
use Cake\TestSuite\TestCase;

class InactiveTest extends TestCase {

	var $mockUserId = 1;
	
	public function setup() {
		parent::setup();
		$this->inactive = new Inactive(['user_id' => 1]);
		$this->inactive->user = new User(['id' => 1]);
	}

	public function testNewInactive() {
		$this->assertNotEquals($this->inactive->token, null, "Token should be populated upon instantiation.");
		$this->assertEquals($this->inactive->user_id, $this->mockUserId, "User Id should be populated.");
	}
	
	public function testIsValidInactive() {
		$this->assertEquals($this->inactive->isValid(), true, "Inactive record is valid since it has the corresponding user.");
		
		#invalidate inactive record;
		$this->inactive->user = null;
		$this->assertEquals($this->inactive->isValid(), false, "Inactive record is invalid since it doesn't have a corresponding user record.");
	}
	
}