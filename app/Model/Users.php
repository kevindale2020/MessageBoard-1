<?php

App::uses('AppModel', 'Model');


class Users extends AppModel {

	public $useTable = "users";

	public $primaryKey = 'id';

	// public $validate = array(

	// 	'name' => array(
	// 		'alphaNumeric' => array(
	// 			'rule' => 'alphaNumeric',
	// 			'required' => true,
	// 			'message' => 'Letters and numbers only'
	// 		),
	// 	)
	// );

	// public function beforeSave($options = array()) {

 //        if (isset($this->data['Users']['password'])) {
            
 //            $this->data['Users']['password'] = AuthComponent::password($this->data['Users']['password']);
 //        }
 //        return true;
 //    }

    public $belongsTo = array(

	    'Roles' => array(
	       'className' => 'Roles',
	       'foreignKey' => 'role_id'
	    )
  	);

  	 public $hasMany = array(

	    'Messages' => array(
	       'className' => 'Messages',
	       'foreignKey' => 'id'
	    )
  	);
}