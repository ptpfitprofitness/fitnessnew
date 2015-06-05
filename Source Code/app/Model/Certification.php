<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		21/02/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class Certification extends AppModel
	{
		public $name = 'Certification';
		public $useTable = 'certifications';
		public $belongsTo = array(
        'CertificationOrganization' => array(
            'className' => 'CertificationOrganization',
            'foreignKey' => 'certi_orgaid'
        )
    );
            
		public $virtualFields = array('full_name' => 'Certification.course');
	
		public $validate = 
		array(
		
		'course' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Username address already in use')
						),
		'certi_orgaid' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required')
						)				
			
			
					
		);
		
	
	public function saveCertificationData($data){
		
		if(!empty($data))
		{
			
			$this->save($data);
		}
	}
	
	
}
?>