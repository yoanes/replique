<?php

namespace App\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class InactivesTableTest extends TestCase {
	
	private $existingToken = 'abcdef12345';
	
	public $fixtures = ['app.users', 'app.inactives'];
	
	public function setup() {
		$this->inactivesTable = TableRegistry::get('Inactives');
	}
	
	public function testFindByToken() {
		$inactive = $this->inactivesTable->findByToken($this->existingToken);
		$this->assertNotEquals($inactive, null, "Inactive record should be populated.");
		
		$nonExistingInactive = $this->inactivesTable->findByToken(null);
		$this->assertEquals($nonExistingInactive, null, "Inactive record not found.");
	}
	
	public function tearDown() {
		TableRegistry::clear();
	}
}