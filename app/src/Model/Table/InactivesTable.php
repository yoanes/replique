<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class InactivesTable extends Table {
	
	public function initialize(array $config) {	
		$this->belongsTo('Users', [
				'foreignKey' => 'user_id'
		]);
	}
}