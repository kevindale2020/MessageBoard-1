<?php

class Messages extends AppModel {

	public $useTable = "messages";

	public $primaryKey = 'id';

	public $belongsTo = array(

        'Users' => array(
            'className' => 'Users',
            'foreignKey' => 'user_id'
        ),

        'Recipients' => array(
            'className' => 'Users',
            'foreignKey' => 'recipient'
        ),

        
        'Comments' => array(
           'className' => 'Comments',
           'foreignKey' => 'id'
        ),
    );
}