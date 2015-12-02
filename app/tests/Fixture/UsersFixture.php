<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture {

	public $connection = 'test';
	
	public $import = ['table' => 'users', 'connection' => 'default'];
	
	public function init() {
		$this->records = [
			[
				'id' => 1,
				'username' => 'testuser1',
				'email' => 'testuser1@test.com',
				'password' => uniqid(),
				'salt' => uniqid('', true),
				'private_key' => uniqid('rk.', true),
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			]
		];
		
		parent::init();
	}
}