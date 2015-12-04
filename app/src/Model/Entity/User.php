<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;

class User extends Entity {
	
	private $pwdTokenSeparator = '-::-';
	
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
		return uniqid('rk.', true) . "." . uniqid('', true);
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
	
	public function generateResetPasswordToken() {
		if(!$this->isActive()) {
			return false;
		}
		
		$id = $this->id;
		$email = $this->email;
		$created = $this->created;
		$now = time();
		$SEP = $this->pwdTokenSeparator;
		$data = "$now$SEP$id$SEP$email$SEP$created"; 
		
		$cipher = Security::encrypt($data, $this->private_key);
		$token = urlencode(base64_encode($cipher));
		
		return $token;
	}
	
	public function validateResetPasswordToken($token = null) {
		if(empty($token)) {
			return false;
		}
		
		$cipher = base64_decode($token);
		$data = Security::decrypt($cipher, $this->private_key);

		if($data) {
			/* 0 is time
			 * 1 is user id
			 * 2 is email
			 * 3 is created date
			 */
			$datas = explode($this->pwdTokenSeparator, $data);
			
			return is_array($datas)
				&& $this->isPwdTokenLessThanADay($datas[0])
				&& $this->isPwdTokenContainsValidData($datas[1], $datas[2], $datas[3]);
		}
		
		return false;
	}
	
	private function isPwdTokenLessThanADay($tokenTimestamp) {
		return time() - $tokenTimestamp <= (24 * 60 * 60);
	}
	
	private function isPwdTokenContainsValidData($id, $email, $created) {
		return $this->id == $id && 
			   $this->email == $email && 
		       $this->created == $created;
	}
}