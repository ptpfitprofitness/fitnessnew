<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class ClubContact extends AppModel
	{
		public $name = 'ClubContact';
		public $useTable = 'club_contacts';
		public $belongsTo = array(
        'Club' => array(
            'className' => 'Club',
            'foreignKey' => 'club_id'
        )
    );
            
		//public $virtualFields = array('full_name' => 'CONCAT(ClubBranch.first_name, " ",ClubBranch.last_name)');
	
		public $validate = 
		array(
					
			'email' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Email address already in use')
						)
					
		);
		
	
	
	
	
}
?>