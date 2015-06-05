<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class Corporation extends AppModel
	{
		public $name = 'Corporation';
		
		 public $hasMany = array(
        'Employee' => array(
            'className' => 'Employee',
           /* 'conditions' => array('Employee.approved' => '1'),
            'order' => 'Employee.created DESC'*/
        )
    );
	
		public $validate = 
		array(
		'username' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Username already in use')
						),
			'email' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Email address already in use')
						),
			'company_name' => array(
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
						/*'Alphanumeric' => array('rule' => array('Alphanumeric'), 'last'=>true, 'message' =>'Please provide a valid value'),*/
						
					),
						'password' => array(
			'length' => array(
        'rule'      => array('between', 8, 40),
        'message'   => 'Your password must be between 8 and 40 characters.',
    ),
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
					),
			'con_password' => array(
    'length' => array(
        'rule'      => array('between', 8, 40),
        'message'   => 'Your password must be between 8 and 40 characters.',
    ),
    'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
    'compare'    => array(
        'rule'      => array('validate_passwords'),
        'message' => 'The passwords you entered do not match.',
    )
),

					
		);
		
	
	
	
	

	
	function removeDefaults($data) {
	
		if(!empty($data)){
			foreach($data as $k=>$v) {
				switch($k){
					case'first_name':
						if($v == "First Name")
							$data[$k] = "";
					break;					
					case'last_name':
						if($v == "Last Name")
							$data[$k] = "";
					break;					
					case'email':
						if($v == "Email")
							$data[$k] = "";
					break;					
					case'city':
						if($v == "Zip")
							$data[$k] = "";
					break;										
					case'username':
						if($v == "Username")
							$data[$k] = "";
					break;					
					case'password':
						if($v == "*******")
							$data[$k] = "";
					break;				
					case'Cpassword':
						if($v == "*******")
							$data[$k] = "";
					break;				
				}
			}		
		}
		return $data;
	}
	
	function loadDefaults() {
	
		return array(	
				"first_name"=>"First Name",
				"last_name"=>"Last Name",
				"city"=>"City",
				"email"=>"Email Address",
				"password"=>"*******",
				"Cpassword"=>"*******"
			);
	
	}
	
}
?>