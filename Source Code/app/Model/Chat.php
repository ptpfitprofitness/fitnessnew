<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		24/05/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class Chat extends AppModel
	{
		public $name = 'Chat';
		public $useTable = 'chat';
		
            
		public $virtualFields = array('full_name' => 'Degree.name');
	
		public $validate = 
		array(
		
		/*'name' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Degree Name already in use')
						)*/
					
		);
		
	
	public function saveChatData($data){
		
		if(!empty($data))
		{
			
			$this->save($data);
		}
	}
	
	
}
?>