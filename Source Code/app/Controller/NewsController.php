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
	class NewsController extends AppController {

		public $name 		= 'News';
		public $helpers 	= array('Html','Session','Cksource');
		
		public $uses 		= array('Country','Member','Club','Trainer','Corporation','Trainee','CertificationOrganization','Certification','Degree','Page','Neww');
		public $components  = array('Upload');			
		public $facebook;
		public $amazon;
	
		public function admin_add(){
			
			if(!empty($this->data)) {
		
				$this->Neww->set($this->data);
				if($this->Neww->validates()) {
						if( !empty($this->data["Neww"]["logo"]) ) {
							$filename = $this->data["Neww"]["logo"]["name"];
							$target = $this->config["upload_path"];
							$this->Upload->upload($this->data["Neww"]["logo"], $target, null, null);
  					        $this->request->data["Neww"]["logo"] = $this->Upload->result; 					
						}else{	
							
							unset($this->request->data["Neww"]["logo"]);
							$this->request->data["Neww"]["logo"] = '';							
					    }
					    
					    $this->request->data["Neww"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Neww"]["modified_date"] 		= date("Y-m-d h:i:s");
					    	
						if($this->Neww->save($this->data)) {				
							$this->Session->setFlash('News has been created successfully.');
							$this->redirect('/admin/news/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_view(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("newInfo",$this->Neww->find("first",array("conditions"=>array("Neww.id"=>$this->params["pass"][0]))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_edit($id = null)
		{			
			if(!empty($this->data)){
			
			$this->Neww->set($this->data);
			$this->Neww->id = $this->data['Neww']['id'];		
			
							
			if($this->Neww->validates()) {
				
				if(!empty($this->request->data["Neww"]["logo"]["name"]))
				{
					$filename = $this->request->data["Neww"]["logo"]["name"];
					$target = $this->config["upload_path"];
					$this->Upload->upload($this->data["Neww"]["logo"], $target, null, null);
  					$this->request->data["Neww"]["logo"] = $this->Upload->result; 
  					$picPath = $this->config["upload_path"].$this->request->data["Neww"]["old_image"];
					@unlink($picPath);
				}else{	
					
					if(!empty($this->request->data["Neww"]["old_image"])){
						$this->request->data["Neww"]["logo"] = $this->request->data["Neww"]["old_image"];			
					}
					else{
						$this->request->data["Neww"]["logo"] = "";
					}
				}
				$this->request->data["Neww"]["modified_date"] 		    = date("Y-m-d h:i:s");
				if($this->Neww->save($this->data)) {
					$this->Session->setFlash('News information has been updated successfully.');
					$this->redirect('/admin/news/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
				$this->request->data["Neww"]["logo"]=$this->request->data["Neww"]["old_image"];				
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Neww->id = $id;
						$this->request->data = $this->Neww->read();
					} else {
						$this->Session->setFlash('Invalid News id.');
						$this->redirect('/admin/news/');
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
												"Neww.heading LIKE" => "%".$this->data["keyword"]."%",
												"Neww.description LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['Neww']['statusTop']) ) {
							$action = $this->data['Neww']['statusTop'];
						}elseif( !empty($this->data['Neww']['status'])) {
							$action = $this->data['Neww']['status'];
						}
						
						if(isset($this->data['Neww']['id']) && count($this->data['Neww']['id']) > 0) {
							$this->update_status(trim($action), $this->data['Neww']['id'], count($this->data['Neww']['id']));
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
									"Neww.heading LIKE" => "%".$this->params["named"]["keyword"]."%",
									"Neww.description LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Neww.heading' => 'ASC'));
			$news = $this->paginate('Neww'); //default take the current
			$this->set('news', $news);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['Neww']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Neww']['options']['page']);
		}
		
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Neww->id = $ids[$ctr];
						$this->Neww->saveField("status", '1');
					}
					$this->Session->setFlash('News has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Neww->id = $ids[$ctr];
						$this->Neww->saveField("status", '0');
					}
					$this->Session->setFlash('News has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->Neww->create();
						$this->Neww->id = $ids[$i];
						
						$this->Neww->delete($ids[$i]);
						
					}
					$this->Session->setFlash('News has been deleted successfully.');
					break;
			}
		}
		
		function removePic() {
				
			$this->layout = '';
			$this->render = false;
		
			if($this->data) {
				
				$userPic = $this->Neww->find("first",array("fields"=>array("logo"),"conditions"=>array("Neww.id"=>$this->data["id"])));
				$picPath = $this->config["upload_path"].$userPic["Neww"]["logo"];
				unlink($picPath);
				
				$data["logo"] = null;
				if( $this->Neww->updateAll($data,array("Neww.id"=>$this->data["id"])) ) {
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully updated");
				}else{
					$response = array("responseclassName"=>"nFailure","errorMsg"=>"unable to process the request");
				}
				echo json_encode($response);
				exit;	
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
			//$this->set("faqInfo",$this->Neww->find("all",array("conditions"=>array("Neww.status"=>1))));	
			$setSpecalistArrURL=$this->Admin->find("first",array("conditions"=>array("Admin.name"=>Admin)));
			$this->set("setSpecalistArrURL",$setSpecalistArrURL);		
		}	
		
	}