<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class Coupon extends AppModel
	{
		public $name = 'Coupon';		
	
		public $validate = 
		array(
			'question' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							
						),
			'answer' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),														
						)
					
		);
	
}
?>