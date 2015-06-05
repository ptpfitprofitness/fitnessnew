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
	class FaqsController extends AppController {

		public $name 		= 'Faqs';
		public $helpers 	= array('Html','Session','Cksource');
		
		public $uses 		= array('Country','Member','Club','Trainer','Corporation','Trainee','CertificationOrganization','Certification','Degree','Page','Faq');
		public $components  = array('Upload');			
		public $facebook;
		public $amazon;
	
		public function admin_add(){			
			
			if(!empty($this->data)) {
		
				$this->Faq->set($this->data);
				if($this->Faq->validates()) {
						
					    
					    $this->request->data["Faq"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Faq"]["modified_date"] 		= date("Y-m-d h:i:s");
						$this->request->data["Faq"]["status"] 		= 1 ;
					    	
						if($this->Faq->save($this->data)) {				
							$this->Session->setFlash('Faq has been created successfully.');
							$this->redirect('/admin/Faqs/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_view(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("faqInfo",$this->Faq->find("first",array("conditions"=>array("Faq.id"=>$this->params["pass"][0]))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_edit($id = null)
		{
			
			
			if(!empty($this->data)){
			
			$this->Faq->set($this->data);
			$this->Faq->id = $this->data['Faq']['id'];		
			
							
			if($this->Faq->validates()) {
				
				
				$this->request->data["Faq"]["modified_date"] 		    = date("Y-m-d h:i:s");
				if($this->Faq->save($this->data)) {
					$this->Session->setFlash('Faq information has been updated successfully.');
					$this->redirect('/admin/faqs/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
						
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Faq->id = $id;
						$this->request->data = $this->Faq->read();
					} else {
						$this->Session->setFlash('Invalid Faq id.');
						$this->redirect('/admin/faqs/');
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
												"Faq.questiom LIKE" => "%".$this->data["keyword"]."%",
												"Faq.answer LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['Faq']['statusTop']) ) {
							$action = $this->data['Faq']['statusTop'];
						}elseif( !empty($this->data['Faq']['status'])) {
							$action = $this->data['Faq']['status'];
						}
						
						if(isset($this->data['Faq']['id']) && count($this->data['Faq']['id']) > 0) {
							$this->update_status(trim($action), $this->data['Faq']['id'], count($this->data['Faq']['id']));
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
									"Faq.question LIKE" => "%".$this->params["named"]["keyword"]."%",
									"Faq.answer LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Faq.question' => 'ASC'));
			$faqs = $this->paginate('Faq'); //default take the current
			$this->set('faqs', $faqs);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['Faq']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Faq']['options']['page']);
		}
		
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Faq->id = $ids[$ctr];
						$this->Faq->saveField("status", '1');
					}
					$this->Session->setFlash('Faq(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Faq->id = $ids[$ctr];
						$this->Faq->saveField("status", '0');
					}
					$this->Session->setFlash('Faq(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->Faq->create();
						$this->Faq->id = $ids[$i];
						
						$this->Faq->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Faq(s) has been deleted successfully.');
					break;
			}
		}
		
		public function index(){
			$this->layout = "homelayout";
			if($this->Session->read('USER_ID'))
			{
			$dbusertype = $this->Session->read('UTYPE');					
		$this->set("dbusertype",$dbusertype);
		$uid = $this->Session->read('USER_ID');		
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
				$this->set("setSpecalistArr",$setSpecalistArr);
			}
			$this->set("faqInfo",$this->Faq->find("all",array("conditions"=>array("Faq.status"=>1))));	
		}
		
	
		
		
	}