<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		08/03/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class Nutritional extends AppModel
	{
		public $name = 'Nutritional';
		public $useTable = 'Nutritional';
		
		public $virtualFields = array('full_name' => 'Nutritional.guide_name');
	
		public $validate = 
		array(
		'guide_name' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							
						),
			
			'guide_file' => array(							
						'required' => array('rule' => array('validateFile'), 'last'=>true, 'message' => 'This field is not valid'),		
			 		)		
			
					
		);
		
	public function validateFile($value) 
	{		 
		 	$ext=array ('doc','docx','pdf','PDF');		 
		    $build_img2="";	 
		   
		    if(is_array($value['guide_file']))
		    {	 
			     $build_img = $value['guide_file']['name'];
		    	 $build_img2= $build_img;
		    }
		    else {
		    	$build_img2=$value['guide_file'];
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