<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\InternalErrorException;

class InactivesController extends AppController {
	
	public function initialize() {
		parent::initialize();
		$this->Auth->allow('activate');
	}
	
	public function activate($token) {
		$inactive = $this->Inactives->findByToken($token);

		if(empty($inactive)) {
			$this->log("Token with value: $token is not found.", "info");
			throw new NotFoundException();
		}
		
		if($inactive->isValid()) {
			$user = $inactive->user;
			
			if($this->Inactives->delete($inactive)) {
				// Log user in automatically
				$this->Auth->setUser($user->toArray());
				return $this->redirect($this->homeUrl);
			} else {
				$this->log("Failure in activating user account with token: $token.", "error");
				throw new InternalErrorException('Failure in activating user.');
			}
		} else {
			$this->log("User with Token : $token is not found.", "info");
			throw new NotFoundException();
		}
	}
}