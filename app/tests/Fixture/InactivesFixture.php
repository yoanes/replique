<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class InactivesFixture extends TestFixture {

	public $connection = 'test';
	
	public $import = ['table' => 'inactives', 'connection' => 'default'];

	public function init() {
		$this->records = [
			[
				'user_id' => 1,
				'token' => 'abcdef12345'
			],
			[ 
				'user_id' => 2,
				'token' => 'invalid_token_nonexistent_user'
			]
		];

		parent::init();
	}
}