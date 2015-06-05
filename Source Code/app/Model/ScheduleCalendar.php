<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		19/03/2014
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************	
	class ScheduleCalendar extends AppModel
	{
		public $name = 'ScheduleCalendar';
		public $useTable = 'schedule_calendar';
		
            
		//public $virtualFields = array('full_name' => 'schedule_calendar.title');
	
		public $validate = 
		array(
		
		'title' => array(
							'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'This field is required'),							
							/*'unique'=>array('rule' => array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Organization Name already in use')*/
						)	
					
		);
		
	
	public function saveScheduleCalendarData($data){
		
		if(!empty($data))
		{
			
			$this->save($data);
		}
	}
	
	
}
?>