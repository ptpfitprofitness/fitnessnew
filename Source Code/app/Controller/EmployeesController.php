<?php
ob_start();
##******************************************************************
##  Project		:		Fitness
##  Done by		:		1265
##	Create Date	:		03/02/2014
##  Description :		This file contains function for Trainees
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
	class EmployeesController extends AppController {

		public $name 		= 'Employees';
		public $helpers 	= array('Html','Session','Cksource');
		public $uses 		= array('Employee','Country','Member','Club','Trainer','Trainee','TraineeClub','TraineeTrainer','Corporation','CorporationBranch','CorporationContact');
		public $components  = array('Upload');			
		public $facebook;
		public $amazon;
	
		public function admin_add(){
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
			$this->set("corporations",$this->Corporation->find('list',array('fields'=>array('Corporation.id','Corporation.company_name'))));	
			$this->set("branches",$this->CorporationBranch->find('list',array('fields'=>array('CorporationBranch.id','CorporationBranch.branch_name'))));
			
			if(!empty($this->data)) {
					
		
				$this->Employee->set($this->data);
				if($this->Employee->validates()) {
						if( !empty($this->data["Employee"]["photo"]) ) {
							$filename = $this->data["Employee"]["photo"]["name"];
							$target = $this->config["upload_path"];
							$this->Upload->upload($this->data["Employee"]["photo"], $target, null, null);
  					        $this->request->data["Employee"]["photo"] = $this->Upload->result; 					
						}else{	
							
							unset($this->request->data["Employee"]["photo"]);
							$this->request->data["Employee"]["photo"] = '';							
					    }
					    
					    
					    $this->request->data["Employee"]["username"]= $this->data["Employee"]["email"];
					    $this->request->data["Employee"]["created_date"]= date("Y-m-d h:i:s");
						$this->request->data["Employee"]["update_date"]= date("Y-m-d h:i:s");	
					    	
						
						if($this->Employee->save($this->data['Employee'])) {
							
							if(isset($this->request->data['Employee']['trainee_flag']) &&($this->request->data['Employee']['trainee_flag']==1)){
								
								$makeTrainee=array();
								$makeTrainee['Trainee']['employee_id']=$this->Employee->getInsertID();
								$makeTrainee['Trainee']['corporation_id']=$this->request->data['Employee']['corporation_id'];
								$makeTrainee['Trainee']['date_enrolled']=$this->request->data['Employee']['date_enrolled'];
								$makeTrainee['Trainee']['mobile']=$this->request->data['Employee']['mobile'];
								$makeTrainee['Trainee']['phone']=$this->request->data['Employee']['phone'];
								$makeTrainee['Trainee']['notification_status']=$this->request->data['Employee']['notification_status'];
								$makeTrainee['Trainee']['update_date']=$this->request->data["Employee"]["update_date"];
								$makeTrainee['Trainee']['created_date']=$this->request->data["Employee"]["created_date"];
								$makeTrainee['Trainee']['status']=0;
								$makeTrainee['Trainee']['photo']=$this->request->data['Employee']['photo'];
								$makeTrainee['Trainee']['zip']=$this->request->data['Employee']['zip'];
								$makeTrainee['Trainee']['country']=$this->request->data['Employee']['country'];
								$makeTrainee['Trainee']['state']=$this->request->data['Employee']['state'];
								$makeTrainee['Trainee']['city']=$this->request->data['Employee']['city'];
								$makeTrainee['Trainee']['address']=$this->request->data['Employee']['address'];
								$makeTrainee['Trainee']['password']=$this->request->data['Employee']['password'];
								$makeTrainee['Trainee']['email']=$this->request->data['Employee']['email'];
								$makeTrainee['Trainee']['last_name']=$this->request->data['Employee']['last_name'];
								
								$makeTrainee['Trainee']['first_name']=$this->request->data['Employee']['first_name'];
								$makeTrainee['Trainee']['username']=$this->request->data['Employee']['email'];
								
							$this->Trainee->savaEmp($makeTrainee);
							
						}
							
									
							
							/*$lastId = $this->Employee->getLastInsertID();
							
							foreach($this->data['EmployeeClub_Id'] as $val)
							{
								$allTask = $this->Trainee->query("insert into trainee_clubs set trainee_id ='$lastId', club_id='$val'");
							}
							
							foreach($this->data['TraineeTrainer'] as $tran)
							{
								$allTask = $this->Trainee->query("insert into trainee_trainers set trainee_id ='$lastId', trainerId='$tran'");
							}*/
									
							$this->Session->setFlash('Employee has been created successfully.');
							$this->redirect('/admin/employees/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_view(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("traineeInfo",$this->Employee->find("first",array("conditions"=>array("Employee.id"=>$this->params["pass"][0]))));
				//$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_edit($id=null)
		{
			
			//pr($this->Trainee->getAllTrainee());
			//die;
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
			$this->set("corporations",$this->Corporation->find('list',array('fields'=>array('Corporation.id','Corporation.company_name'))));	
			$this->set("branches",$this->CorporationBranch->find('list',array('fields'=>array('CorporationBranch.id','CorporationBranch.branch_name'))));
		
			if(!empty($this->data)){
			
			//$this->Trainee->set($this->data);
			$this->Employee->id = $id;		
			
							
			if($this->Employee->validates()) {				
				if(!empty($this->request->data["Employee"]["photo"]["name"]))
				{
					$filename = $this->request->data["Employee"]["photo"]["name"];
					$target = $this->config["upload_path"];
					$this->Upload->upload($this->data["Trainee"]["photo"], $target, null, null);
  					$this->request->data["Employee"]["photo"] = $this->Upload->result; 
  					$picPath = $this->config["upload_path"].$this->request->data["Employee"]["old_image"];
					@unlink($picPath);
				}else{	
					
					if(!empty($this->request->data["Employee"]["old_image"])){
						$this->request->data["Employee"]["photo"] = $this->request->data["Employee"]["old_image"];			
					}
					else{
						$this->request->data["Employee"]["photo"] = "";
					}
				}
				$this->request->data["Employee"]["username"] =$this->data["Employee"]["email"];
				$this->request->data["Employee"]["update_date"] =date("Y-m-d h:i:s");
$this->request->data["Employee"]["created_date"] = date("Y-m-d h:i:s");
				if($this->Employee->save($this->data)) {
					
					if(isset($this->request->data['Employee']['trainee_flag']) &&($this->request->data['Employee']['trainee_flag']==1)){
								
								$makeTrainee=array();
								//$this->Trainee->id=
								$makeTrainee['Trainee']['employee_id']=$id;
								$makeTrainee['Trainee']['corporation_id']=$this->request->data['Employee']['corporation_id'];
								$makeTrainee['Trainee']['date_enrolled']=$this->request->data['Employee']['date_enrolled'];
								$makeTrainee['Trainee']['mobile']=$this->request->data['Employee']['mobile'];
								$makeTrainee['Trainee']['phone']=$this->request->data['Employee']['phone'];
								$makeTrainee['Trainee']['notification_status']=$this->request->data['Employee']['notification_status'];
								$makeTrainee['Trainee']['update_date']=$this->request->data['Employee']['update_date'];
								$makeTrainee['Trainee']['created_date']=$this->request->data['Employee']['created_date'];
								$makeTrainee['Trainee']['status']=0;
								$makeTrainee['Trainee']['photo']=$this->request->data['Employee']['photo'];
								$makeTrainee['Trainee']['zip']=$this->request->data['Employee']['zip'];
								$makeTrainee['Trainee']['country']=$this->request->data['Employee']['country'];
								$makeTrainee['Trainee']['state']=$this->request->data['Employee']['state'];
								$makeTrainee['Trainee']['city']=$this->request->data['Employee']['city'];
								$makeTrainee['Trainee']['address']=$this->request->data['Employee']['address'];
								$makeTrainee['Trainee']['password']=$this->request->data['Employee']['password'];
								$makeTrainee['Trainee']['email']=$this->request->data['Employee']['email'];
								$makeTrainee['Trainee']['last_name']=$this->request->data['Employee']['last_name'];
								
								$makeTrainee['Trainee']['first_name']=$this->request->data['Employee']['first_name'];
								$makeTrainee['Trainee']['username']=$this->request->data['Employee']['email'];
								
							if($this->Trainee->save($makeTrainee)){
								//return true;
							}else {
								$this->Session->setFlash('Some error has been occured. Please try again.');
							}
							
						}
						elseif(isset($this->request->data['Employee']['trainee_flag']) &&($this->request->data['Employee']['trainee_flag']==0)) {
							$this->Trainee->deleteAll(array('Trainee.employee_id' =>$id),FALSE);
						}
						else {
							return true;
						}
					
					//die();
					$this->Session->setFlash('Employee information has been updated successfully.');
					$this->redirect('/admin/employees/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
				$this->request->data["Employee"]["photo"]=$this->request->data["Employee"]["old_image"];				
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Employee->id = $id;
						$this->request->data = $this->Employee->read();
					} else {
						$this->Session->setFlash('Invalid Employee id.');
						$this->redirect('/admin/employees/');
				}
			}	
		}
		
		public function admin_index($status = null)
		{
				
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by email or Employee Name...") ) {					
					$conditions["OR"] = array(
												"Employee.first_name LIKE" => "%".$this->data["keyword"]."%",
												"Employee.last_name LIKE" => "%".$this->data["keyword"]."%",
												"Employee.email LIKE" => "%".$this->data["keyword"]."%",
												"Employee.full_name LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['Employee']['statusTop']) ) {
							
							$action = $this->data['Employee']['statusTop'];
						}elseif( !empty($this->data['Employee']['status'])) {
							$action = $this->data['Employee']['status'];
						}
						
						if(isset($this->data['Employee']['id']) && count($this->data['Employee']['id']) > 0) {
							$this->update_status(trim($action), $this->data['Employee']['id'], count($this->data['Employee']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by email or Employee Name...') && $this->data["submit"]=='Search'){
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
									"Employee.first_name LIKE" => "%".$this->params["named"]["keyword"]."%",
									"Employee.last_name LIKE" => "%".$this->params["named"]["keyword"]."%",
									"Employee.email LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Employee.first_name' => 'ASC'));
			$employees = $this->paginate('Employee'); //default take the current
			$this->set('employees', $employees);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['Employee']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Employee']['options']['page']);
		}
		
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Employee->id = $ids[$ctr];
						$this->Employee->saveField("status", '1');
					}
					$this->Session->setFlash('Employee(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Employee->id = $ids[$ctr];
						$this->Employee->saveField("status", '0');
					}
					$this->Session->setFlash('Employee(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->Employee->create();
						$this->Employee->id = $ids[$i];
						
						$this->Employee->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Employee(s) has been deleted successfully.');
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
					$dataCheck = $this->Employee->find('all', array('conditions'=>array('Employee.email'=>trim($validateValue), 'Employee.id !='=>trim($row_id))));
				}else{
					$dataCheck = $this->Employee->find('all', array('conditions'=>array('Employee.email'=>trim($validateValue))));
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
				
		function removePic() {
				
			$this->layout = '';
			$this->render = false;
		
			if($this->data) {
				
				$userPic = $this->Employee->find("first",array("fields"=>array("photo"),"conditions"=>array("Employee.id"=>$this->data["id"])));
				$picPath = $this->config["upload_path"].$userPic["Employee"]["photo"];
				unlink($picPath);
				
				$data["photo"] = null;
				if( $this->Employee->updateAll($data,array("Employee.id"=>$this->data["id"])) ) {
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully updated");
				}else{
					$response = array("responseclassName"=>"nFailure","errorMsg"=>"unable to process the request");
				}
				echo json_encode($response);
				exit;	
			}
		
		}
		
		function listbranches()
			{
				$this->layout = '';
				$this->render = false;
				if($this->data)
				{
				 	$array = $_POST['corporation_branches']; // order in 'In' clause
					$condition = array('CorporationBranch.corporation_id' => $array);
					$branchData = $this->CorporationBranch->find('all',array('fields'=>array('CorporationBranch.id','CorporationBranch.branch_name'),"conditions"=>$condition));
				 			
				 	$tra = '<select id="EmployeeBranchId" class="validate[required]" name="data[Employee][branch_id]">';
				 	$tra .='<option value="">-- Select Branch --</option>';
					foreach($branchData as $val)
				 	{
				 		$tra .='<option value="'.$val['CorporationBranch']['id'].'">'.$val['CorporationBranch']['branch_name'].'</option>';
				 	}
				 	
				 	$tra .='</select>';
				}
				echo $tra;
				exit;
			}
			
	}