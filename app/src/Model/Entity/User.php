<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class User extends Entity {
	
	protected $_accessible = [
		'username' => true,
		'password' => true,
		'email' => true
	];
	
	private function setSalt() {
		if(empty($this->salt)) {
			$this->salt = uniqid('', true);
		}
	}
	
	public function setKey() {
		if(empty($this->key)) {
			$this->userkey = uniqid('rk.', true);
		}
	}
	
	public function hashPassword() {
		$this->setSalt();
		$salt = $this->salt;
		$password = $this->password;
		$this->password = md5("--$salt--$password--");
	}
}