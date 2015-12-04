<?php

namespace App\Test\Fixture;

use Cake\Auth\DefaultPasswordHasher;
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
				'password' => (new DefaultPasswordHasher)->hash('password'),
				'private_key' => uniqid('rk.', true) . "." . uniqid('', true),
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			],
			[
				'id' => 3,
				'username' => 'testuser3',
				'email' => 'testuser3@test.com',
				'password' => (new DefaultPasswordHasher)->hash('password'),
				'private_key' => uniqid('rk.', true) . "." . uniqid('', true),
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			]		
		
		];
		
		parent::init();
	}
}