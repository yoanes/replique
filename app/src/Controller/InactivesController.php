<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\InternalErrorException;

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
			$user = $this->inactive->user;
			
			if($this->Inactives->delete($inactive)) {
				// Log user in automatically
				$this->Auth->setUser($user->toArray());
				
				// Ideally this will redirect to the login or index page. But since UI is not completed yet, 
				// we return 200 ok
				$this->returnOK('200');
			} else {
				$this->log("Failure in activating user account with token: $token.", "error");
				throw new InternalErrorException('Failure in activating user.');
			}
		}
	}
}