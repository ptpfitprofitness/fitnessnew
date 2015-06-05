<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		This file contains function for Trainers
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
	class FormsController extends AppController {

		public $name 		= 'Forms';
		public $components  = array('Upload','Email');		
		public $helpers 	= array('Html','Session','Cksource');
		public $uses 		= array('Country','Member','Club','Trainer','Trainee','Subscription','Form');
	
	
		public function admin_add(){
					
			
			if(!empty($this->data)) {
				$this->Form->set($this->data);
				if($this->Form->validates()) {
					    $this->request->data["Form"]["added_date"] = date("Y-m-d h:i:s");
						$this->request->data["Form"]["status"] ='1';
							if( !empty($this->data["Form"]["document"]) ) {
								
							$filename1 = time().'_'.$this->data["Form"]["document"]["name"];
							$target = $this->config["upload_form"];
							if($this->data["Form"]["document"]["tmp_name"]){
			move_uploaded_file($this->data["Form"]["document"]["tmp_name"], $target.$filename1);
							}
             $this->request->data["Form"]["document"] = $filename1;
             //die('here');
						}else{	
							
							unset($this->request->data["Form"]["document"]);
							$this->request->data["Form"]["document"] = '';							
					    }
					    	
						if($this->Form->save($this->data)) {				
							$this->Session->setFlash('Form has been Uploaded successfully.');
							$this->redirect('/admin/Forms/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_view(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("FormInfo",$this->Form->find("first",array("conditions"=>array("Form.id"=>$this->params["pass"][0]))));
				
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_edit($id = null)
		{
			
			
			
			if(!empty($this->data)){
			
			$this->Form->set($this->data);
			$this->Form->id = $this->data['Form']['id'];		
			/*pr($this->request->data);
							die('here');*/
			if($this->Form->validates()) {
				$filename1 = time().'_'.$this->request->data["Form"]["document"]["name"];
				$target = $this->config["upload_form"];
				if($this->request->data["Form"]["document"]["tmp_name"]){
				move_uploaded_file($this->request->data["Form"]["document"]["tmp_name"], $target.$filename1);
				}
				$this->request->data['Form']['document']=$filename1;
				if($this->request->data['Form']['document']['name'] && $this->request->data['Form']['old_doc'])
				{
					$picPath = $this->config["upload_form"].$this->request->data["Form"]["old_doc"];
					@unlink($picPath);
				}
				
				if($this->Form->save($this->request->data)) {
					$this->Session->setFlash('Form has been updated successfully.');
					$this->redirect('/admin/Forms/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
							
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Form->id = $id;
						$this->request->data = $this->Form->read();
					} else {
						$this->Session->setFlash('Invalid Form id.');
						$this->redirect('/admin/Forms/');
				}
			}	
		}
		
		public function admin_index($status = null)
		{			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by Form Title...") ) {					
					$conditions["OR"] = array(
												"Form.title LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['Form']['status'])) {
							$action = $this->data['Form']['status'];
						}
						
						if(isset($this->data['Form']['id']) && count($this->data['Form']['id']) > 0) {
							$this->update_status(trim($action), $this->data['Form']['id'], count($this->data['Form']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by Form title...') && $this->data["submit"]=='Search'){
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
									"Form.title LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Form.title' => 'ASC'));
			$forms = $this->paginate('Form'); //default take the current
			$this->set('forms', $forms);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['Form']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Form']['options']['page']);
		}
		
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Form->id = $ids[$ctr];
						$this->Form->saveField("status", '1');
					}
					$this->Session->setFlash('Form(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Form->id = $ids[$ctr];
						$this->Form->saveField("status", '0');
					}
					$this->Session->setFlash('Form(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->Form->create();
						$this->Form->id = $ids[$i];
						
						$this->Form->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Form(s) has been deleted successfully.');
					break;
			}
		}
		
		public function admin_duplicate($id = null)
		{
			
			
			
			if(!empty($this->data)){
			
			$this->Form->set($this->data);
			
			
							
			if($this->Form->validates()) {
				
				$this->Form->create();
				
				if($this->Form->save($this->data)) {
					$this->Session->setFlash('Duplicate of Form has been created successfully.');
					$this->redirect('/admin/Forms/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
							
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Form->id = $id;
						$this->request->data = $this->Form->read();
					} else {
						$this->Session->setFlash('Invalid Form id.');
						$this->redirect('/admin/Forms/');
				}
			}	
		}
		
		
		
	}