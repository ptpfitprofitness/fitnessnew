<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class CorporationBranch extends AppModel
	{
		public $name = 'CorporationBranch';
		public $useTable = 'corporation_branches';
		public $belongsTo = array(
        'Corporation' => array(
            'className' => 'Corporation',
            'foreignKey' => 'corporation_id'
        )
    );
            
		public $virtualFields = array('full_name' => 'CONCAT(CorporationBranch.first_name, " ",CorporationBranch.last_name)');
	
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
			'branch_name' => array(
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
						/*'Alphanumeric' => array('rule' => array('Alphanumeric'), 'last'=>true, 'message' =>'Please provide a valid value'),*/
						
					),
			'password' => array(
						'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),
					)
					
		);
		
	
	public function saveBranchData($data){
		
		if(!empty($data))
		{
			
			$this->save($data);
		}
	}
	
	
}
?>