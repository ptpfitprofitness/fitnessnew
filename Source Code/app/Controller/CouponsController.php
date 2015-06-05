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
	class CouponsController extends AppController {

		public $name 		= 'Coupons';
		public $helpers 	= array('Html','Session','Cksource');
		
		public $uses 		= array('Country','Member','Club','Trainer','Corporation','Trainee','CertificationOrganization','Certification','Degree','Page','Coupon');
		public $components  = array('Upload');			
		public $facebook;
		public $amazon;
	
		public function admin_add(){
		
			if(!empty($this->data)) {
					
				$this->Coupon->set($this->data);
				if($this->Coupon->validates()) {
						
					    $this->request->data["Coupon"]["start_date"] = date("Y-m-d h:i:s", strtotime($this->data["Coupon"]["start_date"]));
						
						$this->request->data["Coupon"]["expiry_date"] = date("Y-m-d h:i:s", strtotime($this->data["Coupon"]["expiry_date"]));
						
					    $this->request->data["Coupon"]["created_date"] = date("Y-m-d h:i:s");
						$this->request->data["Coupon"]["modified_date"]	= date("Y-m-d h:i:s");
						$this->request->data["Coupon"]["status"] = 1 ;
						
						$chktArr1=$this->Coupon->find("first",array("conditions"=>array("Coupon.coupon_name"=>$this->data["Coupon"]["coupon_name"])));

						$chktArr2=$this->Coupon->find("first",array("conditions"=>array("Coupon.coupon_code"=>$this->data["Coupon"]["coupon_code"])));
						
						if(empty($chktArr1) && empty($chktArr2)) 
						{				    	
							if($this->Coupon->save($this->data)) {				
								$this->Session->setFlash('Coupon has been created successfully.');
								$this->redirect('/admin/Coupons/');
							} else {
								$this->Session->setFlash('Some error has been occured. Please try again.');
							}
						}
						else
						{
							$this->Session->setFlash('Either Coupon Name or Coupon Code already exists. Please try again.');
							$this->redirect('/admin/Coupons/');
						}
				}	
			}
		}
		
		public function admin_view(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("couponInfo",$this->Coupon->find("first",array("conditions"=>array("Coupon.id"=>$this->params["pass"][0]))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_edit($id = null)
		{		
			
			if(!empty($this->data)){
			
			$this->Coupon->set($this->data);
			$this->Coupon->id = $this->data['Coupon']['id'];		
			
			
							
			if($this->Coupon->validates()) {
			
				$this->request->data["Coupon"]["start_date"] = date("Y-m-d h:i:s", strtotime($this->data["Coupon"]["start_date"]));
						
				$this->request->data["Coupon"]["expiry_date"] = date("Y-m-d h:i:s", strtotime($this->data["Coupon"]["expiry_date"]));
								
				$this->request->data["Coupon"]["modified_date"]	= date("Y-m-d h:i:s");
				
				$this->request->data["Coupon"]["status"] = $this->data["Coupon"]["status"] ;
								
				$chktArr1=$this->Coupon->find("all",array("conditions"=>array("Coupon.coupon_name"=>$this->data["Coupon"]["coupon_name"],"Coupon.id <>"=>$this->data["Coupon"]["id"])));

				$chktArr2=$this->Coupon->find("all",array("conditions"=>array("Coupon.coupon_code"=>$this->data["Coupon"]["coupon_code"],"Coupon.id <>"=>$this->data["Coupon"]["id"])));
				
				/*echo $this->data["Coupon"]["id"];
				print_r($chktArr2);
				print_r($chktArr1);
				die;*/
				if(count($chktArr1)==0 && count($chktArr2)==0)
				{
					if($this->Coupon->save($this->data)) {
						$this->Session->setFlash('Coupon information has been updated successfully.');
						$this->redirect('/admin/coupons/');
					} else {
						$this->Session->setFlash('Some error has been occured. Please try again.');
					}
				}
				else
				{
					$this->Session->setFlash('Either Coupon Name or Coupon Code already exists. Please try again.');
					$this->redirect('/admin/Coupons/');
				}
		
			}
						
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Coupon->id = $id;
						$this->request->data = $this->Coupon->read();
					} else {
						$this->Session->setFlash('Invalid Coupon id.');
						$this->redirect('/admin/coupons/');
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
												"Coupon.coupon_name LIKE" => "%".$this->data["keyword"]."%",
												"Coupon.coupon_code LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['Coupon']['statusTop']) ) {
							$action = $this->data['Coupon']['statusTop'];
						}elseif( !empty($this->data['Coupon']['status'])) {
							$action = $this->data['Coupon']['status'];
						}
						
						if(isset($this->data['Coupon']['id']) && count($this->data['Coupon']['id']) > 0) {
							$this->update_status(trim($action), $this->data['Coupon']['id'], count($this->data['Coupon']['id']));
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
									"Coupon.coupon_name LIKE" => "%".$this->params["named"]["keyword"]."%",
									"Coupon.coupon_code LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Coupon.coupon_name' => 'ASC'));
			
			$coupons = $this->paginate('Coupon'); //default take the current
			
			$this->set('coupons', $coupons);
		
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
		
			$this->set('limit', $this->params['request']['paging']['Coupon']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Coupon']['options']['page']);
		}
		
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Coupon->id = $ids[$ctr];
						$this->Coupon->saveField("status", '1');
					}
					$this->Session->setFlash('Coupon(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Coupon->id = $ids[$ctr];
						$this->Coupon->saveField("status", '0');
					}
					$this->Session->setFlash('Coupon(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->Coupon->create();
						$this->Coupon->id = $ids[$i];
						
						$this->Coupon->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Coupon(s) has been deleted successfully.');
					break;
			}
		}
		
		/*public function index(){
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
		}*/
		
	
		
		
	}