<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class Trainer extends AppModel
	{
		public $name = 'Trainer';
		public $hasAndBelongsToMany = array(
       
            'Trainee' =>
            array(
                'className' => 'Trainee',
                'joinTable' => 'trainee_trainers',
                'foreignKey' => 'trainerId',
                'associationForeignKey' => 'traineeId',
                'with' => 'TraineeTrainer'
            )
    );
		/*public $hasMany = array(
        'Certification' => array(
            'className' => 'Certification',
            'foreignKey' => 'certification_id'
        ),
        'CertificationOrganization'=>array(
        'className'=>'CertificationOrganization',
        'foreignKey'=>'certification_org_id'
        ),
        'Degree' => array(
            'className' => 'Degree',
            'foreignKey' => 'degree_id'
        ),
    );*/
		public $virtualFields = array('full_name' => 'CONCAT(Trainer.first_name, " ", Trainer.last_name)');
	
		public $validate = 
		array(
		'username' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Username address already in use')
						),
			'email' => array(
			'email'=>array( 
              'rule' => 'email', 
              'message' => 'Please provide a valid email address.' 
         ),
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Email address already in use')
						),
			'paypal_email' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Paypal Email address already in use')
						),
			'publicproname' => array(
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
						'Alphanumeric' => array('rule' => array('Alphanumeric'), 'last'=>true, 'message' =>'Please provide a valid value only Alphanumeric'),
						'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Public name already in use')
					),	
			'first_name' => array(
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
						'Alphanumeric' => array('rule' => array('Alphanumeric'), 'last'=>true, 'message' =>'Please provide a valid value')
					),
			'last_name' => array(
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
						'Alphanumeric' => array('rule' => array('Alphanumeric'), 'last'=>true, 'message' =>'Please provide a valid value')
					),							
			'session_price' => array(
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
			'logo' => array(							
						'required' => array('rule' => array('validateFile'), 'last'=>true, 'message' => 'This field is not valid'),		
			 		)
					
		);
		
	
	
	public function validateFile($value) 
	{		 
		 	$ext=array ('jpg','png','gif','bmp','jpeg','JPEG','JPG','PNG','GIF','BMP');		 
		    $build_img2="";	 
		   
		    if(is_array($value['logo']))
		    {	 
			     $build_img = $value['logo']['name'];
		    	 $build_img2= $build_img;
		    }
		    else {
		    	$build_img2=$value['logo'];
		    }
		    
		   if($build_img2!='') {	
				$extension = explode(".",$build_img2);
				$count     = count($extension);
				$count--;
				if(in_array(strtolower(trim($extension[$count])),$ext)) {					
					return true;
				}else{
					return false;
				}
			}else{				
				return true;				
			}
	}
	
	public function validate_passwords() {
		
    return $this->data[$this->alias]['password'] === $this->data[$this->alias]['con_password'];
}
	

	
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