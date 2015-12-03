<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Network\Exception\BadRequestException;

class UsersController extends AppController {
	
	public function initialize() {
		parent::initialize();
	}

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow('register');		
	}

// 	public function index() {
// 		$user = $this->Users->findByEmail('test@ccc6.com');
		
// 		var_dump($user->isActive());
// 	}
	
	public function register() {
		if($this->request->is('post')) {
			$newUser = $this->Users->newEntity();
			$newUser = $this->Users->patchEntity($newUser, $this->request->data);

			if($newUser->errors()) {
				$this->returnErrors($newUser, '400');
 				return;
			} 
			
			if($this->Users->save($newUser)) {
				$this->sendRegistrationEmail($newUser->email, $newUser->token, $newUser->username);
				$this->returnOK('201');
			} else {
				$this->log("Failed in creating new user: " . json_encode($newUser->errors()), 'error');
				$this->returnErrors($newUser, '400');
			}	
		}
	}
	
	private function sendRegistrationEmail($useremail, $token, $username) {
		$email = new Email('default');
		
		try {
			$email->from(['noreply@repliqueministry.org' => 'Replique Ministry Auto Reply'])
			      ->emailFormat('html')
			      ->to($useremail)
			      ->subject('Welcome To Replique Ministry.')
			      ->template('registration')
			      ->viewVars([
			      	'token' => $token,
			      	'username' => $username
			      ])
			      ->send();
			
			$this->log("Email sent to $useremail for new user registration.", 'info');
		} catch(Exception $e) {
			$this->log("User Registration failed to send confirmation email. Exceptions: " . $e->getMessage(), 'error');
		}
	}
	
	public function login($url) {
		if($this->request->is('post')) {
			$user = $this->Auth->identify();
			if($user) {
				$this->Auth->setUser($user);
				$this->returnOK();
			} else {
				throw new BadRequestException("Credential supplied is invalid.");
			}
		}
	}
}