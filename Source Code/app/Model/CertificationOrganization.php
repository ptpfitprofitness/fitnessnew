<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		21/02/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class CertificationOrganization extends AppModel
	{
		public $name = 'CertificationOrganization';
		public $useTable = 'certification_organizations';
		
            
		public $virtualFields = array('full_name' => 'CertificationOrganization.name');
	
		public $validate = 
		array(
		
		'name' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Organization Name already in use')
						)	
					
		);
		
	
	public function saveCertificationOrgData($data){
		
		if(!empty($data))
		{
			
			$this->save($data);
		}
	}
	
	
}
?>