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
	class ClubsController extends AppController {

		public $name 		= 'Clubs';
		public $helpers 	= array('Html','Session','Cksource','Csv');
		public $uses 		= array('Country','Member','ClubBranch','Club','ClubContact','Trainer','Trainee','CertificationOrganization','Certification','Degree','Emessage','Subscription','MessageBoard', 'HelpGuide', 'Managemail', 'Payment', 'CertificationTrainers', 'ScheduleCalendar', 'Goal', 'WarmUps', 'CoreBalancePlyometric', 'SpeedAgilityQuickness', 'Resistence', 'CoolDown', 'Measurement', 'SessionPurchase', 'TraineesessionPurchase', 'ScdetailPopup', 'WorkOuts','Coupon');
		public $components  = array('Upload','Autharb');	
		public $facebook;
		public $amazon;
	
		public function admin_add(){
			
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
			
			if(!empty($this->data)) {
		
				$this->Club->set($this->data);
				if($this->Club->validates()) {
						if( !empty($this->data["Club"]["logo"]) ) {
							$filename = $this->data["Club"]["logo"]["name"];
							$target = $this->config["upload_path"];
							$this->Upload->upload($this->data["Club"]["logo"], $target, null, null);
  					        $this->request->data["Club"]["logo"] = $this->Upload->result; 					
						}else{	
							
							unset($this->request->data["Club"]["logo"]);
							$this->request->data["Club"]["logo"] = '';							
					    }
					    
					    $this->request->data["Club"]["username"]= $this->data["Club"]["email"];
					    $this->request->data["Club"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Club"]["modified_date"] 		    = date("Y-m-d h:i:s");
					    	//pr($this->request->data);
					    	//die('Here');
						if($this->Club->save($this->data)) {				
							$this->Session->setFlash('Club has been created successfully.');
							$this->redirect('/admin/clubs/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_view(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("clubInfo",$this->Club->find("first",array("conditions"=>array("Club.id"=>$this->params["pass"][0]))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_edit($id = null)
		{
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
			
			if(!empty($this->data)){
			
			$this->Club->set($this->data);
			$this->Club->id = $this->data['Club']['id'];		
			
							
			if($this->Club->validates()) {
				
				if(!empty($this->request->data["Club"]["logo"]["name"]))
				{
					$filename = $this->request->data["Club"]["logo"]["name"];
					$target = $this->config["upload_path"];
					$this->Upload->upload($this->data["Club"]["logo"], $target, null, null);
  					$this->request->data["Club"]["logo"] = $this->Upload->result; 
  					$picPath = $this->config["upload_path"].$this->request->data["Club"]["old_image"];
					@unlink($picPath);
				}else{	
					
					if(!empty($this->request->data["Club"]["old_image"])){
						$this->request->data["Club"]["logo"] = $this->request->data["Club"]["old_image"];			
					}
					else{
						$this->request->data["Club"]["logo"] = "";
					}
				}
				 $this->request->data["Club"]["username"]= $this->data["Club"]["email"];
				$this->request->data["Club"]["modified_date"] 		    = date("Y-m-d h:i:s");
				if($this->Club->save($this->data)) {
					$this->Session->setFlash('Club information has been updated successfully.');
					$this->redirect('/admin/clubs/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
				$this->request->data["Club"]["logo"]=$this->request->data["Club"]["old_image"];				
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Club->id = $id;
						$this->request->data = $this->Club->read();
					} else {
						$this->Session->setFlash('Invalid Club id.');
						$this->redirect('/admin/clubs/');
				}
			}	
		}
		
		public function admin_index($status = null)
		{			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by email or Club Name...") ) {					
					$conditions["OR"] = array(
												"Club.club_name LIKE" => "%".$this->data["keyword"]."%",
												"Club.email LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['Club']['statusTop']) ) {
							$action = $this->data['Club']['statusTop'];
						}elseif( !empty($this->data['Club']['status'])) {
							$action = $this->data['Club']['status'];
						}
						
						if(isset($this->data['Club']['id']) && count($this->data['Club']['id']) > 0) {
							$this->update_status(trim($action), $this->data['Club']['id'], count($this->data['Club']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by email or Club Name...') && $this->data["submit"]=='Search'){
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
									"Club.club_name LIKE" => "%".$this->params["named"]["keyword"]."%",
									"Club.email LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Club.club_name' => 'ASC'));
			$clubs = $this->paginate('Club'); //default take the current
			$this->set('clubs', $clubs);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['Club']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Club']['options']['page']);
		}
		
		public function index(){		
		//$this->checkUserLogin();
		$this->layout = "homelayout";		
		/*echo $this->Session->read('ClubBr');
		die();*/
		
		$dbusertype = $this->Session->read('UTYPE');					
		$this->set("dbusertype",$dbusertype);
		$uid = $this->Session->read('USER_ID');	

		if($this->Session->read('ClubBr')!='')
		{
			$uid8=$this->Session->read('ClubBr');
			$setSpecalistArr=$this->ClubBranch->find("first",array("conditions"=>array("ClubBranch.id"=>$uid8)));
		    $this->set("setSpecalistArr",$setSpecalistArr);
		    $this->set("setUser",'ClubBranch');
			
		}
		else {
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
		$this->set("setSpecalistArr",$setSpecalistArr);
		$this->set("setUser",$dbusertype);
		}
			
		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
		
		$this->set("SubscriptionInfo",$this->Subscription->find("all",array("conditions"=>array('OR' => array(
    array('Subscription.plan_for' => 'All'),
    array('Subscription.plan_for' => 'Club')),'Subscription.status'=>1))));		
	
		$checksubsplan=$this->Subscription->find("all",array("conditions"=>array("Subscription.status"=>1,"Subscription.plan_cost <>"=>0,'or' => array(
		array("Subscription.plan_for" => 'Club'),array("Subscription.plan_for" => 'All')))));		
		
		$this->set("checksubsplan",$checksubsplan);
		}
		
		public function subscription()
		{		
			$this->layout = "homelayout";		
			
			$dbusertype = $this->Session->read('UTYPE');					
			
			$this->set("dbusertype",$dbusertype);
			
			$uid = $this->Session->read('USER_ID');	

			if($this->Session->read('ClubBr')!='')
			{
				$uid8=$this->Session->read('ClubBr');
				
				$setSpecalistArr=$this->ClubBranch->find("first",array("conditions"=>array("ClubBranch.id"=>$uid8)));
				
				$this->set("setSpecalistArr",$setSpecalistArr);
				
				$this->set("setUser",'ClubBranch');			
			}
			else 
			{
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
				
				$this->set("setSpecalistArr",$setSpecalistArr);
				
				$this->set("setUser",$dbusertype);
			}
				
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
			
			$this->set("SubscriptionInfo",$this->Subscription->find("all",array("conditions"=>array('OR' => array(array('Subscription.plan_for' => 'All'),array('Subscription.plan_for' => 'Club')),'Subscription.status'=>1))));		
		}
		
		
		public function editprofile()
		{
			
			$this->checkUserLogin();
		    $this->layout = "homelayout";	
		    $this->set("leftcheck",'homeindex');
			$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('USER_ID');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		  $this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
		
			
			if(!empty($this->data)){
			
			$this->Club->set($this->data);
			$this->Club->id = $this->data['Club']['id'];		
			
							
			if($this->Club->validates()) {
				
				if(!empty($this->request->data["Club"]["website_logo"]["name"]))
				{
					$filename = $this->request->data["Club"]["website_logo"]["name"];
					$target = $this->config["upload_path"];
					$this->Upload->upload($this->data["Club"]["website_logo"], $target, null, null);
  					$this->request->data["Club"]["website_logo"] = $this->Upload->result; 					
  					$picPath = $this->config["upload_path"].$this->request->data["Club"]["old_image"];
					@unlink($picPath);
				}else{	
					
					if(!empty($this->request->data["Club"]["old_image"])){
						$this->request->data["Club"]["website_logo"] = $this->request->data["Club"]["old_image"];			
					}
					else{
						$this->request->data["Club"]["website_logo"] = "";
					}
				}
				$this->request->data["Club"]["username"] 		    = $this->data['Club']['email'];
				$this->request->data["Club"]["modified_date"] 		    = date("Y-m-d h:i:s");
				
				if($this->Club->save($this->data)) {
					$this->Session->setFlash('Club information has been updated successfully.');
					$this->redirect('/clubs/index/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
				$this->request->data["Club"]["website_logo"]=$this->request->data["Club"]["old_image"];				
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Club->id = $id;
						$this->request->data = $this->Club->read();
					} else {
						$this->Session->setFlash('Invalid Club id.');
						$this->redirect('/clubs/index/');
				}
			}
			
		}
		
		
		public function changepassclub()

		{
		    $this->layout = "homelayout";	
		    $this->set("leftcheck",'homeindex');
			$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('USER_ID');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
			$this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

			
			$this->Club->set($this->data);
			$this->Club->id = $this->data['Club']['id'];	
			$orig_pass = $this->Club->data['Club']['originalpassword'];
			$oldpassuser = $this->Club->data['Club']['oldpassword'];
			$new_pass = $this->Club->data['Club']['newpassword'];
			$conf_pass = $this->Club->data['Club']['conpassword'];
			
			
				 if( ($orig_pass==$oldpassuser) && ($new_pass==$conf_pass) )
					{
					$this->Club->query("update clubs set password = '".$new_pass."' where id='".$id."'");
					$this->Session->setFlash('Password updated successfully.');		
					$this->redirect('/clubs/index/');
					}
				else if($orig_pass!=$oldpassuser)
					{
						$this->Session->setFlash('Old Password is Incorrect.');
						$this->redirect('/clubs/editprofile/');
					}
				else if($new_pass!=$conf_pass)
					{
						$this->Session->setFlash('New Password and Confirm password not Match.');
						$this->redirect('/clubs/editprofile/');
					}
				else
				{
					$this->Session->setFlash('Some error.');
					$this->redirect('/clubs/editprofile/');
				}
		}
		
		
		
		
		
		
		public function helpguide(){
		
		$this->checkUserLogin();
		
		$this->layout = "homelayout";		
				
		$this->set("leftcheck",'helpguide');
		
		$dbusertype = $this->Session->read('UTYPE');					
		
		$this->set("dbusertype",$dbusertype);
		
		$uid = $this->Session->read('USER_ID');	
		
		
		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));			
				
		$this->set("videos",$this->HelpGuide->find('all',array('conditions'=>array('HelpGuide.user_type'=>array("Club","All")),'fields'=>array('HelpGuide.id','HelpGuide.doc_name','HelpGuide.description','HelpGuide.user_type'))));
		
		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);
	
}
		
		
		
		
		
		
		
		
		
		
		
		public function editprofiles()
		{
			
			
		    $this->layout = "homelayout";	
		    $this->set("leftcheck",'homeindex');
			$dbusertype='ClubBranch';				
			$this->set("dbusertype",'ClubBranch');
			$id = $this->Session->read('ClubBr');
			 $this->set("setUser",'ClubBranch');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		  $this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
		
			/*echo '<pre>';
			print_r($setSpecalistArr);
			echo '</pre>';
			die()*/;
		
			
			
			if(!empty($this->data)){
			
			$this->ClubBranch->set($this->data);
			$this->ClubBranch->id = $this->data['ClubBranch']['id'];		
			
							
			if($this->ClubBranch->validates()) {
				
				if(!empty($this->request->data["ClubBranch"]["logo"]["name"]))
				{
					$filename = $this->request->data["ClubBranch"]["logo"]["name"];
					$target = $this->config["upload_path"];
					$this->Upload->upload($this->data["ClubBranch"]["logo"], $target, null, null);
  					$this->request->data["ClubBranch"]["logo"] = $this->Upload->result; 
  					$picPath = $this->config["upload_path"].$this->request->data["ClubBranch"]["old_image"];
					@unlink($picPath);
				}else{	
					
					if(!empty($this->request->data["ClubBranch"]["old_image"])){
						$this->request->data["ClubBranch"]["logo"] = $this->request->data["ClubBranch"]["old_image"];			
					}
					else{
						$this->request->data["ClubBranch"]["logo"] = "";
					}
				}
				$this->request->data["ClubBranch"]["username"] = $this->data['ClubBranch']['email'];
				$this->request->data["ClubBranch"]["modified_date"] 		    = date("Y-m-d h:i:s");
				if($this->ClubBranch->save($this->data)) {
					$this->Session->setFlash('Club Branch information has been updated successfully.');
					$this->redirect('/clubs/index/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
				$this->request->data["ClubBranch"]["logo"]=$this->request->data["ClubBranch"]["old_image"];				
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->ClubBranch->id = $id;
						$this->request->data = $this->ClubBranch->read();
					} else {
						$this->Session->setFlash('Invalid Club Branch id.');
						$this->redirect('/clubs/index/');
				}
			}
			
		}
		
		
		
		
		
		public function changepass()

		{
		    $this->layout = "homelayout";	
		    $this->set("leftcheck",'homeindex');
			$dbusertype='ClubBranch';				
			$this->set("dbusertype",'ClubBranch');
			$id = $this->Session->read('ClubBr');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
			$this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

			
			$this->ClubBranch->set($this->data);
			$this->ClubBranch->id = $this->data['ClubBranch']['id'];	
			$orig_pass = $this->ClubBranch->data['ClubBranch']['originalpassword'];
			$oldpassuser = $this->ClubBranch->data['ClubBranch']['oldpassword'];
			$new_pass = $this->ClubBranch->data['ClubBranch']['newpassword'];
			$conf_pass = $this->ClubBranch->data['ClubBranch']['conpassword'];
			
			
				 if( ($orig_pass==$oldpassuser) && ($new_pass==$conf_pass) )
					{
					$this->Trainee->query("update club_branches set password = '".$new_pass."' where id='".$id."'");
					$this->Session->setFlash('Password updated successfully.');		
					$this->redirect('/clubs/index/');
					}
				else if($orig_pass!=$oldpassuser)
					{
						$this->Session->setFlash('Old Password is Incorrect.');
						$this->redirect('/clubs/editprofiles/');
					}
				else if($new_pass!=$conf_pass)
					{
						$this->Session->setFlash('New Password and Confirm password not Match.');
						$this->redirect('/clubs/editprofiles/');
					}
				else
				{
					$this->Session->setFlash('Some error.');
					$this->redirect('/clubs/editprofiles/');
				}
		}
		
		
		
		
		
		
		public function userfbstatus()
		{	
			$this->layout = "ajax";
			
			
			if($this->Session->read('ClubBr')!='')
			{
				$uid = $this->Session->read('ClubBr');
				$dbusertype = 'ClubBranch';					
			$this->set("dbusertype",$dbusertype);
			}else{
				$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			   $uid = $this->Session->read('USER_ID');
			}
			
			
			if(trim($_POST['userfb_status'])!='')
			{
			$this->request->data[$dbusertype]["userfb_status"]=$_POST['userfb_status'];
			$this->request->data[$dbusertype]["id"]=$_POST['id'];
			
			if($this->$dbusertype->save($this->data))
			{
				$this->set("data",'1');
			}
			else {
				$this->set("data",'2');
			}
			}else {
				$this->set("data",'2');
			}
			
			
		}
		public function userfbstatusget()
		{
			$this->layout = "ajax";
			
			if($this->Session->read('ClubBr')!='')
			{
				$uid = $this->Session->read('ClubBr');
				$dbusertype = 'ClubBranch';					
			$this->set("dbusertype",$dbusertype);
			}else{
				$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			   $uid = $this->Session->read('USER_ID');
			}
			$id=$_POST['id'];
			$setArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		  $this->set("setArr",$setArr);
		}
		
		
		
		public function deletetrainer()
		{
			$this->layout = '';
			$this->render = false;
			if(trim($_POST['id'])!='')
			{
				$datav=array();				
				$datav['id']=trim($_POST['id']);
				
				$trainerArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$datav['id'])));
				$this->set("setArr",$setArr);

				$clubArr=$this->Club->find("first",array("conditions"=>array("Club.id"=>$trainerArr['Trainer']['club_id'])));
				$this->set("clubArr",$clubArr);
				
				if ($datav['id']!='')
				{	
					$updated_trainer = $clubArr['Club']['no_trainer'] - 1;
					
					$this->Club->updateAll(array("Club.no_trainer"=>$updated_trainer),array("Club.id"=>$clubArr['Club']['id']));
								
					$this->Trainer->query("update trainers set trainer_type = 'I' ,club_id = NULL,club_branch_id = NULL where id='".$datav['id']."'");
					
					$this->send_delete_trainer_email_admin($trainerArr['Trainer']['first_name'],$trainerArr['Trainer']['last_name'],$trainerArr['Trainer']['email'],$clubArr['Club']['club_name'],$clubArr['Club']['email']);
					
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully Updated the Trainer Status");
				}				
				
			}
			else 
			{
				
				$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, please refresh the page and try again!!");
			}
			
			
				echo json_encode($response);
				exit;	
			
		}
		
		public function addtrainer()
		{
			 $this->layout = "homelayout";	
		    $this->set("leftcheck",'ctrainer');
		    
		    if($this->Session->read('ClubBr')!='')
		     {
               $this->set("setUser",'ClubBranch');
               $dbusertype ='ClubBranch';					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('ClubBr');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		  $this->set("setSpecalistArr",$setSpecalistArr);
               
		     } else {
		     	
		     	$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('USER_ID');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		  $this->set("setSpecalistArr",$setSpecalistArr);
		     	
		     }
		    
			$club_logo=$setSpecalistArr[$dbusertype]['website_logo'];
			
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
			
				$this->set("cert_org",$this->CertificationOrganization->find('list',array('fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));
			$this->set("certifications",$this->Certification->find('list',array('fields'=>array('Certification.id','Certification.course'))));
			
			$this->set("degrees",$this->Degree->find('list',array('fields'=>array('Degree.id','Degree.name'))));
			$this->set("cbranchs",$this->ClubBranch->find('list',array("conditions"=>array("ClubBranch.club_id"=>$id),'fields'=>array('ClubBranch.id','ClubBranch.branch_name'))));
			
			if(!empty($this->data)) {
		
				$this->Trainer->set($this->data);
				if($this->Trainer->validates()) {
						if( !empty($this->data["Trainer"]["logo"]) ) {
							$filename = $this->data["Trainer"]["logo"]["name"];
							$target = $this->config["upload_path"];
							$this->Upload->upload($this->data["Trainer"]["logo"], $target, null, null);
  					        $this->request->data["Trainer"]["logo"] = $this->Upload->result; 					
						}else{	
							
							unset($this->request->data["Trainer"]["logo"]);
							$this->request->data["Trainer"]["logo"] = '';							
					    }
					    
					    $this->request->data["Trainer"]["username"]  = $this->data["Trainer"]["email"];
					    $this->request->data["Trainer"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Trainer"]["modified_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Trainer"]["password"]= substr(md5(microtime()),rand(0,26),8);
						$this->request->data["Trainer"]["status"] 		    = 1;
						$this->request->data["Trainer"]["first_time_login"] = 0;
						$trainerdata['Trainer']['website_logo']=$setSpecalistArr['Club']['website_logo'];
					    	
						if($this->Trainer->save($this->data)) {
							
							$updated_trainer = $setSpecalistArr[$dbusertype]['no_trainer'] + 1;
					
							$this->$dbusertype->updateAll(array("$dbusertype.no_trainer"=>$updated_trainer),array("$dbusertype.id"=>$setSpecalistArr[$dbusertype]['id']));
							
							$user_names=trim($this->data["Trainer"]["first_name"]).' '.trim($this->data["Trainer"]["last_name"]);
							
							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
							
							if($club_logo!=''){

					$content.='<img width="150" height="130" src="'.$this->config['url'].'uploads/'.$club_logo.'"/>';

					}else {

					$content.='<img src="'.$this->config['url'].'images/logo.png"/>';

					}
							
							$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>
				<p>We are using software from� Personal Training Partners to better serve our clients.<br />
Please use your log in credentials below to access your account. Once you\'re logged in just click on �edit profile� to change your password.  </p>
				
				<p>
					Website URL: www.PTPFitPro.com <br />
					Username:'.trim($this->data["Trainer"]["email"]).'<br/>
				   Password:'.trim($this->data["Trainer"]["password"]).'<br/>
				   User Type: Trainer<br/>
				</p>
				<p>Here\'s the easiest way to get started.�</p>
				<p>Log into your account and:</p>
				<p>1. Create your public profile name (manage my account > edit my profile)<br/>
				2. Add all of your certifications (edit certifications button)<br/>
				3. Add your photo gallery, �bio and testimonials to your webpage (edit webpage button)<br/>
				4. Set up our session types/names (manage sessions > add sessions)<br/>
				5. Add or invite your clients (my clients > invite a client)<br/>
				6. Add purchased sessions for each of your clients (my clients > view client sessions > add sessions)<br/>
				7. Schedule your clients (scheduling calendar)<br />
				8. Build some workouts<br/><br/></p>
<p>View the <a href="http://www.ptpfitpro.com/home/helpguide">Help Guide Videos</a> for additional information on how site works.</p>
				</td></tr><tr><td><br/>Thanks,<br/>'.$setSpecalistArr[$dbusertype]['first_name'].' '.$setSpecalistArr[$dbusertype]['last_name'].'<br />
'.$setSpecalistArr[$dbusertype]['email'].'<br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
								
								$subject = "Credentials for new trainer software"; 
						  
						
							
								
									$this->sendEmailMessage($this->data["Trainer"]["email"],$subject,$content,null,null);
									
							$this->Session->setFlash('Trainer has been created successfully.');
							$this->redirect('/clubs/manage_trainer/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
			
		}
		
		public function invite_new_trainer()
		{
		  $this->layout = '';
			$this->render = false;
			
			if($this->Session->read('ClubBr')!='')
		     {
		     	 $dbusertype ='ClubBranch';					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('ClubBr');
		     }
		     else {
		     	 $dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('USER_ID');
		     	
		     }
			
		     	
		   
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		  $this->set("setSpecalistArr",$setSpecalistArr);
		  
		  $clubname='';
		  $club_logo='';
		  
		  if($dbusertype=='ClubBranch')
		  {
		  	 $clubname=$setSpecalistArr[$dbusertype]['branch_name'];
			 $clubownerfname=$setSpecalistArr[$dbusertype]['first_name'];
			 $clubowneremail=$setSpecalistArr[$dbusertype]['email'];
			 $clubownerlname=$setSpecalistArr[$dbusertype]['last_name'];
			 $club_logo=$setSpecalistArr[$dbusertype]['website_logo'];
		  }
		  else {
		  	$clubname=$setSpecalistArr[$dbusertype]['club_name'];
			$clubownerfname=$setSpecalistArr[$dbusertype]['first_name'];
			$clubowneremail=$setSpecalistArr[$dbusertype]['email'];
			$clubownerlname=$setSpecalistArr[$dbusertype]['last_name'];
			$club_logo=$setSpecalistArr[$dbusertype]['website_logo'];
		  }
		     	
		     
		     
			
			
				$trainerdata=array();
				$response=array();
				
			if( $_POST['firstname']!='' && $_POST['lastname']!='' && $_POST['email']!='' )
			{

				 $email=trim($_POST['email']);
                $expldv=explode("@",$email);
				$username=trim($expldv[0]);
				$password=substr(md5(microtime()),rand(0,26),8);
				$first_name=trim($_POST['firstname']);
				$last_name=trim($_POST['lastname']);
				
				//$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));
				
				$trainerdata['Trainer']['club_id']=trim($_POST['club_id']);
				$trainerdata['Trainer']['club_branch_id']=trim($id);
				$trainerdata['Trainer']['first_name']=trim($_POST['firstname']);
				$trainerdata['Trainer']['last_name']=trim($_POST['lastname']);
				$trainerdata['Trainer']['username']=trim($_POST['email']);
				$trainerdata['Trainer']['password']=trim($password);
				$trainerdata['Trainer']['email']=trim($_POST['email']);
				$trainerdata['Trainer']['trainer_type']='C';
				$trainerdata['Trainer']['status']=1;
				$trainerdata['Trainer']['first_time_login']=0;
				$trainerdata['Trainer']['added_date']=date('Y-m-d H:i:s');
				$trainerdata['Trainer']['modified_date']=date('Y-m-d H:i:s');
				$trainerdata['Trainer']['website_logo']=$setSpecalistArr['Club']['website_logo'];
				
				$chktArr1=$this->Trainer->find("first",array("conditions"=>array("Trainer.username"=>trim($username))));
				$chktArr2=$this->Trainer->find("first",array("conditions"=>array("Trainer.email"=>trim($_POST['email']))));
					if(empty($chktArr1) && empty($chktArr2)) {	
				
				if($this->Trainer->save($trainerdata)) {
					
					$updated_trainer = $setSpecalistArr[$dbusertype]['no_trainer'] + 1;
					
					$this->$dbusertype->updateAll(array("$dbusertype.no_trainer"=>$updated_trainer),array("$dbusertype.id"=>$setSpecalistArr[$dbusertype]['id']));
														
					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
					
					
					if($club_logo!=''){

					$content.='<img width="150" height="130" src="'.$this->config['url'].'uploads/'.$club_logo.'"/>';

					}else {

					$content.='<img src="'.$this->config['url'].'images/logo.png"/>';

					}
					
					
					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.trim($_POST['firstname']).'!</p>
				<p>We are using software from  Personal Training Partners to better serve your clients.<br />Please use your log in credentials below to access your account. Once you\'re logged in just click on �edit profile� to change your password.  </p>
				<p>Website URL: www.PTPFitPro.com <br />
					Username:'.trim($_POST['email']).'<br/>
				   Password:'.trim($password).'<br/>				  
				   Usertype: Trainer <br/>
				   
				</p>
				<p>Here\'s the easiest way to get started.</p>
				<p>Log into your account and:</p>
				<p>1. Create your public profile name (manage my account > edit my profile)<br/>
				2. Add all of your certifications (edit certifications button)<br/>
				3. Add your photo gallery, bio and testimonials to your webpage (edit webpage button)<br/>
				4. Set up our session types/names (manage sessions > add sessions)<br/>
				5. Add or invite your clients (my clients > invite a client)<br/>
				6. Add purchased sessions for each of your clients (my clients > view client sessions > add sessions)<br/>
				7. Schedule your clients (scheduling calendar)<br />
				8. Build some workouts<br/><br/></p>
				<p>View the <a href="http://www.ptpfitpro.com/home/helpguide">Help Guide Videos</a> for additional information on how site works.</p>
				</td></tr><tr><td><br/>Thanks,<br/>'.$clubownerfname.' '.$clubownerlname.' <br/>'.$clubowneremail.'<br /></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				
								
								$subject = "Credentials for new trainer software"; 
						  
						
							
								
									if($this->sendEmailMessage(trim($_POST['email']),$subject,$content,null,null))
									{
										$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have added Trainer successfully and Invite mail has been sent to trainer.");
									}	
									else {
										$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have added Trainer successfully and Invite mail has been sent to trainer.");
									}	
					
							
						}
						else {
							
							$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, please refresh the page and try again!!");
						}
					} else 
					{
						$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, email address or username already exist.");
					}
			}
			
			
		echo json_encode($response);
				exit;		
		}
		
		public function invite_new_trainee()
		{
		  $this->layout = '';
			$this->render = false;
			
			if($this->Session->read('ClubBr')!='')
		     {
		     	 $dbusertype ='ClubBranch';					
			     $this->set("dbusertype",$dbusertype);
			     $id = $this->Session->read('ClubBr');
		     }
		     else {
		     	 $dbusertype = $this->Session->read('UTYPE');					
			     $this->set("dbusertype",$dbusertype);
			     $id = $this->Session->read('USER_ID');
		     	
		     }
			
		     	
		   
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		  $this->set("setSpecalistArr",$setSpecalistArr);
		     	
		     $clubname='';
		  
		  if($dbusertype=='ClubBranch')
		  {
		  	 $clubname=$setSpecalistArr[$dbusertype]['branch_name'];
			 $club_logo=$setSpecalistArr[$dbusertype]['website_logo'];
		  }
		  else {
		  	$clubname=$setSpecalistArr[$dbusertype]['club_name'];
			$club_logo=$setSpecalistArr[$dbusertype]['website_logo'];
		  }
		     
			
			
				$traineedata=array();
				$response=array();
				
			if( $_POST['firstname']!='' && $_POST['lastname']!='' && $_POST['email']!='' )
			{

				 $email=trim($_POST['email']);
                $expldv=explode("@",$email);
				$username=$email;
				$password=substr(md5(microtime()),rand(0,26),8);
				$first_name=trim($_POST['firstname']);
				$last_name=trim($_POST['lastname']);
				
				//$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));
				
				$traineedata['Trainee']['club_id']=trim($_POST['club_id']);
				$traineedata['Trainee']['club_branch_id']=trim($id);
				$traineedata['Trainee']['first_name']=trim($first_name);
				$traineedata['Trainee']['last_name']=trim($last_name);
				$traineedata['Trainee']['username']=trim($username);
				$traineedata['Trainee']['password']=trim($password);
				$traineedata['Trainee']['email']=trim($_POST['email']);
				//$traineedata['Trainee']['trainer_type']='C';
				$traineedata['Trainee']['status']=1;
				$traineedata['Trainee']['created_date']=date('Y-m-d H:i:s');
				$traineedata['Trainee']['update_date']=date('Y-m-d H:i:s');
				
					
				$chktArr1=$this->Trainee->find("first",array("conditions"=>array("Trainee.username"=>trim($username))));
				$chktArr2=$this->Trainee->find("first",array("conditions"=>array("Trainee.email"=>trim($_POST['email']))));
					if(empty($chktArr1) && empty($chktArr2)) {		
				if($this->Trainee->save($traineedata)) {
					
					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
					
					if($club_logo!=''){

					$content.='<img width="150" height="130" src="'.$this->config['url'].'uploads/'.$club_logo.'"/>';

					}else {

					$content.='<img src="'.$this->config['url'].'images/logo.png"/>';

					}
								
								
				$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$first_name.'!</p>
				<p>I wanted to welcome you and invite you to use our training software to help us reach your fitness goals.</p>
				<p>You will be receiving another email shortly from your trainer with your log on credentials and information on how the site works.</p>
				<p>In the meantime, please let me know if there is anything I can do to make your training experience with us more effective and enjoyable.</p>
				</td></tr><tr><td><br/>Thanks,<br/>'.$setSpecalistArr[$dbusertype]['first_name'].' '.$setSpecalistArr[$dbusertype]['last_name'].'<br />'.$setSpecalistArr[$dbusertype]['email'].'<br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
								
								$subject = "Welcome"; 
						  
						
							
								
									if($this->sendEmailMessage(trim($_POST['email']),$subject,$content,null,null))
									{
										$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have added Client successfully and Invite mail has been sent to Client.");
									}else {
										$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have added Client successfully and Invite mail has been sent to Client.");
									}		
					
							
						}
						else {
							
							$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, please refresh the page and try again!!");
						}
					}
					else {
						$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, username or email already exist!!");
					}
			}
			
			
		echo json_encode($response);
				exit;		
		}
		
		public function traineredit($trid)
		{
			$trainer_id=base64_decode($trid);
			
			$this->layout = "homelayout";	
		    $this->set("leftcheck",'ctrainer');
		    
		    if($this->Session->read('ClubBr')!='')
		    {
                $this->set("setUser",'ClubBranch');
                
				$dbusertype ='ClubBranch';	
                
				$this->set("dbusertype",$dbusertype);
				
				$id = $this->Session->read('ClubBr');
				
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
				
				$this->set("setSpecalistArr",$setSpecalistArr);		
				
				$id=$setSpecalistArr['ClubBranch']['club_id'];
			  
				/* echo '<pre>';
				print_r($setSpecalistArr);
				echo '</pre>';
				die();*/
		     }
		     else 
			 {
				$dbusertype = $this->Session->read('UTYPE');					
			
				$this->set("dbusertype",$dbusertype);
			
				$id = $this->Session->read('USER_ID');
				
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
				
				$this->set("setSpecalistArr",$setSpecalistArr);
		     }
			
			$trid=base64_decode($trid);
			
			$this->set("trid",$trid);
			
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
			
			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));	
			
			//$this->set("cert_org",$this->CertificationOrganization->find('list',array('fields'=>array('CertificationOrganization.name','CertificationOrganization.name'))));
			
			$this->set("cert_org",$this->CertificationOrganization->find('list',array('fields'=>array('CertificationOrganization.name','CertificationOrganization.name'),'order'=>array('CertificationOrganization.name ASC'))));
			
			
			$this->set("certifications",$this->Certification->find('list',array('fields'=>array('Certification.course','Certification.course'),'order'=>array('Certification.course ASC'))));
			
			$this->set("cbranchs",$this->ClubBranch->find('list',array("conditions"=>array("ClubBranch.club_id"=>$id),'fields'=>array('ClubBranch.id','ClubBranch.branch_name'))));
			
			$this->set("degrees",$this->Degree->find('list',array('fields'=>array('Degree.id','Degree.name'))));				
			
			$tranrsdata=$this->CertificationTrainers->find('all',array('conditions'=>array('CertificationTrainers.trainer_id'=>$trainer_id)));
			
			$this->set("certificationstr",$tranrsdata);
			
			if(!empty($this->data))
			{
				$this->Trainer->set($this->data);
				$this->Trainer->id = $this->data['Trainer']['id'];		
				
				if($this->Trainer->validates()) 
				{
					if(!empty($this->request->data["Trainer"]["logo"]["name"]))
					{
						$filename = $this->request->data["Trainer"]["logo"]["name"];
						
						$target = $this->config["upload_path"];
						
						$this->Upload->upload($this->data["Trainer"]["logo"], $target, null, null);
  					
						$this->request->data["Trainer"]["logo"] = $this->Upload->result; 
						
						$picPath = $this->config["upload_path"].$this->request->data["Trainer"]["old_image"];
						
						@unlink($picPath);
					}
					else
					{	
						if(!empty($this->request->data["Trainer"]["old_image"]))
						{
							$this->request->data["Trainer"]["logo"] = $this->request->data["Trainer"]["old_image"];			
						}
						else
						{
							$this->request->data["Trainer"]["logo"] = "";
						}
				     }
					
					$this->request->data["Trainer"]["username"] = $this->data['Trainer']['email'];
					
					$this->request->data["Trainer"]["modified_date"] = date("Y-m-d h:i:s");
					
					/*echo $trainer_id;
					echo "<br />";
					echo $this->data['Trainer']['certification_no'];
					echo "<br />";
					echo $this->data['Trainer']['certification_org_id'];
					
					
					$data12["CertificationTrainers"]["trainer_id"] = $trainer_id;
					$data12["CertificationTrainers"]["certification_code"]=$this->data['Trainer']['certification_no'];
					$data12["CertificationTrainers"]["certification_org"]=$this->data['Trainer']['certification_org_id'];
					
					
					$this->CertificationTrainers->save($this->data12);*/
					
					$this->CertificationTrainers->query("insert certification_trainers set trainer_id = '".$trainer_id."',  certification_code = '".$this->data['Trainer']['certification_no']."', certification_org = '".$this->data['Trainer']['certification_org_id']."', certification_org1 = '".$this->data['Trainer']['certification_org1']."', certification_name = '".$this->data['Trainer']['certification_id']."', certification_name1 = '".$this->data['Trainer']['certification_name1']."'");
					
					
					
					if($this->Trainer->save($this->data)) 
					{
						$this->Session->setFlash('Trainer information has been updated successfully.');
						$this->redirect('/clubs/manage_trainer/');
					}
					else
					{
						$this->Session->setFlash('Some error has been occured. Please try again.');
					}
			    }
				else
				{				
					$this->request->data["Trainer"]["logo"]=$this->request->data["Trainer"]["old_image"];				
				}				
		    } 
			else
			{
				if(is_numeric($id) && $id > 0) 
				{
					$this->Trainer->id = $trid;
					$this->request->data = $this->Trainer->read();
				} 
				else
				{
					$this->Session->setFlash('Invalid Trainer id.');
					$this->redirect('/clubs/manage_trainer/');
				}
			}
		}
		
	public function manage_trainee()
		{
			$this->checkUserLogin();
			 $this->layout = "homelayout";	
		    $this->set("leftcheck",'homemy_clients');
		    
		     if($this->Session->read('ClubBr')!='')
		    {
		     $this->set("setUser",'ClubBranch');
			$dbusertype = 'ClubBranch';					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('ClubBr');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		  $this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
			
			//$tranrsdata=$this->Trainee->find('all',array('conditions'=>array('Trainee.club_branch_id'=>$id),'fields'=>array('Trainee.id','Trainee.full_name','Trainee.address','Trainee.email','Trainee.club_id','Trainee.club_branch_id','Trainee.trainer_id')));
			
			
			
			$tranrsdata = $this->Trainee->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'trainers',
                            'alias' => 'trainer',
                            'type' => 'LEFT',
                            'conditions' => array(
                            'Trainee.trainer_id = trainer.id'
                            )
                        ),
						array(
						'table' => 'club_branches',
						'alias' => 'club_branche',
						'type' => 'LEFT',
						'conditions' => array('Trainee.club_branch_id=club_branche.id')
						),
                    ),
                    'conditions' => array(
                        'Trainee.club_branch_id'=>$id),
                   
                    'fields' => array("Trainee.id","Trainee.full_name","Trainee.address","Trainee.email","Trainee.club_id","Trainee.club_branch_id","Trainee.trainer_id","trainer.first_name","trainer.last_name","club_branche.branch_name","club_branche.last_name","club_branche.first_name"),
                )    
                );
			
			
			
			
			$this->set("trainees",$tranrsdata);
		    } else {
		    	$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('USER_ID');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		  $this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
			
			/*$tranrsdata=$this->Trainee->find('all',array('conditions'=>array('Trainee.club_id'=>$id),'fields'=>array('Trainee.id','Trainee.full_name','Trainee.address','Trainee.email','Trainee.club_id','Trainee.club_branch_id','Trainee.trainer_id')));
			
			$this->set("trainees",$tranrsdata);*/
			
			
			
			
			$tranrsdata = $this->Trainee->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'trainers',
                            'alias' => 'trainer',
                            'type' => 'LEFT',
                            'conditions' => array(
                            'Trainee.trainer_id = trainer.id'
                            )
                        ),
						array(
						'table' => 'club_branches',
						'alias' => 'club_branche',
						'type' => 'LEFT',
						'conditions' => array('Trainee.club_branch_id=club_branche.id')
						),
                    ),
                    'conditions' => array(
                        'Trainee.club_id'=>$id),
                   
                    'fields' => array("Trainee.id","Trainee.full_name","Trainee.address","Trainee.email","Trainee.club_id","Trainee.club_branch_id","Trainee.trainer_id","trainer.first_name","trainer.last_name","club_branche.branch_name","club_branche.last_name","club_branche.first_name"),
                )    
                );
			$this->set("trainees",$tranrsdata);	
			
		    }
			
				
			
		}
		
		public function manage_branchs()
		{
		$this->checkUserLogin();
			$this->layout = "homelayout";	
		    $this->set("leftcheck",'homeindex');
			$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('USER_ID');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		    $this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
			$tranrsdata=$this->ClubBranch->find('all',array('conditions'=>array('ClubBranch.club_id'=>$id),'fields'=>array('ClubBranch.id','ClubBranch.branch_name','ClubBranch.email','ClubBranch.first_name','ClubBranch.last_name')));
			
			$this->set("branchs",$tranrsdata);
				
			
		}
		
		public function addbranch()
		{
			$this->layout = "homelayout";	
		    $this->set("leftcheck",'homeindex');
			$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('USER_ID');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		    $this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
			
						
			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));
			
			if(!empty($this->data)) {
		
				$this->ClubBranch->set($this->data);
				if($this->ClubBranch->validates()) {
						
					    
					    $this->request->data["ClubBranch"]["username"] 		    = $this->data['ClubBranch']['email'];
					    $this->request->data["ClubBranch"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["ClubBranch"]["modified_date"] 		= date("Y-m-d h:i:s");
						$this->request->data["ClubBranch"]["status"]= 1;
					    	//pr($this->request->data);
					    //$this->loadModel('ClubBranch');
					   
						if($this->ClubBranch->save($this->request->data)) {	
										
							$this->Session->setFlash('Branch has been created successfully.');
							$this->redirect('/clubs/manage_branchs/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
			
		}
		
		
		public function editbranch($bid = null)
		{
			$this->layout = "homelayout";	
		    $this->set("leftcheck",'homeindex');
			$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('USER_ID');
			$bid=base64_decode($bid);
			$this->set("bid",$bid);
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		    $this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));	
				
			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));
			
			if(!empty($this->data)){
			
			$this->ClubBranch->set($this->data);
			$this->ClubBranch->id = $this->data['ClubBranch']['id'];		
			
							
			if($this->ClubBranch->validates()) {
				
				
				$this->request->data["ClubBranch"]["username"] 		    = $this->data['ClubBranch']['email'];
				$this->request->data["ClubBranch"]["modified_date"] 		    = date("Y-m-d h:i:s");
				if($this->ClubBranch->save($this->data)) {
					$this->Session->setFlash('Branch information has been updated successfully.');
					$this->redirect('/clubs/manage_branchs/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
				//$this->request->data["Club"]["logo"]=$this->request->data["Club"]["old_image"];				
			}				
		 } else{
				if(is_numeric($bid) && $bid > 0) {
						$this->ClubBranch->id = $bid;
						$this->request->data = $this->ClubBranch->read();
					} else {
						$this->Session->setFlash('Invalid Branch id.');
						$this->redirect('/clubs/manage_branchs/');
				}
			}	
		}
		
		public function deletebranch()
		{
			$this->layout = '';
			$this->render = false;
			if(trim($_POST['id'])!='')
			{
				$datav=array();				
				$datav['id']=trim($_POST['id']);
				if($this->ClubBranch->delete($datav)) {
							
							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully deleted");
						}
						else {
							
							
							$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");
						}
			}
			else 
			{
				
				$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, please refresh the page and try again!!");
			}
			
			
				echo json_encode($response);
				exit;	
			
		}
		
	public function addclient()
		{
			 $this->layout = "homelayout";	
		  $this->set("leftcheck",'homemy_clients');
		    
		     if($this->Session->read('ClubBr')!='')
		    {
		     $this->set("setUser",'ClubBranch');
			$dbusertype = 'ClubBranch';					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('ClubBr');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		    $this->set("setSpecalistArr",$setSpecalistArr);
		    $id=$setSpecalistArr['ClubBranch']['club_id'];
			
		    }else{
			$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('USER_ID');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		  $this->set("setSpecalistArr",$setSpecalistArr);
		    }
			
			$club_logo=$setSpecalistArr[$dbusertype]['website_logo'];
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
			
				$this->set("trainers",$this->Trainer->find('list',array("conditions"=>array("Trainer.club_id"=>$id),'fields'=>array('Trainer.id','Trainer.full_name'))));
			$this->set("cbranchs",$this->ClubBranch->find('list',array("conditions"=>array("ClubBranch.club_id"=>$id),'fields'=>array('ClubBranch.id','ClubBranch.branch_name'))));
			
			if(!empty($this->data)) {
		
				$this->Trainee->set($this->data);
				if($this->Trainee->validates()) {
						if( !empty($this->data["Trainee"]["photo"]) ) {
							$filename = $this->data["Trainee"]["photo"]["name"];
							$target = $this->config["upload_path"];
							$this->Upload->upload($this->data["Trainee"]["photo"], $target, null, null);
  					        $this->request->data["Trainee"]["photo"] = $this->Upload->result; 					
						}else{	
							
							unset($this->request->data["Trainee"]["photo"]);
							$this->request->data["Trainee"]["photo"] = '';							
					    }
					    
					    $this->request->data["Trainee"]["username"] 		    = $this->data["Trainee"]["email"];
					    $this->request->data["Trainee"]["created_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Trainee"]["password"] = substr(md5(microtime()),rand(0,26),8);
						$this->request->data["Trainee"]["update_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Trainee"]["status"] 		    = 1;
						
						//echo $this->data["Trainee"]["trainer_id"];
						//die;
					    	$user_names=$this->data["Trainee"]["first_name"].' '.$this->data["Trainee"]["last_name"];
						if($this->Trainee->save($this->data)) {	
							
								$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
								
								if($club_logo!=''){

					$content.='<img width="150" height="130" src="'.$this->config['url'].'uploads/'.$club_logo.'"/>';

					}else {

					$content.='<img src="'.$this->config['url'].'images/logo.png"/>';

					}
								
								
								$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>
				<p>I wanted to welcome you and invite you to use our training software to help us reach your fitness goals.</p>
				<p>You will be receiving another email shortly from your trainer with your log on credentials and information on how the site works.</p>
				<p>In the meantime, please let me know if there is anything I can do to make your training experience with us more effective and enjoyable.</p>
				</td></tr><tr><td><br/>Thanks,<br/>'.$setSpecalistArr[$dbusertype]['first_name'].' '.$setSpecalistArr[$dbusertype]['last_name'].'<br />'.$setSpecalistArr[$dbusertype]['email'].'<br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
								
								$subject = "Welcome"; 
						  
						
							
								
									$this->sendEmailMessage($this->data["Trainee"]["email"],$subject,$content,null,null);
								
							
							
										
							$this->Session->setFlash('Client has been created successfully.');
							$this->redirect('/clubs/manage_trainee/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
			
		}
		
		/* function checkwktexist($workoutname, $newtrainer)
		{
			if($workoutname!='' && $newtrainer!='')
			{
				$workoutdata=$this->WorkOuts->find("first",array("conditions"=>array("WorkOuts.trainer_id"=>$newtrainer,"WorkOuts.workout_name"=>$workoutname)));
				if(!empty($workoutdata))
				{
					return 1;
				}
				else {
				return 2;	
				}		
			}
			else {
			return 3;	
			}
			//$rtval=$this->checkwktexist($trs['workout']['workout_name'],$new_trainerid);
		} */
		
		function checktsexist ($sessionid, $trainerid, $traineeid)
		{
			if($sessionid!='' && $trainerid!='' && $traineeid!='')
			{
				$traineedata=$this->TraineesessionPurchase->find("first",array("conditions"=>array("TraineesessionPurchase.SessTypeId"=>$sessionid,"TraineesessionPurchase.trainer_id"=>$trainerid, "TraineesessionPurchase.trainee_id"=>$traineeid)));
				if(!empty($traineedata))
				{
					return 1;
				}
				else {
				return 2;	
				}		
			}
			else {
			return 3;	
			}
			
		}
		
		public function editclient($trid)
		{
			$this->layout = "homelayout";	
		   $this->set("leftcheck",'homemy_clients');
		    $orig_trainerid=0;
		     if($this->Session->read('ClubBr')!='')
		    {
		     $this->set("setUser",'ClubBranch');
			$dbusertype = 'ClubBranch';					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('ClubBr');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		    $this->set("setSpecalistArr",$setSpecalistArr);
		    $id=$setSpecalistArr['ClubBranch']['club_id'];
		    }else{
			$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('USER_ID');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		    $this->set("setSpecalistArr",$setSpecalistArr);
		    }
			$trid=base64_decode($trid);
			$this->set("trid",$trid);
			
			
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));	
			
			$this->set("trainers",$this->Trainer->find('list',array("conditions"=>array("Trainer.club_id"=>$id),'fields'=>array('Trainer.id','Trainer.full_name'))));
			
			$this->set("cbranchs",$this->ClubBranch->find('list',array("conditions"=>array("ClubBranch.club_id"=>$id),'fields'=>array('ClubBranch.id','ClubBranch.branch_name'))));
			
			
			
			
					
			if(!empty($this->data)){
			
			$this->Trainee->set($this->data);
			$this->Trainee->id = $this->data['Trainee']['id'];		
							
			if($this->Trainee->validates()) {
			
			/****ORIGINAL DATA*****/
			$org_trainee_data=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$this->data['Trainee']['id'])));
			
			$this->set("org_trainee_data",$org_trainee_data);
			
			$orig_trainerid = $org_trainee_data["Trainee"]["trainer_id"];
					
			/****ORIGINAL DATA*****/
				
				if(!empty($this->request->data["Trainee"]["photo"]["name"]))
				{
					$filename = $this->request->data["Trainee"]["photo"]["name"];
					$target = $this->config["upload_path"];
					$this->Upload->upload($this->data["Trainee"]["photo"], $target, null, null);
  					$this->request->data["Trainee"]["photo"] = $this->Upload->result; 
  					$picPath = $this->config["upload_path"].$this->request->data["Trainee"]["old_image"];
					@unlink($picPath);
				}else{	
					
					if(!empty($this->request->data["Trainee"]["old_image"])){
						$this->request->data["Trainee"]["photo"] = $this->request->data["Trainee"]["old_image"];			
					}
					else{
						$this->request->data["Trainee"]["photo"] = "";
					}
				}
				$this->request->data["Trainee"]["username"] = $this->data['Trainee']['email'];
				$this->request->data["Trainee"]["update_date"] 		    = date("Y-m-d h:i:s");
				if($this->Trainee->save($this->data)) {
					$orig_trainerid = $org_trainee_data["Trainee"]["trainer_id"];
					$new_trainerid = $this->data["Trainee"]["trainer_id"];
					$newtrainer=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$orig_trainerid),'fields'=>array('Trainer.id','Trainer.full_name')));
					$this->set("newtrainer",$newtrainer);
					//echo "<pre>";print_r($newtrainer);echo "</pre>";
					$new_trainer_name = $newtrainer['Trainer']['full_name'];		
					$orig_trainerid;
					$org_traineeid = $this->data['Trainee']['id'];
									
					if ($new_trainerid == $orig_trainerid)
					{
						$this->Session->setFlash('Client information has been updated successfully.');
						$this->redirect('/clubs/manage_trainee/');
					}
					else
					{
						/*FIND DATA FROM TRAINEEPURCHASE ON BASIS OF OLDTRAINER ID AND CLIENT ID*/
								
						$trsp = $this->TraineesessionPurchase->find('all', array(
						'joins' => array(
							array(
							'table' => 'workouts',
							'alias' => 'workout',
							'type' => 'LEFT',
							'conditions' => array('TraineesessionPurchase.SessTypeId=workout.id')
							),
						 ),
						'conditions' => array(
                        'TraineesessionPurchase.trainee_id'=>$org_traineeid,
						'TraineesessionPurchase.trainer_id'=>$orig_trainerid),'fields' => array("TraineesessionPurchase.id","TraineesessionPurchase.SessTypeId","workout.workout_name","workout.workout_time","workout.workout_price","workout.added_date","workout.modified_date","workout.status","workout.id"),
						));
						
						$this->set("trsp",$trsp);
						//$last_wor_id=array();
						
											
						foreach($trsp as $trs)
						{											
							$last_wor_id = 0;
							
							$datads['WorkOuts']['trainer_id']=$new_trainerid;
							$datads['WorkOuts']['workout_name']=$new_trainer_name."_".$trs['workout']['workout_name'];
							$datads['WorkOuts']['workout_time']=$trs['workout']['workout_time'];
							$datads['WorkOuts']['workout_price']=$trs['workout']['workout_price'];
							$datads['WorkOuts']['added_date']=$trs['workout']['added_date'];
							$datads['WorkOuts']['modified_date']=$trs['workout']['modified_date'];
							$datads['WorkOuts']['status']=$trs['workout']['status'];
							$this->loadModel('WorkOuts');
							
							$this->WorkOuts->create();
							$this->WorkOuts->save($datads);
							
							//$last_wor_id[]=$this->WorkOuts->getLastInsertID();
							$last_wor_id=$this->WorkOuts->getLastInsertID();
							
						$this->TraineesessionPurchase->updateAll(
							array('TraineesessionPurchase.trainer_id' => "'$new_trainerid'",'TraineesessionPurchase.SessTypeId' => "'$last_wor_id'"),
							array('TraineesessionPurchase.trainee_id' => $org_traineeid, 'TraineesessionPurchase.trainer_id' => $orig_trainerid,'TraineesessionPurchase.SessTypeId' => $trs['workout']['id'])
						);
						$this->SessionPurchase->updateAll(
							array('SessionPurchase.trainer_id' => "'$new_trainerid'",'SessionPurchase.session_id' => "'$last_wor_id'"),
							array('SessionPurchase.client_id' => $org_traineeid, 'SessionPurchase.trainer_id' => $orig_trainerid,'SessionPurchase.session_id' => $trs['workout']['id'])
						);
						$new_sess_name = $new_trainer_name."_".$trs['workout']['workout_name'];
						$this->ScheduleCalendar->updateAll(
							array('ScheduleCalendar.trainer_id' => "'$new_trainerid'",'ScheduleCalendar.session_typeid' => "'$last_wor_id'",'ScheduleCalendar.session_type' => "'$new_sess_name'"),
							array('ScheduleCalendar.trainee_id' => $org_traineeid, 'ScheduleCalendar.trainer_id' => $orig_trainerid,'ScheduleCalendar.session_typeid' => $trs['workout']['id'])
						);
						$this->ScdetailPopup->updateAll(
							array('ScdetailPopup.trainer_id' => "'$new_trainerid'",'ScdetailPopup.session_id' => "'$last_wor_id'",'ScdetailPopup.session_type' => "'$new_sess_name'"),
							array('ScdetailPopup.trainee_id' => $org_traineeid, 'ScdetailPopup.trainer_id' => $orig_trainerid,'ScdetailPopup.session_id' => $trs['workout']['id'])
						);
							unset($last_wor_id);
						}
								
						
						//die('HEreBy RTA');
						/*FIND DATA FROM TRAINEEPURCHASE ON BASIS OF OLDTRAINER ID AND CLIENT ID*/
						
						$this->Trainee->query("update trainees set trainer_id = '".$new_trainerid."' where id='".$org_traineeid."' AND trainer_id='".$orig_trainerid."'");
						
						$this->TraineesessionPurchase->query("update traineesession_purchases set trainer_id = '".$new_trainerid."' where trainee_id='".$org_traineeid."' AND trainer_id='".$orig_trainerid."'");
															
						$this->SessionPurchase->query("update session_purchases set trainer_id = '".$new_trainerid."' where client_id='".$org_traineeid."' AND trainer_id='".$orig_trainerid."'");
						
						$this->ScdetailPopup->query("update scdetail_popups set trainer_id = '".$new_trainerid."' where trainee_id='".$org_traineeid."' AND trainer_id='".$orig_trainerid."'");
						
						$this->MessageBoard->query("update message_boards set trainer_id = '".$new_trainerid."' where client_id='".$org_traineeid."' AND trainer_id='".$orig_trainerid."'");
						
						$this->ScheduleCalendar->query("update schedule_calendar set trainer_id = '".$new_trainerid."' where trainee_id='".$org_traineeid."' AND trainer_id='".$orig_trainerid."'");
						
						$this->CoolDown->query("update cool_down set trainer_id = '".$new_trainerid."' where trainee_id='".$org_traineeid."' AND trainer_id='".$orig_trainerid."'");
						
						$this->CoreBalancePlyometric->query("update corebalance_plyometric set trainer_id = '".$new_trainerid."' where trainee_id='".$org_traineeid."' AND trainer_id='".$orig_trainerid."'");						
						
						$this->Goal->query("update goal set trainer_id = '".$new_trainerid."' where trainee_id='".$org_traineeid."' AND trainer_id='".$orig_trainerid."'");
						
						$this->Measurement->query("update measurements set trainer_id = '".$new_trainerid."' where trainee_id='".$org_traineeid."' AND trainer_id='".$orig_trainerid."'");
											
						$this->Resistence->query("update resistences set trainer_id = '".$new_trainerid."' where trainee_id='".$org_traineeid."' AND trainer_id='".$orig_trainerid."'");								
						$this->SpeedAgilityQuickness->query("update speedagility_quickness set trainer_id = '".$new_trainerid."' where trainee_id='".$org_traineeid."' AND trainer_id='".$orig_trainerid."'");
						
						$this->WarmUps->query("update warm_ups set trainer_id = '".$new_trainerid."' where trainee_id='".$org_traineeid."' AND trainer_id='".$orig_trainerid."'");
						
						/** EMESSAGES***/
						$this->Emessage->query("update emessages set sender_id = '".$new_trainerid."' where receiver_id='".$org_traineeid."' AND sender_id='".$orig_trainerid."'");
						
						$this->Emessage->query("update emessages set receiver_id = '".$new_trainerid."' where receiver_id='".$orig_trainerid."' AND sender_id='".$org_traineeid."'");
						
						$this->Session->setFlash('Client information has been updated successfully.');
						$this->redirect('/clubs/manage_trainee/');
					}
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
				$this->request->data["Trainee"]["photo"]=$this->request->data["Trainee"]["old_image"];				
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Trainee->id = $trid;
						$this->request->data = $this->Trainee->read();
					} else {
						$this->Session->setFlash('Invalid Client id.');
						$this->redirect('/clubs/manage_trainee/');
				}
			}
		}
		
		public function deleteclient()
		{
			$this->layout = '';
			$this->render = false;
			if(trim($_POST['id'])!='')
			{
				$datav=array();				
				$datav['id']=trim($_POST['id']);
				if($this->Trainee->delete($datav)) {
							
							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully deleted");
						}
						else {
							
							
							$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");
						}
			}
			else 
			{
				
				$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, please refresh the page and try again!!");
			}
			
			
				echo json_encode($response);
				exit;	
			
		}
		
		
		
		public function setstatus()
		{
			 $this->layout = '';
			 $this->render = false;
			 
			 $response = array();
			 
			 if(trim($_POST['id'])!='')
			 {

				$datav=array();				

				$datav['id']=trim($_POST['id']);
				$datav['status']=trim($_POST['st']);
				if($this->Trainer->save($datav)) {
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Status Successfully changed.");								}
				else {
					$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");				}
			 }
			else 
			{
				$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, please refresh the page and try again!!");
			}
				echo json_encode($response);

				exit;			 
		}
		
		public function manage_trainer()
		{
		$this->checkUserLogin();
			 $this->layout = "homelayout";	
		    $this->set("leftcheck",'homeindex');
		    if($this->Session->read('ClubBr')!='')
		    {
		     $this->set("setUser",'ClubBranch');
		    
		    
			$dbusertype = 'ClubBranch';					
			
			$this->set("dbusertype",$dbusertype);
			
			$id = $this->Session->read('ClubBr');
			
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
			
			$this->set("setSpecalistArr",$setSpecalistArr);
			
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
			
			/*$tranrsdata=$this->Trainer->find('all',array('conditions'=>array('Trainer.club_branch_id'=>$id,'Trainer.trainer_type'=>'C'),'fields'=>array('Trainer.id','Trainer.full_name','Trainer.address','Trainer.email','Trainer.club_branch_id')));
			
			$this->set("trainers",$tranrsdata);*/
								
			$tranrsdata = $this->Trainer->find('all', array(
                    'joins' => array(
                        array(
						'table' => 'club_branches',
						'alias' => 'club_branche',
						'type' => 'LEFT',
						'conditions' => array('Trainer.club_branch_id=club_branche.id')
						),
                    ),
                    'conditions' => array(
                        'Trainer.club_branch_id'=>$id,
						'Trainer.trainer_type'=>'C'),
                   
                    'fields' => array("Trainer.id","Trainer.full_name","Trainer.address","Trainer.email","Trainer.status","Trainer.club_branch_id","club_branche.branch_name","club_branche.last_name","club_branche.first_name"),
                )    
                );
			$this->set("trainers",$tranrsdata);	
			
		    }
		    else {
		    	$dbusertype = $this->Session->read('UTYPE');					
				
				$this->set("dbusertype",$dbusertype);
				
				$id = $this->Session->read('USER_ID');
				
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
			
				$this->set("setSpecalistArr",$setSpecalistArr);
				
				$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
			
				/*$tranrsdata=$this->Trainer->find('all',array('conditions'=>array('Trainer.club_id'=>$id,'Trainer.trainer_type'=>'C'),'fields'=>array('Trainer.id','Trainer.full_name','Trainer.address','Trainer.email','Trainer.club_branch_id')));		
				
				
				$this->set("trainers",$tranrsdata);*/
				
								
				$tranrsdata = $this->Trainer->find('all', array(
                    'joins' => array(
                        array(
						'table' => 'club_branches',
						'alias' => 'club_branche',
						'type' => 'LEFT',
						'conditions' => array('Trainer.club_branch_id=club_branche.id')
						),
                    ),
                    'conditions' => array(
                        'Trainer.club_id'=>$id,
						'Trainer.trainer_type'=>'C'),
                   
                    'fields' => array("Trainer.id","Trainer.full_name","Trainer.address","Trainer.email","Trainer.status","Trainer.club_branch_id","club_branche.branch_name","club_branche.last_name","club_branche.first_name"),
                )    
                );
			$this->set("trainers",$tranrsdata);	
			/*echo "<pre>";
			print_r($tranrsdata);
			echo "</pre>";*/
		    }
		    
		     
		    
		
				
			
		}
		
		
		
		public function active_trainer()
		{
			$this->checkUserLogin();
			$this->layout = "homelayout";	
		    $this->set("leftcheck",'homeindex');
		    if($this->Session->read('ClubBr')!='')
		    {
				$this->set("setUser",'ClubBranch');
		      
				$dbusertype = 'ClubBranch';					
			
				$this->set("dbusertype",$dbusertype);
			
				$id = $this->Session->read('ClubBr');
			
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
			
				$this->set("setSpecalistArr",$setSpecalistArr);
			
				$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));						
					
				$tranrsdata = $this->Trainer->find('all', array(
                    'joins' => array(
                        array(
						'table' => 'club_branches',
						'alias' => 'club_branche',
						'type' => 'LEFT',
						'conditions' => array('Trainer.club_branch_id=club_branche.id')
						),
                    ),
                    'conditions' => array(
                        'Trainer.club_branch_id'=>$id,
						'Trainer.trainer_type'=>'C',
						'Trainer.status'=>1),
                   
                    'fields' => array("Trainer.id","Trainer.full_name","Trainer.address","Trainer.email","Trainer.status","Trainer.club_branch_id","club_branche.branch_name","club_branche.last_name","club_branche.first_name"),
                )    
                );
				$this->set("trainers",$tranrsdata);				
		    }
			else 
			{
				$dbusertype = $this->Session->read('UTYPE');					
				
				$this->set("dbusertype",$dbusertype);
				
				$id = $this->Session->read('USER_ID');
				
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
			
				$this->set("setSpecalistArr",$setSpecalistArr);
				
				$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
											
				$tranrsdata = $this->Trainer->find('all', array(
                    'joins' => array(
                        array(
						'table' => 'club_branches',
						'alias' => 'club_branche',
						'type' => 'LEFT',
						'conditions' => array('Trainer.club_branch_id=club_branche.id')
						),
                    ),
                    'conditions' => array(
                        'Trainer.club_id'=>$id,
						'Trainer.trainer_type'=>'C',
						'Trainer.status'=>1),
                   
                    'fields' => array("Trainer.id","Trainer.full_name","Trainer.address","Trainer.email","Trainer.status","Trainer.club_branch_id","club_branche.branch_name","club_branche.last_name","club_branche.first_name"),
                )    
                );
				$this->set("trainers",$tranrsdata);				
		    }
		}
		
		public function in_active_trainer()
		{
			$this->checkUserLogin();
			$this->layout = "homelayout";	
		    $this->set("leftcheck",'homeindex');
		    if($this->Session->read('ClubBr')!='')
		    {
				$this->set("setUser",'ClubBranch');
		      
				$dbusertype = 'ClubBranch';					
			
				$this->set("dbusertype",$dbusertype);
			
				$id = $this->Session->read('ClubBr');
			
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
			
				$this->set("setSpecalistArr",$setSpecalistArr);
			
				$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));						
					
				$tranrsdata = $this->Trainer->find('all', array(
                    'joins' => array(
                        array(
						'table' => 'club_branches',
						'alias' => 'club_branche',
						'type' => 'LEFT',
						'conditions' => array('Trainer.club_branch_id=club_branche.id')
						),
                    ),
                    'conditions' => array(
                        'Trainer.club_branch_id'=>$id,
						'Trainer.trainer_type'=>'C',
						'Trainer.status'=>0),
                   
                    'fields' => array("Trainer.id","Trainer.full_name","Trainer.address","Trainer.email","Trainer.status","Trainer.club_branch_id","club_branche.branch_name","club_branche.last_name","club_branche.first_name"),
                )    
                );
				$this->set("trainers",$tranrsdata);				
		    }
			else 
			{
				$dbusertype = $this->Session->read('UTYPE');					
				
				$this->set("dbusertype",$dbusertype);
				
				$id = $this->Session->read('USER_ID');
				
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
			
				$this->set("setSpecalistArr",$setSpecalistArr);
				
				$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
											
				$tranrsdata = $this->Trainer->find('all', array(
                    'joins' => array(
                        array(
						'table' => 'club_branches',
						'alias' => 'club_branche',
						'type' => 'LEFT',
						'conditions' => array('Trainer.club_branch_id=club_branche.id')
						),
                    ),
                    'conditions' => array(
                        'Trainer.club_id'=>$id,
						'Trainer.trainer_type'=>'C',
						'Trainer.status'=>0),
                   
                    'fields' => array("Trainer.id","Trainer.full_name","Trainer.address","Trainer.email","Trainer.status","Trainer.club_branch_id","club_branche.branch_name","club_branche.last_name","club_branche.first_name"),
                )    
                );
				$this->set("trainers",$tranrsdata);				
		    }
		}
		
		
		
		
		 public function uploadpic()
		{
			
		    $this->layout = "homelayout";	
			$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('USER_ID');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		    $this->set("setSpecalistArr",$setSpecalistArr);
		    
		    if(!empty($this->data)){
		    $this->Club->set($this->data);
			$this->Club->id = $id;	
			
			  if(!empty($this->request->data["Club"]["logo"]["name"]))
				{
					
					$filename = $this->request->data["Club"]["logo"]["name"];
					$target = $this->config["upload_path"];
					$this->Upload->upload($this->data["Club"]["logo"], $target, null, null);
  					$this->request->data["Club"]["logo"] = $this->Upload->result; 
  					$picPath = $this->config["upload_path"].$this->request->data["Club"]["old_image"];
					@unlink($picPath);
					$this->request->data["Club"]["modified_date"] 		    = date("Y-m-d h:i:s");
					$this->request->data["Club"]["id"] 		    = $id;
					if($this->Club->save($this->data)) {
					$this->Session->setFlash('Club information has been updated successfully.');
					$this->redirect($_SERVER["HTTP_REFERER"]);	
					} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
					$this->redirect($_SERVER["HTTP_REFERER"]);	
					}
				}
			
				
		    }
		    $this->redirect($_SERVER["HTTP_REFERER"]);	
		}
		
		public function uploadpicbr()
		{
			
		    $this->layout = "homelayout";	
			$dbusertype = 'ClubBranch';					
			$this->set("dbusertype",$dbusertype);
			
			//$uid8=$this->Session->read('ClubBr');
			
			$id = $this->Session->read('ClubBr');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		    $this->set("setSpecalistArr",$setSpecalistArr);
		    
		    if(!empty($this->data)){
		    
			$this->ClubBranch->id = $id;	
			
			  if(!empty($this->request->data["Club"]["logo"]["name"]))
				{
					
					$filename = $this->request->data["Club"]["logo"]["name"];
					$target = $this->config["upload_path"];
					$this->Upload->upload($this->data["Club"]["logo"], $target, null, null);
  					$this->request->data["ClubBranch"]["logo"] = $this->Upload->result; 
  					$picPath = $this->config["upload_path"].$this->request->data["Club"]["old_image"];
					@unlink($picPath);
					$this->request->data["ClubBranch"]["modified_date"] 		    = date("Y-m-d h:i:s");
					$this->request->data["ClubBranch"]["id"] 		    = $id;
					if($this->ClubBranch->save($this->data)) {
					$this->Session->setFlash('Club Branch information has been updated successfully.');
					$this->redirect($_SERVER["HTTP_REFERER"]);	
					} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
					$this->redirect($_SERVER["HTTP_REFERER"]);	
					}
				}
			
				
		    }
		    $this->redirect($_SERVER["HTTP_REFERER"]);	
		}
		
		public function coverpicbr()
		{
			$this->checkUserLogin();
		    $this->layout = "homelayout";	
			$dbusertype ='ClubBranch';					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('ClubBr');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		    $this->set("setSpecalistArr",$setSpecalistArr);
		    
		    if(!empty($this->data)){
		   
			$this->$dbusertype->id = $id;	
			
			  if(!empty($this->request->data["Club"]["cpic"]["name"]))
				{
					$filename = $this->request->data["Club"]["cpic"]["name"];
					$target = $this->config["upload_path"];
					$this->Upload->upload($this->data["Club"]["cpic"], $target, null, null);
  					$this->request->data["ClubBranch"]["cpic"] = $this->Upload->result; 
  					$picPath = $this->config["upload_path"].$this->request->data["Club"]["old_covimage"];
					@unlink($picPath);
					
					$this->request->data["$dbusertype"]["id"] 		    = $id;
					if($this->$dbusertype->save($this->data)) {
					$this->Session->setFlash("$dbusertype information has been updated successfully.");
					$this->redirect($_SERVER["HTTP_REFERER"]);	
					} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
					$this->redirect($_SERVER["HTTP_REFERER"]);	
					}
				}
			
				
		    }
		    $this->redirect($_SERVER["HTTP_REFERER"]);	
		}
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Club->id = $ids[$ctr];
						$this->Club->saveField("status", '1');
					}
					$this->Session->setFlash('Club(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Club->id = $ids[$ctr];
						$this->Club->saveField("status", '0');
					}
					$this->Session->setFlash('Club(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						
						$this->Club->create();
						
						$this->Club->id = $ids[$i];	

						$clubdeldata=$this->Club->find('first',array('conditions'=>array('Club.id'=>$ids[$i]),'fields'=>array('Club.email','Club.id','Club.first_name')));		
						
						$this->set("clubdeldata",$clubdeldata);
						
						
						
						$assTrainerdata=$this->Trainer->find('all',array('conditions'=>array('Trainer.club_id'=>$ids[$i]),'fields'=>array('Trainer.id','Trainer.first_name','Trainer.email','Trainer.added_date')));
						
						$this->set("assTrainerdata",$assTrainerdata);
						/*echo "<pre>";
						print_r($assTrainerdata);
						echo "</pre>";*/
						
						
						$clubcancel_date = date('Y-m-d H:i:s');
						
						$trainer_list = NULL;
						
						foreach($assTrainerdata as $assTrainer){
						
						$trainer_list .= $prefix . '' . $assTrainer['Trainer']['email'] . '';
						$prefix = ', ';
						$this->Trainer->query("update trainers set club_id=NULL,trainer_type='I',subscriptionplan=NULL ,club_cancel_date='".$clubcancel_date."',club_cancel_status=1 where id='".$assTrainer['Trainer']['id']."' AND club_id='".$clubdeldata['Club']['id']."'");
						}
						
						
						
						
						//$this->send_mail_to_club($clubdeldata['Club']['email'],$clubdeldata['Club']['first_name']);
						
						//$this->send_mail_to_admin($clubdeldata['Club']['email'],$clubdeldata['Club']['first_name'],$trainer_list);
						
						$this->send_mail_to_admin($clubdeldata['Club']['email'],$clubdeldata['Club']['first_name'],$clubdeldata['Club']['club_name'],$trainer_list);
						
						$this->Club->delete($ids[$i]);
					}
					$this->Session->setFlash('Club(s) has been deleted successfully.');
					break;
				case "unassigntrainer":
					for($i=0;$i<$count;$i++){
						$this->Club->create();
						$this->Club->id = $ids[$i];								
						
						$clubdeldata=$this->Club->find('first',array('conditions'=>array('Club.id'=>$ids[$i]),'fields'=>array('Club.email','Club.id','Club.first_name','Club.club_name')));
		
						
						$this->set("clubdeldata",$clubdeldata);
						
						
						
						$assTrainerdata=$this->Trainer->find('all',array('conditions'=>array('Trainer.club_id'=>$ids[$i]),'fields'=>array('Trainer.id','Trainer.first_name','Trainer.email','Trainer.added_date')));
						
						$this->set("assTrainerdata",$assTrainerdata);
						/*echo "<pre>";
						print_r($assTrainerdata);
						echo "</pre>";*/
						
						
						$clubcancel_date = date('Y-m-d H:i:s');
						
						$trainer_list = NULL;
						foreach($assTrainerdata as $assTrainer){
						
						$trainer_list .= $prefix . '' . $assTrainer['Trainer']['email'] . '';
						$prefix = ', ';
						$this->Trainer->query("update trainers set club_id=NULL,trainer_type='I',subscriptionplan=NULL ,club_cancel_date='".$clubcancel_date."',club_cancel_status=1 where id='".$assTrainer['Trainer']['id']."' AND club_id='".$clubdeldata['Club']['id']."'");
						}
						
						
						
						
						//$this->send_mail_to_club($clubdeldata['Club']['email'],$clubdeldata['Club']['first_name']);
						
						$this->send_mail_to_admin($clubdeldata['Club']['email'],$clubdeldata['Club']['first_name'],$clubdeldata['Club']['club_name'],$trainer_list);
						
						//$this->Club->delete($ids[$i]);

						
					}
					$this->Session->setFlash('Trainer(s) has been unassigned successfully.');
					break;
			}
		}
		
		function send_mail_to_admin($cemail,$cfname,$ccname,$tlist) {		
		App::uses('CakeEmail', 'Network/Email');	
		//$admin_email	= 'synapseindia8@gmail.com';
		$admin_email	= 'registration@ptpfitpro.com';
		$email = new CakeEmail();		
		$email->emailFormat('html');
	
				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello  Admin!</p>
				<p>A Club with following details and his associated Trainer(s) has been Un-Assigned.</p>				
				<p>Club Name-: '.$ccname.'</p>
				<p>Club Email-: '.$cemail.'</p>
				<p>Club Trainer List-: '.$tlist.'</p>				
				</td></tr><tr><td><br/>Thanks,<br/>Fitness Team<br /></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(FROM_EMAIL => EMAILNAME));
		$email->to($admin_email);		
		$subtxt = __('A Club Trainers UnAssigned.');
		$email->subject($subtxt);
		$email->send($content);
	}
		
		/*function send_mail_to_club($cemail,$cfname) {		
		App::uses('CakeEmail', 'Network/Email');		
		$email = new CakeEmail();		
		$email->emailFormat('html');
	
				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello  '.$cfname.'!</p>
				<p>As per your resquest with us, we have successfully deleted your account. Please get in touch with us for any further assistance.</p>				
							
				</td></tr><tr><td><br/>Thanks again,<br/>Fitness Team<br /></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(FROM_EMAIL => EMAILNAME));
		$email->to($cemail);		
		$subtxt = __('Account Deletion Confirmation.');
		$email->subject($subtxt);
		$email->send($content);
	}*/
		
		public function update_statusb($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->ClubBranch->id = $ids[$ctr];
						$this->ClubBranch->saveField("status", '1');
					}
					$this->Session->setFlash('Branch(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->ClubBranch->id = $ids[$ctr];
						$this->ClubBranch->saveField("status", '0');
					}
					$this->Session->setFlash('Branch(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->ClubBranch->create();
						$this->ClubBranch->id = $ids[$i];
						
						$this->ClubBranch->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Branch(s) has been deleted successfully.');
					break;
			}
		}
		
		public function email($mode = null){
			$this->layout = '';
			$this->autoRender = false;
			if(isset($_GET['fieldId'])){
				$validateValue = $_GET['fieldValue'];
				$validateId = $_GET['fieldId'];
				$row_id = $_GET['row_id'];
				$arrayToJs = array();
				$arrayToJs[0] = $validateId;
				if($row_id > 0){
					$dataCheck = $this->Club->find('all', array('conditions'=>array('Club.email'=>trim($validateValue), 'Club.id !='=>trim($row_id))));
				}else{
					$dataCheck = $this->Club->find('all', array('conditions'=>array('Club.email'=>trim($validateValue))));
				}
				if(count($dataCheck) == 0){ // validate??
					$arrayToJs[1] = true; // RETURN TRUE
					echo json_encode($arrayToJs); // RETURN ARRAY WITH success
				}else{
					for($x=0;$x<1000000;$x++){
						if($x == 990000){
							$arrayToJs[1] = false;
							echo json_encode($arrayToJs); // RETURN ARRAY WITH ERROR
						}
					}
				}
			}
			
			exit;
		}
		
		public function messageclient()
		{
			
			$this->layout = "";
			$this->autoRender=false;
			
			
			/*echo"<pre>";
			print_r($_REQUEST);
			echo"</pre>";*/
			
		//	$sentfor="Client";
			
			$sentfor=trim($_REQUEST['sentfor']);
			
			$subject=trim($_REQUEST['subject']);
			$message2=trim($_REQUEST['message']);
			$sendto=trim($_REQUEST['sendto']);
			//$mestype=trim($_REQUEST['mestype']);
			
			if($this->Session->read('ClubBr')!='')
		    {
		     $this->set("setUser",'ClubBranch');
		    
		    
			$dbusertype = 'ClubBranch';					
			$this->set("dbusertype",$dbusertype);
			$uid = $this->Session->read('ClubBr');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
		    $this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
		
			
		    } else {
		    	$uid = $this->Session->read('USER_ID');
		    	$setSpecalistArr=$this->Club->find("first",array("conditions"=>array("Club.id"=>$uid)));
		    }
			
			
			
			
			if($sentfor=='T')
			{
				
				
				 $traineeDataArr=$this->Trainer->find('first',array('conditions'=>array('Trainer.id'=>$sendto),'fields'=>array('Trainer.id','Trainer.username','Trainer.email','Trainer.phone')));	
				$to=$traineeDataArr['Trainer']['email'];
				
				if($this->Session->read('ClubBr')!='')
		         {
		         	$from=$setSpecalistArr['ClubBranch']['email'];
				$fromName=$setSpecalistArr['ClubBranch']['club_name'];
				
		         }else {
		         	$from=$setSpecalistArr['Club']['email'];
				$fromName=$setSpecalistArr['Club']['club_name'];
		         }
				
				
					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
					
					if($this->Session->read('ClubBr')!='')
		            {
		            	if($setSpecalistArr['ClubBranch']['website_logo']){
					$content.='<img src="'.$this->config['url'].'uploads/'.$setSpecalistArr['ClubBranch']['website_logo'].'"/>';
					}else{
						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
					}
		            } else{
					
					if($setSpecalistArr['Club']['website_logo']){
					$content.='<img src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Club']['website_logo'].'"/>';
					}else{
						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
					}
		            }
					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$traineeDataArr['Trainee']['username'].'!</p>
				<p> Club - '.$fromName.' sent message </p>
				<p>'.$message2.' </p>
				
				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
					
					if($this->Session->read('ClubBr')!='')
		           {
		           	$dataSet['MessageBoard']['club_id']=0;
		           	$dataSet['MessageBoard']['clubbranch_id']=$uid;
		           } else {
		           		$dataSet['MessageBoard']['club_id']=$uid;
		           	$dataSet['MessageBoard']['clubbranch_id']=0;
		           }
					
					//$dataSet['MessageBoard']['sender_type']='Trainer';
					$dataSet['MessageBoard']['client_id']=0;
					$dataSet['MessageBoard']['trainer_id']=$sendto;
					$dataSet['MessageBoard']['parent_message']=0;
					$dataSet['MessageBoard']['posted_by']='C';
					$dataSet['MessageBoard']['message']=$message2;
					$dataSet['MessageBoard']['added_date']=date('Y-m-d H:i:s');
					
					$msgdetail=$subject;
					
					
					
					if($this->MessageBoard->save($dataSet)) {	
						
							/*if($this->sendEmailMessage(trim($to),$subject,$content,null,null))
							{
								
							}	*/
							
			
			
							
							echo 200;
							exit;
							
						}	
						else 
						{
						 echo 400;
							exit;
						}	
						 										
				
			}
			
			if($sentfor=='C')
			{
			   /*$clubDataArr=$this->Club->find('first',array('conditions'=>array('Club.id'=>$sendto),'fields'=>array('Club.id','Club.username','Club.email','Club.phone')));	
				$to=$traineeDataArr['Club']['email'];
				$from=$setSpecalistArr['Trainer']['email'];
				$fromName=$setSpecalistArr['Trainer']['full_name'];
				
					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
					if($setSpecalistArr['Trainer']['website_logo']){
					$content.='<img src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';
					}else{
						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
					}
					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$traineeDataArr['Trainee']['username'].'!</p>
				<p> Trainer - '.$fromName.' sent message </p>
				<p>'.$message2.' </p>
				
				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
					
					
					$dataSet['MessageBoard']['trainer_id']=$uid;
					$dataSet['MessageBoard']['sender_type']='Trainer';
					$dataSet['MessageBoard']['club_id']=$sendto;
					$dataSet['MessageBoard']['parent_message']=0;
					$dataSet['MessageBoard']['posted_by']='T';
					$dataSet['MessageBoard']['message']=$message2;
					$dataSet['MessageBoard']['added_date']=date('Y-m-d H:i:s');
					
					$msgdetail=$subject;
					
					if($this->MessageBoard->save($dataSet)) {	
						
							if($this->sendEmailMessage(trim($to),$subject,$content,null,null))
							{
								
							}
							
			
			
							
							echo 200;
							exit;
							
						}	
						else 
						{
						 echo 400;
							exit;
						}	*/
				
				
			}
			//echo 400;
							exit;
		}
		
		
		public function communication_center(){	
						
		//$this->checkUserLogin();
		$this->layout = "homelayout";		
		//echo $this->Session->read('UNAME');
		$this->set("leftcheck",'communication_center');
		
		$dbusertype = $this->Session->read('UTYPE');					
		$this->set("dbusertype",$dbusertype);
		$uid = $this->Session->read('USER_ID');	

	
		
     
			
		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
		
			
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
		  $this->set("setSpecalistArr",$setSpecalistArr);
		  
		  
		  $setSpecalistArrPayment=$this->Payment->find("first",array("conditions"=>array("Payment.trainer_id"=>$uid),'order'=>array('Payment.id DESC')));

		    $this->set("setSpecalistArrPayment",$setSpecalistArrPayment);
		  
		  //Emessage for Mail Session
		     $this->set("emessageclientArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Club','Emessage.sender_type'=>'Client','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));	
		     
		     $this->set("emessageclientsentArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'Club','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));
		     
		     $this->set("emessageclubArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Club','Emessage.sender_type'=>'Trainer','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));
		     
		      $clientDataArr=$this->Trainee->find('list',array('conditions'=>array('Trainee.club_id'=>$uid),'fields'=>array('Trainee.id','Trainee.full_name')));
		      $this->set("clientDataArr",$clientDataArr);
		      
		     
		      $clubDataArr=$this->Trainer->find('list',array('conditions'=>array('Trainer.club_id'=>$uid),'fields'=>array('Trainer.id','Trainer.full_name')));	
		       $this->set("clubDataArr",$clubDataArr);
		       
		       $this->set("emessageclubsentArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Club','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));
		       
		     //Emessage for Text Session   
		     
		        $this->set("emessageclientArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Client','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));	
		     
		     $this->set("emessageclientsentArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'Trainer','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));
		     
		     $this->set("emessageclubArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Club','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));
		     
		      $this->set("emessageclubsentArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Club','Emessage.sender_type'=>'Trainer','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));
		      
		      
		        /* for club type*/
		        
		         $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id","fields"=>array("Trainer.full_name","Trainer.website_logo", "Trainer.logo"),"conditions"=>array()))));
		      $this->MessageBoard->bindModel(array("belongsTo"=>array("Club"=>array("foreignKey"=>"club_id","fields"=>array("Club.full_name","Club.website_logo", "Club.logo"),"conditions"=>array()))));
		      $this->MessageBoard->recursive = 2;
		      
		       $this->set("emessageArrIMSesTCTxt",$this->MessageBoard->find('all',array('conditions'=>array('MessageBoard.club_id'=>$uid,'MessageBoard.parent_message'=>0,'MessageBoard.status'=>1),'order'=>array('MessageBoard.id DESC'))));
		         $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id","fields"=>array("Trainer.full_name","Trainer.website_logo","Trainer.logo"),"conditions"=>array()))));
		      $this->MessageBoard->bindModel(array("belongsTo"=>array("Club"=>array("foreignKey"=>"club_id","fields"=>array("Club.full_name","Club.website_logo","Club.logo"),"conditions"=>array()))));
		      $this->MessageBoard->recursive = 2;
		        $this->set("emessageArrIMSesTCTxt2",$this->MessageBoard->find('all',array('conditions'=>array('MessageBoard.club_id'=>$uid,'MessageBoard.parent_message >'=>0,'MessageBoard.status'=>1),'order'=>array('MessageBoard.id ASC'))));
		        
		     
		
		}
		
		
		public function communication_center_branch(){	
						
		$this->checkUserLogin();
		$this->layout = "homelayout";		
		//echo $this->Session->read('UNAME');
		$this->set("leftcheck",'communication_center');
		
		
		 if($this->Session->read('ClubBr')!='')
		    {
		     $this->set("setUser",'ClubBranch');
		    
		    
			$dbusertype = 'ClubBranch';					
			$this->set("dbusertype",$dbusertype);
			$uid = $this->Session->read('ClubBr');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
		  $this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
		
			
		    }
		    else {
		    	$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$uid = $this->Session->read('USER_ID');
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
		  $this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
			
			
			
		    }
	
		
     
			
		
		  //Emessage for Mail Session
		     $this->set("emessageclientArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'ClubBranch','Emessage.sender_type'=>'Client','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));	
		     
		     $this->set("emessageclientsentArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'ClubBranch','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));
		     
		     $this->set("emessageclubArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'ClubBranch','Emessage.sender_type'=>'Trainer','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));
		     
		      $clientDataArr=$this->Trainee->find('list',array('conditions'=>array('Trainee.club_branch_id'=>$uid),'fields'=>array('Trainee.id','Trainee.full_name')));
		      $this->set("clientDataArr",$clientDataArr);
		      
		     
		      $clubDataArr=$this->Trainer->find('list',array('conditions'=>array('Trainer.club_branch_id'=>$uid),'fields'=>array('Trainer.id','Trainer.full_name')));	
		       $this->set("clubDataArr",$clubDataArr);
		       
		       $this->set("emessageclubsentArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'ClubBranch','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));
		       
		     //Emessage for Text Session   
		     
		        $this->set("emessageclientArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'ClubBranch','Emessage.sender_type'=>'Client','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));	
		     
		     $this->set("emessageclientsentArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'ClubBranch','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));
		     
		     $this->set("emessageclubArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'ClubBranch','Emessage.sender_type'=>'Trainer','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));
		     
		      $this->set("emessageclubsentArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'ClubBranch','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));
		      
		      
		        /* for club type*/
		        
		         $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id","fields"=>array("Trainer.full_name","Trainer.website_logo", "Trainer.logo"),"conditions"=>array()))));
		      $this->MessageBoard->bindModel(array("belongsTo"=>array("ClubBranch"=>array("foreignKey"=>"clubbranch_id","fields"=>array("ClubBranch.full_name","ClubBranch.website_logo", "ClubBranch.logo"),"conditions"=>array()))));
		      $this->MessageBoard->recursive = 2;
		      $emessageArrIMSesTCTxt=$this->MessageBoard->find('all',array('conditions'=>array('MessageBoard.clubbranch_id'=>$uid,'MessageBoard.parent_message'=>0,'MessageBoard.status'=>1),'order'=>array('MessageBoard.id DESC')));
		      
		    /*  echo '<pre>';
		      
		       print_r($emessageArrIMSesTCTxt);
		      echo '</pre>';
		      die();*/
		       $this->set("emessageArrIMSesTCTxt",$emessageArrIMSesTCTxt);
		         $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id","fields"=>array("Trainer.full_name","Trainer.website_logo","Trainer.logo"),"conditions"=>array()))));
		      $this->MessageBoard->bindModel(array("belongsTo"=>array("ClubBranch"=>array("foreignKey"=>"clubbranch_id","fields"=>array("ClubBranch.full_name","ClubBranch.website_logo","ClubBranch.logo"),"conditions"=>array()))));
		      $this->MessageBoard->recursive = 2;
		      
		      $emessageArrIMSesTCTxt2=$this->MessageBoard->find('all',array('conditions'=>array('MessageBoard.clubbranch_id'=>$uid,'MessageBoard.parent_message >'=>0,'MessageBoard.status'=>1),'order'=>array('MessageBoard.id ASC')));
		       $this->set("emessageArrIMSesTCTxt2",$emessageArrIMSesTCTxt2);
		        
		        
		     
		
		}
		
		/* Message reply fucntionality start */
		public function messageclientrp()
		{
			
			$this->layout = "";
			$this->autoRender=false;
			$uid = $this->Session->read('USER_ID');
			//$dbusertype = $this->Session->read('UTYPE');					
			
	
		
			
			$postedby="C";
			if($dbusertype=='Trainer')
			{
				$postedby="T";
			}
			
			$message2=trim($_REQUEST['message']);
			$clubid=trim($_REQUEST['clubid']);
			$trainerid=trim($_REQUEST['trainerid']);
			$mes_pid=trim($_REQUEST['pmessageid']);
			
			
			
			
			$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$trainerid)));
			
			if($this->Session->read('ClubBr')!='')
		    {
		     $this->set("setUser",'ClubBranch');
		    
		    
			$dbusertype = 'ClubBranch';					
			$this->set("dbusertype",$dbusertype);
			$uid = $this->Session->read('ClubBr');
			$traineeDataArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$clubid)));
		    $this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
		
			
		    } else {
		    	 $traineeDataArr=$this->Club->find('first',array('conditions'=>array('Club.id'=>$clubid),'fields'=>array('Club.id','Club.username','Club.email','Club.phone')));
		    }
			
			
				
			if($postedby=='T')
			{
				
				$to=$traineeDataArr['Club']['email'];
				$from=$setSpecalistArr['Trainer']['email'];
				$fromName=$setSpecalistArr['Trainer']['full_name'];
				
					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
					if($setSpecalistArr['Trainer']['website_logo']){
					$content.='<img src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';
					}else{
						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
					}
					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$traineeDataArr['Trainee']['full_name'].'!</p>
				<p> Trainer - '.$fromName.' sent message </p>
				<p>'.$message2.' </p>
				
				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
					
					
					$dataSet['MessageBoard']['trainer_id']=$trainerid;					
					$dataSet['MessageBoard']['client_id']=0;
					if($this->Session->read('ClubBr')!='')
		             {
		             	$dataSet['MessageBoard']['clubbranch_id']=$clubid;
		             	$dataSet['MessageBoard']['club_id']=0;
		             } else{
		             	$dataSet['MessageBoard']['clubbranch_id']=0;
		             	$dataSet['MessageBoard']['club_id']=$clubid;
		             }
					
					$dataSet['MessageBoard']['parent_message']=$mes_pid;
					$dataSet['MessageBoard']['posted_by']=$postedby;
					$dataSet['MessageBoard']['message']=$message2;
					$dataSet['MessageBoard']['added_date']=date('Y-m-d H:i:s');
					
					$msgdetail=$subject;
					
					if($this->MessageBoard->save($dataSet)) {	
						
							$this->sendEmailMessage(trim($to),$subject,$content,null,null);	
							
			
			
							
							echo 200;
							exit;
							
						}	
						else 
						{
						 echo 400;
							exit;
						}	
						 										
				
			} else {
				if($this->Session->read('ClubBr')!='')
		             {
		             	$from=$traineeDataArr['ClubBranch']['email'];
				      $to=$setSpecalistArr['Trainer']['email'];
				    $fromName=$setSpecalistArr['ClubBranch']['full_name'];
		             } else{
				$from=$traineeDataArr['Club']['email'];
				$to=$setSpecalistArr['Trainer']['email'];
				$fromName=$setSpecalistArr['Club']['full_name'];
		             }
				
					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
					if($this->Session->read('ClubBr')!=''){
					if($traineeDataArr['ClubBranch']['website_logo']){
					$content.='<img src="'.$this->config['url'].'uploads/'.$traineeDataArr['ClubBranch']['website_logo'].'"/>';
					}else{
						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
					}
					} else{
						if($traineeDataArr['Club']['website_logo']){
					$content.='<img src="'.$this->config['url'].'uploads/'.$traineeDataArr['Club']['website_logo'].'"/>';
					}else{
						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
					}
					}
					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$setSpecalistArr['Trainer']['full_name'].'!</p>
				<p> Club - '.$fromName.' sent message </p>
				<p>'.$message2.' </p>
				
				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
					
					
					$dataSet['MessageBoard']['trainer_id']=$trainerid;					
					$dataSet['MessageBoard']['client_id']=0;
					if($this->Session->read('ClubBr')!='')
		             {
		             		$dataSet['MessageBoard']['clubbranch_id']=$clubid;
		             	$dataSet['MessageBoard']['club_id']=0;
		             } else {
		             	$dataSet['MessageBoard']['clubbranch_id']=0;
		             	$dataSet['MessageBoard']['club_id']=$clubid;
		             }
					
					$dataSet['MessageBoard']['parent_message']=$mes_pid;
					$dataSet['MessageBoard']['posted_by']=$postedby;
					$dataSet['MessageBoard']['message']=$message2;
					$dataSet['MessageBoard']['added_date']=date('Y-m-d H:i:s');
					
					$msgdetail=$subject;
					
					if($this->MessageBoard->save($dataSet)) {	
						
							$this->sendEmailMessage(trim($to),$subject,$content,null,null);	
							
			
			
							
							echo 200;
							exit;
							
						}	
						else 
						{
						 echo 400;
							exit;
						}	
			}	
			
			//echo 400;
							exit;
		}
		/* Message reply fucntionality end */
		
		public function postmessage()
		{
			
			$this->layout = "";
			$this->autoRender=false;
			 if($this->Session->read('ClubBr')!='')
		           {
			
			$uid = $this->Session->read('ClubBr');
			$setSpecalistArr=$this->ClubBranch->find("first",array("conditions"=>array("ClubBranch.id"=>$uid)));
		           } else {
		           	$uid = $this->Session->read('USER_ID');
			$setSpecalistArr=$this->Club->find("first",array("conditions"=>array("Club.id"=>$uid)));
		           }
			$sentfor=trim($_REQUEST['sentfor']);
			$subject=trim($_REQUEST['subject']);
			$message2=trim($_REQUEST['message']);
			$sendto=trim($_REQUEST['sendto']);
			$modifiedSendTo=explode(",",$sendto);
			$mestype=trim($_REQUEST['mestype']);
			
			foreach($modifiedSendTo as $snto)
			{
				if($sentfor=='Client' || $sentfor=='Clientv')
				{
					$traineeDataArr=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>$snto),'fields'=>array('Trainee.id','Trainee.username','Trainee.email','Trainee.phone','Trainee.mobile')));	
					
					$to=$traineeDataArr['Trainee']['email'];
				
					if($sentfor=='Clientv'){
						$sentfor='Client';
					}
				
					if($this->Session->read('ClubBr')!=''){
						$from=$setSpecalistArr['ClubBranch']['email'];
						$club_logo=$setSpecalistArr['ClubBranch']['website_logo'];
						$fromName=$setSpecalistArr['ClubBranch']['first_name'];
						$fromlName=$setSpecalistArr['ClubBranch']['last_name'];
		            } else {
						$from=$setSpecalistArr['Club']['email'];
						$club_logo=$setSpecalistArr['Club']['website_logo'];
						$fromName=$setSpecalistArr['Club']['club_name'];
		            }
					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
					
					if($club_logo!='')
					{
						$content.='<img width="150" height="130" src="'.$this->config['url'].'uploads/'.$club_logo.'"/>';
					}
					else
					{
						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
					}
					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td>
					
					<p> '.$fromName.' '.$fromlName.' (<a href="mailto:'.$from.'" target="_top">'.$from.'</a>) has sent you a message.</p>
					
					<p>'.$message2.' </p>
				
					</td></tr><tr><td><br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
										
					$dataSet['Emessage']['sender_id']=$uid;
					if($this->Session->read('ClubBr')!='')
					{
						$dataSet['Emessage']['sender_type']='ClubBranch';
					} else {
						$dataSet['Emessage']['sender_type']='Club';
		            }
					
					$dataSet['Emessage']['receiver_id']=$snto;
					$dataSet['Emessage']['receiver_type']=$sentfor;
					$dataSet['Emessage']['subject']=$subject;
					$dataSet['Emessage']['detail']=$message2;
					$dataSet['Emessage']['usefor']=$mestype;
					$dataSet['Emessage']['sent_date']=date('Y-m-d H:i:s');
					
					$msgdetail=$subject;
					
					if($this->Emessage->saveAll($dataSet)) {	
					
						$this->sendEmailMessage(trim($to),$subject,$content,null,null);	
						
						if($mestype=='T')
						{
							App::import('Vendor', 'Twilio', array('file' => 'twilio'.DS.'Services'.DS.'Twilio.php'));

							$account_sid = Configure::read("twilio_details.account_sid");

							$auth_token = Configure::read("twilio_details.auth_token");

							$fromno = Configure::read("twilio_details.fromno");

							$phone1=$traineeDataArr['Trainee']['mobile'];

							$client = new Services_Twilio($account_sid, $auth_token);
							
							if(trim($phone1)!='' && strlen(trim($phone1))>=10)
							{
								//exit;
								$msgdetail =$msgdetail.'. This is NoReply Message.';
								try {  
									$sms = $client->account->sms_messages->create(
									"$fromno", // From this number			
									"$phone1",
									$msgdetail);
								}
								catch (Services_Twilio_RestException $e) {
								//echo $e->getMessage();
								}
							}
						}				
						//echo 200;
						//exit;
						$flag_send=1;	
						}else{
							//echo 400;
							$flag_send=150;
							exit;
						}	
			 	}
			}
			foreach($modifiedSendTo as $snto)
			{
				if($sentfor=='Trainer')
				{
					$traineeDataArr=$this->Trainer->find('first',array('conditions'=>array('Trainer.id'=>$snto),'fields'=>array('Trainer.id','Trainer.username','Trainer.email','Trainer.phone')));	
						
					$to=$traineeDataArr['Trainer']['email'];
						
					if($this->Session->read('ClubBr')!='')
					{
						$from=$setSpecalistArr['ClubBranch']['email'];
						$fromName=$setSpecalistArr['ClubBranch']['first_name'];
						$fromlName=$setSpecalistArr['ClubBranch']['last_name'];
						$club_logo=$setSpecalistArr['ClubBranch']['website_logo'];
		            }else{
						$from=$setSpecalistArr['Club']['email'];
						$fromName=$setSpecalistArr['Club']['full_name'];
						$club_logo=$setSpecalistArr['Club']['website_logo'];
		            }
				
					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
					
					if ($club_logo!='')
					{
						$content.='<img width="150" height="130" src="'.$this->config['url'].'uploads/'.$club_logo.'"/>';
						
					}
					else
					{
						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
					}
					
					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td>
					
					<p> '.$fromName.' '.$fromlName.' (<a href="mailto:'.$from.'" target="_top">'.$from.'</a>) has sent you a message.</p>
					<p>'.$message2.' </p>
				
					</td></tr><tr><td><br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
										
					$dataSet['Emessage']['sender_id']=$uid;
										
					if($this->Session->read('ClubBr')!='')
					{
						$dataSet['Emessage']['sender_type']='ClubBranch';
					} else {
						$dataSet['Emessage']['sender_type']='Club';
					}
						$dataSet['Emessage']['receiver_id']=$snto;
						$dataSet['Emessage']['receiver_type']=$sentfor;
						$dataSet['Emessage']['subject']=$subject;
						$dataSet['Emessage']['detail']=$message2;
						$dataSet['Emessage']['usefor']=$mestype;
						$dataSet['Emessage']['sent_date']=date('Y-m-d H:i:s');
						$msgdetail=$subject;
					
					if($this->Emessage->saveAll($dataSet))
					{
						$this->sendEmailMessage(trim($to),$subject,$content,null,null);	
					
						if($mestype=='T')
						{
							App::import('Vendor', 'Twilio', array('file' => 'twilio'.DS.'Services'.DS.'Twilio.php'));
							
							$account_sid = Configure::read("twilio_details.account_sid");

							$auth_token = Configure::read("twilio_details.auth_token");

							$fromno = Configure::read("twilio_details.fromno");

							if($this->Session->read('ClubBr')!='')
							{
								$phone1=$traineeDataArr['ClubBranch']['phone'];
							} else {
								$phone1=$traineeDataArr['Club']['phone'];
							}
							$phone1=$traineeDataArr['Trainer']['phone'];
							$client = new Services_Twilio($account_sid, $auth_token);

							if(trim($phone1)!='' && strlen(trim($phone1))>=10)
							{
								//exit;
								$msgdetail =$msgdetail.'. This is NoReply Message.';
								try {  
									$sms = $client->account->sms_messages->create(
									//"+19082383840", // From this number
									"$fromno", // From this number			
									"$phone1",
									$msgdetail);
								}
								catch (Services_Twilio_RestException $e) {
									//echo $e->getMessage();
								}
							}
						}
						//echo 200;
						//exit;
						$flag_send=1;
						}else{
						//echo 400;
						$flag_send=150;
						exit;
						}	
				}
			}
			echo $flag_send;
}
		
		public function getchatuser()
		{
			$this->layout = "";
			$this->autoRender=false;
			$uid = $this->Session->read('USER_ID');
			$userfor=trim($_REQUEST['userfor']);
			if($userfor=='client')
			{
				$traineeDataArr=$this->Trainee->find('all',array('conditions'=>array('Trainee.club_id'=>$uid),'fields'=>array('Trainee.id','Trainee.username')));	
				$strreturn='';
				 if(!empty($traineeDataArr))
				 {
				 	for($i=0;$i<count($traineeDataArr);$i++)
				 	{
				 		$strreturn .='<div style="clear: both; font-family: arial; width: 100%; padding: 5px; background: none repeat scroll 0px 0px rgb(204, 204, 204); border-bottom: 1px solid rgb(0, 0, 0);"><a onclick="javascript:chatWith(\''.$traineeDataArr[$i]['Trainee']['username'].'_Client\')" href="javascript:void(0);"><img src="'.$this->config['url'].'images/widget_online_icon.gif">'.$traineeDataArr[$i]['Trainee']['username'].'_Client</a></div>';
				 	}
				 	echo $strreturn;
				 	exit;
				 }
				 else {
				 	 echo 404;	
				     exit;				 	
				 }
			}
			else {
				
				
				 $traineeDataArr=$this->Trainer->find('all',array('conditions'=>array('Trainer.club_id'=>$uid),'fields'=>array('Trainer.id','Trainer.username')));	
				 $strreturn='';
				 if(!empty($traineeDataArr))
				 {
				 	for($i=0;$i<count($traineeDataArr);$i++)
				 	{
				 	$strreturn .='<div style="clear: both; font-family: arial; width: 100%; padding: 5px; background: none repeat scroll 0px 0px rgb(204, 204, 204); border-bottom: 1px solid rgb(0, 0, 0);"><a onclick="javascript:chatWith(\''.$traineeDataArr[$i]['Trainer']['username'].'_Trainer\')" href="javascript:void(0);"><img src="'.$this->config['url'].'images/widget_online_icon.gif">'.$traineeDataArr[$i]['Trainer']['username'].'_Trainer</a></div>';
				 	}
				 	
				 	echo $strreturn;
				 	exit;
				 }
				 else {
				  echo 404;	
				  exit;
				 }
				
			}
		}
		
		public function registration() {
		
			$this->layout = "marketplace";
			$error = "";
			$facebookError='';
			$amazonUrl = "";
			$country = $this->Country->find("list");
			$displayPopup = false;
			
			if($this->data)
			{
				$refined["Member"] = $this->Member->removeDefaults($this->request->data["Member"]);
				$this->Member->set($refined); 
				if( $this->Member->validates() )
				{
					$this->request->data["Member"]["activation_code"]   = md5("Helper".time());
					$this->request->data["Member"]["helpler_verified"]  = "0";
					
					if($this->Session->check("user_id"))
					{
						$user_id  = $this->Session->read("user_id");
						$userInfo = $this->Member->find("first",array("conditions"=>array("Member.id"=>$user_id)));	
						
						$data = $this->addQuote($this->data["Member"]);
						
						if( $this->Member->updateAll($data,array("Member.id"=>$this->Session->read("user_id"))) ){
							
							$content = Configure::read("message.accountactivation");
							$content = str_replace("MAILNAME",$userInfo["Member"]["first_name"]." ".$userInfo["Member"]["last_name"],$content);
							$content = str_replace("USERNAME",$userInfo["Member"]["email"],$content);
									
							$content .= "<a href='".$this->config["url"]."members/helpler_activate/".$this->request->data["Member"]["activation_code"]."'>Click here to confirm the edu email address</a><br/><br/>";
							$content .= Configure::read('Website.email_signature');
													 
							$subject = Configure::read('Website.email_subject_signature')." : Account verification Notification"; 
						
							if( ($this->data["Member"]["helplers_email"] != "null") && ($this->data["Member"]["helplers_email"] != "valid .edu Email address") ) 
							{
								if($_SERVER["REMOTE_ADDR"] == "121.242.47.195" || $_SERVER["REMOTE_ADDR"] == "121.242.47.194" ) { 
									$this->sendEmailMessage("synapse135@gmail.com",$subject,$content,null,null);
								}else{
									$this->sendEmailMessage($this->data["Member"]["helplers_email"],$subject,$content,null,null);
								}
							}
							$this->amazon = $this->Components->load("Amazon"); 
							$amazonUrl = $this->amazon->generateRecipientToken(array("url"=>"helpler/registration","member_id"=>$this->Session->read("user_id")));
							$displayPopup = true;
						}
					
					}else
					{
						unset($this->request->data["Member"]["Cpassword"]);
						$this->request->data["Member"]["updated"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Member"]["created"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Member"]["status"]  		    = "1";												
						$this->request->data["Member"]["zipcode"]  = $this->request->data["Member"]["city"];
					
						
						unset($this->request->data["Member"]["city"]);
						
						if( $this->Member->save($this->data) ) {
							$this->Session->setFlash("User Successfully Created");
						}else{
							$this->Session->setFlash("Unable to process the request");
						}				
						/* echo"sasa";
						echo"<pre>";print_r($this->data["Member"]); */					
						$content = Configure::read("message.accountactivation");
						$content = str_replace("MAILNAME",$this->request->data["Member"]["first_name"]." ".$this->request->data["Member"]["last_name"],$content);
						$content = str_replace("USERNAME",$this->request->data["Member"]["email"],$content);
									
						$content .= "<a href='".$this->config["url"]."members/helpler_activate/".$this->request->data["Member"]["activation_code"]."'>Click here to confirm the edu email address</a><br/><br/>";
						$content .= Configure::read('Website.email_signature');
						
						$subject = Configure::read('Website.email_subject_signature')." : Account verification Notification";
					
						$this->sendEmailMessage($this->data["Member"]["email"],Configure::read('Website.email_subject_signature')." : Welcome to ".Configure::read('Website.email_subject_signature'),Configure::read('message.welcomeEmail'),"signup","signup");
										
						if( ($this->data["Member"]["helplers_email"] != "null") && ($this->data["Member"]["helplers_email"] != "valid .edu Email address") ) 
						{
							if($_SERVER["REMOTE_ADDR"] == "121.242.47.195" || $_SERVER["REMOTE_ADDR"] == "121.242.47.194" ) { 
								$this->sendEmailMessage("synapse135@gmail.com",$subject,$content,null,null);
							}else{
								$this->sendEmailMessage($this->data["Member"]["helplers_email"],$subject,$content,null,null);
							}
						}
						
						$this->Session->write("user_id",$this->Member->id);
						$this->Session->write("username",$this->request->data["Member"]["first_name"]." ".$this->request->data["Member"]["last_name"]);
						
						$this->redirect($this->config["url"]."members/myaccount");
					
					}
					/* echo"<pre>";print_r($_SESSION);
					echo"<pre>";print_r($this->request->data);die(); */
					
					
					/* $content = Configure::read("message.accountactivation");
					$content = str_replace("MAILNAME",$this->request->data["Member"]["first_name"]." ".$this->request->data["Member"]["last_name"],$content);
					$content = str_replace("USERNAME",$this->request->data["Member"]["email"],$content);
					//$content = str_replace("PASSWORD",$this->request->data["Member"]["password"],$content);
					$content .= "<a href='".$this->config["url"]."members/activate/".$this->request->data["Member"]["activation_code"]."'>Click here to confirm the email address</a>";
					$content .= Configure::read('Website.email_signature');
					
					$subject = Configure::read('Website.email_subject_signature')." : Account verification Notification";
					
					$this->sendEmailMessage($this->request->data["Member"]["email"],$subject,$content,null,null);
					$this->redirect($this->config["url"]."helpler/registration/thankyou"); */
				}else{
					$error = "1"; 
					//die("errro");
				}
			}else
			{
				$this->request->data["Member"] = $this->Member->loadDefaults();
				//echo"<pre>";print_r($this->request->data["Member"]);die;
				$this->facebook	 =  $this->Components->load('Facebook');
				$this->set("loginUrl",$this->facebook->loginUrl());
								
				if(preg_match("/tab:home/",$this->params->url))
					$validateExt = false;
				else
					$validateExt = true;
				
				if( !empty($this->params->query["state"]) && !empty($this->params->query["state"]) ){
					$userInfo = $this->facebook->verifyUser();
					
					if( !$this->facebookRegistration($userInfo,$validateExt)) 
					{	
						if($validateExt) {
							$this->request->data["Member"] = $userInfo;					
							if(!empty($userInfo["hometown"]["name"]) ) {
								$address = explode(",",$userInfo["hometown"]["name"]);
								if(!empty($address)){
									$this->request->data["Member"]["city"] 		 = $address[0];
									$this->request->data["Member"]["country_id"] = $address[1];
								}
								$this->set("displayPop",$validateExt);
							}
						}else{
							$this->request->data["Member"] = $userInfo;	
							//echo"<pre>";print_r($this->request->data);die;
							$this->set("displayPop",$validateExt);
						}
					}
				}
				
				if( array_key_exists("tokenID",$this->params->query) ) 
				{
					$this->Member->updateAll(array("Member.tokenId"=>$this->addQuote($this->params->query["tokenID"])),array("Member.id"=>$this->Session->read("user_id")));						
					$showSuccess = true;										
				}
			}
			//$this->set("facebookError",$facebookError);
			$this->set("helper_hear",Configure::read("helper_hear"));
			$this->set("country",$country);
			$this->set("error",$error);
			$this->set("displayPopup",$displayPopup);
			$this->set("amazonUrl",$amazonUrl);
		
		}
		
		public function register_user() {
			
			Configure::write('debug',0);
			$this->layout = "";
			$this->autoRender = false;
			$error   = 1;
			$message = "Please provide the valid data";
			
			if($this->data) 
			{
				$isFacebook    = false;
				$validate      = true;
				$emailEduCheck = "";
				
				if(!array_key_exists("Member",$this->data))
				{
					if(array_key_exists("requestLocation",$this->data)) {
						if( $this->data["requestLocation"] == Configure::read('Website.url')."helpler/registration" && $this->data["Member"]["email"]!=''){
							
							$validate = $this->Member->validateEmail(array("helplers_email"=>$this->data["Member"]["email"]));
						}
					}
					$this->request->data["Member"] = $this->data;
					$isFacebook = true;
				}
				
				if( $validate ) 
				{
					
			
					if( isset($this->data["requestLocation"]) && ($this->data["requestLocation"] == Configure::read('Website.url')."helpler/registration") ) {
						$emailCheck = $this->Member->find("first",array("conditions"=>array("OR"=>array("Member.helplers_email"=>$this->data["Member"]["email"],"Member.email"=>$this->data["Member"]["email"])))); 
						
					}else{
						$emailCheck = $this->Member->find("first",array("conditions"=>array("Member.email"=>$this->data["Member"]["email"])));
						
						if( empty($emailCheck) && !empty($this->data["Member"]["helplers_email"]) && ($this->data["Member"]["helplers_email"] != "valid .edu Email address") ) {
							$emailEduCheck = $this->Member->find("first",array("conditions"=>array("Member.helplers_email"=>$this->data["Member"]["helplers_email"])));  
						}else{
							$this->request->data["Member"]["helplers_email"] = "null";
						}
					}
					
					if( !empty($emailCheck) )
					{ 
						if( $emailCheck["Member"]["status"] == 1 && $isFacebook ) {
							$error   = 2;
							$message = "";
							
							$this->Session->write("username",$emailCheck["Member"]["username"]);
							$this->Session->write("user_id",$emailCheck["Member"]["id"]);
							
						}elseif( $emailCheck["Member"]["status"] == 0 && $isFacebook) {
							$error   = 1;
							$message = "Email Address verification is pending";
							
						}else{
							$error   = 1;
							$message = "Email Address already exists";
						}
					
					}else{	 
							if(empty($emailEduCheck)) {
								
								$type = "";					
														
								$this->request->data["Member"]["updated"] 		  = date("Y-m-d h:i:s");
								$this->request->data["Member"]["created"] 		  = date("Y-m-d h:i:s");
							
								if($isFacebook)
									$this->request->data["Member"]["status"]  		  = "1";
								else
									$this->request->data["Member"]["status"]  		  = "0";
							
								$this->request->data["Member"]["activation_code"] = md5("Helper".time());
								$this->request->data["Member"]["zip_code"] 		  = $this->request->data["Member"]["city"];
							
								unset($this->request->data["Member"]["city"]);
								
								if(! isset($this->data["Member"]["logo"]) ) {
									$this->data["Member"]["logo"] = null;
								}
							 
								$sql = "INSERT INTO `members` (`password`, `first_name`, `last_name`, `email`,`created`, `updated`, `status`, `type`, `activation_code`, `logo`,`zip_code`,`helplers_email`) VALUES ('".$this->data["Member"]["password"]."', '".$this->data["Member"]["first_name"]."', '".$this->data["Member"]["last_name"]."', '".$this->data["Member"]["email"]."', '".$this->data["Member"]["created"]."', '".$this->data["Member"]["updated"]."','1','".$type."','".$this->data["Member"]["activation_code"]."','".$this->data["Member"]["logo"]."','".$this->data["Member"]["zip_code"]."','".$this->data["Member"]["helplers_email"]."')";
							
								$this->Member->query($sql);
								$id = $this->Member->query("SELECT LAST_INSERT_ID()");
							
								$content = Configure::read("message.accountactivation");
								$content = str_replace("MAILNAME",$this->request->data["Member"]["first_name"]." ".$this->request->data["Member"]["last_name"],$content);
								$content = str_replace("USERNAME",$this->request->data["Member"]["email"],$content);
								
								$content .= "<a href='".$this->config["url"]."members/helpler_activate/".$this->request->data["Member"]["activation_code"]."'>Click here to confirm the edu email address</a><br/><br/>";
								$content .= Configure::read('Website.email_signature');
								
								$subject = Configure::read('Website.email_subject_signature')." : Account verification Notification";
								
								if(!$isFacebook)
								{
									$this->sendEmailMessage($this->data["Member"]["email"],Configure::read('Website.email_subject_signature')." : Welcome to ".Configure::read('Website.email_subject_signature'),Configure::read('message.welcomeEmail'),"signup","signup");
									
									if( ($this->data["Member"]["helplers_email"] != "null") && ($this->data["Member"]["helplers_email"] != "valid .edu Email address") ) {
										if($_SERVER["REMOTE_ADDR"] == "121.242.47.195" || $_SERVER["REMOTE_ADDR"] == "121.242.47.194" ) {
											$this->sendEmailMessage("synapse135@gmail.com",$subject,$content,null,null);
										}else{
											$this->sendEmailMessage($this->data["Member"]["helplers_email"],$subject,$content,null,null);
										}
									}
								}
							
								if($isFacebook){
									$error   = 2;
									$message = "";
									$this->Session->write("username",$this->request->data["Member"]["first_name"]." ".$this->request->data["Member"]["last_name"]);
									$this->Session->write("user_id",$id[0][0]["LAST_INSERT_ID()"]);
								}else{
									$error   = 0;
									$message = "";
									$this->Session->write("user_id",$id[0][0]["LAST_INSERT_ID()"]);
									$this->Session->write("username",$this->request->data["Member"]["first_name"]." ".$this->request->data["Member"]["last_name"]);
								}								
							}else{
								$error   = 1;
								$message = ".edu Email Address already exist";							
							}
					}
				}
			}else{
				$error   = 1;
				$message = "Please provide a valid .edu email";
			}				
			echo json_encode(array("error"=>$error,"message"=>$message));
			exit;
		}
		
		public function facebookRegistration($data,$validateExt) {
			
			if(!empty($data)) {
				$userInfo = $this->Member->find("first",array("conditions"=>array("Member.email"=>$data["email"])));
				
				if(	!empty($userInfo) ) {
					if($userInfo["Member"]["status"] == "1") 
					{
						$this->Session->write("username",$userInfo["Member"]["username"]);
						$this->Session->write("user_id",$userInfo["Member"]["id"]);
						//$this->redirect($this->config["url"]."helpler/dashboard/");
						$this->redirect($this->config["url"]."members/myaccount/");
					}else{
						$this->Session->setFlash("Email Address verification is pending");
						return false;
					}
				}else{
						if(!empty($data["email"])) 
						{
							$emailExt = explode(".",$data["email"]);
							$count 	  = count($emailExt);
							$count--;
			
							if($emailExt[$count] != "edu" && $validateExt){
								$this->Session->setFlash("Please provide a valid .edu email");
								return false;
							}else{
									$memberData["Member"]["first_name"] 	 =	$data["first_name"];
									$memberData["Member"]["last_name"] 	     =	$data["last_name"]; 
									$memberData["Member"]["email"] 		     =	$data["email"]; 
					
									$address = explode(",",$data["hometown"]["name"]);	
									$country = $this->Country->find("list");
						
									if(!empty($address)){
										if(!empty($address[0]))	
											$memberData["Member"]["city"] 		     =	$address[0]; 
									}
						
									$memberData["Member"]["created"] 		 =	date("Y-m-d h:i:s");
									$memberData["Member"]["updated"] 		 =	date("Y-m-d h:i:s");
									$memberData["Member"]["status"] 		 =	"0";									
									
								
									unset($this->Member->validate);
									if( $this->Member->save($memberData) )
									{									
										$content = Configure::read("message.facebookaccountactivation");
										$content = str_replace("MAILNAME",$memberData["Member"]["first_name"]." ".$memberData["Member"]["last_name"],$content);
										$content .= "<a href='".$this->config["url"]."members/helpler_activate/".$memberData["Member"]["activation_code"]."'>Click here to confirm the email address</a>";
										
										$content .= Configure::read('Website.email_signature');
										$subject = Configure::read('Website.email_subject_signature')." : Account verification Notification";
										$this->sendEmailMessage($memberData["Member"]["email"],$subject,$content,null,null);
										$this->redirect($this->config["url"]."members/registration_successsful");
									
									}
							}
						}else{
							$this->Session->setFlash("Please provide a valid Email Address");
							return false;
						}					
					}
			}
		
		}
		
		public function dashboard() {
		
			$this->layout = "marketplace";
			$this->validateUser();
			//echo"<pre>";print_r($this->Session->read("usersname"));
		}
		
		public function registration_successsful() {
		
			$this->layout = "marketplace";
			
		}
		
		
		public function cancelmyaccount()
		{	
			$this->layout = '';

			$this->render = false;

			if(trim($_POST['id'])!='')
			{
				$datav=array();				

				$datav['id']=trim($_POST['id']);
				
				
				
				$clubdata=$this->Club->find('first',array('conditions'=>array('Club.id'=>$_POST['id']),'fields'=>array('Club.id','Club.first_name','Club.last_name','Club.club_name','Club.email','Club.phone')));
				
				$this->set("clubdata",$clubdata);				
				
				
				$this->Club->query("update clubs set status=0 where id='".$datav['id']."'");
				
				$this->ClubBranch->query("update club_branches set status=0 where club_id='".$datav['id']."'");
				
				$this->send_cancel_account_mail_admin($clubdata['Club']['email'],$clubdata['Club']['first_name'],$clubdata['Club']['last_name'],$clubdata['Club']['phone'],$clubdata['Club']['club_name']);
				
							
				$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Account Cancelled Successfully.");
				
				
				
				$dbusertype=$this->Session->read('UTYPE');

				$vdata[$dbusertype]['id']=$this->Session->read('USER_ID');

				$vdata[$dbusertype]['login_status']='0';
				
				$this->Session->delete('USER_ID');

				$this->Session->delete('USER_NAME');

				$this->Session->delete('UNAME');

				$this->Session->destroy();

				$this->Session->setFlash('Account Cancelled and Logged Out Successfully!');

				
			}
			else{
					$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");
				}
			echo json_encode($response);
			exit;	
	   }
	   
	   function send_cancel_account_mail_admin($club_email,$club_fname,$club_lname,$club_phone,$club_clubname) {
		$to_admin = "registration@ptpfitpro.com";
		App::uses('CakeEmail', 'Network/Email');		
		$email = new CakeEmail();		
		$email->emailFormat('html');
				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello  Admin!</p>
				<p>A Club has cancel his/her account.</p>				
				<p>Please find details below</p>
				
				<p>Club Name: '.$club_fname.'</p>
				<p>Club Email: '.$club_email.'</p>
				<p>Club Phone: '.$club_phone.'</p>
				<p>Club Name: '.$club_clubname.'</p>
					
				</td></tr><tr><td><br/>Thanks,<br/>Fitness Team<br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(FROM_EMAIL => EMAILNAME));
		$email->to($to_admin);			
		$subtxt = __('Club Cancel Account Notification');
		$email->subject($subtxt);
		$email->send($content);
	}
		
		
		
		
		
		
		public function activate() {
		
			$this->layout = "marketplace";
			
			$memberInfo   = $this->Member->find("list",array("fields"=>array("activation_code","helpler_verified"),"conditions"=>array("Member.activation_code"=>$this->params["pass"][0])));
			
			if($memberInfo[$this->params["pass"][0]] == "1" ) {
				$response = "Your account is already been activated.Please login to your account";
			}elseif( $memberInfo[$this->params["pass"][0]] == "0" ) {
				$this->Member->updateAll(array("Member.status"=>"1","Member.helpler_verified"=>"1"),array("Member.activation_code"=>$this->params["pass"][0]));
				$response = "Your Helpler's .edu email address is successfully verified.Please login to your account to bid for tasks";
			}else{
				$response = "Unable to trace the activation code.Please contact admin for further support";
			}
			
			$this->set("response",$response);
		
		}
		
		public function forgot_password() {
			
			$this->layout = "marketplace";
			if($this->data){
				if($this->data["Member"]["email"] == "abc@abc.com")
					$this->request->data["Member"]["email"] = "";
				
				unset($this->Member->validate["first_name"]);
				unset($this->Member->validate["last_name"]);
				unset($this->Member->validate["city"]);
				unset($this->Member->validate["country_id"]);
				unset($this->Member->validate["username"]);
				unset($this->Member->validate["password"]);
				unset($this->Member->validate["Cpassword"]);
				unset($this->Member->validate["referer"]);
				unset($this->Member->validate["email"]["unique"]);
				unset($this->Member->validate["email"]["email"]);
				
				$this->Member->set($this->data);
				if($this->Member->validates()) {
					$memberInfo = $this->Member->find("first",array("conditions"=>array("Member.email"=>$this->data["Member"]["email"],"Member.status"=>"1","Member.facebook_id"=>"")));
					
					$newPassword = rand(0,99999);
					if(!empty($memberInfo)) {
						if( $this->Member->updateAll(array("Member.password"=>"'$newPassword'"),array("Member.id"=>$memberInfo["Member"]["id"]))) {
							
							$content = Configure::read("message.forgotpassword");
							$content = str_replace("MAILNAME",$memberInfo["Member"]["first_name"]." ".$memberInfo["Member"]["last_name"],$content);
							$content = str_replace("PASSWORD",$newPassword,$content);
							
							$subject = "Password Reset Notification";
							$this->sendEmailMessage($memberInfo["Member"]["email"],$subject,$content,null,null);
							$this->Session->setFlash("New Password successfully sent on registered email");
						}
					}else{
						$this->Session->setFlash("Email Address not found in records");
					}
				}				
			}else{
				$this->request->data["Member"]["email"] = "abc@abc.com";
			}
		}
		
		public function login_user(){
					
			$this->layout = '';
			$this->autoRender = false;
			
			$error   = 0;			
			$message = "";
			
			if($this->data){				
				$userInfo = $this->Member->find("first",array("conditions"=>array("Member.email"=>$this->data["Member"]["username"],"Member.password"=>$this->data["Member"]["password"])));
							
				if(!empty($userInfo)){
					if($userInfo["Member"]["status"] == 0) {
						$error   = 1;
						$message = "Email address verification is pending";	
					}else{						
						$this->Session->write("username",$this->data["Member"]["username"]);
						$this->Session->write("user_id",$userInfo["Member"]["id"]);
						
						if(array_key_exists("remember",$this->data["Member"])){
							$this->rememberUser($this->data["Member"]);
						}else{
							$this->removeUser();
						}						

						$this->Member->updateAll(array("Member.isOnline"=>"1"),array("Member.id"=>$userInfo["Member"]["id"]));
						$message = $this->data["Member"]["username"]."|".$this->data["Member"]["password"];
						
						$this->loadModel("Alert");
						$this->Session->write("user_settings",$this->Alert->find("first",array("conditions"=>array("Alert.member_id"=>$userInfo["Member"]["id"]))));
					}
				}else{
					$error   = 1;
					$message = "Invalid Email address or password";	
				}
			}
			
			echo json_encode(array("error"=>$error,"message"=>$message));
			exit;		
		}
		
		public function login() {
			
			$this->layout = "marketplace";			
			if($this->data) {
				//echo"<pre>";print_r($this->data);die;
				unset($this->Member->validate["first_name"]);
				unset($this->Member->validate["last_name"]);
				unset($this->Member->validate["city"]);
				unset($this->Member->validate["country_id"]);
				unset($this->Member->validate["email"]);
				unset($this->Member->validate["Cpassword"]);
				unset($this->Member->validate["referer"]);
				unset($this->Member->validate["username"]["unique"]);
				
				$this->Member->set($this->data);
				if($this->Member->validates()) {
					$memberInfo = $this->Member->find("first",array("conditions"=>array("Member.username"=>$this->data["Member"]["username"],"Member.password"=>$this->data["Member"]["password"])));
					
					if(!empty($memberInfo)){
						if( $memberInfo["Member"]["status"] == "1"){							
							$this->Session->write("usersname",$memberInfo["Member"]["first_name"]." ".$memberInfo["Member"]["last_name"]);
							$this->Session->write("user_id",$memberInfo["Member"]["id"]);
							
							if( (array_key_exists("remember",$this->data["Member"]) ) && ($this->data["Member"]["remember"] == "1") ) {
								$this->rememberUser($this->data["Member"]);
							}else{
								$this->removeUser();
							}
														
							$this->redirect($this->config["url"]);
						}else{
							$this->Session->setFlash("The Account is inActive mode.Please contact admin for further assistance");
						}
					}else{
						$this->Session->setFlash("Invalid username or password");
					}
				}
			
			}else{
				$this->request->data["Member"]["username"] = $this->Cookie->read("user");
				$this->request->data["Member"]["password"] = $this->Cookie->read("pass");
				$this->request->data["Member"]["remember"] = $this->Cookie->read("isRemember");
			}	
		}
		
		/**
		*Summary of Method: 	Function for forgot password
		*created date: 			28th Jan 2013
		*created by:			1262
		*Database Table Access:	
		*/
		
		
		public function forgotpassword(){
			
			$this->layout = '';
			$this->autoRender = false;
			
			$error   = 0;			
			$message = "";
			
			if(!empty($this->data)) {
			
			$this->Member->set($this->data);
			
				if($this->Member->validates()) {
				
					$memberInfo = $this->Member->find('first', array('conditions'=>array('Member.email'=>trim($this->data[Member][useremail]))));
					
					$newPassword = rand(0,9999999);
					if(!empty($memberInfo)) {
						
						if( $memberInfo["Member"]["status"] == "0"){
							$error   = 1;
							$message = "Email Address verification is pending";							
						}else{
							if( $this->Member->updateAll(array("Member.password"=>"'".$newPassword."'"),array("Member.id"=>$memberInfo["Member"]["id"]))) 
							{						
								$content = Configure::read("message.forgotpassword");
								$content = str_replace("MAILNAME",$memberInfo["Member"]["first_name"]." ".$memberInfo["Member"]["last_name"],$content);
								$content = str_replace("PASSWORD",$newPassword,$content);
								
								$subject = "Password Reset Notification";
								$this->sendEmailMessage($memberInfo["Member"]["email"],$subject,$content,null,null);
								$this->Session->setFlash("New Password successfully sent on registered email");						
							}							
						}						
					} else {
							$this->Session->setFlash("Email Address not found in records");
							$error   = 1;
							$message = "Email Address not found in records";	
						}

				}		
			}
			
			echo json_encode(array("error"=>$error,"message"=>$message));
			exit;		
		}
		
		
		/**
		*Summary of Method: 	Function for change password
		*created date: 			28th Jan 2013
		*created by:			1262
		*Database Table Access:	
		*/
		
		
		public function changepassword(){
			
			$this->layout = '';
			$this->autoRender = false;
					
			$user_id  = $this->Session->read('user_id');
			$username = $this->Session->read('username');
						
			if(!empty($this->data)) 
			{			
				if( $this->data["Member"]["new_password"] != $this->data["Member"]["confirm_password"] ) {
					$this->request->data["Member"]["confirm_password"] = "";
				}
				
				$this->Member->set($this->data);			
				if($this->Member->validates()) 
				{
					$memberInfo = $this->Member->find('first',array('conditions'=>array('Member.id'=>$user_id,'Member.password'=>trim($this->data['Member']['old_password']))));
					
					if(!empty($memberInfo))
					{
						$password = $this->addQuote($this->data['Member']['new_password']);
						if( $this->Member->updateAll(array("Member.password"=>$password),array("Member.id"=>$memberInfo["Member"]["id"]))) 
						{
							$this->Session->write("passwordResponse",'<span class="successClass">Password has been changed successfully</span>');
							unset($_SESSION["formData"]);
						}else{
							$this->Session->write("passwordResponse",'<span class="errorClass">Unable to update the password</span>');
							$this->Session->write("formData",$this->data);
						}
					}else{ 
						$this->Session->write("passwordResponse",'<span class="errorClass">Current password donot match</span>');
						$this->Session->write("formData",$this->data);
					}
				}else{
					$this->Session->write("formData",$this->data);
				}
			}
			$this->redirect(array('controller'=>'members','action'=>'myaccount'));
		}
		
		
		/**
		*Summary of Method: 	Function to view the user profile
		*created date: 			24th Jan 2013
		*created by:			0451
		*Database Table Access:	
		*/
		
		public function profile(){
		
			$this->layout = "inside_layout";
			Configure::write("debug",0);
			if( !empty($this->params["pass"][0]) ) 
			{
				$this->loadModel("Task");
				$this->Task->create();
				
				/* Members normal tasks*/
					$this->Member->bindModel(array("hasMany"=>array("Task"=>array("foreignKey"=>"assigned_user_id","fields"=>array("Task.title","Task.id","Task.user_id","Task.price","Task.start_date","Task.status")))));
					
					$this->Task->bindModel(array("hasMany"=>array("Review"=>array("foreignKey"=>"task_id","fields"=>array("Review.ratings"),"conditions"=>array("Review.type"=>"hirer_comment")))));
					
					$this->Member->recursive = 2;
					$tasks = $this->Member->find("first",array("conditions"=>array("Member.id"=>$this->params["pass"][0])));
					
					$i=0;
					foreach( $tasks["Task"] as $task) {	
						$member = $this->Member->find("first",array("fields"=>array("full_name","id","logo"),"conditions"=>array("Member.id"=>$task["user_id"])));
						
						if(!empty($member["Member"])){
							$tasks["Task"][$i]["Member"] = $member["Member"];
						}						
						$i++;
					}
					
					$this->set("memberInfo",$tasks);
				/* Members normal tasks*/
				
				/* Members quick hire tasks*/				
					/* $this->Member->bindModel(array("hasMany"=>array("QuickTask"=>array("foreignKey"=>"user_id","conditions"=>array("DATEDIFF(QuickTask.Expiration,NOW()) >="=>"0","QuickTask.is_awarded "=>"0","QuickTask.title <> "=>""))))); */
					//$this->QuickTask->bindModel(array("hasMany"=>array("Review"=>array("foreignKey"=>"task_id","fields"=>array("Review.ratings"),"conditions"=>array("Review.type"=>"hirer_comment")))));
					//$this->QuickTask->bindModel(array("hasMany"=>array("Member"=>array("foreignKey"=>"task_id","fields"=>array("Review.ratings"),"conditions"=>array("Review.type"=>"hirer_comment")))));
					
					/* $this->Member->recursive = 2;
					
					$memberQuickTask = $this->Member->find("first",array("fields"=>array("Member.first_name","Member.last_name"),"conditions"=>array("Member.id"=>$this->params["pass"][0]))); */
					
					$this->loadModel('QuickHireSale');
					$this->QuickHireSale->create();
					
					$conditions = array("QuickTask.user_id"=>$this->params["pass"][0],
										"OR"=>array(	
													"DATEDIFF(QuickTask.Expiration,NOW()) >="=>"0",
													"QuickTask.no_expiration"=>"1"
												)
									);
				
					$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo","Member.id")))));
					
					$this->QuickHireSale->bindModel(array("hasMany"=>array("Review"=>array("foreignKey"=>"sales_id","fields"=>array("ratings"),"conditions"=>array("Review.type"=>'hirer_comment')))));
					
					$this->QuickHireSale->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"hirer_id","fields"=>array("Member.full_name","Member.logo","Member.id")))));
				
					$this->QuickTask->bindModel(array("hasMany"=>array("QuickHireSale"=>array("foreignKey"=>"task_id","conditions"=>array("QuickHireSale.status"=>"3")))));
					
					$this->QuickTask->recursive = 2;
					$allQuicktasks = $this->QuickTask->find("all",array("conditions"=>$conditions,"order"=>"QuickTask.id DESC"));
					//echo"<pre>";print_r($allQuicktasks);die();
					$this->set("membersQuickInfo",$allQuicktasks);
				/* Members quick hire tasks*/			
				 
			}else{
				$this->redirect($this->config["url"]);
			}
			
		}
		
		/**
		*Summary of Method: 	Function to edit the nasic details and change password
		*created date: 			24th Jan 2013
		*created by:			0451
		*Database Table Access:	
		*/
		
		public function myaccount() {
			
			//echo"<pre>";print_r($_COOKIE);die;			
			$this->validateUser();
			$this->set("error","");
			$this->layout = "inside_layout";
			$user_id = $this->Session->read('user_id');
			
			$userData = $this->Member->find("first",array("conditions"=>array("Member.id"=>$user_id)));
			$this->set("memberType",$userData);
			
			if($this->data)
			{
				$skills = "";
				if(!empty($this->data["Skills"])) {
					$skills = serialize($this->data["Skills"]);
				}
				$this->request->data["Member"]["skills"] = $skills;
				
				$travel = "";
				if(!empty($this->data["travel"])) {
					$travel = serialize($this->data["travel"]);
				}
				$this->request->data["Member"]["travel"] = $travel;
				
				if(!empty($_FILES["logo"]["name"])){
					$this->request->data["Member"]["logo"] = $_FILES["logo"]["name"];
				}
				
				if( !empty($this->data["Member"]["new_video"]) && ($this->data["Member"]["video"] != $this->data["Member"]["new_video"]) ) {
					$this->request->data["Member"]["video"] = $this->data["Member"]["new_video"];
				}
				unset($this->request->data["Member"]["new_video"]);
				//echo"<pre>";print_r($this->data["Member"]);die;
				$this->Member->set($this->data["Member"]);
				if( $this->Member->validates() ) 
				{ 
					if(!empty($_FILES["logo"]["name"])) 
					{
						$extension = explode(".",$_FILES["logo"]["name"]);
						$count     = count($extension);
						$count--;
						
						$name   = "user_".time();
						$target = Configure::read("include_path")."users/"."user1_".time().".".$extension[$count];
						
						if(move_uploaded_file($_FILES["logo"]["tmp_name"],$target))
						{
							$this->Resize->load($target);
							$menudimensions  = array(
													"users"=> array("width"=>50,"height"=>50),
													"users/big"=> array("width"=>130,"height"=>130)
												);
												
							foreach( $menudimensions as $folder => $dimension )
							{
								$targetWidth    = $dimension["width"];
								$targetHeight   = $dimension["height"];
								
								$sourceWidth = $this->Resize->getWidth();
								$sourceHeight = $this->Resize->getHeight();
						
								if ($sourceWidth > $sourceHeight) {
								  $this->Resize->resizeToWidth($targetWidth);
								}else {
								  $this->Resize->resizeToHeight($targetHeight);
								}
								$this->Resize->resize($targetWidth, $targetHeight);
								
								$fileName = Configure::read("include_path").$folder."/".$name.".".$extension[$count];
								$this->Resize->save($fileName);
							}
							unlink($target);
							$this->request->data["Member"]["logo"] = $name.".".$extension[$count];
						}					
					}
					
					$this->request->data["Member"]["about_me"] = addslashes($this->data["Member"]["about_me"]);
					$data = $this->addQuote($this->data["Member"]);
				
					if($this->Member->updateAll($data,array("Member.id"=>$this->Session->read('user_id')))) 
					{	
						if( (!empty($this->data["Member"]["helplers_email"])) && ($this->data["Member"]["helplers_email"] != $userData["Member"]["helplers_email"] ) ) 
						{
							$this->Member->updateAll(array("Member.activation_code"=>md5($userData["Member"]["helplers_email"]),"Member.helpler_verified"=>"0"),array("Member.id"=>$this->Session->read('user_id')));
							
							$content = str_replace("MAILNAME",$this->data["Member"]["first_name"]." ".$this->data["Member"]["last_name"],Configure::read('message.eduMailConfirmation'));
							
							$content = str_replace("LINK","<a href='".Configure::read('Website.url')."members/helpler_activate/".md5($userData["Member"]["helplers_email"])."'>Click here to confirm the edu email address</a>",$content);
						
							$subject = "Helpler's Email address account verification";
							
							if( $this->sendEmailMessage($this->data["Member"]["helplers_email"],$subject,$content,null,null) ) 
								$this->Session->setFlash('<span class="success">Profile has been updated successfully.<br/>Please check and confirm the new .edu email address</span>');
							else
								$this->Session->setFlash('<span class="success">Profile has been updated successfully and but unable to send the email on requested .edu email address.<br/> Please contact the site admin</span>');
						}else{
							$this->Session->setFlash('<span class="success">Profile has been updated successfully</span>');
						}
						$this->redirect(array('controller'=>'members','action'=>'myaccount/'.rand()));
					}
				}else{
					//	echo"32<pre>";print_r($this->Member->validationErrors);die;
					 $this->set("error",$this->Member->validationErrors);					
				}
				$userInfo["Member"] = $this->data["Member"]; 
				$userInfo["Member"]["logo"]  = $this->data["logo"]; 
				$userInfo["Member"]["video"] = $this->data["video"]; 
			}else{
				if( $this->Session->check("formData") ){
					$this->data = $this->Session->read("formData");
				}else{
					$userInfo =  $this->Member->find("first",array("conditions"=>array("Member.id"=>$user_id)));
				}
			}

			$this->set("passwordResponse",$this->Session->read("passwordResponse"));
			$this->Session->write("passwordResponse","");
			
			$this->set("userInfo",$userInfo);
			
			if(!empty($userData["Member"]["password"]))
				$showPassword = true;
			else
				$showPassword = false;
			
			$this->set("showPassword",$showPassword);	
		
		}
		
		public function helpler_activate() {
			
			$this->layout = "marketplace";
			if( $this->params["pass"][0] ) {
			
				$memberInfo = $this->Member->find("first",array("fields"=>array("id","helpler_verified"),"conditions"=>array("Member.activation_code"=>$this->params["pass"][0])));
			
				if(!empty($memberInfo)) {
					if( $memberInfo["Member"]["helpler_verified"] == 1 ) {
						$this->set("message","Your helpler's email address is already verified");
					}else{
						$this->Member->updateAll(array("Member.helpler_verified"=>"1"),array("Member.id"=>$memberInfo["Member"]["id"]));
						$this->set("message","Your  Helpler  .edu  email  address  has  been  verified.");
					}
				}else{
					$this->set("message","Invalid helpler's email address");
				}
			}else{
				$this->set("message","Invalid helpler's email address");
			}
		
		}
		
		function uploadVideo() {
			
			if(!empty($_FILES["Filedata"]["name"]) ){
				$extension = explode(".",$_FILES["Filedata"]["name"]);
				$count     = count($extension);
				$count--;
			
				$name   = "user_videos_".time().".".$extension[$count];
				$target = Configure::read('Website.include_path')."users/videos/".$name;
				
				move_uploaded_file($_FILES["Filedata"]["tmp_name"],$target);
				echo $name;	
				exit;
			}
		
		}
		
		function delete()
		{
			if($this->data) {				
				switch($this->data["fields"]) {
					case "pic":
						$fields = array("Member.logo"=>"''");
						break;						
					case "video":
						$fields = array("Member.video"=>"''");
					break;			
				}
				$this->Member->updateAll($fields,array("Member.id"=>$this->data["user_id"]));
				echo $this->data["fields"];
				exit;
			}			
		}
		
		/**
		*Summary of Method: 	Function to view the list of tasks i am running
		*created date: 			24th Jan 2013
		*created by:			0451
		*Database Table Access:	
		*/
		
		public function taskrunning(){
			
			$this->validateUser();
			
			$this->layout = "inside_layout";
			Configure::write("debug",0);
			
			$user_id  = $this->Session->read('user_id');			
			$userInfo = $this->Member->find("first",array("conditions"=>array("Member.id"=>$user_id)));
			
			$this->set("userInfo",$userInfo);
			
			$this->loadModel("QuickTask");
			$this->QuickTask->create();
				
			$this->loadModel("QuickHireSale");
			$this->QuickHireSale->create();
			
			$this->set("categorys",$this->Category->find("list",array("fields"=>array("id","name"))));
		
			if(!empty($this->params->query["tokenID"])) {				
				$updateFields = array("QuickHireSale.tokenID"=>$this->params->query["tokenID"],"QuickHireSale.refundTokenID"=>$this->params->query["refundTokenID"],"QuickHireSale.is_confirmed"=>1);
				
				$updateFields = $this->addQuote($updateFields);
				$ids = explode("QuickHire",$this->params->query["callerReference"]);
				
				if( $this->QuickHireSale->updateAll($updateFields,array("QuickHireSale.id"=>$ids[0]) ) )
					$this->redirect("/members/taskrunning/tab:taskAssigned/id:".$ids[0]);
			}
			
			/* Fetching the user's running projects*/
			
				$this->loadModel("Review");
				$this->Review->create();
				
				$conditions = array("QuickTask.user_id"=>$this->Session->read("user_id"),"QuickTask.status <>"=>"2");
				
				$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo","Member.id")))));
				
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"hirer_id","fields"=>array("Member.full_name","Member.logo","Member.id")))));
				
				$this->QuickTask->bindModel(array("hasMany"=>array("QuickHireSale"=>array("foreignKey"=>"task_id","conditions"=>array("QuickHireSale.id <>"=>"")))));
				$this->QuickTask->recursive = 2;
				
				$allQuicktasks = $this->QuickTask->find("all",array("conditions"=>$conditions,"order"=>"QuickTask.id DESC"));
				$this->amazon = $this->Components->load("Amazon"); 
				
				$this->loadModel("TaskPM");
				$this->TaskPM->create();
				
				$i=0;			
				foreach( $allQuicktasks as $task ) {
					$j =0;	
					if(!empty($task["QuickHireSale"]))	{
						foreach( $task["QuickHireSale"] as $sales ) {  
						
							$allQuicktasks[$i]["QuickHireSale"][$j]["confirmUrl"] = $this->amazon->generateRecipientToken(array("url"=>"members/taskrunning","member_id"=>$sales["id"]."QuickHire".$task["QuickTask"]["id"],"amount"=>$task["QuickTask"]["price"]));
							
							$messages = $this->TaskPM->find("all",array("conditions"=>array("TaskPM.job_id"=>$sales["task_id"],"TaskPM.sales_id"=>$sales["id"])));
							
							$messageCount = 0;
							if(!empty($messages)){ 
								foreach( $messages as $message ){
									$members = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$message["TaskPM"]["posted_by"])));
								
									$messages[$messageCount]["Member"] = $members["Member"];								
									$messageCount++;
								}
							}
							
							$allQuicktasks[$i]["QuickHireSale"][$j]["messages"] = $messages;
							
							$reviews = $this->Review->find("all",array("conditions"=>array("Review.task_id"=>$task["QuickTask"]["id"],"Review.sales_id"=>$sales["id"])));
							
							$reviewCount = 0;
							foreach( $reviews as $review ){
									
								$members = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$review["Review"]["member_id"])));
								
								$reviews[$reviewCount]["Member"] = $members["Member"];								
								$reviewCount++;
							}							
							$allQuicktasks[$i]["QuickHireSale"][$j]["helpler_comment"] = $reviews;							
							$j++;						
						}
						/* $allQuicktasks[$i]["members"] = $this->Member->find("first",array("conditions"=>array("Member.id"=>$task["QuickTask"]["hirer_id"]))); */
						
					}else{
						unset($allQuicktasks[$i]);
					}					
					$i++;			
				}
				
				//echo"<pre>";print_r($allQuicktasks);die();
				$this->set("allQuicktasks",$allQuicktasks);
		
				$allTask = $this->Task->query("SELECT Task.*,Member.id,Member.first_name,Member.last_name,Member.logo FROM jobs as Task LEFT JOIN members as Member on Task.user_id = Member.id WHERE ( (assigned_user_id =".$this->Session->read("user_id").") OR (Task.id IN( (SELECT job_id FROM member_bids Bid LEFT JOIN jobs J ON Bid.job_id = J.id WHERE J.status = 0 AND Bid.member_id =".$this->Session->read("user_id").")))) ORDER BY Task.id DESC");
				
				$this->loadModel("Review");
				$this->Review->create();
				
				$i=0;		
				$this->loadModel("TaskPM");
				$this->TaskPM->create();			
				
				foreach( $allTask as $tasks) {
				
					$allTask[$i]["hirer"] = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo","Member.id"),"conditions"=>array("Member.id"=>$tasks["Task"]["user_id"])));
			
					$allTask[$i]["assigned"] = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo","Member.id"),"conditions"=>array("Member.id"=>$tasks["Task"]["assigned_user_id"])));
					
					$this->Review->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"member_id","fields"=>array("Member.full_name","Member.logo","Member.id")))));
						
					$allTask[$i]["helpler_comment"] = $this->Review->find("all",array("conditions"=>array("Review.task_id"=>$tasks["Task"]["id"],"Review.task_type"=>"0","Review.member_id <>"=>"0")));
					
					$this->TaskPM->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"posted_by","fields"=>array("Member.full_name","Member.logo","Member.id")))));
					$allTask[$i]["messages"] = $this->TaskPM->find("all",array("conditions"=>array("TaskPM.job_id"=>$tasks["Task"]["id"])));
					
					$allTask[$i]["Task"]["new_comment"] = $this->TaskPM->find("count",array("conditions"=>array("TaskPM.posted_to"=>$this->Session->read("user_id"),"TaskPM.status"=>"0","TaskPM.job_id"=>$tasks["Task"]["id"])));
					
					$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$allTask[$i]["Task"]["task_location"]."&sensor=true";
					
					$ch = curl_init($url);
					curl_SETOPT($ch,CURLOPT_RETURNTRANSFER,true);
					$response = curl_exec($ch);
							
					$result   = json_decode($response);
					
					$allTask[$i]["Task"]["lat"] = $result->results[0]->geometry->location->lat;
					$allTask[$i]["Task"]["lng"] = $result->results[0]->geometry->location->lng;
					$i++;
				
				}
				//echo"<pre>";print_r($allTask);die();
				$this->set("allTask",$allTask);
			
			/* Fetching the user's running projects*/
			
			
			/* Fetching the user's bidded projects*/
			
				$this->set("biddedTask",$this->Task->query("SELECT Task.*,Member.id,Member.first_name,Member.last_name,Member.logo  FROM jobs as Task LEFT JOIN members as Member on Task.user_id = Member.id WHERE Task.id IN(SELECT job_id FROM member_bids WHERE member_id =".$this->Session->read("user_id").") AND Task.status = 0 ORDER BY Task.id DESC"));	
		
			/* Fetching the user's bidded projects*/
				///Configure::write("debug",2);
			/* Fetching the user's assigned projects*/
				$assignedTask = array();
				$i =0;
				$assignedRefine = $allQuicktasks;
				foreach($assignedRefine as $quickTasks){
				
					if(!empty($quickTasks["QuickHireSale"])) {
						$noneHired = true;
						$j=0;
						foreach( $quickTasks["QuickHireSale"] as $quickSales ) {
							if($quickSales["status"] != 1){
								unset($quickTasks["QuickHireSale"][$j]);
							}
							$j++;
						}
						
						if(!empty($quickTasks["QuickHireSale"])) {
							$assignedTask[] = $quickTasks;
						}else{
							unset($assignedRefine[$i]);
						}						
					}else{
						unset($assignedRefine[$i]);
					}
					$i++;
				}
				
				$this->set("assignedQuicktasks",$assignedTask);
			
				$this->set("assignedTask",$this->Task->query("SELECT Task.*,Member.id,Member.first_name,Member.last_name,Member.logo FROM jobs as Task LEFT JOIN members as Member on Task.user_id = Member.id WHERE Task.assigned_user_id = ".$this->Session->read("user_id")." AND Task.status = 1  ORDER BY Task.id DESC"));
				
			/* Fetching the user's assigned projects*/
			
			/* Fetching the user's completed projects*/
				
				$completedQuickTask = array();
				$i =0;
				$completeRefine = $allQuicktasks;
				foreach( $completeRefine as $quickTasks ) {				
					if(!empty($quickTasks["QuickHireSale"]) ) {
						$noneHired = true;
						$j=0;
						foreach( $quickTasks["QuickHireSale"] as $quickSales ) {
							if($quickSales["status"] == 3){
								$noneHired = false;
							}else{
								unset($quickTasks["QuickHireSale"][$j]);
							}
							$j++;
						}
					}					
					if(!$noneHired) {
						$completedQuickTask[$i] = $quickTasks;
						$i++;
					}
				}
				
				//echo"<pre>";print_r($completedQuickTask);die();
				$this->set("completedQuickTask",$completedQuickTask);
			
				$completedTask = $this->Task->query("SELECT Task.*,Member.id,Member.first_name,Member.last_name,Member.logo FROM jobs as Task LEFT JOIN members as Member on Task.user_id = Member.id WHERE Task.assigned_user_id =".$this->Session->read("user_id")." AND Task.status=3 ORDER BY Task.id DESC");
				
				$i=0;				
				foreach( $completedTask as $tasks) {
				
					$completedTask[$i]["hirer"] = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo","Member.id"),"conditions"=>array("Member.id"=>$tasks["Task"]["user_id"])));
					
					$completedTask[$i]["assigned"] = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo","Member.id"),"conditions"=>array("Member.id"=>$tasks["Task"]["assigned_user_id"])));
					
					$this->Review->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"member_id","fields"=>array("Member.full_name","Member.logo","Member.id")))));
					$completedTask[$i]["helpler_comment"] = $this->Review->find("all",array("conditions"=>array("Review.task_id"=>$tasks["Task"]["id"],"Review.task_type"=>"0","Review.member_id <>"=>"0")));
					
					$this->TaskPM->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"posted_by","fields"=>array("Member.full_name","Member.logo","Member.id")))));
					
					$completedTask[$i]["messages"] = $this->TaskPM->find("all",array("conditions"=>array("TaskPM.job_id"=>$tasks["Task"]["id"])));
					
					/* $allTask[$i]["Task"]["new_comment"] = $this->TaskPM->find("count",array("conditions"=>array("TaskPM.posted_to"=>$this->Session->read("user_id"),"TaskPM.status"=>"0","TaskPM.job_id"=>$tasks["Task"]["id"])));
					
					$completedTask[$i]["Task"]["helpler_comment"] = $this->Review->find("count",array("conditions"=>array("Review.task_id"=>$tasks["Task"]["id"],"Review.type"=>"helpler_comment","Review.task_type"=>"0"))); */
					
					$completedTask[$i]["Task"]["new_comment"] = $this->TaskPM->find("count",array("conditions"=>array("TaskPM.posted_to"=>$this->Session->read("user_id"),"TaskPM.status"=>"0","TaskPM.job_id"=>$tasks["Task"]["id"])));
					
					$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$completedTask[$i]["Task"]["task_location"]."&sensor=true";
					
					$ch = curl_init($url);
					curl_SETOPT($ch,CURLOPT_RETURNTRANSFER,true);
					$response = curl_exec($ch);
				
					$result   = json_decode($response);
					
					$completedTask[$i]["Task"]["lat"] = $result->results[0]->geometry->location->lat;
					$completedTask[$i]["Task"]["lng"] = $result->results[0]->geometry->location->lng;
					
					$i++;					
				}
				//echo"<pre>";print_r($completedTask);die;
				$this->set("completedTask",$completedTask);
			/* Fetching the user's completed projects*/

			/* Fetching the user's closed projects*/
				
				$closedQuickTask = array();
				$i =0;
				$closedRefine = $allQuicktasks;
				foreach( $closedRefine as $quickTasks ) {
					if(!empty($quickTasks["QuickHireSale"]) ) {
						$noneHired = true;
						foreach( $quickTasks["QuickHireSale"] as $quickSales ) {
							if($quickSales["status"] == 4){
								$noneHired = false;
							}
						}
					}					
					if(!$noneHired) {
						$closedQuickTask[$i] = $quickTasks;
						$i++;
					}
				}
				$this->set("closedQuickTask",$closedQuickTask);
				
				$this->set("closedTask",$this->Task->query("SELECT Task.*,Member.id,Member.first_name,Member.last_name,Member.logo  FROM jobs as Task LEFT JOIN members as Member on Task.user_id = Member.id WHERE Task.assigned_user_id = ".$this->Session->read("user_id")." AND Task.status = 4 ORDER BY Task.id DESC"));
				
			/* Fetching the user's closed projects*/
		
		
		}
		
		/**
		*Summary of Method: 	Function to view the list of tasks i have posted
		*created date: 			24th Jan 2013
		*created by:			0451
		*Database Table Access:	
		*/
		
		public function taskposted()
		{
			Configure::write("debug",0);
		
			$this->loadModel("QuickHireSale");
			$this->QuickHireSale->create();	
			
			$this->loadModel("Review");
			$this->Review->create();	
			
			$this->amazon = $this->Components->load("Amazon");

			if(!empty($this->params->query["fundingTokenID"]))
			{
				if(preg_match("/QuickHire/",$this->params->query["callerReference"]))
				{
					$callerReference = explode("-",$this->params->query["callerReference"]);					
					
					$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"hirer_id","fields"=>array("tokenId","id","full_name")))));
					
					$this->QuickHireSale->bindModel(array("belongsTo"=>array("QuickTask"=>array("foreignKey"=>"task_id"))));
					$taskInfo = $this->QuickHireSale->find("first",array("conditions"=>array("QuickHireSale.id"=>$callerReference[1])));
					
					$data 	  =  array(
									'SenderTokenId' => 
													array(
															'FieldValue' => $this->params->query["tokenID"], 
															'FieldType' => 'string'
														),
									'RecipientTokenId' => array(
																'FieldValue' => $taskInfo["QuickHireSale"]["tokenID"], 
																'FieldType' => 'string'
															),
									'TransactionAmount' => array(
																'FieldValue' =>$taskInfo["QuickTask"]["price"], 
																'FieldType' => 'Amazon_FPS_Model_Amount'
															),
									'TransactionAmount.CurrencyCode' => array(
																			'FieldValue' =>"USD", 
																			'FieldType' => 'Amazon_FPS_Model_Amount'
																	),
									'ChargeFeeTo' => array(
															'FieldValue' =>"Recipient", 
															'FieldType' => 'ChargeFeeTo'
														),
									'CallerReference' => array(
															'FieldValue' =>rand(), 
															'FieldType' => 'string'
														),
									//'CallerDescription' => array('FieldValue' =>rand(), 'FieldType' => 'string'),
									//'SenderDescription' => array('FieldValue' =>"Sender ".rand(), 'FieldType' => 'string'),
									'DescriptorPolicy' => array(
																'FieldValue' =>"Descriptip ".rand(), 
																'FieldType' => 'Amazon_FPS_Model_DescriptorPolicy'
														)
								);
					//echo"<pre>";print_r($data);die();
					//$repsone = $this->amazon->transferFunds($data);
					$repsone = $this->amazon->reserveFunds($data);
					if(!empty($repsone)){					
						$responses = new SimpleXMLElement($repsone["ResponseBody"]);
						
						if(!empty($responses->PayResult->TransactionId)){
							$paymentFields = array(
												"request_payments"=>"2",
												"paid_on"=>date("Y-m-d H:i:s"),
												"transaction_id" =>trim($responses->PayResult->TransactionId),
												"payment_status" =>"Completed"
											);
											
							if(!empty($callerReference[1])) {
								$paymentFields = $this->addQuote($paymentFields);
								$this->QuickHireSale->updateAll($paymentFields,array("QuickHireSale.id"=>$callerReference[1]));
							}
						}
					}
				}else
				{						
					if(!empty($this->params->query["fundingTokenID"]))
					{
						$fields = array("fundingTokenID"=>$this->params->query["fundingTokenID"],"prepaidSenderTokenID"=>$this->params->query["prepaidSenderTokenID"],"prepaidInstrumentID"=>$this->params->query["prepaidInstrumentID"]);
						
						$field  = $this->addQuote($fields);
						
						$this->Bid->updateAll($field,array("Bid.job_id"=>$this->params->named["taskid"],"Bid.member_id"=>$this->params->named["memberId"]));
					
						$fields = array("Task.assigned_user_id"=>$this->params->named["memberId"],"Task.awarded_date"=>date("Y-m-d H:i:s"),"Task.is_awarded"=>"1","Task.status"=>"1","Task.updatedOn"=>date("Y-m-d H:i:s"));
				
						$fields = $this->addQuote($fields);
						
						if( $this->Task->updateAll($fields,array("Task.id"=>$this->params->named["taskid"])) ) 
						{
							$messageUpdate = array("helper_id"=>$this->params->named["memberId"],"task_id"=>$this->params->named["taskid"],"hirer_id"=>"0","posted_by"=>$this->params->named["memberId"],"message"=>"<b>ASSIGNED to this task.</b>","postedOn"=>date("Y-m-d H:i:s"));
							
							$this->loadModel("Message");
							$this->Message->create();
							
							if( $this->Message->save($messageUpdate) ) 
							{
								$error   = 0;
								$message = "Task Successfully Assigned";					
								
								$taskInfo = $this->Task->find("first",array("fields"=>array("Task.title","Task.user_id"),"conditions"=>array("Task.id"=>$this->params->named["taskid"])));
								
								$this->Member->bindModel(array("hasMany"=>array("Alert"=>array("foreignKey"=>"member_id"))));
								$helpler = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.email","Member.helplers_email","Member.phone_number"),"conditions"=>array("Member.id"=>$this->params->named["memberId"])));
								
								$hirer = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.email","Member.helplers_email","Member.phone_number"),"conditions"=>array("Member.id"=>$taskInfo["Task"]["user_id"])));
												
								$notification = str_replace("HELPLER",$helpler["Member"]["full_name"],Configure::read('message.assignTaskHelpler'));
								$notification = str_replace("HIRER",$hirer["Member"]["full_name"],$notification);
								$notification = str_replace("TASKNAME","`".$taskInfo["Task"]["title"]."`",$notification);


								$notification1 = str_replace("HELPLER",$hirer["Member"]["full_name"],Configure::read('message.assignTaskHirer'));
								$notification1 = str_replace("HIRER",$helpler["Member"]["full_name"],$notification1);
								$notification1 = str_replace("TASKNAME","`".$taskInfo["Task"]["title"]."`",$notification1);
								
								if($helpler["Alert"][0]["email_bid_accepted_rejected"] == "1") {
									$this->sendEmailMessage($helpler["Member"]["email"],Configure::read('Website.email_subject_signature').":Task Assign Notification",$notification,null,null);
								}
								
								if($this->settings["email_get_task_assigned"] == "1") {
									$this->sendEmailMessage($hirer["Member"]["email"],Configure::read('Website.email_subject_signature').":Task Assign Notification",$notification1,null,null);
								}
								
								/* Sending SMS notification to the users*/
									if($this->settings["phone_get_task_assigned"] == "1")
									{
										if(Configure::read("testMode")){
											$email = Configure::read("phoneNumber");
										}else{
											$email = str_replace("-","",$hirer["Member"]["phone_number"]);
										}
										$email = $this->createSmsUrl($email);
										$this->sendEmailMessage($email,Configure::read('Website.email_subject_signature').":Task Assign Notification",$notification1,null,null);
									}
								/* Sending SMS notification to the users*/
								
								/* Sending SMS notification to the users*/
									if($helpler["Alert"][0]["phone_bid_accepted_rejected"] == "1")
									{
										if(Configure::read("testMode")){
											$email = Configure::read("phoneNumber");
										}else{
											$email = str_replace("-","",$helpler["Member"]["phone_number"]);
										}
										$email = $this->createSmsUrl($email);
										$this->sendEmailMessage($email,Configure::read('Website.email_subject_signature').":Task Assign Notification",$notification,null,null);
									}
								/* Sending SMS notification to the users*/
							}else{
								$error   = 1;
								$message = "Unable to assigned the task";
							}
						}
					}					
					$taskId  = $this->params->named["taskid"];
					$salesId = 0;
				}				
				$this->redirect("/members/taskposted/jobId:".$taskId."/salesId:".$salesId);
			}
		
			/* fetching all tasks */				
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"hirer_id","fields"=>array("Member.full_name","Member.logo","Member.id"))))); 
				
				$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo","Member.id"))))); 
				
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("QuickTask"=>array("foreignKey"=>"task_id"))));
				
				$this->QuickHireSale->recursive = 2;				
				$quickTaskAll = $this->QuickHireSale->find("all",array("conditions"=>array("QuickHireSale.hirer_id"=>$this->Session->read("user_id")),"order"=>"QuickHireSale.id desc"));
				
				$this->loadModel("TaskPM");
				$this->TaskPM->create();
				
				$count = 0;
				foreach( $quickTaskAll as $all ) {   
					
					if( !empty($all["QuickTask"]["Member"]) )
					{
						$quickTaskAll[$count]["amazonUrl"] = $this->amazon->generateSenderToken(array("url"=>"members/taskposted","member_id"=>"QuickHire-".$all["QuickHireSale"]["id"],"price"=>$all["QuickTask"]["price"],"taskName"=>$all["QuickTask"]["title"],"recipientToken"=>$all["QuickHireSale"]["tokenID"]));
						
						/* $quickTaskAll[$count]["QuickHireSale"]["helpler_comment"] = $this->Review->find("count",array("conditions"=>array("Review.task_id"=>$all["QuickTask"]["id"],"Review.type"=>"hirer_comment","Review.task_type"=>"0","Review.sales_id"=>$all["QuickHireSale"]["id"]))); */
						
						$messages = $this->TaskPM->find("all",array("conditions"=>array("TaskPM.job_id"=>$all["QuickHireSale"]["task_id"],"TaskPM.sales_id"=>$all["QuickHireSale"]["id"])));
							
							$messageCount = 0;
							if(!empty($messages)){ 
								foreach( $messages as $message ){
									$members = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$message["TaskPM"]["posted_by"])));
								
									$messages[$messageCount]["Member"] = $members["Member"];								
									$messageCount++;
								}
							}
							
							$quickTaskAll[$count]["messages"] = $messages;
							
							$reviews = $this->Review->find("all",array("conditions"=>array("Review.task_id"=>$task["QuickTask"]["id"],"Review.sales_id"=>$all["QuickHireSale"]["id"])));
							
							$reviewCount = 0;
							foreach( $reviews as $review ){
									
								$members = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$review["Review"]["member_id"])));
								
								$reviews[$reviewCount]["Member"] = $members["Member"];								
								$reviewCount++;
							}							
							$quickTaskAll[$count]["helpler_comment"] = $reviews;							
					
					}else{
						unset($quickTaskAll[$count]);
					}
					$count++;
				}				
				
				//echo"<pre>";print_r($quickTaskAll);die();
				/* $quickTaskAll = $this->QuickTask->find("all",array("fields"=>array("QuickTask.price","QuickTask.title","QuickTask.Expiration","QuickTask.task_location","QuickTask.user_id","QuickTask.pic","QuickTask.status","QuickTask.id","QuickTask.hirer_id"),"order"=>"QuickTask.id desc")); */
				/* $this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo")))));
				$this->QuickTask->recursive = 2;
				
				$quickTaskAll = $this->QuickTask->find("all",array("fields"=>array("QuickTask.price","QuickTask.title","QuickTask.Expiration","QuickTask.task_location","QuickTask.user_id","QuickTask.pic","QuickTask.status","QuickTask.id","QuickTask.hirer_id"),"conditions"=>array("QuickTask.hirer_id"=>$this->Session->read("user_id")),"order"=>"QuickTask.id desc")); */
								
				$this->set("quickTaskAll",$quickTaskAll);
				
				$this->validateUser();
				$this->layout = "inside_layout";	
				
				$user_id  = $this->Session->read('user_id');			
				$userInfo = $this->Member->find("first",array("conditions"=>array("Member.id"=>$user_id)));			
				$this->set("userInfo",$userInfo);	
				
				$conditions = array("Task.user_id"=>$this->Session->read("user_id"));	
				
				$this->loadModel("Bid");
				$this->Bid->create();
				
				$this->loadModel("Message");
				$this->Message->create();
				
				$this->loadModel("Review");
				$this->Review->create();
				
				$this->paginate = array('conditions' =>$conditions,'limit' => "10",'order' => array("Task.id"=>'desc'));
					
				//$jobs = $this->paginate("Task");
				$this->Task->recursive = 2;
				$jobs = $this->Task->find("all",array("conditions"=>$conditions,"order"=>"Task.id DESC"));
				$i=0;
				
				$this->loadModel("TaskPM");
				$this->TaskPM->create();
				
				foreach( $jobs as $job )
				{
					$jobs[$i]["hirer"] = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo","Member.id"),"conditions"=>array("Member.id"=>$job["Task"]["user_id"])));
					
					$jobs[$i]["assigned"] = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo","Member.id"),"conditions"=>array("Member.id"=>$job["Task"]["assigned_user_id"])));
					
					$this->Review->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"member_id","fields"=>array("Member.full_name","Member.logo","Member.id")))));
					
					$jobs[$i]["helpler_comment"] = $this->Review->find("all",array("conditions"=>array("Review.task_id"=>$job["Task"]["id"],"Review.task_type"=>"0","Review.member_id <>"=>"0")));
					
					$this->TaskPM->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"posted_by","fields"=>array("Member.full_name","Member.logo","Member.id")))));
					
					$jobs[$i]["messages"] = $this->TaskPM->find("all",array("conditions"=>array("TaskPM.job_id"=>$job["Task"]["id"])));				
				
					$bids = $this->Bid->find("list",array("fields"=>array("Bid.id","Bid.member_id"),"conditions"=>array("Bid.job_id"=>$job["Task"]["id"])));
										
					$comments = $this->Message->find("count",array("conditions"=>array("Message.task_id"=>$job["Task"]["id"],"Message.hirer_id <>"=>"0")));
					
					$members = $this->Member->find("all",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$bids)));
					
					$memberCount = 0;
					foreach( $members as $member ){
						
						//$members[$memberCount]["amazonUrl"] = $this->amazon->generateSenderToken(array("url"=>"members/taskposted","member_id"=>$job["Task"]["id"]."-".$member["Member"]["id"],"price"=>$job["Task"]["price"],"taskName"=>$job["Task"]["title"],"recipientToken"=>$job["Member"]["tokenId"]));
						
						$members[$memberCount]["amazonUrl"] = $this->amazon->reserveFunds(array("url"=>"members/taskposted/taskid:".$job["Task"]["id"]."/memberId:".$member["Member"]["id"],"member_id"=>$job["Task"]["id"]."-".$member["Member"]["id"],"amount"=>($job["Task"]["price"]+((Configure::read('Website.hirerComissionCharge')/100)*$job["Task"]["price"])),"taskName"=>$job["Task"]["title"],"recipientToken"=>$job["Member"]["tokenId"]));
					
						$memberCount++;
					}
					
					$review = $this->Review->find("count",array("conditions"=>array("Review.task_id"=>$job["Task"]["id"],"Review.type"=>"hirer_comment","Review.task_type"=>"0")));
					
					$jobs[$i]["Task"]["new_comment"] = $this->TaskPM->find("count",array("conditions"=>array("TaskPM.posted_to"=>$this->Session->read("user_id"),"TaskPM.status"=>"0","TaskPM.job_id"=>$job["Task"]["id"])));
					
					$jobs[$i]["Member"]   = $members;				
					$jobs[$i]["comments"] = $comments;				
					$jobs[$i]["Task"]["hirer_comment"] = $review;
					
					$i++;
				}
				 
				//$thips->set("jobs",$jobs);
				$this->set("jobsall",$jobs);
				$this->set("limit",10);
				
				$this->set("category",$this->Category->find("list",array("fields"=>array("id","name"),"conditions"=>array("Category.status"=>"1"))));
			
			/* Fetching all tasks */
			
			
			/* Fetching posted tasks */			
				$conditionp = array("Task.user_id"=>$this->Session->read("user_id"), "Task.status"=>'0');
				$jobsposted = $this->Task->find("all",array("conditions"=>$conditionp,"order"=>"Task.id DESC"));
				$i =0;
				foreach( $jobsposted as $posted ) 
				{
					$bids = $this->Bid->find("list",array("fields"=>array("Bid.id","Bid.member_id"),"conditions"=>array("Bid.job_id"=>$posted["Task"]["id"])));
					
					$comments = $this->Message->find("count",array("conditions"=>array("Message.task_id"=>$posted["Task"]["id"],"Message.hirer_id <>"=>"0")));
					
					$members = $this->Member->find("all",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$bids)));
					
					$memberCount = 0;
					foreach( $members as $member ){
						
						//$members[$memberCount]["amazonUrl"] = $this->amazon->generateSenderToken(array("url"=>"members/taskposted","member_id"=>$job["Task"]["id"]."-".$member["Member"]["id"],"price"=>$job["Task"]["price"],"taskName"=>$job["Task"]["title"],"recipientToken"=>$job["Member"]["tokenId"]));
						
						$members[$memberCount]["amazonUrl"] = $this->amazon->reserveFunds(array("url"=>"members/taskposted/taskid:".$job["Task"]["id"]."/memberId:".$member["Member"]["id"],"member_id"=>$posted["Task"]["id"]."-".$member["Member"]["id"],"amount"=>($posted["Task"]["price"]+((Configure::read('Website.hirerComissionCharge')/100)*$posted["Task"]["price"])),"taskName"=>$job["Task"]["title"],"recipientToken"=>$posted["Member"]["tokenId"]));
						
						$memberCount++;
					}
					
					$jobsposted[$i]["Task"]["new_comment"] = $this->TaskPM->find("count",array("conditions"=>array("TaskPM.posted_to"=>$this->Session->read("user_id"),"TaskPM.status"=>"0","TaskPM.job_id"=>$posted["Task"]["id"])));
					
					$jobsposted[$i]["Member"]   = $members;				
					$jobsposted[$i]["comments"] = $comments;	
					
					/* $jobsposted[$i]["amazonUrl"] = $this->amazon->generateSenderToken(array("url"=>"members/taskposted","member_id"=>$posted["Task"]["id"],"price"=>$posted["Task"]["price"],"taskName"=>$posted["Task"]["title"],"recipientToken"=>$posted["Member"]["tokenId"])); */
					
					$i++;
				}
				$this->set("jobsposted",$jobsposted);
				
				
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"hirer_id","fields"=>array("Member.full_name","Member.logo","Member.id"))))); 
				
				$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo","Member.id"))))); 
				
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("QuickTask"=>array("foreignKey"=>"task_id"))));
				
				$this->QuickHireSale->recursive = 2;				
				$quickPostedTask = $this->QuickHireSale->find("all",array("conditions"=>array("QuickHireSale.hirer_id"=>$this->Session->read("user_id"),"QuickHireSale.status"=>"0"),"order"=>"QuickHireSale.id desc"));
				
				$this->set("quickPostedTask",$quickPostedTask);
				/* $this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo")))));
				$this->QuickTask->recursive = 2;
			
				$this->set("quickPostedTask",$this->QuickTask->find("all",array("fields"=>array("QuickTask.price","QuickTask.title","QuickTask.Expiration","QuickTask.task_location","QuickTask.user_id","QuickTask.pic","QuickTask.status","QuickTask.id","QuickTask.hirer_id"),"conditions"=>array("QuickTask.hirer_id"=>$this->Session->read("user_id"),"QuickTask.status"=>"0"),"order"=>"QuickTask.id desc"))); */
				
			/* fetching posted task*/
			
			
			/* fetching assigned task*/
			
				$conditionw = array("Task.user_id"=>$this->Session->read("user_id"), "Task.status"=>'1');
				$jobsworking = $this->Task->find("all",array("conditions"=>$conditionw,"order"=>"Task.id DESC"));
				$i =0;
				foreach( $jobsworking as $working ) 
				{
					$this->TaskPM->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"posted_by","fields"=>array("Member.full_name","Member.logo","Member.id")))));
					
					$jobsworking[$i]["messages"] = $this->TaskPM->find("all",array("conditions"=>array("TaskPM.job_id"=>$working["Task"]["id"])));	
					
					$review = $this->Review->find("count",array("conditions"=>array("Review.task_id"=>$working["Task"]["id"],"Review.type"=>"hirer_comment","Review.task_type"=>"0")));
					
					$jobsworking[$i]["Task"]["new_comment"] = $this->TaskPM->find("count",array("conditions"=>array("TaskPM.posted_to"=>$this->Session->read("user_id"),"TaskPM.status"=>"0","TaskPM.job_id"=>$working["Task"]["id"])));
					 				
					$bids = $this->Bid->find("list",array("fields"=>array("Bid.id","Bid.member_id"),"conditions"=>array("Bid.job_id"=>$working["Task"]["id"])));
					
					$comments = $this->Message->find("count",array("conditions"=>array("Message.task_id"=>$working["Task"]["id"],"Message.hirer_id <>"=>"0")));
					
					$members = $this->Member->find("all",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$bids)));
					
					$memberCount = 0;
					foreach( $members as $member ){
						
						//$members[$memberCount]["amazonUrl"] = $this->amazon->generateSenderToken(array("url"=>"members/taskposted","member_id"=>$job["Task"]["id"]."-".$member["Member"]["id"],"price"=>$job["Task"]["price"],"taskName"=>$job["Task"]["title"],"recipientToken"=>$job["Member"]["tokenId"]));
						
						$members[$memberCount]["amazonUrl"] = $this->amazon->reserveFunds(array("url"=>"members/taskposted/taskid:".$working["Task"]["id"]."/memberId:".$member["Member"]["id"],"member_id"=>$working["Task"]["id"]."-".$member["Member"]["id"],"amount"=>($working["Task"]["price"]+((Configure::read('Website.hirerComissionCharge')/100)*$working["Task"]["price"])),"taskName"=>$working["Task"]["title"],"recipientToken"=>$working["Member"]["tokenId"]));
					
						$memberCount++;
					}
					
					$jobsworking[$i]["Task"]["new_comment"] = $this->TaskPM->find("count",array("conditions"=>array("TaskPM.posted_to"=>$this->Session->read("user_id"),"TaskPM.status"=>"0","TaskPM.job_id"=>$working["Task"]["id"])));
					
					$jobsworking[$i]["Member"]   = $members;				
					$jobsworking[$i]["comments"] = $comments;	
					$jobsworking[$i]["Task"]["hirer_comment"] = $review;	
					
					/* $jobsworking[$i]["amazonUrl"] = $this->amazon->generateSenderToken(array("url"=>"members/taskposted","member_id"=>$working["Task"]["id"],"price"=>$working["Task"]["price"],"taskName"=>$working["Task"]["title"],"recipientToken"=>$working["Member"]["tokenId"])); */
												
					$i++;
				}
				
				$this->set("jobsworking",$jobsworking);
				
				
				/* $this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo","Member.id")))));
				$this->QuickTask->recursive = 2;
			
				$this->set("quickAssignedTask",$this->QuickTask->find("all",array("fields"=>array("QuickTask.price","QuickTask.title","QuickTask.Expiration","QuickTask.task_location","QuickTask.user_id","QuickTask.pic","QuickTask.status","QuickTask.id","QuickTask.hirer_id"),"conditions"=>array("QuickTask.hirer_id"=>$this->Session->read("user_id"),"QuickTask.status"=>"1"),"order"=>"QuickTask.id desc"))); */
				
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"hirer_id","fields"=>array("Member.full_name","Member.logo","Member.id"))))); 
				
				$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo","Member.id"))))); 
				
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("QuickTask"=>array("foreignKey"=>"task_id"))));
				
				$this->QuickHireSale->recursive = 2;				
				$quickAssignedTask = $this->QuickHireSale->find("all",array("conditions"=>array("QuickHireSale.hirer_id"=>$this->Session->read("user_id"),"QuickHireSale.status"=>"1"),"order"=>"QuickHireSale.id desc"));
				
				$assignedCount = 0;
				foreach($quickAssignedTask as $assigned){
					if(empty($assigned["QuickTask"]["Member"] )){
						unset($quickAssignedTask[$assignedCount]);
					}
					$assignedCount++;
				}
				
				$this->set("quickAssignedTask",$quickAssignedTask);
				
			/* fetching the asssigned task*/
			
			
			/* Filling the completed job data */ 
				$conditionc = array("Task.user_id"=>$this->Session->read("user_id"), "Task.status"=>'3');
				$jobscomp = $this->Task->find("all",array("conditions"=>$conditionc,"order"=>"Task.id DESC")); 
				
				$i=0;
				foreach($jobscomp as $job ) 
				{
					$jobscomp[$i]["hirer"] = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo","Member.id"),"conditions"=>array("Member.id"=>$job["Task"]["user_id"])));
					
					$jobscomp[$i]["assigned"] = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo","Member.id"),"conditions"=>array("Member.id"=>$job["Task"]["assigned_user_id"])));
					
					$this->Review->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"member_id","fields"=>array("Member.full_name","Member.logo","Member.id")))));
					
					$jobscomp[$i]["helpler_comment"] = $this->Review->find("all",array("conditions"=>array("Review.task_id"=>$job["Task"]["id"],"Review.task_type"=>"0","Review.member_id <>"=>"0")));
					
					$this->TaskPM->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"posted_by","fields"=>array("Member.full_name","Member.logo","Member.id")))));
					
					$jobscomp[$i]["messages"] = $this->TaskPM->find("all",array("conditions"=>array("TaskPM.job_id"=>$job["Task"]["id"])));				
				
					$bids = $this->Bid->find("list",array("fields"=>array("Bid.id","Bid.member_id"),"conditions"=>array("Bid.job_id"=>$job["Task"]["id"])));
				
					$comments = $this->Message->find("count",array("conditions"=>array("Message.task_id"=>$job["Task"]["id"],"Message.hirer_id <>"=>"0")));
					
					$review = $this->Review->find("count",array("conditions"=>array("Review.task_id"=>$job["Task"]["id"],"Review.type"=>"hirer_comment","Review.task_type"=>"0")));
					
					$jobscomp[$i]["Task"]["new_comment"] = $this->TaskPM->find("count",array("conditions"=>array("TaskPM.posted_to"=>$this->Session->read("user_id"),"TaskPM.status"=>"0","TaskPM.job_id"=>$job["Task"]["id"])));
				
					$members = $this->Member->find("all",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$bids)));
					
					$memberCount = 0;
					/* foreach( $members as $member ){
						
						//$members[$memberCount]["amazonUrl"] = $this->amazon->generateSenderToken(array("url"=>"members/taskposted","member_id"=>$job["Task"]["id"]."-".$member["Member"]["id"],"price"=>$job["Task"]["price"],"taskName"=>$job["Task"]["title"],"recipientToken"=>$job["Member"]["tokenId"]));
						
						$members[$memberCount]["amazonUrl"] = $this->amazon->reserveFunds(array("url"=>"members/taskposted/taskid:".$job["Task"]["id"]."/memberId:".$member["Member"]["id"],"member_id"=>$job["Task"]["id"]."-".$member["Member"]["id"],"amount"=>($job["Task"]["price"]+((Configure::read('Website.hirerComissionCharge')/100)*$job["Task"]["price"])),"taskName"=>$job["Task"]["title"],"recipientToken"=>$job["Member"]["tokenId"]));
					
						$memberCount++;
					} */					
					$review = $this->Review->find("count",array("conditions"=>array("Review.task_id"=>$job["Task"]["id"],"Review.type"=>"hirer_comment","Review.task_type"=>"0")));
					
					$jobscomp[$i]["Task"]["new_comment"] = $this->TaskPM->find("count",array("conditions"=>array("TaskPM.posted_to"=>$this->Session->read("user_id"),"TaskPM.status"=>"0","TaskPM.job_id"=>$job["Task"]["id"])));
					
					$jobscomp[$i]["Member"]   = $members;				
					$jobscomp[$i]["comments"] = $comments;				
					$jobscomp[$i]["Task"]["hirer_comment"] = $review;	
					
					/* $jobscomp[$i]["amazonUrl"] = $this->amazon->generateSenderToken(array("url"=>"members/taskposted","member_id"=>$job["Task"]["id"],"price"=>$job["Task"]["price"],"taskName"=>$job["Task"]["title"],"recipientToken"=>$job["Member"]["tokenId"])); */
					
					$i++;
				}
				//echo"<pre>";print_r($jobscomp);die();
				$this->set("jobscomp",$jobscomp);
				
				/* $this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo")))));
				$this->QuickTask->recursive = 2;
			
				$this->set("quickCompletedTask",$this->QuickTask->find("all",array("fields"=>array("QuickTask.price","QuickTask.title","QuickTask.Expiration","QuickTask.task_location","QuickTask.user_id","QuickTask.pic","QuickTask.status","QuickTask.id","QuickTask.hirer_id"),"conditions"=>array("QuickTask.hirer_id"=>$this->Session->read("user_id"),"QuickTask.status"=>"3"),"order"=>"QuickTask.id desc"))); */
				
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"hirer_id","fields"=>array("Member.full_name","Member.logo","Member.id"))))); 
				
				$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo","Member.id"))))); 
				
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("QuickTask"=>array("foreignKey"=>"task_id"))));
				
				$this->QuickHireSale->recursive = 2;				
				$quickCompletedTask = $this->QuickHireSale->find("all",array("conditions"=>array("QuickHireSale.hirer_id"=>$this->Session->read("user_id"),"QuickHireSale.status"=>"3"),"order"=>"QuickHireSale.id desc"));
				//echo"<pre>";print_r($quickCompletedTask);die("sa");
				
				$count = 0;
				foreach( $quickCompletedTask as $all ) { 
					
					if(!empty($all["QuickTask"]["Member"])){
						
						$quickCompletedTask[$count]["amazonUrl"] = $this->amazon->generateSenderToken(array("url"=>"members/taskposted","member_id"=>"QuickHire-".$all["QuickHireSale"]["id"],"price"=>$all["QuickTask"]["price"],"taskName"=>$all["QuickTask"]["title"],"recipientToken"=>$all["QuickHireSale"]["tokenID"]));
					
						/* $quickCompletedTask[$count]["QuickHireSale"]["helpler_comment"] = $this->Review->find("count",array("conditions"=>array("Review.task_id"=>$all["QuickTask"]["id"],"Review.type"=>"hirer_comment","Review.task_type"=>"0","Review.sales_id"=>$all["QuickHireSale"]["id"]))); */
					
					
						$messages = $this->TaskPM->find("all",array("conditions"=>array("TaskPM.job_id"=>$all["QuickHireSale"]["task_id"],"TaskPM.sales_id"=>$all["QuickHireSale"]["id"])));
							
							$messageCount = 0;
							if(!empty($messages)){ 
								foreach( $messages as $message ){
									$members = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$message["TaskPM"]["posted_by"])));
								
									$messages[$messageCount]["Member"] = $members["Member"];								
									$messageCount++;
								}
							}
							
							$quickCompletedTask[$count]["messages"] = $messages;
							
							$reviews = $this->Review->find("all",array("conditions"=>array("Review.task_id"=>$task["QuickTask"]["id"],"Review.sales_id"=>$all["QuickHireSale"]["id"])));
							
							$reviewCount = 0;
							foreach( $reviews as $review ){
									
								$members = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$review["Review"]["member_id"])));
								
								$reviews[$reviewCount]["Member"] = $members["Member"];								
								$reviewCount++;
							}							
							$quickCompletedTask[$count]["helpler_comment"] = $reviews;					
					}else{
						unset($quickCompletedTask[$count]);
					}
					$count++;
				}				
				$this->set("quickCompletedTask",$quickCompletedTask);			
			/* Filling the completed job data */ 
			
			$conditioncls = array("Task.user_id"=>$this->Session->read("user_id"), "Task.status"=>'4');
			$this->set("jobsclosed",$this->Task->find("all",array("conditions"=>$conditioncls,"order"=>"Task.id DESC")));
			
			/* $this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo")))));
			$this->QuickTask->recursive = 2;
			
			$this->set("quickClosedTask",$this->QuickTask->find("all",array("fields"=>array("QuickTask.price","QuickTask.title","QuickTask.Expiration","QuickTask.task_location","QuickTask.user_id","QuickTask.pic","QuickTask.status","QuickTask.id","QuickTask.hirer_id"),"conditions"=>array("QuickTask.hirer_id"=>$this->Session->read("user_id"),"QuickTask.status"=>"4"),"order"=>"QuickTask.id desc"))); */
			
			$this->QuickHireSale->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"hirer_id","fields"=>array("Member.full_name","Member.logo","Member.id"))))); 
				
			$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo","Member.id"))))); 
				
			$this->QuickHireSale->bindModel(array("belongsTo"=>array("QuickTask"=>array("foreignKey"=>"task_id"))));
				
			$this->QuickHireSale->recursive = 2;				
			$quickClosedTask = $this->QuickHireSale->find("all",array("conditions"=>array("QuickHireSale.hirer_id"=>$this->Session->read("user_id"),"QuickHireSale.status"=>"4"),"order"=>"QuickHireSale.id desc"));
				
			$this->set("quickClosedTask",$quickClosedTask);

		}
		
		/**
		*Summary of Method: 	Function to view the list of quick hire tasks
		*created date: 			24th Jan 2013
		*created by:			0451
		*Database Table Access:	
		*/
		
		public function quickhiretasks(){
			
			$this->validateUser();
			//Configure::write("debug",2);
			
			$this->loadModel("QuickHireSale");
			$this->QuickHireSale->create();				
						
			
			if(!empty($this->params->query["tokenID"])) {				
				$updateFields = array("QuickHireSale.tokenID"=>$this->params->query["tokenID"],"QuickHireSale.refundTokenID"=>$this->params->query["refundTokenID"],"QuickHireSale.is_confirmed"=>1);
				
				$updateFields = $this->addQuote($updateFields);			
				if( $this->QuickHireSale->updateAll($updateFields,array("QuickHireSale.id"=>$this->params->query["callerReference"])) )
					$this->redirect("/members/quickhiretasks");
			}
			
			$this->layout = "inside_layout";			
			$user_id = $this->Session->read('user_id');			
			$userInfo = $this->Member->find("first",array("conditions"=>array("Member.id"=>$user_id)));			
			$this->set("userInfo",$userInfo);			
		
			$this->loadModel("QuickTask");
			$this->QuickTask->create();
			
			$this->loadModel("Review");
			$this->Review->create();
			
			$conditions = array("QuickTask.user_id"=>$this->Session->read("user_id"));						
			
			$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("full_name","logo")))));
			
			$this->QuickHireSale->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"hirer_id","fields"=>array("full_name","logo")))));
			
			$this->QuickTask->bindModel(array("hasMany"=>array("QuickHireSale"=>array("foreignKey"=>"task_id"))));
			$this->QuickTask->recursive = 2;
			
			$tasks = $this->QuickTask->find("all",array("conditions"=>$conditions,"order"=>"id DESC"));
			$this->amazon = $this->Components->load("Amazon"); 
			
			$i=0;			
			foreach( $tasks as $task ) {
				$j =0;				
				foreach( $task["QuickHireSale"] as $sales ) {
					$tasks[$i]["QuickHireSale"][$j]["confirmUrl"] = $this->amazon->generateRecipientToken(array("url"=>"members/quickhiretasks","member_id"=>$sales["id"],"amount"=>$task["QuickTask"]["price"]));
					$j++;
				}
				
				$tasks[$i]["QuickTask"]["helpler_comment"] = $this->Review->find("count",array("conditions"=>array("Review.task_id"=>$task["QuickTask"]["id"],"Review.type"=>"hirer_comment","Review.task_type"=>"1")));
				
				$tasks[$i]["members"] = $this->Member->find("first",array("conditions"=>array("Member.id"=>$task["QuickTask"]["hirer_id"])));
				
				$i++;			
			}
			//echo"<pre>";print_r($tasks);die();
			$this->set("tasks",$tasks);
		
			$this->set("category",$this->Category->find("list",array("fields"=>array("id","name"),"conditions"=>array("Category.status"=>"1","Category.parent_id"=>"0"))));
		}
		
		/**
		*Summary of Method: 	Function to create a new quick hire task
		*created date: 			24th Jan 2013
		*created by:			0451
		*Database Table Access:	
		*/
		
		public function createnewtask(){
			
			$this->validateUser();
			Configure::write("debug",0);
			$this->layout = "inside_layout";			
			$user_id 	  = $this->Session->read('user_id');			
			
			$this->loadModel("QuickTask");
			$this->QuickTask->create();				
			
			if($this->data) {		
				if(!empty($this->data["Task"]["task_location"])) {
					$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$this->data["Task"]["task_location"]."&sensor=true";
					$ch  = curl_init($url);
					curl_SETOPT($ch,CURLOPT_RETURNTRANSFER,true);
					$response = curl_exec($ch);
					$result   = json_decode($response);
					
					//echo"<pre>";print_r($result);
					
					if( $result->status != "ZERO_RESULTS" ){
						//$this->request->data["Task"]["address"] = $result->results[0]->formatted_address;
						$addressParts = explode(",",$result->results[0]->formatted_address);
						if(count($addressParts) == 3)
							unset($addressParts[2]);
						
						$this->request->data["Task"]["address"]   = implode(", ",$addressParts);
					} 				
				}
				
				if( !empty($this->data["Task"]["new_video"]) && ($this->data["Task"]["new_video"] != $this->data["Task"]["video"]) ) {
					$this->request->data["Task"]["video"] = $this->data["Task"]["new_video"];					
				}
				unset($this->request->data["Task"]["new_video"]);

				if( !empty($this->data["Task"]["new_pic"]) && ($this->data["Task"]["new_pic"] != $this->data["Task"]["pic"]) ) {
					$this->request->data["Task"]["pic"] = $this->data["Task"]["new_pic"];					
				}				
				unset($this->request->data["Task"]["new_pic"]);
				
				$this->request->data["QuickTask"] = $this->data["Task"];
				$id = $this->request->data["QuickTask"]["id"];
				
				unset($this->request->data["Task"]);
				unset($this->request->data["QuickTask"]["id"]);
				
				/* if( preg_match("/a/",$this->request->data["QuickTask"]["Availability"]) ){
					$this->request->data["QuickTask"]["Availability"] = str_replace("a","am",$this->request->data["QuickTask"]["Availability"]);
				}elseif( preg_match("/p/",$this->request->data["QuickTask"]["Availability"]) ){
					$this->request->data["QuickTask"]["Availability"] = str_replace("p","pm",$this->request->data["QuickTask"]["Availability"]);
				}
				
				if( preg_match("/a/",$this->request->data["QuickTask"]["Expiration"]) ){
					$this->request->data["QuickTask"]["Expiration"] = str_replace("a","am",$this->request->data["QuickTask"]["Expiration"]);
				}elseif( preg_match("/p/",$this->request->data["QuickTask"]["Expiration"]) ){
					$this->request->data["QuickTask"]["Expiration"] = str_replace("p","pm",$this->request->data["QuickTask"]["Expiration"]);
				} */
							
				$this->request->data["QuickTask"]["user_id"]      =  $this->Session->read("user_id");
				$this->request->data["QuickTask"]["posted_on"]    =  date("Y-m-d H:i:s");
				$this->request->data["QuickTask"]["updated_on"]   =  date("Y-m-d H:i:s");
				$this->request->data["QuickTask"]["Availability"] =  date("Y-m-d H:i:s",strtotime($this->request->data["QuickTask"]["Availability"]));
				$this->request->data["QuickTask"]["Expiration"]   =  date("Y-m-d H:i:s",strtotime($this->request->data["QuickTask"]["Expiration"]));
				$this->request->data["QuickTask"]["updated_on"]   =  date("Y-m-d H:i:s");
				
				//echo"<pre>";print_r($this->data["QuickTask"]);die();
				$this->QuickTask->set($this->data["QuickTask"]);
				
				if($this->QuickTask->validates()) 
				{
					if(!empty($id)) {
						$data = $this->addQuote($this->data["QuickTask"]);
						if( $this->QuickTask->updateAll($data,array("QuickTask.id"=>$id)) ) {
							$this->Session->setFlash('<span class="successClass">Tasks Successfully Created</span>');
							$this->redirect($this->config["url"]."members/quickhiretasks");
						}else{
							$this->Session->setFlash('<span class="successClass">Tasks Successfully Created</span>');
						}
					}else{
						//echo"<pre>";print_r($this->data["QuickTask"]);die();
						if( $this->QuickTask->save($this->data["QuickTask"]) ) {
							$this->Session->setFlash('<span class="successClass">Tasks Successfully Created</span>');
							$this->redirect($this->config["url"]."members/quickhiretasks");
						}else{
							$this->Session->setFlash('<span class="successClass">Tasks Successfully Created</span>');
						}
					}
				}
			}
			
			if(!empty($this->params["pass"][0])) {
				$conditions = array("QuickTask.user_id"=>$this->Session->read("user_id"),"QuickTask.id"=>$this->params["pass"][0]);				
				$data = $this->QuickTask->find("first",array("conditions"=>$conditions));
				$this->request->data["Task"] = $data["QuickTask"];
			}else{
				$this->request->data["Task"] = $this->QuickTask->loadDefault();
			}
			
			$userInfo 	  = $this->Member->find("first",array("conditions"=>array("Member.id"=>$user_id)));
			$this->set("userInfo",$userInfo);
			
			$this->set("category",$this->Category->find("list",array("fields"=>array("id","name"),"conditions"=>array("Category.status"=>"1","Category.parent_id"=>"0"))));		
		
		}
		
		/**
		*Summary of Method: 	Function to view the messages
		*created date: 			24th Jan 2013
		*created by:			0451
		*Database Table Access:	
		*/
		
		public function messages(){
			
			$this->validateUser();
			Configure::write("debug",0);
			
			$this->layout = "inside_layout";			
			$user_id = $this->Session->read('user_id');			
			$userInfo = $this->Member->find("first",array("conditions"=>array("Member.id"=>$user_id)));
			
			$this->set("userInfo",$userInfo);
			
			$this->loadModel("TaskPM");
			$this->TaskPM->Create();				
			
			/* Task Running*/		  
			$this->Task->recursive = 2;
			$taskRunning = $this->Task->find("all",array("fields"=>array("Task.id","Task.user_id","Task.title","Task.status"),"conditions"=>array("Task.assigned_user_id"=>$this->Session->read("user_id"),"Task.status <>"=>"4")));
			
			$i =0;
			if(!empty($taskRunning)){				
				foreach( $taskRunning as $running ) {
				
					$this->TaskPM->bindModel(array("belongsTo"=>array("Member"=>array("fields"=>array("Member.full_name","Member.id"),"foreignKey"=>"posted_by"))));
					
					$taskPm = $this->TaskPM->find("all",array("conditions"=>array("TaskPM.job_id"=>$running["Task"]["id"]),"order"=>"TaskPM.id DESC"));
									
					$messageCount = $this->TaskPM->find("count",array("conditions"=>array("TaskPM.status"=>"0","TaskPM.job_id"=>$running["Task"]["id"],"TaskPM.posted_to"=>$this->Session->read("user_id"))));
					 
					$member = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo","Member.id"),"conditions"=>array("Member.id"=>$running["Task"]["user_id"])));
									
					$taskRunning[$i]["messageCount"] = $messageCount;
					$taskRunning[$i]["messages"]	  = $taskPm;
					$taskRunning[$i]["Member"]   	  = $member["Member"];
					$i++;
				}			
			}
			
			$this->set("taskRunning",$taskRunning);
			
			/* QuickTask running*/
					
				$this->loadModel("QuickHireSale");	
				$this->QuickHireSale->create();
				
				$conditions = array("QuickTask.user_id"=>$this->Session->read("user_id"),"QuickTask.status <>"=>"2");
				$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo","Member.id")))));
				
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"hirer_id","fields"=>array("Member.full_name","Member.logo","Member.id")))));
				
				$this->QuickTask->bindModel(array("hasMany"=>array("QuickHireSale"=>array("foreignKey"=>"task_id","conditions"=>array("QuickHireSale.id <>"=>"")))));
				
				$this->QuickTask->recursive = 2;
				$allQuicktasks = $this->QuickTask->find("all",array("conditions"=>$conditions,"order"=>"QuickTask.id DESC"));
				
				Configure::write("debug",0);
				$i=0;
				foreach( $allQuicktasks as $task ) {					
					if(!empty($task["QuickHireSale"])){
						$j=0;
						foreach( $task["QuickHireSale"] as $sale ) 
						{							
							$this->TaskPM->bindModel(array("belongsTo"=>array("Member"=>array("fields"=>array("Member.full_name","Member.id"),"foreignKey"=>"posted_by"))));
							
							$taskPm = $this->TaskPM->find("all",array("conditions"=>array("TaskPM.job_id"=>$task["QuickTask"]["id"],"TaskPM.sales_id"=>$sale["id"]),"order"=>"TaskPM.id DESC"));
							//echo"<pre>";print_r($taskPm)
							
							$messageCount = $this->TaskPM->find("count",array("conditions"=>array("TaskPM.sales_id"=>$sale["id"],"TaskPM.status"=>"0","TaskPM.job_id"=>$task["QuickTask"]["id"],"TaskPM.posted_to"=>$this->Session->read("user_id"))));
							 
							$member = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo","Member.id"),"conditions"=>array("Member.id"=>$task["QuickTask"]["user_id"])));
											
							$allQuicktasks[$i]["QuickHireSale"][$j]["messageCount"] = $messageCount;
							$allQuicktasks[$i]["QuickHireSale"][$j]["messages"]	    = $taskPm;
							//$allQuicktasks[$j]["messages"]["Member"]   	   = $member["Member"];
						
							$j++;
						}
					}else{
						unset($allQuicktasks[$i]);
					}
					$i++;
				}
				
				//echo"<pre>";print_r($allQuicktasks);die();
				$this->set("allQuicktasks",$allQuicktasks);
			/* QuickTask running*/
			
			
			/* Task Running*/ 
			 
			$taskPosted = $this->Task->find("all",array("fields"=>array("Task.id","Task.user_id","Task.assigned_user_id","Task.title","Task.status"),"conditions"=>array("Task.user_id"=>$this->Session->read("user_id"),"Task.status <>"=>"4")));
			$i=0;
			
			if(!empty($taskPosted)){			
				//echo"<pre>";print_r($taskPosted);die();
				foreach( $taskPosted as $posted ) {
				
					$this->TaskPM->bindModel(array("belongsTo"=>array("Member"=>array("fields"=>array("Member.full_name","Member.id"),"foreignKey"=>"posted_by"))));
					
					$taskPm = $this->TaskPM->find("all",array("conditions"=>array("TaskPM.job_id"=>$posted["Task"]["id"]),"order"=>"TaskPM.id DESC"));
									
					$messageCount = $this->TaskPM->find("count",array("conditions"=>array("TaskPM.status"=>"0","TaskPM.job_id"=>$posted["Task"]["id"],"TaskPM.posted_to"=>$this->Session->read("user_id"))));
									
					$member = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo","Member.id"),"conditions"=>array("Member.id"=>$posted["Task"]["user_id"])));
					
					$taskPosted[$i]["messageCount"] = $messageCount;
					$taskPosted[$i]["messages"]	 = $taskPm;
					$taskPosted[$i]["Member"]   = $member["Member"];
					
					$i++;
				}	
			}

			//echo"<pre>";print_r($taskPosted);die();	
				
 			/* QuickTask posted*/
			Configure::write("debug",0);
			
			$this->QuickHireSale->recursive = 2;
			$quickTaskPosted = $this->QuickHireSale->find("all",array("conditions"=>array("QuickHireSale.hirer_id"=>$this->Session->read("user_id"),"QuickHireSale.status"=>array("1","3"))));
									
			/* $quickTaskPosted = $this->QuickTask->find("all",array("fields"=>array("QuickTask.id","QuickTask.hirer_id","QuickTask.title","QuickTask.status","QuickTask.user_id"),"conditions"=>array("QuickTask.hirer_id"=>$this->Session->read("user_id"),"QuickTask.status <>"=>"4"))); */
			$i = 0;
			
			if(!empty($quickTaskPosted)){			
				foreach( $quickTaskPosted as $posted ) {
					
					$quickTask = $this->QuickTask->find("first",array("conditions"=>array("QuickTask.id"=>$posted["QuickHireSale"]["task_id"])));				
					
					$quickTaskPosted[$i]["QuickTask"] = $quickTask["QuickTask"];
								
					$this->TaskPM->bindModel(array("belongsTo"=>array("Member"=>array("fields"=>array("Member.full_name","Member.id"),"foreignKey"=>"posted_by"))));
					
					$taskPm = $this->TaskPM->find("all",array("conditions"=>array("TaskPM.job_id"=>$quickTask["QuickTask"]["id"],"TaskPM.sales_id"=>$posted["QuickHireSale"]["id"]),"order"=>"TaskPM.id DESC"));
				
					$messageCount = $this->TaskPM->find("count",array("conditions"=>array("TaskPM.status"=>"0","TaskPM.job_id"=>$quickTask["QuickTask"]["id"],"TaskPM.posted_to"=>$this->Session->read("user_id"))));
								
					$member = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo","Member.id"),"conditions"=>array("Member.id"=>$posted["QuickHireSale"]["hirer_id"])));
					
					$quickTaskPosted[$i]["messageCount"] = $messageCount;
					$quickTaskPosted[$i]["messages"]	 = $taskPm;
					$quickTaskPosted[$i]["Member"]  	 = $member["Member"];
					
					$i++;
				}
			}
			//echo"<pre>";print_r($quickTaskPosted);die();	
			$this->set("quickTaskPosted",$quickTaskPosted);
			$this->set("taskPosted",$taskPosted);
			/* Task Posted*/
			
			$salesId = 0;
			if(!empty($this->params["pass"][1]))
				$salesId = $this->params["pass"][1];
			
			$this->set("salesId",$salesId);
		
		}
		
		/**
		*Summary of Method: 	Function to set the alerts received from the website
		*created date: 			24th Jan 2013
		*created by:			0451
		*Database Table Access:	
		*/
		
		public function alerts()
		{
			Configure::write("debug",0);
			$this->validateUser();
			$this->layout = "inside_layout";
			
			$this->loadModel("Alert");
			$this->Alert->create();
			
			$user_id = $this->Session->read('user_id');
			$userInfo = $this->Member->find("first",array("conditions"=>array("Member.id"=>$user_id)));
			//echo"<pre>";print_r($userInfo);die();
			$this->set("userInfo",$userInfo);
			
			$this->set("alerts",$this->Alert->find("first",array("conditions"=>array("Alert.member_id"=>$this->Session->read("user_id")))));
		
		}
		
		/**
		*Summary of Method: 	Function to view the list of reveiws received
		*created date: 			24th Jan 2013
		*created by:			0451
		*Database Table Access:	
		*/
		
		public function reviews()
		{
			Configure::write("debug",0);
			$this->validateUser();
			$this->layout = "inside_layout";
			
			$user_id = $this->Session->read('user_id');			
			$userInfo = $this->Member->find("first",array("conditions"=>array("Member.id"=>$user_id)));			
			$this->set("userInfo",$userInfo);			
			
			/* I have runninggg  */
			$allTask = $this->Task->find("all",array("fields"=>array("Task.id","Task.title","Task.status","Task.user_id"),"conditions"=>array("Task.status"=>3,"Task.assigned_user_id"=>$this->Session->read("user_id")),"order"=>"Task.id desc"));
				
			$this->loadModel("Review");
			$this->Review->create();
				
			$i=0;					
			foreach( $allTask as $tasks) {
				
				$reviews = $this->Review->find("all",array("fields"=>array("posted_on","member_id","reviews","ratings"),"conditions"=>array("Review.task_id"=>$tasks["Task"]["id"])));				
				
				if(!empty($reviews)){
					$reviewCount = 0;
					foreach( $reviews as $review) {
						$postedBy = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$review["Review"]["member_id"])));
						
						$reviews[$reviewCount]["Review"]["posterInfo"] = $postedBy["Member"];
						$reviewCount++;						
					}
					$allTask[$i]["Task"]["helpler_comment"] = $reviews;
				}else{
					$allTask[$i]["Task"]["helpler_comment"] = $reviews;
				}
				
				$allTask[$i]["Task"]["Member"] = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$tasks["Task"]["user_id"])));
					
				$i++;					
			}				
			
			$this->loadModel("QuickHireSale");
			$this->QuickHireSale->create();
			
			$this->QuickTask->bindModel(array("hasMany"=>array("QuickHireSale"=>array("foreignKey"=>"task_id"))));
			
			$allQuickTask = $this->QuickTask->find("all",array("fields"=>array("QuickTask.id","QuickTask.title","QuickTask.status","QuickTask.user_id"),"conditions"=>array("QuickTask.user_id"=>$this->Session->read("user_id")),"order"=>"QuickTask.id desc"));
					
			$this->loadModel("Review");
			$this->Review->create();
				
			$i=0;					
			foreach( $allQuickTask as $tasks) {
				
				if(!empty($tasks["QuickHireSale"])){
					$j=0;
					foreach( $tasks["QuickHireSale"] as $sales ){
						$reviews = $this->Review->find("all",array("fields"=>array("posted_on","member_id","reviews","ratings"),"conditions"=>array("Review.task_id"=>$tasks["QuickTask"]["id"],"Review.sales_id"=>$sales["id"])));
				
						if( !empty($reviews) ) {
							$reviewCount = 0;
							foreach( $reviews as $review) {
								$postedBy = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$review["Review"]["member_id"])));
								
								$reviews[$reviewCount]["Review"]["posterInfo"] = $postedBy["Member"];
								$reviewCount++;						
							}
							$allQuickTask[$i]["QuickHireSale"][$j]["helpler_comment"] = $reviews;
						}else{
							$allQuickTask[$i]["QuickHireSale"][$j]["helpler_comment"] = $reviews;
						}
						$j++;
					}
				}
				
				$allQuickTask[$i]["QuickTask"]["Member"] = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$tasks["QuickTask"]["user_id"])));
			
				$i++;					
			}			
			 
			$this->set("allQuickTask",$allQuickTask);
			$this->set("allTask",$allTask);
			/* I have runninggg  */
			
			
			/* I have posted  */
			$postedTask = $this->Task->find("all",array("fields"=>array("Task.id","Task.title","Task.status","Task.user_id"),"conditions"=>array("Task.status"=>3,"Task.user_id"=>$this->Session->read("user_id")),"order"=>"Task.id desc"));
				
			$this->loadModel("Review");
			$this->Review->create();
				
			$i=0;					
			foreach( $postedTask as $tasks) {				
				
				$reviews = $this->Review->find("all",array("fields"=>array("posted_on","member_id","reviews","ratings"),"conditions"=>array("Review.task_id"=>$tasks["Task"]["id"])));				
				
				if(!empty($reviews)){
					$reviewCount = 0;
					foreach( $reviews as $review) {
						$postedBy = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$review["Review"]["member_id"])));
						
						$reviews[$reviewCount]["Review"]["posterInfo"] = $postedBy["Member"];
						$reviewCount++;						
					}
					$postedTask[$i]["Task"]["helpler_comment"] = $reviews;
				}else{
					$postedTask[$i]["Task"]["helpler_comment"] = $reviews;
				}
				
				$postedTask[$i]["Task"]["Member"] = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$tasks["Task"]["user_id"])));
				
				/* $review =  $this->Review->find("first",array("fields"=>array("posted_on","member_id","reviews","ratings"),"conditions"=>array("Review.task_id"=>$tasks["Task"]["id"],"Review.type"=>"hirer_comment")));
				
				$postedTask[$i]["Task"]["helpler_comment"] = $review["Review"];
				
				$postedBy = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$review["Review"]["member_id"])));
				
				$postedTask[$i]["Task"]["helpler_comment"]["Member"] = $postedBy["Member"];
				
				$postedTask[$i]["Task"]["Member"] = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$tasks["Task"]["user_id"]))); */
				
				$i++;					
			}
			
		
			/* $postedQuickTask = $this->QuickTask->find("all",array("fields"=>array("QuickTask.id","QuickTask.title","QuickTask.status","QuickTask.user_id"),"conditions"=>array("QuickTask.status"=>3,"QuickTask.hirer_id"=>$this->Session->read("user_id")),"order"=>"QuickTask.id desc")); */
			
			$this->loadModel("QuickHireSale");
			$this->QuickHireSale->create();
			
			$this->QuickHireSale->bindModel(array("belongsTo"=>array("QuickTask"=>array("foreignKey"=>"task_id"))));
			
			$postedQuickTask = $this->QuickHireSale->find("all",array("conditions"=>array("QuickHireSale.hirer_id"=>$this->Session->read("user_id"),"QuickHireSale.status"=>3),"order"=>"QuickHireSale.id desc"));
				
			$this->loadModel("Review");
			$this->Review->create();
				
			$i=0;					
			foreach( $postedQuickTask as $tasks) {
				
				$reviews = $this->Review->find("all",array("fields"=>array("posted_on","member_id","reviews","ratings"),"conditions"=>array("Review.task_id"=>$tasks["QuickTask"]["id"],"Review.sales_id"=>$tasks["QuickHireSale"]["id"])));				
				
				if(!empty($reviews)){
					$reviewCount = 0;
					foreach( $reviews as $review) {
						$postedBy = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$review["Review"]["member_id"])));
						
						$reviews[$reviewCount]["Review"]["posterInfo"] = $postedBy["Member"];
						$reviewCount++;						
					}
					$postedQuickTask[$i]["QuickTask"]["helpler_comment"] = $reviews;
				}else{
					$postedQuickTask[$i]["QuickTask"]["helpler_comment"] = $reviews;
				}
				
				$postedQuickTask[$i]["QuickTask"]["Member"] = $this->Member->find("first",array("fields"=>array("Member.id","Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$tasks["QuickTask"]["user_id"])));
					
				$i++;					
			}			
			
			$this->set("postedQuickTask",$postedQuickTask);			
			//echo"<pre>";print_r($postedQuickTask);die;
			$this->set("postedTask",$postedTask);
			/* I have posted  */
		} 
		
		/**
		*Summary of Method: 	Function to invite the friends using the facebook and also to invite the friends using email
		*created date: 			24th Jan 2013
		*created by:			0451
		*Database Table Access:	
		*/
		
		public function invitefriends(){
			
			$this->layout = "inside_layout";
			$this->validateUser();			
			$user_id = $this->Session->read('user_id');			
			$userInfo = $this->Member->find("first",array("conditions"=>array("Member.id"=>$user_id)));			
			$this->set("userInfo",$userInfo);
		}
		
		public function wallPost() {
			
			Configure::write('debug',2);
			$this->facebook	 =  $this->Components->load('Facebook');
			$this->facebook->postToWall($this->data["token"]);
			die;
		}	
		
		public function emailInvite() {
			
			$this->validateUser();
			$this->layout = "";	 
			if(!empty($this->data["Member"]["emails"])) 
			{				
				$user_id  = $this->Session->read('user_id');
				$userInfo = $this->Member->find("first",array("fields"=>array("Member.first_name","Member.last_name"),"conditions"=>array("Member.id"=>$user_id)));
			
				$email   = trim($this->data["Member"]["emails"]);
				$emails  = explode(",",$email);
				$content = str_replace("SENDER",$userInfo["Member"]["first_name"]." ".$userInfo["Member"]["last_name"],Configure::read('message.emailInvitation'));
				
				foreach( $emails as $email )
				{
					$name    = explode("@",$email);
					$content = str_replace("MAILNAME",$name[0],Configure::read('message.emailInvitation'));
					if($this->data["Member"]["message"] != "Please write your message here!")
						$content = str_replace("CUSTOM",$this->data["Member"]["message"],$content);
					else
						$content = str_replace("CUSTOM","",$content);
						
					$subject = "Invitation to join ".Configure::read('Website.base_title');
					$this->sendEmailMessage($email,$subject,$content,null,null);
				}
				echo "send";
				exit;
			}
		}
		
		/**
		*Summary of Method:	Function is used to destroy the session of logged in user
		*created date: 28th Jan 2013			
		*created by: 0451			
		*Database Table Access:	members
		*Modified date:			
		*/		
		
		public function logout() 

		{

			$this->Member->updateAll(array("Member.isOnline"=>"0"),array("Member.id"=>$this->Session->read("user_id")));
			$this->Session->destroy();
			$this->redirect($this->config["url"]);
		}		
		
		/**
		*Summary of Method:	Function is used to destroy the session of logged in user
		*created date: 28th Jan 2013			
		*created by: 0451			
		*Database Table Access:	members
		*Modified date:			
		*/		
		
		
		
		
		
		
		
		
		
	
		
		
		
		
		function removePic() {
				
			$this->layout = '';
			$this->render = false;
		
			if($this->data) {
				
				//$userPic = $this->Club->find("first",array("fields"=>array("logo"),"conditions"=>array("Club.id"=>$this->data["id"])));
				
				
				$userPic = $this->Club->find("first",array("fields"=>array("website_logo"),"conditions"=>array("Club.id"=>$this->data["id"])));
				
				//$picPath = $this->config["upload_path"].$userPic["Club"]["logo"];
								
				$picPath = $this->config["upload_path"].$userPic["Club"]["website_logo"];
				
				unlink($picPath);
				
				$data["website_logo"] = null;
				if( $this->Club->updateAll($data,array("Club.id"=>$this->data["id"])) ) {
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully updated");
				}else{
					$response = array("responseclassName"=>"nFailure","errorMsg"=>"unable to process the request");
				}
				echo json_encode($response);
				exit;	
			}
		
		}
		
		
		
		
		
		
		
	
					

		
		
		
		public function checkDatabase() {
		
			Configure::write("debug",2);
					
			$con = mysql_connect('localhost','bmain_mkt3839','Mo8cd9zRcw');
			mysql_select_db("bmain_marketplace3839",$con);
			
/* 			$sql   = "UPDATE quick_task_jobs SET video = 'tasks_videos_1361188335.flv' WHERE id = 100";
			mysql_query($sql); */
			
			$sql   = "SELECT * FROM members";
			$query = mysql_query($sql);
			WHILE($row = mysql_fetch_array($query,MYSQL_ASSOC)){
				//echo $row["id"]." ".$row["title"]." ".$row["video"]."<br/>";
				echo $row["email"]." === ".$row["password"]."<br/>";
			}
			DIE("DONE");
			

		
		}
		
		
	
		/**************Clubs Branches Start Here******************/
		public function admin_branch($status = null)
		{			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by email or Branch Name...") ) {					
					$conditions["OR"] = array(
												"ClubBranch.branch_name LIKE" => "%".$this->data["keyword"]."%",
												"ClubBranch.email LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['ClubBranch']['statusTop']) ) {
							$action = $this->data['ClubBranch']['statusTop'];
						}elseif( !empty($this->data['ClubBranch']['status'])) {
							$action = $this->data['ClubBranch']['status'];
						}
						
						if(isset($this->data['ClubBranch']['id']) && count($this->data['ClubBranch']['id']) > 0) {
							$this->update_statusb(trim($action), $this->data['ClubBranch']['id'], count($this->data['ClubBranch']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by email or Branch Name...') && $this->data["submit"]=='Search'){
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
									"ClubBranch.branch_name LIKE" => "%".$this->params["named"]["keyword"]."%",
									"ClubBranch.email LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('ClubBranch.branch_name' => 'ASC'));
			$branches = $this->paginate('ClubBranch'); //default take the current
			$this->set('branches', $branches);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['ClubBranch']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['ClubBranch']['options']['page']);
		}
		public function admin_addbranch(){
			
			
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
			
			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));
			
			if(!empty($this->data)) {
		
				$this->ClubBranch->set($this->data);
				if($this->ClubBranch->validates()) {
						
					    
					    $this->request->data["ClubBranch"]["username"] 		    = $this->data["ClubBranch"]["email"] ;
					    $this->request->data["ClubBranch"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["ClubBranch"]["modified_date"] 		    = date("Y-m-d h:i:s");
					    	//pr($this->request->data);
					    //$this->loadModel('ClubBranch');
					   
						if($this->ClubBranch->save($this->request->data)) {	
										
							$this->Session->setFlash('Branch has been created successfully.');
							$this->redirect('/admin/clubs/branch/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_viewbranch(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("clubInfo",$this->ClubBranch->find("first",array("conditions"=>array("ClubBranch.id"=>$this->params["pass"][0]))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_editbranch($id = null)
		{
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));
			
			if(!empty($this->data)){
			
			$this->ClubBranch->set($this->data);
			$this->ClubBranch->id = $this->data['ClubBranch']['id'];		
			
							
			if($this->ClubBranch->validates()) {
				
				
				$this->request->data["ClubBranch"]["username"] 		    = $this->data['ClubBranch']['email'];	
				$this->request->data["ClubBranch"]["modified_date"] 		    = date("Y-m-d h:i:s");
				if($this->ClubBranch->save($this->data)) {
					$this->Session->setFlash('Branch information has been updated successfully.');
					$this->redirect('/admin/clubs/branch/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
				//$this->request->data["Club"]["logo"]=$this->request->data["Club"]["old_image"];				
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->ClubBranch->id = $id;
						$this->request->data = $this->ClubBranch->read();
					} else {
						$this->Session->setFlash('Invalid Branch id.');
						$this->redirect('/admin/clubs/branch/');
				}
			}	
		}
		
		/**********************Manage Club Contacts***************************/
		
	public function admin_addcontact(){
			
			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));
			$branches=$this->ClubBranch->find('list',array('fields'=>array('ClubBranch.id','ClubBranch.branch_name')));
			$this->set('branches',$branches);
			//$this->set("branches",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));
			
			if(!empty($this->data)) {
		
				$this->ClubContact->set($this->data);
				if($this->ClubContact->validates()) {
						
					    
					    $this->request->data["ClubContact"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["ClubContact"]["modified_date"] 		    = date("Y-m-d h:i:s");
					    	//pr($this->request->data);
					    //$this->loadModel('ClubBranch');
					   
						if($this->ClubContact->save($this->request->data)) {	
										
							$this->Session->setFlash('Contact has been created successfully.');
							$this->redirect('/admin/clubs/contact/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
	function listbranches()
			{
				$this->layout = '';
				$this->render = false;
				if($this->data)
				{
				 	$array = $_POST['club_branches']; // order in 'In' clause
					$condition = array('ClubBranch.club_id' => $array);
					$branchData = $this->ClubBranch->find('all',array('fields'=>array('ClubBranch.id','ClubBranch.branch_name'),"conditions"=>$condition));
				 			
				 	$tra = '<select id="ClubContactBranchId" class="validate[required]" name="data[ClubContact][branch_id]">';
				 	$tra .='<option value="">-- Select Club --</option>';
					foreach($branchData as $val)
				 	{
				 		$tra .='<option value="'.$val['ClubBranch']['id'].'">'.$val['ClubBranch']['branch_name'].'</option>';
				 	}
				 	
				 	$tra .='</select>';
				}
				echo $tra;
				exit;
			}
			
			public function admin_viewcontact(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("clubInfo",$this->ClubContact->find("first",array("conditions"=>array("ClubContact.id"=>$this->params["pass"][0]))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_editcontact($id = null)
		{
				
			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));
			$branches=$this->ClubBranch->find('list',array('fields'=>array('ClubBranch.id','ClubBranch.branch_name')));
			$this->set('branches',$branches);
			
			if(!empty($this->data)){
			
			$this->ClubContact->set($this->data);
			$this->ClubContact->id = $this->data['ClubContact']['id'];		
			
							
			if($this->ClubContact->validates()) {
				
				
				$this->request->data["ClubContact"]["modified_date"] 		    = date("Y-m-d h:i:s");
				if($this->ClubContact->save($this->data)) {
					$this->Session->setFlash('Contact information has been updated successfully.');
					$this->redirect('/admin/clubs/contact/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
				//$this->request->data["Club"]["logo"]=$this->request->data["Club"]["old_image"];				
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->ClubContact->id = $id;
						$this->request->data = $this->ClubContact->read();
					} else {
						$this->Session->setFlash('Invalid contact id.');
						$this->redirect('/admin/clubs/contact/');
				}
			}	
		}
		
		public function admin_contact($status = null)
		{			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by email or contact Name...") ) {					
					$conditions["OR"] = array(
												"ClubContact.title LIKE" => "%".$this->data["keyword"]."%",
												"ClubContact.email LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['ClubContact']['statusTop']) ) {
							$action = $this->data['ClubContact']['statusTop'];
						}elseif( !empty($this->data['ClubContact']['status'])) {
							$action = $this->data['ClubContact']['status'];
						}
						
						if(isset($this->data['ClubContact']['id']) && count($this->data['ClubContact']['id']) > 0) {
							$this->update_statusc(trim($action), $this->data['ClubContact']['id'], count($this->data['ClubContact']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by email or Contact Name...') && $this->data["submit"]=='Search'){
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
									"ClubContact.title LIKE" => "%".$this->params["named"]["keyword"]."%",
									"ClubContact.email LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('ClubContact.title' => 'ASC'));
			$contacts = $this->paginate('ClubContact'); //default take the current
			$this->set('contacts', $contacts);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['ClubContact']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['ClubContact']['options']['page']);
		}
		public function update_statusc($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->ClubContact->id = $ids[$ctr];
						$this->ClubContact->saveField("status", '1');
					}
					$this->Session->setFlash('Contact(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->ClubContact->id = $ids[$ctr];
						$this->ClubContact->saveField("status", '0');
					}
					$this->Session->setFlash('Contact(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->ClubContact->create();
						$this->ClubContact->id = $ids[$i];
						
						$this->ClubContact->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Contact(s) has been deleted successfully.');
					break;
			}
		}
				function register(){
				$mailfetchtype = 'Registration Mail';
				$condition= array('mails_type'=>$mailfetchtype,'status'=>'1');	
				$mailcontentfetch = $this->Managemail->find('first',array('conditions'=>$condition));
				$this->set("mailcontentfetch",$mailcontentfetch);
				$this->layout='register';
			
				$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
				
				
				$this->Club->set($this->data);
				if($this->Club->validates()) {
				if(!empty($this->data)) {
				
				
				if(!empty($this->data["Club"]["password"]) && ($this->data["Club"]["password"]==$this->data["Club"]["con_password"]))
					    {
					   
		
				//$this->Club->set($this->data);
				//if($this->Club->validates()) {
						if( !empty($this->data["Club"]["logo"]) ) {
							
							$filename = $this->data["Club"]["logo"]["name"];
							$target = $this->config["upload_path"];
							$this->Upload->upload($this->data["Club"]["logo"], $target, null, null);
  					        $this->request->data["Club"]["logo"] = $this->Upload->result; 					
						}else{	
							
							unset($this->request->data["Club"]["logo"]);
							$this->request->data["Club"]["logo"] = '';							
					    }
					    
					    
					    $this->request->data["Club"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Club"]["modified_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Club"]["status"]= 1;
						$this->request->data["Club"]["username"]= $this->request->data["Club"]["email"];
						$this->request->data["Club"]["notification_status"]= 1;
					    	
						if($this->Club->save($this->data)) {
							
							
							$this->send_welcome_email($this->request->data["Club"]["email"],$this->request->data["Club"]["first_name"],$this->request->data["Club"]["password"],$this->request->data["Club"]["last_name"],$this->request->data["Club"]["username"],$mailcontentfetch['Managemail']['content'],$mailcontentfetch['Managemail']['subject']);
							$this->send_welcome_email_admin($this->request->data["Club"]["email"],$this->request->data["Club"]["first_name"],$this->request->data["Club"]["password"],$this->request->data["Club"]["last_name"],$this->request->data["Club"]["username"],$mailcontentfetch['Managemail']['content'],$mailcontentfetch['Managemail']['subject']);
							$this->Session->setFlash('Your account has been created successfully.We have sent welcome mail in your registered email address.');
							$dbusertype='Club';
							$data_array=array();
							$data_array[$dbusertype]['username']=$this->request->data["Club"]["username"];
							$data_array[$dbusertype]['id']=$this->Club->getLastInsertId();
							$data_array[$dbusertype]['first_name']=$this->request->data["Club"]["first_name"];
							
							$this->Session->write('USER_ID', $data_array[$dbusertype]['id']);
					$this->Session->write('USER_NAME', $data_array[$dbusertype]['username']);
					$this->Session->write('UNAME', $data_array[$dbusertype]['first_name']);
					$this->Session->write('UTYPE', $dbusertype);
							$this->redirect('/Clubs/communication_center');
							
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				//}	
			}
			else {
				$this->Session->setFlash('Please Enter Confirm  Password same as Password.');
			}
		}
		}
			
		}
		function send_welcome_email($emailaddress,$name,$pass,$lname,$username,$mail_con,$mail_sub) {
		App::uses('CakeEmail', 'Network/Email');		
		$email = new CakeEmail();		
		$email->emailFormat('html');
	
				
				 $content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hi '.$name.' !</p>
				
				
				
				</td></tr><tr><td>'.$mail_con.' <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(WEBSITE_FROM_EMAIL => $this->config['base_title_trainer']));
		$email->to($emailaddress);
		//$email->cc('rprasad@sampatti.com');
		$subtxt = __($mail_sub);
		$email->subject($mail_sub);
		$email->send($content);
	}
	
	
	function send_welcome_email_admin($emailaddress,$name,$pass,$lname,$username,$mail_con,$mail_sub) {
		App::uses('CakeEmail', 'Network/Email');		
		$email = new CakeEmail();		
		$email->emailFormat('html');
	
				
				 $content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Dear Admin!</p>
				<p>A New Club User has been registerd on '.$this->config["base_title"].' site. </p>				
				<p>Please find below the login credentials</p>
				<p>Email is'.' '.$emailaddress.'</p>
				<p>Password is'.' '.$pass.'</p>
				</td></tr><tr><td><br/>'.$mail_con.' <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(WEBSITE_FROM_EMAIL => WEBSITENAME));
		$email->to($this->config['email_admin_free_trial']);
		//$email->cc('rprasad@sampatti.com');
		$subtxt = __('New Club User Registration');
		$email->subject($subtxt);
		$email->send($content);
	}
	
	
	
	function send_delete_trainer_email_admin($trfname,$trlname,$tremail,$clname,$clemail) {
		App::uses('CakeEmail', 'Network/Email');		
		$email = new CakeEmail();		
		$email->emailFormat('html');	
				
				 $content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Dear Admin!</p>
				<p>A Trainer has been deleted by club.</p>				
				<p>Please find below the details</p>
				<p>Club Email - '.' '.$clemail.'</p>
				<p>Club Name - '.' '.$clname.'</p>
				<p>Trainer Email - '.' '.$tremail.'</p>
				<p>Trainer Name - '.' '.$trfname.' '.$trlname.'</p>
				</td></tr><tr><td><br/>Thanks,<br />Fitness Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(WEBSITE_FROM_EMAIL => WEBSITENAME));
		$email->to('registration@ptpfitpro.com');
		//$email->cc('rprasad@sampatti.com');
		$subtxt = __('Club owner deleted a trainer');
		$email->subject($subtxt);
		$email->send($content);
	}
	
	
	
	public function upgradesubs()
		{	
			$this->layout='';
			$this->autoRender=false;
			
			$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$uid = $this->Session->read('USER_ID');	
			$id=trim($_POST['subsplanid']);
			if($id!='' && $uid!='')
			{
				
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
				
				if($setSpecalistArr[$dbusertype]['cardname']!='' && $setSpecalistArr[$dbusertype]['cardtype']!='' && $setSpecalistArr[$dbusertype]['cardnumber']!='' && $setSpecalistArr[$dbusertype]['exmonth']!=''  && $setSpecalistArr[$dbusertype]['exyear']!=''  && $setSpecalistArr[$dbusertype]['exyear']!='cvv' )
				{
						$SubscriptionInfo=$this->Subscription->find("first",array("conditions"=>array(
    'Subscription.id'=>$id)));
				
				/*echo '<pre>';
				print_r($SubscriptionInfo);
				echo '</pre>';*/
				
				
				######## Payment Gateway Start ########
			
			/**************ARBCreateSubscriptionRequest********************/
						//$loginname= '72J5rmR9HM'; 
						$loginname= '96fV4zs3BdX'; 
						//$transactionkey = '9yUBFW43m44d6s3M';
						$transactionkey ='27Abm977RD5BZ8mZ';
						$host = 'api.authorize.net';
						//$host = 'apitest.authorize.net';
						$path= '/xml/v1/request.api';
						
						//define variables to send
						$refId = 'cc'.time();
						
						$name = ucwords($SubscriptionInfo['Subscription']['plan_name'].' Plan subscription');
						//$name = ucwords(' Plan subscription');
						$startDate = date("Y-m-d");
						$unit = 'months';
						$totalOccurrences = '9999';	
						
						//$amount         = 1.00;  // test amt
						$amount         = $SubscriptionInfo['Subscription']['plan_cost'];  // test amt
						
						
						$cardNumber      = $setSpecalistArr[$dbusertype]['cardnumber'];
						$expirationDate1 = $setSpecalistArr[$dbusertype]['exyear'];		
						$expirationDate2 = $setSpecalistArr[$dbusertype]['exmonth'];		
						$expirationDate  = $expirationDate1.'-'.$expirationDate2;
						/*	$cardNumber     = '4111111111111111';
						$expirationDate = '2015-03';*/					
							
						$trialOccurrences = '0';
						$trialAmount    = '0.00';										
						$firstName      = $setSpecalistArr[$dbusertype]['first_name'];
						$lastName       = $setSpecalistArr[$dbusertype]['last_name'];						
						$length = 1;
														
						//build xml to post
						$content =
						        "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
						        "<ARBCreateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
						        "<merchantAuthentication>".
							        "<name>" .$loginname. "</name>".
							        "<transactionKey>" .$transactionkey. "</transactionKey>".
						        "</merchantAuthentication>".
								"<refId>" . $refId . "</refId>".
						        "<subscription>".
							        "<name>" . $name . "</name>".
							        "<paymentSchedule>".
								        "<interval>".
									        "<length>". $length ."</length>".
									        "<unit>". $unit ."</unit>".
								        "</interval>".
								        "<startDate>" . $startDate . "</startDate>".
								        "<totalOccurrences>". $totalOccurrences . "</totalOccurrences>".
								        "<trialOccurrences>". $trialOccurrences . "</trialOccurrences>".
							        "</paymentSchedule>".
							        "<amount>". $amount ."</amount>".
							        "<trialAmount>" . $trialAmount . "</trialAmount>".
							        "<payment>".
								        "<creditCard>".
								        "<cardNumber>" . $cardNumber . "</cardNumber>".
								        "<expirationDate>" . $expirationDate . "</expirationDate>".
								        "</creditCard>".
							        "</payment>". 							        
							        "<billTo>".
								        "<firstName>". $firstName . "</firstName>".
								        "<lastName>" . $lastName . "</lastName>".
								       					        
							        "</billTo>".
						        "</subscription>".
						        "</ARBCreateSubscriptionRequest>";
						        
						        
			//send the xml via curl
						//$response = $this->Autharb->send_request_via_curl($host,$path,$content);
						$response = $this->Autharb->send_request_via_curl($host,$path,$content);
						//if the connection and send worked $response holds the return from Authorize.net
														
						if($response)
						{
						
							
							list ($refId, $resultCode, $code, $text, $subscriptionId) = $this->Autharb->parse_return($response);
							if($resultCode == 'Ok') {
							$aa['Payment']['trainer_id']=$uid;
							$aa['Payment']['trainer_name']=$setSpecalistArr[$dbusertype]['first_name'].' '.$setSpecalistArr[$dbusertype]['last_name'];
							$aa['Payment']['trainer_email']=$setSpecalistArr[$dbusertype]['email'];
							$aa['Payment']['subscriptionplan']=$SubscriptionInfo['Subscription']['plan_name'];
							$aa['Payment']['subscriptionplanid']=$id;
							$aa['Payment']['transactionid']     = $subscriptionId;
							$aa['Payment']['refid']              = $refId;
							$aa['Payment']['amount']              = $amount;
							$aa['Payment']['paymenttype']              = $SubscriptionInfo['Subscription']['plan_type'];
							$aa['Payment']['paymentdate']              = date('Y-m-d H:i:s');
		$aa['Payment']['nextbillingdate'] = date('Y-m-d',strtotime("+1 months"));
		$aa['Payment']['payusertype']              = "Club";
		
							//$aa['User']['ftext']               = $text;
							/* $this->User->set('status', '0');
							 $this->User->set('smonth', date('Y-m-d'));
							 $this->User->set('emonth', date('Y-m-d',strtotime("+1 months")));*/
							
							
							$this->Payment->save($aa);								
							
							$this->$dbusertype->id=$uid;
							$cc2[$dbusertype]['subscriptionplan']=$SubscriptionInfo['Subscription']['plan_name'];
							$cc2[$dbusertype]['after_sub_trial_end']=0;
							
							
							$this->$dbusertype->save($cc2);
							
							$ufullname=ucwords($setSpecalistArr[$dbusertype]['full_name']);
							
							// send password on the registered e-mail address
							
							$to      = $setSpecalistArr[$dbusertype]['email'];
							//$to      = 'synapseindia8@gmail.com';
							$subject = 'Subscription Plan activated in '.$this->config['base_title'];
							
							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
					if($setTrainerArr){
						
					//$content.='<img width="75" height="76" src="'.$this->config['url'].'uploads/'.$setTrainerArr['Trainer']['logo'].'"/>';
					
					$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
					
					}else {
					$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
					}
					
					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$ufullname.'!</p>
				<p>Your Subscription plan has been activated in your '.$this->config['base_title'].' Account </p>
				<p>Please find below Subascription Plan Detail:</p>
				<p>Subscription Plan: '.$aa['Payment']['subscriptionplan'].'<br/>
				   Subscription Amount: '.$aa['Payment']['amount'].'<br/>
				   Subscription Cycle: '.$aa['Payment']['paymenttype'].'<br/>
				   Subscription Payment Date: '.$aa['Payment']['paymentdate'].'<br/>
				   Subscription Next Billing Date: '.$aa['Payment']['nextbillingdate'].'<br/>
				  
				   <br/>
				</p>
				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
								
														
							
							
							if($this->sendEmailMessage(trim($to),$subject,$content,null,null))
							{
							
							echo 'Your Subscription plan has been upgraded successfully, we have sent detail on your registered email address. Please check your emaill account.';
							
							
							}
							else {
							echo 'mail issue';
							}
							
															
						}
						
						else {
							echo 'Transaction Failed!. Try Again!  '.$code.' \r\n'.$text;
										
						}
							
							
							
						}
			
			
			
			
			
			######## Payment Gateway End   ########
				
				
					
				} else {
					echo 'Sorry, first you need to set you credit card detail in Dashboard - Manage Crad Detail.';
				}
		
		
	
				
				
				
			}
			else {
				echo 'Sorry, please select subscription plan.';
			
			}
			
		}
		
		
		public function savecard(){
			$id = $this->Session->read('USER_ID');
			$this->autoRender=false;
		  /* echo "<pre>";
			print_r($this->request->data);
			echo "</pre>";
			die;*/
			if(!empty($this->request->data)){
				
				$this->Club->id=$id;
				$this->Club->save($this->request->data);
				$this->Session->setFlash('Your Credit Card Details Saved Successfully');
				$this->redirect('/clubs/index/');
			}else{
				if(is_numeric($id) && $id > 0) {
						$this->Club->id = $id;
						$this->request->data = $this->Club->read();
					} else {
						$this->Session->setFlash('Invalid Club id.');
						$this->redirect('/home/index/');
				}
			}
			
		}
		
		
		public function admin_download()
		{
			$this->set('clubs', $this->Club->find('all',array('fields'=>array('Club.username','Club.first_name','Club.last_name','Club.club_name','Club.email','Club.address','Club.city','Club.state','Club.country','Club.status','Club.no_trainer','Club.phone','Club.date_enrolled'))));
			$this->layout = null;
			$this->autoLayout = false;
			Configure::write('debug', '0');
		}
		
		
		
		
		
		
		public function newpayment()
		{	
			$this->layout='';
			
			$this->autoRender=false;
			
			$dbusertype = $this->Session->read('UTYPE');					
			
			$this->set("dbusertype",$dbusertype);
			
			$uid = $this->Session->read('USER_ID');	
			
			$id=trim($_POST['subsplanid']);
			
			//echo "<pre>";print_r($_POST);
			
			
			$cnumber=trim($_POST['data']['Club']['cardnumber']);
			
			$cNum = 'XXXXXXXXXXXX'.substr($cnumber,-4);
			
			$exmonth=trim($_POST['data']['Club']['exmonth']);
			
			$exyear=trim($_POST['data']['Club']['exyear']);
			
			$fcname=trim($_POST['data']['Club']['firstcardname']);
			
			$flname=trim($_POST['data']['Club']['lastcardname']);
			
			$temail=trim($_POST['data']['Club']['email']);
			
			$subtype=trim($_POST['data']['Club']['paymentmode']);
			
			$address=trim($_POST['data']['Club']['address1']);
			
			$city=trim($_POST['data']['Club']['city']);
			
			$state=trim($_POST['data']['Club']['state']);
			
			$zip=trim($_POST['data']['Club']['zip']);
			
			$phone=trim($_POST['data']['Club']['phone']);
			
			$tamount=trim($_POST['data']['Club']['total']);
			
			$clubcost=trim($_POST['data']['Club']['cost']);
			
			$coupon=trim($_POST['data']['Club']['coupon_code']);
			
			if($coupon != '')
			{
				$couponappl = $coupon;
			}
			else
			{
				$couponappl = '---';
			}

			$totaltrainer=trim($_POST['data']['Trainer']['number']);			
			
			$datetum = new DateTime();
						
			$invoice = $datetum->getTimestamp();
			
			
			if($id!='' && $uid!='' && $subtype=='Monthly')
			{
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
				
				$SubscriptionInfo=$this->Subscription->find("first",array("conditions"=>array('Subscription.id'=>$id)));
				
				$checkPayment = $this->Payment->find("first",array("conditions"=>array('Payment.trainer_id'=>$uid),'order'=>array('Payment.id DESC')));
			
				$this->set('checkPayment',$checkPayment);
				
				//$setCouponArr=$this->Coupon->find("first",array("conditions"=>array("Coupon.coupon_code"=>$coupon,"Coupon.status"=>1)));
				
				//echo"<pre>";print_r($checkPayment);echo"</pre>";die;
								
				######## Payment Gateway Start ########
			
				/**************ARBCreateSubscriptionRequest********************/
				
				//$loginname= '72J5rmR9HM'; 

				$loginname= '96fV4zs3BdX'; 

				//$transactionkey = '9yUBFW43m44d6s3M';

				//$transactionkey ='27Abm977RD5BZ8mZ';
					
				$transactionkey ='6uFSJ686c9Xp33Uq';

				$host = 'api.authorize.net';

				//$host = 'apitest.authorize.net';

				$path= '/xml/v1/request.api';
						
				//define variables to send
				$refId = 'cc'.time();
						
				$name = ucwords($SubscriptionInfo['Subscription']['plan_name'].' Plan subscription');
				
				//$name = ucwords(' Plan subscription');				
				
				$startDate = date("Y-m-d");
				
				$unit = 'months';

				$totalOccurrences = '1';	
						
				$amount  = $tamount;				
				
				$cardNumber      = $cnumber;

				$expirationDate1 = $exyear;		

				$expirationDate2 = $exmonth;
				
				$expirationDate  = $expirationDate1.'-'.$expirationDate2;
					
				$trialOccurrences = '0';
				
				$trialAmount    = '0.00';	
				
				$firstName      = $fcname;

				$lastName       = $flname;

				$length = 1;
												
				//build xml to post
				
				$content =
						"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
						"<ARBCreateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
						"<merchantAuthentication>".
							"<name>" .$loginname. "</name>".
							"<transactionKey>" .$transactionkey. "</transactionKey>".
						"</merchantAuthentication>".
						"<refId>" . $refId . "</refId>".
						"<subscription>".
							"<name>" . $name . "</name>".
							"<paymentSchedule>".
								"<interval>".
									"<length>". $length ."</length>".
									"<unit>". $unit ."</unit>".
								"</interval>".
								"<startDate>" . $startDate . "</startDate>".
								"<totalOccurrences>". $totalOccurrences . "</totalOccurrences>".
								"<trialOccurrences>". $trialOccurrences . "</trialOccurrences>".
							"</paymentSchedule>".
							"<amount>". $amount ."</amount>".
							"<trialAmount>" . $trialAmount . "</trialAmount>".
							"<payment>".
								"<creditCard>".
								"<cardNumber>" . $cardNumber . "</cardNumber>".
								"<expirationDate>" . $expirationDate . "</expirationDate>".
								"</creditCard>".
							"</payment>". 							        
							"<order>".
									"<invoiceNumber>". $invoice . "</invoiceNumber>".
								"</order>". 

								"<customer>".
									"<id>". $uid . "</id>".
									"<email>" . $temail . "</email>".
									"<phoneNumber>" . $phone . "</phoneNumber>".
								"</customer>".

								"<billTo>".
									"<firstName>". $firstName . "</firstName>".
									"<lastName>" . $lastName . "</lastName>".
									"<address>" . $address . "</address>".
									"<city>" . $city . "</city>".
									"<state>" . $state . "</state>".
									"<zip>" . $zip . "</zip>".
									
								"</billTo>".
								
								"<shipTo>".
									"<firstName>". $firstName . "</firstName>".
									"<lastName>" . $lastName . "</lastName>".
									"<address>" . $address . "</address>".
									"<city>" . $city . "</city>".
									"<state>" . $state . "</state>".
									"<zip>" . $zip . "</zip>".
								"</shipTo>".
						"</subscription>".
						"</ARBCreateSubscriptionRequest>";
				
				$response = $this->Autharb->send_request_via_curl($host,$path,$content);
				
				//if the connection and send worked $response holds the return from Authorize.net
												
				if($response)
				{
					list ($refId, $resultCode, $code, $text, $subscriptionId) = $this->Autharb->parse_return($response);
					
					if($resultCode == 'Ok') 
					{
						$aa['Payment']['trainer_id']=$uid;
						
						$aa['Payment']['trainer_name']=$firstName.' '.$lastName;
						
						$aa['Payment']['trainer_email']=$temail;
						
						$aa['Payment']['subscriptionplan']=$SubscriptionInfo['Subscription']['plan_name'];
						
						$aa['Payment']['subscriptionplanid']=$id;
						
						$aa['Payment']['transactionid']     = $subscriptionId;
						
						$aa['Payment']['refid']              = $refId;
						
						$aa['Payment']['amount']              = $amount;
						
						$aa['Payment']['invoice']              = $invoice;
						
						$aa['Payment']['paymenttype'] = $SubscriptionInfo['Subscription']['plan_type'];
						
						if(strtotime("now") < strtotime($checkPayment['Payment']['nextbillingdate']))
						{							
							$aa['Payment']['paymentdate']  = $checkPayment['Payment']['paymentdate'];
							
							$aa['Payment']['nextbillingdate'] = $checkPayment['Payment']['nextbillingdate'];							
						}
						else
						{
							$aa['Payment']['paymentdate']  = date('Y-m-d H:i:s');
							
							$aa['Payment']['nextbillingdate'] = date('Y-m-d',strtotime("+1 months"));
						}
						
						$aa['Payment']['payusertype']              = "Club";
						
						$aa['Payment']['no_of_trainer_purchased']  = $totaltrainer;
						
						

						//$aa['User']['ftext']               = $text;
						/* $this->User->set('status', '0');
						 $this->User->set('smonth', date('Y-m-d'));
						 $this->User->set('emonth', date('Y-m-d',strtotime("+1 months")));*/
						
						/*TO SAVE COUPON CODE ON PAYMENT*/
							
						$setCouponArr=$this->Coupon->find("first",array("conditions"=>array("Coupon.coupon_code"=>$coupon,"Coupon.status"=>1)));

						$this->set('setCouponArr',$setCouponArr);
						
						$totalredlimit = $setCouponArr['Coupon']['redemption_limit'];
						
						$totalredcount = $setCouponArr['Coupon']['redemption_count'];
						
						$reddiff = $totalredlimit - $totalredcount;
						
						$couponstartdate = $setCouponArr['Coupon']['start_date'];
						
						$couponexpirydate = $setCouponArr['Coupon']['expiry_date'];		
						
						$current_date = date('Y-m-d H:i:s');
						
						$current_date=date('Y-m-d', strtotime($current_date));
						
						$couponsd = date('Y-m-d', strtotime($couponstartdate));
						
						$couponed = date('Y-m-d', strtotime($couponexpirydate));

						if (($current_date >= $couponsd) && ($current_date <= $couponed) && ($reddiff >0))
						{
							$aa['Payment']['coupon_code']  = $coupon;
							
							$new_redemption_count  = $setCouponArr['Coupon']['redemption_count'] + 1;	
							
							$this->Coupon->query("update coupons set redemption_count = '".$new_redemption_count."',modified_date = '".date('Y-m-d h:i:s')."' where coupon_code='".$coupon."'");	
						}
						
						/*TO SAVE COUPON CODE ON PAYMENT*/
												
						$this->Payment->save($aa);								
						
						$this->$dbusertype->id=$uid;
						
						$cc2[$dbusertype]['subscriptionplan']=$SubscriptionInfo['Subscription']['plan_name'];
						
						/*TO SAVE TRAINER COUNT*/
						
						$cc2[$dbusertype]['paid_trainer']=$setSpecalistArr['Club']['paid_trainer'] + $totaltrainer;
												
						/*TO SAVE TRAINER COUNT*/
						
						$cc2[$dbusertype]['after_sub_trial_end']=0;
						
						$this->$dbusertype->save($cc2);
						
						$ufullname=ucwords($setSpecalistArr[$dbusertype]['full_name']);
						
						// send password on the registered e-mail address
						
						$to      = $temail;
						
						//$to      = 'synapseindia8@gmail.com';
						
						$subject = 'Subscription Plan activated in '.$this->config['base_title'];
						
						$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
						if($setTrainerArr)
						{						
							//$content.='<img width="75" height="76" src="'.$this->config['url'].'uploads/'.$setTrainerArr['Trainer']['logo'].'"/>';
							
							$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
						}
						else
						{
							$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
						}
					
						$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$ufullname.'!</p>
						<p>Your Subscription plan has been activated in your '.$this->config['base_title'].' Account </p>
						<p>Please find below Subascription Plan Detail:</p>
						<p>Subscription Plan: '.$aa['Payment']['subscriptionplan'].'<br/>
						   Subscription Amount: '.$aa['Payment']['amount'].'<br/>
						   Subscription Cycle: '.$aa['Payment']['paymenttype'].'<br/>
						   Subscription Payment Date: '.$aa['Payment']['paymentdate'].'<br/>
						   Subscription Next Billing Date: '.$aa['Payment']['nextbillingdate'].'<br/><br/>
						</p>
						</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
						
						
						
						//NEW MESSAGE START//
							
							$content2 = '<html><body><div style="width:700px; text-align:center; border:1px solid #21aded;">
							<div style="background:#21aded;height:30px; text-align:left;"><div align="center">';
							
							
							if($setTrainerArr)
							{				
														
								$content2.='<img src="'.$this->config['url'].'images/logo.png"/>';
							}
							else
							{
								$content2.='<img src="'.$this->config['url'].'images/logo.png"/>';
							}	
							
							$newpaymentdate = date("m/d/Y", strtotime($aa['Payment']['paymentdate']));
							
							$upnewpaymentdate = date("M j,Y", strtotime($aa['Payment']['paymentdate']));
							
							$newnextbillingdate = date("m/d/Y", strtotime($aa['Payment']['nextbillingdate']));
							
							$upnewnextbillingdate = date("M j,Y", strtotime($aa['Payment']['nextbillingdate']));
							
							$content2.='</div></div>
							
							<div style="clear:both"></div>
							<div style="padding:15px;">
								<div>
									<div style="float:left;color:#5f5b8c;font-size:22px;">Personal Training Partners, Inc.</div>
									<div style="float:right">Invoice : '.$invoice.'</div>
								</div>
								
								<div style="clear:both"></div>
								
								<div>
									<div style="float:left">372 S. Eagle Road #154 <br /> Eagle, ID 83616-5908</div>
									<div style="float:right">Date: '.$upnewpaymentdate.'<br />Due: '.$upnewnextbillingdate.'</div>
								</div>
															
								<div style="clear:both"></div>
								
								<div style="font-size:20px; font-weight:bold; margin:30px 0 0 0;text-align:left;">
									Charges
								</div>
								
								<div style="clear:both"></div>
								
								<div style="float:left;width:150px;"> 
									<p style="font-weight:bold; font-size:18px; text-align:center;color:#999999;">
									Item </p>
									<p style="text-align:center;">Club Trainer Subscription - '.$aa['Payment']['subscriptionplan'].'</p>
								</div>
								
								<div style="float:left;width:150px; margin: 0 0 0 10px;"> 
									<p style="font-weight:bold; font-size:18px;text-align:center;color:#999999;">
									Date </p>
									<p style="text-align:center;">'.$upnewpaymentdate.' -  '.$upnewnextbillingdate.'</p>
								</div>
								
								<div style="float:left;width:150px; margin: 0 0 0 10px;"> 
									<p style="font-weight:bold; font-size:18px;text-align:center;color:#999999;">
									Price x Qty</p>
									<p style="text-align:center;">$'.$clubcost.' x '.$totaltrainer.' Trainer</p>
									<p style="font-weight:bold; font-size:18px; text-align:center;font-style:italic;">
									Coupon </p>
									<p style="font-weight:bold; font-size:18px; text-align:center;font-style:italic;">
									Current charges </p>
								</div>
								
								<div style="float:left;width:150px; margin: 0 0 0 10px;"> 
									<p style="font-weight:bold;font-size:18px; text-align:center;color:#999999;">
									Total </p>
									<p style="text-align:center;">$'.$tamount.'</p>
									<p style="font-weight:bold; font-size:18px; text-align:center;"> '.$couponappl.'</p>	
									<p style="font-weight:bold; font-size:18px; text-align:center;"> $'.$tamount.'</p>	
								</div>
								
								
								<div style="clear:both"></div>
								
								<div style="font-size:20px; font-weight:bold; margin:15px 0 0 0;text-align:left;">
									Credits & payments
								</div>
								
								<div style="clear:both"></div>
								
								
								<div style="float:left;width:150px;"> 
									<p style="font-weight:bold; font-size:18px; text-align:center;color:#999999;">
									Description </p>
									<p style="text-align:center;">Payment</p>
								</div>
								
								<div style="float:left;width:250px; margin: 0 0 0 10px;"> 								
									<p style="font-weight:bold; font-size:18px;text-align:center;color:#999999;">
									Note </p>
									<p style="text-align:center;">Credit Card '.$cNum.' Ref '.$refId.'</p>									
								</div>
								
								<div style="float:left;width:200px; margin: 0 0 0 10px;">
									<p style="font-weight:bold; font-size:18px;text-align:center;color:#999999;">
									Amount</p>
									<p style="text-align:center;">$'.$tamount.'</p>
									<p style="font-weight:bold; font-size:18px; text-align:center;font-style:italic">
									Current credits $'.$tamount.'</p>									
								</div>
								
								<div style="clear:both"></div>
								
								<div style="float:right; font-weight:bold; text-align:center; width:300px;">
									<p style="font-weight:bold; font-size:20px; text-align:center;">Total Due $0.00</p>  
								</div>
								
								<div style="clear:both"></div>
								
								<p style="text-align:center; font-size:16px; font-style:italic;margin:20px 0 0 0;">Thank you for being a PTP customer, we appreciate your business!</p>
							
								<p style="text-align:left; font-size:16px; font-style:italic">If you have any questions or concerns about this invoice or your services, don’t hesitate to contact us at info@ptpfitpro.com.</p>
								
								
							</div>
							</div></body></html>';
							
							
							
							$this->sendEmailMessage(trim($to),$subject,$content2,null,null);
							//NEW MESSAGE END//
						
						
						
						
						
						
						
						
						
						if($this->sendEmailMessage(trim($to),$subject,$content,null,null))
						{						
							echo 'Your Subscription plan has been upgraded successfully, we have sent detail on your registered email address. Please check your emaill account.';
							
							$this->Session->setFlash('Thanks, your subscription has been activated.');

							$this->redirect('/clubs/index/');
						}
						else
						{
							echo 'mail issue';
						}
					}
					else
					{
						echo 'Transaction Failed!. Try Again!  '.$code.' \r\n'.$text;
					}
				}
				######## Payment Gateway End   ########
			}
			else if($id!='' && $uid!='' && $subtype=='Yearly')
			{
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));			
				
				
				$SubscriptionInfo=$this->Subscription->find("first",array("conditions"=>array('Subscription.id'=>$id)));
				
				$checkPayment = $this->Payment->find("first",array("conditions"=>array('Payment.trainer_id'=>$uid,'Payment.paymenttype'=>'Yearly'),'order'=>array('Payment.id DESC')));
			
				$this->set('checkPayment',$checkPayment);
				
				//echo "<pre>"; print_r($checkPayment); echo "</pre>"; die;
												
				######## Payment Gateway Start ########
			
				/**************ARBCreateSubscriptionRequest********************/
				
				//$loginname= '72J5rmR9HM'; 

				$loginname= '96fV4zs3BdX'; 

				//$transactionkey = '9yUBFW43m44d6s3M';

				//$transactionkey ='27Abm977RD5BZ8mZ';
					
				$transactionkey ='6uFSJ686c9Xp33Uq';

				$host = 'api.authorize.net';

				//$host = 'apitest.authorize.net';

				$path= '/xml/v1/request.api';
						
				//define variables to send
				$refId = 'cc'.time();
						
				$name = ucwords($SubscriptionInfo['Subscription']['plan_name'].' Plan subscription');
				
				//$name = ucwords(' Plan subscription');
				
				$startDate = date("Y-m-d");
				
				$unit = 'months';

				$totalOccurrences = '1';	
						
				$amount  = $tamount;				
				
				$cardNumber      = $cnumber;

				$expirationDate1 = $exyear;		

				$expirationDate2 = $exmonth;
				
				$expirationDate  = $expirationDate1.'-'.$expirationDate2;
					
				$trialOccurrences = '0';
				
				$trialAmount    = '0.00';	
				
				$firstName      = $fcname;

				$lastName       = $flname;

				$length = 12;
												
				//build xml to post
				
				$content =
						"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
						"<ARBCreateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
						"<merchantAuthentication>".
							"<name>" .$loginname. "</name>".
							"<transactionKey>" .$transactionkey. "</transactionKey>".
						"</merchantAuthentication>".
						"<refId>" . $refId . "</refId>".
						"<subscription>".
							"<name>" . $name . "</name>".
							"<paymentSchedule>".
								"<interval>".
									"<length>". $length ."</length>".
									"<unit>". $unit ."</unit>".
								"</interval>".
								"<startDate>" . $startDate . "</startDate>".
								"<totalOccurrences>". $totalOccurrences . "</totalOccurrences>".
								"<trialOccurrences>". $trialOccurrences . "</trialOccurrences>".
							"</paymentSchedule>".
							"<amount>". $amount ."</amount>".
							"<trialAmount>" . $trialAmount . "</trialAmount>".
							"<payment>".
								"<creditCard>".
								"<cardNumber>" . $cardNumber . "</cardNumber>".
								"<expirationDate>" . $expirationDate . "</expirationDate>".
								"</creditCard>".
							"</payment>". 							        
							"<order>".
									"<invoiceNumber>". $invoice . "</invoiceNumber>".
								"</order>". 

								"<customer>".
									"<id>". $uid . "</id>".
									"<email>" . $temail . "</email>".
									"<phoneNumber>" . $phone . "</phoneNumber>".
								"</customer>".

								"<billTo>".
									"<firstName>". $firstName . "</firstName>".
									"<lastName>" . $lastName . "</lastName>".
									"<address>" . $address . "</address>".
									"<city>" . $city . "</city>".
									"<state>" . $state . "</state>".
									"<zip>" . $zip . "</zip>".
									
								"</billTo>".
								
								"<shipTo>".
									"<firstName>". $firstName . "</firstName>".
									"<lastName>" . $lastName . "</lastName>".
									"<address>" . $address . "</address>".
									"<city>" . $city . "</city>".
									"<state>" . $state . "</state>".
									"<zip>" . $zip . "</zip>".
								"</shipTo>".
						"</subscription>".
						"</ARBCreateSubscriptionRequest>";
				
				$response = $this->Autharb->send_request_via_curl($host,$path,$content);
				
				//if the connection and send worked $response holds the return from Authorize.net
												
				if($response)
				{
					list ($refId, $resultCode, $code, $text, $subscriptionId) = $this->Autharb->parse_return($response);
					
					if($resultCode == 'Ok') 
					{
						$aa['Payment']['trainer_id']=$uid;
						
						$aa['Payment']['trainer_name']=$firstName.' '.$lastName;
						
						$aa['Payment']['trainer_email']=$temail;
						
						$aa['Payment']['subscriptionplan']=$SubscriptionInfo['Subscription']['plan_name'];
						
						$aa['Payment']['subscriptionplanid']=$id;
						
						$aa['Payment']['transactionid']     = $subscriptionId;
						
						$aa['Payment']['refid']              = $refId;
						
						$aa['Payment']['amount']              = $amount;
						
						$aa['Payment']['invoice']              = $invoice;
						
						$aa['Payment']['paymenttype'] = $SubscriptionInfo['Subscription']['plan_type'];			

						if(strtotime("now") < strtotime($checkPayment['Payment']['nextbillingdate']))
						{							
							$aa['Payment']['paymentdate']  = $checkPayment['Payment']['paymentdate'];
							
							$aa['Payment']['nextbillingdate'] = $checkPayment['Payment']['nextbillingdate'];							
						}
						else
						{
							$aa['Payment']['paymentdate']  = date('Y-m-d H:i:s');
							
							$aa['Payment']['nextbillingdate'] = date('Y-m-d',strtotime("+12 months"));
						}
						
						$aa['Payment']['payusertype']              = "Club";
						
						$aa['Payment']['no_of_trainer_purchased']  = $totaltrainer;

						//$aa['User']['ftext']               = $text;
						/* $this->User->set('status', '0');
						 $this->User->set('smonth', date('Y-m-d'));
						 $this->User->set('emonth', date('Y-m-d',strtotime("+1 months")));*/
						
						/*TO SAVE COUPON CODE ON PAYMENT*/
							
						$setCouponArr=$this->Coupon->find("first",array("conditions"=>array("Coupon.coupon_code"=>$coupon,"Coupon.status"=>1)));

						$this->set('setCouponArr',$setCouponArr);
						
						$totalredlimit = $setCouponArr['Coupon']['redemption_limit'];
						
						$totalredcount = $setCouponArr['Coupon']['redemption_count'];
						
						$reddiff = $totalredlimit - $totalredcount;
						
						$couponstartdate = $setCouponArr['Coupon']['start_date'];
						
						$couponexpirydate = $setCouponArr['Coupon']['expiry_date'];		
						
						$current_date = date('Y-m-d H:i:s');
						
						$current_date=date('Y-m-d', strtotime($current_date));
						
						$couponsd = date('Y-m-d', strtotime($couponstartdate));
						
						$couponed = date('Y-m-d', strtotime($couponexpirydate));

						if (($current_date >= $couponsd) && ($current_date <= $couponed) && ($reddiff >0))
						{
							$aa['Payment']['coupon_code']  = $coupon;
							
							$new_redemption_count  = $setCouponArr['Coupon']['redemption_count'] + 1;
							
							$this->Coupon->query("update coupons set redemption_count = '".$new_redemption_count."',modified_date = '".date('Y-m-d h:i:s')."' where coupon_code='".$coupon."'");
						}
						/*TO SAVE COUPON CODE ON PAYMENT*/
						
						$this->Payment->save($aa);								
						
						$this->$dbusertype->id=$uid;
						
						$cc2[$dbusertype]['subscriptionplan']=$SubscriptionInfo['Subscription']['plan_name'];
						
						/*TO SAVE TRAINER COUNT*/
						
						$cc2[$dbusertype]['paid_trainer']=$setSpecalistArr['Club']['paid_trainer'] + $totaltrainer;
												
						/*TO SAVE TRAINER COUNT*/
						
						$cc2[$dbusertype]['after_sub_trial_end']=0;
						
						$this->$dbusertype->save($cc2);
						
						$ufullname=ucwords($setSpecalistArr[$dbusertype]['full_name']);
						
						// send password on the registered e-mail address
						
						$to      = $temail;
						
						//$to      = 'synapseindia8@gmail.com';
						
						$subject = 'Subscription Plan activated in '.$this->config['base_title'];
						
						$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
						if($setTrainerArr)
						{						
							//$content.='<img width="75" height="76" src="'.$this->config['url'].'uploads/'.$setTrainerArr['Trainer']['logo'].'"/>';
							
							$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
						}
						else
						{
							$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
						}
					
						$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$ufullname.'!</p>
						<p>Your Subscription plan has been activated in your '.$this->config['base_title'].' Account </p>
						<p>Please find below Subascription Plan Detail:</p>
						<p>Subscription Plan: '.$aa['Payment']['subscriptionplan'].'<br/>
						   Subscription Amount: '.$aa['Payment']['amount'].'<br/>
						   Subscription Cycle: '.$aa['Payment']['paymenttype'].'<br/>
						   Subscription Payment Date: '.$aa['Payment']['paymentdate'].'<br/>
						   Subscription Next Billing Date: '.$aa['Payment']['nextbillingdate'].'<br/><br/>
						</p>
						</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
						
						
						//NEW MESSAGE START//
							
							$content2 = '<html><body><div style="width:700px; text-align:center; border:1px solid #21aded;">
							<div style="background:#21aded;height:30px; text-align:left;"><div align="center">';
							
							
							if($setTrainerArr)
							{				
														
								$content2.='<img src="'.$this->config['url'].'images/logo.png"/>';
							}
							else
							{
								$content2.='<img src="'.$this->config['url'].'images/logo.png"/>';
							}	
							
							$newpaymentdate = date("m/d/Y", strtotime($aa['Payment']['paymentdate']));
							
							$upnewpaymentdate = date("M j,Y", strtotime($aa['Payment']['paymentdate']));
							
							$newnextbillingdate = date("m/d/Y", strtotime($aa['Payment']['nextbillingdate']));
							
							$upnewnextbillingdate = date("M j,Y", strtotime($aa['Payment']['nextbillingdate']));
							
							$content2.='</div></div>
							
							<div style="clear:both"></div>
							<div style="padding:15px;">
								<div>
									<div style="float:left;color:#5f5b8c;font-size:22px;">Personal Training Partners, Inc.</div>
									<div style="float:right">Invoice : '.$invoice.'</div>
								</div>
								
								<div style="clear:both"></div>
								
								<div>
									<div style="float:left">372 S. Eagle Road #154 <br /> Eagle, ID 83616-5908</div>
									<div style="float:right">Date: '.$upnewpaymentdate.'<br />Due: '.$upnewnextbillingdate.'</div>
								</div>
															
								<div style="clear:both"></div>
								
								<div style="font-size:20px; font-weight:bold; margin:30px 0 0 0;text-align:left;">
									Charges
								</div>
								
								<div style="clear:both"></div>
								
								<div style="float:left;width:150px;"> 
									<p style="font-weight:bold; font-size:18px; text-align:center;color:#999999;">
									Item </p>
									<p style="text-align:center;">Club Trainer Subscription - '.$aa['Payment']['subscriptionplan'].'</p>
								</div>
								
								<div style="float:left;width:150px; margin: 0 0 0 10px;"> 
									<p style="font-weight:bold; font-size:18px;text-align:center;color:#999999;">
									Date </p>
									<p style="text-align:center;">'.$upnewpaymentdate.' -  '.$upnewnextbillingdate.'</p>
								</div>
								
								<div style="float:left;width:150px; margin: 0 0 0 10px;"> 
									<p style="font-weight:bold; font-size:18px;text-align:center;color:#999999;">
									Price x Qty</p>
									<p style="text-align:center;">$'.$clubcost.' x '.$totaltrainer.' Trainer</p>
									<p style="font-weight:bold; font-size:18px; text-align:center;font-style:italic;">
									Coupon </p>
									<p style="font-weight:bold; font-size:18px; text-align:center;font-style:italic;">
									Current charges </p>
								</div>
								
								<div style="float:left;width:150px; margin: 0 0 0 10px;"> 
									<p style="font-weight:bold;font-size:18px; text-align:center;color:#999999;">
									Total </p>
									<p style="text-align:center;">$'.$tamount.'</p>
									<p style="font-weight:bold; font-size:18px; text-align:center;"> '.$couponappl.'</p>	
									<p style="font-weight:bold; font-size:18px; text-align:center;"> $'.$tamount.'</p>	
								</div>
								
								
								<div style="clear:both"></div>
								
								<div style="font-size:20px; font-weight:bold; margin:15px 0 0 0;text-align:left;">
									Credits & payments
								</div>
								
								<div style="clear:both"></div>
								
								
								<div style="float:left;width:150px;"> 
									<p style="font-weight:bold; font-size:18px; text-align:center;color:#999999;">
									Description </p>
									<p style="text-align:center;">Payment</p>
								</div>
								
								<div style="float:left;width:250px; margin: 0 0 0 10px;"> 								
									<p style="font-weight:bold; font-size:18px;text-align:center;color:#999999;">
									Note </p>
									<p style="text-align:center;">Credit Card '.$cNum.' Ref '.$refId.'</p>									
								</div>
								
								<div style="float:left;width:200px; margin: 0 0 0 10px;">
									<p style="font-weight:bold; font-size:18px;text-align:center;color:#999999;">
									Amount</p>
									<p style="text-align:center;">$'.$tamount.'</p>
									<p style="font-weight:bold; font-size:18px; text-align:center;font-style:italic">
									Current credits $'.$tamount.'</p>									
								</div>
								
								<div style="clear:both"></div>
								
								<div style="float:right; font-weight:bold; text-align:center; width:300px;">
									<p style="font-weight:bold; font-size:20px; text-align:center;">Total Due $0.00</p>  
								</div>
								
								<div style="clear:both"></div>
								
								<p style="text-align:center; font-size:16px; font-style:italic;margin:20px 0 0 0;">Thank you for being a PTP customer, we appreciate your business!</p>
							
								<p style="text-align:left; font-size:16px; font-style:italic">If you have any questions or concerns about this invoice or your services, don’t hesitate to contact us at info@ptpfitpro.com.</p>
								
								
							</div>
							</div></body></html>';
							
							
							
							$this->sendEmailMessage(trim($to),$subject,$content2,null,null);
							//NEW MESSAGE END//
						
						
						
						if($this->sendEmailMessage(trim($to),$subject,$content,null,null))
						{						
							echo 'Your Subscription plan has been upgraded successfully, we have sent detail on your registered email address. Please check your emaill account.';
							
							$this->Session->setFlash('Thanks, your subscription has been activated.');

							$this->redirect('/clubs/index/');
						}
						else
						{
							echo 'mail issue';
						}
					}
					else
					{
						echo 'Transaction Failed!. Try Again!  '.$code.' \r\n'.$text;
					}
				}
				######## Payment Gateway End   ########
			}
			else
			{
				echo 'Sorry, please select subscription plan.';
			}	
		}
		
		
		
		public function couponcode()
		{	
			/*echo"<pre>";
			print_r($_REQUEST);
			echo"</pre>";*/
			
			$this->layout = "";	

			$this->autoRender=false;
			
			$amount = $_POST['amount'];
			
			$coupon = $_POST['coupon'];
			
			$setCouponArr=$this->Coupon->find("first",array("conditions"=>array("Coupon.coupon_code"=>$coupon,"Coupon.status"=>1)));

			$this->set('setCouponArr',$setCouponArr);
			
			//echo "<pre>"; print_r($setCouponArr); echo "</pre>"; 
			
			if(empty($setCouponArr))
			{
				echo 'Coupon Code Invalid';
				exit;
			}
						
			$totalredlimit = $setCouponArr['Coupon']['redemption_limit'];
			
			$totalredcount = $setCouponArr['Coupon']['redemption_count'];
			
			$reddiff = $totalredlimit - $totalredcount;
			
			$couponstartdate = $setCouponArr['Coupon']['start_date'];
			
			$couponexpirydate = $setCouponArr['Coupon']['expiry_date'];		
			
			$current_date = date('Y-m-d H:i:s');
			
			$current_date=date('Y-m-d', strtotime($current_date));
			
			$couponsd = date('Y-m-d', strtotime($couponstartdate));
			
			$couponed = date('Y-m-d', strtotime($couponexpirydate));

			if (($current_date >= $couponsd) && ($current_date <= $couponed) && ($reddiff >0))
			{
			  if ($setCouponArr['Coupon']['discount_type']=='Fixed')
			  {
					echo $discounted_price = $amount - $setCouponArr['Coupon']['discount_fixed_value'];
			  }
			  else if ($setCouponArr['Coupon']['discount_type']=='Percentage')
			  {		
					$percentagediscount = ($setCouponArr['Coupon']['discount_percent_value'] * $amount)/100;
					
					echo $discounted_price = $amount - $percentagediscount;
			  }
			  
			}
			else
			{
			  echo 'Coupon Code Expired';
			  exit;
			}
						
			//echo json_encode($flag_satus);

			exit;
	}
	
	
	
	public function changecertorg()
		{			
			$this->layout = "";	

			$this->autoRender=false;
			
			$certi = $_POST['str'];	
			
			$setcertiname=$this->CertificationOrganization->find("first",array("conditions"=>array("CertificationOrganization.name"=>$certi)));

			$this->set('setcertiname',$setcertiname);
						
			$setcertiname2=$this->Certification->find("all",array("conditions"=>array("Certification.certi_orgaid"=>$setcertiname['CertificationOrganization']['id']),'fields'=>array('Certification.course','Certification.course'),'order'=>array('Certification.course ASC')));
			
			$this->set('setcertiname2',$setcertiname2);
									
			$strreturn='<option value=""> -- Select -- </option>';

			if(!empty($setcertiname2))
			{					
				foreach($setcertiname2 as $scm) 
				{
					$strreturn .='<option value="'.$scm['Certification']['course'].'">'.$scm['Certification']['course'].'</option>';
				}
				$strreturn.='<option value=" ">Other</option>';

				echo $strreturn;

				exit;
			}	
	}
		
		
	public function purchasehistory()
		{	
			$this->checkUserLogin();
			
			$this->layout = "homelayout";
			
			$this->set("leftcheck",'homeindex');
			
			//$this->autoRender=false;
			
			$dbusertype = $this->Session->read('UTYPE');					
			
			$this->set("dbusertype",$dbusertype);
						
			$uid = $this->Session->read('USER_ID');
			
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
			
		    $this->set("setSpecalistArr",$setSpecalistArr);

			$paymentArr=$this->Payment->find("all",array("conditions"=>array("Payment.trainer_id"=>$uid),"order"=>array("Payment.paymentdate")));
						
			$this->set("paymentArr",$paymentArr);
													
		}	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
