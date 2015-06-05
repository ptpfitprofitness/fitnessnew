<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		21/02/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class Degree extends AppModel
	{
		public $name = 'Degree';
		public $useTable = 'degrees';
		
            
		public $virtualFields = array('full_name' => 'Degree.name');
	
		public $validate = 
		array(
		
		'name' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Degree Name already in use')
						)
					
		);
		
	
	public function saveDegreeData($data){
		
		if(!empty($data))
		{
			
			$this->save($data);
		}
	}
	
	
}
?>