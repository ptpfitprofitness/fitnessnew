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
	class CertificationorganizationsController extends AppController {

		public $name 		= 'Certificationorganizations';
		public $helpers 	= array('Html','Session','Cksource');
	public $uses 		= array('Country','Member','ClubBranch','Club','ClubContact','CertificationOrganization','Certification','Degree');
		public $components  = array('Upload');			
		public $facebook;
		public $amazon;
	
		public function admin_add(){
			
			if(!empty($this->data)) {
		
				$this->CertificationOrganization->set($this->data);
				if($this->CertificationOrganization->validates()) {
						
					    
					    $this->request->data["CertificationOrganization"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["CertificationOrganization"]["modification_date"] 		    = date("Y-m-d h:i:s");
					    	//pr($this->request->data);
					    	//die('Here');
						if($this->CertificationOrganization->save($this->data)) {				
							$this->Session->setFlash('Certification Organization has been created successfully.');
							$this->redirect('/admin/certificationorganizations/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_view(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("CertificationOrganizationInfo",$this->CertificationOrganization->find("first",array("conditions"=>array("CertificationOrganization.id"=>$this->params["pass"][0]))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_edit($id = null)
		{
					
			if(!empty($this->data)){
			
			$this->CertificationOrganization->set($this->data);
			$this->CertificationOrganization->id = $this->data['CertificationOrganization']['id'];		
			
							
			if($this->CertificationOrganization->validates()) {
				
				
				$this->request->data["CertificationOrganization"]["modification_date"] 		    = date("Y-m-d h:i:s");
				if($this->CertificationOrganization->save($this->data)) {
					$this->Session->setFlash('Certification Organization information has been updated successfully.');
					$this->redirect('/admin/certificationorganizations/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
							
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->CertificationOrganization->id = $id;
						$this->request->data = $this->CertificationOrganization->read();
					} else {
						$this->Session->setFlash('Invalid Certification Organization id.');
						$this->redirect('/admin/certificationorganizations/');
				}
			}	
		}
		
		public function admin_index($status = null)
		{			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by Certification Organization...") ) {					
					$conditions["OR"] = array(
												"CertificationOrganization.name LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['CertificationOrganization']['statusTop']) ) {
							$action = $this->data['CertificationOrganization']['statusTop'];
						}elseif( !empty($this->data['CertificationOrganization']['status'])) {
							$action = $this->data['CertificationOrganization']['status'];
						}
						
						if(isset($this->data['CertificationOrganization']['id']) && count($this->data['CertificationOrganization']['id']) > 0) {
							$this->update_status(trim($action), $this->data['CertificationOrganization']['id'], count($this->data['CertificationOrganization']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by Certification Organization...') && $this->data["submit"]=='Search'){
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
									"CertificationOrganization.name LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('CertificationOrganization.name' => 'ASC'));
			$certificationorganizations = $this->paginate('CertificationOrganization'); //default take the current
			$this->set('certificationorganizations', $certificationorganizations);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['CertificationOrganization']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['CertificationOrganization']['options']['page']);
		}
		
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->CertificationOrganization->id = $ids[$ctr];
						$this->CertificationOrganization->saveField("status", '1');
					}
					$this->Session->setFlash('Certification Organization(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->CertificationOrganization->id = $ids[$ctr];
						$this->CertificationOrganization->saveField("status", '0');
					}
					$this->Session->setFlash('Certification Organization(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->CertificationOrganization->create();
						$this->CertificationOrganization->id = $ids[$i];
						
						$this->CertificationOrganization->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Certification Organization(s) has been deleted successfully.');
					break;
			}
		}
		
		/**************Certification Start Here******************/
		public function update_statusb($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Certification->id = $ids[$ctr];
						$this->Certification->saveField("status", '1');
					}
					$this->Session->setFlash('Certification(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Certification->id = $ids[$ctr];
						$this->Certification->saveField("status", '0');
					}
					$this->Session->setFlash('Certification(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->Certification->create();
						$this->Certification->id = $ids[$i];
						
						$this->Certification->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Certification(s) has been deleted successfully.');
					break;
			}
		}
		public function admin_certification($status = null)
		{			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by certification or organization...") ) {					
					/*$conditions["OR"] = array(
												"Certification.course LIKE" => "%".$this->data["keyword"]."%"
											);*/
					$conditions["OR"] = array(
												"Certification.course LIKE" => "%".$this->data["keyword"]."%",
												"CertificationOrganization.name LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					$this->redirect('/admin/certificationorganizations/certification/keyword:'.$this->data["keyword"]);
				}else{						
						if( !empty($this->data['Certification']['statusTop']) ) {
							$action = $this->data['Certification']['statusTop'];
						}elseif( !empty($this->data['Certification']['status'])) {
							$action = $this->data['Certification']['status'];
						}
						
						if(isset($this->data['Certification']['id']) && count($this->data['Certification']['id']) > 0) {
							$this->update_statusb(trim($action), $this->data['Certification']['id'], count($this->data['Certification']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by certification...') && $this->data["submit"]=='Search'){
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
									"Certification.course LIKE" => "%".$this->params["named"]["keyword"]."%",
									"CertificationOrganization.name LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					//
					//echo $keyword;
			$this->set('keyword', $keyword);
			//die('here');
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('CertificationOrganization.name' => 'ASC'));
			
			$certifications = $this->paginate('Certification'); //default take the current
			
			
			
			$this->set('certifications', $certifications);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			
			
			
			$this->set('limit', $this->params['request']['paging']['Certification']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Certification']['options']['page']);
			
			
		}
		public function admin_addcertification(){
			
				
			
			$this->set("certificationorganizations",$this->CertificationOrganization->find('list',array('fields'=>array('CertificationOrganization.id','CertificationOrganization.name'),'order'=>array('CertificationOrganization.name ASC'))));
			
			if(!empty($this->data)) {
		
				$this->Certification->set($this->data);
				if($this->Certification->validates()) {
						
					    
					    $this->request->data["Certification"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Certification"]["modification_date"] 		    = date("Y-m-d h:i:s");
					    	//pr($this->request->data);
					    //$this->loadModel('ClubBranch');
					   
						if($this->Certification->save($this->request->data)) {	
										
							$this->Session->setFlash('Certification has been created successfully.');
							$this->redirect('/admin/certificationorganizations/certification/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_viewcertification(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("certificationInfo",$this->Certification->find("first",array("conditions"=>array("Certification.id"=>$this->params["pass"][0]))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_editcertification($id = null)
		{
				
			$this->set("certificationorganizations",$this->CertificationOrganization->find('list',array('fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));
			
			if(!empty($this->data)){
			
			$this->Certification->set($this->data);
			$this->Certification->id = $this->data['Certification']['id'];		
			
							
			if($this->Certification->validates()) {
				
				
				$this->request->data["Certification"]["modification_date"] 		    = date("Y-m-d h:i:s");
				if($this->Certification->save($this->data)) {
					$this->Session->setFlash('Certification information has been updated successfully.');
					$this->redirect('/admin/certificationorganizations/certification/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
				//$this->request->data["Club"]["logo"]=$this->request->data["Club"]["old_image"];				
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Certification->id = $id;
						$this->request->data = $this->Certification->read();
					} else {
						$this->Session->setFlash('Invalid Certification id.');
						$this->redirect('/admin/certificationorganizations/certification/');
				}
			}	
		}
		
		
		/**************Degree Start Here******************/
		public function update_statusd($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Degree->id = $ids[$ctr];
						$this->Degree->saveField("status", '1');
					}
					$this->Session->setFlash('Degree(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Degree->id = $ids[$ctr];
						$this->Degree->saveField("status", '0');
					}
					$this->Session->setFlash('Degree(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->Degree->create();
						$this->Degree->id = $ids[$i];
						
						$this->Degree->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Degree(s) has been deleted successfully.');
					break;
			}
		}
		public function admin_degree($status = null)
		{	
			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by Degree...") ) {					
					$conditions["OR"] = array(
												"Degree.name LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['Degree']['statusTop']) ) {
							$action = $this->data['Degree']['statusTop'];
						}elseif( !empty($this->data['Degree']['status'])) {
							$action = $this->data['Degree']['status'];
						}
						
						if(isset($this->data['Degree']['id']) && count($this->data['Degree']['id']) > 0) {
							$this->update_statusd(trim($action), $this->data['Degree']['id'], count($this->data['Degree']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by Degree...') && $this->data["submit"]=='Search'){
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
									"Degree.name LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Degree.name' => 'ASC'));
			$degrees = $this->paginate('Degree'); //default take the current
			$this->set('degrees', $degrees);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['Degree']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Degree']['options']['page']);
		}
		
		public function admin_adddegree(){
				
			if(!empty($this->data)) {
		
				$this->Degree->set($this->data);
				if($this->Degree->validates()) {
						
					    
					    $this->request->data["Degree"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Degree"]["modification_date"] 		    = date("Y-m-d h:i:s");
					    	//pr($this->request->data);
					    //$this->loadModel('ClubBranch');
					   
						if($this->Degree->save($this->request->data)) {	
										
							$this->Session->setFlash('Degree has been created successfully.');
							$this->redirect('/admin/certificationorganizations/degree/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_viewdegree(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("DegreeInfo",$this->Degree->find("first",array("conditions"=>array("Degree.id"=>$this->params["pass"][0]))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_editdegree($id = null)
		{
				
			
			
			if(!empty($this->data)){
			
			$this->Degree->set($this->data);
			$this->Degree->id = $this->data['Degree']['id'];		
			
							
			if($this->Degree->validates()) {
				
				
				$this->request->data["Degree"]["modification_date"] 		    = date("Y-m-d h:i:s");
				if($this->Degree->save($this->data)) {
					$this->Session->setFlash('Degree information has been updated successfully.');
					$this->redirect('/admin/certificationorganizations/degree/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
				//$this->request->data["Club"]["logo"]=$this->request->data["Club"]["old_image"];				
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Degree->id = $id;
						$this->request->data = $this->Degree->read();
					} else {
						$this->Session->setFlash('Invalid Degree id.');
						$this->redirect('/admin/certificationorganizations/degree/');
				}
			}	
		}
		
		
	}