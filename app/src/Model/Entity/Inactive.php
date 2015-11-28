<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Inactive extends Entity {
	
	private function setToken() {
		if(empty($this->token)) {
			$this->token = md5(uniqid('replique', true));
		}
	}
	
	public function __construct($userId) {
		parent::__construct();
		
		$this->user_id = $userId;
		$this->setToken();
	}
}