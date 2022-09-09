<?php

class Roles extends AppModel {

	public $useTable = "roles";

	public $primaryKey = 'id';

	public $hasOne = array(

        'Users' => array(
            'className' => 'Users',
            'foreignKey' => 'id'
        )
    );
}