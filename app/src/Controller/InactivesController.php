<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

class InactivesController extends AppController {
	
	public function initialize() {
		parent::initialize();
	}
	
	public function activate($token) {
		$inactive = $this->Inactives->findByToken($token);

		if(empty($inactive)) {
			$this->log("User with Token : $token is not found.", "info");
			throw new NotFoundException("Token not found.");
		}
		
		if($inactive->isValid()) {
			if($this->Inactives->delete($inactive)) {
			
				// Ideally this will redirect to the login or index page. But since UI is not completed yet, 
				// we return 200 ok
				$this->returnOK('200');
			} else {
				$this->log("Failure in activating user account with token: $token.", "error");
				$this->returnErrors($inactive);
			}
		}
	}
}