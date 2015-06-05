<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class CorporationContact extends AppModel
	{
		public $name = 'CorporationContact';
		public $useTable = 'corporation_contacts';
		public $belongsTo = array(
        'Corporation' => array(
            'className' => 'Corporation',
            'foreignKey' => 'corporation_id'
        )
    );
            
		public $validate = 
		array(
			'email' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Email address already in use')
						),
		);	
}
?>