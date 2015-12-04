<?php

namespace App\Model\Table;

use ArrayObject;
use App\Model\Entity\User;
use App\Model\Entity\Inactive;
use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\ORM\Query;
use Cake\Validation\Validator;

class UsersTable extends Table {
	
	public function initialize(array $config) {
		$this->addBehavior('Timestamp');
		
		$this->hasOne('Inactives', [
			'foreignKey' => 'user_id',
			'dependent' => true
 		]);	
	}
	
	public function validationDefault(Validator $validator) {
		
		$validator
			->requirePresence('username', 'create')
			->notEmpty('username', 'This field cannot be empty.')
			->add('username', 'length', [
					'rule' => ['minLength', 6],
					'message' => __('Username has to be at least 6 characters long.')
			]);
		
		$validator
			->requirePresence('password', 'create')
			->notEmpty('password', 'This field cannot be empty.')
			->add('password', 'length', [
					'rule' => ['lengthBetween', 6, 40],
					'message' => __('Password has to be between 6 and 40 characters long.')
			]);
	
	    $validator 
	    	->requirePresence('passwordConfirmation', 'create')
	    	->notEmpty('passwordConfirmation', 'This field cannot be empty.')
	    	->add('passwordConfirmation', 'equalValue', [
	    			'rule' => ['compareWith', 'password'],
	    			'message' => __('Confirmation password doesn\'t match the given password.')
	    	]);
	    	
	    $validator
	    	->requirePresence('email', 'create')
	    	->notEmpty('email', 'This field cannot be empty.')
	    	->add('email', 'validFormat', [
	    			'rule' => ['email'],
	    			'message' => __('Email format is incorrect.')
	    	]);
	    	
		return $validator;
	}
	
	public function buildRules(RulesChecker $rules) {
		$rules->add($rules->isUnique(['email'], 'Supplied email already taken.'));
		$rules->add($rules->isUnique(['username'], 'Supplied username already taken.'));
		return $rules;
	}
	
	public function afterSave(Event $event, User $user, ArrayObject $options) {
		if($user->isNew()) {
			$inactive = new Inactive(['user_id' => $user->id]);
			$this->Inactives->save($inactive);
			# on save, populate user's inactive property
			$user->inactive = $inactive;
		}
		
		return true;
	}
	
	public function findByEmail($email = null) {
		if(empty($email)) {
			return null;
		}
		
		return $this->find()
		    		->where(['Users.email' => $email])
		    		->contain(['Inactives'])
		    		->first();
	}
	
	public function findAuth(Query $query, array $options) {
		$query
			->select(['id', 'username', 'password'])
			->contain(['Inactives'])
			->where(['Inactives.user_id IS' => NULL]);
			
		return $query;
	}
}