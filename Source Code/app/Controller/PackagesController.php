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
	class PackagesController extends AppController {

		public $name 		= 'Packages';
		public $helpers 	= array('Html','Session','Cksource');
		public $uses 		= array('Country','Member','Club','Trainer','CertificationOrganization','Certification','Degree','Package');
	
	
		public function admin_add(){
			
			
			$this->set("trainers",$this->Trainer->find('list',array('fields'=>array('Trainer.id','Trainer.username'))));	
			
		
			
			if(!empty($this->data)) {
		
				$this->Package->set($this->data);
				if($this->Package->validates()) {
						
					    
					    $this->request->data["Package"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Package"]["modification_date"] 		    = date("Y-m-d h:i:s");
					    	
						if($this->Package->save($this->data)) {				
							$this->Session->setFlash('Session Package has been created successfully.');
							$this->redirect('/admin/packages/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_view(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("packageInfo",$this->Package->find("first",array("conditions"=>array("Package.id"=>$this->params["pass"][0]))));
				
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_edit($id = null)
		{
			
			$this->set("trainers",$this->Trainer->find('list',array('fields'=>array('Trainer.id','Trainer.username'))));
			
			
			if(!empty($this->data)){
			
			$this->Package->set($this->data);
			$this->Package->id = $this->data['Package']['id'];		
			
							
			if($this->Package->validates()) {
				
				
				$this->request->data["Package"]["modified_date"] 		    = date("Y-m-d h:i:s");
				if($this->Package->save($this->data)) {
					$this->Session->setFlash('Session Package has been updated successfully.');
					$this->redirect('/admin/packages/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
							
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Package->id = $id;
						$this->request->data = $this->Package->read();
					} else {
						$this->Session->setFlash('Invalid Package id.');
						$this->redirect('/admin/packages/');
				}
			}	
		}
		
		public function admin_index($status = null)
		{			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by Package Name...") ) {					
					$conditions["OR"] = array(
												"Package.package_name LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['Package']['statusTop']) ) {
							$action = $this->data['Package']['statusTop'];
						}elseif( !empty($this->data['Package']['status'])) {
							$action = $this->data['Package']['status'];
						}
						
						if(isset($this->data['Package']['id']) && count($this->data['Package']['id']) > 0) {
							$this->update_status(trim($action), $this->data['Package']['id'], count($this->data['Package']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by Package Name...') && $this->data["submit"]=='Search'){
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
									"Package.package_name LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Package.package_name' => 'ASC'));
			$packages = $this->paginate('Package'); //default take the current
			$this->set('packages', $packages);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['Package']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Package']['options']['page']);
		}
		
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Package->id = $ids[$ctr];
						$this->Package->saveField("status", '1');
					}
					$this->Session->setFlash('Package(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Package->id = $ids[$ctr];
						$this->Package->saveField("status", '0');
					}
					$this->Session->setFlash('Package(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->Package->create();
						$this->Package->id = $ids[$i];
						
						$this->Package->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Package(s) has been deleted successfully.');
					break;
			}
		}
		
		
		
	}