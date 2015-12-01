<?php

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Inactive;
use Cake\TestSuite\TestCase;

class InactiveTest extends TestCase {

	var $mockUserId = 1;
	
	public function setup() {
		parent::setup();
		$this->inactive = null;
	}

	public function testNewInactive() {
		$this->inactive = new Inactive(['user_id' => 1]);
		
		$this->assertNotEquals($this->inactive->token, null, "Token should be populated upon instantiation.");
		$this->assertEquals($this->inactive->user_id, $this->mockUserId, "User Id should be populated.");
	}
}