<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class Member extends AppModel
	{
		public $name = 'Member';
		public $virtualFields = array('full_name' => 'CONCAT(Member.first_name, " ", Member.last_name)');
	
		public $validate = 
		array(
			'email' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Email address already in use')
						),
			'username' => array(
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
						'Alphanumeric' => array('rule' => array('Alphanumeric'), 'last'=>true, 'message' =>'Please provide a valid value'),
						'unique'=>array('rule'=>array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Username already in use'),
					),
			'password' => array(
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
					),
			'picture' => array(							
						'required' => array('rule' => array('validateFile'), 'last'=>true, 'message' => 'This field is not valid'),		
			 		)
					
		);
		
	
	
	public function validateFile($value) 
	{		 
		 	$ext=array ('jpg','png','gif','bmp','jpeg','JPEG','JPG','PNG','GIF','BMP');		 
		    $build_img2="";	 
		   
		    if(is_array($value['picture']))
		    {	 
			     $build_img = $value['picture']['name'];
		    	 $build_img2= $build_img;
		    }
		    else {
		    	$build_img2=$value['picture'];
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
						if($v == "Zipcode")
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
				"city"=>"Zipcode",
				"email"=>"Email Address",
				"password"=>"*******",
				"Cpassword"=>"*******"
			);
	
	}
	
}
?>