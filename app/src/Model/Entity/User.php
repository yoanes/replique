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
	
	public function __construct($properties = [], $options = []) {
		if(!array_key_exists('private_key', $properties)) {
			$properties['private_key'] = $this->generateUserKey();
		}
	
		parent::__construct($properties, $options);
	}
	
	private function generateUserKey() {
		return uniqid('rk.', true);
	}
	
	public function hashPassword() {
		$this->setSalt();
		$salt = $this->salt;
		$password = $this->password;
		$this->password = md5("--$salt--$password--");
	}
	
	public function isActive() {
		return empty($this->inactive) ? true : false;
	}
}