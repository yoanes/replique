<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController {
	
	public function initialize() {
		parent::initialize();
	}
	
	public function index() {
		$user = $this->Users->findByEmail('test@ccc6.com');
		
		var_dump($user->isActive());
	}
	
	public function register() {
		if($this->request->is('post')) {
			$newUser = $this->Users->newEntity();
			$newUser = $this->Users->patchEntity($newUser, $this->request->data);

			if($newUser->errors()) {
				$this->returnErrors($newUser, '400');
 				return;
			} 
			
			if($this->Users->save($newUser)) {
				$this->returnOK('201');
			} else {
				$this->log("Failed in creating new user: " . json_encode($newUser->errors()), 'error');
				$this->returnErrors($newUser);
			}	
		}
	}
	
	private function sendRegistrationEmail($email, $token) {
		$email = new Email('default');
		
		try {
			$email->from(['noreply@repliqueministry.org' => 'Replique Ministry Auto Reply'])
			      ->emailFormat('html')
			      ->to($email)
			      ->subjects('Welcome To Replique Ministry.')
			      ->template('welcomeContent')
			      ->viewVars(['token' => $token])
			      ->send();
			
			$this->log("Email sent to $email for new user registration.", 'info');
		} catch(Exception $e) {
			$this->log("User Registration failed to send confirmation email. Exceptions: " . $e->getMessage(), 'error');
		}
		
	}
}