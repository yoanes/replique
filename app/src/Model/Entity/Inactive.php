<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Inactive extends Entity {
	
	private function generateToken() {
		return md5(uniqid('replique', true));
	}
	
	public function __construct($properties = [], $options = []) {
		if(!array_key_exists('token', $properties)) {
			$properties['token'] = $this->generateToken();
		}
		
		parent::__construct($properties, $options);
	}
	
	public function isValid() {
		return empty($this->user) ? false :
					$this->user->id == $this->user_id ? true : false;
	}
}