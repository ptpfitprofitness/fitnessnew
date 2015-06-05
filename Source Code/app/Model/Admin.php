<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************
	class Admin extends AppModel{
		public $name = 'Admin';
		
		public $validate = array(
		    'email' => array(
		        'rule' => array('email'),
		        'required' => true,
		        'last'=>true,
		        'message' => 'Invalid email address'
		        
		    ),
		    'old_password' => array(
				'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'Please enter current password.'),
			),
			'new_password' => array(
				'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'Please enter new password.'),
				'pass' => array('rule' => array('minLength', 6), 'last'=>true, 'message' => 'New password must have between 6-20 characters.')
			),
			'confirm_password' => array(
				'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'Please enter confirm password'),
				'pass' => array('rule' => array('equal','new_password'), 'last'=>true, 'message' => 'New password and confirm password should be same.')
			), 
		);
	}
?>
