<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		04/03/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class Package extends AppModel
	{
		public $name = 'Package';
		public $useTable = 'packages';
		public $belongsTo = array(
        'Trainer' => array(
            'className' => 'Trainer',
            'foreignKey' => 'trainer_id'
        )
    );
		public $virtualFields = array('full_name' => 'Package.package_name');
	
		public $validate = 
		array(
		'package_name' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							
						),
			'no_session' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							
						),
			'price' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
						),	
			'trainer_id' => array(
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
						
					),
			
					
		);
	
	
	
	
}
?>