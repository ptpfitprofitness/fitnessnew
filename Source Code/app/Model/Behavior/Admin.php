<?php
	class Admin extends AppModel{
		public $name = 'Admin';
		
		public $validate = array(
		    'email' => array(
		        'rule' => 'email',
		        'required' => true,
		        'last'=>true,
		        'message' => 'Invalid Email Address'
		    )
		);
	}
?>
