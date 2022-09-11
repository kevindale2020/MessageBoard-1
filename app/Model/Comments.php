<?php

class Comments extends AppModel {

	public $useTable = "comments";

	public $primaryKey = 'id';

	public $belongsTo = array(

        'Users' => array(
            'className' => 'Users',
            'foreignKey' => 'user_id'
        ),

        'Messages' => array(
            'className' => 'Messages',
            'foreignKey' => 'message_id'
        ),
    );
}