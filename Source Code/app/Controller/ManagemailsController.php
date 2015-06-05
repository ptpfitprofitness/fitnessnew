<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		This file contains function for clubs
## *****************************************************************

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/members-controller.html
 */
	class ManagemailsController extends AppController {
		public $name 		= 'Managemails';
		public $helpers 	= array('Html','Session','Cksource');
		
		public $uses 		= array('Country','Member','Club','Trainer','Corporation','Trainee','CertificationOrganization','Certification','Degree','Page','Faq', 'Managemail');
		public $components  = array('Upload');			
	
	
		public function admin_add(){			
			
			if(!empty($this->data)) {
		
				$this->Managemail->set($this->data);
				if($this->Managemail->validates()) {
						
					    
					    $this->request->data["Managemail"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Managemail"]["modified_date"] 		= date("Y-m-d h:i:s");
						$this->request->data["Managemail"]["status"] 		= 1 ;
					    	
						if($this->Managemail->save($this->data)) {				
							$this->Session->setFlash('Mail has been Saved successfully.');
							$this->redirect('/admin/Managemails/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_view(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("ManagemailInfo",$this->Managemail->find("first",array("conditions"=>array("Managemail.id"=>$this->params["pass"][0]))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_edit($id = null)
		{
			
			
			if(!empty($this->data)){
			
			$this->Managemail->set($this->data);
			$this->Managemail->id = $this->data['Managemail']['id'];		
			
							
			if($this->Managemail->validates()) {
				
				
				$this->request->data["Managemail"]["modified_date"] 		    = date("Y-m-d h:i:s");
				if($this->Managemail->save($this->data)) {
					$this->Session->setFlash('Mails information has been updated successfully.');
					$this->redirect('/admin/Managemails/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
						
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Managemail->id = $id;
						$this->request->data = $this->Managemail->read();
					} else {
						$this->Session->setFlash('Invalid Mail id.');
						$this->redirect('/admin/Managemails/');
				}
			}	
		}
		
		public function admin_index($status = null)
		{	
			$conditions = array();
			$keyword 	= "";			
			if(!empty($this->data)){	
				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by content...") ) {					
					$conditions["OR"] = array(
												"Managemail.subject LIKE" => "%".$this->data["keyword"]."%",
												"Managemail.content LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['Managemail']['statusTop']) ) {
							$action = $this->data['Managemail']['statusTop'];
						}elseif( !empty($this->data['Managemail']['status'])) {
							$action = $this->data['Managemail']['status'];
						}
						
						if(isset($this->data['Managemail']['id']) && count($this->data['Managemail']['id']) > 0) {
							$this->update_status(trim($action), $this->data['Managemail']['id'], count($this->data['Managemail']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by content...') && $this->data["submit"]=='Search'){
								$this->Session->setFlash('Please enter keyword to perform search.');
							}
							else{
								$this->Session->setFlash('Please select any checkbox to perform any action.');
							}
						}
				}
			}
			
			if( !empty($this->params["named"]["keyword"]) ) {
				$conditions["OR"] = array(
									"Managemail.subject LIKE" => "%".$this->params["named"]["keyword"]."%",
									"Managemail.content LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Managemail.subject' => 'ASC'));
			
			$Managemails = $this->paginate('Managemail');	
			
			$this->set('Managemails', $Managemails);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['Managemail']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Managemail']['options']['page']);
			
		}
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Managemail->id = $ids[$ctr];
						$this->Managemail->saveField("status", '1');
					}
					$this->Session->setFlash('Mail(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Managemail->id = $ids[$ctr];
						$this->Faq->saveField("status", '0');
					}
					$this->Session->setFlash('Mail(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->Managemail->create();
						$this->Managemail->id = $ids[$i];
						
						$this->Managemail->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Mail(s) has been deleted successfully.');
					break;
			}
		}
		
		
	
	
		
		
	}