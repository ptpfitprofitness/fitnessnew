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
	class TrainersController extends AppController {

		public $name 		= 'Trainers';
		public $helpers 	= array('Html','Session','Cksource','Csv');
		public $uses 		= array('Country','Member','Club','Trainer','CertificationOrganization','Certification','Degree','CertificationTrainers','Managemail','Trainee');
		public $components  = array('Upload','Email');			
		public $facebook;
		public $amazon;
	
		public function admin_add(){
			
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
			
			
			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name','Club.email'),'order' => array('Club.club_name' => 'ASC'))));				
			
			$this->set("cert_org",$this->CertificationOrganization->find('list',array('fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));
			$this->set("certifications",$this->Certification->find('list',array('fields'=>array('Certification.id','Certification.course'))));
			
			$this->set("degrees",$this->Degree->find('list',array('fields'=>array('Degree.id','Degree.name'))));
			
			if(!empty($this->data)) {
		
				$this->Club->set($this->data);
				if($this->Club->validates()) {
						if( !empty($this->data["Trainer"]["logo"]) ) {
							$filename = $this->data["Trainer"]["logo"]["name"];
							$target = $this->config["upload_path"];
							$this->Upload->upload($this->data["Trainer"]["logo"], $target, null, null);
  					        $this->request->data["Trainer"]["logo"] = $this->Upload->result; 					
						}else{	
							
							unset($this->request->data["Trainer"]["logo"]);
							$this->request->data["Trainer"]["logo"] = '';							
					    }
					    
					      $this->request->data["Trainer"]["username"]= $this->data["Trainer"]["email"];
					    $this->request->data["Trainer"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Trainer"]["modified_date"] 		    = date("Y-m-d h:i:s");
					    /*echo "<pre>";
						print_r($this->data);
						echo "<pre>";
						//die;*/
						if($this->Trainer->save($this->data)) {
						$this->Session->setFlash('Trainer information has been updated successfully.');
						$this->redirect('/admin/trainers/');
						}
						else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_view(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("trainerInfo",$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$this->params["pass"][0]))));
				$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_edit($id = null)
		{
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
			//$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));

			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name','Club.email'),'order' => array('Club.club_name' => 'ASC'))));	
			
			$this->set("cert_org",$this->CertificationOrganization->find('list',array('fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));
			$this->set("certifications",$this->Certification->find('list',array('fields'=>array('Certification.id','Certification.course'))));
			
			$this->set("degrees",$this->Degree->find('list',array('fields'=>array('Degree.id','Degree.name'))));
			
			
			if(!empty($this->data)){
			
			$this->Trainer->set($this->data);
			$this->Trainer->id = $this->data['Trainer']['id'];		
			
							
			if($this->Trainer->validates()) {
				
				if(!empty($this->request->data["Trainer"]["logo"]["name"]))
				{
					$filename = $this->request->data["Trainer"]["logo"]["name"];
					$target = $this->config["upload_path"];
					$this->Upload->upload($this->data["Trainer"]["logo"], $target, null, null);
  					$this->request->data["Trainer"]["logo"] = $this->Upload->result; 
  					$picPath = $this->config["upload_path"].$this->request->data["Trainer"]["old_image"];
					@unlink($picPath);
				}else{	
					
					if(!empty($this->request->data["Trainer"]["old_image"])){
						$this->request->data["Trainer"]["logo"] = $this->request->data["Trainer"]["old_image"];			
					}
					else{
						$this->request->data["Trainer"]["logo"] = "";
					}
				}
				
				 $this->request->data["Trainer"]["username"]= $this->data["Trainer"]["email"];
				$this->request->data["Trainer"]["modified_date"] 		    = date("Y-m-d h:i:s");
				if($this->Trainer->save($this->data)) {
					$this->Session->setFlash('Trainer information has been updated successfully.');
					$this->redirect('/admin/trainers/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else{				
				$this->request->data["Trainer"]["logo"]=$this->request->data["Trainer"]["old_image"];				
			}				
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->Trainer->id = $id;
						$this->request->data = $this->Trainer->read();
					} else {
						$this->Session->setFlash('Invalid Trainer id.');
						$this->redirect('/admin/trainers/');
				}
			}	
		}
		
		public function admin_addcerti($trid=null)
		{
			
			 $id = $trid;
			
			if($id!='')
			{
			$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$id)));
			if(!empty($setSpecalistArr)){
		    $this->set("setSpecalistArr",$setSpecalistArr);
		    $this->set("trid",$trid);
			
			
			$this->set("cert_org",$this->CertificationOrganization->find('list',array('fields'=>array('CertificationOrganization.name','CertificationOrganization.name'))));
			
			
			
			$this->set("certifications",$this->Certification->find('list',array('fields'=>array('Certification.course','Certification.course'))));
			
			$this->set("degrees",$this->Degree->find('list',array('fields'=>array('Degree.name','Degree.name'))));
			
			if(!empty($this->data)) {
			
				$this->CertificationTrainers->set($this->data);
				//$this->Trainer->id = $this->data['Trainer']['id'];	
				if($this->CertificationTrainers->validates()) {
						
					    
					    $this->request->data["CertificationTrainers"]["added_date"] 		    = date("Y-m-d");
						$this->request->data["CertificationTrainers"]["modified_date"] 		= date("Y-m-d");
					    	//pr($this->request->data);
					    //$this->loadModel('ClubBranch');
					   
						if($this->CertificationTrainers->save($this->request->data)) {	
										
							$this->Session->setFlash('Certification has been created successfully.');
							$this->redirect('/admin/trainers/managecerti/'.$id);
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
			  }
			  else {
				
				$this->redirect('/admin/trainers/');
			   }
			} else {
				
				$this->redirect('/admin/trainers/');
			}
			
		}
		
		public function admin_managecerti($trid=null)
		{
			 $id = $trid;
			if($id!='')
			{
			$conditions=array('CertificationTrainers.trainer_id'=>$id);
			$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$id)));
			
			if(!empty($setSpecalistArr)){
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '50', 'order' => array('CertificationTrainers.id' => 'DESC'));
			
			$trainers = $this->paginate('CertificationTrainers'); //default take the current
			 
			
			
			$this->set('trainerinfo', $setSpecalistArr);
			$this->set('certifications', $trainers);
			$this->set('trid', $trid);
			
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['CertificationTrainers']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['CertificationTrainers']['options']['page']);
			  } else 
				{
					$this->redirect('/admin/trainers/');
				}
			} else 
			{
				$this->redirect('/admin/trainers/');
			}
			
			
		}
		
		public function admin_index($status = null)
		{			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by email or Trainer Name...") ) {					
					$conditions["OR"] = array(
												"Trainer.first_name LIKE" => "%".$this->data["keyword"]."%",
												"Trainer.last_name LIKE" => "%".$this->data["keyword"]."%",
												"Trainer.email LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['Trainer']['statusTop']) ) {
							$action = $this->data['Trainer']['statusTop'];
						}elseif( !empty($this->data['Trainer']['status'])) {
							$action = $this->data['Trainer']['status'];
						}
						
						if(isset($this->data['Trainer']['id']) && count($this->data['Trainer']['id']) > 0) {
							$this->update_status(trim($action), $this->data['Trainer']['id'], count($this->data['Trainer']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by email or Trainer Name...') && $this->data["submit"]=='Search'){
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
									"Trainer.first_name LIKE" => "%".$this->params["named"]["keyword"]."%",
									"Trainer.last_name LIKE" => "%".$this->params["named"]["keyword"]."%",
									"Trainer.email LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Trainer.first_name' => 'ASC'));
			$trainers = $this->paginate('Trainer'); //default take the current
			$this->set('trainers', $trainers);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['Trainer']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Trainer']['options']['page']);
		}
		
		public function admin_unassigntrainer($status = null)
		{			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by email or Trainer Name...") ) {					
					$conditions["OR"] = array(
												"Trainer.first_name LIKE" => "%".$this->data["keyword"]."%",
												"Trainer.last_name LIKE" => "%".$this->data["keyword"]."%",
												"Trainer.email LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['Trainer']['statusTop']) ) {
							$action = $this->data['Trainer']['statusTop'];
						}elseif( !empty($this->data['Trainer']['status'])) {
							$action = $this->data['Trainer']['status'];
						}
						
						if(isset($this->data['Trainer']['id']) && count($this->data['Trainer']['id']) > 0) {
							$this->update_status(trim($action), $this->data['Trainer']['id'], count($this->data['Trainer']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by email or Trainer Name...') && $this->data["submit"]=='Search'){
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
									"Trainer.first_name LIKE" => "%".$this->params["named"]["keyword"]."%",
									"Trainer.last_name LIKE" => "%".$this->params["named"]["keyword"]."%",
									"Trainer.email LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>array('Trainer.club_id'=>NULL),'limit' => '10', 'order' => array('Trainer.first_name' => 'ASC'));
			$trainers = $this->paginate('Trainer'); //default take the current
			$this->set('trainers', $trainers);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['Trainer']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['Trainer']['options']['page']);
		}
		
		
		public function admin_userautocomplete()
		{
			
			$this->layout='';
			$this->autoRender=false;
			
			if(trim($_REQUEST['q'])!='')
			{
				$keyw=trim($_REQUEST['q']);
				$conditions["OR"] = array(
									/*"Trainer.first_name LIKE" => "%".$keyw."%",
									"Trainer.last_name LIKE" => "%".$keyw."%",*/
									"Trainer.email LIKE" => "%".$keyw."%"
								);
								
			  $udata = $this->Trainer->find('all', array('conditions'=>$conditions,'fields'=>array('Trainer.email')));
			  if(!empty($udata))
			  {
			  	$uArr=array();
			  	foreach($udata as $key=>$val)
			  	{
			  		echo $val['Trainer']['email']."\n";
			  	}
			  	 //echo print_r($uArr);
			  	
			  }					
			}
			exit();
		}
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Trainer->id = $ids[$ctr];
						$this->Trainer->saveField("status", '1');
					}
					$this->Session->setFlash('Trainer(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->Trainer->id = $ids[$ctr];
						$this->Trainer->saveField("status", '0');
					}
					$this->Session->setFlash('Trainer(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->Trainer->create();
						$this->Trainer->id = $ids[$i];
						
						$trainerdeldata=$this->Trainer->find('first',array('conditions'=>array('Trainer.id'=>$ids[$i]),'fields'=>array('Trainer.email','Trainer.first_name','Trainer.id')));		
						
						$this->set("trainerdeldata",$trainerdeldata);
						
						$tranrsdata=$this->Trainee->find('all',array('conditions'=>array('Trainee.trainer_id'=>$ids[$i]),'fields'=>array('Trainee.id','Trainee.full_name','Trainee.email')));
						
						$this->set("trainees",$tranrsdata);
						/*echo "<pre>";
						print_r($tranrsdata);
						echo "</pre>";*/
						
						$client_list = NULL;
						
						foreach($tranrsdata as $transDeep){
						
							$client_list .= $prefix . '' . $transDeep['Trainee']['email'] . '';
						
							$prefix = ', ';
						
							$this->Trainee->query("update trainees set trainer_id=NULL where id='".$transDeep['Trainee']['id']."' AND trainer_id='".$trainerdeldata['Trainer']['id']."'");
						}					
												
						$this->send_mail_to_admin($trainerdeldata['Trainer']['email'],$trainerdeldata['Trainer']['first_name'],$client_list);
						
						$this->Trainer->delete($ids[$i]);
					}
					$this->Session->setFlash('Trainer(s) has been deleted successfully.');
					break;
				case "unassignclient":
					for($i=0;$i<$count;$i++){
						$this->Trainer->create();
						
						$this->Trainer->id = $ids[$i];
						
						$trainerdeldata=$this->Trainer->find('first',array('conditions'=>array('Trainer.id'=>$ids[$i]),'fields'=>array('Trainer.email','Trainer.first_name','Trainer.id')));		
						
						$this->set("trainerdeldata",$trainerdeldata);
						
						$tranrsdata=$this->Trainee->find('all',array('conditions'=>array('Trainee.trainer_id'=>$ids[$i]),'fields'=>array('Trainee.id','Trainee.full_name','Trainee.email')));
						
						$this->set("trainees",$tranrsdata);
						/*echo "<pre>";
						print_r($tranrsdata);
						echo "</pre>";*/
						
						$client_list = NULL;
						
						foreach($tranrsdata as $transDeep){
						
							$client_list .= $prefix . '' . $transDeep['Trainee']['email'] . '';
						
							$prefix = ', ';
						
							$this->Trainee->query("update trainees set trainer_id=NULL where id='".$transDeep['Trainee']['id']."' AND trainer_id='".$trainerdeldata['Trainer']['id']."'");
						}					
												
						$this->send_mail_to_admin($trainerdeldata['Trainer']['email'],$trainerdeldata['Trainer']['first_name'],$client_list);
						//$this->send_mail_to_trainer($trainerdeldata['Trainer']['email'],$trainerdeldata['Trainer']['first_name']);
						
						//$this->Trainer->delete($ids[$i]);
					}
					$this->Session->setFlash('Client(s) has been Un-Assigned successfully.');
					break;
			}
		}
		
		function send_mail_to_admin($temail,$tfname,$cllist) {		
		App::uses('CakeEmail', 'Network/Email');	
		//$admin_email	= 'synapseindia8@gmail.com';
		$admin_email	= 'registration@ptpfitpro.com';
		$email = new CakeEmail();		
		$email->emailFormat('html');
	
				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello  Admin!</p>
				<p>An Individual Trainer with following details and his asscociated client(s) has been un-assigned.</p>				
				<p>Trainer Name-: '.$tfname.'</p>
				<p>Trainer Email-: '.$temail.'</p>
				<p>Trainer Client List-: '.$cllist.'</p>				
				</td></tr><tr><td><br/>Thanks,<br/>Fitness Team<br /></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(FROM_EMAIL => EMAILNAME));
		$email->to($admin_email);		
		$subtxt = __('Individual Trainer Clients Un Assigned.');
		$email->subject($subtxt);
		$email->send($content);
	}
		
		/*function send_mail_to_trainer($temail,$tfname) {		
		App::uses('CakeEmail', 'Network/Email');		
		$email = new CakeEmail();		
		$email->emailFormat('html');
	
				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello  '.$tfname.'!</p>
				<p>As per your resquest with us, we have successfully deleted your account. Please get in touch with us for any further assistance.</p>				
							
				</td></tr><tr><td><br/>Thanks again,<br/>Fitness Team<br /></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(FROM_EMAIL => EMAILNAME));
		$email->to($temail);		
		$subtxt = __('Account Deletion Confirmation.');
		$email->subject($subtxt);
		$email->send($content);
	}*/
		
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
					$dataCheck = $this->Trainer->find('all', array('conditions'=>array('Trainer.email'=>trim($validateValue), 'Trainer.id !='=>trim($row_id))));
				}else{
					$dataCheck = $this->Trainer->find('all', array('conditions'=>array('Trainer.email'=>trim($validateValue))));
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
					
					
					$i++;
				}
				$this->set("jobsposted",$jobsposted);
				
				
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"hirer_id","fields"=>array("Member.full_name","Member.logo","Member.id"))))); 
				
				$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("Member.full_name","Member.logo","Member.id"))))); 
				
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("QuickTask"=>array("foreignKey"=>"task_id"))));
				
				$this->QuickHireSale->recursive = 2;				
				$quickPostedTask = $this->QuickHireSale->find("all",array("conditions"=>array("QuickHireSale.hirer_id"=>$this->Session->read("user_id"),"QuickHireSale.status"=>"0"),"order"=>"QuickHireSale.id desc"));
				
				$this->set("quickPostedTask",$quickPostedTask);
			
				
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
		
		public function updateAlerts()
		{
			$this->layout     = null;
			$this->autoRender = false;
			
			$this->loadModel("Alert");
			$this->Alert->create();
			
			Configure::write("debug",0);
			if( empty($this->data["value"]) )
				$this->request->data["value"] = 0;
			
			$userSetting = $this->Alert->find("list",array("fields"=>array("id","member_id"),"conditions"=>array("member_id"=>$this->Session->read("user_id"))));
			
			if(!empty($userSetting)){ 
				$this->Alert->updateAll(array("Alert.".$this->data["name"]=>$this->data["value"],"Alert.updated_on"=>"'".date("Y-m-d h:i:s")."'"),array("Alert.member_id"=>$this->Session->read("user_id")));
			}else{
				$data = array($this->data["name"]=>$this->data["value"],"updated_on"=>date("Y-m-d h:i:s"),"member_id"=>$this->Session->read("user_id"));
				 
				if( $this->Alert->save($data) ) 
					echo "saved";
				else
					echo "not-saved";
			}
			
			$this->Session->write("user_settings",$this->Alert->find("first",array("conditions"=>array("Alert.member_id"=>$this->Session->read("user_id")))));
			
			exit;		
		}
		
		public function updateSetting() {
			
			$this->layout    = '';
			$this->autoRender = false;
			
			$error   = 0;
			$message = "";
			
			Configure::write('debug',0);
			if($this->data)
			{
				if( $this->data["Member"]["collegeStudent1"] == "0")
				{
					$fields = array("Member.type"=>"hirer");
				}else{
					$emailExt = explode(".",$this->data["Member"]["validateEDEmail"]);
					$count 	  = count($emailExt);
					$count--;
					
					if($emailExt[$count] == "edu") {
						
						$memberInfo = $this->Member->find("first",array("conditions"=>array("Member.helplers_email"=>$this->data["Member"]["validateEDEmail"])));
											
						if(!empty($memberInfo)){
							$error   = 1;
							$message = ".edu Email Address already exists.";
						}else{
							$fields = array("Member.activation_code"=>md5($this->data["Member"]["validateEDEmail"]),"Member.type"=>"helpler","Member.helplers_email"=>$this->data["Member"]["validateEDEmail"]);
							$memberInfo = $this->Member->find("first",array("conditions"=>array("Member.id"=>$this->Session->read("user_id"))));
						
							$content = str_replace("MAILNAME",$memberInfo["Member"]["first_name"]." ".$memberInfo["Member"]["last_name"],Configure::read('message.eduMailConfirmation'));
								
							//$content = str_replace("LINK",Configure::read('Website.url')."members/helpler_activate/".md5($this->data["Member"]["validateEDEmail"]),$content);
							$content = str_replace("LINK","<a href='".Configure::read('Website.url')."members/helpler_activate/".md5($userData["Member"]["helplers_email"])."'>Click here to confirm the edu email address</a>",$content);
							
							$subject = "Helpler's Email address account verification";
								
							$this->sendEmailMessage($this->data["Member"]["validateEDEmail"],$subject,$content,null,null);
						}	
					}else{
						$error   = 1;
						$message = "Invalid .edu Email Address format.";						
					}
				}
				
				$fields = $this->addQuote($fields);
				if($error == 0)		
					$this->Member->updateAll($fields,array("Member.id"=>$this->Session->read("user_id")));
					
				echo json_encode(array("error"=>$error,"message"=>$message));
				exit;
			}
			
		}
		
		public function privateMessage()
		{			
			Configure::write("debug",0);
			$this->layout = "inside_layout";
			$this->validateUser();			
			
			$user_id = $this->Session->read('user_id');			
			$userInfo = $this->Member->find("first",array("conditions"=>array("Member.id"=>$user_id)));			
			$this->set("userInfo",$userInfo);
			
			if(!$this->params["pass"][1])
			{
				if($this->params["pass"][0]) 
				{
					$this->loadModel("TaskPM");
					$this->TaskPM->Create();				
					
					$this->Task->bindModel(array("hasMany"=>array("TaskPM"=>array("fields"=>array("TaskPM.message","TaskPM.postedOn","TaskPM.posted_by","TaskPM.id","TaskPM.TaskUploadedDocs"),"foreignKey"=>"job_id"))));
								
					$this->Task->bindModel(array("belongsTo"=>array("Member"=>array("fields"=>array("Member.full_name","Member.id"),"foreignKey"=>"user_id"))));
					
					$this->Task->recursive = 2;
					$jobs = $this->Task->find("first",array("conditions"=>array("Task.id"=>$this->params["pass"][0])));
					
					if( $this->Session->read("user_id") != $jobs["Member"]["id"] ){
						$jobs["Member"]["first_name"] = $userInfo["Member"]["first_name"];
					}
					$i=0;
					
					foreach($jobs["TaskPM"] as $job) {
						$memberInfo = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$job["posted_by"])));
						
						$jobs["TaskPM"][$i]["Member"] = $memberInfo["Member"];
						$i++;
					}
					$this->set("job",$jobs); 				
					
					$this->TaskPM->updateAll(array("TaskPM.status"=>1),array("TaskPM.posted_to"=>$this->Session->read("user_id"),"TaskPM.job_id"=>$this->params["pass"][0]));
					
				}else{
					$this->redirect($_SERVER["HTTP_REFERER"]);			
				}
			}else{
				if($this->params["pass"][0]) 
				{
					$this->loadModel("TaskPM");
					$this->TaskPM->Create();				
					
					$this->QuickTask->bindModel(array("hasMany"=>array("TaskPM"=>array("fields"=>array("TaskPM.message","TaskPM.postedOn","TaskPM.posted_by","TaskPM.id","TaskPM.TaskUploadedDocs"),"foreignKey"=>"job_id"))));
								
					$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("fields"=>array("Member.full_name","Member.id"),"foreignKey"=>"user_id"))));
					
					$this->QuickTask->recursive = 2;
					$jobs = $this->QuickTask->find("first",array("conditions"=>array("QuickTask.id"=>$this->params["pass"][0])));
					
					if( $this->Session->read("user_id") != $jobs["Member"]["id"] ){
						$jobs["Member"]["first_name"] = $userInfo["Member"]["first_name"];
					}
					$i=0;
					
					foreach($jobs["TaskPM"] as $job) {
						$memberInfo = $this->Member->find("first",array("fields"=>array("Member.full_name","Member.logo"),"conditions"=>array("Member.id"=>$job["posted_by"])));
						
						$jobs["TaskPM"][$i]["Member"] = $memberInfo["Member"];
						$i++;
					}
					$this->set("job",$jobs); 				
					
					$this->TaskPM->updateAll(array("TaskPM.status"=>1),array("TaskPM.posted_to"=>$this->Session->read("user_id"),"TaskPM.job_id"=>$this->params["pass"][0]));
					
				}else{
					$this->redirect($_SERVER["HTTP_REFERER"]);			
				}
			
			}
		
		}
		
		public function post_message() {
		
			$this->layout     = "";
			
			if($this->data)
			{
				Configure::write("debug",0);
				
				$this->loadModel("TaskPM");
				$this->TaskPM->create();
				
				$this->request->data["TaskPM"] = $this->data["Member"];
				$this->request->data["TaskPM"]["postedOn"] = date("Y-m-d H:i:s");
				$this->request->data["TaskPM"]["status"]   = "0";
				$count = $this->request->data["TaskPM"]["count"];
				
				$this->request->data["TaskPM"]["message"]   		 = $this->request->data["TaskPM"]["message$count"];
				$this->request->data["TaskPM"]["TaskUploadedDocs"]   = $this->request->data["TaskPM"]["TaskUploadedDocs$count"];
				$this->request->data["TaskPM"]["posted_to"]   		 = $this->request->data["TaskPM"]["posted_to$count"];
				$this->request->data["TaskPM"]["job_id"]   	  	  	 = $this->request->data["TaskPM"]["job_id$count"];
				$this->request->data["TaskPM"]["posted_by"]   		 = $this->request->data["TaskPM"]["posted_by$count"];
				$this->request->data["TaskPM"]["sales_id"]   		 = $this->request->data["TaskPM"]["sales_id$count"];
							
				unset($this->request->data["Member"]);				
				if( $this->TaskPM->save($this->data) ) 
				{
					$this->request->data["TaskPM"]["id"] = $this->TaskPM->id; 
					
					$this->Member->bindModel(array("hasMany"=>array("Alert"=>array("foreignKey"=>"member_id"))));
					$receiver = $this->Member->find("first",array("fields"=>array("full_name","phone_number","email"),"conditions"=>array("Member.id"=>$this->request->data["TaskPM"]["posted_to"])));
					
					$this->Member->bindModel(array("hasMany"=>array("Alert"=>array("foreignKey"=>"member_id"))));
					$sender   = $this->Member->find("first",array("fields"=>array("email","full_name","phone_number","logo"),"conditions"=>array("Member.id"=>$this->request->data["TaskPM"]["posted_by"])));
					
					$content = str_replace("RECEIVER",$receiver["Member"]["full_name"],Configure::read('message.PMmessageNotification'));
					$content = str_replace("SENDER",$sender["Member"]["full_name"],$content);
					
					if(!empty($receiver["Member"]["email"]))
						$this->sendEmailMessage($receiver["Member"]["email"],Configure::read('Website.email_subject_signature').":New Private Message Notification",$content,null,null);
					
					$content1 = str_replace("RECEIVER",$receiver["Member"]["full_name"],Configure::read('message.PMmessageSenderNotification'));
					$content1 = str_replace("SENDER",$sender["Member"]["full_name"],$content);
					
					if( $sender["Alert"][0]["email_receive_message"] == "1") {
						if(!empty($sender["Member"]["email"]))
							$this->sendEmailMessage($sender["Member"]["email"],Configure::read('Website.email_subject_signature').":New Private Message Notification",$content,null,null);
					}
					
					if( $sender["Alert"][0]["phone_receive_message"] == "1") {
						if(Configure::read("testMode")){
							$email = Configure::read("phoneNumber");
						}else{
							$email = str_replace("-","",$sender["Member"]["phone_number"]);
						}
						$email = $this->createSmsUrl($email);
						if(!empty($email))
							$this->sendEmailMessage($email,Configure::read('Website.email_subject_signature').":New Private Message Notification",$content,null,null);
					}
					
					if( $receiver["Alert"][0]["email_sends_message"] == "1") {
						if(!empty($receiver["Member"]["email"]))
							$this->sendEmailMessage($receiver["Member"]["email"],Configure::read('Website.email_subject_signature').":New Private Message Notification",$content1,null,null);
					}
					
					if( $receiver["Alert"][0]["phone_sends_message"] == "1") {
						if(Configure::read("testMode")){
							$email = Configure::read("phoneNumber");
						}else{
							$email = str_replace("-","",$receiver["Member"]["phone_number"]);
						}
						$email = $this->createSmsUrl($email);
						if(!empty($email))
							$this->sendEmailMessage($email,Configure::read('Website.email_subject_signature').":New Private Message Notification",$content1,null,null);
					}
					
					$error = 0;
					$message = "Message Successfully sent";			
					
					$this->set("activeClass",$this->data["Member"]["ActiveClass"]);					
					$this->set("member_info",$sender);					
					$this->set("message",$this->data["TaskPM"]);					
				}else{
					$this->autoRender = false;
				}
			}
		
		}
		
		function mailT() {
				
			if( $this->sendEmailMessage("synapse0451@gmail.com","TEST",Configure::read('message.welcomeEmail'),"signup","signup")) 
				echo "sent";
				
			die();
		}
		
		
		
		
		function removePic() {
				
			$this->layout = '';
			$this->render = false;
		
			if($this->data) {
				
				$userPic = $this->Club->find("first",array("fields"=>array("logo"),"conditions"=>array("Club.id"=>$this->data["id"])));
				$picPath = $this->config["upload_path"].$userPic["Club"]["logo"];
				unlink($picPath);
				
				$data["logo"] = null;
				if( $this->Club->updateAll($data,array("Club.id"=>$this->data["id"])) ) {
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully updated");
				}else{
					$response = array("responseclassName"=>"nFailure","errorMsg"=>"unable to process the request");
				}
				echo json_encode($response);
				exit;	
			}
		
		}
		
	function removePicTrainer() {
				
			$this->layout = '';
			$this->render = false;
		
			if($this->data) {
				
				$userPic = $this->Trainer->find("first",array("fields"=>array("logo"),"conditions"=>array("Trainer.id"=>$this->data["id"])));
				$picPath = $this->config["upload_path"].$userPic["Trainer"]["logo"];
				unlink($picPath);
				
				$data["logo"] = null;
				if( $this->Trainer->updateAll($data,array("Trainer.id"=>$this->data["id"])) ) {
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully updated");
				}else{
					$response = array("responseclassName"=>"nFailure","errorMsg"=>"unable to process the request");
				}
				echo json_encode($response);
				exit;	
			}
		
		}
		
		function payments() 
		{
			Configure::write("debug",0);
			$this->layout = "inside_layout";
			$this->validateUser();		
			
			$user_id = $this->Session->read('user_id');			
			$userInfo = $this->Member->find("first",array("conditions"=>array("Member.id"=>$user_id)));			
			$this->set("userInfo",$userInfo);
			
			$this->loadModel("QuickHireSale");
			$this->QuickHireSale->create();
			
			$this->amazon = $this->Components->load("Amazon");
			
			

			/* Fetching all working tasks */
				$this->Task->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("full_name","id","logo")))));
				$this->Task->recursive = 2;
				
				$taskRuning = $this->Task->find("all",array("conditions"=>array("Task.transaction_id <>"=>"","Task.status"=>"3","Task.assigned_user_id"=>$this->Session->read("user_id")),"order"=>"Task.id desc"));
				
				$i =0;
				foreach( $taskRuning as $runing ){
					$taskRuning[$i]["Assigned"] = $this->Member->find("first",array("fields"=>array("full_name","id","logo"),"conditions"=>array("Member.id"=>$runing["Task"]["assigned_user_id"]))); 
					$i++;
				}
				$this->set("tasksRunning",$taskRuning);
				
				$conditions = array("QuickTask.user_id"=>$this->Session->read("user_id"));	
				
				$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("full_name","logo")))));
			
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"hirer_id","fields"=>array("full_name","logo","id")))));
			
				$this->QuickTask->bindModel(array("hasMany"=>array("QuickHireSale"=>array("foreignKey"=>"task_id","conditions"=>array("QuickHireSale.status"=>"3","QuickHireSale.transaction_id <>"=>"")))));
				$this->QuickTask->recursive = 2;
			
				$taskQuickRunning = $this->QuickTask->find("all",array("conditions"=>$conditions,"order"=>"id DESC"));
				
				$count = 0;
				foreach($taskQuickRunning as $running){
					if(empty($running["QuickHireSale"]))
						unset($taskQuickRunning[$count]);
					else{
						$taskQuickRunning[$count]["Assigned"] = $this->Member->find("first",array("fields"=>array("full_name","id","logo"),"conditions"=>array("Member.id"=>$running["QuickTask"]["user_id"])));
					}
					$count++;
				}
				$this->set("taskQuickRunning",$taskQuickRunning);
				//echo"<pre>";print_r($taskQuickRunning);die("sasa");
				/*$taskQuickRunning = $this->QuickTask->find("all",array("conditions"=>array("QuickTask.status"=>"3","QuickTask.user_id"=>$this->Session->read("user_id"))));
				
				$i =0;
				foreach($taskQuickRunning as $runing ){
					$taskQuickRunning[$i]["Assigned"] = $this->Member->find("first",array("fields"=>array("full_name","id","logo"),"conditions"=>array("Member.id"=>$runing["QuickTask"]["user_id"])));
					$i++;
				}
				$this->set("taskQuickRunning",$taskQuickRunning); */
			/* Fetching all working tasks */
			
			/* Fetching all Posted tasks */
				$this->Task->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("full_name","id","logo","tokenId")))));
				$this->Task->recursive = 2;
				
				$taskPosted = $this->Task->find("all",array("conditions"=>array("Task.transaction_id <>"=>"","Task.status"=>"3","Task.user_id"=>$this->Session->read("user_id")),"order"=>"Task.id Desc"));
				
				$i =0;
				foreach( $taskPosted as $runing ){
					$taskPosted[$i]["Assigned"] = $this->Member->find("first",array("fields"=>array("full_name","id","logo"),"conditions"=>array("Member.id"=>$runing["Task"]["assigned_user_id"]))); 
								
					$taskPosted[$i]["amazonUrl"] = $this->amazon->generateSenderToken(array("url"=>"members/payments","member_id"=>$runing["Task"]["id"],"price"=>$runing["Task"]["price"],"taskName"=>$runing["Task"]["title"],"recipientToken"=>$runing["Member"]["tokenId"]));
					
					$i++;
				}
				$this->set("taskPosted",$taskPosted);
				
				Configure::write("debug",0);
				
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"hirer_id","fields"=>array("full_name","id","logo")))));
				$this->QuickHireSale->bindModel(array("belongsTo"=>array("QuickTask"=>array("foreignKey"=>"task_id"))));
				
				$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("foreignKey"=>"user_id","fields"=>array("full_name","id","logo")))));
				
				$this->QuickHireSale->recursive = 2;
				$taskQuickPosted = $this->QuickHireSale->find("all",array("conditions"=>array("QuickHireSale.hirer_id"=>$this->Session->read("user_id"),"QuickHireSale.status"=>"3","QuickHireSale.transaction_id <>"=>"","QuickHireSale.request_payments"=>"2")));
				
				$i =0;
				foreach($taskQuickPosted as $runing )
				{
					$taskQuickPosted[$i]["amazonUrl"] = $this->amazon->generateSenderToken(array("url"=>"members/payments","member_id"=>"QuickHire-".$runing["QuickHireSale"]["id"],"price"=>$runing["QuickTask"]["price"],"taskName"=>$runing["QuickTask"]["title"],"recipientToken"=>$runing["Member"]["tokenId"]));
					$i++;
				}				
				
				$this->set("taskQuickPosted",$taskQuickPosted);
			/* Fetching all Posted tasks */
		
		}
		
		public function requestPayment() {
			
			$this->layout = "";
			$this->autoRender = false;
			
			if( $this->request->data["Member"]["taskTypes"] == "quickhire" ) {
				$this->requestQuickPayments();
			}else{
				
				$this->request->data["taskId"] = $this->data["Member"]["taskIds"];			
				if($this->data["taskId"])
				{
					Configure::write("debug",0);
					$memberInfo = $this->Member->find("first",array("fields"=>array("phone_number","full_name","id","tokenId"),"conditions"=>array("id"=>$this->Session->read("user_id"))));
					
					if(!empty($memberInfo["Member"]["tokenId"]))
					{
						$this->Member->bindModel(array("hasOne"=>array("Alert"=>array("fields"=>array("Alert.email_task_completion_payment_request","Alert.phone_task_completion_payment_request"),"foreignKey"=>"member_id"))));
						
						$this->Task->bindModel(array("belongsTo"=>array("Member"=>array("fields"=>array("Member.full_name","Member.id","email"),"foreignKey"=>"user_id"))));
						
						$this->Task->recursive = 2;
						$taskInfo = $this->Task->find("first",array("fields"=>array("title","assigned_user_id","user_id"),"conditions"=>array("Task.id"=>$this->data["taskId"])));
										
						$this->Task->updateAll(array("request_payments"=>"1","request_sent"=>"'".date("Y-m-d H:i:s")."'"),array("id"=>$this->data["taskId"]));
						
						if( (array_key_exists("email_task_completion_payment_request",$taskInfo["Member"]["Alert"]))&& ($taskInfo["Member"]["Alert"]["email_task_completion_payment_request"] == "0") ) {
								
							$content = str_replace("SENDER",$memberInfo["Member"]["full_name"],Configure::read('message.task_payment_request'));
							$content = str_replace("TASK",$taskInfo["Task"]["title"],$content);
							$content = "Hi ".$taskInfo["Member"]["full_name"].",<br/><br/>".$content;
						
							$this->sendEmailMessage($taskInfo["Member"]["email"],Configure::read('message.task_payment_request_subject'),$content,null,null);
						}
						
						if( (array_key_exists("phone_task_completion_payment_request",$taskInfo["Member"]["Alert"]))&& ($taskInfo["Member"]["Alert"]["phone_task_completion_payment_request"] == "0") ) {
								
							if(Configure::read("testMode")){
								$email = Configure::read("phoneNumber");
							}else{
								$email = str_replace("-","",$memberInfo["Member"]["phone_number"]);
							}
							$email = $this->createSmsUrl($email);
							$this->sendEmailMessage($email,Configure::read('message.task_payment_request_subject'),$content,null,null);
						}
						$error   = 0;
						$message = "Payment request successfully sent";
					}else{
						$error   = 1;
						$message = "Please provide the amazon account information prior to send request";
					}
					//
					echo json_encode(array("error"=>$error,"message"=>$message));
					exit();
				}
			
			}	
		}
		
		public function requestQuickPayments() {
			
			$this->layout = "";
			$this->autoRender = false;
			
			if($this->data["Member"]["taskIds"])
			{
				$ids = explode("-",$this->data["Member"]["taskIds"]);
				$this->request->data["Member"]["taskId"] = $ids[0];
				$options = $ids[1];
				
				Configure::write("debug",0);
				
				$memberInfo = $this->Member->find("first",array("fields"=>array("phone_number","full_name","id","tokenId"),"conditions"=>array("id"=>$this->Session->read("user_id"))));
				
				$this->Member->bindModel(array("hasOne"=>array("Alert"=>array("fields"=>array("Alert.email_task_completion_payment_request","Alert.phone_task_completion_payment_request"),"foreignKey"=>"member_id"))));
					
				$this->QuickTask->bindModel(array("belongsTo"=>array("Member"=>array("fields"=>array("Member.full_name","Member.id","email"),"foreignKey"=>"user_id"))));
					
				$this->QuickTask->recursive = 2;
							
				$taskInfo = $this->QuickTask->find("first",array("fields"=>array("title","user_id"),"conditions"=>array("QuickTask.id"=>$this->data["taskId"])));
				
				$this->loadModel("QuickHireSale");
				$this->QuickHireSale->create();
				
				$salesInfo = $this->QuickHireSale->find("first",array("fields"=>array("hirer_id","tokenID"),"conditions"=>array("QuickHireSale.id"=>$options)));
				
				if(!empty($salesInfo["QuickHireSale"]["tokenID"]))
				{					
					$this->QuickHireSale->updateAll(array("request_payments"=>"1","request_sent"=>"'".date("Y-m-d H:i:s")."'"),array("id"=>$options));
					
					if( (array_key_exists("email_task_completion_payment_request",$taskInfo["Member"]["Alert"]))&& ($taskInfo["Member"]["Alert"]["email_task_completion_payment_request"] == "0") ) {
							
						$content = str_replace("SENDER",$memberInfo["Member"]["full_name"],Configure::read('message.task_payment_request'));
						$content = str_replace("TASK",$taskInfo["QuickTask"]["title"],$content);
						$content = "Hi ".$taskInfo["Member"]["full_name"].",<br/><br/>".$content;
					
						$this->sendEmailMessage($taskInfo["Member"]["email"],Configure::read('message.task_payment_request_subject'),$content,null,null);
					}
					
					if( (array_key_exists("phone_task_completion_payment_request",$taskInfo["Member"]["Alert"]))&& ($taskInfo["Member"]["Alert"]["phone_task_completion_payment_request"] == "0") ) {
							
						if(Configure::read("testMode")){
							$email = Configure::read("phoneNumber");
						}else{
							$email = str_replace("-","",$memberInfo["Member"]["phone_number"]);
						}
						$email = $this->createSmsUrl($email);
						$this->sendEmailMessage($email,Configure::read('message.task_payment_request_subject'),$content,null,null);
					}
					$error   = 0;
					$message = "Payment request successfully sent";
				}else{
					$error   = 1;
					$message = "Please provide the amazon account information prior to send request";
				}
				//
				echo json_encode(array("error"=>$error,"message"=>$message));
				exit();
			}
		
		}
		
		public function requestRefund(){
			
			Configure::write("debug",0);
			$this->layout = "";
			$this->autoRender = false;
			
			if($this->data){
				$this->Task->updateAll(array("Task.request_payments"=>"3","Task.refund_request_sent"=>"'".date("Y-m-d H:i:s")."'"),array("Task.id"=>$this->data["taskId"]));
				
				$taskInfo = $this->Task->find("list",array("fields"=>array("id","title"),"conditions"=>array("Task.id"=>$this->data["taskId"])));
				
				$content = Configure::read('message.refundNotification');
				$content = str_replace("TASKNAME",$taskInfo[$this->data["taskId"]],$content);
				
				$subject = Configure::read('message.refundNotificationSubject');
				$this->sendEmailMessage(Configure::read('Website.email'),$subject,$content,null,null);				
				echo json_encode(array("error"=>0));
				exit;
			}
			
		}
					
		public function requestQuickRefund(){
			
			Configure::write("debug",0);
			$this->layout = "";
			$this->autoRender = false;
			
			if($this->data){
			
				if( $this->QuickTask->updateAll(array("QuickTask.request_payments"=>"3","QuickTask.refund_request_sent"=>"'".date("Y-m-d H:i:s")."'"),array("QuickTask.id"=>$this->data["taskId"])) ){
					$taskInfo = $this->QuickTask->find("list",array("fields"=>array("id","title"),"conditions"=>array("QuickTask.id"=>$this->data["taskId"])));
				
					$content = Configure::read('message.refundNotification');
					$content = str_replace("TASKNAME",$taskInfo[$this->data["taskId"]],$content);
				
					$subject = Configure::read('message.refundNotificationSubject');
					$this->sendEmailMessage(Configure::read('Website.email'),$subject,$content,null,null);				
					echo json_encode(array("error"=>0));
				}			
				exit;
			}
			
		}
		
		function releaseTaskFund() {
			
			Configure::write("debug",0);
			$this->layout = "";
			$this->autoRender = false;
			
			if($this->data["taskId"]){
			
				$this->Member->bindModel(array("hasMany"=>array("Bid"=>array("foreignKey"=>"member_id"))));
				$this->Task->bindModel(array("hasMany"=>array("Bid"=>array("foreignKey"=>"job_id","conditions"=>array("Bid.fundingTokenID <>"=>"")))));
							
				$this->Task->recursive = 2;
				$taskInfo = $this->Task->find("first",array("fields"=>array("description","title","user_id","price","assigned_user_id"),"conditions"=>array("Task.id"=>$this->data["taskId"])));
				
				$this->amazon = $this->Components->load("Amazon");
				$parameter = array(
									'SenderTokenId' =>$taskInfo["Bid"][0]["fundingTokenID"],
									'PrepaidInstrumentId' =>$taskInfo["Bid"][0]["prepaidInstrumentID"],
									'FundingAmount' => ($taskInfo["Task"]["price"]+$taskInfo["Task"]["price"]*(Configure::read('Website.hirerComissionCharge')/100)),
									'CallerReference'=>rand()."A".$taskInfo["Task"]["id"],
									'SenderDescription'=>$taskInfo["Task"]["title"],
									'CallerDescription'=>substr($taskInfo["Task"]["title"],0,150),
									'DescriptorPolicy'=>substr($taskInfo["Task"]["description"],0,150)
								);
								
				$repsone = $this->amazon->transferFunds($parameter);				
				if(!empty($repsone)){
					$paymentFields = array(
										"request_payments"=>"2",
										"paid_on"=>date("Y-m-d H:i:s"),
										"transaction_id" =>trim($repsone->FundPrepaidResult->TransactionId),
										"payment_status" =>"Completed"
									);
					
						$paymentFields = $this->addQuote($paymentFields);	
						$this->Task->updateAll($paymentFields,array("Task.id"=>$taskInfo["Task"]["id"]));
						
						/* Updating clients for the payments*/
							$memberInfo = $this->Member->find("all",array("fields"=>array("Member.id","Member.full_name","Member.email"),"conditions"=>array("Member.id"=>array($taskInfo["Task"]["user_id"],$taskInfo["Task"]["assigned_user_id"]))));
			
							if(!empty($memberInfo)){
								foreach( $memberInfo as $member ) {
									
									if( $taskInfo["Task"]["user_id"] == $member["Member"]["id"] ) {							
										$hirer = array("name"=>$member["Member"]["full_name"],"email"=>$member["Member"]["email"],"id"=>$member["Member"]["id"]);
									}else{
										$helpler = array("name"=>$member["Member"]["full_name"],"email"=>$member["Member"]["email"],"id"=>$member["Member"]["id"]);						
									}
								}
								
								$contentHelpler = Configure::read('message.payFundHelplerNotification');
								$contentHelpler = str_replace("USER",$helpler["name"],$contentHelpler);
								if( $this->data["isAdmin"] == 1 )
									$contentHelpler = str_replace("HIRER","<b>Admin</b>",$contentHelpler);
								else
									$contentHelpler = str_replace("HIRER","<b>".$hirer["name"]."</b>",$contentHelpler);
									
									
								$contentHelpler = str_replace("TASK","<b>".$taskInfo["Task"]["title"]."</b>",$contentHelpler);
								$contentHelpler = str_replace("AMOUNT","<b>".$taskInfo["Task"]["price"]."</b>",$contentHelpler);
							
								$contentHirer = Configure::read('message.payFundHirerNotification');
								$contentHirer = str_replace("USER",$hirer["name"],$contentHirer);
								$contentHirer = str_replace("TASK","<b>".$taskInfo["Task"]["title"]."</b>",$contentHirer);
								$contentHirer = str_replace("AMOUNT","<b>".$taskInfo["Task"]["price"]."</b>",$contentHirer);
								
								if( $this->data["isAdmin"] == 1 )
									$contentHirer = str_replace("You","The Admin",$contentHirer);
							}
							
							$this->sendEmailMessage($helpler["email"],Configure::read('message.payFundHelplerSubject'), $contentHelpler,null,null);
							
							$this->sendEmailMessage($hirer["email"],Configure::read('message.payFundHelplerSubject'), $contentHirer,null,null);
								
						/* Updating clients for the payments*/
							$error   = 1;
							$message = "Funds Sucessfully transfered to the amazon account";	
					 
				}else{
					$error   = 0;
					$message = "Unable to transfer the amount.Please contact site Admin2";
				}
				
				echo json_encode(array("error"=>$error,"message"=>$message));
			}
			exit;			
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
		
		
		function parse_response(){
			
			Configure::write("debug",2);
			$this->amazon = $this->Components->load("Amazon");			
			$price = 10;
			
			if(!empty($this->params->query["fundingTokenID"])) {
				
				$parameter = array(
									'SenderTokenId' =>$this->params->query["fundingTokenID"],
									'PrepaidInstrumentId' =>$this->params->query["prepaidInstrumentID"],
									'FundingAmount' => ($price+$price*(Configure::read('Website.hirerComissionCharge')/100)),
									'CallerReference'=>time().rand(0,1000)."1A",
									'SenderDescription'=>"TEST ".time().rand(0,1000)."2A",
									'CallerDescription'=>"TEST ".time().rand(0,1000)."3A",
									'DescriptorPolicy'=>"TEST ".time().rand(0,1000)."4A"
								);
				$repsone = $this->amazon->transferFunds($parameter);
				echo"<pre>";print_r($repsone->FundPrepaidResult->TransactionId);
				echo"<pre>";print_r($repsone->FundPrepaidResult->TransactionStatus);
				die();
				
			}else{
				$link = $this->amazon->reserveFunds(array("url"=>"members/parse_response/taskid:".rand(0,100)."/memberId:".rand(0,1000),"member_id"=>rand(0,100)."-".rand(0,1000),"amount"=>($price+((Configure::read('Website.hirerComissionCharge')/100)*$price)),"taskName"=>"TEST ".rand(0,100000),"recipientToken"=>"TEST ".rand(0,100000)));
			
				echo "<a href='".$link."'>TEST</a>";
				die();
			}			
		
		}
		function register(){
			$mailfetchtype = 'Registration Mail';
			$condition= array('mails_type'=>$mailfetchtype,'status'=>'1');	
			$mailcontentfetch = $this->Managemail->find('first',array('conditions'=>$condition));
			$this->set("mailcontentfetch",$mailcontentfetch);
			$this->layout='register';
			
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
			//pr($this->request->data);
			//die;
			$this->Trainer->set($this->data);
			if($this->Trainer->validates()) {
			if(!empty($this->data)) {
				
				$eml=$this->data["Trainer"]["email"];
				$emexplode=explode("@",$eml);
				//$username=$emexplode[0];
				$username=$eml;
				$this->request->data["Trainer"]["username"] =$eml;
				if(!empty($this->data["Trainer"]["password"]) && ($this->data["Trainer"]["password"]==$this->data["Trainer"]["con_password"]))
					    {
					   
		
				//$this->Club->set($this->data);
				//if($this->Club->validates()) {
						if( !empty($this->data["Trainer"]["logo"]) ) {
							
							$filename = $this->data["Trainer"]["logo"]["name"];
							$target = $this->config["upload_path"];
							$this->Upload->upload($this->data["Trainer"]["logo"], $target, null, null);
  					        $this->request->data["Trainer"]["logo"] = $this->Upload->result; 					
						}else{	
							
							unset($this->request->data["Trainer"]["logo"]);
							$this->request->data["Trainer"]["logo"] = '';							
					    }
					    
					    
					    $this->request->data["Trainer"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["Trainer"]["modified_date"] 		    = date("Y-m-d h:i:s");
					    	$this->request->data["Trainer"]["status"]=1;
							$this->request->data["Trainer"]["notification_status"]=1;
						if($this->Trainer->save($this->data)) {
							
							
							$this->send_welcome_email($this->request->data["Trainer"]["email"],$this->request->data["Trainer"]["first_name"],$this->request->data["Trainer"]["password"],$this->request->data["Trainer"]["last_name"],$this->request->data["Trainer"]["username"],$mailcontentfetch['Managemail']['content'],$mailcontentfetch['Managemail']['subject']);
							$this->send_welcome_email_admin($this->request->data["Trainer"]["email"],$this->request->data["Trainer"]["first_name"],$this->request->data["Trainer"]["password"],$this->request->data["Trainer"]["last_name"],$this->request->data["Trainer"]["username"],$mailcontentfetch['Managemail']['content'],$mailcontentfetch['Managemail']['subject']);							
							$this->Session->setFlash('Your account has been created successfully.We have sent welcome mail in your registered email address.');
							$dbusertype='Trainer';
							$data_array=array();
							$data_array[$dbusertype]['username']=$username;
							$data_array[$dbusertype]['id']=$this->Trainer->getLastInsertId();
							$data_array[$dbusertype]['first_name']=$this->request->data["Trainer"]["first_name"];
							
							$this->Session->write('USER_ID', $data_array[$dbusertype]['id']);
					$this->Session->write('USER_NAME', $data_array[$dbusertype]['username']);
					$this->Session->write('UNAME', $data_array[$dbusertype]['first_name']);
					$this->Session->write('UTYPE', $dbusertype);
							$this->redirect('/home/index');
							
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
				</td></tr><tr><td><br/>'.$mail_con.' <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(WEBSITE_FROM_EMAIL => WEBSITENAME));
		$email->to($emailaddress);
		//$email->cc('rprasad@sampatti.com');
		$subtxt = __($mail_sub);
		$email->subject($mail_sub);
		$email->subject($subtxt);
		
		try {
		    if ( $email->send($content) ) {
		        // Success
		    } else {
		        $this->Session->setFlash('Some error has been occured. Please try again with different email.');
		        $this->redirect('/home/index');
		    }
		} catch ( Exception $e ) {
		    // Failure, with exception
		}
	}
	
	function send_welcome_email_admin($emailaddress,$name,$pass,$lname,$username,$mail_con,$mail_sub) {
		App::uses('CakeEmail', 'Network/Email');		
		$email = new CakeEmail();		
		$email->emailFormat('html');
	
	$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Dear Admin!</p>
				<p>A New Trainer has been registerd on '.$this->config["base_title"].' site. </p>	
				<p>Please find below the login credentials</p>				
				<p>Email is'.' '.$username.'</p>
				<p>Password is'.' '.$pass.'</p>
				</td></tr><tr><td><br/>'.$mail_con.' <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(WEBSITE_FROM_EMAIL => WEBSITENAME));
		$email->to($this->config['email_admin_registration']);
		//$email->cc('rprasad@sampatti.com');
		$subtxt = __('New Trainer Registration');
		$email->subject($subtxt);	
		$email->send($content);	
		
		try {
		    if ( $email->send($content) ) {
		        // Success
		    } else {
		        $this->Session->setFlash('Some error has been occured. Please try again with different email.');
		        $this->redirect('/home/index');
		    }
		} catch ( Exception $e ) {
		    // Failure, with exception
		}
	}
	
	
	
	function EmailExistCheck(){
			$this->autoRender = false;
			$response=array();
			if (!empty($this->request->data['email'])) {
			if ($this->request->data['email']== '') {
				//$this->set('value', 0);
				$response['success']=2;
			} else {
				$u = $this->Trainer->findByEmail($this->request->data['email']);
				if (empty($u)) {
					$this->set('value', 0);
					$response['success']=0;
				} else {
					//$this->set('value', 0);
					$response['success']=1;
				}
			}
			} else {
			$response['success']=2;
			}
		echo json_encode($response);
		exit;
	}
	
	public function admin_download()
		{
			$this->set('trainers', $this->Trainer->find('all',array('fields'=>array('Trainer.trainer_type','Trainer.username','Trainer.first_name','Trainer.last_name','Trainer.email','Trainer.address','Trainer.city','Trainer.state','Trainer.country','Trainer.status','Trainer.session_price','Trainer.phone','Trainer.mobile','Trainer.date_enrolled'))));
			$this->layout = null;
			$this->autoLayout = false;
			Configure::write('debug', '0');
		}
		
	}