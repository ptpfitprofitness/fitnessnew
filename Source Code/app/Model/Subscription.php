<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		15/07/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class Subscription extends AppModel
	{
		public $name = 'Subscription';
		public $useTable = 'subscriptions';
	/*	public $belongsTo = array(
        'Trainer' => array(
            'className' => 'Trainer',
            'foreignKey' => 'trainer_id'
        )
    );*/
		public $virtualFields = array('full_name' => 'Subscription.plan_name');
	
		public $validate = 
		array(
		'plan_name' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							
						),
			'plan_type' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							
						),
			'plan_cost' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
						),	
			'plan_for' => array(
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
						
					),
			
					
		);
	
	
	
	
}
?>