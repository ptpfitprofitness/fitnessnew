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
	class SubscriptionsController extends AppController {

		public $name 		= 'Subscriptions';
		public $helpers 	= array('Html','Session','Cksource');
		public $uses 		= array('Country','Member','Club','Trainer','Trainee','Subscription');
	
	
		public function admin_add(){
					
			
			if(!empty($this->data)) {
		
				$this->Subscription->set($this->data);
				if($this->Subscription->validates()) {
						
					    
					    $this->request->data["Subscription"]["added_date"] = date("Y-m-d h:i:s");
						$this->request->data["Subscription"]["status"] ='1';
					    	
						if($this->Subscription->save($this->data)) {				
							$this->Session->setFlash('Subscription has been created successfully.');
							$this->redirect('/admin/subscriptions/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_view(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("SubscriptionInfo",$this->Subscription->find("first",array("conditions"=>array("Subscription.id"=>$this->params["pass"][0]))));
				
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_edit($id = null)
		{
			
			
			
			if(!empty($this->data)){
			
			$this->Subscription->set($this->data);
			$this->Subscription->id = $this->data['Subscription']['id'];		
			
							
			if($this->Subscription->validates()) {
				
				
				
				if($this->Subscription->save($this->data)) {
					$this->Session->setFlash('Subscription has been updated successfully.');
					$this->redirect('/admin/subscriptions/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
							
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Subscription->id = $id;
						$this->request->data = $this->Subscription->read();
					} else {
						$this->Session->setFlash('Invalid Subscription id.');
						$this->redirect('/admin/subscriptions/');
				}
			}	
		}
		
		public function admin_index($status = null)
		{			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by Subscription Name...") ) {					
					$conditions["OR"] = array(
												"Subscription.plan_name LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['Subscription']['statusTop']) ) {
							$action = $this->data['Subscription']['statusTop'];
						}elseif( !empty($this->data['Subscription']['status'])) {
							$action = $this->data['Subscription']['status'];
						}
						
						if(isset($this->data['Subscription']['id']) && count($this->data['Subscription']['id']) > 0) {
							$this->update_status(trim($action), $this->data['Subscription']['id'], count($this->data['Subscription']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by Subscription Name...') && $this->data["submit"]=='Search'){
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
									"Subscription.plan_name LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Subscription.plan_name' => 'ASC'));
			$subscriptions = $this->paginate('Subscription'); //default take the current
			$this->set('subscriptions', $subscriptions);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['Subscription']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Subscription']['options']['page']);
		}
		
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Subscription->id = $ids[$ctr];
						$this->Subscription->saveField("status", '1');
					}
					$this->Session->setFlash('Subscription(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Subscription->id = $ids[$ctr];
						$this->Subscription->saveField("status", '0');
					}
					$this->Session->setFlash('Subscription(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->Subscription->create();
						$this->Subscription->id = $ids[$i];
						
						$this->Subscription->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Subscription(s) has been deleted successfully.');
					break;
			}
		}
		
		
		
	}