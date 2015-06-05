<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class Employee extends AppModel
	{
		public $name = 'Employee';
		public $hasOne = 'Trainee';
		public $useTable = 'employees';
		/*public $hasAndBelongsToMany = array(
        'Club' =>
            array(
                'className' => 'Club',
                'joinTable' => 'trainee_clubs',
                'foreignKey' => 'trainee_id',
                'associationForeignKey' => 'club_id',
                'with' => 'TraineeClub'
            ),
            'Trainer' =>
            array(
                'className' => 'Trainer',
                'joinTable' => 'trainee_trainers',
                'foreignKey' => 'traineeId',
                'associationForeignKey' => 'trainerId',
                'with' => 'TraineeTrainer'
            )
    );*/
    
		public $virtualFields = array('full_name' => 'CONCAT(Employee.first_name, " ", Employee.last_name)');
	
		public $validate = 
		array(
		'username' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Username address already in use')
						),
			'email' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Email address already in use')
						),
			'first_name' => array(
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
						'Alphanumeric' => array('rule' => array('Alphanumeric'), 'last'=>true, 'message' =>'Please provide a valid value')
					),
			'last_name' => array(
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
						'Alphanumeric' => array('rule' => array('Alphanumeric'), 'last'=>true, 'message' =>'Please provide a valid value')
					),							
			
			'password' => array(
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
					),
			
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
	

	
	
}
?>