<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class InactivesTable extends Table {
	
	public function initialize(array $config) {	
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id'
		]);
	}
	
	public function findByToken($token) {
		if(empty($token)) {
			return null;
		}
		
		return $this->find()
		            ->where(['Inactives.token' => $token])
		            ->contain(['Users' => function($q) {
		            	return $q->select(['id', 'username']);
		            }])
		            ->first();
	}
}