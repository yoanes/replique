<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class User extends Entity {
	
	protected $_accessible = [
		'username' => true,
		'password' => true,
		'email' => true
	];
	
	public function __construct($properties = [], $options = []) {
		if(!array_key_exists('private_key', $properties)) {
			$properties['private_key'] = $this->generateUserKey();
		}
	
		parent::__construct($properties, $options);
	}
	
	private function generateUserKey() {
		return uniqid('rk.', true);
	}
	
	public function _setPassword($password) {
		if(!empty($password)) {
			return (new DefaultPasswordHasher)->hash($password);
		}
	}
	
	public function isActive() {
		return empty($this->inactive) ? true : false;
	}
	
	public function _getToken() {
		if(!$this->isActive()) {
			return $this->inactive->token;
		} 
		
		return null;
	}
}