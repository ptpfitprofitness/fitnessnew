<?php

##******************************************************************

##  Project		:		Fitness

##  Done by		:		921

##	Create Date	:		06/03/2014

##  Description :		This file contains function related to the Home page

## *****************************************************************

App::uses('CakeTime', 'Utility');

App::uses('AppController', 'Controller');

//App::import('Vendor','html2pdf');

/**

 * Static content controller

 *

 * Override this controller by placing a copy in controllers directory of an application

 *

 * @package       app.Controller

 * @link http://book.cakephp.org/2.0/en/controllers/specialists-controller.html

 */



	class HomeController extends AppController { 



		public $name 		= 'Home';
		

		public $helpers 	= array('Html','Session','Cksource','GoogleChart');

		public $uses 		= array('Country','Member','ClubBranch','Club','ClubContact','Trainer','Corporation','Trainee','CertificationOrganization','Certification','Degree','Page','TraineeTrainer','ScheduleCalendar','SevensiteBodyfat','ThreesiteBodyfat','BodymassIndex','EstimatedenergyRequirement','FoodNutritionLog','AdddailyNutritionDiary','CertificationTrainers','ExerciseHistorys','Goal','WarmUps','CoreBalancePlyometric','SpeedAgilityQuickness','Resistence','CoolDown','WorkOuts','FoodUsda','ExerciseLibrary','Emessage','Event','Subscription','Form','Gallery','Doc','Payment','MessageBoard','TempWorkout','WorkoutCategory','Measurement','TraineesessionPurchase','SessionPurchase','HelpGuide','ScdetailPopup','Managemail','Group','GroupMember','GroupClientStat','Coupon');

		public $components  = array('Upload','Autharb','Paginator');				

		
		

	

		public function index(){		

		//$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'homeindex');
		
		
		
		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	    $this->set("degrees",$this->Degree->find('all',array('conditions'=>array('Degree.status'=>1),'fields'=>array('Degree.id','Degree.name'))));	

	    $this->set("certificationsorg",$this->CertificationOrganization->find('all',array('conditions'=>array('CertificationOrganization.status'=>1),'fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));	

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
			
			
			
		
			
			
			
			
			$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
			
			$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
			
			/*echo "<pre>";
			print_r($setSpecalistArr1);
			echo "</pre>";
			
			echo "<pre>";
			print_r($setSpecalistArr);
			echo "</pre>";
			die();*/

		  $this->set("setSpecalistArr",$setSpecalistArr);
		  $this->set("setSpecalistArr1",$setSpecalistArr1);

		  

			
		$this->set("events",$this->Event->find('all',array('conditions'=>array('Event.trainer_id'=>$uid))));	       
		
		$tranrsdata=$this->CertificationTrainers->find('all',array('conditions'=>array('CertificationTrainers.trainer_id'=>$uid),'order'=>array('CertificationTrainers.certification_org ASC')));

			

		$this->set("certificationstr",$tranrsdata);
			
			
			


			$checksubsplan=$this->Subscription->find("all",array("conditions"=>array("Subscription.status"=>1,"Subscription.plan_cost <>"=>0,'or' => array(
			array("Subscription.plan_for" => 'Trainer'),array("Subscription.plan_for" => 'All')))));		
			$this->set("checksubsplan",$checksubsplan);

		}

		

		public function addevent(){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'homeindex');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		

	

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);
		
		$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

		  

		  if(!empty($this->data)) {

			

				$this->Event->set($this->data);

				//$this->Trainer->id = $this->data['Trainer']['id'];	

				if($this->Event->validates()) {

						

					    

					    //$this->request->data["Event"]["added_date"] 		    = date("Y-m-d H:i:s");

						

					    	//pr($this->request->data);

					    //$this->loadModel('ClubBranch');

					    

					   /* echo '<pre>';

					    print_r($this->request->data["Event"]);

					    echo '</pre>';

					    die();*/

					   

						if($this->Event->save($this->data["Event"])) {	

										

							$this->Session->setFlash('Event has been added successfully.');

							$this->redirect('/home/index/');

						} else {

							$this->Session->setFlash('Some error has been occured. Please try again.');

						}

				}	

			}

		

		

		}

		

		public function getsestime()

		{

			$this->layout = "";	

			$this->autoRender=false;

			$wrkt=trim($_POST['workout']);
			

			$response = array();

			if($wrkt!=''){

			 $setWrktArr=$this->WorkOuts->find("first",array("conditions"=>array("WorkOuts.id"=>$wrkt)));

			//echo "<pre>"; print_r($setWrktArr); echo "</pre>"; die;

			 if(!empty($setWrktArr))

			 {

			$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Session has been booked successfully.","workout"=>$setWrktArr['WorkOuts']['workout_time'],"sessiontype"=>$setWrktArr['WorkOuts']['workout_name']);

			

			 } else {

			 	

			 	$response = array("responseclassName"=>"nFailure","errorMsg"=>"Please select valid data!!");

			 }

			

			}

			else {

			$response = array("responseclassName"=>"nFailure","errorMsg"=>"Please select valid data!!");

			}



echo json_encode($response);

				exit;



			

		}

		

		

		public function scheduling_calendar($dta=null){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');
		

		$this->set("leftcheck",'homescheduling_calendar');
		
		$this->set("setdtsval",$dta);

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

		

		$this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$uid,'Trainee.status'=>1,'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.last_name ASC'),'fields'=>array('Trainee.id','Trainee.full_name'))));
		
		$this->set("groupdata",$this->Group->find('list',array('conditions'=>array('Group.trainer_id'=>$uid,'Group.status'=>1),'order'=>array('Group.group_name ASC'),'fields'=>array('Group.id','Group.group_name'))));

		echo $groupdata['Group']['id'];
				
		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));

		
		
		
		

		//ScheduleCalendar

		$sccondition=array();

		$clid='';

		

		if(isset($dbusertype) && $dbusertype=='Trainee')

		{

			$sccondition=array('ScheduleCalendar.trainee_id'=>$uid,'ScheduleCalendar.status'=>1);

			

			

		}

		if(isset($dbusertype) && $dbusertype=='Trainer')

		{

			

			if(isset($this->data['Trainee']['id']) && trim($this->data['Trainee']['id'])!=''){

			 $clientemail=$this->data['Trainee']['id'];

		    $setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientemail)));

		    	  

		    $clid=$setClientArr['Trainee']['id'];

		    

		    $this->set("clid",$clid);

		    

		    

		   

		    if(isset($this->request->data['ScheduleCalendar']['timeslot']) && trim($this->request->data['ScheduleCalendar']['timeslot'])!=''){

		    	$setslot=$this->request->data['ScheduleCalendar']['timeslot'];

		    	$this->set("setslot",$setslot);

		    }

		    if(isset($this->data['ScheduleCalendar']['appointment_type']) && trim($this->data['ScheduleCalendar']['appointment_type'])!=''){

		    	$avty=trim($this->data['ScheduleCalendar']['appointment_type']);

		    	

		    $sccondition=array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clid,'ScheduleCalendar.appointment_type'=>$avty);

		    

		    /*echo "<pre>";

		    print_r($sccondition);

		    echo "</pre>";

		    die();*/

		    

			}

			else 

			{

				$sccondition=array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clid);

			}

		  }

		  else 

		  {

		  	

		  	$sccondition=array('ScheduleCalendar.trainer_id'=>$uid);

		  }

		}

		$sccondition['ScheduleCalendar.status'] = 1;

		$this->set("scheduleCalendars",$this->ScheduleCalendar->find('all',array('conditions'=>$sccondition,'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.appointment_type','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.mapwrkt'))));	

			

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	    $this->set("degrees",$this->Degree->find('all',array('conditions'=>array('Degree.status'=>1),'fields'=>array('Degree.id','Degree.name'))));	

	    $this->set("certificationsorg",$this->CertificationOrganization->find('all',array('conditions'=>array('CertificationOrganization.status'=>1),'fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));	

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		  $this->set("setSpecalistArr",$setSpecalistArr);
		  $club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

		 

		 $this->set("bclid",$clid);

		

		}

		

		public function setslot()
		{	
			$this->layout = "";

			$this->autoRender=false;

			if(trim( $_POST['slot'])!='')
			{	
				$dvstart=$_POST['slot'];

				$dvend=$_POST['endslot'];

				$clientid=$_POST['clientid'];
				
				//$trainerid=$_POST['trainerid'];
				
				$sessiontypeid=$_POST['sessiontypeid'];

				$apty='Booked';
				
				$SessionTypeVal = $_POST['SessionTypeVal'];

				//$apty=$_POST['apty'];

			    $uid = $this->Session->read('USER_ID');		
			    
				$trainerid=$uid;
			    
				$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));
			    
				$sessionPurchase=$this->SessionPurchase->find('first',array("conditions"=>array('SessionPurchase.client_id'=>$clientid,'SessionPurchase.trainer_id'=>$trainerid,'SessionPurchase.session_id'=>$sessiontypeid)));
			   
				//echo "<pre>";print_r($sessionPurchase);echo "</pre>";die;
			   
		        $aptitle=$setClientArr['Trainee']['full_name'];

				//$purchSession = $setClientArr['Trainee']['no_ses_purchased'];

				$purchSession = $sessionPurchase['SessionPurchase']['no_of_purchase'];
		         
				//$bokedSession = $setClientArr['Trainee']['booked_ses'];
		        
				$bokedSession = $sessionPurchase['SessionPurchase']['no_of_booked'];

				$leftSession = $purchSession - $bokedSession;
		         
				$CheckDataExist=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.start"=>$dvstart,"ScheduleCalendar.end"=>$dvend,"ScheduleCalendar.trainer_id"=>$uid,"ScheduleCalendar.trainee_id"=>$clientid,"ScheduleCalendar.status"=>1)));
		       
				if(!empty($CheckDataExist))
		        {
		         	$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry this time slot already booked.");
		         	
					echo json_encode($response);
					
					exit;
		        }
		        
				if($leftSession > 0)
				{
					$data=array();

					$this->request->data['ScheduleCalendar']['appointment_type']=$apty;

					$this->request->data['ScheduleCalendar']['title']=$aptitle;

					$this->request->data['ScheduleCalendar']['description']='Session  - '. $setClientArr['Trainee']['full_name'];

					$this->request->data['ScheduleCalendar']['trainer_id']=$uid;
					
					$this->request->data['ScheduleCalendar']['session_typeid']=$sessiontypeid;

					$this->request->data['ScheduleCalendar']['trainee_id']=$clientid;

					$this->request->data['ScheduleCalendar']['start']=$dvstart;

					$this->request->data['ScheduleCalendar']['end']=$dvend;

					$this->request->data['ScheduleCalendar']['added_date']=date('Y-m-d h:i:s');

					$this->request->data['ScheduleCalendar']['modification_date']=date('Y-m-d h:i:s');

					$this->request->data['ScheduleCalendar']['status']='1';
					
					$this->request->data['ScheduleCalendar']['session_type']= $SessionTypeVal;
					
					if($this->ScheduleCalendar->save($this->data['ScheduleCalendar'])) 
					{
						$setTrainerArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$uid)));

						$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));
						
						$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
						
						if($setTrainerArr)
						{
							$content.='<img width="75" height="76" src="'.$this->config['url'].'uploads/'.$setTrainerArr['Trainer']['logo'].'"/>';
						}
						else
						{
							$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
						}

						$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$aptitle.'!</p>

						<p>Trainer has '.$apty.' session with you : '.$this->config["base_title"].' site. </p>

						<p>Please find below Your Session Time.</p>

						<p>Start Time:'.trim($dvstart).'<br/>

						End Time:'.trim($dvend).'<br/>

						Trainer Name:'.trim($setTrainerArr['Trainer']['full_name']).'<br/>

						<br/>

						</p>

						</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

						$subject = $this->config["base_title"]." : Trainer ".$apty." Session Successfully"; 
						//$this->sendEmailMessage(trim($setClientArr['Trainee']['email']),$subject,$content,null,null);	

						//$scheduleCalendars='';

						$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.status'=>1),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status','ScheduleCalendar.mapwrkt')));
					
						$data=array();			
						
						if(!empty($scheduleCalendars))
						{
							foreach ($scheduleCalendars as $key=>$val)
							{
								$clsname='red';
								if($val['ScheduleCalendar']['appointment_type']!='')
								{
									if($val['ScheduleCalendar']['appointment_type']=='Booked' && $val['ScheduleCalendar']['mapwrkt']==1)
									{
										$clsname='green';
									}
									if($val['ScheduleCalendar']['appointment_type']=='Booked' && $val['ScheduleCalendar']['mapwrkt']==0)
									{
										$clsname='red';
									}
									if($val['ScheduleCalendar']['appointment_type']=='Completed')
									{
										//$clsname='blue';
										$clsname='gray';
									}
									if($val['ScheduleCalendar']['appointment_type']=='Cancel')
									{
										//$clsname='red';
										$clsname='gray';
									}
									if($val['ScheduleCalendar']['appointment_type']=='Comp')
									{
										//$clsname='orange';
										$clsname='gray';
									}
									if($val['ScheduleCalendar']['appointment_type']=='Cancel NC')
									{
										//$clsname='red';
										$clsname='gray';
									}		
									if($val['ScheduleCalendar']['appointment_type']=='Cancel Charge')
									{
										//$clsname='red';
										$clsname='gray';
									}
								}
								$data[] = array(
								
								'id'=>$val['ScheduleCalendar']['id'],
	
								'title'=>$val['ScheduleCalendar']['title'],

								'start'=>$val['ScheduleCalendar']['start'],

								'end'=>$val['ScheduleCalendar']['end'],

								'className'=>$clsname			
								);
							}
						}					

						$bokedSessionn = $bokedSession + 1; 

	     				//$this->Trainee->query("update trainees set booked_ses = '".$bokedSessionn."' where id='".$clientid."'");

		     			$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Session has been booked successfully.","caldata"=>$data);

						$this->set('scheduleCalendars',$data);
					}
					else 
					{
						$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");
					}
				}
				else 
				{
					$this->set("response","Please purchase the session!!");

					$response = array("responseclassName"=>"nFailure","errorMsg"=>"Please purchase the session data!!");
				}
			}
			else 
			{
				$this->set("response","Please fill valid data!!");

				$response = array("responseclassName"=>"nFailure","errorMsg"=>"Please select valid data!!");
			}
			echo json_encode($response);

			exit;
		}
		
		
		
		/*DRAGABBLE SLOT CODE START */
			
		public function dragsession()
		{	
			$this->layout = "";

			$this->autoRender=false;
			
			$evid = $_POST['evid'];
			$newsdate = $_POST['newstartdate'];
			$newedate = $_POST['newenddate'];
			
			
			if(trim( $_POST['evid'])!='')
			{	
				$scheduleCalendars=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$evid),'fields'=>array('ScheduleCalendar.mapwrkt','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.posted_by')));
				
				$ismapwrkt=$scheduleCalendars['ScheduleCalendar']['mapwrkt'];
				$traineeid=$scheduleCalendars['ScheduleCalendar']['trainee_id'];
				$trainerid=$scheduleCalendars['ScheduleCalendar']['trainer_id'];
				$ori_start=$scheduleCalendars['ScheduleCalendar']['start'];
				$ori_end=$scheduleCalendars['ScheduleCalendar']['end'];
				$posted= $scheduleCalendars['ScheduleCalendar']['posted_by'];
				
				
				if(trim($_POST['newstartdate'])!='' && $ismapwrkt==1 && $posted!='Group')
		        {
				
					$this->ScheduleCalendar->query("update schedule_calendar set start = '".$newsdate."',end = '".$newedate."',modification_date = '".date('Y-m-d h:i:s')."' where id='".$evid."'");	
					
					$this->Goal->query("update goal set start = '".$newsdate."',end = '".$newedate."',modified_date = '".date('Y-m-d h:i:s')."' where trainer_id='".$trainerid."' AND trainee_id='".$traineeid."' AND start='".$ori_start."' AND end='".$ori_end."'");
					
					$this->WarmUps->query("update warm_ups set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND trainee_id='".$traineeid."' AND start='".$ori_start."' AND end='".$ori_end."'");
					
					$this->CoreBalancePlyometric->query("update corebalance_plyometric set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND trainee_id='".$traineeid."' AND start='".$ori_start."' AND end='".$ori_end."'");
					
					$this->SpeedAgilityQuickness->query("update speedagility_quickness set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND trainee_id='".$traineeid."' AND start='".$ori_start."' AND end='".$ori_end."'");
					
					$this->Resistence->query("update resistences set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND trainee_id='".$traineeid."' AND start='".$ori_start."' AND end='".$ori_end."'");
					
					$this->CoolDown->query("update cool_down set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND trainee_id='".$traineeid."' AND start='".$ori_start."' AND end='".$ori_end."'");
					
					
					
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Session has been booked successfully.");		
				}
				else if(trim($_POST['newstartdate'])!='' && $ismapwrkt==1 && $posted=='Group')
		        {					
					$groupmemData=$this->GroupMember->find('all',array("conditions"=>array('GroupMember.group_id'=>$traineeid)));
				
					$this->set("groupmemData",$groupmemData);
					
					//echo "<pre>"; print_r($groupmemData); echo "</pre>";
					
					foreach($groupmemData as $gmdata)
					{
						$this->Goal->query("update goal set start = '".$newsdate."',end = '".$newedate."',modified_date = '".date('Y-m-d h:i:s')."' where trainer_id='".$trainerid."' AND trainee_id='".$gmdata['GroupMember']['client_id']."' AND start='".$ori_start."' AND end='".$ori_end."'");
					
						$this->WarmUps->query("update warm_ups set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND trainee_id='".$gmdata['GroupMember']['client_id']."' AND start='".$ori_start."' AND end='".$ori_end."'");
						
						$this->CoreBalancePlyometric->query("update corebalance_plyometric set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND trainee_id='".$gmdata['GroupMember']['client_id']."' AND start='".$ori_start."' AND end='".$ori_end."'");
						
						$this->SpeedAgilityQuickness->query("update speedagility_quickness set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND trainee_id='".$gmdata['GroupMember']['client_id']."' AND start='".$ori_start."' AND end='".$ori_end."'");
						
						$this->Resistence->query("update resistences set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND trainee_id='".$gmdata['GroupMember']['client_id']."' AND start='".$ori_start."' AND end='".$ori_end."'");
						
						$this->CoolDown->query("update cool_down set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND trainee_id='".$gmdata['GroupMember']['client_id']."' AND start='".$ori_start."' AND end='".$ori_end."'");
						
						$this->GroupClientStat->query("update group_client_stats set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND client_id='".$gmdata['GroupMember']['client_id']."' AND start='".$ori_start."' AND end='".$ori_end."'");
					}
						
					$this->ScheduleCalendar->query("update schedule_calendar set start = '".$newsdate."',end = '".$newedate."',modification_date = '".date('Y-m-d h:i:s')."' where id='".$evid."'");	
					
					$this->Goal->query("update goal set start = '".$newsdate."',end = '".$newedate."',modified_date = '".date('Y-m-d h:i:s')."' where trainer_id='".$trainerid."' AND groupid='".$traineeid."' AND start='".$ori_start."' AND end='".$ori_end."'");
					
					$this->WarmUps->query("update warm_ups set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND groupid='".$traineeid."' AND start='".$ori_start."' AND end='".$ori_end."'");
					
					$this->CoreBalancePlyometric->query("update corebalance_plyometric set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND groupid='".$traineeid."' AND start='".$ori_start."' AND end='".$ori_end."'");
					
					$this->SpeedAgilityQuickness->query("update speedagility_quickness set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND groupid='".$traineeid."' AND start='".$ori_start."' AND end='".$ori_end."'");
					
					$this->Resistence->query("update resistences set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND groupid='".$traineeid."' AND start='".$ori_start."' AND end='".$ori_end."'");
					
					$this->CoolDown->query("update cool_down set start = '".$newsdate."',end = '".$newedate."' where trainer_id='".$trainerid."' AND groupid='".$traineeid."' AND start='".$ori_start."' AND end='".$ori_end."'");
					
					
					
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Session has been booked successfully.");		
				}
				else
				{				
					$this->ScheduleCalendar->query("update schedule_calendar set start = '".$newsdate."',end = '".$newedate."',modification_date = '".date('Y-m-d h:i:s')."' where id='".$evid."'");
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Session has been booked successfully.");
				}
			}
			else 
			{
				$this->set("response","Please fill valid data!!");
				$response = array("responseclassName"=>"nFailure","errorMsg"=>"Please select valid data!!");
			}
			echo json_encode($response);
			exit;
		}
		/*DRAGABBLE SLOT CODE END */
		
		
		
		
		
		
		
		
		
	public function getsetslot()
	{	
		$this->layout = "";
		$this->autoRender=false;		  
		if(trim( $_POST['slot'])!='')
		{				
			$uid = $this->Session->read('USER_ID');							         
			$data=array();
							

							//$scheduleCalendars='';

			$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.status'=>1),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status','ScheduleCalendar.mapwrkt')));

			$data=array();			
			if(!empty($scheduleCalendars))
	     	{				
	     		foreach ($scheduleCalendars as $key=>$val)
				{

					$clsname='red';
					if($val['ScheduleCalendar']['appointment_type']!='')
					{
						if($val['ScheduleCalendar']['appointment_type']=='Booked' && $val['ScheduleCalendar']['mapwrkt']==1)
						{
							$clsname='green';
						}

						if($val['ScheduleCalendar']['appointment_type']=='Booked' && $val['ScheduleCalendar']['mapwrkt']==0)
						{
							$clsname='red';
						}

						if($val['ScheduleCalendar']['appointment_type']=='Completed')
						{
							$clsname='gray';
						}

						if($val['ScheduleCalendar']['appointment_type']=='Cancel')
						{
							$clsname='gray';
						}
						if($val['ScheduleCalendar']['appointment_type']=='Comp')
						{
							$clsname='gray';
						}
					}				

					$data[] = array(
					'id'=>$val['ScheduleCalendar']['id'],
					'title'=>$val['ScheduleCalendar']['title'],
					'start'=>$val['ScheduleCalendar']['start'],
					'end'=>$val['ScheduleCalendar']['end'],
					'className'=>$clsname
					);
				}
		     	}
		     				

		     		$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Session has been booked successfully.","caldata"=>$data);

					$this->set('scheduleCalendars',$data);
			}
			else 
			{
				$this->set("response","Please fill valid data!!");
				$response = array("responseclassName"=>"nFailure","errorMsg"=>"Please select valid data!!");
			}		

			echo json_encode($response);
			exit;
		}

		

		/* Print Scheduled Start */

		public function printscheduled_old($dt=null)

		{

			$this->checkUserLogin();

		    $this->layout = "printlayout";		

			/*echo $dt;

			die();*/

			$dbusertype = $this->Session->read('UTYPE');

			$this->set("dbusertype",$dbusertype);

			

		    $uid = $this->Session->read('USER_ID');

		    $setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
		    $this->set("setSpecalistArr",$setSpecalistArr);

	

			if($dt!=''){

		    	

		$startdt=$dt.' 00:00:00';    	

		$enddt=$dt.' 23:59:00';    	

		

		    

		    if($dbusertype=='Trainer')

		    {

		    	   $sccondition=array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.start >='=>$startdt,'ScheduleCalendar.start <='=>$enddt);

		    	   

		    	   $this->ScheduleCalendar->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id"))));

		    	   $this->ScheduleCalendar->bindModel(array("belongsTo"=>array("Trainee"=>array("foreignKey"=>"trainee_id"))));

		    	   

		

		        $this->ScheduleCalendar->recursive = 2;

		    	   

		    	$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>$sccondition,'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.appointment_type','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end')));	

		    	$this->set("calendarData",$scheduleCalendars);

		    	

		    	$setGoalArrs3=array();

		    	$setQuicknessArr3=array();

		    	$setWarmupArr2=array();

		    	$setCoreBalancePlyometricArr=array();

		    	$setResistenceArr2=array();

		    	$setCoolDownArr2=array();

		    	foreach ($scheduleCalendars as $scalender){

		    		 $startDay=$scalender['ScheduleCalendar']['start'];

		    		$endDay=$scalender['ScheduleCalendar']['end'];

		    		

		    		

		    		

		    		$setQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.start"=>$startDay,"SpeedAgilityQuickness.end"=>$endDay),'order'=>array('SpeedAgilityQuickness.id ASC')));

		    		$setQuicknessArr3[]=$setQuicknessArr;

		    		

		    		$setGoalArrs=$this->Goal->find("first",array("conditions"=>array("Goal.start"=>$startDay,"Goal.end"=>$endDay),"Order"=>array("Goal.id"=>"DESC")));

		    		//print_r($setGoalArrs);

		    		$setGoalArrs3[]=$setGoalArrs;

		    	

			

			

				

			$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.start"=>$startDay,"WarmUps.end"=>$endDay),'order'=>array('WarmUps.id ASC')));

			

			$setWarmupArr2[]=$setWarmupArr;

			

			

			$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.start"=>$startDay,"CoreBalancePlyometric.end"=>$endDay),'order'=>array('CoreBalancePlyometric.id ASC')));

			

			$setCoreBalancePlyometricArr2[]=$setCoreBalancePlyometricArr;

			

			$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.start"=>$startDay,"Resistence.end"=>$endDay),'order'=>array('Resistence.id ASC')));

				//$this->set('setResistenceArr',$setResistenceArr);

						$setResistenceArr2[]=$setResistenceArr;

			

			 $setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.start"=>$startDay,"CoolDown.end"=>$endDay),'order'=>array('CoolDown.id ASC')));

			 	//$this->set('setCoolDownArr',$setCoolDownArr);

			 	$setCoolDownArr2[]=$setCoolDownArr;

		    	}

		    	

		    	

		    	$this->set("setGoalArrs",$setGoalArrs3);	

		    	$this->set("setQuicknessArr3",$setQuicknessArr3);	

		    	$this->set("setWarmupArr2",$setWarmupArr2);	

		    	$this->set("setCoreBalancePlyometricArr2",$setCoreBalancePlyometricArr2);	

		    	$this->set("setResistenceArr2",$setResistenceArr2);	

		    	$this->set("setCoolDownArr2",$setCoolDownArr2);	

		    }

		    else {

		    	if($dbusertype=='Trainee')

		        {

		    	  $sccondition=array('ScheduleCalendar.trainee_id'=>$uid,'ScheduleCalendar.start >='=>$startdt,'ScheduleCalendar.start <='=>$enddt);

		    	  

		    	  $this->ScheduleCalendar->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id"))));

		    	   $this->ScheduleCalendar->bindModel(array("belongsTo"=>array("Trainee"=>array("foreignKey"=>"trainee_id"))));

		

		        $this->ScheduleCalendar->recursive = 2;

		    	  

		    	$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>$sccondition,'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.appointment_type','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end')));	

		    	$this->set("calendarData",$scheduleCalendars);

		    	

		        }

		    }

			}

		//print_r($calendarData);

			//die();

			

		}

		/* Print Scheduled End */

			

			

				

		

		public function evdetail()

		{
			$this->layout = "ajax";

			$dbusertype = $this->Session->read('UTYPE');					
			
			$this->set("dbusertype",$dbusertype);

			$uid = $this->Session->read('USER_ID');	
			
			$postedby = $_POST['postedby'];
			
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

			$this->set("setSpecalistArr",$setSpecalistArr);
			
			//echo "<pre>"; print_r($setSpecalistArr); echo "</pre>"; 
			
						
			if(trim($_POST['evid'])!='')
			{
				$sccondition=array();

				$evid=trim($_POST['evid']);
			
				if(isset($dbusertype) && $dbusertype=='Trainer')
				{
					
					$sccondition=array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.id'=>$evid);
				}
				
				if(isset($dbusertype) && $dbusertype=='Trainee')
				{
					$sccondition=array('ScheduleCalendar.trainee_id'=>$uid,'ScheduleCalendar.status'=>1,'ScheduleCalendar.id'=>$evid);
				}				
				
				if(isset($dbusertype) && $dbusertype=='Trainee' && $postedby=='Group')
				{
					$sccondition=array('ScheduleCalendar.id'=>$evid,'ScheduleCalendar.status'=>1);
				}
				
				$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>$sccondition,'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.appointment_type','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.mapwrkt','ScheduleCalendar.session_type','ScheduleCalendar.session_typeid','ScheduleCalendar.posted_by')));
				
				
				$popupschedetail = $this->ScdetailPopup->find('first', array('conditions'=>array('ScdetailPopup.trainer_id'=>$schcaldt['ScheduleCalendar']['trainer_id'],'ScdetailPopup.trainee_id'=>$schcaldt['ScheduleCalendar']['trainee_id'],'ScdetailPopup.session_id'=>$schcaldt['ScheduleCalendar']['session_typeid'])));
		
				$this->set("popupschedetail",$popupschedetail);
						
				
				
		
				//echo "<pre>"; print_r($GroupclientstatArr); echo "</pre>"; 
		
				if($schcaldt['ScheduleCalendar']['trainee_id'] !='')
				{
					$sccondition9=array('Trainee.id'=>$schcaldt['ScheduleCalendar']['trainee_id']);
				
					$sessionPurchase=$this->SessionPurchase->find('first',array("conditions"=>array('SessionPurchase.client_id'=>$schcaldt['ScheduleCalendar']['trainee_id'],'SessionPurchase.trainer_id'=>$schcaldt['ScheduleCalendar']['trainer_id'],'SessionPurchase.session_id'=>$schcaldt['ScheduleCalendar']['session_typeid'])));
					
					$this->set('sessionPurchase',$sessionPurchase);
			     		
					$trainedt=$this->Trainee->find('first',array('conditions'=>$sccondition9,'fields'=>array('Trainee.id','Trainee.first_name','Trainee.last_name','Trainee.photo','Trainee.no_ses_purchased','Trainee.booked_ses')));

					$this->set("trainedt",$trainedt);
				}

				$sccondition91=array('Trainer.id'=>$schcaldt['ScheduleCalendar']['trainer_id']);

				$trainerdt=$this->Trainer->find('first',array('conditions'=>$sccondition91,'fields'=>array('Trainer.id','Trainer.first_name','Trainer.last_name','Trainer.logo')));

				$this->set("trainerdt",$trainerdt);
				
				$this->set("scheduleCalendars",$schcaldt);	
							
				//echo "<pre>"; print_r($schcaldt); echo "</pre>"; 
				
				
				$groupmemData=$this->GroupMember->find('first',array("conditions"=>array('GroupMember.group_id'=>$schcaldt['ScheduleCalendar']['trainee_id'])));
				
				$this->set("groupmemData",$groupmemData);
				
				//echo "<pre>"; print_r($groupmemData); echo "</pre>"; 
				
				$groupmemDataAll=$this->GroupMember->find('all',array("conditions"=>array('GroupMember.group_id'=>$schcaldt['ScheduleCalendar']['trainee_id']),'fields'=>array('GroupMember.client_id','GroupMember.client_name')));
				
				$this->set("groupmemDataAll",$groupmemDataAll);
				
				$GroupclientstatArr = $this->GroupClientStat->find('all', array('conditions'=>array('GroupClientStat.gid'=>$schcaldt['ScheduleCalendar']['trainee_id'],'GroupClientStat.start'=>$schcaldt['ScheduleCalendar']['start'],'GroupClientStat.end'=>$schcaldt['ScheduleCalendar']['end'])));
		
					$this->set("GroupclientstatArr",$GroupclientstatArr);	
				
					
				
					
			}
		}

		

		public function evdetailedit()

		{

			$this->layout = "ajax";

			$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	

		

			if(trim($_POST['evid'])!='')

			{

				$sccondition=array();

		         $evid=trim($_POST['evid']);

		

		if(isset($dbusertype) && $dbusertype=='Trainer')

		{

			$sccondition=array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.id'=>$evid);

			

			

			

		}

		if(isset($dbusertype) && $dbusertype=='Trainee')

		{

			$sccondition=array('ScheduleCalendar.trainee_id'=>$uid,'ScheduleCalendar.status'=>1,'ScheduleCalendar.id'=>$evid);

		}

		

		$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>$sccondition,'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.appointment_type','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end')));

		

		$this->set("scheduleCalendars",$schcaldt);

		

		if($schcaldt['ScheduleCalendar']['trainee_id'] !='')

		{

			$sccondition9=array('Trainee.id'=>$schcaldt['ScheduleCalendar']['trainee_id']);

			$trainedt=$this->Trainee->find('first',array('conditions'=>$sccondition9,'fields'=>array('Trainee.id','Trainee.first_name','Trainee.last_name','Trainee.photo')));

			$this->set("trainedt",$trainedt);

		}

		

		$sccondition91=array('Trainer.id'=>$schcaldt['ScheduleCalendar']['trainer_id']);

			$trainerdt=$this->Trainer->find('first',array('conditions'=>$sccondition91,'fields'=>array('Trainer.id','Trainer.first_name','Trainer.last_name','Trainer.logo')));

			$this->set("trainerdt",$trainerdt);

		

			

		

			}

		}

		

		public function markcompleted()

		{
			
			$this->layout = "ajax";

			$this->autoRender=false;

			if(trim($_POST['completed'])!='' )

			{
				$sessiontypeid=trim($_POST['sessiontypeid']);

				$datav=array();				

				//$datav['id']=trim($_POST['completed']);

				$this->ScheduleCalendar->id = trim($_POST['completed']);	

				

				$setScheduleCalendarAr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.id"=>trim($_POST['completed']))));

				//echo "<pre>"; print_r($setScheduleCalendarAr); echo "</pre>"; 

				$trnId = $setScheduleCalendarAr['ScheduleCalendar']['trainee_id'];
				$trnrId = $setScheduleCalendarAr['ScheduleCalendar']['trainer_id'];

				

				 $setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$trnId)));
				 
				 $setTrainerArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$trnrId)));			 
				 
				//echo "<pre>"; print_r($setTrainerArr); echo "</pre>"; 
				 
				//echo "<pre>"; print_r($setClientArr); echo "</pre>"; 
				
				
				
				 $setSchdetalpopArr=$this->ScdetailPopup->find("first",array("conditions"=>array("ScdetailPopup.trainee_id"=>$setScheduleCalendarAr['ScheduleCalendar']['trainee_id'],"ScdetailPopup.trainer_id"=>$setScheduleCalendarAr['ScheduleCalendar']['trainer_id'],"ScdetailPopup.session_id"=>$setScheduleCalendarAr['ScheduleCalendar']['session_typeid'])));
				 
				 $this->set("setSchdetalpopArr",$setSchdetalpopArr);
				//echo "<pre>"; print_r($setSchdetalpopArr); echo "</pre>"; die();
				 
			
				 
				
				 $setSessionArr=$this->SessionPurchase->find("first",array("conditions"=>array("SessionPurchase.id"=>$sessiontypeid)));

		        	         		        

		         $bokedSession = $setClientArr['Trainee']['booked_ses'];
		         $sessbokedSession = $setSessionArr['SessionPurchase']['no_of_booked'];

				

				$datav['ScheduleCalendar']['appointment_type']='Completed';

				if($this->ScheduleCalendar->save($datav)) {

							

							$bokedSessionn = $bokedSession + 1; 
							$sessbokedSession = $sessbokedSession + 1; 

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Your availability has been Marked Completed successfully.");

							$this->Trainee->query("update trainees set booked_ses = '".$bokedSessionn."' where id='".$trnId."'");
							$this->SessionPurchase->query("update session_purchases set no_of_booked = '".$sessbokedSession."' where id='".$sessiontypeid."'");
							 
							
							if(($setSchdetalpopArr['ScdetailPopup']['trainee_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['session_id']==''))
							{
								$this->ScdetailPopup->query("insert scdetail_popups set trainee_id = '".$setScheduleCalendarAr['ScheduleCalendar']['trainee_id']."',  trainer_id = '".$setScheduleCalendarAr['ScheduleCalendar']['trainer_id']."', session_type = '".$setScheduleCalendarAr['ScheduleCalendar']['session_type']."', session_id = '".$setScheduleCalendarAr['ScheduleCalendar']['session_typeid']."', completed = '1'");
								
							}
							else if (($setSchdetalpopArr['ScdetailPopup']['trainee_id']==$setScheduleCalendarAr['ScheduleCalendar']['trainee_id']) && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']==$setScheduleCalendarAr['ScheduleCalendar']['trainer_id']) && ($setSchdetalpopArr['ScdetailPopup']['session_id']==$setScheduleCalendarAr['ScheduleCalendar']['session_typeid']))
							{
								$increase_comp = $setSchdetalpopArr['ScdetailPopup']['completed'] + 1;								
								$this->ScdetailPopup->query("update scdetail_popups set completed='".$increase_comp."' where trainee_id='".$setScheduleCalendarAr['ScheduleCalendar']['trainee_id']."' AND trainer_id='".$setScheduleCalendarAr['ScheduleCalendar']['trainer_id']."' AND session_id='".$setScheduleCalendarAr['ScheduleCalendar']['session_typeid']."'");
							}
							
							if ($setClientArr['Trainee']['comp_session_notification']==1)
							{
							
							$this->send_session_complete($setTrainerArr['Trainer']['email'],$setClientArr['Trainee']['email'],$setClientArr['Trainee']['first_name'],$setClientArr['Trainee']['last_name'],$setTrainerArr['Trainer']['first_name'],$setTrainerArr['Trainer']['last_name'],$setTrainerArr['Trainer']['phone'],$setTrainerArr['Trainer']['website_logo'],$setScheduleCalendarAr['ScheduleCalendar']['start']);	
							}

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
		
		
		
		function send_session_complete($email_from,$email_to,$cfname,$clname,$tfname,$tlname,$tphone,$tlogo,$start_date) {
		
		$start_date = date("m/d/Y", strtotime($start_date));

		App::uses('CakeEmail', 'Network/Email');		

		$email = new CakeEmail();		

		$email->emailFormat('html');		
	
		$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'uploads/'.$tlogo.'"/ style="width:100px"></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$cfname.' '.$clname.'!</p>

				<p>Your session on '.$start_date.' has been Completed. </p>

				<p>As always, it\'s a pleasure to help you reach your fitness goals.  Feel free to contact me anytime with questions regarding your training.</p>

				</td></tr><tr><td><br/>Thank You,<br /><br /> '.$tfname.' '.$tlname.'<br/>'.$tphone.'<br />'.$email_from.'</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';	 
            

		//$email->from(array($email_from => "$tfname $tlname"));
		
		$email->from(array(FROM_EMAIL => EMAILNAME));

		$email->to($email_to);

		//$email->cc('rprasad@sampatti.com');

		$subtxt = __('Session Status');

		$email->subject($subtxt);

		$email->send($content);

	}
		
		

		public function markcomp()

		{

			$this->layout = "ajax";

			$this->autoRender=false;

			if(trim($_POST['comp'])!='' )

			{

				$datav=array();				

				$this->ScheduleCalendar->id = trim($_POST['comp']);	

				$datav['ScheduleCalendar']['appointment_type']='Comp';
				
				$setScheduleCalendarAr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.id"=>trim($_POST['comp']))));

				//echo "<pre>"; print_r($setScheduleCalendarAr); echo "</pre>"; 

				$trnId = $setScheduleCalendarAr['ScheduleCalendar']['trainee_id'];
				$trnrId = $setScheduleCalendarAr['ScheduleCalendar']['trainer_id'];
				
				$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$trnId)));
				 
				 $setTrainerArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$trnrId)));			 
				 
				 //echo "<pre>"; print_r($setTrainerArr); echo "</pre>"; 
				 
				 //echo "<pre>"; print_r($setClientArr); echo "</pre>"; die();
				 
				 $setSchdetalpopArr=$this->ScdetailPopup->find("first",array("conditions"=>array("ScdetailPopup.trainee_id"=>$setScheduleCalendarAr['ScheduleCalendar']['trainee_id'],"ScdetailPopup.trainer_id"=>$setScheduleCalendarAr['ScheduleCalendar']['trainer_id'],"ScdetailPopup.session_id"=>$setScheduleCalendarAr['ScheduleCalendar']['session_typeid'])));
				 
				$this->set("setSchdetalpopArr",$setSchdetalpopArr);
				
				
				if($this->ScheduleCalendar->save($datav)) {

							

							

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Your availability has been Marked Comp successfully.");
							
							
							if(($setSchdetalpopArr['ScdetailPopup']['trainee_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['session_id']==''))
							{
								$this->ScdetailPopup->query("insert scdetail_popups set trainee_id = '".$setScheduleCalendarAr['ScheduleCalendar']['trainee_id']."',  trainer_id = '".$setScheduleCalendarAr['ScheduleCalendar']['trainer_id']."', session_type = '".$setScheduleCalendarAr['ScheduleCalendar']['session_type']."', session_id = '".$setScheduleCalendarAr['ScheduleCalendar']['session_typeid']."', complimentary = '1'");
								
							}
							else if (($setSchdetalpopArr['ScdetailPopup']['trainee_id']==$setScheduleCalendarAr['ScheduleCalendar']['trainee_id']) && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']==$setScheduleCalendarAr['ScheduleCalendar']['trainer_id']) && ($setSchdetalpopArr['ScdetailPopup']['session_id']==$setScheduleCalendarAr['ScheduleCalendar']['session_typeid']))
							{
								$increase_compl = $setSchdetalpopArr['ScdetailPopup']['complimentary'] + 1;								
								$this->ScdetailPopup->query("update scdetail_popups set complimentary='".$increase_compl."' where trainee_id='".$setScheduleCalendarAr['ScheduleCalendar']['trainee_id']."' AND trainer_id='".$setScheduleCalendarAr['ScheduleCalendar']['trainer_id']."' AND session_id='".$setScheduleCalendarAr['ScheduleCalendar']['session_typeid']."'");
							}
							
							
							
							$this->send_session_complimentary($setTrainerArr['Trainer']['email'],$setClientArr['Trainee']['email'],$setClientArr['Trainee']['first_name'],$setClientArr['Trainee']['last_name'],$setTrainerArr['Trainer']['first_name'],$setTrainerArr['Trainer']['last_name'],$setTrainerArr['Trainer']['phone'],$setTrainerArr['Trainer']['website_logo'],$setScheduleCalendarAr['ScheduleCalendar']['start']);

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
		
		
		function send_session_complimentary($email_from,$email_to,$cfname,$clname,$tfname,$tlname,$tphone,$tlogo,$start_date) {
		
		$start_date = date("m/d/Y", strtotime($start_date));

		App::uses('CakeEmail', 'Network/Email');		

		$email = new CakeEmail();		

		$email->emailFormat('html');		
	
		$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'uploads/'.$tlogo.'"/ style="width:100px"></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$cfname.' '.$clname.'!</p>

				<p>Your session on '.$start_date.' was Complimentary. </p>

				<p>As always, it\'s a pleasure to help you reach your fitness goals.  Feel free to contact me anytime with questions regarding your training.</p>

				</td></tr><tr><td><br/>Thank You,<br /><br /> '.$tfname.' '.$tlname.'<br/>'.$tphone.'<br />'.$email_from.'</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';	 
            

		//$email->from(array($email_from => "$tfname $tlname"));
		$email->from(array(FROM_EMAIL => EMAILNAME));

		$email->to($email_to);

		//$email->cc('rprasad@sampatti.com');

		$subtxt = __('Session Status');

		$email->subject($subtxt);

		$email->send($content);

	}

		

		public function markcancel()

		{

			$this->layout = "";

			$this->autoRender=false;

			if(trim($_POST['cancel'])!='' )

			{

				$datav=array();				

				$this->ScheduleCalendar->id = trim($_POST['cancel']);	

				$scHId = trim($_POST['cancel']);	

				$datav['ScheduleCalendar']['appointment_type']='Cancel NC';

				

			    $setScheduleCalendarArr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.id"=>$scHId)));

			   // echo "<pre>";print_r($setScheduleCalendarArr);echo"</pre>";

			    $TraineeId = $setScheduleCalendarArr['ScheduleCalendar']['trainee_id'];
				$TrainerId = $setScheduleCalendarArr['ScheduleCalendar']['trainer_id'];

			    

			    $setTraineeArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$TraineeId)));
				
				$setTrainerArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$TrainerId)));
			  
				//echo "<pre>";print_r($setTraineeArr);echo"</pre>";
				//echo "<pre>";print_r($setTrainerArr);echo"</pre>";
				
				//die();
			    

			    /*$NewBooked_ses = $setTraineeArr['Trainee']['booked_ses'] - 1;

			    

			    $this->Trainee->query("update trainees set booked_ses='".$NewBooked_ses."' where id='".$TraineeId."'");*/	

				$setSchdetalpopArr=$this->ScdetailPopup->find("first",array("conditions"=>array("ScdetailPopup.trainee_id"=>$setScheduleCalendarArr['ScheduleCalendar']['trainee_id'],"ScdetailPopup.trainer_id"=>$setScheduleCalendarArr['ScheduleCalendar']['trainer_id'],"ScdetailPopup.session_id"=>$setScheduleCalendarArr['ScheduleCalendar']['session_typeid'])));
				 
				$this->set("setSchdetalpopArr",$setSchdetalpopArr);

				

				if($this->ScheduleCalendar->save($datav)) {

							

							

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Your availability has been Marked Cancel NC successfully.");
							
							if(($setSchdetalpopArr['ScdetailPopup']['trainee_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['session_id']==''))
							{
								$this->ScdetailPopup->query("insert scdetail_popups set trainee_id = '".$setScheduleCalendarArr['ScheduleCalendar']['trainee_id']."',  trainer_id = '".$setScheduleCalendarArr['ScheduleCalendar']['trainer_id']."', session_type = '".$setScheduleCalendarArr['ScheduleCalendar']['session_type']."', session_id = '".$setScheduleCalendarArr['ScheduleCalendar']['session_typeid']."', cancel_no_charge = '1'");
								
							}
							else if (($setSchdetalpopArr['ScdetailPopup']['trainee_id']==$setScheduleCalendarArr['ScheduleCalendar']['trainee_id']) && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']==$setScheduleCalendarArr['ScheduleCalendar']['trainer_id']) && ($setSchdetalpopArr['ScdetailPopup']['session_id']==$setScheduleCalendarArr['ScheduleCalendar']['session_typeid']))
							{
								$increase_cancel_no_charge = $setSchdetalpopArr['ScdetailPopup']['cancel_no_charge'] + 1;								
								$this->ScdetailPopup->query("update scdetail_popups set cancel_no_charge='".$increase_cancel_no_charge."' where trainee_id='".$setScheduleCalendarArr['ScheduleCalendar']['trainee_id']."' AND trainer_id='".$setScheduleCalendarArr['ScheduleCalendar']['trainer_id']."' AND session_id='".$setScheduleCalendarArr['ScheduleCalendar']['session_typeid']."'");
							}
							
							
							$this->send_session_cancel_no_charge($setTrainerArr['Trainer']['email'],$setTraineeArr['Trainee']['email'],$setTraineeArr['Trainee']['first_name'],$setTraineeArr['Trainee']['last_name'],$setTrainerArr['Trainer']['first_name'],$setTrainerArr['Trainer']['last_name'],$setTrainerArr['Trainer']['phone'],$setTrainerArr['Trainer']['website_logo'],$setScheduleCalendarArr['ScheduleCalendar']['start']);	
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
		
		
		
		function send_session_cancel_no_charge($email_from,$email_to,$cfname,$clname,$tfname,$tlname,$tphone,$tlogo,$start_date) {

		$start_date = date("m/d/Y", strtotime($start_date));
		App::uses('CakeEmail', 'Network/Email');		

		$email = new CakeEmail();		

		$email->emailFormat('html');		
	
		$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'uploads/'.$tlogo.'"/ style="width:100px"></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$cfname.' '.$clname.'!</p>

				<p>Your session on '.$start_date.' has been Cancelled with No Charge. </p>

				<p>As always, it\'s a pleasure to help you reach your fitness goals.  Feel free to contact me anytime with questions regarding your training.</p>

				</td></tr><tr><td><br/>Thank You,<br /><br /> '.$tfname.' '.$tlname.'<br/>'.$tphone.'<br />'.$email_from.'</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';	 
            

		//$email->from(array($email_from => "$tfname $tlname"));
		$email->from(array(FROM_EMAIL => EMAILNAME));

		$email->to($email_to);

		//$email->cc('rprasad@sampatti.com');

		$subtxt = __('Session Status');

		$email->subject($subtxt);

		$email->send($content);

	}

		

		

		

		public function markcancel_charged()

		{

			$this->layout = "ajax";

			$this->autoRender=false;

			if(trim($_POST['cancel'])!='' )

			{
				//$sessiontypeid=trim($_POST['sessiontypeid']);
				

				$datav=array();				

				$this->ScheduleCalendar->id = trim($_POST['cancel']);	

				$datav['ScheduleCalendar']['appointment_type']='Cancel Charge';

				

				$setScheduleCalendarAr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.id"=>trim($_POST['cancel']))));
					
				$sessiontypeid = $setScheduleCalendarAr['ScheduleCalendar']['session_typeid'];
				//$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>$sccondition,'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.appointment_type','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.mapwrkt','ScheduleCalendar.session_type','ScheduleCalendar.session_typeid')));
				
				
				
				
				//$setSessionArr= $this->SessionPurchase->query("update session_purchases set no_of_booked = '".$sessbokedSession."' where id='".$sessiontypeid."'");

				

				$trnId = $setScheduleCalendarAr['ScheduleCalendar']['trainee_id'];
				$trnrId = $setScheduleCalendarAr['ScheduleCalendar']['trainer_id'];

				

				$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$trnId)));
				
				$setTrainerArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$trnrId)));
				
				$sessionPurchase=$this->SessionPurchase->find('first',array("conditions"=>array('SessionPurchase.client_id'=>$setClientArr['Trainee']['id'],'SessionPurchase.trainer_id'=>$setTrainerArr['Trainer']['id'],'SessionPurchase.session_id'=>$setScheduleCalendarAr['ScheduleCalendar']['session_typeid'])));
				
				$this->set('sessionPurchase',$sessionPurchase);
				
				$setSchdetalpopArr=$this->ScdetailPopup->find("first",array("conditions"=>array("ScdetailPopup.trainee_id"=>$setScheduleCalendarAr['ScheduleCalendar']['trainee_id'],"ScdetailPopup.trainer_id"=>$setScheduleCalendarAr['ScheduleCalendar']['trainer_id'],"ScdetailPopup.session_id"=>$setScheduleCalendarAr['ScheduleCalendar']['session_typeid'])));
				 
				$this->set("setSchdetalpopArr",$setSchdetalpopArr);

		       // echo "<pre>"; print_r($setTrainerArr);echo "</pre>";
				//echo "<pre>"; print_r($setScheduleCalendarAr);echo "</pre>";
				//echo "<pre>"; print_r($sessionPurchase);echo "</pre>";
	         		        
		        $bokedSession = $setClientArr['Trainee']['booked_ses'];
		        $sessbokedSession = $sessionPurchase['SessionPurchase']['no_of_booked'];
				
				//die();

							    				

				if($this->ScheduleCalendar->save($datav)) {
							
							

							$bokedSessionn = $bokedSession + 1; 
							$sessbokedSession = $sessbokedSession + 1; 

							$this->Trainee->query("update trainees set booked_ses = '".$bokedSessionn."' where id='".$trnId."'");
							
							$this->SessionPurchase->query("update session_purchases set no_of_booked = '".$sessbokedSession."' where session_id='".$sessiontypeid."'");
							

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Your availability has been Marked Cancel Charge successfully.");
							
							if(($setSchdetalpopArr['ScdetailPopup']['trainee_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['session_id']==''))
							{
								$this->ScdetailPopup->query("insert scdetail_popups set trainee_id = '".$setScheduleCalendarAr['ScheduleCalendar']['trainee_id']."',  trainer_id = '".$setScheduleCalendarAr['ScheduleCalendar']['trainer_id']."', session_type = '".$setScheduleCalendarAr['ScheduleCalendar']['session_type']."', session_id = '".$setScheduleCalendarAr['ScheduleCalendar']['session_typeid']."', cancel = '1'");
								
							}
							else if (($setSchdetalpopArr['ScdetailPopup']['trainee_id']==$setScheduleCalendarAr['ScheduleCalendar']['trainee_id']) && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']==$setScheduleCalendarAr['ScheduleCalendar']['trainer_id']) && ($setSchdetalpopArr['ScdetailPopup']['session_id']==$setScheduleCalendarAr['ScheduleCalendar']['session_typeid']))
							{
								$increase_cancel = $setSchdetalpopArr['ScdetailPopup']['cancel'] + 1;								
								$this->ScdetailPopup->query("update scdetail_popups set cancel='".$increase_cancel."' where trainee_id='".$setScheduleCalendarAr['ScheduleCalendar']['trainee_id']."' AND trainer_id='".$setScheduleCalendarAr['ScheduleCalendar']['trainer_id']."' AND session_id='".$setScheduleCalendarAr['ScheduleCalendar']['session_typeid']."'");
							}
							
							$this->send_session_cancel_charge($setTrainerArr['Trainer']['email'],$setClientArr['Trainee']['email'],$setClientArr['Trainee']['first_name'],$setClientArr['Trainee']['last_name'],$setTrainerArr['Trainer']['first_name'],$setTrainerArr['Trainer']['last_name'],$setTrainerArr['Trainer']['phone'],$setTrainerArr['Trainer']['website_logo'],$setScheduleCalendarAr['ScheduleCalendar']['start']);

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
		
		
		function send_session_cancel_charge($email_from,$email_to,$cfname,$clname,$tfname,$tlname,$tphone,$tlogo,$start_date) {
		
		$start_date = date("m/d/Y", strtotime($start_date));
		
		App::uses('CakeEmail', 'Network/Email');		

		$email = new CakeEmail();		

		$email->emailFormat('html');		
	
		$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'uploads/'.$tlogo.'"/ style="width:100px"></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$cfname.' '.$clname.'!</p>

				<p>Your session on '.$start_date.' has been Cancelled but Charged. </p>

				<p>As always, it\'s a pleasure to help you reach your fitness goals.  Feel free to contact me anytime with questions regarding your training.</p>

				</td></tr><tr><td><br/>Thank You,<br /><br /> '.$tfname.' '.$tlname.'<br/>'.$tphone.'<br />'.$email_from.'</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';	 
            

		//$email->from(array($email_from => "$tfname $tlname"));
		$email->from(array(FROM_EMAIL => EMAILNAME));

		$email->to($email_to);

		//$email->cc('rprasad@sampatti.com');

		$subtxt = __('Session Status');

		$email->subject($subtxt);

		$email->send($content);

	}

		

		

		

		public function createavailability()

		{	

			$this->layout = "ajax";

			//$this->autoRender=false;

			

			

			if(trim($_POST['title'])!='' && trim($_POST['description'])!='' && trim($_POST['startd'])!='' && trim($_POST['endd'])!='' && trim($_POST['user_id'])!='')

			{

				

             

				$datav=array();

				

				

				$datav['ScheduleCalendar']['title']=trim($_POST['title']);

				$datav['ScheduleCalendar']['appointment_type']='Available';

				$datav['ScheduleCalendar']['description']=trim($_POST['description']);

				$datav['ScheduleCalendar']['trainer_id']=trim($_POST['user_id']);

				

				/*$datav['ScheduleCalendar']['start']=trim($_POST['startd']);

				$datav['ScheduleCalendar']['end']=trim($_POST['endd']);*/

				

				$datav['ScheduleCalendar']['start']=trim($_POST['startd']);

				$datav['ScheduleCalendar']['end']=trim($_POST['endd']);

				

				$datav['ScheduleCalendar']["added_date"] 		    = date("Y-m-d");

				$datav['ScheduleCalendar']["modification_date"] 		    = date("Y-m-d");

				

				/*	echo '<pre>';

				print_r($datav);

				echo '</pre>';

				exit;*/

					    	

						if($this->ScheduleCalendar->save($datav)) {

							

							$this->set("response","Your availability has been marked successfully.");

						}

						else {

							

							$this->set("response","Some issue occur, please try again!!");

						}

							

				

			}

			else 

			{

				$this->set("response","Please fill valid data!!");

			}

			

		}

		

		

		public function editavailbility()

		{	

			$this->layout = "ajax";

			//$this->autoRender=false;

			

			

			if(trim($_POST['title'])!='' && trim($_POST['evid'])!=''  && trim($_POST['description'])!='' && trim($_POST['startd'])!='' && trim($_POST['endd'])!='' && trim($_POST['user_id'])!='')

			{

				

             

				$datav=array();

				

				

				$datav['ScheduleCalendar']['id']=trim($_POST['evid']);

				$datav['ScheduleCalendar']['title']=trim($_POST['title']);

				$datav['ScheduleCalendar']['appointment_type']='Available';

				$datav['ScheduleCalendar']['description']=trim($_POST['description']);

				$datav['ScheduleCalendar']['trainer_id']=trim($_POST['user_id']);

				

				/*$datav['ScheduleCalendar']['start']=trim($_POST['startd']);

				$datav['ScheduleCalendar']['end']=trim($_POST['endd']);*/

				

				$datav['ScheduleCalendar']['start']=trim($_POST['startd']);

				$datav['ScheduleCalendar']['end']=trim($_POST['endd']);

				

				

				$datav['ScheduleCalendar']["modification_date"] 		    = date("Y-m-d");

				

				/*	echo '<pre>';

				print_r($datav);

				echo '</pre>';

				exit;*/

					    	

						if($this->ScheduleCalendar->save($datav)) {

							

							$this->set("response","Your availability has been updated successfully.");

						}

						else {

							

							$this->set("response","Some issue occur, please try again!!");

						}

							

				

			}

			else 

			{

				$this->set("response","Please fill valid data!!");

			}

			

		}

		

		

		public function deleteslot()

		{	

			$this->layout = "ajax";

			//$this->autoRender=false;

			if(trim($_POST['evid'])!='')

			{

				$datav=array();				

				$datav['id']=trim($_POST['evid']);
				
				$schdulingData=$this->ScheduleCalendar->findById($datav['id']);
				$trainerd_id=$schdulingData['ScheduleCalendar']['trainer_id'];
				$traineed_id=$schdulingData['ScheduleCalendar']['trainee_id'];
				$startdDate=$schdulingData['ScheduleCalendar']['start'];
				$enddDate=$schdulingData['ScheduleCalendar']['end'];
				

				$datav['status']='0';

				//if($this->ScheduleCalendar->delete($datav)) {

				if($this->ScheduleCalendar->save($datav)) {
					
					$goalDatav['Goal']['status']=0;
					

					$this->Goal->updateAll($goalDatav['Goal'], array('Goal.trainer_id' =>$trainerd_id,'Goal.trainee_id' =>$traineed_id,'Goal.start'=>$startdDate,'Goal.end'=>$enddDate));

							$this->set("response","Your availability has been deleted successfully.");

						}

						else {

							

							$this->set("response","Some issue occur, please try again!!");

						}

			}

			else 

			{

				$this->set("response","Sorry, please refresh the page and try again!!");

			}

		}

		

		

		public function deleteevent()

		{	

			$this->layout = "";

			$this->autoRender=false;

			if(trim($_POST['eventid'])!='')

			{

				$datav=array();				

				$datav['id']=trim($_POST['eventid']);

				if($this->Event->delete($datav)) {

							

							echo "Your availability has been deleted successfully.";

							exit;

						}

						else {

							

							echo "Some issue occur, please try again!!";

							exit;

						}

			}

			else 

			{

				echo "Sorry, please refresh the page and try again!!";

				exit;

			}

		}

		

		public function my_clients(){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'homemy_clients');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	    $this->set("degrees",$this->Degree->find('all',array('conditions'=>array('Degree.status'=>1),'fields'=>array('Degree.id','Degree.name'))));	

	    $this->set("certificationsorg",$this->CertificationOrganization->find('all',array('conditions'=>array('CertificationOrganization.status'=>1),'fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));

	    $this->Trainee->unbindModel(array('hasAndBelongsToMany' => array('Club')), true);

	   /* $clients = $this->Trainer->find('all', array(

        'joins' => array(

             array('table' => 'trainee_trainers',

                'alias' => 'TraineeTrainer',

                'type' => 'INNER',

                'conditions' => array(

                    'TraineeTrainer.trainerId' => $uid)

                

            )

        ),

        array(

        'table' => 'trainees',

        'alias' => 'Trainee',

        'type' => 'inner',

        'conditions'=> array(

            'Trainee.id = TraineeTrainer.traineeId'

        ))

    ));*/

	  $clients=$this->Trainee->Trainer->find('all', array(

    'conditions' => array('Trainer.id' => 1)));

	  //$clients=$this->Trainer->Trainee->find();

	  

	   //pr($clients);

	   $this->set('clients',$clients[0]['Trainee']);

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		  $this->set("setSpecalistArr",$setSpecalistArr);
$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);
		

		

		}

		

		public function measurement_and_goal($clientid=null){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'measurement_and_goal');

		

		if($clientid!='')

		{

			$this->set("clientid",$clientid);

			

			$response=$this->Goal->find("all",array("conditions"=>array("Goal.trainee_id"=>$clientid),'order' => array('Goal.id' => 'DESC')));

			

	

			

			

		}

				

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	



		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	    $this->set("degrees",$this->Degree->find('all',array('conditions'=>array('Degree.status'=>1),'fields'=>array('Degree.id','Degree.name'))));	

	    $this->set("certificationsorg",$this->CertificationOrganization->find('all',array('conditions'=>array('CertificationOrganization.status'=>1),'fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));	

			

			

	    

	    $this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$uid,'Trainee.status'=>1,'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.full_name ASC'),'fields'=>array('Trainee.id','Trainee.full_name'))));

	    

	    

	    $setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);
		
		$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$setSpecalistArr['Trainer']['club_id'])));
		$this->set("setSpecalistArr1",$setSpecalistArr1);
		
		/*echo $setSpecalistArr['Trainer']['club_id'];
		echo "<pre>";
		print_r($setSpecalistArr);
		echo "<pre>";
		echo "<pre>";
		print_r($setSpecalistArr1);
		echo "<pre>";
		die();*/
		  

		  /* ----*/

		 

		  

		   

		 

		  $uid2=2;

		  $setSvftArr=$this->SevensiteBodyfat->find("first",array("conditions"=>array("SevensiteBodyfat.client_id"=>$uid2), 'order' => array('SevensiteBodyfat.id' => 'DESC')));

		 

		  $this->set("setSvftArr",$setSvftArr);

		  

		   $setThrftArr=$this->ThreesiteBodyfat->find("first",array("conditions"=>array("ThreesiteBodyfat.client_id"=>$uid2), 'order' => array('ThreesiteBodyfat.id' => 'DESC')));

		  $this->set("setThrftArr",$setThrftArr);

		  

		  

		   $setBMIArr=$this->BodymassIndex->find("first",array("conditions"=>array("BodymassIndex.client_id"=>$uid2), 'order' => array('BodymassIndex.id' => 'DESC')));

		  $this->set("setBMIArr",$setBMIArr);

		  

		  

		}

		

		public function listtraineegoal()

		{

			//echo "hello"; die(); 

			

			$this->layout = '';

			$this->render = false;

		 if($this->data)

		 {

		 	

		 	$respons= array();

		 	

		 	

		 	

		 	 $client_id = $_POST['trainee_id'];

		 	 $response=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$client_id), 'order' => array('Goal.goal ' => 'Desc')));

		 	 

		 	$respons['goal'] = $response['Goal']['goal'];

		 	$respons['trainee_id'] = $_POST['trainee_id'];

		 	$respons['trainer_id'] = $response['Goal']['trainer_id'];

		 	$respons['id'] = $response['Goal']['id'];

		 	

		 	

		 	 

		 	 

		 	  echo json_encode($respons);

				exit;

				



		 	

		 } else {

		 	$response=array();

		 	 echo json_encode($response);

				exit;	

		   }	

		}

		

		

		public function listtraineemeasurement()

		{

			//echo "hello"; die(); 

			

			$this->layout = '';

			$this->render = false;

		 if($this->data)

		 {

		 	

		 	$respons= array();

		 	

		 	$client_id = $_POST['trainee_id'];

		 	 

		 	

		 	$response19 =$this->SevensiteBodyfat->find("all",array("conditions"=>array("SevensiteBodyfat.client_id"=>$client_id), 'order' => array('SevensiteBodyfat.id ' => 'Desc')));

		 	

		 	/*print_r($response19);

		 	exit;*/

		 	

		 	$response20 =$this->ThreesiteBodyfat->find("all",array("conditions"=>array("ThreesiteBodyfat.client_id"=>$client_id), 'order' => array('ThreesiteBodyfat.id ' => 'Desc')));

		 	

		 	//$response21 =$this->BodymassIndex->find("all",array("conditions"=>array("BodymassIndex.client_id"=>$client_id), 'order' => array('BodymassIndex.id ' => 'Desc')));

		 	

		 		 	 

		 	 $jtms='';



		 	 if(!empty($response19) || !empty($response20) )

				{

					$cnt=1;

				$jtms= "<table border='1' width='100%'>

				

				<tr class='slectedmn'>

				<th colspan='6'><h3 style='text-align:center;'>Measurement Goal</h3></th>

				</tr>

				<tr>

				<th>S.No.</th>

				<th>Date</th>

				<th>Seven Site Body Fat</th>

				<th>Three Site Body Fat</th>

				<!--<th>Body Mass Index</th>-->

				<th>Action</th>

				

				</tr>";

				}

				$cntv=0;

				$cntv9=0;

				if(!empty($response19))

				{

					 $cntv1=count($response19);

				}

				if(!empty($response20))

				{

					 $cntv2=count($response20);

				}

				/*if(!empty($response21))

				{

					$cntv=count($response21);

				}*/

				if($cntv1>$cntv2)

				{

					$cntv=$cntv1;

					$cntv9=1;

				}

				else{

					if($cntv2>$cntv1)

					{$cntv=$cntv2; $cntv9=2;}

					 else {

					        $cntv=$cntv2; $cntv9=3;

				        }

				}

				

				for($i=0;$i<$cntv;$i++)

				

				{

					

						if(isset($response19[$i]['SevensiteBodyfat']['created_date']) && $cntv9==1)

						{

							 $dtvs=$response19[$i]['SevensiteBodyfat']['created_date'];

						}

						if(isset($response20[$i]['ThreesiteBodyfat']['created_date']) && $cntv9==2)

						{

							 $dtvs=$response20[$i]['ThreesiteBodyfat']['created_date'];

						}

						if($cntv9==3)

						{

							 $dtvs=$response20[$i]['ThreesiteBodyfat']['created_date'];

						}

						/*if(isset($response21[$i]['BodymassIndex']['created_date']))

						{

							echo $dtvs=$response21[$i]['BodymassIndex']['created_date'];

						}*/

					

					

					$jtms .= "<tr><td>".$cnt."</td>";

					$jtms .= "<td>".date('M, j Y',strtotime($dtvs))."</td>"; 

					$jtms .= "<td>";

					if(isset($response19[$i]['SevensiteBodyfat']['status']) && $response19[$i]['SevensiteBodyfat']['status']==1)

					   {$jtms .=$response19[$i]['SevensiteBodyfat']['body_fat'];}

					    else{$jtms .='--';}

					$jtms .="</td>";

					

					$jtms .= "<td>";

					if(isset($response20[$i]['ThreesiteBodyfat']['status']) && $response20[$i]['ThreesiteBodyfat']['status']==1)

					   {$jtms .=$response20[$i]['ThreesiteBodyfat']['body_fat'];}

					    else{$jtms .='--';}

					$jtms .="</td>";

					

					/*$jtms .= "<td>";

					if(isset($response21[$i]['BodymassIndex']['status']) && $response21[$i]['BodymassIndex']['status']==1)

					   {$jtms .=$response21[$i]['BodymassIndex']['body_fat'];}

					    else{$jtms .='--';}

					$jtms .="</td>";*/

					

										

					$jtms .= '<td><a href="javascript:void(0);" onclick="viewdetail(\''.$client_id.'\',\''.date('Y-m-d',strtotime($dtvs)).'\');">View</a>/<a href="javascript:void(0);" onclick="deletetrainer('.$client_id.','.strtotime($dtvs).',0);">Delete</a></td>';

					

				 $jtms .= "</tr>";

				 $cnt++;

				};

			

				echo $jtms .= "</table>";

             

           				 	 

		 	

		 	 // echo json_encode($response1);

				exit;

				



		 	

		 } else {

		 	$response1=array();

		 	 echo json_encode($response1);

				exit;	

		   }	

		}

		

		public function deletemeasurement()

		{

						

			$this->layout = '';

			$this->render = false;

			if(trim($_POST['id'])!='' && trim($_POST['id2'])!='')

			{

				$datavt=array();				

				 $datavt['client_id']=trim($_POST['id']);

			 $datavt['created_date']=date('Y-m-d',$_POST['id2']);

				//echo $_POST['id2'];

				//die;

			



				

				//$datavb['id']=trim($_POST['id3']);

				if($this->SevensiteBodyfat->query("delete from sevensite_bodyfats where client_id='".$datavt['client_id']."' and created_date='".$datavt['created_date']."'")) {

							

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully deleted");

						}

						/*else {

							

							

							$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");

						}*/

						

						if($this->ThreesiteBodyfat->query("delete from threesite_bodyfat where client_id='".$datavt['client_id']."' and created_date='".$datavt['created_date']."'")) {

							

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully deleted");

						}

						/*else {

							

							

							$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");

						}*/

						

						if($this->BodymassIndex->query("delete from bodymass_index where client_id='".$datavt['client_id']."' and created_date='".$datavt['created_date']."'")) {

							

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully deleted");

						}

						/*else {

							

							

							$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");

						}*/

			}

			else 

			{

				

				$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, please refresh the page and try again!!");

			}

			

			

				echo json_encode($response);

				exit;	

			

		}

		

		public function clientmesdetail($client_id=null,$date=null)

		{

						

			//$this->checkUserLogin();

		$this->layout = "ajax1";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'measurement_and_goal');

		

		//$dbusertype = $this->Session->read('UTYPE');					

		//$this->set("dbusertype",$dbusertype);

		//$uid = $this->Session->read('USER_ID');				

		//$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		//$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	  	

			

			//$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		//  $this->set("setSpecalistArr",$setSpecalistArr);

			



			

			$response=$this->SevensiteBodyfat->find("all",array("conditions"=>array("SevensiteBodyfat.client_id"=>$client_id,'SevensiteBodyfat.created_date <='=>$date), 'order' => array('SevensiteBodyfat.id' => 'DESC'),'limit'=>2));

			

			//$conditions = array('SevensiteBodyfat.created_date <=' => $date, 'SevensiteBodyfat.created_date >=' => $start);

			

						

			$this->set("response",$response);

			



		 	 

		 	$response_threesite =$this->ThreesiteBodyfat->find("all",array("conditions"=>array("ThreesiteBodyfat.client_id"=>$client_id,'ThreesiteBodyfat.created_date <='=>$date), 'order' => array('ThreesiteBodyfat.id ' => 'Desc'),'limit'=>2));

		 	

		 	$this->set("response_threesite",$response_threesite);

		 	

		 	$response_bodyindex =$this->BodymassIndex->find("all",array("conditions"=>array("BodymassIndex.client_id"=>$client_id,'BodymassIndex.created_date <='=>$date), 'order' => array('BodymassIndex.id ' => 'Desc'),'limit'=>2));

		 	

		 	$this->set("response_bodyindex",$response_bodyindex);

		 	



		

		}

		

		

		public function deletewrkt($goalid=null,$clientid=null)

		{

          $this->layout = "";

		  $this->autoRender=false;

            if($goalid!='' && $clientid!='')

			{



               $setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.id"=>$goalid)));

                if(!empty($setClientGoalArr))

				{

                      $trainerid=$setClientGoalArr['Goal']['trainer_id'];

					  $startdt=$setClientGoalArr['Goal']['start'];

					  $enddt=$setClientGoalArr['Goal']['end'];

                      $this->WarmUps->deleteAll(array('WarmUps.start' => $startdt,'WarmUps.end'=>$enddt,'WarmUps.trainer_id'=>$trainerid,'WarmUps.trainee_id'=>$clientid), false);



                      $this->CoreBalancePlyometric->deleteAll(array('CoreBalancePlyometric.start' => $startdt,'CoreBalancePlyometric.end'=>$enddt,'CoreBalancePlyometric.trainer_id'=>$trainerid,'CoreBalancePlyometric.trainee_id'=>$clientid), false);



					   $this->SpeedAgilityQuickness->deleteAll(array('SpeedAgilityQuickness.start' => $startdt,'SpeedAgilityQuickness.end'=>$enddt,'SpeedAgilityQuickness.trainer_id'=>$trainerid,'SpeedAgilityQuickness.trainee_id'=>$clientid), false);



					    $this->Resistence->deleteAll(array('Resistence.start' => $startdt,'Resistence.end'=>$enddt,'Resistence.trainer_id'=>$trainerid,'Resistence.trainee_id'=>$clientid), false);



						 $this->CoolDown->deleteAll(array('CoolDown.start' => $startdt,'CoolDown.end'=>$enddt,'CoolDown.trainer_id'=>$trainerid,'CoolDown.trainee_id'=>$clientid), false);

				

                         $this->Goal->delete($goalid);

                         

                          $this->ScheduleCalendar->query("update schedule_calendar set mapwrkt=0 where trainer_id='".$trainerid."' AND trainee_id='".$clientid."' AND start='".$startdt."' AND end='".$enddt."'");



                       $response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully deleted");



				}

				else

				{

                   $response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");

				}





			 

			} else

			{

                 

				  $response = array("responseclassName"=>"nFailure","errorMsg"=>"Please select the Workout.");

			}

              echo json_encode($response);

				exit;	

		}
		public function exercise_history_build($clientid=null,$rangeA=null,$rangeB=null){

			

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'exercise_history');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');

		
		if($rangeA!='' && $rangeB=='')
		{
		  	$this->set("selectedslt",$rangeA);
		}
		

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));

		

		$this->set("workoutcategory",$this->WorkoutCategory->find('all',array('conditions'=>array('WorkoutCategory.trainerId'=>$uid),'fields'=>array('WorkoutCategory.id','WorkoutCategory.name'))));

		

		  $this->set("setSpecalistArr",$setSpecalistArr);

		 

		  $tgvs=0;

		  $showoff=1;

		if($clientid!='')

		{

			$this->set("clientid",$clientid);

			

			 $dateN=date('Y-m-d');

			 $dateN2=date('Y-m-d',strtotime("-31 days"));

			

			$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));

			

			$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid),'order' => array('Goal.id' => 'DESC')));

			

			

			$this->set('clientGoal',$setClientGoalArr);

			$this->set('setClientArr',$setClientArr);

			/*$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0', 'ScheduleCalendar.status <>'=>'0','ScheduleCalendar.start >'=>date('Y-m-d H:i:s')),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status'),'limit'=>5));*/
			$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0', 'ScheduleCalendar.status <>'=>'0'),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));

			
			
			
			
			$this->set('scheduleCalendars',$scheduleCalendars);

			

			

			$dt1 = date('Y-m-d h:i:s', strtotime($rangeA));

			$dt2 = date('Y-m-d h:i:s', strtotime($rangeB));

			$setClientGoalArr3=array();
			
		
					
					

			if (!empty($dt1) && $dt1!='1970-01-01 01:00:00' && (!empty($dt2) && $dt2!='1970-01-01 01:00:00')) 

			{

				 $this->set("rangeA",date('m/d/Y', strtotime($rangeA)));

				 $this->set("rangeB",date('m/d/Y', strtotime($rangeB)));

				 

				 //if ((isset($_POST['rangeA']) && $_POST['rangeA']!='') && (isset($_POST['rangeB']) && $_POST['rangeB']!=''))

				 //echo $dt1;



				$setClientGoalArrco=$this->Goal->find("count",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.status"=>1,'Goal.start between ? and ?' => array($dt1, $dt2)),'order' => array('Goal.start' => 'DESC')));
				 
				// $totRec = count($setClientGoalArrco);
				 
				 //$setClientGoalArr3=$this->Goal->find("all",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.status"=>1,'Goal.start between ? and ?' => array($dt1, $dt2)),'order' => array('Goal.start' => 'ASC'),'limit'=> $rec_limit,'offset'=>$offset));
				 
				 $this->Paginator->settings = array(
        'conditions' => array("Goal.trainee_id"=>$clientid,"Goal.status"=>1,'Goal.start between ? and ?' => array($dt1, $dt2)),
        'order'=>array('Goal.start' => 'ASC'),
        'limit' => 5
    );
    $setClientGoalArr3 = $this->Paginator->paginate('Goal');

				 

			}

			else 

			{
					
			

				$setClientGoalArrco=$this->Goal->find("count",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.status"=>1),'order' => array('Goal.start' => 'DESC')));
				
				
				 $this->Paginator->settings = array(
        'conditions' => array("Goal.trainee_id"=>$clientid,"Goal.status"=>1),
        'order'=>array('Goal.start' => 'ASC'),
        'limit' => 5
    );
    $setClientGoalArr3 = $this->Paginator->paginate('Goal');
				
				
			}

			$totalGl=count($setClientGoalArr3);

			

			$jtms='';



		 	

					$cnt=1;

					$cn=1;

					if($totalGl>0){
					//$next_url=$this->here.'/page:'.$next;
					// $prev_url=$this->here.'/page:'.$prev;
						
						$showoff=0;
					
						

			      

					}

      
        

				

			



			

			if($showoff==0){

				$this->set("rst",$jtms);

				$this->set("showoff",$showoff);

			}

			else {

				$this->set("rst",'');

				$this->set("showoff",$showoff);

			}

			

		}

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	



		$surl=$this->config['url'].'home/exercise_history/'.$clientid;

			$this->set("surl",$surl);

		

		

			

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	



		$this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$uid,'Trainee.status'=>1,'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.full_name ASC'),'fields'=>array('Trainee.id','Trainee.full_name'))));

		

		

			

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);
		}

		public function exercise_history($clientid=null,$rangeA=null,$rangeB=null)
{
	$this->checkUserLogin();

	$this->layout = "homelayout";		

	$this->set("leftcheck",'exercise_history');

	$dbusertype = $this->Session->read('UTYPE');					

	$this->set("dbusertype",$dbusertype);

	$uid = $this->Session->read('USER_ID');

	if($rangeA!='' && $rangeB=='')
	{
		$this->set("selectedslt",$rangeA);
	}
	if($rangeA!='')
	{
		$this->set("selectedslt",$rangeA);
	}

	$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

	$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));

	$this->set("workoutcategory",$this->WorkoutCategory->find('all',array('conditions'=>array('WorkoutCategory.trainerId'=>$uid),'fields'=>array('WorkoutCategory.id','WorkoutCategory.name'))));

	$this->set("setSpecalistArr",$setSpecalistArr);
	
	$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
	
	$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
	
	$this->set("setSpecalistArr1",$setSpecalistArr1);

	$tgvs=0;

	$showoff=1;

	if($clientid!='')
	{
		$this->set("clientid",$clientid);
		
		$dateN=date('Y-m-d');
		
		$dateN2=date('Y-m-d',strtotime("-31 days"));

		$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));

		$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid),'order' => array('Goal.id' => 'DESC')));

		$this->set('clientGoal',$setClientGoalArr);

		$this->set('setClientArr',$setClientArr);

		$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0', 'ScheduleCalendar.status <>'=>'0'),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));
		
		$this->set('scheduleCalendars',$scheduleCalendars);

		$dt1 = date('Y-m-d h:i:s', strtotime($rangeA));

		$dt2 = date('Y-m-d h:i:s', strtotime($rangeB));

		$setClientGoalArr3=array();

		if (!empty($dt1) && $dt1!='1970-01-01 01:00:00' && (!empty($dt2) && $dt2!='1970-01-01 01:00:00')) 
		{
			$this->set("rangeA",date('m/d/Y', strtotime($rangeA)));

			$this->set("rangeB",date('m/d/Y', strtotime($rangeB)));

			$setClientGoalArrco=$this->Goal->find("count",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.status"=>1,'Goal.start between ? and ?' => array($dt1, $dt2)),'order' => array('Goal.start' => 'DESC')));

			$this->Paginator->settings = array('conditions' => array("Goal.trainee_id"=>$clientid,"Goal.status"=>1,'Goal.start between ? and ?' => array($dt1, $dt2)),'order'=>array('Goal.start' => 'DESC'),
			'limit' => 5);
			
			$setClientGoalArr3 = $this->Paginator->paginate('Goal');
		}
		else 
		{
			$setClientGoalArrco=$this->Goal->find("count",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.status"=>1),'order' => array('Goal.start' => 'DESC')));

			$this->Paginator->settings = array('conditions' => array("Goal.trainee_id"=>$clientid,"Goal.status"=>1),'order'=>array('Goal.start' => 'DESC'),'limit' => 5);
			
			$setClientGoalArr3 = $this->Paginator->paginate('Goal');
		}
		
		$totalGl=count($setClientGoalArr3);
	
		$jtms='';
		
		$cnt=1;
		
		$cn=1;
		
		if($totalGl>0)
		{
			$showoff=0;
			
			$jtms.= "<table border='1' class='newst'><tr><th></th>";

			for($tg=1;$tg<=$totalGl;$tg++)
			{
				$jtms .= " <th><input type='button' style='  height: 36px; margin: 10px 0 10px 10px; width: 93px;' class=change-pic-nav' value='Save Workout' onclick=popupOpenSW(".$setClientGoalArr3[$tgvs]['Goal']['id']."); name='submit'><br/><input type='button' style='  float: left; height: 36px; margin: 0 0 10px 10px; width: 93px;' class=change-pic-nav' value='Repeat Workout' name='submit' onclick=popupOpenRW(".$setClientGoalArr3[$tgvs]['Goal']['id'].")><br/><input type='button' style='  float: left; height: 36px; margin: 0 0 10px 10px; width: 93px;clear: both;' class=change-pic-nav' value='Edit Workout' name='submit' onclick=popupOpenEW(".$setClientGoalArr3[$tgvs]['Goal']['id'].")><br/><input type='button' style='  float: left; height: 36px; margin: 0 0 10px 10px; width: 93px;clear: both;' class=change-pic-nav' value='Delete Workout' name='submit' onclick=deletewrkt(".$setClientGoalArr3[$tgvs]['Goal']['id'].",".$setClientGoalArr3[$tgvs]['Goal']['trainee_id'].")></th>";

				$tgvs++;
			}
			
			$jtms .= " </tr>
			<tr>
				<td style='width:20%;'><b>Client: ".ucwords($setClientArr['Trainee']['full_name'])."</b></td>";
				
				foreach($setClientGoalArr3 as $setClientGoalArrsv)
				{
					$startvaldt=$setClientGoalArrsv['Goal']['start'];

					$endvaldt=$setClientGoalArrsv['Goal']['end'];

					$jtms .= "<td>".date('m/d/Y h:i A', strtotime($startvaldt))."</td> ";
				}
				
				$jtms .= "</tr><tr><td><b>Warm-Up</b></td>";

				foreach($setClientGoalArr3 as $setClientGoalArrsv)
				{
					$jtms .= "<td><table><tr><th>Sets</th><th>Dur.</th><th>Tips</th></tr></table></td>";
				}
				
				$jtms .= " </tr>";
				
				foreach($setClientGoalArr3 as $setClientGoalArrsv)
				{
					$startvaldt=$setClientGoalArrsv['Goal']['start'];
					
					$endvaldt=$setClientGoalArrsv['Goal']['end'];

					$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));
					
					if(!empty($setWarmupArr))
					{
						$showoff=0;
						
						$kh=0;
						
						foreach($setWarmupArr as $key=>$val)
						{
							$jtms .= "<tr>";
							
							$jtms .= "<td>".$val['WarmUps']['exercise']." </td>";
							
							for($kh=0;$kh<count($setClientGoalArr3);$kh++)
							{							
								if($setClientGoalArr3[$kh]['Goal']['start']==$val['WarmUps']['start'])
								{
									$jtms .= "<td><table><tr><td>".$val['WarmUps']['set']."</td><td>".$val['WarmUps']['duration']."</td><td>".$val['WarmUps']['coaching_tip']."</td></tr></table></td>";
								}else 
								{
									$jtms .= "<td></td>";
								}
							}
							
							$jtms .= "</tr>";

						 }
					}
				}
				
				$jtms .= "<tr><td><b>CORE/BALANCE/PLYOMETRIC</b></td>";
				
				foreach($setClientGoalArr3 as $setClientGoalArrsv)
				{
					$jtms .= "<td><table><tr><th>Sets</th><th>Rep.</th><th>Wt.</th><th>Rest</th><th>Tips</th></tr></table></td>";
				}
				
				$jtms .= " </tr>";
				
				foreach($setClientGoalArr3 as $setClientGoalArrsv)
				{
					$startvaldt=$setClientGoalArrsv['Goal']['start'];
					
					$endvaldt=$setClientGoalArrsv['Goal']['end'];

					$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));
					
					if(!empty($setCoreBalancePlyometricArr))
					{
						$showoff=0;
						
						foreach($setCoreBalancePlyometricArr as $key=>$val)
						{
							$jtms .= "<tr><td>".$val['CoreBalancePlyometric']['exercise']."</td>";
							
							for($kh=0;$kh<count($setClientGoalArr3);$kh++)
							{
								if($setClientGoalArr3[$kh]['Goal']['start']==$val['CoreBalancePlyometric']['start'])
								{
									$jtms .="<td><table><tr><td>".$val['CoreBalancePlyometric']['set']."</td> <td>".$val['CoreBalancePlyometric']['rep']."</td> <td>".$val['CoreBalancePlyometric']['temp']."</td><td>".$val['CoreBalancePlyometric']['rest']."</td><td>".$val['CoreBalancePlyometric']['coaching_tip']."</td></tr></table></td>";
								}else
								{
									$jtms .= "<td></td>";
								}
							}
							
							$jtms .= " </tr>";
						}
					}
				}
				
				$jtms .= " <tr><td><b>SPEED/AGILITY/QUICKNESS</b></td>";
				
				foreach($setClientGoalArr3 as $setClientGoalArrsv)
				{	
					$jtms .= "<td><table><tr><th>Sets</th><th>Rep.</th><th>Wt.</th><th>Rest</th><th>Tips</th></tr></table></td>";
				}
				
				$jtms .= " </tr>";
				
				foreach($setClientGoalArr3 as $setClientGoalArrsv)
				{
					$startvaldt=$setClientGoalArrsv['Goal']['start'];
					
					$endvaldt=$setClientGoalArrsv['Goal']['end'];
					
					$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));
					
					if(!empty($setSpeedAgilityQuicknessArr))
					{
						$showoff=0;
						
						foreach($setSpeedAgilityQuicknessArr as $key=>$val)
						{
							$jtms .= "<tr><td>".$val['SpeedAgilityQuickness']['exercise']."</td>";
							
							for($kh=0;$kh<count($setClientGoalArr3);$kh++)
							{
								if($setClientGoalArr3[$kh]['Goal']['start']==$val['SpeedAgilityQuickness']['start'])
								{
									$jtms .="<td><table><tr><td>".$val['SpeedAgilityQuickness']['set']."</td> <td>".$val['SpeedAgilityQuickness']['rep']."</td> <td>".$val['SpeedAgilityQuickness']['temp']."</td><td>".$val['SpeedAgilityQuickness']['rest']."</td><td>".$val['SpeedAgilityQuickness']['coaching_tip']."</td></tr></table></td>";
								}
								else
								{
									$jtms .= "<td></td>";
								}
							}
							$jtms .= " </tr>";
						}
					}
				}
				$jtms .= " <tr><td><b>RESISTANCE</b></td>";
				
				foreach($setClientGoalArr3 as $setClientGoalArrsv)
				{
					$jtms .= "<td><table><tr><th>Sets</th><th>Rep.</th><th>Wt.</th><th>Rest</th><th>Tips</th></tr></table></td>";
				}
				
				$jtms .= " </tr>";
				
				foreach($setClientGoalArr3 as $setClientGoalArrsv)
				{
					$startvaldt=$setClientGoalArrsv['Goal']['start'];
					
					$endvaldt=$setClientGoalArrsv['Goal']['end'];
					
					$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));
					
					if(!empty($setResistenceArr))
					{
						$showoff=0;
						
						foreach($setResistenceArr as $key=>$val)
						{
							$jtms .= "<tr><td>".$val['Resistence']['exercise']."</td>";
							
							for($kh=0;$kh<count($setClientGoalArr3);$kh++)
							{
								if($setClientGoalArr3[$kh]['Goal']['start']==$val['Resistence']['start'])
								{
									$jtms .="<td><table><tr><td>".$val['Resistence']['set']."</td> <td>".$val['Resistence']['rep']."</td> <td>".$val['Resistence']['temp']."</td><td>".$val['Resistence']['rest']."</td><td>".$val['Resistence']['coaching_tip']."</td></tr></table></td>";
								}
								else
								{
									$jtms .= "<td></td>";
								}
							}
						$jtms .= " </tr>";
					}
				}
			}
			$jtms .= "<tr><td><b>COOL - DOWN</b></td>";
			
			foreach($setClientGoalArr3 as $setClientGoalArrsv)
			{
				$jtms .= "<td><table><tr><th>Sets</th><th>Dur.</th><th>Tips</th></tr></table></td>";
			}
			
			$jtms .= " </tr>";
			
			foreach($setClientGoalArr3 as $setClientGoalArrsv)
			{
				$startvaldt=$setClientGoalArrsv['Goal']['start'];
				
				$endvaldt=$setClientGoalArrsv['Goal']['end'];
				
				$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));
				
				if(!empty($setCoolDownArr))
				{
					$showoff=0;
					
					foreach($setCoolDownArr as $key=>$val)
					{
						$jtms .= "<tr><td>".$val['CoolDown']['exercise']."</td>";
						
						for($kh=0;$kh<count($setClientGoalArr3);$kh++)
						{
							if($setClientGoalArr3[$kh]['Goal']['start']==$val['CoolDown']['start'])
							{
								$jtms .="<td><table><tr><td>".$val['CoolDown']['set']."</td> <td>".$val['CoolDown']['duration']."</td> <td>".$val['CoolDown']['coaching_tip']."</td></tr></table></td>";
							}else
							{
								$jtms .= "<td></td>";
							}
						}
						$jtms .= " </tr>";
					}
				}
			}
			$jtms .= " </table>";
		}
		$jtms12='';
		
		$jtms12 .= " <table border='1' width='100%'>
			<tr class='slectedmn'>
				<td colspan='3' class=\"th2\"><h3 style='text-align:left;float:left;'>Client Name: </h3> <span id=\"clname\" style=\"float: left; line-height: 32px;  padding: 10px 5px 5px;\">".ucwords($setClientArr['Trainee']['full_name'])."</span></td>
				<td  style=\"padding-left:220px;\"></td>
			</tr>
		</table>";	
		
		if(!empty($setClientGoalArr3))
		{	
			foreach($setClientGoalArr3 as $setClientGoalArrsv)
			{
				$startvaldt=$setClientGoalArrsv['Goal']['start'];

				$endvaldt=$setClientGoalArrsv['Goal']['end'];
				
				if($cnt!=1)
				{
					$shdate =date('Y-m-d',strtotime("-$cn days"));
				}
				
				$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));
				
				$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));
				
				$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));
				
				$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

				$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

				if(!empty($setSpeedAgilityQuicknessArr) || !empty($setWarmupArr) || !empty($setCoreBalancePlyometricArr) || !empty($setResistenceArr) || !empty($setCoolDownArr))
				{				
					$showoff=0;
					$jtms12 .= " <table border='1' width='100%'>
						<tr class='slectedmn'>
							<td colspan='3'  class=\"th2\"><h3 style='text-align:left;float:left;'>Date: </h3> <span id=\"clname\" style=\"float: left; line-height: 32px;  padding: 10px 5px 5px;\">".$startvaldt."</span>
							</td>
							<td  style=\"padding-left:10px;\"></td>
						</tr>
					</table>";
					
					if($setClientGoalArrsv['Goal']['goal']!='')
					{
						$jtms12 .= "<table width='100%' border='1'><tbody><tr class='slectedmn'><td class='th2' colspan='3'><span style='float: left;'>Goal: </span>".$setClientGoalArrsv['Goal']['goal']." </td><td> <span style='float: left; '>Phase: </span>".$setClientGoalArrsv['Goal']['phase']." </td></tr></tbody></table>";
					}
					
					if($setClientGoalArrsv['Goal']['note']!='')
					{
						$jtms12 .= "<table width='100%' border='1'><tbody><tr class='slectedmn'><td class='th2'><span style='float: left; '>Note: </span>".$setClientGoalArrsv['Goal']['note']." </td></tr></tbody></table>";
					}
					
					if($setClientGoalArr2['Goal']['alert']!='')
					{
						$jtms12 .= "<table width='100%' border='1'><tbody><tr class='slectedmn'><td class='th2'><span style='float: left; '>Alert: </span>".$setClientGoalArrsv['Goal']['alert']." </td></tr></tbody></table>";
					}
				}
				if(!empty($setWarmupArr))
				{
					$showoff=0;
					$jtms12 .= "<table border='1' width='100%' ><tr class='slectedmn'><td colspan='6' class=\"th2\"><h3 style='text-align:left;'>Warm-Up </h3></td></tr><th  class=\"throw\">Exercise</th><th  class=\"throw\">Sets</th>
					<th  class=\"throw\">Duration</th><th  class=\"throw\">Coaching Tip</th><th  class=\"throw\">Date</th><th  class=\"throw\"></th></tr>";
					
					foreach($setWarmupArr as $key=>$val)
					{
						$jtms12 .= "<tr><td>".$val['WarmUps']['exercise']."</td><td>".$val['WarmUps']['set']."</td><td>".$val['WarmUps']['duration']."</td><td>".$val['WarmUps']['coaching_tip']."</td><td>".date('Y-m-d',strtotime($startvaldt))."</td><td></td></tr>";
					}
					
					$jtms12 .= "</table> ";  
				}
				if(!empty($setCoreBalancePlyometricArr))
				{
					$showoff=0;
					
					$jtms12 .= "<table border='1' width='100%' ><tr class='slectedmn'><td colspan='8' class=\"th2\"><h3 style='text-align:left;'>CORE/BALANCE/PLYOMETRIC </h3></td></tr><th  class=\"throw\">Exercise</th><th  class=\"throw\">Sets</th><th  class=\"throw\">Reps</th><th  class=\"throw\">Weight</th><th  class=\"throw\">Rest</th><th  class=\throw\">Coaching Tip</th><th  class=\throw\">Date</th><th><th></tr>";
					
					foreach($setCoreBalancePlyometricArr as $key=>$val)
					{
						$jtms12 .= "<tr><td>".$val['CoreBalancePlyometric']['exercise']."</td><td>".$val['CoreBalancePlyometric']['set']."</td><td>".$val['CoreBalancePlyometric']['rep']."</td><td>".$val['CoreBalancePlyometric']['temp']."</td><td>".$val['CoreBalancePlyometric']['rest']."</td><td>".$val['CoreBalancePlyometric']['coaching_tip']."</td><td>".date('Y-m-d',strtotime($startvaldt))."</td><td></td></tr>";
					}		 
					
					$jtms12 .= "</table>";
				}
				
				if(!empty($setSpeedAgilityQuicknessArr))
				{
					$showoff=0;
					$jtms12 .= "<table border='1' width='100%' >
					<tr class='slectedmn'><td colspan='8' class=\"th2\"><h3 style='text-align:left;'>SPEED/AGILITY/QUICKNESS </h3></td></tr><th  class=\"throw\">Exercise</th><th  class=\"throw\">Sets</th><th class=\"throw\">Reps</th><th class=\"throw\">Weight</th><th class=\"throw\">Rest</th><th class=\"throw\">Coaching Tip</th><th class=\"throw\">Date</th><th><th></tr>";
					
					foreach($setSpeedAgilityQuicknessArr as $key=>$val)
					{	
						$jtms12 .="<tr><td>".$val['SpeedAgilityQuickness']['exercise']."</td><td>".$val['SpeedAgilityQuickness']['set']."</td><td>".$val['SpeedAgilityQuickness']['rep']."</td><td>".$val['SpeedAgilityQuickness']['temp']."</td><td>".$val['SpeedAgilityQuickness']['rest']."</td><td>".$val['SpeedAgilityQuickness']['coaching_tip']."</td><td>".date('Y-m-d',strtotime($startvaldt))."</td><td></td></tr>";
					}
					$jtms12 .= "</table>"; 
				}
				if(!empty($setResistenceArr))
				{
					$showoff=0;
					$jtms12 .= "<table border='1' width='100%' ><tr class='slectedmn'><td colspan='8' class=\"th2\"><h3 style='text-align:left;'>RESISTANCE </h3></td></tr><th  class=\"throw\">Exercise</th><th  class=\"throw\">Sets</th><th class=\"throw\">Reps</th><th class=\"throw\">Weight</th><th class=\"throw\">Rest</th><th class=\"throw\">Coaching Tip</th><th class=\"throw\">Date</th><th></th></tr>";
					
					foreach($setResistenceArr as $key=>$val)
					{
						$jtms12 .="<tr><td>".$val['Resistence']['exercise']."</td>
						<td>".$val['Resistence']['set']."</td><td>".$val['Resistence']['rep']."</td><td>".$val['Resistence']['temp']."</td><td>".$val['Resistence']['rest']."</td><td>".$val['Resistence']['coaching_tip']."</td><td>".date('Y-m-d',strtotime($startvaldt))."</td><td></td></tr>";
					}
					$jtms12 .= "</table>"; 
				}
				if(!empty($setCoolDownArr))
				{
					$showoff=0;
					
					$jtms12 .= " <table border='1' width='100%'><tr class='slectedmn'><td colspan='6' class=\"th2\"><h3 style='text-align:left;'>COOL-DOWN </h3></td></tr><th  class=\"throw\">Exercise</th><th  class=\"throw\">Sets</th><th  class=\"throw\">Duration</th><th  class=\"throw\">Coaching Tip</th><th  class=\"throw\">Date</th><th></th></tr>";
					
					foreach($setCoolDownArr as $key=>$val)
					{	
						$jtms12 .="<tr><td>".$val['CoolDown']['exercise']."</td><td>".$val['CoolDown']['set']."</td><td>".$val['CoolDown']['duration']."</td><td>".$val['CoolDown']['coaching_tip']."</td><td>".date('Y-m-d',strtotime($startvaldt))."</td><td></td></tr>";
					}
					$jtms12 .= "</table>"; 
				}
				$cnt++;
			}
		}
		$jtms12 .= "</table>";
		
		if($showoff==0)
		{
			$this->set("rst",$jtms);
			
			$this->set("showoff",$showoff);
		}
		else
		{
			$this->set("rst",'');
			
			$this->set("showoff",$showoff);
		}
	}
	
	$dbusertype = $this->Session->read('UTYPE');					
	
	$this->set("dbusertype",$dbusertype);
	
	$uid = $this->Session->read('USER_ID');	

	$surl=$this->config['url'].'home/exercise_history/'.$clientid;

	$this->set("surl",$surl);
	
	$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
	
	$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	$this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$uid,'Trainee.status'=>1,'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.full_name ASC'),'fields'=>array('Trainee.id','Trainee.full_name'))));
	
	$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
	
	$this->set("setSpecalistArr",$setSpecalistArr);
}

		

		public function exercise_viewhistory($clientid=null,$stD=null){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'exercise_history');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');

		

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));

		

		//$workData = $this->Goal->find('all',array('conditions'=>array('Goal.trainee_id'=>$clientid),'fields'=>array('Goal.start')));

		

		  $this->set("setSpecalistArr",$setSpecalistArr);
		  $club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

		  $showoff=1;

		if($clientid!='')

		{

			$this->set("clientid",$clientid);

			

			$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));

			

		

			 /*echo"<pre>";

			 print_r($_REQUEST);

			 echo"</pre>";*/

			 

				//print $days;

			if($stD!='')

			{

				

				$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.start','ScheduleCalendar.end')));

				

				$strtDt = $schcaldt['ScheduleCalendar']['start'];

				$endDt  = $schcaldt['ScheduleCalendar']['end'];

				

				$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid, "Goal.start"=>$strtDt,"Goal.end"=>$endDt),"Order"=>array("Goal.id"=>"DESC")));

				

			}

			else 

			{

				$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid),"Order"=>array("Goal.id"=>"DESC")));

				

			}

			

			/*echo"<pre>";

			 print_r($setClientGoalArr);

			 echo"</pre>";exit;*/

			

			$this->set('clientGoal',$setClientGoalArr);

			

		

			$jtms='';



		 	

					$cnt=1;

					$cn=1;

				$jtms= "

         

         <table border='1' width='100%'>

				

				<tr class='slectedmn'>

				<td colspan='3' class=\"th2\"><h3 style='text-align:left;float:left;'>Client Name: </h3> <span id=\"clname\" style=\"float: left; line-height: 32px;  padding: 10px 5px 5px;\">".ucwords($setClientArr['Trainee']['full_name'])."</span>

				</td>

				<td  style=\"padding-left:220px;\"></td>

				

				

				

				</tr>

			</table>";	

			if($stD!='')

			{

				$strtDt = $schcaldt['ScheduleCalendar']['start'];

				$endDt  = $schcaldt['ScheduleCalendar']['end'];

				

				$setClientGoalArr3=$this->Goal->find("all",array("conditions"=>array("Goal.trainee_id"=>$clientid, "Goal.start"=>$strtDt,"Goal.end"=>$endDt),'order' => array('Goal.start' => 'DESC')));

			}

			else 

			{

				$setClientGoalArr3=$this->Goal->find("all",array("conditions"=>array("Goal.trainee_id"=>$clientid),'order' => array('Goal.start' => 'DESC')));

			}

			

			

			/*echo"<pre>";

			print_r($setClientGoalArr3);

			echo"</pre>";	exit;*/

			

		if(!empty($setClientGoalArr3)){	

			

			foreach($setClientGoalArr3 as $setClientGoalArrsv)

			{

				$startvaldt=$setClientGoalArrsv['Goal']['start'];

				$endvaldt=$setClientGoalArrsv['Goal']['end'];

				

				

				if($cnt!=1)

			{

				$shdate =date('Y-m-d',strtotime("-$cn days"));

			}

			

			$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));

			

			

			

				

			$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));

			

			$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));

			

			$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

			

			 $setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

			 

			 

			

			if(!empty($setSpeedAgilityQuicknessArr) || !empty($setWarmupArr) || !empty($setCoreBalancePlyometricArr) || !empty($setResistenceArr) || !empty($setCoolDownArr)){

			 $jtms .= " <table border='1' width='100%'>

				

				<tr class='slectedmn'>

				<td colspan='3'  class=\"th2\"><h3 style='text-align:left;float:left;'>Date: </h3> <span id=\"clname\" style=\"float: left; line-height: 32px;  padding: 10px 5px 5px;\">".$startvaldt."</span>

				

				</td>

				<td  style=\"padding-left:10px;\"></td>

				

				

				

				</tr></table>";

			 

			 if($setClientGoalArrsv['Goal']['goal']!=''){

			 $jtms .= "<table width='100%' border='1'>

			<tbody><tr class='slectedmn'>

				<td class='th2' colspan='3'><span style='float: left;'>Goal: </span>".$setClientGoalArrsv['Goal']['goal']." </td><td> <span style='float: left; '>Phase: </span>".$setClientGoalArrsv['Goal']['phase']." </td>

				</tr>

			</tbody></table>";

			 

			 	

            }

            if($setClientGoalArrsv['Goal']['note']!=''){

             $jtms .= "<table width='100%' border='1'>

			<tbody><tr class='slectedmn'>

				<td class='th2'><span style='float: left; '>Note: </span>".$setClientGoalArrsv['Goal']['note']." </td>

				</tr>

			</tbody></table>";

            }

			

             if($setClientGoalArr2['Goal']['alert']!=''){

             $jtms .= "<table width='100%' border='1'>

			<tbody><tr class='slectedmn'>

				<td class='th2'><span style='float: left; '>Alert: </span>".$setClientGoalArrsv['Goal']['alert']." </td>

				</tr>

			</tbody></table>";

            }

			 

			} 

				

				

			

			

			if(!empty($setWarmupArr))

			{

			$showoff=0;

			 $jtms .= "<table border='1' width='100%' id=\"w\">

				<tr class='slectedmn'>

				<td colspan='6' class=\"th2\"><h3 style='text-align:left;'>Warm-Up </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th  class=\"throw\">Duration</th>

				<th  class=\"throw\">Coaching Tip</th>

				<th  class=\"throw\">Date</th>

				<th  class=\"throw\"></th>

				

				</tr>";

			

				foreach($setWarmupArr as $key=>$val){

					

				 $jtms .= "<tr>

	    

		     <td>".$val['WarmUps']['exercise']."</td>

		     <td>".$val['WarmUps']['set']."</td>

		     <td>".$val['WarmUps']['duration']."</td>

		     <td>".$val['WarmUps']['coaching_tip']."</td>

		     <td>".date('Y-m-d',strtotime($startvaldt))."</td>

		     <td></td>		     

		     </tr>";

				  

				}

      $jtms .= "</table> ";  

			}

			if(!empty($setCoreBalancePlyometricArr))

			{

	      $showoff=0;

     $jtms .= "<table border='1' width='100%' id=\"cbp\">

     <tr class='slectedmn'>

				<td colspan='8' class=\"th2\"><h3 style='text-align:left;'>CORE/BALANCE/PLYOMETRIC </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th  class=\"throw\">Reps</th>

				<th  class=\"throw\">Weight</th>

				<th  class=\"throw\">Rest</th>

				<th  class=\throw\">Coaching Tip</th>

				<th  class=\throw\">Date</th>

				<th><th>

				</tr>";

				

	foreach($setCoreBalancePlyometricArr as $key=>$val){			 

     $jtms .= "<tr>

	    

		     <td>".$val['CoreBalancePlyometric']['exercise']."</td>

		     <td>".$val['CoreBalancePlyometric']['set']."</td>

		     <td>".$val['CoreBalancePlyometric']['rep']."</td>

		     <td>".$val['CoreBalancePlyometric']['temp']."</td>

		     <td>".$val['CoreBalancePlyometric']['rest']."</td>

		     <td>".$val['CoreBalancePlyometric']['coaching_tip']."</td>

		     <td>".date('Y-m-d',strtotime($startvaldt))."</td>

             <td></td>		    

		          

	     

	     </tr>";

			}		 

	     

       $jtms .= "</table>";

			}

			

			

			

			

			if(!empty($setSpeedAgilityQuicknessArr))

			{

      $showoff=0;

       $jtms .= "<table border='1' width='100%' id=\"saq\">

     <tr class='slectedmn'>

				<td colspan='8' class=\"th2\"><h3 style='text-align:left;'>SPEED/AGILITY/QUICKNESS </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th class=\"throw\">Reps</th>

				<th class=\"throw\">Weight</th>

				<th class=\"throw\">Rest</th>

				<th class=\"throw\">Coaching Tip</th>

				<th class=\"throw\">Date</th>

				<th><th>

				</tr>";

		foreach($setSpeedAgilityQuicknessArr as $key=>$val){	

       	

			$jtms .="<tr>

	    

		     <td>".$val['SpeedAgilityQuickness']['exercise']."</td>

		     <td>".$val['SpeedAgilityQuickness']['set']."</td>

		     <td>".$val['SpeedAgilityQuickness']['rep']."</td>

		     <td>".$val['SpeedAgilityQuickness']['temp']."</td>

		     <td>".$val['SpeedAgilityQuickness']['rest']."</td>

		     <td>".$val['SpeedAgilityQuickness']['coaching_tip']."</td>

		     <td>".date('Y-m-d',strtotime($startvaldt))."</td>

		     <td></td>

	     

	    </tr>";

		}

      $jtms .= "</table>"; 

		}

      

			

		if(!empty($setResistenceArr))

			{

      $showoff=0;

      $jtms .= "<table border='1' width='100%' id=\"res\">

     <tr class='slectedmn'>

				<td colspan='8' class=\"th2\"><h3 style='text-align:left;'>RESISTANCE </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th class=\"throw\">Reps</th>

				<th class=\"throw\">Weight</th>

				<th class=\"throw\">Rest</th>

				<th class=\"throw\">Coaching Tip</th>

				<th class=\"throw\">Date</th>

				<th></th>

				</tr>";

				

				

	    

		    foreach($setResistenceArr as $key=>$val){	

       	

			$jtms .="<tr>

	    

		     <td>".$val['Resistence']['exercise']."</td>

		     <td>".$val['Resistence']['set']."</td>

		     <td>".$val['Resistence']['rep']."</td>

		     <td>".$val['Resistence']['temp']."</td>

		     <td>".$val['Resistence']['rest']."</td>

		     <td>".$val['Resistence']['coaching_tip']."</td>

		     <td>".date('Y-m-d',strtotime($startvaldt))."</td>

		     <td></td>

	     

	    </tr>";

		}

      $jtms .= "</table>"; 

		}



     

		if(!empty($setCoolDownArr))

			{

				$showoff=0;

     $jtms .= " <table border='1' width='100%' id=\"cd\">

				<tr class='slectedmn'>

				<td colspan='6' class=\"th2\"><h3 style='text-align:left;'>COOL-DOWN </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th  class=\"throw\">Duration</th>

				<th  class=\"throw\">Coaching Tip</th>

				<th  class=\"throw\">Date</th>

				<th></th>

				</tr>";

				

			 foreach($setCoolDownArr as $key=>$val){	

       	

			$jtms .="<tr>

	    

		     <td>".$val['CoolDown']['exercise']."</td>

		     <td>".$val['CoolDown']['set']."</td>

		     <td>".$val['CoolDown']['duration']."</td>		   

		     <td>".$val['CoolDown']['coaching_tip']."</td>

		     <td>".date('Y-m-d',strtotime($startvaldt))."</td>

		     <td></td>

	     

	    </tr>";

		}

      $jtms .= "</table>"; 

		}

				

				 $cnt++;

				

				}

		}

				 $jtms .= "</table>";

			

			if($showoff==0){

				$this->set("rst",$jtms);

				$this->set("showoff",$showoff);

			}

			else {

				$this->set("rst",'');

				$this->set("showoff",$showoff);

			}

			

		}

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	



		$surl=$this->config['url'].'home/exercise_history/'.$clientid;

			$this->set("surl",$surl);

		

		

			

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	



		$this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$uid,'Trainee.status'=>1),'fields'=>array('Trainee.id','Trainee.full_name'))));

		

		

			

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);

		

		

		}

		

		

		public function getchatuser()

		{

			$this->layout = "";

			$this->autoRender=false;

			$uid = $this->Session->read('USER_ID');

			$userfor=trim($_REQUEST['userfor']);

			if($userfor=='client')

			{

				$traineeDataArr=$this->Trainee->find('all',array('conditions'=>array('Trainee.trainer_id'=>$uid),'fields'=>array('Trainee.id','Trainee.username')));	

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

				$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$uid)));

				

				 $clubid=$setSpecalistArr['Trainer']['club_id'];

				

				 $traineeDataArr=$this->Club->find('first',array('conditions'=>array('Club.id'=>$clubid),'fields'=>array('Club.id','Club.username')));	

				 $strreturn='';

				 if(!empty($traineeDataArr))

				 {

				 	$strreturn .='<div style="clear: both; font-family: arial; width: 100%; padding: 5px; background: none repeat scroll 0px 0px rgb(204, 204, 204); border-bottom: 1px solid rgb(0, 0, 0);"><a onclick="javascript:chatWith(\''.$traineeDataArr['Club']['username'].'_Club\')" href="javascript:void(0);"><img src="'.$this->config['url'].'images/widget_online_icon.gif">'.$traineeDataArr['Club']['username'].'_Club</a></div>';

				 		

				 	

				 	echo $strreturn;

				 	exit;

				 }

				 else {

				  echo 404;	

				  exit;

				 }

				

			}

		}

		

		public function gettrainersuser()

		{

			$this->layout = "";

			$this->autoRender=false;

			$uid = $this->Session->read('USER_ID');

			$userfor=trim($_REQUEST['userfor']);

			if($userfor=='Client')

			{

				 $traineeDataArr=$this->Trainee->find('all',array('conditions'=>array('Trainee.trainer_id'=>$uid,'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.full_name ASC'),'fields'=>array('Trainee.id','Trainee.username','Trainee.full_name')));	

				  $strreturn='<option value=""> -- Select -- </option>';

				 if(!empty($traineeDataArr))

				 {

				 	for($i=0;$i<count($traineeDataArr);$i++)

				 	{

				 		$strreturn .='<option value="'.$traineeDataArr[$i]['Trainee']['id'].'">'.$traineeDataArr[$i]['Trainee']['full_name'].'</option>';

				 	}

				 	echo $strreturn;

				 	exit;

				 }

				 else {

				  echo 404;	

				  exit;

				 }

			}

			

			if($userfor=='Trainer')

			{
                    if($this->Session->read('ClubBr')!='')
		           {
		           	$uid = $this->Session->read('ClubBr');
		           	 $traineeDataArr=$this->Trainer->find('all',array('conditions'=>array('Trainer.club_branch_id'=>$uid),'fields'=>array('Trainer.id','Trainer.username','Trainer.full_name')));	
		           } else {
				 $traineeDataArr=$this->Trainer->find('all',array('conditions'=>array('Trainer.club_id'=>$uid),'fields'=>array('Trainer.id','Trainer.username','Trainer.full_name')));	
		           }

				  $strreturn='<option value=""> -- Select -- </option>';

				 if(!empty($traineeDataArr))

				 {

				 	for($i=0;$i<count($traineeDataArr);$i++)

				 	{

				 		$strreturn .='<option value="'.$traineeDataArr[$i]['Trainer']['id'].'">'.$traineeDataArr[$i]['Trainer']['full_name'].'</option>';

				 	}

				 	echo $strreturn;

				 	exit;

				 }

				 else {

				  echo 404;	

				  exit;

				 }

			}

			

			if($userfor=='Clientv')

			{

				 $traineeDataArr=$this->Trainee->find('all',array('conditions'=>array('Trainee.club_id'=>$uid,'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.full_name ASC'),'fields'=>array('Trainee.id','Trainee.username','Trainee.full_name')));	

				  $strreturn='<option value=""> -- Select -- </option>';

				 if(!empty($traineeDataArr))

				 {

				 	for($i=0;$i<count($traineeDataArr);$i++)

				 	{

				 		$strreturn .='<option value="'.$traineeDataArr[$i]['Trainee']['id'].'">'.$traineeDataArr[$i]['Trainee']['full_name'].'</option>';

				 	}

				 	echo $strreturn;

				 	exit;

				 }

				 else {

				  echo 404;	

				  exit;

				 }

			}

			

			if($userfor=='Club')

			{

				$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$uid)));

				

				 $clubid=$setSpecalistArr['Trainer']['club_id'];

				

				 $traineeDataArr=$this->Club->find('first',array('conditions'=>array('Club.id'=>$clubid),'fields'=>array('Club.id','Club.username','Club.full_name')));	

				 

				 $strreturn='<option value=""> -- Select -- </option>';

				 if(!empty($traineeDataArr))

				 {

				 	

				 		$strreturn .='<option value="'.$traineeDataArr['Club']['id'].'">'.$traineeDataArr['Club']['full_name'].'</option>';

				 	

				 	echo $strreturn;

				 	exit;

				 }

				 else {

				  echo 404;	

				  exit;

				 }

			}

		}

		

		public function postmessage()
		{	
			$this->layout = "";

			$this->autoRender=false;

			$uid = $this->Session->read('USER_ID');

			$sentfor=trim($_REQUEST['sentfor']);

			$subject=trim($_REQUEST['subject']);

			$message2=trim($_REQUEST['message']);

			$sendto=trim($_REQUEST['sendto']);
		
			$modifiedSendTo=explode(",",$sendto);
			
			/*echo "<pre>";
			print_r($modifiedSendTo);
			echo "</pre>";*/
						
			$mestype=trim($_REQUEST['mestype']);
			
			$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$uid)));
			
			foreach($modifiedSendTo as $snto)
			{
				if($sentfor=='Client')
				{
					$traineeDataArr=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>$snto),'fields'=>array('Trainee.id','Trainee.username','Trainee.email','Trainee.phone','Trainee.mobile','Trainee.first_name','Trainee.last_name')));	
	
					$to=$traineeDataArr['Trainee']['email'];
					
					$toname = $traineeDataArr['Trainee']['first_name'].$traineeDataArr['Trainee']['last_name'];
					
					$from=$setSpecalistArr['Trainer']['email'];

					$fromName=$setSpecalistArr['Trainer']['full_name'];
							
					$fromNameEmail= EMAILNAME;
				
					$fromEmail= FROM_EMAIL;
				
					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';

					if($setSpecalistArr['Trainer']['website_logo']){
						$content.='<img height="100" width="150" src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';
					}else{
						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
					}

					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td>
					
					'.$fromName.' (<a href="mailto:'.$from.'" target="_top">'.$from.'<a/>) has sent you a message.
					
					<p>'.$message2.' </p>
					
					</td></tr><tr><td><br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					$dataSet['Emessage']['sender_id']=$uid;

					$dataSet['Emessage']['sender_type']='Trainer';

					$dataSet['Emessage']['receiver_id']=$snto;

					$dataSet['Emessage']['receiver_type']=$sentfor;

					$dataSet['Emessage']['subject']=$subject;

					$dataSet['Emessage']['detail']=$message2;

					$dataSet['Emessage']['usefor']=$mestype;

					$dataSet['Emessage']['sent_date']=date('Y-m-d H:i:s');

					$msgdetail=$subject;

					if($this->Emessage->saveAll($dataSet)) {
					
						//$this->sendEmailMessage(trim($to),$subject,$content,null,null);
						$this->send_email_communication_trainer(trim($to),$toname,$subject,$content,$fromNameEmail,$fromEmail,null,null);	
						
						if($mestype=='T') {

							App::import('Vendor', 'Twilio', array('file' => 'twilio'.DS.'Services'.DS.'Twilio.php'));
							
							$account_sid = Configure::read("twilio_details.account_sid");

							$auth_token = Configure::read("twilio_details.auth_token");

							$fromno = Configure::read("twilio_details.fromno");

							$phone1=$traineeDataArr['Trainee']['mobile'];

							$client = new Services_Twilio($account_sid, $auth_token);

							if(trim($phone1)!='' && strlen(trim($phone1))>=10){

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
					}else {
						$flag_send=150;
						//echo 400;
						exit;
					}	
			    }				
		    }
			echo $flag_send;
			//exit;
			
			if($sentfor=='Club')

			{

				 $traineeDataArr=$this->Club->find('first',array('conditions'=>array('Club.id'=>$sendto),'fields'=>array('Club.id','Club.username','Club.email','Club.phone')));	

				$to=$traineeDataArr['Club']['email'];

				$from=$setSpecalistArr['Trainer']['email'];

				$fromName=$setSpecalistArr['Trainer']['full_name'];

				

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';

					if($setSpecalistArr['Trainer']['website_logo']){

					$content.='<img src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';

					}else{

						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';

					}

					

					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$traineeDataArr['Club']['username'].'!</p>

				<p> Trainer - '.$fromName.' sent message </p>

				<p>'.$message2.' </p>

				

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					

					

					$dataSet['Emessage']['sender_id']=$uid;

					$dataSet['Emessage']['sender_type']='Trainer';

					$dataSet['Emessage']['receiver_id']=$sendto;

					$dataSet['Emessage']['receiver_type']=$sentfor;

					$dataSet['Emessage']['subject']=$subject;

					$dataSet['Emessage']['detail']=$message2;

					$dataSet['Emessage']['usefor']=$mestype;

					$dataSet['Emessage']['sent_date']=date('Y-m-d H:i:s');

						$msgdetail=$subject;

						

			

						

						

						if($this->Emessage->save($dataSet))

						 {

							$this->sendEmailMessage(trim($to),$subject,$content,null,null);	

							

	if($mestype=='T')

			{

				  App::import('Vendor', 'Twilio', array('file' => 'twilio'.DS.'Services'.DS.'Twilio.php'));

$account_sid = Configure::read("twilio_details.account_sid");

$auth_token = Configure::read("twilio_details.auth_token");

$fromno = Configure::read("twilio_details.fromno");



$phone1=$traineeDataArr['Club']['phone'];

$client = new Services_Twilio($account_sid, $auth_token);



 if(trim($phone1)!='' && strlen(trim($phone1))>=10)

 {

 //exit;
$msgdetail =$msgdetail.'. This is NoReply Message.';
	try {  $sms = $client->account->sms_messages->create(

			//"+19082383840", // From this number

			"$fromno", // From this number			

			"$phone1",

			$msgdetail

			);

	    }

	catch (Services_Twilio_RestException $e) {

	//echo $e->getMessage();

	}



 }





			}

							

							echo 200;

							exit;

							

						}	

						else 

						{

						 echo 400;

							exit;

						}	

						 										

				

			}

			

			

		}

		//$this->send_email_communication_trainer(trim($to),$subject,$content,$fromName,$from,null,null);	
		public function send_email_communication_trainer($to, $toname, $subject, $message, $fromname, $from, $templete, $layout){
		$this->Email->template($templete, $layout)
		->emailFormat('html')
		->from(array("$from" => "$fromname"))
		->to(array("$to" => "$toname"))
		->subject(trim($subject))
		->replyTo(array("$from" => "$fromname"));
		if($this->Email->send($message)){
			return true;
		}else{
			return false;
		}
	}
		

		public function communication_center(){		

		//$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'communication_center');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	



	//Configure::write('debug',2);

		

     

			

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	    $this->set("degrees",$this->Degree->find('all',array('conditions'=>array('Degree.status'=>1),'fields'=>array('Degree.id','Degree.name'))));	

	    $this->set("certificationsorg",$this->CertificationOrganization->find('all',array('conditions'=>array('CertificationOrganization.status'=>1),'fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));	

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		    $this->set("setSpecalistArr",$setSpecalistArr);
			
			
			$setSpecalistArrPayment=$this->Payment->find("first",array("conditions"=>array("Payment.trainer_id"=>$uid),'order'=>array('Payment.id DESC')));

		    $this->set("setSpecalistArrPayment",$setSpecalistArrPayment);
			
			
			
			
			
			$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
			$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
			$this->set("setSpecalistArr1",$setSpecalistArr1);

		  

		  //Emessage for Mail Session

		     $this->set("emessageclientArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Client','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));	

		     

		     $this->set("emessageclientsentArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'Trainer','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));

		     

		     $this->set("emessageclubArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Trainer','OR'=>array('Emessage.sender_type'=>'Club','Emessage.sender_type'=>'ClubBranch'),'Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));

		     

		      $clientDataArr=$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$uid),'fields'=>array('Trainee.id','Trainee.full_name')));

		      $this->set("clientDataArr",$clientDataArr);

		      

		      $clubid=$setSpecalistArr['Trainer']['club_id'];

		      $clubDataArr=$this->Club->find('first',array('conditions'=>array('Club.id'=>$clubid),'fields'=>array('Club.id','Club.username','Club.email','Club.club_name')));	

		       $this->set("clubDataArr",$clubDataArr);
		       
		       if($clubid!='')
		       {
		       	 $clubBrDataArr=$this->ClubBranch->find('all',array('conditions'=>array('ClubBranch.club_id'=>$clubid),'fields'=>array('ClubBranch.id','ClubBranch.full_name','ClubBranch.website_logo','ClubBranch.logo')));	

		       $this->set("clubBrDataArr",$clubBrDataArr);
		       	
		       } else{
               $this->set("clubBrDataArr",array());
		       }

		       $this->set("emessageclubsentArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Club','Emessage.sender_type'=>'Trainer','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));

		       

		     //Emessage for Text Session   

		     

		        $this->set("emessageclientArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Client','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));	

		     

		     $this->set("emessageclientsentArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'Trainer','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));

		     

		     $this->set("emessageclubArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Club','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));

		     

		      $this->set("emessageclubsentArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Club','Emessage.sender_type'=>'Trainer','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));

		      

		      

		      $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id","fields"=>array("Trainer.full_name","Trainer.website_logo","Trainer.logo"),"conditions"=>array()))));

		      $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainee"=>array("foreignKey"=>"client_id","fields"=>array("Trainee.full_name","Trainee.photo"),"conditions"=>array()))));

		      $this->MessageBoard->recursive = 2;

		      //emessageArrIMSesTCTxt

		       $this->set("emessageArrIMSesTxt",$this->MessageBoard->find('all',array('conditions'=>array('MessageBoard.trainer_id'=>$uid,'MessageBoard.parent_message'=>0,'MessageBoard.status'=>1,'MessageBoard.client_id !='=>'0' ),'order'=>array('MessageBoard.id DESC'))));

		         $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id","fields"=>array("Trainer.full_name","Trainer.website_logo","Trainer.logo"),"conditions"=>array()))));

		      $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainee"=>array("foreignKey"=>"client_id","fields"=>array("Trainee.full_name","Trainee.photo"),"conditions"=>array()))));

		      $this->MessageBoard->recursive = 2;

		        $this->set("emessageArrIMSesTxt2",$this->MessageBoard->find('all',array('conditions'=>array('MessageBoard.trainer_id'=>$uid,'MessageBoard.parent_message >'=>0,'MessageBoard.status'=>1, 'MessageBoard.client_id !='=>'0'),'order'=>array('MessageBoard.id ASC'))));

		        

		        

		        /* for club type*/

		        

		         $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id","fields"=>array("Trainer.full_name","Trainer.website_logo","Trainer.logo"),"conditions"=>array()))));

		      $this->MessageBoard->bindModel(array("belongsTo"=>array("Club"=>array("foreignKey"=>"club_id","fields"=>array("Club.id","Club.full_name","Club.website_logo","Club.logo"),"conditions"=>array()))));

		      $this->MessageBoard->recursive = 2;

		      

		       $this->set("emessageArrIMSesTCTxt",$this->MessageBoard->find('all',array('conditions'=>array('MessageBoard.trainer_id'=>$uid,'MessageBoard.parent_message'=>0,'MessageBoard.status'=>1, 'OR'=>array('MessageBoard.club_id !='=>0,'MessageBoard.clubbranch_id !='=>0)),'order'=>array('MessageBoard.id DESC'))));

		         $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id","fields"=>array("Trainer.full_name","Trainer.website_logo","Trainer.logo"),"conditions"=>array()))));

		      $this->MessageBoard->bindModel(array("belongsTo"=>array("Club"=>array("foreignKey"=>"club_id","fields"=>array("Club.id","Club.full_name","Club.website_logo","Club.logo"),"conditions"=>array()))));

		      $this->MessageBoard->recursive = 2;

		        $this->set("emessageArrIMSesTCTxt2",$this->MessageBoard->find('all',array('conditions'=>array('MessageBoard.trainer_id'=>$uid,'MessageBoard.parent_message >'=>0,'MessageBoard.status'=>1,'OR'=>array('MessageBoard.club_id !='=>0,'MessageBoard.clubbranch_id !='=>0)),'order'=>array('MessageBoard.id ASC'))));

		        

		        

		        

		     

		

		}

		

		public function deletethrd()

		{

			$this->layout='';

			$this->autoRender=false;

			$id=trim($_POST['id']);

			

			$this->MessageBoard->id=$id;

			$data['MessageBoard']['status']=0;

			$this->MessageBoard->save($data);

			echo 'done';

		}

		

		public function viewmessage(){		

		$this->checkUserLogin();

		$this->layout = "";	

		$this->autoRender=false;	

		//echo $this->Session->read('UNAME');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	

		$id=base64_decode($_REQUEST['messageid']);

		 $sendby='';

		     $emessageclubArr=$this->Emessage->find('first',array('conditions'=>array('Emessage.id'=>$id)));

		     if($emessageclubArr['Emessage']['receiver_type']=='Client')

		     {

		     	$receiverid=$emessageclubArr['Emessage']['receiver_id'];

		        $receiverArr=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>$receiverid)));

		        $receivedby=$receiverArr['Trainee']['username'];
				$receivedto=$receiverArr['Trainee']['full_name'];

		     }

		     else 

		     {

		     	$receivertype=$emessageclubArr['Emessage']['receiver_type'];

		     	$receiverid=$emessageclubArr['Emessage']['receiver_id'];

		        $receiverArr=$this->$receivertype->find('first',array('conditions'=>array("$receivertype.id"=>$receiverid)));

		        

		        if($receivertype=='Club')

		     	$receivedby=$receiverArr['Club']['club_name'];

		     	else

		     	$receivedby=$receiverArr[$receivertype]['full_name'];
				$receivedto=$receiverArr[$receivertype]['full_name'];

		        

		     }

		     if($emessageclubArr['Emessage']['sender_type']=='Client')

		     {

		     	

		     	$senderid=$emessageclubArr['Emessage']['sender_id'];

		        $senderArr=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>$senderid)));

		        $sendby=$senderArr['Trainee']['full_name'];

		     }

		     else {

		     	$sendertype=$emessageclubArr['Emessage']['sender_type'];

		     	$sendby=$sendertype;

		     	$senderid=$emessageclubArr['Emessage']['sender_id'];

		        $senderArr=$this->$sendertype->find('first',array('conditions'=>array("$sendertype.id"=>$senderid)));

		        if($sendertype=='Club')

		     	$sendby=$senderArr['Club']['club_name'];

		     	else

		     	$sendby=$senderArr[$sendertype]['full_name'];

		     }

		     

		   echo  $message='<div style="font-weight: 700;line-height: 40px;">Subject: '.$emessageclubArr['Emessage']['subject'].'</div><div style="">Sent By: '.$sendby.', Received By :'.$receivedto.'</div><div style="font-size: 14px; line-height: 20px; padding-top: 20px;"><b>Message:</b> '.$emessageclubArr['Emessage']['detail'].'</div>';

		   exit;

		}



			public function deletemessage(){		

		$this->checkUserLogin();

		$this->layout = "";	

		$this->autoRender=false;

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	

		$id=base64_decode($_REQUEST['messageid']);

		 $emessageclubArr=$this->Emessage->find('first',array('conditions'=>array('Emessage.id'=>$id)));

		 

				 if($emessageclubArr['Emessage']['receiver_id']==$uid)

				 {

				 	$this->Emessage->id=$id;

				 	$dataAr['Emessage']['delflag_receiver']='Y';

				 	$this->Emessage->save($dataAr);

				 	echo 1;

				 	exit;

		 		    //delflag_receiver

				 }

				 else {

				 	//delflag_sender

				 	$this->Emessage->id=$id;

				 	$dataAr['Emessage']['delflag_sender']='Y';

				 	$this->Emessage->save($dataAr);

				 	echo 1;

				 	exit;

				 }

			}

			

		

		public function manage_workout(){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'manage_workout');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);	
		
		$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

		

		$workoutdata=$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid)));

			

		$this->set("workout",$workoutdata);	

			

			

		

		

		}

		

		public function addworkout(){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'manage_workout');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

	

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);
		
		$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

		  

		  if(!empty($this->data)) {

			

				$this->WorkOuts->set($this->data);

				//$this->Trainer->id = $this->data['Trainer']['id'];	

				if($this->WorkOuts->validates()) {

						

					    

					    $this->request->data["WorkOuts"]["added_date"] 		    = date("Y-m-d");

						$this->request->data["WorkOuts"]["modified_date"] 		= date("Y-m-d");

					    	//pr($this->request->data);

					    //$this->loadModel('ClubBranch');

					   

						if($this->WorkOuts->save($this->request->data)) {	

										

							$this->Session->setFlash('Workout has been created successfully.');

							$this->redirect('/home/manage_workout/');

						} else {

							$this->Session->setFlash('Some error has been occured. Please try again.');

						}

				}	

			}

		

		

		}

		

		public function editworkout($bid=null){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'manage_workout');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	

		$bid=base64_decode($bid);

		$this->set("bid",$bid);			

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

	

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);
		
		$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

		  

		  if(!empty($this->data)){

			

			$this->WorkOuts->set($this->data);

			$this->WorkOuts->id = $this->data['WorkOuts']['id'];		

			

							

			if($this->WorkOuts->validates()) {

				

				

				$this->request->data["WorkOuts"]["modified_date"] 		    = date("Y-m-d");

				$this->request->data["WorkOuts"]["trainer_id"] 		    = $uid;

				if($this->WorkOuts->save($this->data)) {

					$this->Session->setFlash('WorkOuts information has been updated successfully.');

					$this->redirect('/home/manage_workout/');

				} else {

					$this->Session->setFlash('Some error has been occured. Please try again.');

				}

			}

			else{				

				//$this->request->data["Club"]["logo"]=$this->request->data["Club"]["old_image"];				

			}				

		 } else{

				if(is_numeric($bid) && $bid > 0) {

						$this->WorkOuts->id = $bid;

						$this->request->data = $this->WorkOuts->read();

					} else {

						$this->Session->setFlash('Invalid Branch id.');

						$this->redirect('/home/manage_workout/');

				}

			}

		

		

		}

		

		public function deletworkout()

		{

			$this->layout = '';

			$this->render = false;

			if(trim($_POST['id'])!='')

			{

				$datav=array();				

				$datav['id']=trim($_POST['id']);

				if($this->WorkOuts->delete($datav)) {

							

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

		

     public function daily_nutrition_diary()

		{

			$this->layout = "homelayout";	 

		    $this->set("leftcheck",'daily_nutrition_diary');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);
			
			$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			$tranrsdata=$this->Trainee->find('all',array('conditions'=>array('Trainee.trainer_id'=>$id),'fields'=>array('Trainee.id','Trainee.username','Trainee.email')));

			 

			$this->set("nutritions",$tranrsdata);

				

			

		}

		

		public function add_daily_nutrition_diary($clientid=null,$datva=null)

		{

			$this->layout = "homelayout";	 

		    $this->set("leftcheck",'daily_nutrition_diary');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);
			
			$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
			$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
			$this->set("setSpecalistArr1",$setSpecalistArr1);
		
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			

			if($clientid!='')

			{

				$this->set("clientid",base64_decode($clientid));

			}

			$datefd='';

			if($datva!='')

			{

					

				

               $dtsv=CakeTime::format($datva, '%d-%m-%Y');

               

              // $dtsv

               $expdt2=explode("-",$datva);

               $y2=$expdt2[2];

				$m2='';

				$d2='';

				

				if($expdt2[0]<10)

				{

					$m2='0'.$expdt2[0];

				}

				else {

					$m2=$expdt2[0];

				}

				if($expdt2[1]<10)

				{

					$d2='0'.$expdt2[1];

				}

				else {

					$d2=$expdt2[1];

				}

				

				 $dtsv=$m2.'/'.$d2.'/'.$y2;

				$expdt=explode("-",$datva);

				$y1=$expdt[2];

				$m1='';

				$d1='';

				if($expdt[0]<10)

				{

					$m1='0'.$expdt[0];

				}

				else {

					$m1=$expdt[0];

				}

				if($expdt[1]<10)

				{

					$d1='0'.$expdt[1];

				}

				else {

					$d1=$expdt[1];

				}

          

			 $datefd=$y1.'-'.$m1.'-'.$d1;

			

				 

				

				$this->set("datva",$dtsv);

			}

			else {

				$dtsv=date('m/d/Y');				

				$datefd=date('Y-m-d');

				

				

				$this->set("datva",$dtsv);

			}

			$surl=$this->config['url'].'home/add_daily_nutrition_diary/'.$clientid;

			$this->set("surl",$surl);

			$clid=base64_decode($clientid);

			$this->set("client_id",$clid);

			

			$breakfast=$this->FoodNutritionLog->find("all",array("conditions"=>array("FoodNutritionLog.type"=>'Breakfast'), 'order' => array('FoodNutritionLog.id' => 'DESC')));

		 

		  $this->set("breakfasts",$breakfast);

		  

		  $this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$id,'Trainee.status'=>1),'fields'=>array('Trainee.id','Trainee.full_name'))));

		  

		  

		  $logdata=$this->AdddailyNutritionDiary->find("all",array("conditions"=>array("AdddailyNutritionDiary.client_id"=>$clid,"AdddailyNutritionDiary.trainer_id"=>$id,"AdddailyNutritionDiary.foodlogdate"=>$datefd), 'order' => array('AdddailyNutritionDiary.id' => 'DESC')));

		 

		  $this->set("logdata",$logdata);

			 

		/*  echo "<pre>";

	  print_r($logdata);

		echo "</pre>";	*/

			

			

		}

		

		public function foodlist()

		{

			 $this->layout = '';

			$this->render = false;

		 if($_POST['typefd']!='')

		 {

		 	$fdtype=$_POST['typefd'];

		 	 $response=$this->FoodNutritionLog->find("list",array("conditions"=>array("FoodNutritionLog.type"=>$fdtype), 'order' => array('FoodNutritionLog.name' => 'ASC')));

		 	 

		 	  echo json_encode($response);

				exit;

		 	

		 } else {

		 	$response=array();

		 	 echo json_encode($response);

				exit;	

		   }	

		}

		

	public function add_daily_diary()

		{

		  $this->layout = '';

			$this->autoRender = false;

			$id = $this->Session->read('USER_ID');

			//"food_type":"Breakfast","food_list":"Pasta","food_qty":"1","client_id":"2"

				$fooddata=array();

				$response=array();

				/*echo'<pre>';

				print_r($_POST);

				echo'</pre>';*/

				

				

			if( $_POST['food_type']!='' && $_POST['food_list']!='' && $_POST['food_qty']!='' && $_POST['client_id']!='' )

			{



				$fdtype=trim($_POST['food_type']);

				$fdnm='Breakfast';

				if($fdtype==1)

				{

				  $fdnm='Breakfast';	

				}

				if($fdtype==2)

				{

				  $fdnm='Lunch';	

				}

				if($fdtype==3)

				{

				  $fdnm='Dinner';	

				}

				if($fdtype==4)

				{

				  $fdnm='Snacks';	

				}

				

				$fdname=trim($_POST['food_list']);

				$fddate=trim($_POST['fooddate']);

				

				$id = $this->Session->read('USER_ID');

				

				$fooddata5=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$id)));

				

				$trainerid=$fooddata5['Trainee']['trainer_id'];

				

				$fooddata2=$this->FoodUsda->find("first",array("conditions"=>array("FoodUsda.name"=>$fdname), 'order' => array('FoodUsda.name' => 'ASC')));

				

				

				$fooddata['AdddailyNutritionDiary']['client_id']=trim($_POST['client_id']);

				$fooddata['AdddailyNutritionDiary']['trainer_id']=trim($trainerid);

				$fooddata['AdddailyNutritionDiary']['food_type']=trim($fdnm);

				$fooddata['AdddailyNutritionDiary']['food_name']=trim($fdname);

				$fooddata['AdddailyNutritionDiary']['quantity']=trim($_POST['food_qty']);

				$fooddata['AdddailyNutritionDiary']['calorie']=trim($fooddata2['FoodUsda']['energy_kcal']);

				$fooddata['AdddailyNutritionDiary']['carb']=trim($fooddata2['FoodUsda']['carbohydrt_g']);

				$fooddata['AdddailyNutritionDiary']['fat']='';

				$fooddata['AdddailyNutritionDiary']['protein']=trim($fooddata2['FoodUsda']['protein_g']);

				$fooddata['AdddailyNutritionDiary']['mineral']='';

				$fooddata['AdddailyNutritionDiary']['vitamin']='';

				$fooddata['AdddailyNutritionDiary']['status']=1;

				$fooddata['AdddailyNutritionDiary']['food_gmwt']=trim($_POST['food_gmwt']);

				$fooddata['AdddailyNutritionDiary']['foodlogdate']=date('Y-m-d', strtotime("$fddate"));

				/*

				echo '<pre>';

				  print_r($fooddata);

				echo '</pre>';

				die();*/

				

				if($this->AdddailyNutritionDiary->save($fooddata)) {

							

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have added Food log successfully.");

						}

						else {

							

							$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, please refresh the page and try again!!");

						}

			}

			

			

		echo json_encode($response);

				exit;		

		}	

		

		public function deletefood()

		{

			$this->layout = '';

			$this->render = false;

			if(trim($_POST['id'])!='')

			{

				$datav=array();				

				$datav['id']=trim($_POST['id']);

				if($this->AdddailyNutritionDiary->delete($datav)) {

							

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

		

		public function invite_new_trainee()

		{
			
		  $this->layout = '';

		  $this->render = false;

		  $idd='';

			if($this->Session->read('ClubBr')!='')

		     {

		     	 $dbusertype ='ClubBranch';					

			     $this->set("dbusertype",$dbusertype);

			     $idd = $this->Session->read('ClubBr'); 

		     }

		

		     else {

		     	

		     	 $dbusertype = $this->Session->read('UTYPE');					

			     $this->set("dbusertype",$dbusertype);

			     $id = $this->Session->read('USER_ID'); 

		     	

		     }

			     

		     	

		   

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);

		     	

		    

			

				$traineedata=array();

				$response=array();

				

			if( trim($_POST['firstname'])!='' && trim($_POST['lastname'])!='' && trim($_POST['email'])!='' )

			{

                $email=trim($_POST['email']);

                $expldv=explode("@",$email);

				//$username=trim($expldv[0]);

				$username=trim($email);

				$password=substr(md5(microtime()),rand(0,26),8);

				$first_name=trim($_POST['firstname']);

				$last_name=trim($_POST['lastname']);

				

				

				//$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));

				

			

					if(isset($_POST['club_id']) && $_POST['club_id']!='')

					{

						$traineedata['Trainee']['club_id']=trim($_POST['club_id']);

						

					}

				

				if($idd!='')

				{

				$traineedata['Trainee']['club_branch_id']=trim($idd);

			    }

               else{

               	

               	$traineedata['Trainee']['club_branch_id']='';

               

               }

			    $traineedata['Trainee']['first_name']=trim($_POST['firstname']);

			    $traineedata['Trainee']['last_name']=trim($_POST['lastname']);

			    $traineedata['Trainee']['username']=trim($username);

				$traineedata['Trainee']['password']=trim($password);

				$traineedata['Trainee']['email']=trim($_POST['email']);

				$traineedata['Trainee']['trainer_id']=trim($id);

				$traineedata['Trainee']['status']=1;
				
				$traineedata['Trainee']['first_time_login']=0;
				
				$traineedata['Trainee']['session_reminder_notification']=1;
				
				$traineedata['Trainee']['comp_session_notification']=1;

				$traineedata['Trainee']['created_date']=date('Y-m-d');

				$traineedata['Trainee']['update_date']=date('Y-m-d');
				
				if ($setSpecalistArr['Trainer']['website_logo']!='') {
				$traineedata['Trainee']['website_logo']=$setSpecalistArr['Trainer']['website_logo'];
				}

				

				

				$chktArr1=$this->Trainee->find("first",array("conditions"=>array("Trainee.username"=>trim($username))));

				$chktArr2=$this->Trainee->find("first",array("conditions"=>array("Trainee.email"=>trim($_POST['email']))));

				

				

				//if($this->Trainee->validates()) {				

		if(empty($chktArr1) && empty($chktArr2)) {				
			if($this->Trainee->save($traineedata)) {

				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';

				if($dbusertype=='Trainer' && $setSpecalistArr['Trainer']['website_logo']){
						$content.='<img width="150" height="130" src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';
				}else{
						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
				}
				
				$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.trim($_POST['firstname']).'!</p>

				<p>I am inviting you to use my training software to help us reach your fitness goals.</p>
					
				<p>Please find the link to my website and your log in credentials below.  Once you are logged in just click on the edit profile tab to:</p>	
					
				<p>1. Change your password<br />
				2. Add your picture<br />
				3. Change your cover picture<br />
				4. Fill in the empty fields.<br /> </p> 		
						
				<p>Check out the <b><a href='.$this->config['url'].'trainees/helpguide>Help Guide Videos</a></b> for more information on how the site works.  As your fitness training progresses the site will become an easy way for us to stay in touch regarding your training.  </p>
					
				<p>Below you will find your credentials for logging in:</p>

				<p>Website URL : '.$this->config['url'].'home/myprofile/'.$setSpecalistArr['Trainer']['publicproname'].' <br/>
					
				Username: '.trim($username).'<br/>

				Password: '.trim($password).'<br/>

				Usertype: Client <br/>
					
				</p>
				
				<p>I am excited to work with you!  In the meantime, let me know if you need anything.</p>
					
				</td></tr><tr><td><br/>Thanks,<br/>'.$setSpecalistArr['Trainer']['full_name'].' <br/>'.$setSpecalistArr['Trainer']['mobile'].'<br/>'.$setSpecalistArr['Trainer']['email'].'</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

				$subject = "Welcome"; 

				$from_mail = $setSpecalistArr['Trainer']['email'];
					
				$from_mail_name = $setSpecalistArr['Trainer']['full_name'];
						
				$this->sendEmailMessageTraineeInvite(trim($_POST['email']),$from_mail,$from_mail_name,$subject,$content,null,null);		

				$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have added Client successfully and Invite mail has been sent to Client.");

			}

		}else{

			$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, username or email already exist.");	
		}
				
		}else {
			$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, please fill all fields.");
		}
		
		echo json_encode($response);

		exit;		

}

		function sendEmailMessageTraineeInvite($to, $from_mail1, $from_mail_name, $subject, $message, $templete, $layout){
		$this->Email->template($templete, $layout)
		->emailFormat('html')
		->from(array(FROM_EMAIL => EMAILNAME))
		->to(trim($to))
		->subject(trim($subject))
		->replyTo(array(FROM_EMAIL => EMAILNAME));
		if($this->Email->send($message)){
			return true;
		}else{
			return false;
		}
	}

		public function exercise_library(){	

			

		

				

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'exercise_library');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	    $this->set("degrees",$this->Degree->find('all',array('conditions'=>array('Degree.status'=>1),'fields'=>array('Degree.id','Degree.name'))));	

	    $this->set("certificationsorg",$this->CertificationOrganization->find('all',array('conditions'=>array('CertificationOrganization.status'=>1),'fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));

	    	



		$this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$uid,'Trainee.status'=>1,'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.full_name ASC'),'fields'=>array('Trainee.id','Trainee.full_name'))));

	    

	    	$this->set("videos",$this->ExerciseLibrary->find('all',array('conditions'=>array('ExerciseLibrary.status'=>1),'fields'=>array('ExerciseLibrary.id','ExerciseLibrary.doc_name','ExerciseLibrary.description'))));

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		  $this->set("setSpecalistArr",$setSpecalistArr);
			
		    $club_trai_id = $setSpecalistArr['Trainer']['club_id'];
			$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
			$this->set("setSpecalistArr1",$setSpecalistArr1);
		/*echo "<pre>";
			print_r($setSpecalistArr1);
			echo "</pre>";
			
			echo "<pre>";
			print_r($setSpecalistArr);
			echo "</pre>";
		die();*/	
		

		  

		  	if(!empty($this->data))

			{

				//echo "<pre>";

			//print_r($this->data);

			

					

	$clientsemail=		$this->Trainee->find('all',array('conditions'=>array('Trainee.id'=>$this->data['CertificationTrainers']['clients'],'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.full_name ASC'),'fields'=>array('Trainee.email')));

	

	$videoslink=$this->ExerciseLibrary->find('all',array('conditions'=>array('ExerciseLibrary.id'=>$this->data['CertificationTrainers']['vidid']),'fields'=>array('ExerciseLibrary.doc_name','ExerciseLibrary.id')));

			

		/*echo "<pre>";

			print_r($clientsemail);

			

			print_r($videoslink);

			die();*/

		

		foreach($videoslink as $vids)

		

		{

			$videosmaillink.='<p>'.trim($vids['ExerciseLibrary']['doc_name']).'<br/>

			<a href='.$this->config['url'].'librarys/viewvideo/'.base64_encode($vids['ExerciseLibrary']['id']).' target="_blank">Click to view</a></p>';

		}

		

			foreach($clientsemail as $details)

			{

				if($details['Trainee']['email']!='')

				{

					

					

							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';

							

								

								if($dbusertype=='Trainer' && $setSpecalistArr['Trainer']['website_logo']){

					$content.='<img src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';

					}else{

						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';

					}

							

							

							$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello!</p>

				

				<p>'.$this->data['CertificationTrainers']['message'].'</p>';

							

					$content .=$videosmaillink;	

				$content .='</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = $this->config["base_title"]." : Videos Links"; 

						  

						

							

								

								$this->sendEmailMessage(trim($details['Trainee']['email']),$subject,$content,null,null);	

					

					

					

					

					

				}

			}

			

			$this->Session->setFlash('Emails has been sent successfully.');

					$this->redirect('');

			

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
				
		$this->set("videos",$this->HelpGuide->find('all',array('conditions'=>array('HelpGuide.user_type'=>array("Trainer","All")),'fields'=>array('HelpGuide.id','HelpGuide.doc_name','HelpGuide.description','HelpGuide.user_type'))));
		
		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);
		
		$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
			
		$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
		
		$this->set("setSpecalistArr1",$setSpecalistArr1);
			
		/*echo "<pre>";
			print_r($setSpecalistArr1);
			echo "</pre>";
			
			echo "<pre>";
			print_r($setSpecalistArr);
			echo "</pre>";
		die();*/
	
}
		
		
		
		
		
		

		

		public function fitness_testing(){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'fitness_testing');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	    $this->set("degrees",$this->Degree->find('all',array('conditions'=>array('Degree.status'=>1),'fields'=>array('Degree.id','Degree.name'))));	

	    $this->set("certificationsorg",$this->CertificationOrganization->find('all',array('conditions'=>array('CertificationOrganization.status'=>1),'fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));	

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		  $this->set("setSpecalistArr",$setSpecalistArr);
		  
		  $club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

		

		

		}

		

		public function business_management(){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'business_management');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	    $this->set("degrees",$this->Degree->find('all',array('conditions'=>array('Degree.status'=>1),'fields'=>array('Degree.id','Degree.name'))));	

	    $this->set("certificationsorg",$this->CertificationOrganization->find('all',array('conditions'=>array('CertificationOrganization.status'=>1),'fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));	

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		  $this->set("setSpecalistArr",$setSpecalistArr);
$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);
		

		

		}

		

		

		

		

		function listtrainees()

		{

			

			//echo "list"; die();

			

			$this->layout = '';

			$this->render = false;

			if($this->data)

			{

			 	$array = $_POST['trainee']; 



				

				$response=$this->ExerciseHistorys->find("all",array("conditions"=>array("ExerciseHistorys.trainee_id"=>$array), 'order' => array('ExerciseHistorys.id' => 'DESC')));

				

				

				

				if(!empty($response))

				{

					$cnt=1;

				echo "<table border='1' width='100%'>

				

				<tr class='slectedmn'>

				<th colspan='7'><h3 style='text-align:center;'>Exercise History</h3></th>

				</tr>

				<tr>

				<th>S.No.</th>

				<th>Exercise Name</th>

				<th>Sets</th>

				<th>Reps</th>

				<th>Weight</th>

				<th>Note</th>

				<th>Added Date</th>

				</tr>";

				}

				foreach($response as $res)

				{

					

					echo "<tr><td>".$cnt."</td>";

					echo "<td>".$res[ExerciseHistorys]['exercise_name']."</td>";

					echo "<td>".$res[ExerciseHistorys]['set']."</td>";

					echo "<td>".$res[ExerciseHistorys]['rep']."</td>";

					echo "<td>".$res[ExerciseHistorys]['weight']."</td>";

					echo "<td>".$res[ExerciseHistorys]['note']."</td>";

					echo "<td>".date('l jS  F Y',strtotime($res[ExerciseHistorys]['added_date']))."</td>"; 

					

				 echo "</tr>";

				 $cnt++;

				};

				

				echo "</table>";

				//header('content-type: application/javascript;');

				json_encode($response);

				exit;

			 			



			}

            else {

		 	$response=array();

		 	 echo json_encode($response);

				exit;	

		   }

			

			

			

		}

		

		public function add_exercise_history()

		{

		  $this->layout = '';

			$this->render = false;

			$id = $this->Session->read('USER_ID');

			

				//$exercisedata=array();

				$response=array();

				

				$exe1Count = count($_POST['nplayexercise']); 

				 $exerciseCount1 = count($_POST['nplay1exercise']);

				 $exerciseCount2 = count($_POST['nplay2exercise']);

				 $exerciseCount3 = count($_POST['nplay3exercise']);

				 $exerciseCount4 = count($_POST['nplay4exercise']);

				 

				 $ScheduleCalendarid=trim($_POST['sessType']);

				

				 $checkCalArr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.id"=>$ScheduleCalendarid)));

				 

				 

				

				 

				 $startDate=$checkCalArr['ScheduleCalendar']['start'];

				 $endDate=$checkCalArr['ScheduleCalendar']['end'];

				

				

				 

			/*	 echo $selectedTime = "9:15:00";

$endTime = strtotime("+15 minutes", strtotime($selectedTime));

echo date('h:i:s', $endTime);*/

//die('here');

				 

				//echo $_POST['nplayexercise'][0];

			       $goalArr=array();

					$goalArr['Goal']['goal']=trim($_POST['goal']);

					$goalArr['Goal']['phase']=trim($_POST['phase']);

					$goalArr['Goal']['note']=trim($_POST['note']);

					$goalArr['Goal']['alert']=trim($_POST['alert']);

					$goalArr['Goal']['trainer_id']=trim($_POST['trainer_id']);

					$goalArr['Goal']['trainee_id']=trim($_POST['trainee_id']);

					$goalArr['Goal']['added_date']=date('Y-m-d H:i:s');

					$goalArr['Goal']['modified_date']=date('Y-m-d H:i:s');

					$goalArr['Goal']['start']=$startDate;

					$goalArr['Goal']['end']=$endDate;

					

					

					

			$checkCalArr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.trainer_id"=>$_POST['trainer_id'],'ScheduleCalendar.trainee_id'=>$_POST['trainee_id'],'ScheduleCalendar.start'=>$startDate)));

			       $this->ScheduleCalendar->id=$ScheduleCalendarid;

			        $data=array();

					$this->request->data['ScheduleCalendar']['mapwrkt']=1;

					

								    	

						$this->ScheduleCalendar->save($this->data['ScheduleCalendar']);

										

					

					$this->Goal->save($goalArr);

					

				for($i=0;$i<$exe1Count;$i++)

				{

					

					$exercisedata['WarmUps']['trainer_id']=trim($_POST['trainer_id']);

				    $exercisedata['WarmUps']['trainee_id']=trim($_POST['trainee_id']);

					$exercisedata['WarmUps']['exercise']=trim($_POST['nplayexercise'][$i]);

					$exercisedata['WarmUps']['set']=trim($_POST['nplayset'][$i]);

					$exercisedata['WarmUps']['duration']=trim($_POST['nplayduration'][$i]);

					$exercisedata['WarmUps']['coaching_tip']=trim($_POST['nplaycoaching_tip'][$i]);

					//$exercisedata['WarmUps']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));
					
					$exercisedata['WarmUps']['added_date']=date('Y-m-d H:i:s');
					
					

					$exercisedata['WarmUps']['start']=$startDate;

					$exercisedata['WarmUps']['end']=$endDate;

					

					

					if($exercisedata['WarmUps']['exercise']!='') {

						

						$this->WarmUps->saveAll($exercisedata);

						

					}

					

				}



				

				

				for($i=0;$i<$exerciseCount1;$i++)

				{

					

					$exercisedata1['CoreBalancePlyometric']['trainer_id']=trim($_POST['trainer_id']);

				    $exercisedata1['CoreBalancePlyometric']['trainee_id']=trim($_POST['trainee_id']);

					$exercisedata1['CoreBalancePlyometric']['exercise']=trim($_POST['nplay1exercise'][$i]);

					$exercisedata1['CoreBalancePlyometric']['set']=trim($_POST['nplay1set'][$i]);

					$exercisedata1['CoreBalancePlyometric']['rep']=trim($_POST['nplay1rep'][$i]);

					$exercisedata1['CoreBalancePlyometric']['rest']=trim($_POST['nplay1rest'][$i]);

					$exercisedata1['CoreBalancePlyometric']['temp']=trim($_POST['nplay1temp'][$i]);

					$exercisedata1['CoreBalancePlyometric']['coaching_tip']=trim($_POST['nplay1coaching_tip'][$i]);

					//$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));
					
					$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d h:i:s');

					$exercisedata1['CoreBalancePlyometric']['start']=$startDate;

					$exercisedata1['CoreBalancePlyometric']['end']=$endDate;

					

					

					if($exercisedata1['CoreBalancePlyometric']['exercise']!='') {

						

						$this->CoreBalancePlyometric->saveAll($exercisedata1);

						

					}

					



				}

				

			

				for($i=0;$i<$exerciseCount2;$i++)

				{

					

					$exercisedata2['SpeedAgilityQuickness']['trainer_id']=trim($_POST['trainer_id']);

				    $exercisedata2['SpeedAgilityQuickness']['trainee_id']=trim($_POST['trainee_id']);

					$exercisedata2['SpeedAgilityQuickness']['exercise']=trim($_POST['nplay2exercise'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['set']=trim($_POST['nplay2set'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['rep']=trim($_POST['nplay2rep'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['rest']=trim($_POST['nplay2rest'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['temp']=trim($_POST['nplay2temp'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['coaching_tip']=trim($_POST['nplay2coaching_tip'][$i]);

					//$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));
					
					$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d H:i:s');

					$exercisedata2['SpeedAgilityQuickness']['start']=$startDate;

					$exercisedata2['SpeedAgilityQuickness']['end']=$endDate;

					

					

					if($exercisedata2['SpeedAgilityQuickness']['exercise']!='') {

						

						$this->SpeedAgilityQuickness->saveAll($exercisedata2);

						

					}

					



				}

				

				for($i=0;$i<$exerciseCount3;$i++)

				{

					

					$exercisedata3['Resistence']['trainer_id']=trim($_POST['trainer_id']);

				    $exercisedata3['Resistence']['trainee_id']=trim($_POST['trainee_id']);

					$exercisedata3['Resistence']['exercise']=trim($_POST['nplay3exercise'][$i]);

					$exercisedata3['Resistence']['set']=trim($_POST['nplay3set'][$i]);

					$exercisedata3['Resistence']['rep']=trim($_POST['nplay3rep'][$i]);

					$exercisedata3['Resistence']['rest']=trim($_POST['nplay3rest'][$i]);

					$exercisedata3['Resistence']['temp']=trim($_POST['nplay3temp'][$i]);

					$exercisedata3['Resistence']['coaching_tip']=trim($_POST['nplay3coaching_tip'][$i]);

					//$exercisedata3['Resistence']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));
					
					$exercisedata3['Resistence']['added_date']=date('Y-m-d h:i:s');

					$exercisedata3['Resistence']['start']=$startDate;

					$exercisedata3['Resistence']['end']=$endDate;

					

					

					if($exercisedata3['Resistence']['exercise']!='') {

						

						$this->Resistence->saveAll($exercisedata3);

						

					}

					



				}

				

				for($i=0;$i<$exerciseCount4;$i++)

				{

					

					$exercisedata4['CoolDown']['trainer_id']=trim($_POST['trainer_id']);

				    $exercisedata4['CoolDown']['trainee_id']=trim($_POST['trainee_id']);

					$exercisedata4['CoolDown']['exercise']=trim($_POST['nplay4exercise'][$i]);

					$exercisedata4['CoolDown']['set']=trim($_POST['nplay4set'][$i]);

					$exercisedata4['CoolDown']['duration']=trim($_POST['nplay4duration'][$i]);

					$exercisedata4['CoolDown']['coaching_tip']=trim($_POST['nplay4coaching_tip'][$i]);

					//$exercisedata4['CoolDown']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));
					
					$exercisedata4['CoolDown']['added_date']=date('Y-m-d h:i:s');

					$exercisedata4['CoolDown']['start']=$startDate;

					$exercisedata4['CoolDown']['end']=$endDate;

					

					

					if($exercisedata4['CoolDown']['exercise']!='') {

						

						$this->CoolDown->saveAll($exercisedata4);

						

					}

					



				}

				


                      $rddate=date('Y-m-d',strtotime($endDate));
							

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>$rddate);

						

			

		  

			

		echo json_encode($response);

				exit;		

		}

		

		

		

		

		public function userfbstatus()

		{	

			$this->layout = "ajax";

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$uid = $this->Session->read('USER_ID');

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

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$uid = $this->Session->read('USER_ID');

			$id=$_POST['id'];

			$setArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setArr",$setArr);

		}

		

		

	   public function uploadpic()
		{
			$this->checkUserLogin();
		    $this->layout = "homelayout";	
			$dbusertype = $this->Session->read('UTYPE');					
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('USER_ID');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
		    $this->set("setSpecalistArr",$setSpecalistArr);
		    if(!empty($this->data)){
				$this->Trainer->set($this->data);
				$this->Trainer->id = $id;
				if(!empty($this->request->data["Trainer"]["logo"]["name"]))	{
					$filename = $this->request->data["Trainer"]["logo"]["name"];
					$target = $this->config["upload_path"];
					$this->Upload->upload($this->data["Trainer"]["logo"], $target, null, null);
  					$this->request->data["Trainer"]["logo"] = $this->Upload->result; 
  					$picPath = $this->config["upload_path"].$this->request->data["Trainer"]["old_image"];
					@unlink($picPath);
					$this->request->data["Trainer"]["modified_date"] = date("Y-m-d");
					$this->request->data["Trainer"]["id"] = $id;
					if($this->Trainer->save($this->data)) {
						$this->Session->setFlash('Trainer information has been updated successfully.');
						$this->redirect($_SERVER["HTTP_REFERER"]);	
					}else {
						$this->Session->setFlash('Some error has been occured. Please try again.');
						$this->redirect($_SERVER["HTTP_REFERER"]);	
					}

				}
				else {
					$this->Session->setFlash('Pic is too large. Please try again with low resolution pic.');
					$this->redirect($_SERVER["HTTP_REFERER"]);	
				}
		    }
		    else{
		    	$this->Session->setFlash('Pic is too large. Please try again with low resolution pic.');
			}
		    $this->redirect($_SERVER["HTTP_REFERER"]);	
		}

		

		   public function coverpic()

		{

			$this->checkUserLogin();

		    $this->layout = "homelayout";	

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);

		    

		    if(!empty($this->data)){

		    $this->$dbusertype->set($this->data);

			$this->$dbusertype->id = $id;	

			

			  if(!empty($this->request->data["$dbusertype"]["cpic"]["name"]))

				{

					$filename = $this->request->data["$dbusertype"]["cpic"]["name"];

					$target = $this->config["upload_path"];

					$this->Upload->upload($this->data["$dbusertype"]["cpic"], $target, null, null);

  					$this->request->data["$dbusertype"]["cpic"] = $this->Upload->result; 

  					$picPath = $this->config["upload_path"].$this->request->data["$dbusertype"]["old_covimage"];

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

		

	  public function forgotpassword()

		{

			$this->autoRender=false;

			$response=array();



			//pr($this->request->data);

			//die('Here');

			if(!empty($this->request->data)){

			

				$useremail=trim($_POST['email']);

				$usertype=trim($_POST['user_type']);

				

				$condition= array('email'=>$useremail,'status'=>'1');	

							

				

				  $dbusertype =$usertype;					  				

				

			 	

				$data_array = $this->$dbusertype->find('first',array('conditions'=>$condition));

				if(!empty($data_array))

				{

					$usernm=$data_array[$dbusertype]['first_name'];

					$usernme=$data_array[$dbusertype]['username'];

					$usernpw=$data_array[$dbusertype]['password'];

					$to=$useremail;

				

				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';

				

								

								if($dbusertype=='Trainer' && $data_array['Trainer']['logo']){

					$content.='<img src="'.$this->config['url'].'uploads/'.$data_array['Trainer']['logo'].'"/>';

					}else{

						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';

					}

							

				$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$usernm.'!</p>

				<p>'.$usernm.' '.$this->config["base_title"].' Credential given below. </p>

				

				<p>Username : '.$usernme.'</p>

				<p>Password : '.$usernpw.'</p>

				<p>User Type : '.$dbusertype.'</p>

				<p>Email : '.trim($_POST['email']).'</p>';

				

				

				$content .= '</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

									

							

							

													 

							$subject = $this->config["base_title"]." : Credential Recovery"; 

						  

							

				

				$this->sendEmailMessage($to,$subject,$content,null,null);

									echo 'Your credential has been sent you your registered email address.';

					

					}

					else {

					echo 'Sorry, you email address not valid. Please re-enter email address and select your user type.';

					}

				}

				else {

					echo 'Please Enter Valid Data.';

				}

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
		  $club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));	

			

			$this->set("cert_org",$this->CertificationOrganization->find('list',array('fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));

			$this->set("certifications",$this->Certification->find('list',array('fields'=>array('Certification.id','Certification.course'))));

			

			$this->set("degrees",$this->Degree->find('list',array('fields'=>array('Degree.id','Degree.name'))));

			

			if(!empty($this->data)){

			

			$this->Trainer->set($this->data);

			$this->Trainer->id = $this->data['Trainer']['id'];		

			

							

			if($this->Trainer->validates()) {

				

				if(!empty($this->request->data["Trainer"]["website_logo"]["name"]))

				{

					$filename = $this->request->data["Trainer"]["website_logo"]["name"];

					$target = $this->config["upload_path"];

					$this->Upload->upload($this->data["Trainer"]["website_logo"], $target, null, null);

  					$this->request->data["Trainer"]["website_logo"] = $this->Upload->result; 

  					$picPath = $this->config["upload_path"].$this->request->data["Trainer"]["old_image"];

					@unlink($picPath);

				}else{	

					

					if(!empty($this->request->data["Trainer"]["old_image"])){

						$this->request->data["Trainer"]["website_logo"] = $this->request->data["Trainer"]["old_image"];			

					}

					else{

						$this->request->data["Trainer"]["website_logo"] = "";

					}

				}

				$this->request->data["Trainer"]["username"] 		    = $this->data["Trainer"]["email"];

				$this->request->data["Trainer"]["modified_date"] 		    = date("Y-m-d");

				if($this->Trainer->save($this->data)) {

					$this->Session->setFlash('Trainer information has been updated successfully.');

					$this->redirect('/home/index/');

				} else {

					$this->Session->setFlash('Some error has been occured. Please try again.');

				}

			}

			else{				

				$this->request->data["Trainer"]["website_logo"]=$this->request->data["Trainer"]["old_image"];				

			}				

		 } else{

				if(is_numeric($id) && $id > 0) {

						$this->Trainer->id = $id;

						$this->request->data = $this->Trainer->read();

					} else {

						$this->Session->setFlash('Invalid Trainer id.');

						$this->redirect('/home/index/');

				}

			}

			

		}
		
		public function changepass()

		{
		    $this->layout = "homelayout";
		    $this->set("leftcheck",'editprofile');
			$dbusertype = $this->Session->read('UTYPE');
			$this->set("dbusertype",$dbusertype);
			$id = $this->Session->read('USER_ID');
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));
			$this->set("setSpecalistArr",$setSpecalistArr);
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

			
			$this->Trainer->set($this->data);
			$this->Trainer->id = $this->data['Trainer']['id'];	
			$orig_pass = $this->Trainer->data['Trainer']['originalpassword'];
			$oldpassuser = $this->Trainer->data['Trainer']['oldpassword'];
			$new_pass = $this->Trainer->data['Trainer']['newpassword'];
			$conf_pass = $this->Trainer->data['Trainer']['conpassword'];
			
			
				 if( ($orig_pass==$oldpassuser) && ($new_pass==$conf_pass) )
					{
					$this->Trainer->query("update trainers set password = '".$new_pass."' where id='".$id."'");
					$this->Session->setFlash('Password updated successfully.');		
					$this->redirect('/home/index/');
					}
				else if($orig_pass!=$oldpassuser)
					{
						$this->Session->setFlash('Old Password is Incorrect.');
						$this->redirect('/home/editprofile/');
					}
				else if($new_pass!=$conf_pass)
					{
						$this->Session->setFlash('New Password and Confirm password not Match.');
						$this->redirect('/home/editprofile/');
					}
				else
				{
					$this->Session->setFlash('Some error.');
					$this->redirect('/home/editprofile/');
				}
		}



		

		public function addcertification_trainer()

		{

			$this->layout = "homelayout";	

		    $this->set("leftcheck",'homeindex');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);
			
			$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
			
			$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
			
			$this->set("setSpecalistArr1",$setSpecalistArr1);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			

						

			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));	

			

			$this->set("cert_org",$this->CertificationOrganization->find('list',array('fields'=>array('CertificationOrganization.name','CertificationOrganization.name'),'order'=>array('CertificationOrganization.name ASC'))));

			

			

			

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

										

							$this->Session->setFlash('Branch has been created successfully.');

							$this->redirect('/home/manage_certifications/');

						} else {

							$this->Session->setFlash('Some error has been occured. Please try again.');

						}

				}	

			}

			

		}

		

		public function manage_certifications()

		{

			

			$this->layout = "homelayout";	

		    $this->set("leftcheck",'homeindex');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);
			
			$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			//$tranrsdata=$this->Certification->find('all',array('conditions'=>array('Certification.id'=>$id)));

			$tranrsdata=$this->CertificationTrainers->find('all',array('conditions'=>array('CertificationTrainers.trainer_id'=>$id)));

			

			

			

			$this->set("certifications",$tranrsdata);

				

			

		}

		

		public function deletecertifytrainer()

		{

			$this->layout = '';

			$this->render = false;

			if(trim($_POST['id'])!='')

			{

				$datav=array();				

				$datav['id']=trim($_POST['id']);

				if($this->CertificationTrainers->delete($datav)) {

							

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
		
		
		public function cancelmyaccount()
		{	
			$this->layout = '';

			$this->render = false;

			if(trim($_POST['id'])!='')
			{
				$datav=array();				

				$datav['id']=trim($_POST['id']);
				
				$trainerdata=$this->Trainer->find('first',array('conditions'=>array('Trainer.id'=>$_POST['id']),'fields'=>array('Trainer.id','Trainer.first_name','Trainer.last_name','Trainer.phone','Trainer.email','Trainer.club_id')));
				
				$this->set("trainerdata",$trainerdata);
				
				$club_check = $trainerdata['Trainer']['club_id'];
				
				$trainerclubdata=$this->Club->find('first',array('conditions'=>array('Club.id'=>$club_check),'fields'=>array('Club.id','Club.first_name','Club.last_name','Club.club_name','Club.email','Club.phone')));
				
				$this->set("trainerclubdata",$trainerclubdata);
			
				
				/*echo $trainerdata['Trainer']['email'];
				echo $trainerdata['Trainer']['first_name'];
				echo $trainerdata['Trainer']['last_name'];
				echo $trainerdata['Trainer']['phone'];
				echo $trainerdata['Trainer']['club_id'];
				echo "<pre>";
				print_r($trainerdata);
				echo "</pre>";
				die();*/
				
				$this->Trainer->query("update trainers set status=0 where id='".$datav['id']."'");
				
				$this->send_cancel_account_mail_admin($trainerdata['Trainer']['email'],$trainerdata['Trainer']['first_name'],$trainerdata['Trainer']['last_name'],$trainerdata['Trainer']['phone'],$trainerclubdata['Club']['club_name']);
				
				/*if($club_check != '')
				{
					$this->send_cancel_account_mail_club($trainerdata['Trainer']['email'],$trainerdata['Trainer']['first_name'],$trainerdata['Trainer']['last_name'],$trainerdata['Trainer']['phone'],$trainerclubdata['Club']['club_name'],$trainerclubdata['Club']['email']);
				}*/
				
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
	   
	   function send_cancel_account_mail_admin($to,$to_fname,$to_lname,$to_phone,$to_club) {
		$to_admin = "registration@ptpfitpro.com";
		//$to_admin = "synapseindia8@gmail.com";
		App::uses('CakeEmail', 'Network/Email');		
		$email = new CakeEmail();		
		$email->emailFormat('html');
				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello  Admin!</p>
				<p>A Trainer has cancel his/her account.</p>				
				<p>Please find details below</p>
				
				<p>Trainer Name: '.$to_fname.'</p>
				<p>Trainer Email: '.$to.'</p>
				<p>Trainer Phone: '.$to_phone.'</p>
									
				</td></tr><tr><td><br/>Thanks,<br/>Fitness Team<br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(FROM_EMAIL => EMAILNAME));
		$email->to($to_admin);			
		$subtxt = __('Trainer Cancel Account Notification');
		$email->subject($subtxt);
		$email->send($content);
	}
	/*function send_cancel_account_mail_club($to,$to_fname,$to_lname,$to_phone,$to_club,$to_club_email) {		
		App::uses('CakeEmail', 'Network/Email');		
		$email = new CakeEmail();		
		$email->emailFormat('html');
				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello  Admin!</p>
				<p>A Trainer has cancel his/her account.</p>				
				<p>Please find details below</p>
				
				<p>Trainer Name: '.$to_fname.'</p>
				<p>Trainer Email: '.$to.'</p>
				<p>Trainer Phone: '.$to_phone.'</p>
				<p>Trainer Club: '.$to_club.'</p>
					
				</td></tr><tr><td><br/>Thanks,<br/>Fitness Team<br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(FROM_EMAIL => EMAILNAME));
		$email->to($to_club_email);			
		$subtxt = __('Trainer Cancel Account Notification');
		$email->subject($subtxt);
		$email->send($content);
	}*/
	
	
		
		
		

		public function manage_clients()

		{

			 $this->layout = "homelayout";	

		    $this->set("leftcheck",'homemy_clients');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setSpecalistArr",$setSpecalistArr);
		  $club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			$tranrsdata=$this->Trainee->find('all',array('conditions'=>array('Trainee.trainer_id'=>$id),'order'=>array('Trainee.last_name ASC'),'fields'=>array('Trainee.id','Trainee.full_name','Trainee.address','Trainee.email','Trainee.trainer_setstatus','Trainee.session_reminder_notification','Trainee.comp_session_notification')));

			

			

			$this->set("trainees",$tranrsdata);

				

			

		}
		
		public function active_clients()

		{

			 $this->layout = "homelayout";	

		    $this->set("leftcheck",'homemy_clients');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setSpecalistArr",$setSpecalistArr);
		  
		  $club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			$tranrsdata=$this->Trainee->find('all',array('conditions'=>array('Trainee.trainer_id'=>$id,'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.last_name ASC'),'fields'=>array('Trainee.id','Trainee.full_name','Trainee.address','Trainee.email','Trainee.trainer_setstatus','Trainee.session_reminder_notification','Trainee.comp_session_notification')));
			
			

			

			

			$this->set("trainees",$tranrsdata);

				

			

		}
		
		public function in_active_clients()

		{

			 $this->layout = "homelayout";	

		    $this->set("leftcheck",'homemy_clients');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setSpecalistArr",$setSpecalistArr);
		  
		  $club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			$tranrsdata=$this->Trainee->find('all',array('conditions'=>array('Trainee.trainer_id'=>$id,'Trainee.trainer_setstatus'=>0),'order'=>array('Trainee.last_name ASC'),'fields'=>array('Trainee.id','Trainee.full_name','Trainee.address','Trainee.email','Trainee.trainer_setstatus','Trainee.session_reminder_notification','Trainee.comp_session_notification')));

			

			

			$this->set("trainees",$tranrsdata);

				

			

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
				$datav['trainer_setstatus']=trim($_POST['st']);
				if($this->Trainee->save($datav)) {
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
		
		
		public function sendlogins()
		{
			$this->layout = '';
			
			$this->render = false;
			
			$response = array();
			
			if($this->Session->read('ClubBr')!='')
		    {
		    	 $dbusertype ='ClubBranch';					
			     $this->set("dbusertype",$dbusertype);
			     $idd = $this->Session->read('ClubBr'); 
			}
			else 
			{
				$dbusertype = $this->Session->read('UTYPE');					

				$this->set("dbusertype",$dbusertype);	

				$id = $this->Session->read('USER_ID');      	
		     }
			 
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);
				
			/*echo "<pre>";
			print_r($setSpecalistArr);
			echo "</pre>";*/
			
			if(trim($_POST['id'])!='')
			{
				$datav=array();				

				$datav['id']=trim($_POST['id']);
				
				$clientdata=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>$datav['id']),'fields'=>array('Trainee.id','Trainee.full_name','Trainee.address','Trainee.email','Trainee.username','Trainee.password','Trainee.trainer_setstatus','Trainee.session_reminder_notification','Trainee.comp_session_notification')));
				
				$this->set("clientdata",$clientdata);
				
				/*echo "<pre>";
				print_r($clientdata);
				echo "</pre>";
				echo $clientdata['Trainee']['email'];
				die();*/
				
				/* MAIL CONTENT */
				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';

				if($dbusertype=='Trainer' && $setSpecalistArr['Trainer']['website_logo']){
						$content.='<img width="150" height="130" src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';
				}else{
						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
				}
				
				$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$clientdata['Trainee']['full_name'].'!</p>

				<p>I am inviting you to use my training software to help us reach your fitness goals.</p>
					
				<p>Please find the link to my website and your log in credentials below.  Once you are logged in just click on the edit profile tab to:</p>	
					
				<p>1. Change your password<br />
				2. Add your picture<br />
				3. Change your cover picture<br />
				4. Fill in the empty fields.<br /> </p> 		
						
				<p>Check out the <b><a href='.$this->config['url'].'trainees/helpguide>Help Guide Videos</a></b> for more information on how the site works.  As your fitness training progresses the site will become an easy way for us to stay in touch regarding your training.  </p>
					
				<p>Below you will find your credentials for logging in:</p>

				<p>Website URL : '.$this->config['url'].'home/myprofile/'.$setSpecalistArr['Trainer']['publicproname'].' <br/>
					
				Username: '.$clientdata['Trainee']['username'].'<br/>

				Password: '.$clientdata['Trainee']['password'].'<br/>
								
				</p>
				
				<p>I am excited to work with you!  In the meantime, let me know if you need anything.</p>
					
				</td></tr><tr><td><br/>Thanks,<br/>'.$setSpecalistArr['Trainer']['full_name'].' <br/>'.$setSpecalistArr['Trainer']['mobile'].'<br/>'.$setSpecalistArr['Trainer']['email'].'</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

				$subject = "Welcome"; 

				$from_mail = $setSpecalistArr['Trainer']['email'];
					
				$from_mail_name = $setSpecalistArr['Trainer']['full_name'];
				
				if($this->sendLoginCredentials($clientdata['Trainee']['email'],$subject,$content,null,null))
						
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Login Credentials Successfully Sent.");
				
				else
				{
					$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");
				}
				/* MAIL CONTENT */
			
			}
			else 
			{
				$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, please refresh the page and try again!!");
			}			
			echo json_encode($response);
			exit;			 
		}
		
		
		function sendLoginCredentials($to,$subject,$message, $templete, $layout){
		$this->Email->template($templete, $layout)
		->emailFormat('html')
		->from(array(FROM_EMAIL => EMAILNAME))
		->to(trim($to))
		->subject(trim($subject))
		->replyTo(array(FROM_EMAIL => EMAILNAME));
		if($this->Email->send($message)){
			return true;
		}else{
			return false;
		}
	}
		
		
		public function setsessionreminderstatus()
		{
			 $this->layout = '';
			 $this->render = false;
			 
			 $response = array();
			 
			 if(trim($_POST['id'])!='')
			 {

				$datav=array();				

				$datav['id']=trim($_POST['id']);
				$datav['session_reminder_notification']=trim($_POST['sr']);
				if($this->Trainee->save($datav)) {
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Session Reminder Mail Status Successfully changed.");								}
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
		
		public function setcompletedreminderstatus()
		{
			 $this->layout = '';
			 $this->render = false;
			 
			 $response = array();
			 
			 if(trim($_POST['id'])!='')
			 {

				$datav=array();				

				$datav['id']=trim($_POST['id']);
				$datav['comp_session_notification']=trim($_POST['cr']);
				if($this->Trainee->save($datav)) {
					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Session Completed Mail Status Successfully changed.");								}
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
		

		

		public function viewclientsessions($clientid=null)

		{

			$this->checkUserLogin();

			 $this->layout = "homelayout";	

		    $this->set("leftcheck",'homemy_clients');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);
			//echo "<pre>"; print_r($setSpecalistArr); echo "</pre>";
			//$trainer_s_id = $setSpecalistArr['Trainee']['trainer_id'];
			
			$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			

			

			$traneesdata=$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$id,'Trainee.status'=>1),'fields'=>array('Trainee.id','Trainee.full_name','Trainee.address','Trainee.email'),'order'=>array('Trainee.last_name ASC'),));

			

			

			$this->set("tranee",$traneesdata);
			//echo "<pre>"; print_r($traneesdata); echo "</pre>";

		    $sccondition=array('TraineesessionPurchase.trainer_id'=>$id);

            if(isset($clientid))

			{

              $this->set("clientid",$clientid);

			  $sccondition=array('TraineesessionPurchase.trainer_id'=>$id,'TraineesessionPurchase.trainee_id'=>$clientid);

			}

	    	   

		    	   $this->TraineesessionPurchase->bindModel(array("belongsTo"=>array("Trainee"=>array("foreignKey"=>"trainee_id"))));

		    	   $this->TraineesessionPurchase->bindModel(array("belongsTo"=>array("Workout"=>array("foreignKey"=>"SessTypeId"))));

		    			

		        $this->TraineesessionPurchase->recursive = 2;

		    	   

		    	$tranrsdata=$this->TraineesessionPurchase->find('all',array('conditions'=>$sccondition));	

		    	

			

			$this->set("trainees",$tranrsdata);
			
			
			//echo $trainee_s_id = $tranrsdata['Trainee']['id'];
			//die();
			$session_purc_data = $this->SessionPurchase->find('all', array(
                    'joins' => array(
                        array(
                            'table' => 'workouts',
                            'alias' => 'workout',
                            'type' => 'LEFT',
                            'conditions' => array(
                            'SessionPurchase.session_id = workout.id'
                            )
                        )
                    ),
                    'conditions' => array(
                        'SessionPurchase.client_id' => $clientid,'SessionPurchase.trainer_id'=>$id),
                   
                    'fields' => array("SessionPurchase.*","workout.workout_name"),
                )    
                );
			$this->set("session_purc_data",$session_purc_data);			
			//echo "<pre>"; print_r($session_purc_data); echo "</pre>";
			

		}

		

		

		

		

		public function clientdocs($idv=null)

		{

			if($idv!='')

			{

			 $this->layout = "homelayout";	

		    $this->set("leftcheck",'homemy_clients');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			 $ids=base64_decode($idv);

			$setClientArr=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>$ids),'fields'=>array('Trainee.id','Trainee.full_name','Trainee.address','Trainee.email')));

			$this->set("setClientArr",$setClientArr);

			$clientsdocArr=$this->Doc->find('all',array('conditions'=>array('Doc.client_id'=>$ids),'fields'=>array('Doc.id','Doc.client_id','Doc.title','Doc.vfile','Doc.added_date')));

			

			$this->set("clientsdocArr",$clientsdocArr);

			

			  if(!empty($this->data)){

		    $this->Doc->set($this->data);

			

			

			  if(!empty($this->request->data["Doc"]["vfile"]["name"]))

				{

					$filename = $this->request->data["Doc"]["vfile"]["name"];

					$target = $this->config["upload_path"];

					$this->Upload->upload($this->data["Doc"]["vfile"], $target, null, null);

  					$this->request->data["Doc"]["vfile"] = $this->Upload->result; 

  					$this->request->data["Doc"]["title"] = $this->data['Doc']['title'];

  					

					$this->request->data["Doc"]["added_date"] 		    = date("Y-m-d");

					$this->request->data["Doc"]["client_id"] 		    = $ids;

					if($this->Doc->save($this->data)) {

					$this->Session->setFlash('Document has been updated successfully.');

					$this->redirect($_SERVER["HTTP_REFERER"]);	

					} else {

					$this->Session->setFlash('Some error has been occured. Please try again.');

					$this->redirect($_SERVER["HTTP_REFERER"]);	

					}

				}

				else {

					$this->Session->setFlash('Pic is too large. Please try again with low resolution pic.');

					$this->redirect($_SERVER["HTTP_REFERER"]);	

				}

			

				

		    }

			

			

			

			}else {

				$this->Session->setFlash('Sorry, please select the client.');

							$this->redirect('/home/manage_clients');

			}	

			

		}

		

		/* Issue code */

	/*	public function addclient()

		{

			 $this->layout = "homelayout";	

		    $this->set("leftcheck",'homemy_clients');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setSpecalistArr",$setSpecalistArr);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			

			if(!empty($this->data)) {

			

				$this->CertificationTrainers->set($this->data);

				//$this->Trainer->id = $this->data['Trainer']['id'];	

				if($this->CertificationTrainers->validates()) {

						

					    

					    $this->request->data["CertificationTrainers"]["added_date"] 		    = date("Y-m-d");

						$this->request->data["CertificationTrainers"]["modified_date"] 		= date("Y-m-d");

					    	//pr($this->request->data);

					    //$this->loadModel('ClubBranch');

					   

						if($this->CertificationTrainers->save($this->request->data)) {	

										

							$this->Session->setFlash('Branch has been created successfully.');

							$this->redirect('/home/manage_certifications/');

						} else {

							$this->Session->setFlash('Some error has been occured. Please try again.');

						}

				}	

			}

			

		}

		*/

		public function addclient()

		{

			 $this->layout = "homelayout";	

		    $this->set("leftcheck",'homemy_clients');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setSpecalistArr",$setSpecalistArr);
		  $club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			

			if($setSpecalistArr[$dbusertype]['trainer_type']=='C')

			{

				 

				$clubid=$setSpecalistArr[$dbusertype]['club_id'];

			$this->set("cbranchs",$this->ClubBranch->find('list',array("conditions"=>array("ClubBranch.club_id"=>$clubid),'fields'=>array('ClubBranch.id','ClubBranch.branch_name'))));

			}

			

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
						
						$this->request->data["Trainee"]["password"] 		    = $password=substr(md5(microtime()),rand(0,26),8);

					    $this->request->data["Trainee"]["created_date"] 		    = date("Y-m-d h:i:s");

						$this->request->data["Trainee"]["update_date"] 		    = date("Y-m-d h:i:s");

						$this->request->data["Trainee"]["status"] 		    = 1;
						
						$this->request->data["Trainee"]["session_reminder_notification"]  = 1;
						$this->request->data["Trainee"]["comp_session_notification"]   = 1;
						
						
						if($setSpecalistArr['Trainer']['website_logo']!=''){
						$this->request->data["Trainee"]["website_logo"]=$setSpecalistArr['Trainer']['website_logo'];}

					    	$user_names=$this->data["Trainee"]["first_name"].' '.$this->data["Trainee"]["last_name"];

						if($this->Trainee->save($this->data)) {	

							

								$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';

								

								

								if($dbusertype=='Trainer'&& $setSpecalistArr['Trainer']['website_logo']){

					$content.='<img src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';

					}else{

						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';

					}

							

								

								$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

								<p>I am inviting you to use my free training software to help us reach your fitness goals. </p>
								<p>Please find the link to my website and your login credentials below.  Once you are logged in just click on the edit profile tab to: </p>	
								<p>1. Change your password<br/>
								   2. Add your picture<br/>
								   3. Change your cover picture<br/>
								   4. Fill in the empty fields.</p>
								<p>Check out the <b><a href='.$this->config['url'].'trainees/helpguide>Help Guide Videos</a></b> for more information on how the site works.  As your fitness training progresses the site will become an easy way for us to stay in touch regarding your training.  </p>
								<p>Below you will find your credentials for logging in:</p>

								<p>Website URL : '.$this->config['url'].'home/myprofile/'.$setSpecalistArr['Trainer']['publicproname'].' <br/>
								 Username: '.trim($this->data["Trainee"]["email"]).'<br/>

								 Password: '.trim($this->data["Trainee"]["password"]).'<br/>

								 Usertype: Client <br/>

								 	   

				</p>
				<p>I am excited to work with you!  In the meantime, let me know if you need anything.</p>
						
				</td></tr><tr><td><br/>Thanks,<br/>'.$setSpecalistArr['Trainer']['full_name'].' <br/>'.$setSpecalistArr['Trainer']['mobile'].' <br/>'.$setSpecalistArr['Trainer']['email'].'</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = "Welcome"; 

						  

								$from_mail = $FROM_EMAIL;
								$from_mail_name = $EMAILNAME;

							

								

									$this->sendEmailMessageTraineeInvite($this->data["Trainee"]["email"],$from_mail,$from_mail_name,$subject,$content,null,null);

								

							

							

										

							$this->Session->setFlash('Client has been created successfully.');

							$this->redirect('/home/manage_clients/');

						} else {

							$this->Session->setFlash('Some error has been occured. Please try again.');

						}

				}	

			}

			

		}

		public function editclient($trid)

		{

			$this->layout = "homelayout";	

		     $this->set("leftcheck",'homemy_clients');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$trid=base64_decode($trid);

			$this->set("trid",$trid);

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));	

			

				

			if($setSpecalistArr[$dbusertype]['trainer_type']=='C')

			{

				 

				$clubid=$setSpecalistArr[$dbusertype]['club_id'];

			$this->set("cbranchs",$this->ClubBranch->find('list',array("conditions"=>array("ClubBranch.club_id"=>$clubid),'fields'=>array('ClubBranch.id','ClubBranch.branch_name'))));

			}

			

			

			if(!empty($this->data)){

			

			$this->Trainee->set($this->data);

			$this->Trainee->id = $this->data['Trainee']['id'];		

			

							

			if($this->Trainee->validates()) {

				

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

				$this->request->data["Trainee"]["username"] 		    = $this->data["Trainee"]["email"];

				$this->request->data["Trainee"]["update_date"] 		    = date("Y-m-d");

				

				if(isset($this->data["Trainee"]["ses_purcahse_date"]) && ($this->data["Trainee"]["ses_purcahse_date"])!='0000-00-00' )

				{

					$sespdt=explode("/",$this->data["Trainee"]["ses_purcahse_date"]);

					/*echo '<pre>';

					print_r($sespdt);

					echo '<pre>';

					die();*/

					if(count($sespdt)>1){

						$sespdt2=$sespdt[2].'-'.$sespdt[0].'-'.$sespdt[1];

					$this->request->data["Trainee"]["ses_purcahse_date"]=$sespdt2;

					}

				}

				

				if($this->Trainee->save($this->data)) {

					$this->Session->setFlash('Client information has been updated successfully.');

					$this->redirect('/home/manage_clients/');

				} else {

					$this->Session->setFlash('Some error has been occured. Please try again.');

				}

			}

			else{				

				$this->request->data["Trainee"]["photo"]=$this->request->data["Trainee"]["old_image"];	

				$this->redirect('/home/editclient/'.base64_encode($trid));			

			}				

		 } else{

				if(is_numeric($trid) && $trid > 0) {

						$this->Trainee->id = $trid;

						$this->request->data = $this->Trainee->read();

						$this->set("trid",$trid);

						//$this->redirect('/home/editclient/'.base64_encode($trid));	

					} else {

						$this->Session->setFlash('Invalid Client id.');

						$this->redirect('/home/manage_clients/');

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

				//$datav['id']=trim($_POST['id']);
				
				$datav['id']=trim($_POST['id']);
				$datav['status']=0;
				
				/*if($this->Trainee->delete($datav))*/ 
				if($this->Trainee->save($datav)) {

							

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
		
		
		public function deletesession()
		{	
			$this->layout = '';
			$this->render = false;
			if(trim($_POST['id'])!='')
			{
				$datav=array();				
				$datav['id']=trim($_POST['id']);
								
				$setSpecalistArr1=$this->TraineesessionPurchase->find("first",array("conditions"=>array("TraineesessionPurchase.id"=>$datav['id'])));

				$this->set("setSpecalistArr1",$setSpecalistArr1);
										
				$setSpecalistArr=$this->SessionPurchase->find("first",array("conditions"=>array("SessionPurchase.client_id"=>$setSpecalistArr1['TraineesessionPurchase']['trainee_id'],"SessionPurchase.trainer_id"=>$setSpecalistArr1['TraineesessionPurchase']['trainer_id'],"SessionPurchase.session_id"=>$setSpecalistArr1['TraineesessionPurchase']['SessTypeId'])));

				$this->set("setSpecalistArr",$setSpecalistArr);		
				
				$final_value = $setSpecalistArr['SessionPurchase']['no_of_purchase'] - $setSpecalistArr1['TraineesessionPurchase']['purchase_session'];
					
				if($this->TraineesessionPurchase->delete($datav)) {
							
							$this->SessionPurchase->query("update session_purchases set no_of_purchase='".$final_value."' where client_id='".$setSpecalistArr1['TraineesessionPurchase']['trainee_id']."' AND trainer_id='".$setSpecalistArr1['TraineesessionPurchase']['trainer_id']."' AND session_id='".$setSpecalistArr1['TraineesessionPurchase']['SessTypeId']."'");

							$this->ScheduleCalendar->query("update schedule_calendar set mapwrkt=1 where id='".$_POST['sessType']."'");						
							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully deleted");
							//$this->redirect('/home/viewclientsessions/');
							//echo json_encode($response);
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
		
		
		

		public function deletedocument()

		{

		   $this->layout = '';

			$this->render = false;

			if(trim($_POST['id'])!='')

			{

				$datav=array();				

				$datav['id']=trim($_POST['id']);

				

				$fileData=$this->Doc->findById($_POST['id']);

				

				@unlink($this->config["upload_path"].$fileData['Doc']['vfile']);

				

				

				

				if($this->Doc->delete($datav)) {

							

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

		

		public function  addgoal()

		{

			$this->layout = '';

			$this->render = false;

			if(trim($_POST['trainee_id'])!='')

			{

				$data=array();				

				

				$this->request->data['Goal']['goal']=trim($_POST['goal']);

				

				$this->Goal->trainee_id=trim($_POST['trainee_id']);

				

				if($this->Goal->save($this->data)) {

							

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully updated");

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

		

		public function  editgoal()

		{

			$this->layout = '';

			$this->render = false;

			if(trim($_POST['id'])!='')

			{

				$data=array();				

				

				$this->request->data['Goal']['goal']=trim($_POST['goal']);

				

				$this->Goal->id=trim($_POST['id']);

				

				if($this->Goal->save($this->data)) {

							

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully updated");

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

		

		public function clientmeasurement(){	

		$this->layout = "ajax";

			$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	

		

		/*echo '<pre>';

		print_r($_POST);

		echo '</pre>';*/

		$flg=0;

		if(trim($_REQUEST['cuser_id'])!='')

		{

			if(trim($_REQUEST['skinfold'])=='7')

	         {

			$setSpecalistArr99=$this->SevensiteBodyfat->find("all",array("conditions"=>array("SevensiteBodyfat.created_date"=>date("Y-m-d"),"SevensiteBodyfat.client_id"=>trim($_REQUEST['cuser_id']))));

	         }

	         if(trim($_REQUEST['skinfold'])=='3')

	         {

			$setSpecalistArr99=$this->ThreesiteBodyfat->find("all",array("conditions"=>array("ThreesiteBodyfat.created_date"=>date("Y-m-d"),"ThreesiteBodyfat.client_id"=>trim($_REQUEST['cuser_id']))));

	         }

			/*echo "<pre>";

			print_r($setSpecalistArr99);

			die();*/

			if(count($setSpecalistArr99)>0)

			{

				$flg=1;

			}

		}

		

		

		$svstatus=0;

		$thstatus=0;

		$mbistatus=0;

	

		

	

	  

		

		if($flg==0)

		{

		if(trim($_REQUEST['skinfold'])=='7'){

				if($_REQUEST['gender']=='Male')

				{

					if(trim($_REQUEST['age'])!='' &&  trim($_REQUEST['chestm'])!=''&& trim($_REQUEST['abdominalm'])!='' && trim($_REQUEST['thighm'])!='' && trim($_REQUEST['tricepsm'])!='' && trim($_REQUEST['subscapularism'])!='' && trim($_REQUEST['illiaccrestm'])!='' && trim($_REQUEST['midaxillarym'])!=''  && trim($_REQUEST['cuser_id'])!='') 

					{

						//echo "Male";

						

						$measuremenv=array();

						

						

						

						//$measuremenv['SevensiteBodyfat']['weight']=trim($_REQUEST['weight']);

						//$measuremenv['SevensiteBodyfat']['height']=trim($_REQUEST['height']);

						$measuremenv['SevensiteBodyfat']['age']=trim($_REQUEST['age']);

						$measuremenv['SevensiteBodyfat']['gender']=trim($_REQUEST['gender']);

						

						

						

						$measuremenv['SevensiteBodyfat']['chest']=trim($_REQUEST['chestm']);

						$measuremenv['SevensiteBodyfat']['abs']=trim($_REQUEST['abdominalm']);

						$measuremenv['SevensiteBodyfat']['thigh']=trim($_REQUEST['thighm']);

						$measuremenv['SevensiteBodyfat']['triceps']=trim($_REQUEST['tricepsm']);

						$measuremenv['SevensiteBodyfat']['subscapularis']=trim($_REQUEST['subscapularism']);

						$measuremenv['SevensiteBodyfat']['illiaccrest']=trim($_REQUEST['illiaccrestm']);

						$measuremenv['SevensiteBodyfat']['midaxillary']=trim($_REQUEST['midaxillarym']);

						$measuremenv['SevensiteBodyfat']['status']=1;

						$measuremenv['SevensiteBodyfat']['client_id']=trim($_REQUEST['cuser_id']);

					

						

						$measuremenv['SevensiteBodyfat']["created_date"] 		    = date("Y-m-d");

						

						$Sum=intval(trim($_REQUEST['chestm']))+intval(trim($_REQUEST['abdominalm']))+intval(trim($_REQUEST['thighm']))+intval(trim($_REQUEST['tricepsm']))+intval(trim($_REQUEST['subscapularism']))+intval(trim($_REQUEST['illiaccrestm']))+intval(trim($_REQUEST['midaxillarym']));

						$age=intval(trim($_REQUEST['age']));

		               $BD = 1.112 - ((0.000435)*$Sum) + (((0.00000055)*$Sum)*2) - ((0.000288)*$age);

		               //$BD=round($BD, 2);

		                

		                $bodymalefat = 495/$BD - 450;

		                $bodymalefat = round($bodymalefat);

		              $measuremenv['SevensiteBodyfat']['body_fat']=$bodymalefat;

						$this->SevensiteBodyfat->save($measuremenv);

						//'ThreesiteBodyfat','BodymassIndex','EstimatedenergyRequirement'

						

					

						

						echo 'Successfully Added your Seven site details. Your Seven Site Body Fat is '.$bodymalefat.'%';

					}

				}

				

				elseif($_REQUEST['gender']=='Female')

				{

				  

					if(trim($_REQUEST['age'])!='' && trim($_REQUEST['chestf'])!=''&& trim($_REQUEST['abdominalf'])!='' && trim($_REQUEST['thighf'])!='' && trim($_REQUEST['tricepsf'])!='' && trim($_REQUEST['subscapularisf'])!='' && trim($_REQUEST['illiaccrestf'])!='' && trim($_REQUEST['midaxillaryf'])!=''  && trim($_REQUEST['cuser_id'])!='') 

				  

				  {

				     //echo "Female";

				     $measuremenv=array();

						

						

						//$measuremenv['SevensiteBodyfat']['weight']=trim($_REQUEST['weight']);

						//$measuremenv['SevensiteBodyfat']['height']=trim($_REQUEST['height']);

						$measuremenv['SevensiteBodyfat']['age']=trim($_REQUEST['age']);

						$measuremenv['SevensiteBodyfat']['gender']=trim($_REQUEST['gender']);

						

						

						

						$measuremenv['SevensiteBodyfat']['chest']=trim($_REQUEST['chestf']);

						$measuremenv['SevensiteBodyfat']['abs']=trim($_REQUEST['abdominalf']);

						$measuremenv['SevensiteBodyfat']['thigh']=trim($_REQUEST['thighf']);

						$measuremenv['SevensiteBodyfat']['triceps']=trim($_REQUEST['tricepsf']);

						$measuremenv['SevensiteBodyfat']['subscapularis']=trim($_REQUEST['subscapularisf']);

						$measuremenv['SevensiteBodyfat']['illiaccrest']=trim($_REQUEST['illiaccrestf']);

						$measuremenv['SevensiteBodyfat']['midaxillary']=trim($_REQUEST['midaxillaryf']);

						$measuremenv['SevensiteBodyfat']['status']=1;

						$measuremenv['SevensiteBodyfat']['client_id']=trim($_REQUEST['cuser_id']);

					

						

						$measuremenv['SevensiteBodyfat']["created_date"] 		    = date("Y-m-d");

						

						$Sum=intval(trim($_REQUEST['chestm']))+intval(trim($_REQUEST['abdominalm']))+intval(trim($_REQUEST['thighm']))+intval(trim($_REQUEST['tricepsm']))+intval(trim($_REQUEST['subscapularism']))+intval(trim($_REQUEST['illiaccrestm']))+intval(trim($_REQUEST['midaxillarym']));

						$age=intval(trim($_REQUEST['age']));

		               $BD = 1.097 - ((0.00047)*$Sum) + (((0.00000056)*$Sum)*2) - ((0.000128)*$age);

		              // $BD=round($BD, 2);

		                

		                $bodyfemalefat = 496/$BD - 451;

		                $bodyfemalefat = round($bodyfemalefat);

		              $measuremenv['SevensiteBodyfat']['body_fat']=$bodyfemalefat;

		              $this->SevensiteBodyfat->save($measuremenv);

		              

		              

						

						echo 'Successfully Added your Seven site details. Your Seven Site Body Fat is '.$bodyfemalefat.'%';

		              

		              

		              

				  }

				

				  }

		      }

		  if(trim($_REQUEST['skinfold'])=='3')

		  {

		  	if($_REQUEST['gender']=='Male')

				{

					if(trim($_REQUEST['age'])!='' && trim($_REQUEST['chestm'])!=''&& trim($_REQUEST['abdominalm'])!='' && trim($_REQUEST['thighm'])!='' && trim($_REQUEST['cuser_id'])!='') 

					{

						

						$threesiteArr=array();

						

						$threesiteArr['ThreesiteBodyfat']['age']=trim($_REQUEST['age']);

						$threesiteArr['ThreesiteBodyfat']['gender']=trim($_REQUEST['gender']);

						$threesiteArr['ThreesiteBodyfat']['abdominal']=trim($_REQUEST['abdominalm']);

						

						

						

						$threesiteArr['ThreesiteBodyfat']['chest']=trim($_REQUEST['chestm']);

					

						$threesiteArr['ThreesiteBodyfat']['thigh']=trim($_REQUEST['thighm']);

						$threesiteArr['ThreesiteBodyfat']['triceps']=trim($_REQUEST['tricepsm']);

					   $threesiteArr['ThreesiteBodyfat']['suprailiac']='';

						

						

						

						$threesiteArr['ThreesiteBodyfat']['status']=1;

						$threesiteArr['ThreesiteBodyfat']['client_id']=trim($_REQUEST['cuser_id']);

					

						

						$threesiteArr['ThreesiteBodyfat']["created_date"] 		    = date("Y-m-d");

						

						

						

						$Sum2=intval(trim($_REQUEST['chestm']))+intval(trim($_REQUEST['abdominalm']))+intval(trim($_REQUEST['thighm']));

						$age=intval(trim($_REQUEST['age']));

						

						

						  $BodyDensity = 1.10938- ((0.0008267)*$Sum2) + (((0.0000016)*($Sum2))*2) - ((0.0001392)*$age);

						 $BodyFat = 457/$BodyDensity - 414;

						 $BodyFat = round($BodyFat,2);

						

						

						$threesiteArr['ThreesiteBodyfat']['body_fat']=$BodyFat;

						

						

						$this->ThreesiteBodyfat->save($threesiteArr);

						

						

						echo 'Successfully Added your Three site details. Your Three Site Body Fat is '.$BodyFat.'%';

					}

				}

				

				elseif($_REQUEST['gender']=='Female')

				{

				  

					if(trim($_REQUEST['age'])!='' && trim($_REQUEST['thighf'])!='' && trim($_REQUEST['tricepsf'])!='' && trim($_REQUEST['suprailiacf'])!=''  && trim($_REQUEST['cuser_id'])!='') 

				  

				  {

				     

		              

		                $threesiteArr=array();

						

						$threesiteArr['ThreesiteBodyfat']['age']=trim($_REQUEST['age']);

						$threesiteArr['ThreesiteBodyfat']['gender']=trim($_REQUEST['gender']);

						

						

					

						$threesiteArr['ThreesiteBodyfat']['thigh']=trim($_REQUEST['thighf']);

						$threesiteArr['ThreesiteBodyfat']['triceps']=trim($_REQUEST['tricepsf']);

						$threesiteArr['ThreesiteBodyfat']['suprailiac']=trim($_REQUEST['suprailiacf']);

						

						

						

						$threesiteArr['ThreesiteBodyfat']['status']=1;

						$threesiteArr['ThreesiteBodyfat']['client_id']=trim($_REQUEST['cuser_id']);;

					

						

						$threesiteArr['ThreesiteBodyfat']["created_date"] 		    = date("Y-m-d");

						

						

						

						$Sum2=intval(trim($_REQUEST['thighf']))+intval(trim($_REQUEST['tricepsf']))+intval(trim($_REQUEST['suprailiacf']));

						$age=intval(trim($_REQUEST['age']));

						

						

						 $BodyDensity = 1.099421- ((0.0009929)*$Sum2) + (((0.0000023)*($Sum2))*2) - ((0.0001392)*$age);

						$BodyFat = (457/$BodyDensity)-414;

						$BodyFat = round($BodyFat);

						$threesiteArr['ThreesiteBodyfat']['body_fat']=$BodyFat;

						

						$this->ThreesiteBodyfat->save($threesiteArr);

						

						

						echo 'Successfully Added your Three site details. Your Three Site Body Fat is '.$BodyFat.'%';

		              

		              

		              

				  }

				

				  }

		  	

		  }

		}

		else {

			echo 'Sorry, you need to first delete this date entry then you can able to add new one.';

		}

			

		}

		

		

		

		public function editbio(){

			$id = $this->Session->read('USER_ID');

			$this->autoRender=false;

			

			//pr($this->request->data);

			if(!empty($this->request->data)){

				$this->Trainer->id=$this->request->data['Trainer']['id'];

				$this->Trainer->save($this->request->data);

				$this->redirect('/home/index/');

			}else{

				if(is_numeric($id) && $id > 0) {

						$this->Trainer->id = $id;

						$this->request->data = $this->Trainer->read();

					} else {

						$this->Session->setFlash('Invalid Trainer id.');

						$this->redirect('/home/index/');

				}

			}

			

		}

		public function savecard()
		{
			$id = $this->Session->read('USER_ID');

			$this->autoRender=false;
			
			/*echo "<pre>";

			print_r($this->request->data);
			
			echo "</pre>";	

			die;*/
			
			$trainerdata = $this->Trainer->find("first",array("fields"=>array("email","auth_profile_id","cust_payment_profile_id","phone","city","state","country","address","zip"),"conditions"=>array("Trainer.id"=>$id)));			
			

			if(!empty($this->request->data))
			{
				/***CUSTOMER PROFILE CREATE CODE START****/
				
				$loginname= '96fV4zs3BdX';
				
				//$transactionkey ='27Abm977RD5BZ8mZ';
				
				$transactionkey ='6uFSJ686c9Xp33Uq';		
				
				$host = 'api.authorize.net';
				
				//$host = 'apitest.authorize.net';
				
				$path= '/xml/v1/request.api';
				
				$content =
					"<?xml version=\"1.0\" encoding=\"utf-8\"?>".
					
					"<createCustomerProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
					
					"<merchantAuthentication>".
					
					"<name>".$loginname."</name>".
					
					"<transactionKey>".$transactionkey."</transactionKey>".
					
					"</merchantAuthentication>".
					
					"<profile>".
					
					"<merchantCustomerId>".$id."</merchantCustomerId>".
					
					"<description>".
					
					"</description>".
					
					"<email>" .$trainerdata['Trainer']['email']. "</email>".
					
					"</profile>".
					
					"</createCustomerProfileRequest>";

				$response = $this->Autharb->send_request_via_fsockopen($host,$path,$content);
				
				echo "Raw response: " . htmlspecialchars($response) . "<br><br>";				
				$parsedresponse = $this->Autharb->parse_return($response);
				
				$customerProfileId = $parsedresponse[5];
				
				$resultCode =  $parsedresponse[1];
				
				if("Ok" == $resultCode)
				{					
					$customerProfileId = $parsedresponse[5];
				}
				else
				{					
					$customerProfileId = $trainerdata['Trainer']['auth_profile_id'];
				}
				/***CUSTOMER PROFILE CREATE CODE END****/
				
				
				/***CUSTOMER PAYMENT PROFILE CODE START****/
				if($resultCode=="Ok")
				{
					$mode = 'testMode';
					
					$expirationyear = $this->request->data['Trainer']['exyear'];
					
					$expirationmonth = $this->request->data['Trainer']['exmonth'];
					
					$cardexpiration = $expirationyear."-".$expirationmonth;
					
					$cardno = $this->request->data['Trainer']['cardnumber'];
					
					$cNum = 'XXXXXXXXXXXX'.substr($cardno,-4);
					
					$firstcardname = $this->request->data['Trainer']['firstcardname'];
					
					$lastcardname = $this->request->data['Trainer']['lastcardname'];
					
					$fullcardname = $firstcardname." ".$lastcardname;
								
					$contentpaymentprofile =				
						"<?xml version=\"1.0\" encoding=\"utf-8\"?>".
						
						"<createCustomerPaymentProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
						
						"<merchantAuthentication>".
						
						"<name>".$loginname."</name>".
						
						"<transactionKey>".$transactionkey."</transactionKey>".
						
						"</merchantAuthentication>".						
						
						"<customerProfileId>".$customerProfileId."</customerProfileId>".
						
						"<paymentProfile>".						
							"<billTo>".						
								"<firstName>".$firstcardname."</firstName>".			
								"<lastName>".$lastcardname."</lastName>".				
								"<address>".$trainerdata['Trainer']['address']."</address>".
								"<city>".$trainerdata['Trainer']['city']."</city>".
								"<state>".$trainerdata['Trainer']['state']."</state>".
								"<zip>".$trainerdata['Trainer']['zip']."</zip>".
								"<country>".$trainerdata['Trainer']['country']."</country>".								
								
								"<phoneNumber>".$trainerdata['Trainer']['phone']."</phoneNumber>".									
							"</billTo>".						
							"<payment>".
								"<creditCard>".
									"<cardNumber>".$cardno."</cardNumber>".
									"<expirationDate>".$cardexpiration."</expirationDate>".
								"</creditCard>".
							"</payment>".
						"</paymentProfile>".
						
						"<validationMode>".$mode."</validationMode>".
						
						"</createCustomerPaymentProfileRequest>";	
					
					$responsepaymentprofile = $this->Autharb->send_request_via_fsockopen($host,$path,$contentpaymentprofile);
					
					echo "Raw response: " .htmlspecialchars($contentpaymentprofile)."<br>";				
					
					$parsedresponsepaymentprofile = $this->Autharb->parse_return($responsepaymentprofile);
					
					$customerPaymentProfileId = $parsedresponsepaymentprofile[6];
										
				}
				/***CUSTOMER PAYMENT PROFILE CODE END****/
				
				
				/***CUSTOMER SHIPPING PROFILE CODE START****/
				
				if($customerProfileId !='' && customerPaymentProfileId!='')
				{
					$contentshippingprofile=
						"<?xml version=\"1.0\" encoding=\"utf-8\"?>".
						"<createCustomerShippingAddressRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
							"<merchantAuthentication>".
								"<name>".$loginname."</name>".
								"<transactionKey>".$transactionkey."</transactionKey>".
							"</merchantAuthentication>".
							"<customerProfileId>".$customerProfileId."</customerProfileId>".
							"<address>".
								"<firstName>".$firstcardname."</firstName>".
								"<lastName>".$lastcardname."</lastName>".
								"<phoneNumber>".$trainerdata['Trainer']['phone']."</phoneNumber>".
							"</address>".
						"</createCustomerShippingAddressRequest>";
					
					$responseshippingprofile = $this->Autharb->send_request_via_fsockopen($host,$path,$contentshippingprofile);
				
					echo "Raw response: " .htmlspecialchars($contentshippingprofile)."<br>";				
					
					$parsedresponseshippingprofile = $this->Autharb->parse_return($responseshippingprofile);

					//print_r($parsedresponseshippingprofile);
										
					$customerShippingProfileId = $parsedresponseshippingprofile[7];
						
				}
				
				/***CUSTOMER SHIPPING PROFILE CODE END****/
				
				$this->Trainer->id=$id;
				
				$dataSet['Trainer']['cardnumber'] = $cNum;
				
				$dataSet['Trainer']['cardtype'] = $this->request->data['Trainer']['cardtype'];
				
				$dataSet['Trainer']['auth_profile_id'] = $customerProfileId;
				
				$dataSet['Trainer']['cust_payment_profile_id'] = $customerPaymentProfileId;
				
				$dataSet['Trainer']['cust_shipping_profile_id'] = $customerShippingProfileId;
				
				//$this->Trainer->save($this->request->data);
				
				$this->Trainer->save($dataSet);
				
				if($trainerdata['Trainer']['auth_profile_id']!='')
				{
					$this->Trainer->id=$id;
					
					$dataSet['Trainer']['cardnumber'] = $cNum;
					
					$dataSet['Trainer']['cardtype'] = $this->request->data['Trainer']['cardtype'];					
										
					$this->Trainer->save($dataSet);
				}

				$this->Session->setFlash('Your Credit Card Details Saved Successfully');

				$this->redirect('/home/index/');

			}
			else
			{
				if(is_numeric($id) && $id > 0) 
				{
					$this->Trainer->id = $id;

					$this->request->data = $this->Trainer->read();
				}
				else
				{
					$this->Session->setFlash('Invalid Trainer id.');

					$this->redirect('/home/index/');
				}
			}
		}
		
		
		
		
		
		
		public function updatecard()
		{
			$id = $this->Session->read('USER_ID');

			$this->autoRender=false;
			
			/*echo "<pre>";

			print_r($this->request->data);
			
			echo "</pre>";	

			die;*/
			
			$trainerdata = $this->Trainer->find("first",array("fields"=>array("email","auth_profile_id","cust_payment_profile_id","cust_shipping_profile_id","phone","city","state","country","address","zip"),"conditions"=>array("Trainer.id"=>$id)));			
			

			if(!empty($this->request->data))
			{
				/***CUSTOMER PROFILE CREATE CODE START****/
				
				$loginname= '96fV4zs3BdX';
				
				//$transactionkey ='27Abm977RD5BZ8mZ';
				
				$transactionkey ='6uFSJ686c9Xp33Uq';		
				
				$host = 'api.authorize.net';
				
				//$host = 'apitest.authorize.net';
				
				$path= '/xml/v1/request.api';				
								
				$customerProfileId = $trainerdata['Trainer']['auth_profile_id'];
					
				$customerPaymentProfileId = $trainerdata['Trainer']['cust_payment_profile_id'];
				
				$customerAddressId = $trainerdata['Trainer']['cust_shipping_profile_id'];
				
				/***UPDATE PAYMENT PROFILE CODE START****/
				if($customerProfileId!='' && $customerPaymentProfileId!='')
				{
					$mode = 'testMode';
					
					$expirationyear = $this->request->data['Trainer']['exyear'];
					
					$expirationmonth = $this->request->data['Trainer']['exmonth'];
					
					$cardexpiration = $expirationyear."-".$expirationmonth;
					
					$cardno = $this->request->data['Trainer']['cardnumber'];
					
					$cNum = 'XXXXXXXXXXXX'.substr($cardno,-4);
					
					$firstcardname = $this->request->data['Trainer']['firstcardname'];
					
					$lastcardname = $this->request->data['Trainer']['lastcardname'];
					
					$fullcardname = $firstcardname." ".$lastcardname;
					
					$updatepaymentprofile=
							"<?xml version=\"1.0\" encoding=\"utf-8\"?>".
							"<updateCustomerPaymentProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
							"<merchantAuthentication>".
								"<name>".$loginname."</name>".
								"<transactionKey>".$transactionkey."</transactionKey>".
							"</merchantAuthentication>".
							"<customerProfileId>".$customerProfileId."</customerProfileId>".
							  "<paymentProfile>".
								"<billTo>".
								  "<firstName>".$firstcardname."</firstName>".			
									"<lastName>".$lastcardname."</lastName>".				
									"<address>".$trainerdata['Trainer']['address']."</address>".
									"<city>".$trainerdata['Trainer']['city']."</city>".
									"<state>".$trainerdata['Trainer']['state']."</state>".
									"<zip>".$trainerdata['Trainer']['zip']."</zip>".
									"<country>".$trainerdata['Trainer']['country']."</country>".								
									
									"<phoneNumber>".$trainerdata['Trainer']['phone']."</phoneNumber>".	
								"</billTo>".						
									"<payment>".
										"<creditCard>".
											"<cardNumber>".$cardno."</cardNumber>".
											"<expirationDate>".$cardexpiration."</expirationDate>".
										"</creditCard>".
									"</payment>".									"<customerPaymentProfileId>".$customerPaymentProfileId."</customerPaymentProfileId>".
								"</paymentProfile>".
								
								"<validationMode>".$mode."</validationMode>".
							"</updateCustomerPaymentProfileRequest>";
					
					$responseupdatepaymentprofile = $this->Autharb->send_request_via_fsockopen($host,$path,$updatepaymentprofile);
					
					echo "Raw response: " .htmlspecialchars($updatepaymentprofile)."<br>";				
					
					$parsedresponseupdatepaymentprofile = $this->Autharb->parse_return($responseupdatepaymentprofile);
									
				/***UPDATE PAYMENT PROFILE CODE END****/
				
				/***UPDATE SHIPPING PROFILE CODE START****/
				$updateshippingprofile= 
						"<?xml version=\"1.0\" encoding=\"utf-8\"?>".
						"<updateCustomerShippingAddressRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
						 "<merchantAuthentication>".
								"<name>".$loginname."</name>".
								"<transactionKey>".$transactionkey."</transactionKey>".
							"</merchantAuthentication>".
							"<customerProfileId>".$customerProfileId."</customerProfileId>".
							"<address>".
								"<firstName>".$firstcardname."</firstName>".
								"<lastName>".$lastcardname."</lastName>".
								"<phoneNumber>".$trainerdata['Trainer']['phone']."</phoneNumber>".					   "<customerAddressId>".$customerAddressId."</customerAddressId>".
						 "</address>".
						"</updateCustomerShippingAddressRequest>";
				
				$responseupdateshippingprofile = $this->Autharb->send_request_via_fsockopen($host,$path,$updateshippingprofile);
					
				echo "Raw response: " .htmlspecialchars($updateshippingprofile)."<br>";				
					
				$parsedresponseupdateshippingprofile = $this->Autharb->parse_return($responseupdateshippingprofile);
				
				
				
				
				/***UPDATE SHIPPING PROFILE CODE START****/
				
				}
				
				$this->Trainer->id=$id;
				
				$dataSet['Trainer']['cardnumber'] = $cNum;
				
				$dataSet['Trainer']['cardtype'] = $this->request->data['Trainer']['cardtype'];
				
				$dataSet['Trainer']['auth_profile_id'] = $customerProfileId;
				
				//$this->Trainer->save($this->request->data);
				
				$this->Trainer->save($dataSet);
				
				if($trainerdata['Trainer']['auth_profile_id']!='')
				{
					$this->Trainer->id=$id;
					
					$dataSet['Trainer']['cardnumber'] = $cNum;
					
					$dataSet['Trainer']['cardtype'] = $this->request->data['Trainer']['cardtype'];					
										
					$this->Trainer->save($dataSet);
				}

				$this->Session->setFlash('Your Credit Card Details Saved Successfully');

				$this->redirect('/home/index/');

			}
			else
			{
				if(is_numeric($id) && $id > 0) 
				{
					$this->Trainer->id = $id;

					$this->request->data = $this->Trainer->read();
				}
				else
				{
					$this->Session->setFlash('Invalid Trainer id.');

					$this->redirect('/home/index/');
				}
			}
		}
		
		
		
		
		
		

		public function subscriptions(){

			//$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'homeindex');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	    $this->set("degrees",$this->Degree->find('all',array('conditions'=>array('Degree.status'=>1),'fields'=>array('Degree.id','Degree.name'))));	

	    $this->set("certificationsorg",$this->CertificationOrganization->find('all',array('conditions'=>array('CertificationOrganization.status'=>1),'fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));	

			

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		

		$this->set("setSpecalistArr",$setSpecalistArr);
		$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

		$this->set("SubscriptionInfo",$this->Subscription->find("all",array("conditions"=>array('OR' => array(

    array('Subscription.plan_for' => 'All'),

    array('Subscription.plan_for' => 'Trainer')),'Subscription.status'=>1))));		

		}

		function removeWebsiteLogoTrainer() {

				

			$this->layout = '';

			$this->render = false;

			

		

			if($this->data) {

				

				$userPic = $this->Trainer->find("first",array("fields"=>array("website_logo"),"conditions"=>array("Trainer.id"=>$this->data["id"])));

				$picPath = $this->config["upload_path"].$userPic["Trainer"]["website_logo"];

				unlink($picPath);

				

				$dataa["website_logo"] = null;

				if( $this->Trainer->updateAll($dataa,array("Trainer.id"=>$this->data["id"])) ) {

					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully updated");
					//$this->redirect('/home/index/');

				}else{

					$response = array("responseclassName"=>"nFailure","errorMsg"=>"unable to process the request");

				}

				echo json_encode($response);
				
				exit;	

			}

		

		}

		public function forms(){
		
		$this->checkUserLogin();
		$this->layout = "homelayout";		
		//echo $this->Session->read('UNAME');
		$this->set("leftcheck",'forms');
		$dbusertype = $this->Session->read('UTYPE');					
		$this->set("dbusertype",$dbusertype);
		$uid = $this->Session->read('USER_ID');				
		
		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	
		
		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	
	    
		$this->set("degrees",$this->Degree->find('all',array('conditions'=>array('Degree.status'=>1),'fields'=>array('Degree.id','Degree.name'))));	
	    
		$this->set("certificationsorg",$this->CertificationOrganization->find('all',array('conditions'=>array('CertificationOrganization.status'=>1),'fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));
		
		$this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$uid,'Trainee.status'=>1,'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.full_name ASC'),'fields'=>array('Trainee.id','Trainee.full_name'))));   
    	
		$this->set("videos",$this->ExerciseLibrary->find('all',array('conditions'=>array('ExerciseLibrary.status'=>1),'fields'=>array('ExerciseLibrary.id','ExerciseLibrary.doc_name','ExerciseLibrary.description'))));

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);
		
		
		/*echo "<pre>";
		print_r($tranee);
		echo "</pre>";*/
		
		  	if(!empty($this->data))	{
				/*	echo "<pre>";
				print_r($this->data);
				echo "</pre>";
				die('Here');*/
				$attach=array();
				$upath= $this->config["upload_form"];	
				$clientsemail= $this->Trainee->find('all',array('conditions'=>array('Trainee.id'=>$this->data['CertificationTrainers']['clients'],'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.full_name ASC'),'fields'=>array('Trainee.email','Trainee.first_name')));	//$videoslink=$this->ExerciseLibrary->find('all',array('conditions'=>array('ExerciseLibrary.id'=>$this->data['CertificationTrainers']['vidid']),'fields'=>array('ExerciseLibrary.doc_name','ExerciseLibrary.id')));
				//$forms=$this->Form->find('all',array('conditions' =>array('Form.id'=>$this->data['CertificationTrainers']['vidid'])));
				/*echo "<pre>";
				print_r($clientsemail);
				print_r($videoslink);
				die();*/
					foreach ($this->data['CertificationTrainers']['vidid'] as $calue){
					$forms=$this->Form->find('all',array('conditions' =>array('Form.id'=>$calue)));
						foreach($forms as $vids) {
							$filename=$vids['Form']['document'];
							//$attach[]=$filename;
							$attach[]=$upath.$filename;
							/*$this->Email->attachments(array(
								$name => array(
									'file' => $filepath.$name,
									'mimetype' => 'application/pdf'
								)
								));	*/
						}
					}
				/*	echo "<pre>";
				print_r($attach);
				echo "</pre>";
				die('Here');*/
					foreach($clientsemail as $details){
						if($details['Trainee']['email']!=''){
							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
							if($dbusertype=='Trainer' && $setSpecalistArr['Trainer']['website_logo']){
									$content.='<img width="150" height="130" src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';
								}else{
									$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
								}
							$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td>
							<p>'.$setSpecalistArr['Trainer']['full_name'].' (<a href="mailto:'.$setSpecalistArr['Trainer']['email'].'" target="_top">'.$setSpecalistArr['Trainer']['email'].'</a>) has sent you a message.</p>
							<p>'.$this->data['CertificationTrainers']['message'].'</p>';
							//$content .=$videosmaillink;	
							$content .='</td></tr><tr><td></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
							$subject = $this->config["base_title"]." : Forms with attachments";
							$details['Trainee']['email']= trim($details['Trainee']['email']);
							//die();
							//$attachments='';
							$this->sendEmailMessageAttachment($details['Trainee']['email'],$subject,$content,null,null,$attach);
						}
					}
				$this->Session->setFlash('Emails has been sent successfully.');
				$this->redirect('');
			}
		$forms=$this->Form->find('all',array('conditions' => array('OR' => array(array('Form.type' =>'All'),array('Form.type' => 'Trainer')))));
        $this->set('forms',$forms);
		$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
		$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
		$this->set("setSpecalistArr1",$setSpecalistArr1);
		/*echo "<pre>";
			print_r($setSpecalistArr1);
			echo "</pre>";
			
			echo "<pre>";
			print_r($setSpecalistArr);
			echo "</pre>";
		die();*/
		}

		public function gallery(){	

			

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		  $this->set("setSpecalistArr",$setSpecalistArr);
		  
		  $club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

		  $galleries=$this->Gallery->find('all',array('conditions' => array ('Gallery.trainer_id'=>$uid)));

        

        $this->set('galleries',$galleries);

		

		

		}

		public function addgallery(){	

			$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'manage_workout');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

	

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);
		
		$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);
		
		

		 

		  if(!empty($this->request->data)) {

		  	

				$this->Gallery->set($this->request->data);

				//$this->Trainer->id = $this->data['Trainer']['id'];	

				if($this->Gallery->validates()) {

						

					    if( !empty($this->data["Gallery"]["gallery_image"]) ) {

								

							$filename1 = time().'_'.$this->data["Gallery"]["gallery_image"]["name"];

							$target = $this->config["upload_gallery"];

						

							if($this->data["Gallery"]["gallery_image"]["tmp_name"]){

								

			move_uploaded_file($this->data["Gallery"]["gallery_image"]["tmp_name"], $target.$filename1);

			

			

							}

             $this->request->data["Gallery"]["gallery_image"] = $filename1;

             //die('here');

						}else{	

							

							unset($this->request->data["Gallery"]["gallery_image"]);

							$this->request->data["Gallery"]["gallery_image"]= '';							

					    }

					    

					 

					    

					    

					    $this->request->data["Gallery"]["status"]  = 1;

					   

						if($this->Gallery->save($this->request->data)) {	

										

							$this->Session->setFlash('Gallery has been created successfully.');

							$this->redirect('/home/gallery/');

						} else {

							$this->Session->setFlash('Some error has been occured. Please try again.');

						}

				}	

			}

		

		

		

		

		}



		public function deletegallery($id=null)

		{

			$this->layout='';

			$this->autoRender=false;

			if($id!='')

			{

				$ids=base64_decode($id);

				$this->Gallery->delete($ids);

				$this->Session->setFlash('Gallery has been deleted successfully.');

							$this->redirect('/home/gallery/');

			}

			else {

				$this->Session->setFlash('Sorry, please select gallery pic.');

							$this->redirect('/home/gallery/');

			}

			

		}

		

		

		public function upgradesubs()
		{
			$emailtypesend = "Notification of Subscription Plan Activation";
			
			$ManagemaildetailInfo=$this->Managemail->find("first",array("conditions"=>array("Managemail.mails_type"=>$emailtypesend)));
			
			/*echo '<pre>';print_r($ManagemaildetailInfo);echo '</pre>';die();*/

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
					$SubscriptionInfo=$this->Subscription->find("first",array("conditions"=>array('Subscription.id'=>$id)));
					
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

					$totalOccurrences = '9999';	

					$amount = $SubscriptionInfo['Subscription']['plan_cost']; 
					
					$cardNumber      = $setSpecalistArr[$dbusertype]['cardnumber'];

					$expirationDate1 = $setSpecalistArr[$dbusertype]['exyear'];		

					$expirationDate2 = $setSpecalistArr[$dbusertype]['exmonth'];		
					$expirationDate  = $expirationDate1.'-'.$expirationDate2;

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
					 //echo $content;
					//send the xml via curl

					$response = $this->Autharb->send_request_via_curl($host,$path,$content);

					//if the connection and send worked $response holds the return from Authorize.net

					if($response)
					{
						list ($refId, $resultCode, $code, $text, $subscriptionId) = $this->Autharb->parse_return($response);		

						if($resultCode == 'Ok') 
						{
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

							$aa['Payment']['nextbillingdate']              = date('Y-m-d',strtotime("+1 months"));	
							
							$aa['Payment']['payusertype']              = "Trainer";

							//$aa['User']['ftext']               = $text;

							/* $this->User->set('status', '0');

							 $this->User->set('smonth', date('Y-m-d'));

							 $this->User->set('emonth', date('Y-m-d',strtotime("+1 months")));*/
							 
							/*print_r($aa);

							die();*/
							$this->Payment->save($aa);	

							$this->$dbusertype->id=$uid;

							$cc2[$dbusertype]['subscriptionplan']=$SubscriptionInfo['Subscription']['plan_name'];
							
							$cc2[$dbusertype]['after_sub_trial_end']=0;
							
							$cc2[$dbusertype]['club_cancel_status']=0;				

							$this->$dbusertype->save($cc2);							

							$ufullname=ucwords($setSpecalistArr[$dbusertype]['full_name']);

							// send password on the registered e-mail address

							$to      = $setSpecalistArr[$dbusertype]['email'];

							//$to      = 'synapseindia8@gmail.com';

							$subject = $ManagemaildetailInfo['Managemail']['subject'];

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
							
							$newpaymentdate = date("m/d/Y", strtotime($aa['Payment']['paymentdate']));
							
							$newnextbillingdate = date("m/d/Y", strtotime($aa['Payment']['nextbillingdate']));
							
							$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$ufullname.'!</p>
							
							<p>Congratulations!  Your subscription plan for Personal Training Partners has been activated.  Thank you!  We are looking forward to serving you and helping you grow your business.</p>
							
							<p>Please find your Subscription Details below:</p>
							
							<p>Subscription Plan: '.$aa['Payment']['subscriptionplan'].'<br/>

						   Amount: '.$aa['Payment']['amount'].'<br/>

						   Cycle: '.$aa['Payment']['paymenttype'].'<br/>

						   Payment Date: '.$newpaymentdate.'<br/>

						   Next Billing Date: '.$newnextbillingdate.'<br/>
						
							<br/>
				   
							'.$ManagemaildetailInfo['Managemail']['content'].'<br />
							
							</p>
							</td></tr><tr><td><br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
							
							if($this->sendEmailMessageSubsc(trim($to),$subject,$content,null,null))
							{	
								echo 'Your Subscription plan has been upgraded successfully, we have sent detail on your registered email address. Please check your emaill account.';
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
					echo 'Sorry, first you need to set you credit card detail in Dashboard - Manage Crad Detail.';
				}
			}
			else
			{
				echo 'Sorry, please select subscription plan.';
			}
		}

		

		public function myprofile($usernm=null)

		

		{

			if($usernm!='')

			{

		$this->layout = "publiclayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'homeindex');

		

		$dbusertype = 'Trainer';					

		$this->set("dbusertype",$dbusertype);

		$uid = trim($usernm);				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	   $this->set("degrees",$this->Degree->find('all',array('conditions'=>array('Degree.status'=>1),'fields'=>array('Degree.id','Degree.name'))));	

	    $this->set("certificationsorg",$this->CertificationOrganization->find('all',array('conditions'=>array('CertificationOrganization.status'=>1),'fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));	

		$setSpecalistArrURL=$this->Admin->find("first",array("conditions"=>array("Admin.name"=>Admin)));
		$this->set("setSpecalistArrURL",$setSpecalistArrURL);
		/*echo "<pre>";
		print_r($setSpecalistArrURL);
		echo "</pre>";*/
		
		
			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.publicproname"=>$uid)));

			if(!empty($setSpecalistArr))

			{

		  $this->set("setSpecalistArr",$setSpecalistArr);

		  $trinaerid=$setSpecalistArr[$dbusertype]['id'];

		$this->set("events",$this->Event->find('all',array('conditions'=>array('Event.trainer_id'=>$trinaerid))));	      

		$tranrsdata=$this->CertificationTrainers->find('all',array('conditions'=>array('CertificationTrainers.trainer_id'=>$trinaerid),'order'=>array('CertificationTrainers.certification_org ASC')));

			

			$this->set("certificationstr",$tranrsdata);

			

			 $galleries=$this->Gallery->find('all',array('conditions' => array ('Gallery.trainer_id'=>$trinaerid)));

        

        $this->set('galleries',$galleries);

			

			 }else {

				$this->Session->setFlash('Sorry, invalid URL.');

							$this->redirect('/home/gallery/');

			  }

			} else {

				$this->Session->setFlash('Sorry, invalid URL.');

							$this->redirect('/home/gallery/');

			}

			

		}

		



		

public function messageclient()

		{

			

			$this->layout = "";

			$this->autoRender=false;

			$uid = $this->Session->read('USER_ID');

			

			/*echo"<pre>";

			print_r($_REQUEST);

			echo"</pre>";*/

			

		//	$sentfor="Client";

			

			$sentfor=trim($_REQUEST['sentfor']);

			

			$subject=trim($_REQUEST['subject']);

			$message2=trim($_REQUEST['message']);

			$sendto=trim($_REQUEST['sendto']);

			$mestype=trim($_REQUEST['mestype']);

			$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$uid)));

			if($sentfor=='Client')

			{

				 $traineeDataArr=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>$sendto),'fields'=>array('Trainee.id','Trainee.username','Trainee.email','Trainee.phone')));	

				$to=$traineeDataArr['Trainee']['email'];

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

					$dataSet['MessageBoard']['client_id']=$sendto;

					$dataSet['MessageBoard']['parent_message']=0;

					$dataSet['MessageBoard']['posted_by']='T';

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

			

			if($sentfor=='Club')

			{

			   $clubDataArr=$this->Club->find('first',array('conditions'=>array('Club.id'=>$sendto),'fields'=>array('Club.id','Club.username','Club.email','Club.phone')));	

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

						

							/*if($this->sendEmailMessage(trim($to),$subject,$content,null,null))

							{

								

							}*/	

							

			

			

							

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

		

		/* Message reply fucntionality start */

		public function messageclientrp()

		{

			

			$this->layout = "";

			$this->autoRender=false;

			$uid = $this->Session->read('USER_ID');

			$dbusertype = $this->Session->read('UTYPE');					

			

	

		

			

			$postedby="C";

			if($dbusertype=='Trainer')

			{

				$postedby="T";

			}

			

			$message2=trim($_REQUEST['message']);

			$clientid=trim($_REQUEST['clientid']);

			$trainerid=trim($_REQUEST['trainerid']);

			$mes_pid=trim($_REQUEST['pmessageid']);

			

			

			

			

			$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$trainerid)));

			 $traineeDataArr=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>$clientid),'fields'=>array('Trainee.id','Trainee.username','Trainee.email','Trainee.phone')));	

			if($postedby=='T')

			{

				

				$to=$traineeDataArr['Trainee']['email'];

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

					

					

					$dataSet['MessageBoard']['trainer_id']=$trainerid;					

					$dataSet['MessageBoard']['client_id']=$clientid;

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

				

				$from=$traineeDataArr['Trainee']['email'];

				$to=$setSpecalistArr['Trainer']['email'];

				$fromName=$setSpecalistArr['Trainee']['full_name'];

				

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';

					if($setSpecalistArr['Trainer']['website_logo']){

					$content.='<img src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';

					}else{

						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';

					}

					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$traineeDataArr['Trainee']['username'].'!</p>

				<p> Client - '.$fromName.' sent message </p>

				<p>'.$message2.' </p>

				

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					

					

					$dataSet['MessageBoard']['trainer_id']=$trainerid;					

					$dataSet['MessageBoard']['client_id']=$clientid;

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

		
		/* Message reply fucntionality start */

		public function messageclubrp()

		{

			

			$this->layout = "";

			$this->autoRender=false;

			$uid = $this->Session->read('USER_ID');

			$dbusertype = $this->Session->read('UTYPE');					

			

	

		

			

			$postedby="C";

			if($dbusertype=='Trainer')

			{

				$postedby="T";

			}

			

			$message2=trim($_REQUEST['message']);

			$clientid=trim($_REQUEST['clientid']);

			$trainerid=trim($_REQUEST['trainerid']);

			$mes_pid=trim($_REQUEST['pmessageid']);
			$rptype=trim($_REQUEST['rptype']);

			

			

			

			

			$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$trainerid)));
			if($rptype=='ClubBranch'){
				 $traineeDataArr=$this->$rptype->find('first',array('conditions'=>array('ClubBranch.id'=>$clientid),'fields'=>array('ClubBranch.id','ClubBranch.username','ClubBranch.full_name','ClubBranch.email','ClubBranch.phone')));	
			}
			if($rptype=='Club'){
				 $traineeDataArr=$this->$rptype->find('first',array('conditions'=>array('Club.id'=>$clientid),'fields'=>array('Club.id','Club.username','Club.email','Club.full_name','Club.phone')));	
			}
			

			if($postedby=='T')

			{

				
				$to=$traineeDataArr[$rptype]['email'];
				
				

				$from=$setSpecalistArr['Trainer']['email'];

				$fromName=$setSpecalistArr['Trainer']['full_name'];

				

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';

					if($setSpecalistArr['Trainer']['website_logo']){

					$content.='<img src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';

					}else{

						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';

					}

					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$traineeDataArr[$rptype]['full_name'].'!</p>

				<p> Trainer - '.$fromName.' sent message </p>

				<p>'.$message2.' </p>

				

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					

					

					$dataSet['MessageBoard']['trainer_id']=$trainerid;					

					$dataSet['MessageBoard']['client_id']=0;
					if($rptype=='Club'){
					$dataSet['MessageBoard']['club_id']=$clientid;
					$dataSet['MessageBoard']['clubbranch_id']=0;
					}
					if($rptype=='ClubBranch'){
						$dataSet['MessageBoard']['club_id']=0;
					$dataSet['MessageBoard']['clubbranch_id']=$clientid;
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

				

				$from=$traineeDataArr[$rptype]['email'];

				$to=$setSpecalistArr['Trainer']['email'];

				$fromName=$setSpecalistArr[$rptype]['full_name'];

				

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';

					if($setSpecalistArr['Trainer']['website_logo']){

					$content.='<img src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';

					}else{

						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';

					}

					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$setSpecalistArr['Trainer']['full_name'].'!</p>

				<p> Club - '.$fromName.' sent message </p>

				<p>'.$message2.' </p>

				

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					

					

					$dataSet['MessageBoard']['trainer_id']=$trainerid;					

					$dataSet['MessageBoard']['client_id']=0;
					if($rptype=='Club'){
					$dataSet['MessageBoard']['clubbranch_id']=0;
					$dataSet['MessageBoard']['club_id']=$clientid;
					}
					if($rptype=='ClubBranch'){
					$dataSet['MessageBoard']['clubbranch_id']=$clientid;
					$dataSet['MessageBoard']['club_id']=0;
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

		

	public function add_exercise_history_temp()

	{

		$this->layout = '';

		$this->render = false;

		$id = $this->Session->read('USER_ID');

		

		$response=array();

		

		$exe1Count = count($_POST['nplayexercise']); 

		$exerciseCount1 = count($_POST['nplay1exercise']);

		$exerciseCount2 = count($_POST['nplay2exercise']);

		$exerciseCount3 = count($_POST['nplay3exercise']);

		$exerciseCount4 = count($_POST['nplay4exercise']);

		

		$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$_POST['trainee_id'])));

		

		$setClientArr = $this->TempWorkout->find('first',array('fields'=>array('max(TempWorkout.group_id) as maxva')));

		

		

		//$group_id=$setClientArr[0]['maxva'] + 1;
       $group_id=mt_rand();
		

		

		/*echo $group_id;

		exit;*/

		

		for($i=0;$i<$exe1Count;$i++)

		{

			

			$exercisedata['TempWorkout']['group_id']=$group_id;		    

			$exercisedata['TempWorkout']['exercise_type']="Workout";		    

			$exercisedata['TempWorkout']['name']=trim($_POST['workoutname']); 	    

			$exercisedata['TempWorkout']['category_id']=trim($_POST['workoutcategory']); 	    

			$exercisedata['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);		    

			$exercisedata['TempWorkout']['exercise']=trim($_POST['nplayexercise'][$i]);

			$exercisedata['TempWorkout']['set']=trim($_POST['nplayset'][$i]);

			$exercisedata['TempWorkout']['duration']=trim($_POST['nplayduration'][$i]);

			$exercisedata['TempWorkout']['coaching_tip']=trim($_POST['nplaycoaching_tip'][$i]);

			$exercisedata['TempWorkout']['added_date']=date('Y-m-d');

			

			

			if($exercisedata['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata);

				

			}

			

		}



				

				

		for($i=0;$i<$exerciseCount1;$i++)

		{

			

			$exercisedata1['TempWorkout']['group_id']=$group_id;		    

			$exercisedata1['TempWorkout']['exercise_type']="CORE";	

			$exercisedata1['TempWorkout']['name']=trim($_POST['workoutname']); 	    

			$exercisedata1['TempWorkout']['category_id']=trim($_POST['workoutcategory']); 

			$exercisedata1['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata1['TempWorkout']['exercise']=trim($_POST['nplay1exercise'][$i]);

			$exercisedata1['TempWorkout']['set']=trim($_POST['nplay1set'][$i]);

			$exercisedata1['TempWorkout']['rep']=trim($_POST['nplay1rep'][$i]);

			$exercisedata1['TempWorkout']['rest']=trim($_POST['nplay1rest'][$i]);

			$exercisedata1['TempWorkout']['temp']=trim($_POST['nplay1temp'][$i]);

			$exercisedata1['TempWorkout']['coaching_tip']=trim($_POST['nplay1coaching_tip'][$i]);

			$exercisedata1['TempWorkout']['added_date']=date('Y-m-d');

			

			

			

			if($exercisedata1['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata1);

				

			}

			



		}

		

	

		for($i=0;$i<$exerciseCount2;$i++)

		{

			

			$exercisedata2['TempWorkout']['group_id']=$group_id;		    

			$exercisedata2['TempWorkout']['exercise_type']="SPEED";

			$exercisedata2['TempWorkout']['name']=trim($_POST['workoutname']); 	    

			$exercisedata2['TempWorkout']['category_id']=trim($_POST['workoutcategory']);

			$exercisedata2['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata2['TempWorkout']['exercise']=trim($_POST['nplay2exercise'][$i]);

			$exercisedata2['TempWorkout']['set']=trim($_POST['nplay2set'][$i]);

			$exercisedata2['TempWorkout']['rep']=trim($_POST['nplay2rep'][$i]);

			$exercisedata2['TempWorkout']['rest']=trim($_POST['nplay2rest'][$i]);

			$exercisedata2['TempWorkout']['temp']=trim($_POST['nplay2temp'][$i]);

			$exercisedata2['TempWorkout']['coaching_tip']=trim($_POST['nplay2coaching_tip'][$i]);

			$exercisedata2['TempWorkout']['added_date']=date('Y-m-d');

			

			

			if($exercisedata2['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata2);

				

			}

			



		}

		

		for($i=0;$i<$exerciseCount3;$i++)

		{

			

			$exercisedata3['TempWorkout']['group_id']=$group_id;		    

			$exercisedata3['TempWorkout']['exercise_type']="RESISTANCE";

			$exercisedata3['TempWorkout']['name']=trim($_POST['workoutname']); 	    

			$exercisedata3['TempWorkout']['category_id']=trim($_POST['workoutcategory']);

			$exercisedata3['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata3['TempWorkout']['exercise']=trim($_POST['nplay3exercise'][$i]);

			$exercisedata3['TempWorkout']['set']=trim($_POST['nplay3set'][$i]);

			$exercisedata3['TempWorkout']['rep']=trim($_POST['nplay3rep'][$i]);

			$exercisedata3['TempWorkout']['rest']=trim($_POST['nplay3rest'][$i]);

			$exercisedata3['TempWorkout']['temp']=trim($_POST['nplay3temp'][$i]);

			$exercisedata3['TempWorkout']['coaching_tip']=trim($_POST['nplay3coaching_tip'][$i]);

			$exercisedata3['TempWorkout']['added_date']=date('Y-m-d');

			

			

			if($exercisedata3['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata3);

				

			}

			



		}

		

		for($i=0;$i<$exerciseCount4;$i++)

		{

			

			$exercisedata4['TempWorkout']['group_id']=$group_id;		    

			$exercisedata4['TempWorkout']['exercise_type']="COOL";

			$exercisedata4['TempWorkout']['name']=trim($_POST['workoutname']); 	    

			$exercisedata4['TempWorkout']['category_id']=trim($_POST['workoutcategory']);

			$exercisedata4['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata4['TempWorkout']['exercise']=trim($_POST['nplay4exercise'][$i]);

			$exercisedata4['TempWorkout']['set']=trim($_POST['nplay4set'][$i]);

			$exercisedata4['TempWorkout']['duration']=trim($_POST['nplay4duration'][$i]);

			$exercisedata4['TempWorkout']['coaching_tip']=trim($_POST['nplay4coaching_tip'][$i]);

			$exercisedata4['TempWorkout']['added_date']=date('Y-m-d');

			

			

			if($exercisedata4['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata4);

				

			}

			



		}

		

		$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have added Exercise History successfully.");

		

		echo json_encode($response);

		exit;		

		

	}

	

	public function saveworkoutdata()

	{

		

		$this->layout = '';

		$this->render = false;

		$uid = $this->Session->read('USER_ID');

		$clientid=trim($_POST['trainee_idsw']);

		$goalid_sw=trim($_POST['goalid_sw']);

		$workoutname1=trim($_POST['workoutname1']);

		$workoutcategory1=trim($_POST['workoutcategory1']);

		

		$goalArr=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$goalid_sw)));

		$startvaldt=$goalArr['Goal']['start'];

		$endvaldt=$goalArr['Goal']['end'];

		

		

		$response2=array();

		

		

		$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));



$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));



	$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

	

	 $setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

	 

	 $setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));

	 

	    $TempWorkoutArr = $this->TempWorkout->find('first',array('fields'=>array('max(TempWorkout.group_id)')));
		
		$group_id=mt_rand();

		

	    

		

		if(!empty($setWarmupArr))

			{

			

			  foreach($setWarmupArr as $key=>$val){

			  	

			  

		  // $val['WarmUps']['exercise']

			

			$exercisedata['TempWorkout']['group_id']=$group_id;		    

			$exercisedata['TempWorkout']['exercise_type']="Workout";		    

			$exercisedata['TempWorkout']['name']=$workoutname1; 	    

			$exercisedata['TempWorkout']['category_id']=$workoutcategory1; 	    

			$exercisedata['TempWorkout']['trainer_id']=$uid;		    

			$exercisedata['TempWorkout']['exercise']=trim($val['WarmUps']['exercise']);

			$exercisedata['TempWorkout']['set']=trim($val['WarmUps']['set']);

			$exercisedata['TempWorkout']['duration']=trim($val['WarmUps']['duration']);

			$exercisedata['TempWorkout']['coaching_tip']=trim($val['WarmUps']['coaching_tip']);

			$exercisedata['TempWorkout']['added_date']=date('Y-m-d');

			

			

			if($exercisedata['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata);

				

			}

					  	

			  }

			}

			

		if(!empty($setCoreBalancePlyometricArr))

			{

			

			  foreach($setCoreBalancePlyometricArr as $key=>$val){

			

			$exercisedata1['TempWorkout']['group_id']=$group_id;		    

			$exercisedata1['TempWorkout']['exercise_type']="CORE";		    

			$exercisedata1['TempWorkout']['name']=$workoutname1; 	    

			$exercisedata1['TempWorkout']['category_id']=$workoutcategory1; 	    

			$exercisedata1['TempWorkout']['trainer_id']=$uid;		    

			$exercisedata1['TempWorkout']['exercise']=trim($val['CoreBalancePlyometric']['exercise']);

			$exercisedata1['TempWorkout']['set']=trim($val['CoreBalancePlyometric']['set']);

			$exercisedata1['TempWorkout']['rep']=trim($val['CoreBalancePlyometric']['rep']);

			$exercisedata1['TempWorkout']['rest']=trim($val['CoreBalancePlyometric']['rest']);

			$exercisedata1['TempWorkout']['temp']=trim($val['CoreBalancePlyometric']['temp']);			

			$exercisedata1['TempWorkout']['coaching_tip']=trim($val['CoreBalancePlyometric']['coaching_tip']);

			$exercisedata1['TempWorkout']['added_date']=date('Y-m-d');

			

			

			if($exercisedata1['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata1);

				

			}

					  	

			  }

			}

			

			if(!empty($setSpeedAgilityQuicknessArr))

			{

			

			  foreach($setSpeedAgilityQuicknessArr as $key=>$val){

			  	

			  	

			 $exercisedata2['TempWorkout']['group_id']=$group_id;		    

			$exercisedata2['TempWorkout']['exercise_type']="SPEED";

			$exercisedata2['TempWorkout']['name']=$workoutname1; 	    

			$exercisedata2['TempWorkout']['category_id']=$workoutcategory1;

			$exercisedata2['TempWorkout']['trainer_id']=$uid;

			$exercisedata2['TempWorkout']['exercise']=trim($val['SpeedAgilityQuickness']['exercise']);

			$exercisedata2['TempWorkout']['set']=trim($val['SpeedAgilityQuickness']['set']);

			$exercisedata2['TempWorkout']['rep']=trim($val['SpeedAgilityQuickness']['rep']);

			$exercisedata2['TempWorkout']['rest']=trim($val['SpeedAgilityQuickness']['rest']);

			$exercisedata2['TempWorkout']['temp']=trim($val['SpeedAgilityQuickness']['temp']);

			$exercisedata2['TempWorkout']['coaching_tip']=trim($val['SpeedAgilityQuickness']['coaching_tip']);

			$exercisedata2['TempWorkout']['added_date']=date('Y-m-d');

			

			

			if($exercisedata2['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata2);

				

			}

			

					  	

			  }

			}

			

			if(!empty($setResistenceArr))

			{

			

			  foreach($setResistenceArr as $key=>$val){

			  	

			  	$exercisedata3['TempWorkout']['group_id']=$group_id;		    

			$exercisedata3['TempWorkout']['exercise_type']="RESISTANCE";

			$exercisedata3['TempWorkout']['name']=$workoutname1; 	    

			$exercisedata3['TempWorkout']['category_id']=$workoutcategory1;

			$exercisedata3['TempWorkout']['trainer_id']=$uid;

			$exercisedata3['TempWorkout']['exercise']=trim($val['Resistence']['exercise']);

			$exercisedata3['TempWorkout']['set']=trim($val['Resistence']['set']);

			$exercisedata3['TempWorkout']['rep']=trim($val['Resistence']['rep']);

			$exercisedata3['TempWorkout']['rest']=trim($val['Resistence']['rest']);

			$exercisedata3['TempWorkout']['temp']=trim($val['Resistence']['temp']);

			$exercisedata3['TempWorkout']['coaching_tip']=trim($val['Resistence']['coaching_tip']);

			$exercisedata3['TempWorkout']['added_date']=date('Y-m-d');

			

			

			if($exercisedata3['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata3);

				

			}

			  	

					  	

			  }

			}

			

			if(!empty($setCoolDownArr))

			{

			

			  foreach($setCoolDownArr as $key=>$val){

			  	

			  	$exercisedata4['TempWorkout']['group_id']=$group_id;		    

			$exercisedata4['TempWorkout']['exercise_type']="COOL";

			$exercisedata4['TempWorkout']['name']=$workoutname1;  	    

			$exercisedata4['TempWorkout']['category_id']=$workoutcategory1;

			$exercisedata4['TempWorkout']['trainer_id']=trim($uid);

			$exercisedata4['TempWorkout']['exercise']=trim($val['CoolDown']['exercise']);

			$exercisedata4['TempWorkout']['set']=trim($val['CoolDown']['set']);

			$exercisedata4['TempWorkout']['duration']=trim($val['CoolDown']['duration']);

			$exercisedata4['TempWorkout']['coaching_tip']=trim($val['CoolDown']['coaching_tip']);

			$exercisedata4['TempWorkout']['added_date']=date('Y-m-d');

			

			

			if($exercisedata4['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata4);

				

			}  	

			  }

			}

		

		$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have saved this workout.");

		echo json_encode($response);

		exit;		

		

	}



	

	public function repeatWorkoutData()

	{

		

		$this->layout = '';

		$this->render = false;

		$uid = $this->Session->read('USER_ID');

		$goalid_sw=trim($_POST['goalid_RW']);

		$goalArr=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$goalid_sw)));

		

		$clientid=$goalArr['Goal']['trainee_id'];

		$startvaldt=$goalArr['Goal']['start'];

		$endvaldt=$goalArr['Goal']['end'];

		$nextdt=trim($_POST['sessTypeRW1']);

		

		

		$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));





$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));





$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));



$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

			



 $setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

 

 $scheduleCalendars=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$nextdt),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.start','ScheduleCalendar.end')));

 /*echo '<pre>';

 print_r($scheduleCalendars);

  echo '</pre>';

 die();

 */

 		  if(!empty($goalArr))

           {

             foreach($goalArr as $key=>$val)

             {

             	$setwarpGoal=array();

             	

             	$setwarpGoal['Goal']['trainee_id']=$clientid;

             	$setwarpGoal['Goal']['trainer_id']=$uid;

             	$setwarpGoal['Goal']['exercise']=$val['Goal']['goal'];

             	$setwarpGoal['Goal']['set']=$val['Goal']['note'];

             	$setwarpGoal['Goal']['duration']=$val['Goal']['phase'];

             	$setwarpGoal['Goal']['coaching_tip']=$val['Goal']['alert'];

             	$setwarpGoal['Goal']['added_date']=date('Y-m-d H:i:s');

             	$setwarpGoal['Goal']['start']=$scheduleCalendars['ScheduleCalendar']['start'];

             	$setwarpGoal['Goal']['end']=$scheduleCalendars['ScheduleCalendar']['end'];

             	

             	$this->Goal->saveAll($setwarpGoal);

             	

             }

           }



 

 		  if(!empty($setWarmupArr))

           {

             foreach($setWarmupArr as $key=>$val)

             {

             	$setwarp=array();

             	

             	$setwarp['WarmUps']['trainee_id']=$clientid;

             	$setwarp['WarmUps']['trainer_id']=$uid;

             	$setwarp['WarmUps']['exercise']=$val['WarmUps']['exercise'];

             	$setwarp['WarmUps']['set']=$val['WarmUps']['set'];

             	$setwarp['WarmUps']['duration']=$val['WarmUps']['duration'];

             	$setwarp['WarmUps']['coaching_tip']=$val['WarmUps']['coaching_tip'];

             	$setwarp['WarmUps']['added_date']=date('Y-m-d H:i:s');

             	$setwarp['WarmUps']['start']=$scheduleCalendars['ScheduleCalendar']['start'];

             	$setwarp['WarmUps']['end']=$scheduleCalendars['ScheduleCalendar']['end'];

             	

             	$this->WarmUps->saveAll($setwarp);

             	

             }

           }

         

           

           if(!empty($setCoreBalancePlyometricArr))

           {

             foreach($setCoreBalancePlyometricArr as $key2=>$val2)

             {

             	$setwarp2=array();

             	

             	$setwarp2['CoreBalancePlyometric']['trainee_id']=$clientid;

             	$setwarp2['CoreBalancePlyometric']['trainer_id']=$uid;

             	$setwarp2['CoreBalancePlyometric']['exercise']=$val2['CoreBalancePlyometric']['exercise'];

             	$setwarp2['CoreBalancePlyometric']['set']=$val2['CoreBalancePlyometric']['set'];

             	$setwarp2['CoreBalancePlyometric']['rep']=$val2['CoreBalancePlyometric']['rep'];

             	$setwarp2['CoreBalancePlyometric']['temp']=$val2['CoreBalancePlyometric']['temp'];

             	$setwarp2['CoreBalancePlyometric']['rest']=$val2['CoreBalancePlyometric']['rest'];

             	$setwarp2['CoreBalancePlyometric']['coaching_tip']=$val2['CoreBalancePlyometric']['coaching_tip'];

             	$setwarp2['CoreBalancePlyometric']['added_date']=date('Y-m-d H:i:s');

             	$setwarp2['CoreBalancePlyometric']['start']=$scheduleCalendars['ScheduleCalendar']['start'];

             	$setwarp2['CoreBalancePlyometric']['end']=$scheduleCalendars['ScheduleCalendar']['end'];

             	

             	$this->CoreBalancePlyometric->saveAll($setwarp2);

             	

             }

           }

           

           if(!empty($setSpeedAgilityQuicknessArr))

           {

             foreach($setSpeedAgilityQuicknessArr as $key3=>$val3)

             {

             	$setwarp3=array();

             	

             	$setwarp3['SpeedAgilityQuickness']['trainee_id']=$clientid;

             	$setwarp3['SpeedAgilityQuickness']['trainer_id']=$uid;

             	$setwarp3['SpeedAgilityQuickness']['exercise']=$val3['SpeedAgilityQuickness']['exercise'];

             	$setwarp3['SpeedAgilityQuickness']['set']=$val3['SpeedAgilityQuickness']['set'];

             	$setwarp3['SpeedAgilityQuickness']['rep']=$val3['SpeedAgilityQuickness']['rep'];

             	$setwarp3['SpeedAgilityQuickness']['temp']=$val3['SpeedAgilityQuickness']['temp'];

             	$setwarp3['SpeedAgilityQuickness']['rest']=$val3['SpeedAgilityQuickness']['rest'];

             	$setwarp3['SpeedAgilityQuickness']['coaching_tip']=$val3['SpeedAgilityQuickness']['coaching_tip'];

             	$setwarp3['SpeedAgilityQuickness']['added_date']=date('Y-m-d H:i:s');

             	$setwarp3['SpeedAgilityQuickness']['start']=$scheduleCalendars['ScheduleCalendar']['start'];

             	$setwarp3['SpeedAgilityQuickness']['end']=$scheduleCalendars['ScheduleCalendar']['end'];

             	

             	$this->SpeedAgilityQuickness->saveAll($setwarp3);

             	

             }

           }

           

           

           if(!empty($setResistenceArr))

           {

             foreach($setResistenceArr as $key4=>$val4)

             {

             	$setwarp4=array();

             	

             	$setwarp4['Resistence']['trainee_id']=$clientid;

             	$setwarp4['Resistence']['trainer_id']=$uid;

             	$setwarp4['Resistence']['exercise']=$val4['Resistence']['exercise'];

             	$setwarp4['Resistence']['set']=$val4['Resistence']['set'];

             	$setwarp4['Resistence']['rep']=$val4['Resistence']['rep'];

             	$setwarp4['Resistence']['temp']=$val4['Resistence']['temp'];

             	$setwarp4['Resistence']['rest']=$val4['Resistence']['rest'];

             	$setwarp4['Resistence']['coaching_tip']=$val4['Resistence']['coaching_tip'];

             	$setwarp4['Resistence']['added_date']=date('Y-m-d H:i:s');

             	$setwarp4['Resistence']['start']=$scheduleCalendars['ScheduleCalendar']['start'];

             	$setwarp4['Resistence']['end']=$scheduleCalendars['ScheduleCalendar']['end'];

             	

             	$this->Resistence->saveAll($setwarp4);

             	

             }

           }

           

           if(!empty($setCoolDownArr))

           {

             foreach($setCoolDownArr as $key5=>$val5)

             {

             	$setwarp5=array();

             	

             	$setwarp5['CoolDown']['trainee_id']=$clientid;

             	$setwarp5['CoolDown']['trainer_id']=$uid;

             	$setwarp5['CoolDown']['exercise']=$val5['CoolDown']['exercise'];

             	$setwarp5['CoolDown']['set']=$val5['CoolDown']['set'];

             	$setwarp5['CoolDown']['rep']=$val5['CoolDown']['duration'];

             	$setwarp5['CoolDown']['coaching_tip']=$val5['CoolDown']['coaching_tip'];

             	$setwarp5['CoolDown']['added_date']=date('Y-m-d H:i:s');

             	$setwarp5['CoolDown']['start']=$scheduleCalendars['ScheduleCalendar']['start'];

             	$setwarp5['CoolDown']['end']=$scheduleCalendars['ScheduleCalendar']['end'];

             	

             	$this->CoolDown->saveAll($setwarp5);

             	

             }

           }

 

 

		

		$datav['ScheduleCalendar']['id']=trim($nextdt);

		$datav['ScheduleCalendar']['mapwrkt']=1;

        $this->ScheduleCalendar->save($datav);   

           

		$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have repeat this workout.");

		echo json_encode($response);

		exit;		

		

	}

	

	public function exercise_viewsaveworkout($wrkid=null)

	{

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'exercise_history');

		$this->set("wrkid",$wrkid);

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));

		  $this->set("setSpecalistArr",$setSpecalistArr);
		  
		  $club_trai_id = $setSpecalistArr['Trainer']['club_id'];
$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
$this->set("setSpecalistArr1",$setSpecalistArr1);

		  

		 /* $this->TempWorkout->bindModel(array("belongsTo"=>array("WorkoutCategory"=>array("foreignKey"=>"category_id"))));

		    	   

		    	   

		

		        $this->TempWorkout->recursive = 2;*/

		 

		 $this->set("WorkoutCate",$this->WorkoutCategory->find('all',array('conditions'=>array('WorkoutCategory.status'=>1),'fields'=>array('WorkoutCategory.id','WorkoutCategory.name'))));

		 

		 $this->set("WorkoutCatenew",$this->WorkoutCategory->find('list',array('conditions'=>array('WorkoutCategory.trainerId'=>$uid),'fields'=>array('WorkoutCategory.id','WorkoutCategory.name'))));

		 

		 if($wrkid!='') 

		 {

		  	$this->set("tempwrkt",$this->TempWorkout->find('all',array('conditions'=>array('TempWorkout.trainer_id'=>$uid,'TempWorkout.category_id'=>$wrkid),'fields'=>array('DISTINCT TempWorkout.group_id,TempWorkout.trainer_id,TempWorkout.category_id,TempWorkout.name'))));

		 }else{		  

		  $this->set("tempwrkt",$this->TempWorkout->find('all',array('conditions'=>array('TempWorkout.trainer_id'=>$uid),'fields'=>array('DISTINCT TempWorkout.group_id,TempWorkout.trainer_id,TempWorkout.category_id,TempWorkout.name'))));

		 }

		  

		/*,'TempWorkout.trainer_id','TempWorkout.category_id','TempWorkout.name','TempWorkout.exercise','TempWorkout.set','TempWorkout.rep','TempWorkout.temp','TempWorkout.rest','TempWorkout.coaching_tip','TempWorkout.duration','TempWorkout.exercise_type'*/

		  

		  $this->set("trainee",$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$uid,'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.full_name ASC'),'fields'=>array('Trainee.id','Trainee.full_name'))));
		  
		  $this->set("groupclient",$this->Group->find('list',array('conditions'=>array('Group.trainer_id'=>$uid),'order'=>array('Group.group_name ASC'),'fields'=>array('Group.id','Group.group_name'))));

		

	}

	public function savedwrktshow()

	{

		$this->layout="";

		$this->autoRender=false;

		$clientId=trim($_REQUEST['clientid']);

		$groupid=trim($_REQUEST['groupid']);
		
		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');

		

		 //$tempwrkt=$this->TempWorkout->find('all',array('conditions'=>array('TempWorkout.trainer_id'=>$uid,'TempWorkout.group_id'=>$groupid)));
		 
		  $tempwrkt=$this->TempWorkout->find('all',array('conditions'=>array('TempWorkout.trainer_id'=>$uid,'TempWorkout.group_id'=>$groupid),'order'=>array('TempWorkout.id ASC')));

		 

		 $clientData=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>$clientId)));

		 

		 $goals=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientId),'order' => array('Goal.id' => 'DESC')));

		 

		 $scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientId,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0', 'ScheduleCalendar.status <>'=>'0'),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));

		 

		/* echo"<pre>";

		 print_r($scheduleCalendars);

		 echo"</pre>";exit;*/

		 

		

		echo '<form onsubmit="return validatefrmsfd();" method="POST" action="" id="addexercise">

      

        

         <div style="display: none;" class="loaderResultFd"><img src="http://www.sampatti.com/fitnessAaland/images/ajax-loader.gif"></div> <div id="notificatin_mesFd" style="color:#ff0000; padding:4px 0 4px 0;"></div>

         <input type="hidden" value="'.$uid.'" id="trainer_id" name="trainer_id">

         <input type="hidden" value="'.$clientId.'" id="trainee_id" name="trainee_id">

         <input type="hidden" value="" id="added_date" name="added_date">

         

       

            

       

         

         <table width="100%" border="1" id="a">

				

				<tbody><tr class="slectedmn">

				<td width="100%" class="th2" colspan="4"><h3 style="text-align:left;float:left;">Client Name:   </h3> <span style="float: left; line-height: 32px;  padding: 10px 5px 5px;" id="clnamewt">'.$clientData['Trainee']['full_name'].'</span>

				</td>

					

				

				

				</tr>

				

				

				

				

				

				<tr class="slectedmn">

			

				<td width="100%" colspan="4"> <span style="line-height:34px;float:left;">Session Availability:</span>

				 <div class="twelve  form-select columns"> <select name="sessType" class="sltbx" onchange="document.getElementById(\'CustomSessiontype\').value= this.options[this.selectedIndex].text" id="ScheduleCalendarTimeslot">

<option value="">-- Session Availability --</option>';

		

		

		foreach($scheduleCalendars as $scheduleCalendar)

		{

             

				echo '<option value="'.$scheduleCalendar['ScheduleCalendar']['id'].'">'.date('m-d-Y h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['start'])).' - '.date('h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['end'])).'</option>';

     

		}                 



echo '





</select>

                    

												      

			

                <input type="text" value="-- Session Type --" name="sessTypet" id="CustomSessiontype">

				

                

               

              </div>

				</td>		

				

				

				

				</tr>

				

				

				

				

				

				

				

			</tbody></table>

				



			<table width="100%" border="1" id="b">

			<tbody><tr class="slectedmn">

				<td class="th2" colspan="3"><span style="float: left; line-height: 36px;">Goal:</span> <input type="text" style="width:220px;" value="'.$goals['Goal']['goal'].'" id="goal" name="goal"></td><td> <span style="float: left; line-height: 36px;">Phase:</span> <input type="text" style="width:100px;" value="'.$goals['Goal']['phase'].'" id="phase" name="phase"></td>

				

				

				</tr>

			</tbody></table>	

			

			<table width="100%" border="1" id="c">

			<tbody><tr class="slectedmn">

				<td class="th2"><span style="float: left; line-height: 36px;">Note:</span><textarea style="width: 94%;" name="note" id="note">'.$goals['Goal']['note'].'</textarea></td>

				

				

				</tr>

			</tbody></table>

			

			<table width="100%" border="1" id="d">

			<tbody><tr class="slectedmn">

				<td class="th2"><span style="float: left; line-height: 36px;">Alert:</span><textarea style="width: 94%;" name="alert" id="alert" readonly="readonly">'.$goals['Goal']['alert'].'</textarea></td>

				

				

				</tr>

			</tbody></table>	

			

			 <table width="100%" border="1" id="w">

				<tbody><tr class="slectedmn">

				<td class="th2" colspan="5"><h3 style="text-align:left;">Warm-Up </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Duration</th>

				<th class="throw">Coaching Tip</th>

				<th class="throw"></th>

				

				</tr>';
				$i = 1;
				foreach ($tempwrkt as $tempwrkts) {

					if($tempwrkts['TempWorkout']['exercise_type']=='Workout'){

				
				echo '<tr id="pn-play1_'.$i.'">
				

	    

		     <td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplayexercise[]" id="exercise"></td>

		     <td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'"  id="set" name="nplayset[]"></td>

		     <td><input type="text" placeholder="Duration" value="'.$tempwrkts['TempWorkout']['duration'].'"  id="duration" name="nplayduration[]"></td>

		     <td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'"  id="coaching_tip" name="nplaycoaching_tip[]"></td>

		      <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'pn-play1_'.$i.'\')" href="javascript:void(0);">Remove</a></td>

		     

		     

		    

		     </tr>';

					}
				$i++;
				}

		     



    

	     

	    

	     

     

     echo '</tbody></table>   

     

	      

     <table width="100%" border="1" id="cbp">

     <tbody><tr class="slectedmn">

				<td class="th2" colspan="7"><h3 style="text-align:left;">CORE/BALANCE/PLYOMETRIC </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Reps</th>

				<th class="throw">Weight</th>

				<th class="throw">Rest</th>

				<th class="throw">Coaching Tip</th>

				<th></th><th>

				</th></tr>';

				$i=1;
				
				foreach ($tempwrkt as $tempwrkts) {

					if($tempwrkts['TempWorkout']['exercise_type']=='CORE'){

				echo '<tr id="pn-play2_'.$i.'">
				
				

	    

		     <td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplay1exercise[]" id="exercise"></td>

		     <td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'" id="set" name="nplay1set[]"></td>

		     <td><input type="text" placeholder="Reps" value="'.$tempwrkts['TempWorkout']['rep'].'" id="rep" name="nplay1rep[]"></td>

		     <td><input type="text" placeholder="Weight" value="'.$tempwrkts['TempWorkout']['temp'].'" id="temp" name="nplay1temp[]"></td>

		     <td><input type="text" placeholder="Rest" value="'.$tempwrkts['TempWorkout']['rest'].'" id="rest" name="nplay1rest[]"></td>

		     <td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'" id="coaching_tip" name="nplay1coaching_tip[]"></td>

            <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'pn-play2_'.$i.'\')" href="javascript:void(0);">Remove</a></td>    

		          

	     

	     </tr>';
		 
$i++;
					}

				}

	     

     echo  '</tbody></table> 

      

      

       <table width="100%" border="1" id="saq">

     <tbody><tr class="slectedmn">

				<td class="th2" colspan="7"><h3 style="text-align:left;">SPEED/AGILITY/QUICKNESS </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Reps</th>

				<th class="throw">Weight</th>

				<th class="throw">Rest</th>

				<th class="throw">Coaching Tip</th>

				<th></th><th>

				</th></tr>';

				
				$i = 1;
				foreach ($tempwrkt as $tempwrkts) {

					if($tempwrkts['TempWorkout']['exercise_type']=='SPEED'){

				echo '<tr id="pn-play3_'.$i.'">

	    

		     <td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplay2exercise[]" id="exercise"></td>

		     <td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'" id="set" name="nplay2set[]"></td>

		     <td><input type="text" placeholder="Reps"  value="'.$tempwrkts['TempWorkout']['rep'].'" id="rep" name="nplay2rep[]"></td>

		     <td><input type="text" placeholder="Weight" value="'.$tempwrkts['TempWorkout']['temp'].'" id="temp" name="nplay2temp[]"></td>

		     <td><input type="text" placeholder="Rest" value="'.$tempwrkts['TempWorkout']['rest'].'"  id="rest" name="nplay2rest[]"></td>

		     <td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'" id="coaching_tip" name="nplay2coaching_tip[]"></td>

		     <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'pn-play3_'.$i.'\')" href="javascript:void(0);">Remove</a></td>

	     

	     </tr>';
		 $i++;

					}

		}

	    

      echo '</tbody></table> 

      

      

       <table width="100%" border="1" id="res">

     <tbody><tr class="slectedmn">

				<td class="th2" colspan="7"><h3 style="text-align:left;">RESISTANCE </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Reps</th>

				<th class="throw">Weight</th>

				<th class="throw">Rest</th>

				<th class="throw">Coaching Tip</th>

				<th></th>

				</tr>';

				
				$i = 1;
				foreach ($tempwrkt as $tempwrkts) {

					if($tempwrkts['TempWorkout']['exercise_type']=='RESISTANCE'){

				
echo '<tr id="pn-play4_'.$i.'">

	    

		     <td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplay3exercise[]" id="exercise"></td>

		     <td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'" id="set" name="nplay3set[]"></td>

		     <td><input type="text" placeholder="Reps" value="'.$tempwrkts['TempWorkout']['rep'].'"  id="rep" name="nplay3rep[]"></td>

		     <td><input type="text" placeholder="Weight" value="'.$tempwrkts['TempWorkout']['temp'].'" id="temp" name="nplay3temp[]"></td>

		     <td><input type="text" placeholder="Rest" value="'.$tempwrkts['TempWorkout']['rest'].'" id="rest" name="nplay3rest[]"></td>

		     <td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'" id="coaching_tip" name="nplay3coaching_tip[]"></td>

		     <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'pn-play4_'.$i.'\')" href="javascript:void(0);">Remove</a></td>

		          

	     

	     </tr>'; $i++;}

					}

	     

      echo '</tbody></table> 

       

      

      <table width="100%" border="1" id="cd">

				<tbody><tr class="slectedmn">

				<td class="th2" colspan="5"><h3 style="text-align:left;">COOL-DOWN </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Duration</th>

				<th class="throw">Coaching Tip</th>

				<th></th>

				</tr>';

				
				$i = 1;
				foreach ($tempwrkt as $tempwrkts) {

					if($tempwrkts['TempWorkout']['exercise_type']=='COOL'){

				echo '<tr id="pn-play5_'.$i.'">

	    

		     <td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplay4exercise[]" id="exercise"></td>

		     <td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'" id="set" name="nplay4set[]"></td>

		     <td><input type="text" placeholder="Duration" value="'.$tempwrkts['TempWorkout']['duration'].'" id="duration" name="nplay4duration[]"></td>

		     <td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'" id="coaching_tip" name="nplay4coaching_tip[]"></td>

		     <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'pn-play5_'.$i.'\')" href="javascript:void(0);">Remove</a></td>

		          

	     

	     </tr>';
$i++;
					}

				}

     

     echo '</tbody></table>  

    

     

     <div class="twelve already-member columns">

                          <input type="submit" class="submit-nav" name="" id="svca" value="Send To Calendar">

                       </div>

            </form>';

	}

	

	

	

	public function savedwrktview()

	{

		$this->layout="";

		$this->autoRender=false;

		

		$groupid=trim($_REQUEST['groupid']);

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');

		

		 $tempwrkt=$this->TempWorkout->find('all',array('conditions'=>array('TempWorkout.trainer_id'=>$uid,'TempWorkout.group_id'=>$groupid),'order'=>array('TempWorkout.id ASC')));

		 

		

		 

		

		echo '<form onsubmit="return validatefrmsfdsav();" method="POST" action="" id="addexercisesav">

      

        

         <div style="display: none;" class="loaderResultFdsav"><img src="http://www.sampatti.com/fitnessAaland/images/ajax-loader.gif"></div> <div id="notificatin_mesFd" style="color:#ff0000; padding:4px 0 4px 0;"></div>

         <input type="hidden" value="'.$tempwrkt[0]['TempWorkout']['trainer_id'].'" id="trainer_id" name="trainer_id">

         <input type="hidden" value="'.$tempwrkt[0]['TempWorkout']['category_id'].'" id="workoutcategory" name="workoutcategory">

         <input type="hidden" value="'.$tempwrkt[0]['TempWorkout']['name'].'" id="workoutname" name="workoutname">

         <input type="hidden" value="'.$groupid.'" id="group_id" name="group_id">

        

         <input type="hidden" value="" id="added_date" name="added_date">

         			

			 <table width="100%" border="1" id="wa">

				<tbody><tr class="slectedmn">

				<td class="th2" colspan="5"><h3 style="text-align:left;">Warm-Up </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Duration</th>

				<th class="throw">Coaching Tip</th>

				<th class="throw"></th>

				

				</tr>';
				$i = 1;
				foreach ($tempwrkt as $tempwrkts) {

					if($tempwrkts['TempWorkout']['exercise_type']=='Workout'){

				echo '<tr id="on-play1_'.$i.'">

	    

		     <td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplayexercise[]" id="exercise"></td>

		     <td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'"  id="set" name="nplayset[]"></td>

		     <td><input type="text" placeholder="Duration" value="'.$tempwrkts['TempWorkout']['duration'].'"  id="duration" name="nplayduration[]"></td>

		     <td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'"  id="coaching_tip" name="nplaycoaching_tip[]"></td>

		    <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'on-play1_'.$i.'\')" href="javascript:void(0);">Remove</a></td>

		     

		     

		    

		     </tr>';
			$i++;
					}

				}

		     



    

	     

	    

	     

     

     echo '</tbody></table>   

     <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id="addButtona" onclick="addNPlaya(\'wa\');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 

	      </div>

	      

     <table width="100%" border="1" id="cbpa">

     <tbody><tr class="slectedmn">

				<td class="th2" colspan="7"><h3 style="text-align:left;">CORE/BALANCE/PLYOMETRIC </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Reps</th>

				<th class="throw">Weight</th>

				<th class="throw">Rest</th>

				<th class="throw">Coaching Tip</th>

				<th></th><th>

				</th></tr>';

				
		$i = 1;
				foreach ($tempwrkt as $tempwrkts) {

					if($tempwrkts['TempWorkout']['exercise_type']=='CORE'){

				echo '<tr id="on-play2_'.$i.'">

	    

		     <td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplay1exercise[]" id="exercise"></td>

		     <td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'" id="set" name="nplay1set[]"></td>

		     <td><input type="text" placeholder="Reps" value="'.$tempwrkts['TempWorkout']['rep'].'" id="rep" name="nplay1rep[]"></td>

		     <td><input type="text" placeholder="Weight" value="'.$tempwrkts['TempWorkout']['temp'].'" id="temp" name="nplay1temp[]"></td>

		     <td><input type="text" placeholder="Rest" value="'.$tempwrkts['TempWorkout']['rest'].'" id="rest" name="nplay1rest[]"></td>

		     <td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'" id="coaching_tip" name="nplay1coaching_tip[]"></td>

             <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'on-play2_'.$i.'\')" href="javascript:void(0);">Remove</a></td>    

		          

	     

	     </tr>';
				$i++;
					}

				}

	     

     echo  '</tbody></table> 

      <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id="addButton1a" onclick="addNPlay1a(\'cbpa\');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 

	      </div>

      

       <table width="100%" border="1" id="saqa">

     <tbody><tr class="slectedmn">

				<td class="th2" colspan="7"><h3 style="text-align:left;">SPEED/AGILITY/QUICKNESS </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Reps</th>

				<th class="throw">Weight</th>

				<th class="throw">Rest</th>

				<th class="throw">Coaching Tip</th>

				<th></th><th>

				</th></tr>';

				
$i =1;
				foreach ($tempwrkt as $tempwrkts) {

					if($tempwrkts['TempWorkout']['exercise_type']=='SPEED'){

				echo '<tr id="on-play3_'.$i.'">

	    

		     <td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplay2exercise[]" id="exercise"></td>

		     <td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'" id="set" name="nplay2set[]"></td>

		     <td><input type="text" placeholder="Reps"  value="'.$tempwrkts['TempWorkout']['rep'].'" id="rep" name="nplay2rep[]"></td>

		     <td><input type="text" placeholder="Weight" value="'.$tempwrkts['TempWorkout']['temp'].'" id="temp" name="nplay2temp[]"></td>

		     <td><input type="text" placeholder="Rest" value="'.$tempwrkts['TempWorkout']['rest'].'"  id="rest" name="nplay2rest[]"></td>

		     <td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'" id="coaching_tip" name="nplay2coaching_tip[]"></td>

		     <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'on-play3_'.$i.'\')" href="javascript:void(0);">Remove</a></td>

	     

	     </tr>';
$i++;
					}

		}

	    

      echo '</tbody></table> 

      <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id="addButton2a" onclick="addNPlay2a(\'saqa\');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 

	      </div> 

      

       <table width="100%" border="1" id="resa">

     <tbody><tr class="slectedmn">

				<td class="th2" colspan="7"><h3 style="text-align:left;">RESISTANCE </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Reps</th>

				<th class="throw">Weight</th>

				<th class="throw">Rest</th>

				<th class="throw">Coaching Tip</th>

				<th></th>

				</tr>';

				
$i = 1;
				foreach ($tempwrkt as $tempwrkts) {

					if($tempwrkts['TempWorkout']['exercise_type']=='RESISTANCE'){

				echo '<tr id="on-play4_'.$i.'">

	    

		     <td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplay3exercise[]" id="exercise"></td>

		     <td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'" id="set" name="nplay3set[]"></td>

		     <td><input type="text" placeholder="Reps" value="'.$tempwrkts['TempWorkout']['rep'].'"  id="rep" name="nplay3rep[]"></td>

		     <td><input type="text" placeholder="Weight" value="'.$tempwrkts['TempWorkout']['temp'].'" id="temp" name="nplay3temp[]"></td>

		     <td><input type="text" placeholder="Rest" value="'.$tempwrkts['TempWorkout']['rest'].'" id="rest" name="nplay3rest[]"></td>

		     <td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'" id="coaching_tip" name="nplay3coaching_tip[]"></td>

		     <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'on-play4_'.$i.'\')" href="javascript:void(0);">Remove</a></td>
		          

	     

	     </tr>'; $i++;}

					}

	     

      echo '</tbody></table> 

       <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id=\'addButton3a\' onclick="addNPlay3a(\'resa\');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 

	      </div>

      

      <table width="100%" border="1" id="cda">

				<tbody><tr class="slectedmn">

				<td class="th2" colspan="5"><h3 style="text-align:left;">COOL-DOWN </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Duration</th>

				<th class="throw">Coaching Tip</th>

				<th></th>

				</tr>';

				
$i =1;
				foreach ($tempwrkt as $tempwrkts) {

					if($tempwrkts['TempWorkout']['exercise_type']=='COOL'){

				echo '<tr id="on-play5_'.$i.'">

	    

		     <td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplay4exercise[]" id="exercise"></td>

		     <td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'" id="set" name="nplay4set[]"></td>

		     <td><input type="text" placeholder="Duration" value="'.$tempwrkts['TempWorkout']['duration'].'" id="duration" name="nplay4duration[]"></td>

		     <td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'" id="coaching_tip" name="nplay4coaching_tip[]"></td>

		    <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'on-play5_'.$i.'\')" href="javascript:void(0);">Remove</a></td>
		          

		          

	     

	     </tr>'; $i++;

					}

				}

     

     echo '</tbody></table>  

     <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id=\'addButton4a\' onclick="addNPlay4a(\'cda\');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 

	      </div>

    

     <div class="twelve already-member columns">

                          <input type="submit" value="Save" id="EditWorkoutSaved" name="" class="submit-nav" >

                       </div>

    

            </form>';

	}

	

	

	public function getSavedWorkoutList()

	{

		$goalId    = $_POST['q'];

		$traineeId = $_POST['traineeId'];

		$setGoalArrs=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$goalId)));	

		

		$trainerId = $this->Session->read('USER_ID');						

		$startDate = $setGoalArrs['Goal']['start'];

		$endDate   = $setGoalArrs['Goal']['end'];

		

		$getCalendarDetails=$this->ScheduleCalendar->find("all",array("conditions"=>array("ScheduleCalendar.trainer_id"=>$trainerId,"ScheduleCalendar.trainee_id "=>$traineeId,"ScheduleCalendar.start >"=> $startDate,"ScheduleCalendar.mapwrkt <>"=> 1,'ScheduleCalendar.appointment_type'=>'Booked',"ScheduleCalendar.status <>"=> 0)));	
		
		// $scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientId,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0', 'ScheduleCalendar.status <>'=>'0'),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));

		

		$schList = '<option value="">-- Session Availability --</option>';

		

		foreach($getCalendarDetails as $totSch)

		{

			//$schList['id'] = $totSch['ScheduleCalendar']['id'];

			//$schList[$totSch['ScheduleCalendar']['id']] = $totSch['ScheduleCalendar']['start'].' - '.$totSch['ScheduleCalendar']['end'];

			$schList .= "<option value=".$totSch['ScheduleCalendar']['id'].">".date('m/d/Y h:i A',strtotime($totSch['ScheduleCalendar']['start'])).' - '.date('h:i A',strtotime($totSch['ScheduleCalendar']['end']))."</option>";

		}

		//echo"<pre>";

		echo $schList;

		//echo"</pre>";

		exit;

	}

	

	public function workout_cate()

	{

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'exercise_history');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		

		$this->set("setSpecalistArr",$setSpecalistArr);

		

		 

		 $this->set("WorkoutCate",$this->WorkoutCategory->find('all',array('conditions'=>array('WorkoutCategory.trainerId'=>$uid),'fields'=>array('WorkoutCategory.id','WorkoutCategory.name','WorkoutCategory.status'))));

		  

	}

	

	public function editwrktshow()

	{

		$this->layout = '';

		$this->autoRender = false;

		$id = $this->Session->read('USER_ID');

		$na = base64_decode($_POST['str']);

		

		 

		 $WorkoutCate = $this->WorkoutCategory->find('all',array('conditions'=>array('WorkoutCategory.id'=>$na),'fields'=>array('WorkoutCategory.name')));

		 

		 $WorkoutCatee = $WorkoutCate['0']['WorkoutCategory']['name'];

		 

		 $response = array("responseclassName"=>"nSuccess","errorMsg"=>$WorkoutCatee);  

		

		 echo $WorkoutCatee;

		 exit;

		  

	}
	
		
	public function deletewrkoutcat()

		{

			$this->layout = '';

			$this->render = false;

			if(trim($_POST['id'])!='')

			{

				$datav=array();				

				//$datav['id']=trim($_POST['id']);
				
				$datav['id']=trim($_POST['id']);
				//$datav['status']=0;
				
				if($this->WorkoutCategory->delete($datav))
				/*if($this->Trainee->save($datav))*/ {

							

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully deleted");
							
							//$this->redirect('/home/workout_cate/');

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
	
	

	 public function getcatval()

	{

		$this->layout = '';

		$this->autoRender = false;

		$id = $this->Session->read('USER_ID');
		
		
		 $checkCalArr = $this->WorkoutCategory->find('all',array('conditions'=>array('WorkoutCategory.trainerId'=>$id),'fields'=>array('WorkoutCategory.id','WorkoutCategory.name')));

		 

		$optn='';
        if(!empty($checkCalArr))
        {
        	foreach ($checkCalArr as $key=>$val)
        	{
        		
        		$optn .='<option value="'.$val['WorkoutCategory']['id'].'">'.$val['WorkoutCategory']['name'].'</option>';
        	}
        } else {
        	$optn='<option value="">-- Select Category --</option>';
        }
		
       $response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have added Workout Category successfully.","responseval"=>"$optn");  
		echo json_encode($response);

		exit;
	}
	

	public function add_workout_cate()

	{

		$this->layout = '';

		$this->autoRender = false;

		$id = $this->Session->read('USER_ID');

		$na = trim($_POST['catname']);

			

		

		$response=array();

		

		$checkCalArr=$this->WorkoutCategory->find("all",array("conditions"=>array('WorkoutCategory.trainerId'=>$id,'WorkoutCategory.name'=>$na)));

		

		

		if(count($checkCalArr)==0)

		{

			$catArr=array();

			$catArr['WorkoutCategory']['name']=trim($_POST['catname']);

			$catArr['WorkoutCategory']['trainerId']=$id;

					

			$this->WorkoutCategory->save($catArr);

			

			$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have added Workout Category successfully.");  

		}

		else {

			$response = array("responseclassName"=>"nError","errorMsg"=>"Sorry, This Workout Category Name Already Exits."); 

		}

			

		echo json_encode($response);

		exit;		

	}

	

	public function edit_workout_cate()

	{

		$this->layout = '';

		$this->autoRender = false;

		$id = $this->Session->read('USER_ID');

		$na = trim($_POST['catnameed']);

		$cId = base64_decode($_POST['workCat']);

			

		

		$response=array();

		

		$checkCalArr=$this->WorkoutCategory->find("all",array("conditions"=>array('WorkoutCategory.trainerId'=>$id,'WorkoutCategory.name'=>$na,'WorkoutCategory.id <>'=>$cId)));

		

		

		if(count($checkCalArr)==0)

		{

			$catArr=array();

			$catArr['WorkoutCategory']['name']=trim($_POST['catnameed']);

			$catArr['WorkoutCategory']['trainerId']=$id;

			$catArr['WorkoutCategory']['id']=$cId;

					

			$this->WorkoutCategory->save($catArr);

			

			$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have edited Workout Category successfully.");  

		}

		else {

			$response = array("responseclassName"=>"nError","errorMsg"=>"Sorry, This Workout Category Name Already Exits."); 

		}

			

		echo json_encode($response);

		exit;		

	}

	

	public function getEditWorkoutList()

	{

		$this->layout = '';

		$this->autoRender = false;

		$id = $_POST['id'];

		$traineeId = $_POST['traineeId'];

		

		

		$uid = $this->Session->read('USER_ID');

		

		$getClientGoalDetails=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$id)));

		

		/*echo"<pre>";

		$getClientGoalDetails;

		echo"</pre>";*/

		

		$startvaldt = $getClientGoalDetails['Goal']['start'];

		$endvaldt   = $getClientGoalDetails['Goal']['end'];

		

		$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$traineeId)));

		

		$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$traineeId,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));

		

		$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$traineeId,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));



		$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$traineeId,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));



		$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$traineeId,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));



		$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$traineeId,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

		

		

		$edtd = '

		

		<table border="1" width="100%" id="b">

		<input type="hidden" name="GoalId" value="'.$id.'">

			<tr class="slectedmn">

				<td colspan="3" class="th2"><span style="float: left; line-height: 36px;">Goal:</span> <input name="goal" id="goal" value="'.$getClientGoalDetails['Goal']['goal'].'" type="text"   style="width:220px;"/></td><td > <span style="float: left; line-height: 36px;">Phase:</span> <input name="phase" id="phase" value="'.$getClientGoalDetails['Goal']['phase'].'" type="text"   style="width:100px;"/></td>

				

				

				</tr>

			</table>

			

			<table border="1" width="100%" id="c">

			<tr class="slectedmn">

				<td  class="th2"><span style="float: left; line-height: 36px;">Note:</span><textarea id="note" name="note" style="width: 94%;">'.$getClientGoalDetails['Goal']['note'].'</textarea></td>

				

				

				</tr>

			</table>

			

			<table border="1" width="100%" id="d">

			<tr class="slectedmn">

				<td  class="th2"><span style="float: left; line-height: 36px;">Alert:</span><textarea id="alert" name="alert" style="width: 94%;" readonly>'.$setClientArr['Trainee']['alerts'].'</textarea></td>

				

				

				</tr>

			</table>

		

		';

		

		

			

			$edtd .='

			

			<table border="1" width="100%" id="wa">

				<tr class="slectedmn">

				<td colspan="5" class="th2"><h3 style="text-align:left;">Warm-Up </h3>

				

				</td>

				</tr>

				

				<th  class="throw">Exercise</th>

				<th  class="throw">Sets</th>

				<th  class="throw">Duration</th>

				<th  class="throw">Coaching Tip</th>

				<th  class="throw"></th>

				

				</tr>';

				

		if(!empty($setWarmupArr))

		{	
			$i = 1;
			foreach($setWarmupArr as $key=>$val){

				$edtd .='<tr id="mn-play1_'.$i.'">

	    

		     <td><input type="text" id="exercise" name="nplayexercise[]" value="'.$val['WarmUps']['exercise'].'" placeholder="Exercise" /></td>

		     <td><input type="text" name="nplayset[]" id="set" value="'.$val['WarmUps']['set'].'" placeholder="Sets" /></td>

		     <td><input type="text" name="nplayduration[]" id="duration" value="'.$val['WarmUps']['duration'].'" placeholder="Duration" /></td>

		     <td><input type="text" name="nplaycoaching_tip[]" id="coaching_tip" value="'.$val['WarmUps']['coaching_tip'].'" placeholder="Coaching Tip" /></td>

		     <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'mn-play1_'.$i.'\')" href="javascript:void(0);">Remove</a></td>

		     

		     

		     <!--<td id="responce"></td>-->

		     </tr>';
			 $i++;

			}

			

		}

		     



    

	     

	    

	     

     

     $edtd .='</table>   

     <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id="addButtona" onclick="addNPlaya(\'wa\');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 

	      </div>';

			

	$edtd .='

	

			<table border="1" width="100%" id="cbpa">

     		<tr class="slectedmn">

				<td colspan="7" class="th2"><h3 style="text-align:left;">CORE/BALANCE/PLYOMETRIC </h3>

				

				</td>

				</tr>

				

				<th  class="throw">Exercise</th>

				<th  class="throw">Sets</th>

				<th  class="throw">Reps</th>

				<th  class="throw">Weight</th>

				<th  class="throw">Rest</th>

				<th  class="throw">Coaching Tip</th>

				<th><th>

				</tr>';

				

	if(!empty($setCoreBalancePlyometricArr))

		{

			$i = 1;

			foreach($setCoreBalancePlyometricArr as $key=>$val){

			

			
			$edtd .='<tr id="mn-play2_'.$i.'">

	    

		     <td><input type="text" id="exercise" name="nplay1exercise[]" value="'.$val['CoreBalancePlyometric']['exercise'].'" placeholder="Exercise" /></td>

		     <td><input type="text" name="nplay1set[]" id="set" value="'.$val['CoreBalancePlyometric']['set'].'" placeholder="Sets" /></td>

		     <td><input type="text" name="nplay1rep[]" id="rep" value="'.$val['CoreBalancePlyometric']['rep'].'" placeholder="Reps" /></td>

		     <td><input type="text" name="nplay1temp[]" id="temp" value="'.$val['CoreBalancePlyometric']['temp'].'" placeholder="Weight" /></td>

		     <td><input type="text" name="nplay1rest[]" id="rest" value="'.$val['CoreBalancePlyometric']['rest'].'" placeholder="Rest" /></td>

		     <td><input type="text" name="nplay1coaching_tip[]" id="coaching_tip" value="'.$val['CoreBalancePlyometric']['coaching_tip'].'" placeholder="Coaching Tip" /></td>

             <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'mn-play2_'.$i.'\')" href="javascript:void(0);">Remove</a></td>	    

		          

	     

	    	 </tr>';
			 $i++;

			}

		}

      $edtd .='</table> 

      <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id="addButton1a" onclick="addNPlay1a(\'cbpa\');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 

	      </div>

	

	';		

		

      

      $edtd .='

      

      <table border="1" width="100%" id="saqa">

     <tr class="slectedmn">

				<td colspan="7" class="th2"><h3 style="text-align:left;">SPEED/AGILITY/QUICKNESS </h3>

				

				</td>

				</tr>

				

				<th  class="throw">Exercise</th>

				<th  class="throw">Sets</th>

				<th class="throw">Reps</th>

				<th class="throw">Weight</th>

				<th class="throw">Rest</th>

				<th class="throw">Coaching Tip</th>

				<th><th>

				</tr>';

      

      if(!empty($setSpeedAgilityQuicknessArr))

		{


			$i = 1;
			foreach($setSpeedAgilityQuicknessArr as $key=>$val){

				

				$edtd .='<tr id="mn-play3_'.$i.'">

	    

		     <td><input type="text" id="exercise" name="nplay2exercise[]" value="'.$val['SpeedAgilityQuickness']['exercise'].'" placeholder="Exercise" /></td>

		     <td><input type="text" name="nplay2set[]" id="set" value="'.$val['SpeedAgilityQuickness']['set'].'" placeholder="Sets" /></td>

		     <td><input type="text" name="nplay2rep[]" id="rep" value="'.$val['SpeedAgilityQuickness']['rep'].'" placeholder="Reps" /></td>

		     <td><input type="text" name="nplay2temp[]" id="temp" value="'.$val['SpeedAgilityQuickness']['temp'].'" placeholder="Weight" /></td>

		     <td><input type="text" name="nplay2rest[]" id="rest" value="'.$val['SpeedAgilityQuickness']['rest'].'" placeholder="Rest" /></td>

		     <td><input type="text" name="nplay2coaching_tip[]" id="coaching_tip" value="'.$val['SpeedAgilityQuickness']['coaching_tip'].'" placeholder="Coaching Tip" /></td>

		      <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'mn-play3_'.$i.'\')" href="javascript:void(0);">Remove</a></td>	   

	     

	     </tr>';
			$i++;

			}

			

		}

	    

      $edtd .='</table> 

      <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id="addButton2a" onclick="addNPlay2a(\'saqa\');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 

	      </div> 

      

      ';	

			

	$edtd .='

			<table border=\'1\' width=\'100%\' id="resa">

     <tr class=\'slectedmn\'>

				<td colspan=\'7\' class="th2"><h3 style=\'text-align:left;\'>RESISTANCE </h3>

				

				</td>

				</tr>

				

				<th  class="throw">Exercise</th>

				<th  class="throw">Sets</th>

				<th class="throw">Reps</th>

				<th class="throw">Weight</th>

				<th class="throw">Rest</th>

				<th class="throw">Coaching Tip</th>

				<th></th>

				</tr>';

				

	

	if(!empty($setResistenceArr))

		{
			$i = 1;
		foreach($setResistenceArr as $key=>$val){

	

			$edtd .='<tr id="mn-play4_'.$i.'">

	    

		     <td><input type="text" id="exercise" name="nplay3exercise[]" value="'.$val['Resistence']['exercise'].'" placeholder="Exercise" /></td>

		     <td><input type="text" name="nplay3set[]" id="set" value="'.$val['Resistence']['set'].'" placeholder="Sets" /></td>

		     <td><input type="text" name="nplay3rep[]" id="rep" value="'.$val['Resistence']['rep'].'" placeholder="Reps" /></td>

		     <td><input type="text" name="nplay3temp[]" id="temp" value="'.$val['Resistence']['temp'].'" placeholder="Weight" /></td>

		     <td><input type="text" name="nplay3rest[]" id="rest" value="'.$val['Resistence']['rest'].'" placeholder="Rest" /></td>

		     <td><input type="text" name="nplay3coaching_tip[]" id="coaching_tip" value="'.$val['Resistence']['coaching_tip'].'" placeholder="Coaching Tip" /></td>

		      <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'mn-play4_'.$i.'\')" href="javascript:void(0);">Remove</a></td>	 

		          

	     

	    	 </tr>';
			 $i++;

			}

		}

	     

      $edtd .='</table> 

       <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id=\'addButton3a\' onclick="addNPlay3a(\'resa\');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 

	      </div>

	

	';

			

	  

      $edtd .='

      

      <table border=\'1\' width=\'100%\' id="cda">

				<tr class=\'slectedmn\'>

				<td colspan=\'5\' class="th2"><h3 style=\'text-align:left;\'>COOL-DOWN </h3>

				

				</td>

				</tr>

				

				<th  class="throw">Exercise</th>

				<th  class="throw">Sets</th>

				<th  class="throw">Duration</th>

				<th  class="throw">Coaching Tip</th>

				<th></th>

				</tr>';

      

       if(!empty($setCoolDownArr))

		{
			$i = 1;
			foreach($setCoolDownArr as $key=>$val){

				

					$edtd .='<tr id="mn-play5_'.$i.'">

	    

		     <td><input type="text" id="exercise" name="nplay4exercise[]" value="'.$val['CoolDown']['exercise'].'" placeholder="Exercise" /></td>

		     <td><input type="text" name="nplay4set[]" id="set" value="'.$val['CoolDown']['set'].'" placeholder="Sets" /></td>

		     <td><input type="text" name="nplay4duration[]" id="duration" value="'.$val['CoolDown']['duration'].'" placeholder="Duration" /></td>

		     <td><input type="text" name="nplay4coaching_tip[]" id="coaching_tip" value="'.$val['CoolDown']['coaching_tip'].'" placeholder="Coaching Tip" /></td>

		     <td style="padding: 9px 10px;"> <a onclick="removeFilea(\'mn-play5_'.$i.'\')" href="javascript:void(0);">Remove</a></td>	 

		          

	     

	     </tr>';
		 $i++;

			}

			

		}

	   

     

      $edtd .='</table>  

     <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id=\'addButton4a\' onclick="addNPlay4a(\'cda\');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 

	      </div>

      

      ';		

			

			

			

			

		

		

		echo $edtd;

		exit;

	}

	

	public function editWorkoutData()

	{  

	  

	   		$this->layout = '';

			$this->autoRender = false;

			$TrainerId = $this->Session->read('USER_ID');

			$trainee_id = $_POST['trainee_idEW'];

			

				//$exercisedata=array();

				$response=array();

				

				$exe1Count = count($_POST['nplayexercise']); 

				 $exerciseCount1 = count($_POST['nplay1exercise']);

				 $exerciseCount2 = count($_POST['nplay2exercise']);

				 $exerciseCount3 = count($_POST['nplay3exercise']);

				 $exerciseCount4 = count($_POST['nplay4exercise']);

				 

				 

				 

				 $GoalId=trim($_POST['GoalId']);

				 $getClientGoalDetails=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$GoalId)));

				 

				      $startDate2		=	$getClientGoalDetails['Goal']['start'];

					    $endDate2		=	$getClientGoalDetails['Goal']['end'];

				 

				 if(isset($_POST['changeTime']) && trim($_POST['changeTime'])=='yes')

				 {

					 if(trim($_POST['oldTime'])!=trim($_POST['sessType']))

					 {

					 	$stD=trim($_POST['sessType']);

					 		$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));

				

		                   $startDate = $schcaldt['ScheduleCalendar']['start'];

		                $endDate  = $schcaldt['ScheduleCalendar']['end'];

		                

		                $this->ScheduleCalendar->query("update schedule_calendar set mapwrkt=0 where id='".$_POST['oldTime']."'");

		                $this->ScheduleCalendar->query("update schedule_calendar set mapwrkt=1 where id='".$_POST['sessType']."'");

					 	

					 }

					 else 

					 {

					 	$startDate		=	$getClientGoalDetails['Goal']['start'];

					    $endDate		=	$getClientGoalDetails['Goal']['end'];

					 }

				 } else 

				 {

				 	   $startDate		=	$getClientGoalDetails['Goal']['start'];

					    $endDate		=	$getClientGoalDetails['Goal']['end'];

				 }

				

				 

				 

				

				 

				 

				 

				 $WarmUpsdataD['start']			=	$startDate;

				 $WarmUpsdataD['end']			=	$endDate;

				 $WarmUpsdataD['trainee_id']	=	$trainee_id;

				 $WarmUpsdataD['trainer_id']	=	$TrainerId;

				 

			

				$this->WarmUps->query("delete from warm_ups where trainer_id='".$TrainerId."' and trainee_id='".$trainee_id."' and start='".$startDate2."' and end='".$endDate2."'");

				$this->CoreBalancePlyometric->query("delete from corebalance_plyometric where trainer_id='".$TrainerId."' and trainee_id='".$trainee_id."' and start='".$startDate2."' and end='".$endDate2."'");

				$this->SpeedAgilityQuickness->query("delete from speedagility_quickness where trainer_id='".$TrainerId."' and trainee_id='".$trainee_id."' and start='".$startDate2."' and end='".$endDate2."'");

				$this->Resistence->query("delete from resistences where trainer_id='".$TrainerId."' and trainee_id='".$trainee_id."' and start='".$startDate2."' and end='".$endDate2."'");

				$this->CoolDown->query("delete from cool_down where trainer_id='".$TrainerId."' and trainee_id='".$trainee_id."' and start='".$startDate2."' and end='".$endDate2."'");

				

				 

			

			        $goalArr=array();

					$goalArr['Goal']['goal']=trim($_POST['goal']);

					$goalArr['Goal']['phase']=trim($_POST['phase']);

					$goalArr['Goal']['note']=trim($_POST['note']);

					$goalArr['Goal']['alert']=trim($_POST['alert']);

					$goalArr['Goal']['start']=trim($startDate);

					$goalArr['Goal']['end']=trim($endDate);

					$goalArr['Goal']['id']=$GoalId;						

					

									

					

					$this->Goal->save($goalArr);

					

				for($i=0;$i<$exe1Count;$i++)

				{

					

					$exercisedata['WarmUps']['trainer_id']=$TrainerId;

				    $exercisedata['WarmUps']['trainee_id']=$trainee_id;

					$exercisedata['WarmUps']['exercise']=trim($_POST['nplayexercise'][$i]);

					$exercisedata['WarmUps']['set']=trim($_POST['nplayset'][$i]);

					$exercisedata['WarmUps']['duration']=trim($_POST['nplayduration'][$i]);

					$exercisedata['WarmUps']['coaching_tip']=trim($_POST['nplaycoaching_tip'][$i]);

					$exercisedata['WarmUps']['added_date']=date('Y-m-d H:i:s');

					$exercisedata['WarmUps']['start']=$startDate;

					$exercisedata['WarmUps']['end']=$endDate;

					

					

					if($exercisedata['WarmUps']['exercise']!='') {

						

						$this->WarmUps->saveAll($exercisedata);

						

					}

					

				}



				

				//print_r($exerciseCount1);
				//die();

				for($i=0;$i<$exerciseCount1;$i++)

				{

					

					$exercisedata1['CoreBalancePlyometric']['trainer_id']=$TrainerId;

				    $exercisedata1['CoreBalancePlyometric']['trainee_id']=$trainee_id;

					$exercisedata1['CoreBalancePlyometric']['exercise']=trim($_POST['nplay1exercise'][$i]);
					$exercisedata1['CoreBalancePlyometric']['set']=trim($_POST['nplay1set'][$i]);

					/*$exercisedata1['CoreBalancePlyometric']['set']=trim($_POST['nplay1set'][$i]);*/

					$exercisedata1['CoreBalancePlyometric']['rep']=trim($_POST['nplay1rep'][$i]);

					$exercisedata1['CoreBalancePlyometric']['rest']=trim($_POST['nplay1rest'][$i]);

					$exercisedata1['CoreBalancePlyometric']['temp']=trim($_POST['nplay1temp'][$i]);

					$exercisedata1['CoreBalancePlyometric']['coaching_tip']=trim($_POST['nplay1coaching_tip'][$i]);

					$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d H:i:s');

					$exercisedata1['CoreBalancePlyometric']['start']=$startDate;

					$exercisedata1['CoreBalancePlyometric']['end']=$endDate;

					

					

					if($exercisedata1['CoreBalancePlyometric']['exercise']!='') {

						

						$this->CoreBalancePlyometric->saveAll($exercisedata1);

						

					}

					



				}

				

			

				for($i=0;$i<$exerciseCount2;$i++)

				{

					

					$exercisedata2['SpeedAgilityQuickness']['trainer_id']=$TrainerId;

				    $exercisedata2['SpeedAgilityQuickness']['trainee_id']=$trainee_id;

					$exercisedata2['SpeedAgilityQuickness']['exercise']=trim($_POST['nplay2exercise'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['set']=trim($_POST['nplay2set'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['rep']=trim($_POST['nplay2rep'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['rest']=trim($_POST['nplay2rest'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['temp']=trim($_POST['nplay2temp'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['coaching_tip']=trim($_POST['nplay2coaching_tip'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d H:i:s');

					$exercisedata2['SpeedAgilityQuickness']['start']=$startDate;

					$exercisedata2['SpeedAgilityQuickness']['end']=$endDate;

					

					

					if($exercisedata2['SpeedAgilityQuickness']['exercise']!='') {

						

						$this->SpeedAgilityQuickness->saveAll($exercisedata2);

						

					}

					



				}

				

				for($i=0;$i<$exerciseCount3;$i++)

				{

					

					$exercisedata3['Resistence']['trainer_id']=$TrainerId;

				    $exercisedata3['Resistence']['trainee_id']=$trainee_id;

					$exercisedata3['Resistence']['exercise']=trim($_POST['nplay3exercise'][$i]);

					$exercisedata3['Resistence']['set']=trim($_POST['nplay3set'][$i]);

					$exercisedata3['Resistence']['rep']=trim($_POST['nplay3rep'][$i]);

					$exercisedata3['Resistence']['rest']=trim($_POST['nplay3rest'][$i]);

					$exercisedata3['Resistence']['temp']=trim($_POST['nplay3temp'][$i]);

					$exercisedata3['Resistence']['coaching_tip']=trim($_POST['nplay3coaching_tip'][$i]);

					$exercisedata3['Resistence']['added_date']=date('Y-m-d H:i:s');

					$exercisedata3['Resistence']['start']=$startDate;

					$exercisedata3['Resistence']['end']=$endDate;

					

					

					if($exercisedata3['Resistence']['exercise']!='') {

						

						$this->Resistence->saveAll($exercisedata3);

						

					}

					



				}

				

				for($i=0;$i<$exerciseCount4;$i++)

				{

					

					$exercisedata4['CoolDown']['trainer_id']=$TrainerId;

				    $exercisedata4['CoolDown']['trainee_id']=$trainee_id;

					$exercisedata4['CoolDown']['exercise']=trim($_POST['nplay4exercise'][$i]);

					$exercisedata4['CoolDown']['set']=trim($_POST['nplay4set'][$i]);

					$exercisedata4['CoolDown']['duration']=trim($_POST['nplay4duration'][$i]);

					$exercisedata4['CoolDown']['coaching_tip']=trim($_POST['nplay4coaching_tip'][$i]);

					$exercisedata4['CoolDown']['added_date']=date('Y-m-d H:i:s');

					$exercisedata4['CoolDown']['start']=$startDate;

					$exercisedata4['CoolDown']['end']=$endDate;

					

					

					if($exercisedata4['CoolDown']['exercise']!='') {

						

						$this->CoolDown->saveAll($exercisedata4);

						

					}

					



				}

				



							

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have edited Workout Data successfully.");

						

			

		  

			

		echo json_encode($response);

				exit;

	  

	  

	  

	  

	}

	

	

	

	public function addsession()

		{
			
			//$this->send_welcome_email($this->request->data["Corporation"]["email"],$this->request->data["Corporation"]["company_name"],$this->request->data["Corporation"]["password"],'',$this->request->data["Corporation"]["username"],$mailcontentfetch['Managemail']['content'],$mailcontentfetch['Managemail']['subject']);
			
			$this->layout = "homelayout";	

		    $this->set("leftcheck",'homemy_clients');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);

			//echo "<pre>";print_r($setSpecalistArr);echo "</pre>";die();

			

			$this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$id,'Trainee.status'=>1),'order'=>array('Trainee.last_name ASC'),'fields'=>array('Trainee.id','Trainee.full_name'))));
			
			

			

			$workoutdata=$this->WorkOuts->find('list',array('conditions'=>array('WorkOuts.trainer_id'=>$id),'fields'=>array('WorkOuts.id','WorkOuts.workout_name')));

			$this->set("workoutdata",$workoutdata);
			
			
			

			if($setSpecalistArr[$dbusertype]['trainer_type']=='C')

			{

				

				$clubid=$setSpecalistArr[$dbusertype]['club_id'];

			$this->set("cbranchs",$this->ClubBranch->find('list',array("conditions"=>array("ClubBranch.club_id"=>$clubid),'fields'=>array('ClubBranch.id','ClubBranch.full_name'))));

			}

			

			if(!empty($this->data)) {
				
				
				/******SessionPurchase******/
				
				$sessionPurchase=$this->SessionPurchase->find('first',array("conditions"=>array('SessionPurchase.client_id'=>$this->data['Trainee']['id'],'SessionPurchase.trainer_id'=>$this->Session->read('USER_ID'),'SessionPurchase.session_id'=>$this->data['SessType']['id'])));
			     	if(!empty($sessionPurchase)){
					
						
			 //  $totalSessPurchaseData=$traneeDT['Trainee']['no_ses_purchased']+$this->data['Trainee']['purchasesession'];
				
				$session_purchase_data['SessionPurchase']['client_id']=$this->data['Trainee']['id'];
				$session_purchase_data['SessionPurchase']['trainer_id']=$this->Session->read('USER_ID');
				$session_purchase_data['SessionPurchase']['session_id']=$this->data['SessType']['id'];
				
		$totalSessPurchaseData=$sessionPurchase['SessionPurchase']['no_of_purchase']+$this->data['Trainee']['purchasesession'];
				
				$session_purchase_data['SessionPurchase']['no_of_purchase']=$totalSessPurchaseData;
				$session_purchase_data['SessionPurchase']['added_date']=time();
				$session_purchase_data['SessionPurchase']['id']=$sessionPurchase['SessionPurchase']['id'];
				$this->SessionPurchase->id=$sessionPurchase['SessionPurchase']['id'];
				
				$this->SessionPurchase->save($session_purchase_data);	
			     	}else{
			     		
			    $session_purchase_data['SessionPurchase']['client_id']=$this->data['Trainee']['id'];
				$session_purchase_data['SessionPurchase']['trainer_id']=$this->Session->read('USER_ID');
				$session_purchase_data['SessionPurchase']['session_id']=$this->data['SessType']['id'];
				$session_purchase_data['SessionPurchase']['no_of_purchase']=$this->data['Trainee']['purchasesession'];
			     $this->SessionPurchase->saveAll($session_purchase_data);	
				 
				 
			     	}
				/******SessionPurchase******/

					

						$stringDt = $this->data['Trainee']['purchaseddate'];

						if(stristr($string, '/') === FALSE) {

						$stringDt=str_replace("-","/",$stringDt);

						}

					$exercisedata['TraineesessionPurchase']['trainee_id']=$this->data['Trainee']['id'];

					$exercisedata['TraineesessionPurchase']['SessTypeId']=$this->data['SessType']['id'];

				    $exercisedata['TraineesessionPurchase']['trainer_id']=$this->Session->read('USER_ID');

					$exercisedata['TraineesessionPurchase']['purchase_session']=$this->data['Trainee']['purchasesession'];

					$exercisedata['TraineesessionPurchase']['cost']=$this->data['Trainee']['cost'];

					$exercisedata['TraineesessionPurchase']['purchased_date']=date('Y-m-d',strtotime(trim($stringDt)));

					

				

				//$TraineesessionPurchase;

					$this->TraineesessionPurchase->saveAll($exercisedata);

					$workoutdata15=$this->WorkOuts->find('first',array('conditions'=>array('WorkOuts.id'=>$exercisedata['TraineesessionPurchase']['SessTypeId']),'fields'=>array('WorkOuts.id','WorkOuts.workout_name')));
					
					
					

					$traneeDT=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>$this->data['Trainee']['id']),'fields'=>array('Trainee.id','Trainee.no_ses_purchased','Trainee.email','Trainee.first_name','Trainee.last_name')));



                   $totalSessTr=$traneeDT['Trainee']['no_ses_purchased']+$this->data['Trainee']['purchasesession'];



				   $this->Trainee->id=$this->data['Trainee']['id'];

				   $this->request->data["Trainee"]["no_ses_purchased"]=$totalSessTr;

					$originalDate = $exercisedata['TraineesessionPurchase']['purchased_date'];
					
					$newDate = date("m/d/Y", strtotime($originalDate));

                   $this->send_session_purchase_mail($setSpecalistArr['Trainer']['email'],$traneeDT['Trainee']['email'],$exercisedata['TraineesessionPurchase']['cost'],$exercisedata['TraineesessionPurchase']['purchase_session'],$newDate,$traneeDT['Trainee']['first_name'],$traneeDT['Trainee']['last_name'],$setSpecalistArr['Trainer']['first_name'],$setSpecalistArr['Trainer']['last_name'],$setSpecalistArr['Trainer']['website_logo'],$setSpecalistArr['Trainer']['phone'],$setSpecalistArr['Trainer']['email'],$workoutdata15['WorkOuts']['workout_name']);
				   
				   
				   // $this->send_session_purchase_mail_trainer($setSpecalistArr['Trainer']['email'],$traneeDT['Trainee']['email'],$exercisedata['TraineesessionPurchase']['cost'],$exercisedata['TraineesessionPurchase']['purchase_session'],$exercisedata['TraineesessionPurchase']['purchased_date'],$traneeDT['Trainee']['first_name'],$traneeDT['Trainee']['last_name'],$setSpecalistArr['Trainer']['first_name'],$setSpecalistArr['Trainer']['last_name']);
				   

				   $this->Trainee->save($this->request->data['Trainee']);

					/*echo $exercisedata['TraineesessionPurchase']['cost'];
					echo $exercisedata['TraineesessionPurchase']['purchase_session'];
					echo $exercisedata['TraineesessionPurchase']['purchased_date'];
					echo $setSpecalistArr['Trainer']['email'];
					echo $traneeDT['Trainee']['first_name'];
					echo $traneeDT['Trainee']['last_name'];
					echo 1;
					echo "<pre>";
					print_r($traneeDT);
					echo "<pre>";
					die();*/

					$this->Session->setFlash('Thanks, you have add the session data successfully and mail has been sent to client.');

					$this->redirect('/home/viewclientsessions/');

			} 

			

		}
		
		
		function send_session_purchase_mail($from,$to,$session_cost,$purchased_session,$datepurchased,$cfname,$clname,$tfname,$tlname,$tlogo,$tphone,$temail,$sesstypeemail) {		
		App::uses('CakeEmail', 'Network/Email');		
		$email = new CakeEmail();		
		$email->emailFormat('html');
	
				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'uploads/'.$tlogo.'"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello  '.$cfname.' '.$clname.'!</p>
				<p>Thanks for purchasing sessions with me.</p>				
				<p>Please find your purchase details below</p>
				
				<p>Purchase Cost: $'.$session_cost.'</p>
				<p>No of Session Purchased: '.$purchased_session.'</p>
				<p>Date Purchased: '.$datepurchased.'</p>
				<p>Session Type: '.$sesstypeemail.'</p>
							
				<p>I am looking forward to helping you reach your fitness goals so please feel free to contact me with any questions or concerns regarding your training.</p>
				
				</td></tr><tr><td><br/>Thanks again,<br/>'.$tfname.' '.$tlname.'<br/>'.$tphone.'<br />'.$temail.'</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(FROM_EMAIL => EMAILNAME));
		$email->to($to);		
		$subtxt = __('Thank you for Purchasing Training Sessions');
		$email->subject($subtxt);
		$email->send($content);
	}
	
	/*function send_session_purchase_mail_trainer($from,$to,$session_cost,$purchased_session,$datepurchased,$cfname,$clname,$tfname,$tlname) {
		App::uses('CakeEmail', 'Network/Email');		
		$email = new CakeEmail();		
		$email->emailFormat('html');
	
				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hi Admin!</p>
				<p>A Session has been purchased from '.$this->config["base_title"].' site. </p>				
				<p>Please find below Session details</p>
				<p>Client Name'.' '.$cfname.' '.$clname.'</p>
				<p>Purchase Cost'.' '.$session_cost.'</p>
				<p>No of Session Purchased'.' '.$purchased_session.'</p>
				<p>Session Date'.' '.$datepurchased.'</p>
				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team<br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(WEBSITE_FROM_EMAIL => WEBSITENAME));
		$email->to($from);		
		$subtxt = __('Session Purchased Email reciept');
		$email->subject($subtxt);
		$email->send($content);
	}*/
		
		
		
		

		

		

	function edit_exercise_history($clientid=null,$stD=null,$msdate=null)

	{		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'exercise_history');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');

		

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));

		

		

		$this->set("setSpecalistArr",$setSpecalistArr);

		$showoff=1;

		

		$this->set("clientid",$clientid);

			

		$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));

				

		$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));

				

		$strtDt = $schcaldt['ScheduleCalendar']['start'];

		$endDt  = $schcaldt['ScheduleCalendar']['end'];

		

		$startvaldt = $strtDt;

		$endvaldt = $endDt;

				

		$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid, "Goal.start"=>$strtDt,"Goal.end"=>$endDt),"Order"=>array("Goal.id"=>"DESC")));

				

				

		$this->set('clientGoal',$setClientGoalArr);

		$this->set('schcaldt',$schcaldt);
		$this->set('msdate',$msdate);

		

		//$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0','ScheduleCalendar.start >'=>date('Y-m-d H:i:s')),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));
	
		
		$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0',"ScheduleCalendar.status <>"=> 0),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));

		

		$this->set('scheduleCalendars',$scheduleCalendars);

			

			

		$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));

		

		$this->set('setWarmupArr',$setWarmupArr);

		

		$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));

		

		$this->set('setCoreBalancePlyometricArr',$setCoreBalancePlyometricArr);



		$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));

		

		$this->set('setSpeedAgilityQuicknessArr',$setSpeedAgilityQuicknessArr);



		$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

		

		$this->set('setResistenceArr',$setResistenceArr);



		$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

		

		$this->set('setCoolDownArr',$setCoolDownArr);	

			

			

		

		



	}	

	

	function deletewrktview()

	{

		

		$groupid = $_POST['groupid'];

		$this->TempWorkout->deleteAll(array('TempWorkout.group_id' => $groupid), false);	

		

		$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have successfully deleted the saved Workout Data.");

						

			

		  

			

		echo json_encode($response);

				exit;

	}

	

	public function printscheduled($dt=null)
	{
		$this->checkUserLogin();

	    $this->layout = "printlayout";		

		$dbusertype = $this->Session->read('UTYPE');
			
		$uid = $this->Session->read('USER_ID');

		$this->set("dbusertype",$dbusertype);
			
		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
		
		$this->set("setSpecalistArr",$setSpecalistArr);

		if($dt!='')
		{
			$startdt=$dt.' 00:00:00';    	

			$enddt=$dt.' 23:59:00';   

			if($dbusertype=='Trainer')
			{
				$sccondition=array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.start >='=>$startdt,'ScheduleCalendar.start <='=>$enddt,'ScheduleCalendar.status'=>1);
				
				$this->ScheduleCalendar->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id"))));

				$this->ScheduleCalendar->bindModel(array("belongsTo"=>array("Trainee"=>array("foreignKey"=>"trainee_id"))));

				$this->ScheduleCalendar->recursive = 2;
				
				$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>$sccondition,'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.appointment_type','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.posted_by'),"order"=>array("ScheduleCalendar.start"=>"ASC")));	
				
				$this->set("calendarData",$scheduleCalendars);
			}
		}
	}

	

	public function edit_print_exercise_history($clientid=null,$stD=null)
	{
		$this->checkUserLogin();
		
	    $this->layout = "printlayout";		

		$dbusertype = $this->Session->read('UTYPE');

		$this->set("dbusertype",$dbusertype);

		$this->set("clid",$clientid);

		$this->set("schid",$stD);
		
		$uid = $this->Session->read('USER_ID');

	    $setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));

		$this->set("setSpecalistArr",$setSpecalistArr);

		$showoff=1;

		$this->set("clientid",$clientid);
		
		$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));

		$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));

		$strtDt = $schcaldt['ScheduleCalendar']['start'];

		$endDt  = $schcaldt['ScheduleCalendar']['end'];

		$startvaldt = $strtDt;

		$endvaldt = $endDt;

		$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid, "Goal.start"=>$strtDt,"Goal.end"=>$endDt),"Order"=>array("Goal.id"=>"DESC")));

		$this->set('clientGoal',$setClientGoalArr);

		$this->set('schcaldt',$schcaldt);
		
		$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0','ScheduleCalendar.start >'=>date('Y-m-d H:i:s')),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status'),'limit'=>5));	

		$this->set('scheduleCalendars',$scheduleCalendars);			

		$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));	

		$this->set('setWarmupArr',$setWarmupArr);		

		$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));		

		$this->set('setCoreBalancePlyometricArr',$setCoreBalancePlyometricArr);

		$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));		

		$this->set('setSpeedAgilityQuicknessArr',$setSpeedAgilityQuicknessArr);

		$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));		

		$this->set('setResistenceArr',$setResistenceArr);

		$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

		$this->set('setCoolDownArr',$setCoolDownArr);
		
	}

	

	public function print_exercise_history($clientid=null,$stD=null)

	{

		$this->checkUserLogin();

	    $this->layout = "printlayout";		

		

		$dbusertype = $this->Session->read('UTYPE');

		$this->set("dbusertype",$dbusertype);

		$this->set("clid",$clientid);

		$this->set("schid",$stD);

		

	    $uid = $this->Session->read('USER_ID');

	    

	    

	    $setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));

		

		

		$this->set("setSpecalistArr",$setSpecalistArr);

		$showoff=1;

		

		$this->set("clientid",$clientid);

			

		$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));

		

		$this->set('clientDatas',$setClientArr);

				

		$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));

				

		$strtDt = $schcaldt['ScheduleCalendar']['start'];

		$endDt  = $schcaldt['ScheduleCalendar']['end'];

		

		$startvaldt = $strtDt;

		$endvaldt = $endDt;

				

		$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid, "Goal.start"=>$strtDt,"Goal.end"=>$endDt),"Order"=>array("Goal.id"=>"DESC")));

				

				

		$this->set('clientGoal',$setClientGoalArr);

		$this->set('schcaldt',$schcaldt);

		

		$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0','ScheduleCalendar.start >'=>date('Y-m-d H:i:s')),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status'),'limit'=>5));

		

		$this->set('scheduleCalendars',$scheduleCalendars);

			

			

		$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));

		

		$this->set('setWarmupArr',$setWarmupArr);

		

		$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));

		

		$this->set('setCoreBalancePlyometricArr',$setCoreBalancePlyometricArr);



		$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));

		

		$this->set('setSpeedAgilityQuicknessArr',$setSpeedAgilityQuicknessArr);



		$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

		

		$this->set('setResistenceArr',$setResistenceArr);



		$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

		

		$this->set('setCoolDownArr',$setCoolDownArr);

	}

	

	

	public function printAndSave()

	{  

	  

	   		$this->layout = '';

			$this->autoRender = false;

			$TrainerId = $this->Session->read('USER_ID');

			$trainee_id = $_POST['trainee_idEW'];

			

			$stD = $_POST['oldTime'];

			

			/*echo"<pre>";

			print_r($_POST);

			echo"</pre>";

			exit;*/

			

			$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));

			

				//$exercisedata=array();

				$response=array();

				

				$exe1Count = count($_POST['nplayexercise']); 

				 $exerciseCount1 = count($_POST['nplay1exercise']);

				 $exerciseCount2 = count($_POST['nplay2exercise']);

				 $exerciseCount3 = count($_POST['nplay3exercise']);

				 $exerciseCount4 = count($_POST['nplay4exercise']);

				 

				 $GoalId=trim($_POST['GoalId']);

				 $getClientGoalDetails=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$GoalId)));

				 

				 $startDate2		=	$getClientGoalDetails['Goal']['start'];

				 $endDate2			=	$getClientGoalDetails['Goal']['end'];

				 		

				 $startDate		=	$getClientGoalDetails['Goal']['start'];

				 $endDate		=	$getClientGoalDetails['Goal']['end'];				 

				 

				 $WarmUpsdataD['start']			=	$startDate;

				 $WarmUpsdataD['end']			=	$endDate;

				 $WarmUpsdataD['trainee_id']	=	$trainee_id;

				 $WarmUpsdataD['trainer_id']	=	$TrainerId;

				 

			

				$this->WarmUps->query("delete from warm_ups where trainer_id='".$TrainerId."' and trainee_id='".$trainee_id."' and start='".$startDate2."' and end='".$endDate2."'");

				$this->CoreBalancePlyometric->query("delete from corebalance_plyometric where trainer_id='".$TrainerId."' and trainee_id='".$trainee_id."' and start='".$startDate2."' and end='".$endDate2."'");

				$this->SpeedAgilityQuickness->query("delete from speedagility_quickness where trainer_id='".$TrainerId."' and trainee_id='".$trainee_id."' and start='".$startDate2."' and end='".$endDate2."'");

				$this->Resistence->query("delete from resistences where trainer_id='".$TrainerId."' and trainee_id='".$trainee_id."' and start='".$startDate2."' and end='".$endDate2."'");

				$this->CoolDown->query("delete from cool_down where trainer_id='".$TrainerId."' and trainee_id='".$trainee_id."' and start='".$startDate2."' and end='".$endDate2."'");

				

				 

			

			        $goalArr=array();

					$goalArr['Goal']['goal']=trim($_POST['goal']);

					$goalArr['Goal']['phase']=trim($_POST['phase']);

					$goalArr['Goal']['note']=trim($_POST['note']);

					$goalArr['Goal']['alert']=trim($_POST['alert']);

					$goalArr['Goal']['start']=trim($startDate);

					$goalArr['Goal']['end']=trim($endDate);

					$goalArr['Goal']['id']=$GoalId;						

					

									

					

					$this->Goal->save($goalArr);

					

				for($i=0;$i<$exe1Count;$i++)

				{

					

					$exercisedata['WarmUps']['trainer_id']=$TrainerId;

				    $exercisedata['WarmUps']['trainee_id']=$trainee_id;

					$exercisedata['WarmUps']['exercise']=trim($_POST['nplayexercise'][$i]);

					$exercisedata['WarmUps']['set']=trim($_POST['nplayset'][$i]);

					$exercisedata['WarmUps']['duration']=trim($_POST['nplayduration'][$i]);

					$exercisedata['WarmUps']['coaching_tip']=trim($_POST['nplaycoaching_tip'][$i]);

					$exercisedata['WarmUps']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

					$exercisedata['WarmUps']['start']=$startDate;

					$exercisedata['WarmUps']['end']=$endDate;

					

					

					if($exercisedata['WarmUps']['exercise']!='') {

						

						$this->WarmUps->saveAll($exercisedata);

						

					}

					

				}



				

				

				for($i=0;$i<$exerciseCount1;$i++)

				{

					

					$exercisedata1['CoreBalancePlyometric']['trainer_id']=$TrainerId;

				    $exercisedata1['CoreBalancePlyometric']['trainee_id']=$trainee_id;

					$exercisedata1['CoreBalancePlyometric']['exercise']=trim($_POST['nplay1exercise'][$i]);

					$exercisedata1['CoreBalancePlyometric']['set']=trim($_POST['nplay1set'][$i]);

					$exercisedata1['CoreBalancePlyometric']['rep']=trim($_POST['nplay1rep'][$i]);

					$exercisedata1['CoreBalancePlyometric']['rest']=trim($_POST['nplay1rest'][$i]);

					$exercisedata1['CoreBalancePlyometric']['temp']=trim($_POST['nplay1temp'][$i]);

					$exercisedata1['CoreBalancePlyometric']['coaching_tip']=trim($_POST['nplay1coaching_tip'][$i]);

					$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

					$exercisedata1['CoreBalancePlyometric']['start']=$startDate;

					$exercisedata1['CoreBalancePlyometric']['end']=$endDate;

					

					

					if($exercisedata1['CoreBalancePlyometric']['exercise']!='') {

						

						$this->CoreBalancePlyometric->saveAll($exercisedata1);

						

					}

					



				}

				

			

				for($i=0;$i<$exerciseCount2;$i++)

				{

					

					$exercisedata2['SpeedAgilityQuickness']['trainer_id']=$TrainerId;

				    $exercisedata2['SpeedAgilityQuickness']['trainee_id']=$trainee_id;

					$exercisedata2['SpeedAgilityQuickness']['exercise']=trim($_POST['nplay2exercise'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['set']=trim($_POST['nplay2set'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['rep']=trim($_POST['nplay2rep'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['rest']=trim($_POST['nplay2rest'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['temp']=trim($_POST['nplay2temp'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['coaching_tip']=trim($_POST['nplay2coaching_tip'][$i]);

					$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

					$exercisedata2['SpeedAgilityQuickness']['start']=$startDate;

					$exercisedata2['SpeedAgilityQuickness']['end']=$endDate;

					

					

					if($exercisedata2['SpeedAgilityQuickness']['exercise']!='') {

						

						$this->SpeedAgilityQuickness->saveAll($exercisedata2);

						

					}

					



				}

				

				for($i=0;$i<$exerciseCount3;$i++)

				{

					

					$exercisedata3['Resistence']['trainer_id']=$TrainerId;

				    $exercisedata3['Resistence']['trainee_id']=$trainee_id;

					$exercisedata3['Resistence']['exercise']=trim($_POST['nplay3exercise'][$i]);

					$exercisedata3['Resistence']['set']=trim($_POST['nplay3set'][$i]);

					$exercisedata3['Resistence']['rep']=trim($_POST['nplay3rep'][$i]);

					$exercisedata3['Resistence']['rest']=trim($_POST['nplay3rest'][$i]);

					$exercisedata3['Resistence']['temp']=trim($_POST['nplay3temp'][$i]);

					$exercisedata3['Resistence']['coaching_tip']=trim($_POST['nplay3coaching_tip'][$i]);

					$exercisedata3['Resistence']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

					$exercisedata3['Resistence']['start']=$startDate;

					$exercisedata3['Resistence']['end']=$endDate;

					

					

					if($exercisedata3['Resistence']['exercise']!='') {

						

						$this->Resistence->saveAll($exercisedata3);

						

					}

					



				}

				

				for($i=0;$i<$exerciseCount4;$i++)

				{

					

					$exercisedata4['CoolDown']['trainer_id']=$TrainerId;

				    $exercisedata4['CoolDown']['trainee_id']=$trainee_id;

					$exercisedata4['CoolDown']['exercise']=trim($_POST['nplay4exercise'][$i]);

					$exercisedata4['CoolDown']['set']=trim($_POST['nplay4set'][$i]);

					$exercisedata4['CoolDown']['duration']=trim($_POST['nplay4duration'][$i]);

					$exercisedata4['CoolDown']['coaching_tip']=trim($_POST['nplay4coaching_tip'][$i]);

					$exercisedata4['CoolDown']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

					$exercisedata4['CoolDown']['start']=$startDate;

					$exercisedata4['CoolDown']['end']=$endDate;

					

					

					if($exercisedata4['CoolDown']['exercise']!='') {

						

						$this->CoolDown->saveAll($exercisedata4);

						

					}

					



				}

				

				

				/*$html='

				

				<style>

				

table {

 border-collapse: collapse;

    border-spacing: 0;

background: none repeat scroll 0 0 #FFFFFF;

    border: 1px solid #DDDDDD;

    border-radius: 3px 3px 3px 3px;

    margin: 0 0 18px;

}



table tbody tr td {

    border: medium none;

    color: #333333;

    padding: 9px 10px;

    vertical-align: top;

}



table thead tr th, table tfoot tr th, table tbody tr td, table tr td, table tfoot tr td {

    display: table-cell;

    font-size: 14px;

    line-height: 18px;

    text-align: left;

}



.form-select {

    height: 48px;

}



.twelve, .row .twelve {

    width: 100%;

}



.column, .columns {

    float: left;

    min-height: 1px;

    position: relative;

}



.slectedmn {

    background: none repeat scroll 0 0 #F3F3F3;

    box-shadow: 0 1px 2px #D7D7D7 inset;

}

				

				</style>

				

				<table width="100%" border="1" id="a">

				

				<tbody><tr class="slectedmn">

				<td width="100%" class="th2" colspan="4"><h3 style="text-align:left;float:left;">Client Name:   </h3> <span style="float: left; line-height: 32px;  padding: 10px 5px 5px;" id="clnamewt">'.$schcaldt['ScheduleCalendar']['title'].'</span>

				</td>

					

				

				

				</tr>

				

				

				

				

				

				<tr class="slectedmn">

			

				<td width="100%" colspan="4"> <span style="line-height:34px;float:left;">Session Availability:</span>

				 <div class="twelve  form-select columns"> ';

		

		

		

             

				

     

		                 



$html.= date('Y-m-d h:i A',strtotime($schcaldt['ScheduleCalendar']['start'])).' - '.date('h:i A',strtotime($schcaldt['ScheduleCalendar']['end'])).'

				

                

               

              </div>

				</td>		

				

				

				

				</tr>

				

				

				

				

				

				

				

			</tbody></table>

				



			<table width="100%" border="1" id="b">

			<tbody><tr class="slectedmn">

				<td class="th2" colspan="3"><span style="float: left; line-height: 36px;">Goal:</span> '.trim($_POST['goal']).'</td><td> <span style="float: left; line-height: 36px;">Phase:</span> '.trim($_POST['phase']).'</td>

				

				

				</tr>

			</tbody></table>	

			

			<table width="100%" border="1" id="c">

			<tbody><tr class="slectedmn">

				<td class="th2"><span style="float: left; line-height: 36px;">Note:</span>'.trim($_POST['note']).'</td>

				

				

				</tr>

			</tbody></table>

			

			<table width="100%" border="1" id="d">

			<tbody><tr class="slectedmn">

				<td class="th2"><span style="float: left; line-height: 36px;">Alert:</span>'.trim($_POST['alert']).'</td>

				

				

				</tr>

			</tbody></table>	

			

			 <table width="100%" border="1" id="w">

				<tbody><tr class="slectedmn">

				<td class="th2" colspan="5"><h3 style="text-align:left;">Warm-Up </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Duration</th>

				<th class="throw">Coaching Tip</th>

				<th class="throw"></th>

				

				</tr>';

				for($i=0;$i<$exe1Count;$i++)				{

					//if($tempwrkts['TempWorkout']['exercise_type']=='Workout'){

				$html.= '<tr>

	    

		     <td>'.trim($_POST['nplayexercise'][$i]).'</td>

		     <td>'.trim($_POST['nplayset'][$i]).'</td>

		     <td>'.trim($_POST['nplayduration'][$i]).'</td>

		     <td>'.trim($_POST['nplaycoaching_tip'][$i]).'</td>

		     <td></td>

		     

		     

		    

		     </tr>';

					//}

				}

		     



    

	     

	    

	     

     

     $html.= '</tbody></table>   

     

	      

     <table width="100%" border="1" id="cbp">

     <tbody><tr class="slectedmn">

				<td class="th2" colspan="7"><h3 style="text-align:left;">CORE/BALANCE/PLYOMETRIC </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Reps</th>

				<th class="throw">Weight</th>

				<th class="throw">Rest</th>

				<th class="throw">Coaching Tip</th>

				<th></th><th>

				</th></tr>';

				

				for($i=0;$i<$exerciseCount1;$i++)

				{

					//if($tempwrkts['TempWorkout']['exercise_type']=='CORE'){

				$html.= '<tr>

	    

		     <td>'.trim($_POST['nplay1exercise'][$i]).'</td>

		     <td>'.trim($_POST['nplay1set'][$i]).'</td>

		     <td>'.trim($_POST['nplay1rep'][$i]).'</td>

		     <td>'.trim($_POST['nplay1temp'][$i]).'</td>

		     <td>'.trim($_POST['nplay1rest'][$i]).'</td>

		     <td>'.trim($_POST['nplay1coaching_tip'][$i]).'</td>

             <td></td>		    

		          

	     

	     </tr>';

					//}

				}

	     

     $html.=  '</tbody></table> 

      

      

       <table width="100%" border="1" id="saq">

     <tbody><tr class="slectedmn">

				<td class="th2" colspan="7"><h3 style="text-align:left;">SPEED/AGILITY/QUICKNESS </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Reps</th>

				<th class="throw">Weight</th>

				<th class="throw">Rest</th>

				<th class="throw">Coaching Tip</th>

				<th></th><th>

				</th></tr>';

				

				for($i=0;$i<$exerciseCount2;$i++)

				{

					//if($tempwrkts['TempWorkout']['exercise_type']=='SPEED'){

				$html.= '<tr>

	    

		     <td>'.trim($_POST['nplay2exercise'][$i]).'</td>

		     <td>'.trim($_POST['nplay2set'][$i]).'</td>

		     <td>'.trim($_POST['nplay2rep'][$i]).'</td>

		     <td>'.trim($_POST['nplay2rest'][$i]).'</td>

		     <td>'.trim($_POST['nplay2temp'][$i]).'</td>

		     <td>'.trim($_POST['nplay2coaching_tip'][$i]).'</td>

		     <td></td>

	     

	     </tr>';

					//}

		}

	    

      $html.= '</tbody></table> 

      

      

       <table width="100%" border="1" id="res">

     <tbody><tr class="slectedmn">

				<td class="th2" colspan="7"><h3 style="text-align:left;">RESISTANCE </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Reps</th>

				<th class="throw">Weight</th>

				<th class="throw">Rest</th>

				<th class="throw">Coaching Tip</th>

				<th></th>

				</tr>';

				

				for($i=0;$i<$exerciseCount3;$i++)

				{

					//if($tempwrkts['TempWorkout']['exercise_type']=='RESISTANCE'){

				$html.= '<tr>

	    

		     <td>'.trim($_POST['nplay3exercise'][$i]).'</td>

		     <td>'.trim($_POST['nplay3set'][$i]).'</td>

		     <td>'.trim($_POST['nplay3rep'][$i]).'</td>

		     <td>'.trim($_POST['nplay3temp'][$i]).'</td>

		     <td>'.trim($_POST['nplay3rest'][$i]).'</td>

		     <td>'.trim($_POST['nplay3coaching_tip'][$i]).'</td>

		     <td></td>

		          

	     

	     </tr>'; //}

					}

	     

      $html.= '</tbody></table> 

       

      

      <table width="100%" border="1" id="cd">

				<tbody><tr class="slectedmn">

				<td class="th2" colspan="5"><h3 style="text-align:left;">COOL-DOWN </h3>

				

				</td>

				</tr>

				

				<tr><th class="throw">Exercise</th>

				<th class="throw">Sets</th>

				<th class="throw">Duration</th>

				<th class="throw">Coaching Tip</th>

				<th></th>

				</tr>';

				

				for($i=0;$i<$exerciseCount4;$i++)

				{

					//if($tempwrkts['TempWorkout']['exercise_type']=='COOL'){

				$html.= '<tr>

	    

		     <td>'.trim($_POST['nplay4exercise'][$i]).'</td>

		     <td>'.trim($_POST['nplay4set'][$i]).'</td>

		     <td>'.trim($_POST['nplay4duration'][$i]).'</td>

		     <td>'.trim($_POST['nplay4coaching_tip'][$i]).'</td>

		     <td></td>

		          

	     

	     </tr>';

					//}

				}

     

     $html.= '</tbody></table> ';



   //  echo 	$html; exit;

	//require_once(DIRECT_WEBROOT_PATH.'/html2pdf/html2pdf.class.php');

	

	/*$html=' <div style="clear: both; margin-top: 150px; margin-left: 150px; width: 70%;">

    <form id="editRWa" action="" method="POST" onsubmit="return validatefrmEW();">

      

        <h2>Print Workout</h2></form></div>';*/



       /*App::import('Vendor', 'html2pdf', array('file' => 'html2pdf' .DS . 'html2pdf.class.php'));

	   $name='Workout.pdf';



	   $user_lang = '';

	   $html2pdf = new HTML2PDF();

	  



	   $html2pdf->WriteHTML($html);

	   $html2pdf->Output($name,'F');

	

	   header("Expires: 0");

	   header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 

	   header("Cache-Control: no-store, no-cache, must-revalidate");

	   header("Cache-Control: post-check=0, pre-check=0", false);

	   header("Pragma: no-cache");

       header("Content-type: application/pdf"); 

	   header('Content-length: '.filesize($name));

	   header('Content-disposition: attachment; filename='.$name);

	   readfile($name);*/

/*

	App::import('Vendor', 'html2pdf.class');

	

	$name='Workout.pdf';

	$user_lang = '';

	$html2pdf = new HTML2PDF('P', '', $user_lang);

	$html2pdf->pdf->IncludeJS($script);

	$html2pdf->WriteHTML($html);

	$html2pdf->Output($name,'F');	



	header("Expires: 0");

	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 

	header("Cache-Control: no-store, no-cache, must-revalidate");

	header("Cache-Control: post-check=0, pre-check=0", false);

	header("Pragma: no-cache");

	header("Content-type: application/pdf"); 

	header('Content-length: '.filesize($name));

	header('Content-disposition: attachment; filename='.$name);

	readfile($name);

	*/

			

	$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have edited Workout Data successfully.");

			

	echo json_encode($response);

	exit;

	  

	  

	  

	  

	}

	public function addmeasurement()

		{

            $this->layout='';

			$this->autoRender=false;

			$TrainerId = $this->Session->read('USER_ID');



           $data=array();



           $showdate=trim($_POST['mdate']);





            $data['Measurement']['trainee_id']=trim($_POST['mtraineeid']);

			$data['Measurement']['trainer_id']=trim($TrainerId);

			//$data['Measurement']['gender']=trim($_POST['mgender']);

			$data['Measurement']['show_date']=date('Y-m-d',strtotime($showdate));

			$data['Measurement']['age']=trim($_POST['mage']);

			$data['Measurement']['height']=trim($_POST['mheight']);

			$data['Measurement']['weight']=trim($_POST['mweight']);

			$data['Measurement']['neck']=trim($_POST['mneck']);

			$data['Measurement']['chest']=trim($_POST['mchest']);

			$data['Measurement']['waist']=trim($_POST['mwaist']);

			$data['Measurement']['hips']=trim($_POST['mhips']);

			$data['Measurement']['thigh']=trim($_POST['mthigh']);

			$data['Measurement']['calf']=trim($_POST['mcalf']);

			$data['Measurement']['bicep']=trim($_POST['mbicep']);

			$data['Measurement']['added_date']=date('Y-m-d H:i:s');

			$data['Measurement']['modified_date']=date('Y-m-d H:i:s');

			if($this->Measurement->save($data))

			{

                 echo 'Successfully saved.';

			} else

			{

               echo 'Sorry, some issue occur. Please fill again correct data';

			}

			

			

		}

		public function getmeasurement()

		{

            $this->layout='';

			$this->autoRender=false;

			$clientid=trim($_POST['trainee_id']);

			$uid = $this->Session->read('USER_ID');



			$listdata=$this->Measurement->find("all",array("conditions"=>array("Measurement.trainee_id"=>$clientid,"Measurement.trainer_id"=>$uid),'order'=>array('Measurement.show_date DESC')));



			

           if(!empty($listdata))

			{

              echo "<table border='1' class='newst'>

		     <tr>

			<th> Date </th>

			<th> Age </th>

			<th> Weight (lbs) </th>

			<th> Height (Cm)</th>

			<th> Neck </th>

			<th> Chest </th>

			<th> Waist </th>

			<th> Hips </th>

			<th> Thigh </th>

			<th> Calf </th>

			<th> Bicep </th>

			<th> Action </th>

	        </tr>";

             foreach($listdata as $listdatas=>$listdatav)

				{

			echo "<tr id='g_".$listdatav['Measurement']['id']."'>

		    <td> ".date('m/d/Y',strtotime($listdatav['Measurement']['show_date']))." </td>

			<td> ".$listdatav['Measurement']['age']." </td>

			<td> ".$listdatav['Measurement']['weight']." </td>

			<td> ".$listdatav['Measurement']['height']." </td>

			<td> ".$listdatav['Measurement']['neck']." </td>

			<td> ".$listdatav['Measurement']['chest']." </td>

			<td> ".$listdatav['Measurement']['waist']." </td>

			<td> ".$listdatav['Measurement']['hips']." </td>

			<td> ".$listdatav['Measurement']['thigh']." </td>

			<td> ".$listdatav['Measurement']['calf']." </td>

			<td> ".$listdatav['Measurement']['bicep']." </td>

			<td> <a onclick='deletemes(".$listdatav['Measurement']['id'].");' href='javascript:void(0);'><img src='".$this->config['url']."images/deleteicon.png'></a></td>

			</tr>";

				}

				echo " </table>";

			} else{

                echo 0;

			}



		}



	public function deletemes()

	{

		 $this->layout='';

			$this->autoRender=false;

		$gmid = $_POST['gmid'];

		$this->Measurement->delete($gmid);	

		

		echo 1;

	}

	

	public function checkduplicatename()

	{

		$this->layout='';

		$this->autoRender=false;

		

		$id = $this->Session->read('USER_ID');

		$str = $_POST['str'];

       if(!preg_match('/\s/',$str))

		{



		$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id !="=>$id,'Trainer.publicproname'=>$str)));

		

		/*echo"<pre>";

		print_r($setSpecalistArr);

		echo"</pre>";

		exit;*/

		if(!empty($setSpecalistArr))

		{

			$response = array("responseclassName"=>"nFailed","errorMsg"=>"Sorry, This profile name is already used please enter another name..");

		}

		else 

		{

			$response = array("responseclassName"=>"nSuccess","errorMsg"=>"This profile name is available.");

		}

		} else

		{

             $response = array("responseclassName"=>"nFailed","errorMsg"=>"Please don't use space.");

		}

			

	echo json_encode($response);

	exit;

		

	}

	

	public function edit_exercise_history_temp()

	{

		$this->layout = '';

		$this->render = false;

		$id = $this->Session->read('USER_ID');

		

		$group_id = $_POST['group_id'];

		

		$response=array();

		

		$this->TempWorkout->query("delete from temp_workouts where trainer_id='".trim($_POST['trainer_id'])."' and group_id='".$group_id."' and category_id='".trim($_POST['workoutcategory'])."'");

		

		$exe1Count = count($_POST['nplayexercise']); 

		$exerciseCount1 = count($_POST['nplay1exercise']);

		$exerciseCount2 = count($_POST['nplay2exercise']);

		$exerciseCount3 = count($_POST['nplay3exercise']);

		$exerciseCount4 = count($_POST['nplay4exercise']);

		

		/*$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$_POST['trainee_id'])));

		

		$setClientArr = $this->TempWorkout->find('first',array('fields'=>array('max(TempWorkout.group_id) as maxva')));

		

		

		$group_id=$setClientArr[0]['maxva'] + 1;*/

		

		

		/*echo $group_id;

		exit;*/

		

		for($i=0;$i<$exe1Count;$i++)

		{

			

			$exercisedata['TempWorkout']['group_id']=$group_id;		    

			$exercisedata['TempWorkout']['exercise_type']="Workout";		    

			$exercisedata['TempWorkout']['name']=trim($_POST['workoutname']); 	    

			$exercisedata['TempWorkout']['category_id']=trim($_POST['workoutcategory']); 	    

			$exercisedata['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);		    

			$exercisedata['TempWorkout']['exercise']=trim($_POST['nplayexercise'][$i]);

			$exercisedata['TempWorkout']['set']=trim($_POST['nplayset'][$i]);

			$exercisedata['TempWorkout']['duration']=trim($_POST['nplayduration'][$i]);

			$exercisedata['TempWorkout']['coaching_tip']=trim($_POST['nplaycoaching_tip'][$i]);

			$exercisedata['TempWorkout']['added_date']=date('Y-m-d');

			

			

			if($exercisedata['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata);

				

			}

			

		}



				

				

		for($i=0;$i<$exerciseCount1;$i++)

		{

			

			$exercisedata1['TempWorkout']['group_id']=$group_id;		    

			$exercisedata1['TempWorkout']['exercise_type']="CORE";	

			$exercisedata1['TempWorkout']['name']=trim($_POST['workoutname']); 	    

			$exercisedata1['TempWorkout']['category_id']=trim($_POST['workoutcategory']); 

			$exercisedata1['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata1['TempWorkout']['exercise']=trim($_POST['nplay1exercise'][$i]);

			$exercisedata1['TempWorkout']['set']=trim($_POST['nplay1set'][$i]);

			$exercisedata1['TempWorkout']['rep']=trim($_POST['nplay1rep'][$i]);

			$exercisedata1['TempWorkout']['rest']=trim($_POST['nplay1rest'][$i]);

			$exercisedata1['TempWorkout']['temp']=trim($_POST['nplay1temp'][$i]);

			$exercisedata1['TempWorkout']['coaching_tip']=trim($_POST['nplay1coaching_tip'][$i]);

			$exercisedata1['TempWorkout']['added_date']=date('Y-m-d');

			

			

			

			if($exercisedata1['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata1);

				

			}

			



		}

		

	

		for($i=0;$i<$exerciseCount2;$i++)

		{

			

			$exercisedata2['TempWorkout']['group_id']=$group_id;		    

			$exercisedata2['TempWorkout']['exercise_type']="SPEED";

			$exercisedata2['TempWorkout']['name']=trim($_POST['workoutname']); 	    

			$exercisedata2['TempWorkout']['category_id']=trim($_POST['workoutcategory']);

			$exercisedata2['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata2['TempWorkout']['exercise']=trim($_POST['nplay2exercise'][$i]);

			$exercisedata2['TempWorkout']['set']=trim($_POST['nplay2set'][$i]);

			$exercisedata2['TempWorkout']['rep']=trim($_POST['nplay2rep'][$i]);

			$exercisedata2['TempWorkout']['rest']=trim($_POST['nplay2rest'][$i]);

			$exercisedata2['TempWorkout']['temp']=trim($_POST['nplay2temp'][$i]);

			$exercisedata2['TempWorkout']['coaching_tip']=trim($_POST['nplay2coaching_tip'][$i]);

			$exercisedata2['TempWorkout']['added_date']=date('Y-m-d');

			

			

			if($exercisedata2['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata2);

				

			}

			



		}

		

		for($i=0;$i<$exerciseCount3;$i++)

		{

			

			$exercisedata3['TempWorkout']['group_id']=$group_id;		    

			$exercisedata3['TempWorkout']['exercise_type']="RESISTANCE";

			$exercisedata3['TempWorkout']['name']=trim($_POST['workoutname']); 	    

			$exercisedata3['TempWorkout']['category_id']=trim($_POST['workoutcategory']);

			$exercisedata3['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata3['TempWorkout']['exercise']=trim($_POST['nplay3exercise'][$i]);

			$exercisedata3['TempWorkout']['set']=trim($_POST['nplay3set'][$i]);

			$exercisedata3['TempWorkout']['rep']=trim($_POST['nplay3rep'][$i]);

			$exercisedata3['TempWorkout']['rest']=trim($_POST['nplay3rest'][$i]);

			$exercisedata3['TempWorkout']['temp']=trim($_POST['nplay3temp'][$i]);

			$exercisedata3['TempWorkout']['coaching_tip']=trim($_POST['nplay3coaching_tip'][$i]);

			$exercisedata3['TempWorkout']['added_date']=date('Y-m-d');

			

			

			if($exercisedata3['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata3);

				

			}

			



		}

		

		for($i=0;$i<$exerciseCount4;$i++)

		{

			

			$exercisedata4['TempWorkout']['group_id']=$group_id;		    

			$exercisedata4['TempWorkout']['exercise_type']="COOL";

			$exercisedata4['TempWorkout']['name']=trim($_POST['workoutname']); 	    

			$exercisedata4['TempWorkout']['category_id']=trim($_POST['workoutcategory']);

			$exercisedata4['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata4['TempWorkout']['exercise']=trim($_POST['nplay4exercise'][$i]);

			$exercisedata4['TempWorkout']['set']=trim($_POST['nplay4set'][$i]);

			$exercisedata4['TempWorkout']['duration']=trim($_POST['nplay4duration'][$i]);

			$exercisedata4['TempWorkout']['coaching_tip']=trim($_POST['nplay4coaching_tip'][$i]);

			$exercisedata4['TempWorkout']['added_date']=date('Y-m-d');

			

			

			if($exercisedata4['TempWorkout']['exercise']!='') {

				

				$this->TempWorkout->saveAll($exercisedata4);

				

			}

			



		}

		

		$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have edited Exercise History successfully.");

		

		echo json_encode($response);

		exit;		

	}



	public function printdata()

	{

       $this->layout = '';

	   echo 'okay';

	   App::import('Vendor', 'html2pdf', array('file' => 'html2pdf' .DS . 'html2pdf.class.php'));

	   $name='Workout.pdf';

	$user_lang = '';

	$html2pdf = new HTML2PDF();

	 $testing='testing pdf print fucntionality.';

   //$html2pdf->pdf->IncludeJS($script);

	$html2pdf->WriteHTML($testing);

	$html2pdf->Output($name,'F');

	

	header("Expires: 0");

	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 

	header("Cache-Control: no-store, no-cache, must-revalidate");

	header("Cache-Control: post-check=0, pre-check=0", false);

	header("Pragma: no-cache");

	header("Content-type: application/pdf"); 

	header('Content-length: '.filesize($name));

	header('Content-disposition: attachment; filename='.$name);

	readfile($name);







      





	}

	public function deleteMeasurementsAndGoals()

		{

					

			/* deleteMeasurementsAndGoals	*/

			$this->layout = '';

			$this->render = false;

			$trainer_id = $this->Session->read('USER_ID');

			if(trim($_REQUEST['client_id'])!='' && trim($_REQUEST['mes_id'])!='' && $trainer_id!='')

			{

								

				 $client_id=trim($_REQUEST['client_id']);

				

			     $mes_id=trim($_REQUEST['mes_id']);

				//echo $_POST['id2'];

				//die;

			



				

				//$datavb['id']=trim($_POST['id3']);

				if($this->Measurement->query("delete from measurements where trainer_id='".$trainer_id."' AND trainee_id='".$client_id."' AND id='".$mes_id."'")) {

							

							$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully deleted");

						}

					

			}

			else 

			{

				

				$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, please refresh the page and try again!!");

			}

			

			

				echo json_encode($response);

				exit;	

			

		}
				public function exercise_historybc($clientid=null,$rangeA=null,$rangeB=null){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'exercise_history');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');

		
		if($rangeA!='' && $rangeB=='')
		{
		  	$this->set("selectedslt",$rangeA);
		}
		

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));

		

		$this->set("workoutcategory",$this->WorkoutCategory->find('all',array('conditions'=>array('WorkoutCategory.trainerId'=>$uid),'fields'=>array('WorkoutCategory.id','WorkoutCategory.name'))));

		

		  $this->set("setSpecalistArr",$setSpecalistArr);

		 

		  $tgvs=0;

		  $showoff=1;

		if($clientid!='')

		{

			$this->set("clientid",$clientid);

			

			 $dateN=date('Y-m-d');

			 $dateN2=date('Y-m-d',strtotime("-31 days"));

			

			$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));

			

			  /*echo"<pre>";

			  print_r($setClientArr);

			  echo"</pre>";

			  exit;*/

			

			$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid),'order' => array('Goal.id' => 'DESC')));

			

			

			$this->set('clientGoal',$setClientGoalArr);

			$this->set('setClientArr',$setClientArr);

			/*$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0', 'ScheduleCalendar.status <>'=>'0','ScheduleCalendar.start >'=>date('Y-m-d H:i:s')),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status'),'limit'=>5));*/
			$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0', 'ScheduleCalendar.status <>'=>'0'),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));

			
			
			
			
			$this->set('scheduleCalendars',$scheduleCalendars);

			

			/*echo"<pre>";

			//print_r(date('Y-m-d h:i:s', strtotime($_POST['rangeA'])));

			print_r($scheduleCalendars);

			echo"</pre>";

			exit;*/

			

			$dt1 = date('Y-m-d h:i:s', strtotime($rangeA));

			$dt2 = date('Y-m-d h:i:s', strtotime($rangeB));

			$setClientGoalArr3=array();

			if (!empty($dt1) && $dt1!='1970-01-01 01:00:00' && (!empty($dt2) && $dt2!='1970-01-01 01:00:00')) 

			{

				 $this->set("rangeA",date('m/d/Y', strtotime($rangeA)));

				 $this->set("rangeB",date('m/d/Y', strtotime($rangeB)));

				 

				 //if ((isset($_POST['rangeA']) && $_POST['rangeA']!='') && (isset($_POST['rangeB']) && $_POST['rangeB']!=''))

				 //echo $dt1;



				$setClientGoalArrco=$this->Goal->find("count",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.status"=>1,'Goal.start between ? and ?' => array($dt1, $dt2)),'order' => array('Goal.start' => 'DESC')));
				 
				// $totRec = count($setClientGoalArrco);
				 
				 $setClientGoalArr3=$this->Goal->find("all",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.status"=>1,'Goal.start between ? and ?' => array($dt1, $dt2)),'order' => array('Goal.start' => 'ASC')));

				 

			}

			else 

			{

				$setClientGoalArrco=$this->Goal->find("count",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.status"=>1),'order' => array('Goal.start' => 'DESC')));
				
				//$totRec = count($setClientGoalArrco);
				
				/*$setClientGoalArr3=$this->Goal->find("all",array("conditions"=>array("Goal.trainee_id"=>$clientid),'order' => array('Goal.start' => 'ASC'),'limit'=> 5, 'offset' => $setClientGoalArrco-5));*/
				
				$setClientGoalArr3=$this->Goal->find("all",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.status"=>1),'order' => array('Goal.start' => 'ASC'),'limit'=> 5));
				
				
			}

			$totalGl=count($setClientGoalArr3);

			

			$jtms='';



		 	

					$cnt=1;

					$cn=1;

					if($totalGl>0){
						
						$showoff=0;

				$jtms= "<table border='1' class='newst'>

				

				           <tr>

				           <th></th>";

				     

				

				    for($tg=1;$tg<=$totalGl;$tg++){      

				          $jtms .= " <th><input type='button' style='  height: 36px; margin: 10px 0 10px 10px; width: 93px;' class=change-pic-nav' value='Save Workout' onclick=popupOpenSW(".$setClientGoalArr3[$tgvs]['Goal']['id']."); name='submit'><br/><input type='button' style='  float: left; height: 36px; margin: 0 0 10px 10px; width: 93px;' class=change-pic-nav' value='Repeat Workout' name='submit' onclick=popupOpenRW(".$setClientGoalArr3[$tgvs]['Goal']['id'].")><br/><input type='button' style='  float: left; height: 36px; margin: 0 0 10px 10px; width: 93px;clear: both;' class=change-pic-nav' value='Edit Workout' name='submit' onclick=popupOpenEW(".$setClientGoalArr3[$tgvs]['Goal']['id'].")><br/><input type='button' style='  float: left; height: 36px; margin: 0 0 10px 10px; width: 93px;clear: both;' class=change-pic-nav' value='Delete Workout' name='submit' onclick=deletewrkt(".$setClientGoalArr3[$tgvs]['Goal']['id'].",".$setClientGoalArr3[$tgvs]['Goal']['trainee_id'].")></th>";

				          $tgvs++;

				    }

				          

				          $jtms .= " </tr>

				           <tr>

				           <td style='width:20%;'><b>Client: ".ucwords($setClientArr['Trainee']['full_name'])."</b></td>";

				          

			 foreach($setClientGoalArr3 as $setClientGoalArrsv)

			    {

				$startvaldt=$setClientGoalArrsv['Goal']['start'];

				$endvaldt=$setClientGoalArrsv['Goal']['end'];

				           $jtms .= "<td>".date('m/d/Y h:i A', strtotime($startvaldt))."</td> ";

			    }

				           $jtms .= " </tr>

				           

				          <tr>

				           <td><b>Warm-Up</b></td>";

				            foreach($setClientGoalArr3 as $setClientGoalArrsv)

			              {

				           $jtms .= "<td><table><tr><th>Sets</th><th>Dur.</th><th>Tips</th></tr></table></td>";

			              } 

				

				        $jtms .= " </tr>";

							foreach($setClientGoalArr3 as $setClientGoalArrsv)

						    {

							$startvaldt=$setClientGoalArrsv['Goal']['start'];

							$endvaldt=$setClientGoalArrsv['Goal']['end'];

							$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));

							if(!empty($setWarmupArr))

							{
								
								$showoff=0;

								   $kh=0;

												foreach($setWarmupArr as $key=>$val){

												

												/*if($startvaldt==$val['WarmUps']['start'])

												{

													$jtms .= "<td>";

												}*/

												$jtms .= "<tr>";

												

												$jtms .= "<td>".$val['WarmUps']['exercise']." </td>";

												

												

												/* foreach($setClientGoalArr3 as $setClientGoalArrsv)

			                                     {*/

												for($kh=0;$kh<count($setClientGoalArr3);$kh++)

												{

			                                     if($setClientGoalArr3[$kh]['Goal']['start']==$val['WarmUps']['start']){

												$jtms .= "<td><table><tr><td>".$val['WarmUps']['set']."</td><td>".$val['WarmUps']['duration']."</td><td>".$val['WarmUps']['coaching_tip']."</td></tr></table></td>";

			                                     	}else {

			                                     		$jtms .= "<td></td>";

			                                     	}

												}

			                                    /* }*/

											

												$jtms .= "</tr>";

												

												/*if($startvaldt==$val['WarmUps']['start'])

												{

													$jtms .= "</td>";

												}*/

												

												}

							}

							         //  $jtms .= "<td>".date('d/m/Y', strtotime($startvaldt))."</td> ";

						    }

						    

						    $jtms .= " <tr>

				           <td><b>CORE/BALANCE/PLYOMETRIC</b></td>";

				            foreach($setClientGoalArr3 as $setClientGoalArrsv)

			              {

				           $jtms .= "<td><table><tr><th>Sets</th><th>Rep.</th><th>Wt.</th><th>Rest</th><th>Tips</th></tr></table></td>";

			              } 

			               $jtms .= " </tr>";

			               foreach($setClientGoalArr3 as $setClientGoalArrsv)

						    {

							$startvaldt=$setClientGoalArrsv['Goal']['start'];

							$endvaldt=$setClientGoalArrsv['Goal']['end'];

							

			               $setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));

			               if(!empty($setCoreBalancePlyometricArr))

							{
								
								$showoff=0;

												foreach($setCoreBalancePlyometricArr as $key=>$val){

												

												

													

												$jtms .= "<tr>

												 <td>".$val['CoreBalancePlyometric']['exercise']."</td>";

												

												for($kh=0;$kh<count($setClientGoalArr3);$kh++)

												{

			                                     if($setClientGoalArr3[$kh]['Goal']['start']==$val['CoreBalancePlyometric']['start']){

												$jtms .="<td><table><tr><td>".$val['CoreBalancePlyometric']['set']."</td> <td>".$val['CoreBalancePlyometric']['rep']."</td> <td>".$val['CoreBalancePlyometric']['temp']."</td><td>".$val['CoreBalancePlyometric']['rest']."</td><td>".$val['CoreBalancePlyometric']['coaching_tip']."</td></tr></table></td>";

			                                     	}else {

			                                     		$jtms .= "<td></td>";

			                                     	}

												}

												

												

												

		                               $jtms .= " </tr>";

												

												}

							}

		    

		    

						    }

						    

						    

						     $jtms .= " <tr>

				           <td><b>SPEED/AGILITY/QUICKNESS</b></td>";

				            foreach($setClientGoalArr3 as $setClientGoalArrsv)

			              {

				           $jtms .= "<td><table><tr><th>Sets</th><th>Rep.</th><th>Wt.</th><th>Rest</th><th>Tips</th></tr></table></td>";

			              } 

			               $jtms .= " </tr>";

			               foreach($setClientGoalArr3 as $setClientGoalArrsv)

						    {

							$startvaldt=$setClientGoalArrsv['Goal']['start'];

							$endvaldt=$setClientGoalArrsv['Goal']['end'];

							

			              $setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));

			               if(!empty($setSpeedAgilityQuicknessArr))

							{
								
								$showoff=0;

												foreach($setSpeedAgilityQuicknessArr as $key=>$val){

												

												

													

												$jtms .= "<tr>

												 <td>".$val['SpeedAgilityQuickness']['exercise']."</td>";

												

		                                		for($kh=0;$kh<count($setClientGoalArr3);$kh++)

												{

			                                     if($setClientGoalArr3[$kh]['Goal']['start']==$val['SpeedAgilityQuickness']['start']){

												$jtms .="<td><table><tr><td>".$val['SpeedAgilityQuickness']['set']."</td> <td>".$val['SpeedAgilityQuickness']['rep']."</td> <td>".$val['SpeedAgilityQuickness']['temp']."</td><td>".$val['SpeedAgilityQuickness']['rest']."</td><td>".$val['SpeedAgilityQuickness']['coaching_tip']."</td></tr></table></td>";

			                                     	}else {

			                                     		$jtms .= "<td></td>";

			                                     	}

												}

												

												

												

		                               $jtms .= " </tr>";

												

												}

							}

		    

		    

						    }

						    

						    

						      $jtms .= " <tr>

				           <td><b>RESISTANCE</b></td>";

				            foreach($setClientGoalArr3 as $setClientGoalArrsv)

			              {

				           $jtms .= "<td><table><tr><th>Sets</th><th>Rep.</th><th>Wt.</th><th>Rest</th><th>Tips</th></tr></table></td>";

			              } 

			               $jtms .= " </tr>";

			               foreach($setClientGoalArr3 as $setClientGoalArrsv)

						    {

							$startvaldt=$setClientGoalArrsv['Goal']['start'];

							$endvaldt=$setClientGoalArrsv['Goal']['end'];

							

			            	

			$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

			

			               if(!empty($setResistenceArr))

							{
								$showoff=0;

												foreach($setResistenceArr as $key=>$val){

												

												

													

												$jtms .= "<tr>

												 <td>".$val['Resistence']['exercise']."</td>";

												

												

												for($kh=0;$kh<count($setClientGoalArr3);$kh++)

												{

			                                     if($setClientGoalArr3[$kh]['Goal']['start']==$val['Resistence']['start']){

												$jtms .="<td><table><tr><td>".$val['Resistence']['set']."</td> <td>".$val['Resistence']['rep']."</td> <td>".$val['Resistence']['temp']."</td><td>".$val['Resistence']['rest']."</td><td>".$val['Resistence']['coaching_tip']."</td></tr></table></td>";

			                                     	}else {

			                                     		$jtms .= "<td></td>";

			                                     	}

												}

												

												

												

		                               $jtms .= " </tr>";

												

												}

							}

		    

		    

						    }

						    

						         $jtms .= " <tr>

				           <td><b>COOL - DOWN</b></td>";

				            foreach($setClientGoalArr3 as $setClientGoalArrsv)

			              {

				           $jtms .= "<td><table><tr><th>Sets</th><th>Dur.</th><th>Tips</th></tr></table></td>";

			              } 

			               $jtms .= " </tr>";

			               foreach($setClientGoalArr3 as $setClientGoalArrsv)

						    {

							$startvaldt=$setClientGoalArrsv['Goal']['start'];

							$endvaldt=$setClientGoalArrsv['Goal']['end'];

							

			            	

				 $setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

			

			               if(!empty($setCoolDownArr))

							{
								$showoff=0;

												foreach($setCoolDownArr as $key=>$val){

												

												

													

												$jtms .= "<tr>

												 <td>".$val['CoolDown']['exercise']."</td>";

												

												for($kh=0;$kh<count($setClientGoalArr3);$kh++)

												{

			                                     if($setClientGoalArr3[$kh]['Goal']['start']==$val['CoolDown']['start']){

												$jtms .="<td><table><tr><td>".$val['CoolDown']['set']."</td> <td>".$val['CoolDown']['duration']."</td> <td>".$val['CoolDown']['coaching_tip']."</td></tr></table></td>";

			                                     	}else {

			                                     		$jtms .= "<td></td>";

			                                     	}

												}

												

												

												

		                               $jtms .= " </tr>";

												

												

												}

							}

		    

		    

						    } 

		     

						    

				   $jtms .= " </table>";

					}

         $jtms12='';

        $jtms12 .= " <table border='1' width='100%'>

				

				<tr class='slectedmn'>

				<td colspan='3' class=\"th2\"><h3 style='text-align:left;float:left;'>Client Name: </h3> <span id=\"clname\" style=\"float: left; line-height: 32px;  padding: 10px 5px 5px;\">".ucwords($setClientArr['Trainee']['full_name'])."</span>

				</td>

				<td  style=\"padding-left:220px;\"></td>

				

				

				

				</tr>

			</table>";	

				

			

		if(!empty($setClientGoalArr3)){	

				

			foreach($setClientGoalArr3 as $setClientGoalArrsv)

			{

				$startvaldt=$setClientGoalArrsv['Goal']['start'];

				$endvaldt=$setClientGoalArrsv['Goal']['end'];

				

				

				if($cnt!=1)

			{

				$shdate =date('Y-m-d',strtotime("-$cn days"));

			}

			

			$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));

			

			

			

				

			$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));

			

			$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));

			

			$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

			

			 $setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

			

			if(!empty($setSpeedAgilityQuicknessArr) || !empty($setWarmupArr) || !empty($setCoreBalancePlyometricArr) || !empty($setResistenceArr) || !empty($setCoolDownArr)){
				
				$showoff=0;

			 $jtms12 .= " <table border='1' width='100%'>

				

				<tr class='slectedmn'>

				<td colspan='3'  class=\"th2\"><h3 style='text-align:left;float:left;'>Date: </h3> <span id=\"clname\" style=\"float: left; line-height: 32px;  padding: 10px 5px 5px;\">".$startvaldt."</span>

				

				</td>

				<td  style=\"padding-left:10px;\"></td>

				

				

				

				</tr></table>";

			 

			 if($setClientGoalArrsv['Goal']['goal']!=''){

			 $jtms12 .= "<table width='100%' border='1'>

			<tbody><tr class='slectedmn'>

				<td class='th2' colspan='3'><span style='float: left;'>Goal: </span>".$setClientGoalArrsv['Goal']['goal']." </td><td> <span style='float: left; '>Phase: </span>".$setClientGoalArrsv['Goal']['phase']." </td>

				</tr>

			</tbody></table>";

			 

			 	

            }

            if($setClientGoalArrsv['Goal']['note']!=''){

             $jtms12 .= "<table width='100%' border='1'>

			<tbody><tr class='slectedmn'>

				<td class='th2'><span style='float: left; '>Note: </span>".$setClientGoalArrsv['Goal']['note']." </td>

				</tr>

			</tbody></table>";

            }

			

             if($setClientGoalArr2['Goal']['alert']!=''){

             $jtms12 .= "<table width='100%' border='1'>

			<tbody><tr class='slectedmn'>

				<td class='th2'><span style='float: left; '>Alert: </span>".$setClientGoalArrsv['Goal']['alert']." </td>

				</tr>

			</tbody></table>";

            }

			 

			} 

				

				

			

			

			if(!empty($setWarmupArr))

			{

			$showoff=0;

			 $jtms12 .= "<table border='1' width='100%' >

				<tr class='slectedmn'>

				<td colspan='6' class=\"th2\"><h3 style='text-align:left;'>Warm-Up </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th  class=\"throw\">Duration</th>

				<th  class=\"throw\">Coaching Tip</th>

				<th  class=\"throw\">Date</th>

				<th  class=\"throw\"></th>

				

				</tr>";

			

				foreach($setWarmupArr as $key=>$val){

					

				 $jtms12 .= "<tr>

	    

		     <td>".$val['WarmUps']['exercise']."</td>

		     <td>".$val['WarmUps']['set']."</td>

		     <td>".$val['WarmUps']['duration']."</td>

		     <td>".$val['WarmUps']['coaching_tip']."</td>

		     <td>".date('Y-m-d',strtotime($startvaldt))."</td>

		     <td></td>		     

		     </tr>";

				  

				}

      $jtms12 .= "</table> ";  

			}

			if(!empty($setCoreBalancePlyometricArr))

			{

	      $showoff=0;

     $jtms12 .= "<table border='1' width='100%' >

     <tr class='slectedmn'>

				<td colspan='8' class=\"th2\"><h3 style='text-align:left;'>CORE/BALANCE/PLYOMETRIC </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th  class=\"throw\">Reps</th>

				<th  class=\"throw\">Weight</th>

				<th  class=\"throw\">Rest</th>

				<th  class=\throw\">Coaching Tip</th>

				<th  class=\throw\">Date</th>

				<th><th>

				</tr>";

				

	foreach($setCoreBalancePlyometricArr as $key=>$val){			 

     $jtms12 .= "<tr>

	    

		     <td>".$val['CoreBalancePlyometric']['exercise']."</td>

		     <td>".$val['CoreBalancePlyometric']['set']."</td>

		     <td>".$val['CoreBalancePlyometric']['rep']."</td>

		     <td>".$val['CoreBalancePlyometric']['temp']."</td>

		     <td>".$val['CoreBalancePlyometric']['rest']."</td>

		     <td>".$val['CoreBalancePlyometric']['coaching_tip']."</td>

		     <td>".date('Y-m-d',strtotime($startvaldt))."</td>

             <td></td>		    

		          

	     

	     </tr>";

			}		 

	     

       $jtms12 .= "</table>";

			}

			

			

			

			

			if(!empty($setSpeedAgilityQuicknessArr))

			{

      $showoff=0;

       $jtms12 .= "<table border='1' width='100%' >

     <tr class='slectedmn'>

				<td colspan='8' class=\"th2\"><h3 style='text-align:left;'>SPEED/AGILITY/QUICKNESS </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th class=\"throw\">Reps</th>

				<th class=\"throw\">Weight</th>

				<th class=\"throw\">Rest</th>

				<th class=\"throw\">Coaching Tip</th>

				<th class=\"throw\">Date</th>

				<th><th>

				</tr>";

		foreach($setSpeedAgilityQuicknessArr as $key=>$val){	

       	

			$jtms12 .="<tr>

	    

		     <td>".$val['SpeedAgilityQuickness']['exercise']."</td>

		     <td>".$val['SpeedAgilityQuickness']['set']."</td>

		     <td>".$val['SpeedAgilityQuickness']['rep']."</td>

		     <td>".$val['SpeedAgilityQuickness']['temp']."</td>

		     <td>".$val['SpeedAgilityQuickness']['rest']."</td>

		     <td>".$val['SpeedAgilityQuickness']['coaching_tip']."</td>

		     <td>".date('Y-m-d',strtotime($startvaldt))."</td>

		     <td></td>

	     

	    </tr>";

		}

      $jtms12 .= "</table>"; 

		}

      

			

		if(!empty($setResistenceArr))

			{

      $showoff=0;

      $jtms12 .= "<table border='1' width='100%' >

     <tr class='slectedmn'>

				<td colspan='8' class=\"th2\"><h3 style='text-align:left;'>RESISTANCE </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th class=\"throw\">Reps</th>

				<th class=\"throw\">Weight</th>

				<th class=\"throw\">Rest</th>

				<th class=\"throw\">Coaching Tip</th>

				<th class=\"throw\">Date</th>

				<th></th>

				</tr>";

				

				

	    

		    foreach($setResistenceArr as $key=>$val){	

       	

			$jtms12 .="<tr>

	    

		     <td>".$val['Resistence']['exercise']."</td>

		     <td>".$val['Resistence']['set']."</td>

		     <td>".$val['Resistence']['rep']."</td>

		     <td>".$val['Resistence']['temp']."</td>

		     <td>".$val['Resistence']['rest']."</td>

		     <td>".$val['Resistence']['coaching_tip']."</td>

		     <td>".date('Y-m-d',strtotime($startvaldt))."</td>

		     <td></td>

	     

	    </tr>";

		}

      $jtms12 .= "</table>"; 

		}



     

		if(!empty($setCoolDownArr))

			{

				$showoff=0;

     $jtms12 .= " <table border='1' width='100%'>

				<tr class='slectedmn'>

				<td colspan='6' class=\"th2\"><h3 style='text-align:left;'>COOL-DOWN </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th  class=\"throw\">Duration</th>

				<th  class=\"throw\">Coaching Tip</th>

				<th  class=\"throw\">Date</th>

				<th></th>

				</tr>";

				

			 foreach($setCoolDownArr as $key=>$val){	

       	

			$jtms12 .="<tr>

	    

		     <td>".$val['CoolDown']['exercise']."</td>

		     <td>".$val['CoolDown']['set']."</td>

		     <td>".$val['CoolDown']['duration']."</td>		   

		     <td>".$val['CoolDown']['coaching_tip']."</td>

		     <td>".date('Y-m-d',strtotime($startvaldt))."</td>

		     <td></td>

	     

	    </tr>";

		}

      $jtms12 .= "</table>"; 

		}

				

				 $cnt++;

				

				}

		}

				 $jtms12 .= "</table>";

			

			if($showoff==0){

				$this->set("rst",$jtms);

				$this->set("showoff",$showoff);

			}

			else {

				$this->set("rst",'');

				$this->set("showoff",$showoff);

			}

			

		}

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	



		$surl=$this->config['url'].'home/exercise_history/'.$clientid;

			$this->set("surl",$surl);

		

		

			

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	



		$this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$uid,'Trainee.status'=>1,'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.full_name ASC'),'fields'=>array('Trainee.id','Trainee.full_name'))));

		

		

			

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);

		

		

		}

	public function firstlogin()
		{			
			if($this->params['pass'][0]=='g')
			{
					$dbusertype = $this->Session->read('UTYPE');					
					$this->set("dbusertype",$dbusertype);
					$first_time = 1;
					$id = $this->Session->read('USER_ID');
					$this->Trainer->id=$id;
					$this->Trainer->query("update trainers set first_time_login = '".$first_time."' where id='".$id."'");					
					$this->redirect('/home/communication_center/');

			}
		}
		
	public function viewmygroups($trainerid=null)
	{
		$this->checkUserLogin();

		$this->layout = "homelayout";	

		$this->set("leftcheck",'homemy_clients');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$id = $this->Session->read('USER_ID');

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		$this->set("setSpecalistArr",$setSpecalistArr);
		
		//echo "<pre>"; print_r($setSpecalistArr); echo "</pre>"; die;

		$club_trai_id = $setSpecalistArr['Trainer']['club_id'];

		$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));

		$this->set("setSpecalistArr1",$setSpecalistArr1);

		$groupView=$this->Group->find("all",array("conditions"=>array("Group.trainer_id"=>$setSpecalistArr['Trainer']['id']),'fields'=>array('Group.id','Group.group_name', 'Group.status'),'order'=>array('Group.group_name ASC')));

		$this->set("groupView",$groupView);
			
	}
	 
	 
	 
	 public function newgroup()
     {
		$this->layout = "homelayout";	

		$this->set("leftcheck",'homemy_clients');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$id = $this->Session->read('USER_ID');

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		$this->set("setSpecalistArr",$setSpecalistArr);

		if(!empty($this->data)) {

		$groupData=$this->Group->find('first',array("conditions"=>array('Group.group_name'=>$this->data['Group']['group_name'])));
		
		//echo "<pre>"; print_r($groupData); echo "</pre>"; die;
		
		if(empty($groupData)){

			$group_data['Group']['group_name']=$this->data['Group']['group_name'];
			
			$group_data['Group']['trainer_id']=$this->data['Group']['trainer_id'];
			
			$group_data['Group']['added_date']=date('Y-m-d H:i:s');
			
			$group_data['Group']['modified_date']=date('Y-m-d H:i:s');
			
			$group_data['Group']['status']=$this->data['Group']['status'];	
			
			$this->Group->save($group_data);	
			
			$this->Session->setFlash('Thanks, you have add the Group successfully.');

			$this->redirect('/home/viewmygroups/');
		}
		else
		{
			$this->Session->setFlash('Group Name Duplicated. Please use different name!!');
		}

		
		}

	 }
	 
	public function deletegroup()
	{	
		$this->layout = '';
		$this->render = false;
		if(trim($_POST['id'])!='')
		{
			$datav=array();				
			$datav['id']=trim($_POST['id']);
			if($this->Group->delete($datav)) {							
				$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Deleted Successfully!!");				
			}
			else {
				$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");
			}
		}
		else{		
		$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry, please refresh the page and try again!!");
		}
		echo json_encode($response);
		exit;			
	}
	
	
	
	public function editgroup($gid=null){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		$this->set("leftcheck",'homemy_clients');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	

		$gid=base64_decode($gid);

		$this->set("gid",$gid);				

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);

		$club_trai_id = $setSpecalistArr['Trainer']['club_id'];

		$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));

		$this->set("setSpecalistArr1",$setSpecalistArr1);


		if(!empty($this->data)){			

			$this->Group->set($this->data);

			$this->Group->id = $this->data['Group']['id'];

			if($this->Group->validates()) {
				
				$this->request->data["Group"]["modified_date"] = date('Y-m-d H:i:s');

				$this->request->data["Group"]["group_name"]  = $this->data['Group']['group_name'];

				if($this->Group->save($this->data)) {

					$this->Session->setFlash('Group information has been updated successfully.');
					$this->redirect('/home/viewmygroups/');

				} else {

					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
			else {
				$this->Session->setFlash('Some error has been occured. Please try again.');	
			}	
		} 
		else{

			if(is_numeric($gid) && $gid > 0) {

			$this->Group->id = $gid;

			$this->request->data = $this->Group->read();

			} 
			else 
			{
				$this->Session->setFlash('Invalid Group id.');
				$this->redirect('/home/viewmygroups/');
			}
		}
	}
	
	
	public function addclientingroup($gid=null)
     {
		$this->layout = "homelayout";	

		$this->set("leftcheck",'homemy_clients');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$id = $this->Session->read('USER_ID');

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		$this->set("setSpecalistArr",$setSpecalistArr);
		
		$gid=base64_decode($gid);

		$this->set("gid",$gid);	
		
		$groupData=$this->Group->find('first',array("conditions"=>array('Group.id'=>$gid)));
		
		$this->set("groupData",$groupData);

		$client_data= $this->Trainee->find('list',array("conditions"=>array('Trainee.trainer_id'=>$setSpecalistArr['Trainer']['id'],'Trainee.status'=>1),'fields'=>array('Trainee.id','Trainee.full_name')));
			
		$this->set("client_data",$client_data);		
		
		if(!empty($this->data)) {
			$this->GroupMember->create();
			$mainArr = array();
			foreach ($this->data['GroupMember']['group_clients'] as $key => $value) {
				$groupmemData=$this->GroupMember->find('first',array("conditions"=>array('GroupMember.group_name'=>$this->data['GroupMember']['group_name'],'GroupMember.client_id'=>$value)));
				if(empty($groupmemData)){			
					$trainee_data= $this->Trainee->find('first',array("conditions"=>array('Trainee.id'=>$value),'fields'=>array('Trainee.full_name')));
					$this->set("trainee_data",$trainee_data);	
					$mainArr['trainer_id']=$this->data['GroupMember']['trainer_id'];
					$mainArr['group_id']=$this->data['GroupMember']['id'];
					$mainArr['group_name']=$this->data['GroupMember']['group_name'];
					$mainArr['client_id']=$value;
					$mainArr['client_name']=$trainee_data['Trainee']['full_name'];
					$mainArr['added_date']=date('Y-m-d H:i:s');
					$mainArr['modified_date']=date('Y-m-d H:i:s');
					$this->GroupMember->saveAll($mainArr);
				}
				else{
					
				}
			}
			$this->Session->setFlash('Group Clients has been added successfully.');
			$this->redirect('/home/viewmygroups/');
			
		}
	 }
	 
	 
	 public function editclientingroup($gid=null)
     {
		$this->layout = "homelayout";	

		$this->set("leftcheck",'homemy_clients');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$id = $this->Session->read('USER_ID');

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		$this->set("setSpecalistArr",$setSpecalistArr);
		
		$gid=base64_decode($gid);

		$this->set("gid",$gid);	
		
		$groupData=$this->Group->find('first',array("conditions"=>array('Group.id'=>$gid)));
		
		$this->set("groupData",$groupData);

		$client_data= $this->Trainee->find('list',array("conditions"=>array('Trainee.trainer_id'=>$setSpecalistArr['Trainer']['id'],'Trainee.status'=>1),'fields'=>array('Trainee.id','Trainee.full_name')));
			
		$this->set("client_data",$client_data);
		
		$sele_clients = $this->GroupMember->find('list',array("conditions"=>array('GroupMember.trainer_id'=>$setSpecalistArr['Trainer']['id'],'GroupMember.group_id'=>$gid),'fields'=>array('GroupMember.client_id','GroupMember.client_name')));
		
		$this->set("sele_clients",$sele_clients);
		
		//echo "<pre>"; print_r($sele_clients); echo "</pre>";
		
		if(!empty($this->data)) {
			//echo "<pre>"; print_r($this->data); echo "</pre>";
			$this->GroupMember->deleteAll(array('GroupMember.trainer_id' => $setSpecalistArr['Trainer']['id'],'GroupMember.group_id' => $this->data['GroupMember']['id']));			
			$this->GroupMember->create();
			$mainArr = array();
			foreach ($this->data['GroupMember']['group_clients'] as $key => $value) {
				$groupmemData=$this->GroupMember->find('first',array("conditions"=>array('GroupMember.group_name'=>$this->data['GroupMember']['group_name'],'GroupMember.client_id'=>$value)));
				$this->set("groupmemData",$groupmemData);
				//echo "<pre>"; print_r($groupmemData); echo "</pre>"; die;
				if(empty($groupmemData)){			
					$trainee_data= $this->Trainee->find('first',array("conditions"=>array('Trainee.id'=>$value),'fields'=>array('Trainee.full_name')));
					$this->set("trainee_data",$trainee_data);	
					$mainArr['trainer_id']=$this->data['GroupMember']['trainer_id'];
					$mainArr['group_id']=$this->data['GroupMember']['id'];
					$mainArr['group_name']=$this->data['GroupMember']['group_name'];
					$mainArr['client_id']=$value;
					$mainArr['client_name']=$trainee_data['Trainee']['full_name'];
					$mainArr['added_date']=date('Y-m-d H:i:s');
					$mainArr['modified_date']=date('Y-m-d H:i:s');
					$this->GroupMember->saveAll($mainArr);
				}
				else{
				}
			}			
			$this->Session->setFlash('Group Clients has been added successfully.');
			$this->redirect('/home/viewmygroups/');
			
		}
	 }
	 
	 
	 
	public function groupdetail()
	{
		$this->layout = "ajax";

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	

		$gdid=trim($_POST['gdid']);	
		
		$sessionid=trim($_POST['sessionid']);
		
		/*,'session_purchase.session_id'=>$sessionid*/
		
		$groupData = $this->GroupMember->find('all', array(
		'joins' => array(
					array(
					'table' => 'session_purchases',
					'alias' => 'session_purchase',
					'type' => 'LEFT',
					'conditions' => array(
					'GroupMember.client_id = session_purchase.client_id','session_purchase.session_id'=>$sessionid)
					),
					array(
					'table' => 'workouts',
					'alias' => 'workout',
					'type' => 'LEFT',
					'conditions' => array('session_purchase.session_id=workout.id')
					),
					array(
					'table' => 'trainees',
					'alias' => 'trainee',
					'type' => 'LEFT',
					'conditions' => array('trainee.id=GroupMember.client_id')
					),
					),
				'conditions' => array(
				'GroupMember.group_id'=>$gdid,'trainee.status'=>1),
		'fields' => array("GroupMember.group_name","GroupMember.client_name","workout.workout_name","session_purchase.no_of_purchase","session_purchase.no_of_booked"),
		)    
		);
		
		/*$groupData = $this->GroupMember->find('all', array('conditions' => array('GroupMember.group_id'=>$gdid)));*/

		$this->set("groupData",$groupData);

		//echo"<pre>";print_r($groupData);echo"</pre>";
		//die;
	}
	public function clientdata()
	{
		$this->layout = "ajax";

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	

		$gdid=trim($_POST['gdid']);			
		
		$groupData = $this->GroupMember->find('all',array("conditions"=>array('GroupMember.group_id'=>$gdid),'fields'=>array('GroupMember.group_name','GroupMember.client_id')));
		
		echo json_encode($groupData);
		exit;
	}
	
	public function getgroupclientsworkout()
	{
		$this->layout = "";	

		$this->autoRender=false;

		$wrkt=trim($_POST['workout']);

		$response = array();
		
		$clientid=$_POST['clientid'];
		
		$gdid=trim($_POST['gdid']);	
				
		$sessiontypeid=$_POST['sessiontypeid'];

		$SessionTypeVal = $_POST['SessionTypeVal'];

		$uid = $this->Session->read('USER_ID');		
			    
		$trainerid=$uid;
			    
		$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));
		
		$groupData = $this->GroupMember->find('all',array("conditions"=>array('GroupMember.group_id'=>$gdid),'fields'=>array('GroupMember.group_name','GroupMember.client_id')));		
		
		$this->set("groupData",$groupData);
		
		//echo "<pre>";print_r($groupData);echo "</pre>"; die;
		$flag_satus = "success";
		foreach($groupData as $gd)
		{
			$workoutData=$this->SessionPurchase->find('first',array("conditions"=>array('SessionPurchase.client_id'=>$gd['GroupMember']['client_id'],'SessionPurchase.trainer_id'=>$trainerid,'SessionPurchase.session_id'=>$sessiontypeid)));
			
			$purchSession = $workoutData['SessionPurchase']['no_of_purchase'];
		    
			$bokedSession = $workoutData['SessionPurchase']['no_of_booked'];

			$leftSession = $purchSession - $bokedSession;
			
			if (empty($workoutData)|| $leftSession <= 0)
			{
				$flag_satus = "fail";
			}
			//echo "<pre>";print_r($workoutData);echo "</pre>"; 					
		}		
		echo json_encode($flag_satus);

		exit;
	}
	
	
	
	public function setslotgroup()
	{	
		$this->layout = "";

		$this->autoRender=false;

		if(trim( $_POST['slot'])!='')
		{	
			$dvstart=$_POST['slot'];

			$dvend=$_POST['endslot'];

			$groupid=$_POST['groupid'];
				
			//$trainerid=$_POST['trainerid'];
				
			$sessiontypeid=$_POST['sessiontypeid'];				
			
			$apty='Booked';
				
			$SessionTypeVal = $_POST['SessionTypeVal'];

			//$apty=$_POST['apty'];

			$uid = $this->Session->read('USER_ID');		
			    
			$trainerid=$uid;
			    
			$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));
			    
			$CheckDataExist=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.start"=>$dvstart,"ScheduleCalendar.end"=>$dvend,"ScheduleCalendar.trainer_id"=>$uid,"ScheduleCalendar.trainee_id"=>$groupid,"ScheduleCalendar.status"=>1)));
			
			//$groupData = $this->GroupMember->find('all',array("conditions"=>array('GroupMember.group_id'=>$groupid),'fields'=>array('GroupMember.group_name','GroupMember.client_id')));	

			$groupData=$this->GroupMember->find("first",array("conditions"=>array("GroupMember.group_id"=>$groupid)));			
		
			$this->set("groupData",$groupData);
			
			//echo "<pre>";print_r($groupData);echo "</pre>";
		 
			if(!empty($CheckDataExist))
		    {
		      	$response = array("responseclassName"=>"nFailure","errorMsg"=>"Sorry this time slot already booked.");
		         	
				echo json_encode($response);
					
				exit;
		    }
		        
			$data=array();

			$this->request->data['ScheduleCalendar']['appointment_type']=$apty;
			
			$this->request->data['ScheduleCalendar']['title']=$groupData['GroupMember']['group_name'];
			
			$this->request->data['ScheduleCalendar']['description']='Session  - '. $groupData['GroupMember']['group_name'];
			
			$this->request->data['ScheduleCalendar']['trainer_id']=$uid;
				
			$this->request->data['ScheduleCalendar']['session_typeid']=$sessiontypeid;
			
			$this->request->data['ScheduleCalendar']['trainee_id']=$groupid;
			
			$this->request->data['ScheduleCalendar']['start']=$dvstart;
			
			$this->request->data['ScheduleCalendar']['end']=$dvend;
			
			$this->request->data['ScheduleCalendar']['added_date']=date('Y-m-d h:i:s');
			
			$this->request->data['ScheduleCalendar']['modification_date']=date('Y-m-d h:i:s');
			
			$this->request->data['ScheduleCalendar']['status']='1';
						
			$this->request->data['ScheduleCalendar']['session_type']= $SessionTypeVal;
			
			$this->request->data['ScheduleCalendar']['posted_by']= 'Group';
												
			if($this->ScheduleCalendar->save($this->data['ScheduleCalendar'])) 
			{			
				$setTrainerArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$uid)));
								
				$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.status'=>1),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status','ScheduleCalendar.mapwrkt')));
				
				$data=array();			
				
				if(!empty($scheduleCalendars))
				{
					foreach ($scheduleCalendars as $key=>$val)
					{
						$clsname='red';
						if($val['ScheduleCalendar']['appointment_type']!='')
						{
							if($val['ScheduleCalendar']['appointment_type']=='Booked' && $val['ScheduleCalendar']['mapwrkt']==1)
							{
								$clsname='green';
							}
							if($val['ScheduleCalendar']['appointment_type']=='Booked' && $val['ScheduleCalendar']['mapwrkt']==0)
							{
								$clsname='red';
							}
							if($val['ScheduleCalendar']['appointment_type']=='Completed')
							{
								//$clsname='blue';
								$clsname='gray';
							}
							if($val['ScheduleCalendar']['appointment_type']=='Cancel')
							{
								//$clsname='red';
								$clsname='gray';
							}
							if($val['ScheduleCalendar']['appointment_type']=='Comp')
							{
								//$clsname='orange';
								$clsname='gray';
							}
							if($val['ScheduleCalendar']['appointment_type']=='Cancel NC')
							{
								//$clsname='red';
								$clsname='gray';
							}		
							if($val['ScheduleCalendar']['appointment_type']=='Cancel Charge')
							{
								//$clsname='red';
								$clsname='gray';
							}
						}
						$data[] = array(
						
						'id'=>$val['ScheduleCalendar']['id'],

						'title'=>$val['ScheduleCalendar']['title'],

						'start'=>$val['ScheduleCalendar']['start'],

						'end'=>$val['ScheduleCalendar']['end'],

						'className'=>$clsname			
						);
					}
				}					

				$bokedSessionn = $bokedSession + 1; 
				
				$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Session has been booked successfully.","caldata"=>$data);

				$this->set('scheduleCalendars',$data);
			}
			else 
			{
				$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");
			}
				
				
		}
		else 
		{
			$this->set("response","Please fill valid data!!");

			$response = array("responseclassName"=>"nFailure","errorMsg"=>"Please select valid data!!");
		}
		echo json_encode($response);

		exit;
	}
	
	public function exercise_history_group($clientid=null,$rangeA=null,$rangeB=null)
	{
		$this->checkUserLogin();

		$this->layout = "homelayout";		

		$this->set("leftcheck",'exercise_history');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');
				
		if($rangeA!='' && $rangeB=='')
		{
		  	$this->set("selectedslt",$rangeA);
		}
		if($rangeA!='')
		{	
		  	$this->set("selectedslt",$rangeA);
		}
		
		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));		

		$this->set("workoutcategory",$this->WorkoutCategory->find('all',array('conditions'=>array('WorkoutCategory.trainerId'=>$uid),'fields'=>array('WorkoutCategory.id','WorkoutCategory.name'))));		

		$this->set("setSpecalistArr",$setSpecalistArr);
		
		$club_trai_id = $setSpecalistArr['Trainer']['club_id'];
		
		$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
		
		$this->set("setSpecalistArr1",$setSpecalistArr1);
		
		$this->set("groupname",$this->Group->find('list',array('conditions'=>array('Group.trainer_id'=>$uid,'Group.status'=>1),'order'=>array('Group.group_name ASC'),'fields'=>array('Group.id','Group.group_name'))));
		
		$this->set("clientid",$clientid);
	}
	
	public function viewclientdetailsonpop()
	{	
		$groupid = trim($_POST['groupid']);
		$groupname = trim($_POST['groupname']);		
		$sdate = trim ($_POST['sdate']);
		$edate = trim ($_POST['edate']);		
		$sessiontypeid = trim($_POST['sessiontypeid']);
		$sessiontype = trim($_POST['sessiontype']);		
		$clientname = trim($_POST['clientname']);
		$clientid = trim($_POST['clientid']);	
		$scid = trim($_POST['scid']);
		$mapwrkt = trim($_POST['mapwrkt']);		
		
		$this->layout = "ajax";

		$dbusertype = $this->Session->read('UTYPE');	
		
		$this->set("dbusertype",$dbusertype);
		
		$this->set("sessiontype",$sessiontype);
		
		$this->set("sdate",$sdate);
		
		$this->set("edate",$edate);
		
	
		$sdatevadt = date('Y-m-d H:i:s', strtotime($sdate));	
	
		$edatevadt = date('Y-m-d H:i:s', strtotime($edate));
		
		$this->set("scid",$scid);
		
		$this->set("mapwrkt",$mapwrkt);
		
		$this->set("groupid",$groupid);
		
		$uid = $this->Session->read('USER_ID');	
		
		$groupmemDataAll=$this->GroupMember->find('first',array("conditions"=>array('GroupMember.group_id'=>$groupid,'GroupMember.client_id'=>$clientid,'GroupMember.trainer_id'=>$uid),'fields'=>array('GroupMember.client_id','GroupMember.client_name','GroupMember.trainer_id','GroupMember.group_id')));
			
		$this->set("groupmemDataAll",$groupmemDataAll);
				
		$sessionPurchase=$this->SessionPurchase->find('first',array("conditions"=>array('SessionPurchase.client_id'=>$groupmemDataAll['GroupMember']['client_id'],'SessionPurchase.trainer_id'=>$groupmemDataAll['GroupMember']['trainer_id'],'SessionPurchase.session_id'=>$sessiontypeid)));
					
		$this->set('sessionPurchase',$sessionPurchase);		
		
		$setGroupClientStatusArr=$this->GroupClientStat->find("first",array("conditions"=>array("GroupClientStat.client_id"=>$clientid,"GroupClientStat.trainer_id"=>$uid,"GroupClientStat.gid"=>$groupid,"GroupClientStat.start"=>$sdatevadt,"GroupClientStat.end"=>$edatevadt)));
		 
		$this->set("setGroupClientStatusArr",$setGroupClientStatusArr);
		
		$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));
		
		$this->set("setClientArr",$setClientArr);
				
		$popupschedetail = $this->ScdetailPopup->find('first', array('conditions'=>array('ScdetailPopup.trainer_id'=>$groupmemDataAll['GroupMember']['trainer_id'],'ScdetailPopup.trainee_id'=>$groupmemDataAll['GroupMember']['client_id'],'ScdetailPopup.session_id'=>$sessiontypeid)));
		
		$this->set("popupschedetail",$popupschedetail);
		
		
		/* CHECK FOR DATA EXIST FOR INDIVIDUAL CLIENTS*/
		$setGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.trainer_id"=>$uid,'Goal.start'=>$sdatevadt,'Goal.end'=>$edatevadt)));	

		$this->set('setGoalArr',$setGoalArr);
		
		//echo "<pre>";print_r($setGoalArr);echo"</pre>";
		
		$setWarmupArr=$this->WarmUps->find("first",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$sdatevadt,'WarmUps.end'=>$edatevadt)));	

		$this->set('setWarmupArr',$setWarmupArr);	
		
		//echo "<pre>";print_r($setWarmupArr);echo"</pre>";

		$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("first",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$sdatevadt,'CoreBalancePlyometric.end'=>$edatevadt)));	

		$this->set('setCoreBalancePlyometricArr',$setCoreBalancePlyometricArr);
	
		//echo "<pre>";print_r($setCoreBalancePlyometricArr);echo"</pre>";
		
		$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("first",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$sdatevadt,'SpeedAgilityQuickness.end'=>$edatevadt)));	

		$this->set('setSpeedAgilityQuicknessArr',$setSpeedAgilityQuicknessArr);

		//echo "<pre>";print_r($setSpeedAgilityQuicknessArr);echo"</pre>";
			
		$setResistenceArr=$this->Resistence->find("first",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$sdatevadt,'Resistence.end'=>$edatevadt)));

		$this->set('setResistenceArr',$setResistenceArr);
		
		//echo "<pre>";print_r($setResistenceArr);echo"</pre>";
				
		$setCoolDownArr=$this->CoolDown->find("first",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$sdatevadt,'CoolDown.end'=>$edatevadt)));	

		$this->set('setCoolDownArr',$setCoolDownArr);
		
		//echo "<pre>";print_r($setCoolDownArr);echo"</pre>";
		
		/* CHECK FOR DATA EXIST FOR INDIVIDUAL CLIENTS*/
			
		}
	
	public function markcompletedgroupclient()
	{
		$gid = trim($_POST['gid']);
		$clid = trim($_POST['clid']);
		$tid = trim($_POST['tid']);				
		$sesid = trim($_POST['sesid']);
		$sessiontype = trim($_POST['sessiontype']);
		$stypeid = trim($_POST['stypeid']);
		$sdate = trim($_POST['sdate']);	
		$edate = trim($_POST['edate']);	

		$sdatevadt = date('Y-m-d H:i:s', strtotime($sdate));	
	
		$edatevadt = date('Y-m-d H:i:s', strtotime($edate));		
			
		$this->layout = "ajax";

		$this->autoRender=false;

		$stypeid=trim($_POST['stypeid']);

		$datav=array();				

		$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clid)));
		 
		$setTrainerArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$tid)));			 
		 
		//echo "<pre>"; print_r($setTrainerArr); echo "</pre>"; 
		 
		//echo "<pre>"; print_r($setClientArr); echo "</pre>"; 
	
		$setSchdetalpopArr=$this->ScdetailPopup->find("first",array("conditions"=>array("ScdetailPopup.trainee_id"=>$clid,"ScdetailPopup.trainer_id"=>$tid,"ScdetailPopup.session_id"=>$stypeid)));
		 
		$this->set("setSchdetalpopArr",$setSchdetalpopArr);
		
		//echo "<pre>"; print_r($setSchdetalpopArr); echo "</pre>"; 
		 
		$setSessionArr=$this->SessionPurchase->find("first",array("conditions"=>array("SessionPurchase.client_id"=>$clid,"SessionPurchase.trainer_id"=>$tid,"SessionPurchase.id"=>$sesid,"SessionPurchase.session_id"=>$stypeid)));
		
		//echo "<pre>"; print_r($setSessionArr); echo "</pre>"; die();
			
		$bokedSession = $setClientArr['Trainee']['booked_ses'];
		
		$sessbokedSession = $setSessionArr['SessionPurchase']['no_of_booked'];

		$a = 1;

		$workoutarr=$this->WorkOuts->find("first",array("conditions"=>array("WorkOuts.id"=>$stypeid,"WorkOuts.trainer_id"=>$tid)));		
		
		$setGroupClientStatusArr=$this->GroupClientStat->find("first",array("conditions"=>array("GroupClientStat.client_id"=>$clid,"GroupClientStat.trainer_id"=>$tid,"GroupClientStat.gid"=>$gid,"GroupClientStat.start"=>$sdate,"GroupClientStat.end"=>$edate)));
		 
		$this->set("setGroupClientStatusArr",$setGroupClientStatusArr);
		
		//echo "<pre>"; print_r($setGroupClientStatusArr); echo "</pre>"; die();
		
		if($a==1) 
		{		
			$bokedSessionn = $bokedSession + 1; 
			$sessbokedSession = $sessbokedSession + 1; 

			$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Your availability has been Marked Completed successfully.");

			$this->Trainee->query("update trainees set booked_ses = '".$bokedSessionn."' where id='".$clid."'");
			
			$this->SessionPurchase->query("update session_purchases set no_of_booked = '".$sessbokedSession."' where id='".$sesid."'");
			
			if(($setGroupClientStatusArr['GroupClientStat']['client_id']=='') && ($setGroupClientStatusArr['GroupClientStat']['trainer_id']=='') && ($setGroupClientStatusArr['GroupClientStat']['gid']=='') && ($setGroupClientStatusArr['GroupClientStat']['session_status']=='') && ($setGroupClientStatusArr['GroupClientStat']['start']=='') && ($setGroupClientStatusArr['GroupClientStat']['end']==''))
			{					
				$this->GroupClientStat->query("insert group_client_stats set gid = '".$gid."',trainer_id = '".$tid."',client_id = '".$clid."', session_status = 'Completed', start = '".$sdate."', end = '".$edate."'");
				
			}
			else if (($setGroupClientStatusArr['GroupClientStat']['client_id']==$clid) && ($setGroupClientStatusArr['GroupClientStat']['trainer_id']==$tid) && ($setGroupClientStatusArr['GroupClientStat']['gid']==$gid) && ($setGroupClientStatusArr['GroupClientStat']['start']==$sdatevadt) && ($setGroupClientStatusArr['GroupClientStat']['end']==$edatevadt))
			{									
				$this->GroupClientStat->query("update group_client_stats set session_status='Completed' where client_id='".$clid."' AND trainer_id='".$tid."' AND gid='".$gid."' AND start = '".$sdate."' AND end = '".$edate."'");
			}
			
			if(($setSchdetalpopArr['ScdetailPopup']['trainee_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['session_id']==''))
			{
				$this->ScdetailPopup->query("insert scdetail_popups set trainee_id = '".$clid."',  trainer_id = '".$tid."', session_type = '".$workoutarr['WorkOuts']['workout_name']."', session_id = '".$stypeid."', completed = '1'");
				
			}
			else if (($setSchdetalpopArr['ScdetailPopup']['trainee_id']==$clid) && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']==$tid) && ($setSchdetalpopArr['ScdetailPopup']['session_id']==$stypeid))
			{
				$increase_comp = $setSchdetalpopArr['ScdetailPopup']['completed'] + 1;								
				$this->ScdetailPopup->query("update scdetail_popups set completed='".$increase_comp."' where trainee_id='".$clid."' AND trainer_id='".$tid."' AND session_id='".$stypeid."'");
			}

			if ($setClientArr['Trainee']['comp_session_notification']==1)
			{				
				$this->send_session_complete($setTrainerArr['Trainer']['email'],$setClientArr['Trainee']['email'],$setClientArr['Trainee']['first_name'],$setClientArr['Trainee']['last_name'],$setTrainerArr['Trainer']['first_name'],$setTrainerArr['Trainer']['last_name'],$setTrainerArr['Trainer']['phone'],$setTrainerArr['Trainer']['website_logo'],$sdatevadt);	
			}
		}

		else 
		{
			$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");
		}
		echo json_encode($response);

		exit;
	}
	
	public function markcompgroup()
	{
		$gid = trim($_POST['gid']);
		$clid = trim($_POST['clid']);
		$tid = trim($_POST['tid']);			
		$sesid = trim($_POST['sesid']);
		$sessiontype = trim($_POST['sessiontype']);
		$stypeid = trim($_POST['stypeid']);	
		$sdate = trim($_POST['sdate']);	
		$edate = trim($_POST['edate']);	

		$sdatevadt = date('Y-m-d H:i:s', strtotime($sdate));	
	
		$edatevadt = date('Y-m-d H:i:s', strtotime($edate));
		
		$this->layout = "ajax";

		$this->autoRender=false;

		$datav=array();				
		
		$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clid)));
		 
		 $setTrainerArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$tid)));			 
		 		 
		 $setSchdetalpopArr=$this->ScdetailPopup->find("first",array("conditions"=>array("ScdetailPopup.trainee_id"=>$clid,"ScdetailPopup.trainer_id"=>$tid,"ScdetailPopup.session_id"=>$stypeid)));
		 
		$this->set("setSchdetalpopArr",$setSchdetalpopArr);
		
		//echo "<pre>"; print_r($setSchdetalpopArr); echo "</pre>";  die;
		
		$workoutarr=$this->WorkOuts->find("first",array("conditions"=>array("WorkOuts.id"=>$stypeid,"WorkOuts.trainer_id"=>$tid)));
		
		$setGroupClientStatusArr=$this->GroupClientStat->find("first",array("conditions"=>array("GroupClientStat.client_id"=>$clid,"GroupClientStat.trainer_id"=>$tid,"GroupClientStat.gid"=>$gid,"GroupClientStat.start"=>$sdate,"GroupClientStat.end"=>$edate)));
		 
		$this->set("setGroupClientStatusArr",$setGroupClientStatusArr);
		
		$a = 1;
				
		if($a==1) {
		
			if(($setGroupClientStatusArr['GroupClientStat']['client_id']=='') && ($setGroupClientStatusArr['GroupClientStat']['trainer_id']=='') && ($setGroupClientStatusArr['GroupClientStat']['gid']=='') && ($setGroupClientStatusArr['GroupClientStat']['session_status']=='') && ($setGroupClientStatusArr['GroupClientStat']['start']=='') && ($setGroupClientStatusArr['GroupClientStat']['end']==''))
			{					
				$this->GroupClientStat->query("insert group_client_stats set gid = '".$gid."',trainer_id = '".$tid."',client_id = '".$clid."', session_status = 'Comp', start = '".$sdate."', end = '".$edate."'");
				
			}
			else if (($setGroupClientStatusArr['GroupClientStat']['client_id']==$clid) && ($setGroupClientStatusArr['GroupClientStat']['trainer_id']==$tid) && ($setGroupClientStatusArr['GroupClientStat']['gid']==$gid) && ($setGroupClientStatusArr['GroupClientStat']['start']==$sdatevadt) && ($setGroupClientStatusArr['GroupClientStat']['end']==$edatevadt))
			{									
				$this->GroupClientStat->query("update group_client_stats set session_status='Comp' where client_id='".$clid."' AND trainer_id='".$tid."' AND gid='".$gid."' AND start = '".$sdate."' AND end = '".$edate."'");
			}
		
			$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Your availability has been Marked Comp successfully.");			
			
			if(($setSchdetalpopArr['ScdetailPopup']['trainee_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['session_id']==''))
			{
				$this->ScdetailPopup->query("insert scdetail_popups set trainee_id = '".$clid."',  trainer_id = '".$tid."', session_type = '".$workoutarr['WorkOuts']['workout_name']."', session_id = '".$stypeid."', complimentary = '1'");
				
			}
			else if (($setSchdetalpopArr['ScdetailPopup']['trainee_id']==$clid) && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']==$tid) && ($setSchdetalpopArr['ScdetailPopup']['session_id']==$stypeid))
			{
				$increase_compl = $setSchdetalpopArr['ScdetailPopup']['complimentary'] + 1;
				
				$this->ScdetailPopup->query("update scdetail_popups set complimentary='".$increase_compl."' where trainee_id='".$clid."' AND trainer_id='".$tid."' AND session_id='".$stypeid."'");
			}			
			$this->ScheduleCalendar->query("update schedule_calendar set appointment_type = 'Comp' where trainer_id='".$tid."' AND trainee_id='".$gid."' AND start='".$sdate."' AND end='".$edate."' AND posted_by='Group'");
			
			$this->send_session_complimentary($setTrainerArr['Trainer']['email'],$setClientArr['Trainee']['email'],$setClientArr['Trainee']['first_name'],$setClientArr['Trainee']['last_name'],$setTrainerArr['Trainer']['first_name'],$setTrainerArr['Trainer']['last_name'],$setTrainerArr['Trainer']['phone'],$setTrainerArr['Trainer']['website_logo'],$sdatevadt);

		}
		else {
		$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");
		}
		echo json_encode($response);

		exit;
	}
	
	public function markcancelgroup()
	{
		$gid = trim($_POST['gid']);
		$clid = trim($_POST['clid']);
		$tid = trim($_POST['tid']);			
		$sesid = trim($_POST['sesid']);
		$sessiontype = trim($_POST['sessiontype']);
		$stypeid = trim($_POST['stypeid']);	
		$sdate = trim($_POST['sdate']);	
		$edate = trim($_POST['edate']);	

		$sdatevadt = date('Y-m-d H:i:s', strtotime($sdate));	
	
		$edatevadt = date('Y-m-d H:i:s', strtotime($edate));

		$this->layout = "";

		$this->autoRender=false;

		$datav=array();				

		$setTraineeArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clid)));
		
		$setTrainerArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$tid)));
	  
		$setSchdetalpopArr=$this->ScdetailPopup->find("first",array("conditions"=>array("ScdetailPopup.trainee_id"=>$clid,"ScdetailPopup.trainer_id"=>$tid,"ScdetailPopup.session_id"=>$stypeid)));
		 
		$this->set("setSchdetalpopArr",$setSchdetalpopArr);

		//echo "<pre>";print_r($setSchdetalpopArr);echo"</pre>"; die;

		$workoutarr=$this->WorkOuts->find("first",array("conditions"=>array("WorkOuts.id"=>$stypeid,"WorkOuts.trainer_id"=>$tid)));
		
		$setGroupClientStatusArr=$this->GroupClientStat->find("first",array("conditions"=>array("GroupClientStat.client_id"=>$clid,"GroupClientStat.trainer_id"=>$tid,"GroupClientStat.gid"=>$gid,"GroupClientStat.start"=>$sdate,"GroupClientStat.end"=>$edate)));
		 
		$this->set("setGroupClientStatusArr",$setGroupClientStatusArr);
		
		$a = 1;
				
		if($a==1) 
		{
			if(($setGroupClientStatusArr['GroupClientStat']['client_id']=='') && ($setGroupClientStatusArr['GroupClientStat']['trainer_id']=='') && ($setGroupClientStatusArr['GroupClientStat']['gid']=='') && ($setGroupClientStatusArr['GroupClientStat']['session_status']=='') && ($setGroupClientStatusArr['GroupClientStat']['start']=='') && ($setGroupClientStatusArr['GroupClientStat']['end']==''))
			{					
				$this->GroupClientStat->query("insert group_client_stats set gid = '".$gid."',trainer_id = '".$tid."',client_id = '".$clid."', session_status = 'Cancel NC', start = '".$sdate."', end = '".$edate."'");
				
			}
			else if (($setGroupClientStatusArr['GroupClientStat']['client_id']==$clid) && ($setGroupClientStatusArr['GroupClientStat']['trainer_id']==$tid) && ($setGroupClientStatusArr['GroupClientStat']['gid']==$gid) && ($setGroupClientStatusArr['GroupClientStat']['start']==$sdatevadt) && ($setGroupClientStatusArr['GroupClientStat']['end']==$edatevadt))
			{									
				$this->GroupClientStat->query("update group_client_stats set session_status='Cancel NC' where client_id='".$clid."' AND trainer_id='".$tid."' AND gid='".$gid."' AND start = '".$sdate."' AND end = '".$edate."'");
			}
			
			$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Your availability has been Marked Cancel NC successfully.");
			
			if(($setSchdetalpopArr['ScdetailPopup']['trainee_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['session_id']==''))
			{
				$this->ScdetailPopup->query("insert scdetail_popups set trainee_id = '".$clid."',  trainer_id = '".$tid."', session_type = '".$workoutarr['WorkOuts']['workout_name']."', session_id = '".$stypeid."', cancel_no_charge = '1'");
				
			}
			else if (($setSchdetalpopArr['ScdetailPopup']['trainee_id']==$clid) && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']==$tid) && ($setSchdetalpopArr['ScdetailPopup']['session_id']==$stypeid))
			{
				$increase_cancel_no_charge = $setSchdetalpopArr['ScdetailPopup']['cancel_no_charge'] + 1;	
				
				$this->ScdetailPopup->query("update scdetail_popups set cancel_no_charge='".$increase_cancel_no_charge."' where trainee_id='".$clid."' AND trainer_id='".$tid."' AND session_id='".$stypeid."'");
			}
			
			$this->ScheduleCalendar->query("update schedule_calendar set appointment_type = 'Cancel NC' where trainer_id='".$tid."' AND trainee_id='".$gid."' AND start='".$sdate."' AND end='".$edate."' AND posted_by='Group'");
			
			$this->send_session_cancel_no_charge($setTrainerArr['Trainer']['email'],$setTraineeArr['Trainee']['email'],$setTraineeArr['Trainee']['first_name'],$setTraineeArr['Trainee']['last_name'],$setTrainerArr['Trainer']['first_name'],$setTrainerArr['Trainer']['last_name'],$setTrainerArr['Trainer']['phone'],$setTrainerArr['Trainer']['website_logo'],$sdatevadt);
		}
		else {
			$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");
		}
		echo json_encode($response);
		exit;
		}
	
	public function markcancel_charged_group()
	{
		$gid = trim($_POST['gid']);
		$clid = trim($_POST['clid']);
		$tid = trim($_POST['tid']);		
		$sesid = trim($_POST['sesid']);
		$sessiontype = trim($_POST['sessiontype']);
		$stypeid = trim($_POST['stypeid']);
		$sdate = trim($_POST['sdate']);	
		$edate = trim($_POST['edate']);	

		$sdatevadt = date('Y-m-d H:i:s', strtotime($sdate));	
	
		$edatevadt = date('Y-m-d H:i:s', strtotime($edate));

		$this->layout = "ajax";

		$this->autoRender=false;

		$datav=array();		

		$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clid)));
		
		$setTrainerArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$tid)));
		
		$sessionPurchase=$this->SessionPurchase->find('first',array("conditions"=>array('SessionPurchase.client_id'=>$clid,'SessionPurchase.trainer_id'=>$tid,'SessionPurchase.id'=>$sesid,'SessionPurchase.session_id'=>$stypeid)));
		
		$this->set('sessionPurchase',$sessionPurchase);
		
		//echo "<pre>";print_r($sessionPurchase);echo"</pre>";
		
		$setSchdetalpopArr=$this->ScdetailPopup->find("first",array("conditions"=>array("ScdetailPopup.trainee_id"=>$clid,"ScdetailPopup.trainer_id"=>$tid,"ScdetailPopup.session_id"=>$stypeid)));
		 
		$this->set("setSchdetalpopArr",$setSchdetalpopArr);
					
		$bokedSession = $setClientArr['Trainee']['booked_ses'];

		$sessbokedSession = $sessionPurchase['SessionPurchase']['no_of_booked'];
		
		//echo "<pre>";print_r($setSchdetalpopArr);echo"</pre>"; die;
										

		$workoutarr=$this->WorkOuts->find("first",array("conditions"=>array("WorkOuts.id"=>$stypeid,"WorkOuts.trainer_id"=>$tid)));
		
		$setGroupClientStatusArr=$this->GroupClientStat->find("first",array("conditions"=>array("GroupClientStat.client_id"=>$clid,"GroupClientStat.trainer_id"=>$tid,"GroupClientStat.gid"=>$gid,"GroupClientStat.start"=>$sdate,"GroupClientStat.end"=>$edate)));
		 
		$this->set("setGroupClientStatusArr",$setGroupClientStatusArr);
		
		$a = 1;
				
		if($a==1) 
		{
			$bokedSessionn = $bokedSession + 1; 
			
			$sessbokedSession = $sessbokedSession + 1; 

			$this->Trainee->query("update trainees set booked_ses = '".$bokedSessionn."' where id='".$clid."'");
			
			$this->SessionPurchase->query("update session_purchases set no_of_booked = '".$sessbokedSession."' where id='".$sesid."'");
			
			if(($setGroupClientStatusArr['GroupClientStat']['client_id']=='') && ($setGroupClientStatusArr['GroupClientStat']['trainer_id']=='') && ($setGroupClientStatusArr['GroupClientStat']['gid']=='') && ($setGroupClientStatusArr['GroupClientStat']['session_status']=='') && ($setGroupClientStatusArr['GroupClientStat']['start']=='') && ($setGroupClientStatusArr['GroupClientStat']['end']==''))
			{					
				$this->GroupClientStat->query("insert group_client_stats set gid = '".$gid."',trainer_id = '".$tid."',client_id = '".$clid."', session_status = 'Cancel Charge', start = '".$sdate."', end = '".$edate."'");
				
			}
			else if (($setGroupClientStatusArr['GroupClientStat']['client_id']==$clid) && ($setGroupClientStatusArr['GroupClientStat']['trainer_id']==$tid) && ($setGroupClientStatusArr['GroupClientStat']['gid']==$gid) && ($setGroupClientStatusArr['GroupClientStat']['start']==$sdatevadt) && ($setGroupClientStatusArr['GroupClientStat']['end']==$edatevadt))
			{									
				$this->GroupClientStat->query("update group_client_stats set session_status='Cancel Charge' where client_id='".$clid."' AND trainer_id='".$tid."' AND gid='".$gid."' AND start = '".$sdate."' AND end = '".$edate."'");
			}
			

			$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Your availability has been Marked Cancel Charge successfully.");
			
			if(($setSchdetalpopArr['ScdetailPopup']['trainee_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']=='') && ($setSchdetalpopArr['ScdetailPopup']['session_id']==''))
			{
				$this->ScdetailPopup->query("insert scdetail_popups set trainee_id = '".$clid."',  trainer_id = '".$tid."', session_type = '".$workoutarr['WorkOuts']['workout_name']."', session_id = '".$stypeid."', cancel = '1'");
				
			}
			else if (($setSchdetalpopArr['ScdetailPopup']['trainee_id']==$clid) && ($setSchdetalpopArr['ScdetailPopup']['trainer_id']==$tid) && ($setSchdetalpopArr['ScdetailPopup']['session_id']==$stypeid))
			{
				$increase_cancel = $setSchdetalpopArr['ScdetailPopup']['cancel'] + 1;
				
				$this->ScdetailPopup->query("update scdetail_popups set cancel='".$increase_cancel."' where trainee_id='".$clid."' AND trainer_id='".$tid."' AND session_id='".$stypeid."'");
			}
			
			$this->ScheduleCalendar->query("update schedule_calendar set appointment_type = 'Cancel' where trainer_id='".$tid."' AND trainee_id='".$gid."' AND start='".$sdate."' AND end='".$edate."' AND posted_by='Group'");
			
			$this->send_session_cancel_charge($setTrainerArr['Trainer']['email'],$setClientArr['Trainee']['email'],$setClientArr['Trainee']['first_name'],$setClientArr['Trainee']['last_name'],$setTrainerArr['Trainer']['first_name'],$setTrainerArr['Trainer']['last_name'],$setTrainerArr['Trainer']['phone'],$setTrainerArr['Trainer']['website_logo'],$sdatevadt);

		}
		else 
		{
			$response = array("responseclassName"=>"nFailure","errorMsg"=>"Some issue occur, please try again!!");
		}

		echo json_encode($response);

		exit;
	}
	
	
	public function exercise_history_build_group($groupid=null,$rangeA=null,$rangeB=null)
	{		
		$this->checkUserLogin();

		$this->layout = "homelayout";		

		$this->set("leftcheck",'exercise_history');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');
		
		if($rangeA!='' && $rangeB=='')
		{
		  	$this->set("selectedslt",$rangeA);
		}
		
		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
		
		//echo "<pre>"; print_r($setSpecalistArr); echo "</pre>";
			
		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));		

		$this->set("workoutcategory",$this->WorkoutCategory->find('all',array('conditions'=>array('WorkoutCategory.trainerId'=>$uid),'fields'=>array('WorkoutCategory.id','WorkoutCategory.name'))));
			
		$this->set("setSpecalistArr",$setSpecalistArr);

		$tgvs=0;

		$showoff=1;

		if($groupid!='')
		{
			$this->set("groupid",$groupid);

			$dateN=date('Y-m-d');

			$dateN2=date('Y-m-d',strtotime("-31 days"));

			$setGroupArr=$this->Group->find("first",array("conditions"=>array("Group.id"=>$groupid)));
			
			$this->set('setGroupArr',$setGroupArr);
			
			//echo "<pre>"; print_r($setGroupArr); echo "</pre>";
			
			$setGroupGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.groupid"=>$groupid),'order' => array('Goal.id' => 'DESC')));

			$this->set('clientGoal',$setClientGoalArr);

			
			/*$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0', 'ScheduleCalendar.status <>'=>'0','ScheduleCalendar.start >'=>date('Y-m-d H:i:s')),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status'),'limit'=>5));*/
			
			$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$groupid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0', 'ScheduleCalendar.posted_by'=>'Group','ScheduleCalendar.status <>'=>'0'),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));

			$this->set('scheduleCalendars',$scheduleCalendars);

			$dt1 = date('Y-m-d h:i:s', strtotime($rangeA));

			$dt2 = date('Y-m-d h:i:s', strtotime($rangeB));
			
			//echo "<pre>"; print_r($scheduleCalendars); echo "</pre>"; die;

			$setClientGoalArr3=array();
			
			if (!empty($dt1) && $dt1!='1970-01-01 01:00:00' && (!empty($dt2) && $dt2!='1970-01-01 01:00:00')) 
			{
				 $this->set("rangeA",date('m/d/Y', strtotime($rangeA)));

				 $this->set("rangeB",date('m/d/Y', strtotime($rangeB)));

				 $setClientGoalArrco=$this->Goal->find("count",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.status"=>1,'Goal.start between ? and ?' => array($dt1, $dt2)),'order' => array('Goal.start' => 'DESC')));
				 				 
				 $this->Paginator->settings = array('conditions' => array("Goal.trainee_id"=>$clientid,"Goal.status"=>1,'Goal.start between ? and ?' => array($dt1, $dt2)),'order'=>array('Goal.start' => 'ASC'), 'limit' => 5);
				 
				 $setClientGoalArr3 = $this->Paginator->paginate('Goal');
			}
			else 
			{
				$setClientGoalArrco=$this->Goal->find("count",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.status"=>1),'order' => array('Goal.start' => 'DESC')));
				
				$this->Paginator->settings = array('conditions' => array("Goal.trainee_id"=>$clientid,"Goal.status"=>1),'order'=>array('Goal.start' => 'ASC'),'limit' => 5);

				$setClientGoalArr3 = $this->Paginator->paginate('Goal');
			}
			
			$totalGl=count($setClientGoalArr3);

			$jtms='';

			$cnt=1;

			$cn=1;

			if($totalGl>0)
			{
				$showoff=0;
			}
			if($showoff==0)
			{
				$this->set("rst",$jtms);

				$this->set("showoff",$showoff);
			}
			else
			{
				$this->set("rst",'');

				$this->set("showoff",$showoff);
			}
		}
		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	

		$surl=$this->config['url'].'home/exercise_history/'.$clientid;

		$this->set("surl",$surl);

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

		$this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$uid,'Trainee.status'=>1,'Trainee.trainer_setstatus'=>1),'order'=>array('Trainee.full_name ASC'),'fields'=>array('Trainee.id','Trainee.full_name'))));

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);
	}
	
	public function add_exercise_history_group()
	{
		$this->layout = '';

		$this->render = false;

		$id = $this->Session->read('USER_ID');

		$response=array();

		$exe1Count = count($_POST['nplayexercise']); 

		$exerciseCount1 = count($_POST['nplay1exercise']);

		$exerciseCount2 = count($_POST['nplay2exercise']);

		$exerciseCount3 = count($_POST['nplay3exercise']);

		$exerciseCount4 = count($_POST['nplay4exercise']);

		$ScheduleCalendarid=trim($_POST['sessType']);		

		$checkCalArr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.id"=>$ScheduleCalendarid)));

		$startDate=$checkCalArr['ScheduleCalendar']['start'];

		$endDate=$checkCalArr['ScheduleCalendar']['end'];		
		
		$goalArr=array();

		$goalArr['Goal']['goal']=trim($_POST['goal']);

		$goalArr['Goal']['phase']=trim($_POST['phase']);

		$goalArr['Goal']['note']=trim($_POST['note']);

		$goalArr['Goal']['alert']=trim($_POST['alert']);

		$goalArr['Goal']['trainer_id']=trim($_POST['trainer_id']);

		$goalArr['Goal']['groupid']=trim($_POST['groupid']);

		$goalArr['Goal']['added_date']=date('Y-m-d H:i:s');

		$goalArr['Goal']['modified_date']=date('Y-m-d H:i:s');

		$goalArr['Goal']['start']=$startDate;

		$goalArr['Goal']['end']=$endDate;
				
		$checkCalArr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.trainer_id"=>$_POST['trainer_id'],'ScheduleCalendar.trainee_id'=>$groupid,'ScheduleCalendar.posted_by'=>'Group','ScheduleCalendar.start'=>$startDate)));

		$this->ScheduleCalendar->id=$ScheduleCalendarid;
		
		$data=array();

		$this->request->data['ScheduleCalendar']['mapwrkt']=1;

		$this->ScheduleCalendar->save($this->data['ScheduleCalendar']);

		$this->Goal->save($goalArr);
		
		for($i=0;$i<$exe1Count;$i++)
		{
			$exercisedata['WarmUps']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata['WarmUps']['groupid']=trim($_POST['groupid']);

			$exercisedata['WarmUps']['exercise']=trim($_POST['nplayexercise'][$i]);

			$exercisedata['WarmUps']['set']=trim($_POST['nplayset'][$i]);

			$exercisedata['WarmUps']['duration']=trim($_POST['nplayduration'][$i]);

			$exercisedata['WarmUps']['coaching_tip']=trim($_POST['nplaycoaching_tip'][$i]);
			//$exercisedata['WarmUps']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

			$exercisedata['WarmUps']['added_date']=date('Y-m-d H:i:s');

			$exercisedata['WarmUps']['start']=$startDate;

			$exercisedata['WarmUps']['end']=$endDate;
			
			if($exercisedata['WarmUps']['exercise']!='') 
			{
				$this->WarmUps->saveAll($exercisedata);
			}
		}
		
		for($i=0;$i<$exerciseCount1;$i++)
		{
		
			$exercisedata1['CoreBalancePlyometric']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata1['CoreBalancePlyometric']['groupid']=trim($_POST['groupid']);

			$exercisedata1['CoreBalancePlyometric']['exercise']=trim($_POST['nplay1exercise'][$i]);

			$exercisedata1['CoreBalancePlyometric']['set']=trim($_POST['nplay1set'][$i]);

			$exercisedata1['CoreBalancePlyometric']['rep']=trim($_POST['nplay1rep'][$i]);

			$exercisedata1['CoreBalancePlyometric']['rest']=trim($_POST['nplay1rest'][$i]);

			$exercisedata1['CoreBalancePlyometric']['temp']=trim($_POST['nplay1temp'][$i]);

			$exercisedata1['CoreBalancePlyometric']['coaching_tip']=trim($_POST['nplay1coaching_tip'][$i]);

			//$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

			$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d h:i:s');

			$exercisedata1['CoreBalancePlyometric']['start']=$startDate;

			$exercisedata1['CoreBalancePlyometric']['end']=$endDate;
			
			if($exercisedata1['CoreBalancePlyometric']['exercise']!='') 
			{
				$this->CoreBalancePlyometric->saveAll($exercisedata1);
			}
		}
		
		for($i=0;$i<$exerciseCount2;$i++)
		{
			$exercisedata2['SpeedAgilityQuickness']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata2['SpeedAgilityQuickness']['groupid']=trim($_POST['groupid']);

			$exercisedata2['SpeedAgilityQuickness']['exercise']=trim($_POST['nplay2exercise'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['set']=trim($_POST['nplay2set'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['rep']=trim($_POST['nplay2rep'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['rest']=trim($_POST['nplay2rest'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['temp']=trim($_POST['nplay2temp'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['coaching_tip']=trim($_POST['nplay2coaching_tip'][$i]);

			//$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

			$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d H:i:s');

			$exercisedata2['SpeedAgilityQuickness']['start']=$startDate;

			$exercisedata2['SpeedAgilityQuickness']['end']=$endDate;
			
			if($exercisedata2['SpeedAgilityQuickness']['exercise']!='') 
			{
				$this->SpeedAgilityQuickness->saveAll($exercisedata2);
			}
		}
		
		for($i=0;$i<$exerciseCount3;$i++)
		{
			$exercisedata3['Resistence']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata3['Resistence']['groupid']=trim($_POST['groupid']);

			$exercisedata3['Resistence']['exercise']=trim($_POST['nplay3exercise'][$i]);

			$exercisedata3['Resistence']['set']=trim($_POST['nplay3set'][$i]);

			$exercisedata3['Resistence']['rep']=trim($_POST['nplay3rep'][$i]);

			$exercisedata3['Resistence']['rest']=trim($_POST['nplay3rest'][$i]);

			$exercisedata3['Resistence']['temp']=trim($_POST['nplay3temp'][$i]);

			$exercisedata3['Resistence']['coaching_tip']=trim($_POST['nplay3coaching_tip'][$i]);
			//$exercisedata3['Resistence']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

			$exercisedata3['Resistence']['added_date']=date('Y-m-d h:i:s');

			$exercisedata3['Resistence']['start']=$startDate;

			$exercisedata3['Resistence']['end']=$endDate;

			if($exercisedata3['Resistence']['exercise']!='') 
			{
				$this->Resistence->saveAll($exercisedata3);
			}
		}
		for($i=0;$i<$exerciseCount4;$i++)
		{
			$exercisedata4['CoolDown']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata4['CoolDown']['groupid']=trim($_POST['groupid']);

			$exercisedata4['CoolDown']['exercise']=trim($_POST['nplay4exercise'][$i]);

			$exercisedata4['CoolDown']['set']=trim($_POST['nplay4set'][$i]);

			$exercisedata4['CoolDown']['duration']=trim($_POST['nplay4duration'][$i]);

			$exercisedata4['CoolDown']['coaching_tip']=trim($_POST['nplay4coaching_tip'][$i]);

			//$exercisedata4['CoolDown']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

			$exercisedata4['CoolDown']['added_date']=date('Y-m-d h:i:s');

			$exercisedata4['CoolDown']['start']=$startDate;

			$exercisedata4['CoolDown']['end']=$endDate;
			
			if($exercisedata4['CoolDown']['exercise']!='') 
			{
				$this->CoolDown->saveAll($exercisedata4);
			}
		}
		$rddate=date('Y-m-d',strtotime($endDate));
		
		$response = array("responseclassName"=>"nSuccess","errorMsg"=>$rddate);
		
		echo json_encode($response);
		
		exit;		
	}
	
	function edit_exercise_history_group($groupid=null,$stD=null,$msdate=null)
	{
		$this->checkUserLogin();

		$this->layout = "homelayout";		

		$this->set("leftcheck",'exercise_history');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));		

		$this->set("setSpecalistArr",$setSpecalistArr);

		$showoff=1;		

		$this->set("groupid",$groupid);			

		$setGroupArr=$this->Group->find("first",array("conditions"=>array("Group.id"=>$groupid)));				

		$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));

		$strtDt = $schcaldt['ScheduleCalendar']['start'];

		$endDt  = $schcaldt['ScheduleCalendar']['end'];

		$startvaldt = $strtDt;

		$endvaldt = $endDt;
		
		$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.groupid"=>$groupid, "Goal.start"=>$strtDt,"Goal.end"=>$endDt),"Order"=>array("Goal.id"=>"DESC")));				

		$this->set('clientGoal',$setClientGoalArr);
		
		//echo "<pre>"; print_r($setClientGoalArr); echo "</pre>";
		
		$this->set('schcaldt',$schcaldt);

		$this->set('msdate',$msdate);
		//$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0','ScheduleCalendar.start >'=>date('Y-m-d H:i:s')),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));	
		
		$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$groupid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0',"ScheduleCalendar.status <>"=> 0),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));

		$this->set('scheduleCalendars',$scheduleCalendars);

		$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.groupid"=>$groupid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));

		$this->set('setWarmupArr',$setWarmupArr);		
		
		//echo "<pre>"; print_r($setWarmupArr); echo "</pre>";	
		
		$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.groupid"=>$groupid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));

		$this->set('setCoreBalancePlyometricArr',$setCoreBalancePlyometricArr);

		$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.groupid"=>$groupid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));

		$this->set('setSpeedAgilityQuicknessArr',$setSpeedAgilityQuicknessArr);

		$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.groupid"=>$groupid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

		$this->set('setResistenceArr',$setResistenceArr);

		$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.groupid"=>$groupid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

		$this->set('setCoolDownArr',$setCoolDownArr);	

	}
	
	public function editWorkoutDataGroup()
	{  
		$this->layout = '';

		$this->autoRender = false;

		$TrainerId = $this->Session->read('USER_ID');

		$groupid = $_POST['groupid'];		
		
		$response=array();

		$exe1Count = count($_POST['nplayexercise']); 

		$exerciseCount1 = count($_POST['nplay1exercise']);

		$exerciseCount2 = count($_POST['nplay2exercise']);

		$exerciseCount3 = count($_POST['nplay3exercise']);

		$exerciseCount4 = count($_POST['nplay4exercise']);

		$GoalId=trim($_POST['GoalId']);

		$getClientGoalDetails=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$GoalId)));

		$startDate2		=	$getClientGoalDetails['Goal']['start'];

		$endDate2		=	$getClientGoalDetails['Goal']['end'];

		if(isset($_POST['changeTime']) && trim($_POST['changeTime'])=='yes')
		{
			if(trim($_POST['oldTime'])!=trim($_POST['sessType']))
			{
				$stD=trim($_POST['sessType']);

				$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));

				$startDate = $schcaldt['ScheduleCalendar']['start'];

				$endDate  = $schcaldt['ScheduleCalendar']['end'];

				$this->ScheduleCalendar->query("update schedule_calendar set mapwrkt=0 where id='".$_POST['oldTime']."'");

				$this->ScheduleCalendar->query("update schedule_calendar set mapwrkt=1 where id='".$_POST['sessType']."'");
			}
			else 
			{
				$startDate		=	$getClientGoalDetails['Goal']['start'];

				$endDate		=	$getClientGoalDetails['Goal']['end'];
			}
		} 
		else 
		{
			$startDate		=	$getClientGoalDetails['Goal']['start'];

			$endDate		=	$getClientGoalDetails['Goal']['end'];
		}
		$WarmUpsdataD['start']			=	$startDate;

		$WarmUpsdataD['end']			=	$endDate;

		$WarmUpsdataD['groupid']	=	$groupid;

		$WarmUpsdataD['trainer_id']	=	$TrainerId;

		$this->WarmUps->query("delete from warm_ups where trainer_id='".$TrainerId."' and groupid='".$groupid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->CoreBalancePlyometric->query("delete from corebalance_plyometric where trainer_id='".$TrainerId."' and groupid='".$groupid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->SpeedAgilityQuickness->query("delete from speedagility_quickness where trainer_id='".$TrainerId."' and groupid='".$groupid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->Resistence->query("delete from resistences where trainer_id='".$TrainerId."' and groupid='".$groupid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->CoolDown->query("delete from cool_down where trainer_id='".$TrainerId."' and groupid='".$groupid."' and start='".$startDate2."' and end='".$endDate2."'");

		$goalArr=array();

		$goalArr['Goal']['goal']=trim($_POST['goal']);

		$goalArr['Goal']['phase']=trim($_POST['phase']);

		$goalArr['Goal']['note']=trim($_POST['note']);

		$goalArr['Goal']['alert']=trim($_POST['alert']);

		$goalArr['Goal']['start']=trim($startDate);

		$goalArr['Goal']['end']=trim($endDate);

		$goalArr['Goal']['id']=$GoalId;	

		$this->Goal->save($goalArr);

		for($i=0;$i<$exe1Count;$i++)
		{
			$exercisedata['WarmUps']['trainer_id']=$TrainerId;

			$exercisedata['WarmUps']['groupid']=$groupid;

			$exercisedata['WarmUps']['exercise']=trim($_POST['nplayexercise'][$i]);

			$exercisedata['WarmUps']['set']=trim($_POST['nplayset'][$i]);

			$exercisedata['WarmUps']['duration']=trim($_POST['nplayduration'][$i]);

			$exercisedata['WarmUps']['coaching_tip']=trim($_POST['nplaycoaching_tip'][$i]);

			$exercisedata['WarmUps']['added_date']=date('Y-m-d H:i:s');

			$exercisedata['WarmUps']['start']=$startDate;

			$exercisedata['WarmUps']['end']=$endDate;
			
			if($exercisedata['WarmUps']['exercise']!='') 
			{
				$this->WarmUps->saveAll($exercisedata);
			}
		}

		for($i=0;$i<$exerciseCount1;$i++)
		{
			$exercisedata1['CoreBalancePlyometric']['trainer_id']=$TrainerId;

			$exercisedata1['CoreBalancePlyometric']['groupid']=$groupid;

			$exercisedata1['CoreBalancePlyometric']['exercise']=trim($_POST['nplay1exercise'][$i]);
			$exercisedata1['CoreBalancePlyometric']['set']=trim($_POST['nplay1set'][$i]);

			$exercisedata1['CoreBalancePlyometric']['rep']=trim($_POST['nplay1rep'][$i]);

			$exercisedata1['CoreBalancePlyometric']['rest']=trim($_POST['nplay1rest'][$i]);

			$exercisedata1['CoreBalancePlyometric']['temp']=trim($_POST['nplay1temp'][$i]);

			$exercisedata1['CoreBalancePlyometric']['coaching_tip']=trim($_POST['nplay1coaching_tip'][$i]);

			$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d H:i:s');

			$exercisedata1['CoreBalancePlyometric']['start']=$startDate;

			$exercisedata1['CoreBalancePlyometric']['end']=$endDate;
			
			if($exercisedata1['CoreBalancePlyometric']['exercise']!='') 
			{
				$this->CoreBalancePlyometric->saveAll($exercisedata1);
			}
		}

		for($i=0;$i<$exerciseCount2;$i++)
		{
			$exercisedata2['SpeedAgilityQuickness']['trainer_id']=$TrainerId;

			$exercisedata2['SpeedAgilityQuickness']['groupid']=$groupid;

			$exercisedata2['SpeedAgilityQuickness']['exercise']=trim($_POST['nplay2exercise'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['set']=trim($_POST['nplay2set'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['rep']=trim($_POST['nplay2rep'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['rest']=trim($_POST['nplay2rest'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['temp']=trim($_POST['nplay2temp'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['coaching_tip']=trim($_POST['nplay2coaching_tip'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d H:i:s');

			$exercisedata2['SpeedAgilityQuickness']['start']=$startDate;

			$exercisedata2['SpeedAgilityQuickness']['end']=$endDate;

			if($exercisedata2['SpeedAgilityQuickness']['exercise']!='') 
			{
				$this->SpeedAgilityQuickness->saveAll($exercisedata2);
			}
		}
		
		for($i=0;$i<$exerciseCount3;$i++)
		{
			$exercisedata3['Resistence']['trainer_id']=$TrainerId;

			$exercisedata3['Resistence']['groupid']=$groupid;

			$exercisedata3['Resistence']['exercise']=trim($_POST['nplay3exercise'][$i]);

			$exercisedata3['Resistence']['set']=trim($_POST['nplay3set'][$i]);

			$exercisedata3['Resistence']['rep']=trim($_POST['nplay3rep'][$i]);

			$exercisedata3['Resistence']['rest']=trim($_POST['nplay3rest'][$i]);

			$exercisedata3['Resistence']['temp']=trim($_POST['nplay3temp'][$i]);

			$exercisedata3['Resistence']['coaching_tip']=trim($_POST['nplay3coaching_tip'][$i]);

			$exercisedata3['Resistence']['added_date']=date('Y-m-d H:i:s');

			$exercisedata3['Resistence']['start']=$startDate;

			$exercisedata3['Resistence']['end']=$endDate;

			if($exercisedata3['Resistence']['exercise']!='') 
			{
				$this->Resistence->saveAll($exercisedata3);
			}
		}
				
		for($i=0;$i<$exerciseCount4;$i++)
		{
			$exercisedata4['CoolDown']['trainer_id']=$TrainerId;

			$exercisedata4['CoolDown']['groupid']=$groupid;

			$exercisedata4['CoolDown']['exercise']=trim($_POST['nplay4exercise'][$i]);

			$exercisedata4['CoolDown']['set']=trim($_POST['nplay4set'][$i]);

			$exercisedata4['CoolDown']['duration']=trim($_POST['nplay4duration'][$i]);

			$exercisedata4['CoolDown']['coaching_tip']=trim($_POST['nplay4coaching_tip'][$i]);

			$exercisedata4['CoolDown']['added_date']=date('Y-m-d H:i:s');

			$exercisedata4['CoolDown']['start']=$startDate;

			$exercisedata4['CoolDown']['end']=$endDate;
			
			if($exercisedata4['CoolDown']['exercise']!='') 
			{
				$this->CoolDown->saveAll($exercisedata4);
			}
		}
		
		$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have edited Workout Data successfully.");
		
		echo json_encode($response);

		exit;
	}
	
	
	
	public function edit_print_exercise_history_group($groupid=null,$stD=null,$pBy=null)
	{
		$this->checkUserLogin();

	    $this->layout = "printlayout";		

		$dbusertype = $this->Session->read('UTYPE');

		$this->set("dbusertype",$dbusertype);

		$this->set("gid",$groupid);

		$this->set("schid",$stD);
		
		$this->set("postedby",$pBy);	

	    $uid = $this->Session->read('USER_ID');

	    $setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));

		$this->set("setSpecalistArr",$setSpecalistArr);

		$showoff=1;

		$this->set("groupid",$groupid);
		
		$setGroupArr=$this->Group->find("first",array("conditions"=>array("Group.id"=>$groupid)));				

		$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));

		$strtDt = $schcaldt['ScheduleCalendar']['start'];

		$endDt  = $schcaldt['ScheduleCalendar']['end'];

		$startvaldt = $strtDt;

		$endvaldt = $endDt;
		
		$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.groupid"=>$groupid, "Goal.start"=>$strtDt,"Goal.end"=>$endDt),"Order"=>array("Goal.id"=>"DESC")));				

		$this->set('clientGoal',$setClientGoalArr);
		
		//echo "<pre>"; print_r($setClientGoalArr); echo "</pre>";
		
		$this->set('schcaldt',$schcaldt);

		$this->set('msdate',$msdate);
		//$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0','ScheduleCalendar.start >'=>date('Y-m-d H:i:s')),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));	
		
		$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$groupid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0',"ScheduleCalendar.status <>"=> 0),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));

		$this->set('scheduleCalendars',$scheduleCalendars);

		$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.groupid"=>$groupid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));

		$this->set('setWarmupArr',$setWarmupArr);		
		
		//echo "<pre>"; print_r($setWarmupArr); echo "</pre>";	
		
		$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.groupid"=>$groupid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));

		$this->set('setCoreBalancePlyometricArr',$setCoreBalancePlyometricArr);

		$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.groupid"=>$groupid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));

		$this->set('setSpeedAgilityQuicknessArr',$setSpeedAgilityQuicknessArr);

		$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.groupid"=>$groupid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

		$this->set('setResistenceArr',$setResistenceArr);

		$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.groupid"=>$groupid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));
		
		$this->set('setCoolDownArr',$setCoolDownArr);
		
	}
	
	public function printAndSaveGroup()
	{  
		$this->layout = '';

		$this->autoRender = false;

		$TrainerId = $this->Session->read('USER_ID');
		
		$groupid = $_POST['groupid'];		
		
		$stD = $_POST['oldTime'];

		$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));

		$response=array();

		$exe1Count = count($_POST['nplayexercise']); 

		$exerciseCount1 = count($_POST['nplay1exercise']);

		$exerciseCount2 = count($_POST['nplay2exercise']);

		$exerciseCount3 = count($_POST['nplay3exercise']);

		$exerciseCount4 = count($_POST['nplay4exercise']);

		$GoalId=trim($_POST['GoalId']);

		$getClientGoalDetails=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$GoalId)));

		$startDate2		=	$getClientGoalDetails['Goal']['start'];

		$endDate2			=	$getClientGoalDetails['Goal']['end'];

		$startDate		=	$getClientGoalDetails['Goal']['start'];

		$endDate		=	$getClientGoalDetails['Goal']['end'];				 

		$WarmUpsdataD['start']			=	$startDate;

		$WarmUpsdataD['end']			=	$endDate;

		$WarmUpsdataD['trainee_id']	=	$groupid;

		$WarmUpsdataD['trainer_id']	=	$TrainerId;

		$this->WarmUps->query("delete from warm_ups where trainer_id='".$TrainerId."' and groupid='".$groupid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->CoreBalancePlyometric->query("delete from corebalance_plyometric where trainer_id='".$TrainerId."' and groupid='".$groupid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->SpeedAgilityQuickness->query("delete from speedagility_quickness where trainer_id='".$TrainerId."' and groupid='".$groupid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->Resistence->query("delete from resistences where trainer_id='".$TrainerId."' and groupid='".$groupid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->CoolDown->query("delete from cool_down where trainer_id='".$TrainerId."' and groupid='".$groupid."' and start='".$startDate2."' and end='".$endDate2."'");

		$goalArr=array();

		$goalArr['Goal']['goal']=trim($_POST['goal']);

		$goalArr['Goal']['phase']=trim($_POST['phase']);

		$goalArr['Goal']['note']=trim($_POST['note']);

		$goalArr['Goal']['alert']=trim($_POST['alert']);

		$goalArr['Goal']['start']=trim($startDate);

		$goalArr['Goal']['end']=trim($endDate);

		$goalArr['Goal']['id']=$GoalId;						

		$this->Goal->save($goalArr);
	

		for($i=0;$i<$exe1Count;$i++)
		{
			$exercisedata['WarmUps']['trainer_id']=$TrainerId;

			$exercisedata['WarmUps']['groupid']=$groupid;

			$exercisedata['WarmUps']['exercise']=trim($_POST['nplayexercise'][$i]);

			$exercisedata['WarmUps']['set']=trim($_POST['nplayset'][$i]);

			$exercisedata['WarmUps']['duration']=trim($_POST['nplayduration'][$i]);

			$exercisedata['WarmUps']['coaching_tip']=trim($_POST['nplaycoaching_tip'][$i]);

			$exercisedata['WarmUps']['added_date']=date('Y-m-d H:i:s');

			$exercisedata['WarmUps']['start']=$startDate;

			$exercisedata['WarmUps']['end']=$endDate;
			
			if($exercisedata['WarmUps']['exercise']!='') 
			{
				$this->WarmUps->saveAll($exercisedata);
			}
		}
		
		for($i=0;$i<$exerciseCount1;$i++)
		{
			$exercisedata1['CoreBalancePlyometric']['trainer_id']=$TrainerId;

			$exercisedata1['CoreBalancePlyometric']['groupid']=$groupid;

			$exercisedata1['CoreBalancePlyometric']['exercise']=trim($_POST['nplay1exercise'][$i]);

			$exercisedata1['CoreBalancePlyometric']['set']=trim($_POST['nplay1set'][$i]);

			$exercisedata1['CoreBalancePlyometric']['rep']=trim($_POST['nplay1rep'][$i]);

			$exercisedata1['CoreBalancePlyometric']['rest']=trim($_POST['nplay1rest'][$i]);

			$exercisedata1['CoreBalancePlyometric']['temp']=trim($_POST['nplay1temp'][$i]);

			$exercisedata1['CoreBalancePlyometric']['coaching_tip']=trim($_POST['nplay1coaching_tip'][$i]);

			$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d H:i:s');

			$exercisedata1['CoreBalancePlyometric']['start']=$startDate;

			$exercisedata1['CoreBalancePlyometric']['end']=$endDate;

			if($exercisedata1['CoreBalancePlyometric']['exercise']!='') 
			{
				$this->CoreBalancePlyometric->saveAll($exercisedata1);
			}
		}

		for($i=0;$i<$exerciseCount2;$i++)
		{
			$exercisedata2['SpeedAgilityQuickness']['trainer_id']=$TrainerId;

			$exercisedata2['SpeedAgilityQuickness']['groupid']=$groupid;

			$exercisedata2['SpeedAgilityQuickness']['exercise']=trim($_POST['nplay2exercise'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['set']=trim($_POST['nplay2set'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['rep']=trim($_POST['nplay2rep'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['rest']=trim($_POST['nplay2rest'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['temp']=trim($_POST['nplay2temp'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['coaching_tip']=trim($_POST['nplay2coaching_tip'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d H:i:s');

			$exercisedata2['SpeedAgilityQuickness']['start']=$startDate;

			$exercisedata2['SpeedAgilityQuickness']['end']=$endDate;

			if($exercisedata2['SpeedAgilityQuickness']['exercise']!='') 
			{
				$this->SpeedAgilityQuickness->saveAll($exercisedata2);
			}
		}
		for($i=0;$i<$exerciseCount3;$i++)
		{
			$exercisedata3['Resistence']['trainer_id']=$TrainerId;

			$exercisedata3['Resistence']['groupid']=$groupid;

			$exercisedata3['Resistence']['exercise']=trim($_POST['nplay3exercise'][$i]);

			$exercisedata3['Resistence']['set']=trim($_POST['nplay3set'][$i]);

			$exercisedata3['Resistence']['rep']=trim($_POST['nplay3rep'][$i]);

			$exercisedata3['Resistence']['rest']=trim($_POST['nplay3rest'][$i]);

			$exercisedata3['Resistence']['temp']=trim($_POST['nplay3temp'][$i]);

			$exercisedata3['Resistence']['coaching_tip']=trim($_POST['nplay3coaching_tip'][$i]);

			$exercisedata3['Resistence']['added_date']=date('Y-m-d H:i:s');

			$exercisedata3['Resistence']['start']=$startDate;

			$exercisedata3['Resistence']['end']=$endDate;

			if($exercisedata3['Resistence']['exercise']!='') 
			{
				$this->Resistence->saveAll($exercisedata3);
			}
		}
		for($i=0;$i<$exerciseCount4;$i++)
		{
			$exercisedata4['CoolDown']['trainer_id']=$TrainerId;

			$exercisedata4['CoolDown']['groupid']=$groupid;

			$exercisedata4['CoolDown']['exercise']=trim($_POST['nplay4exercise'][$i]);

			$exercisedata4['CoolDown']['set']=trim($_POST['nplay4set'][$i]);

			$exercisedata4['CoolDown']['duration']=trim($_POST['nplay4duration'][$i]);

			$exercisedata4['CoolDown']['coaching_tip']=trim($_POST['nplay4coaching_tip'][$i]);

			$exercisedata4['CoolDown']['added_date']=date('Y-m-d H:i:s');

			$exercisedata4['CoolDown']['start']=$startDate;

			$exercisedata4['CoolDown']['end']=$endDate;

			if($exercisedata4['CoolDown']['exercise']!='') 
			{
				$this->CoolDown->saveAll($exercisedata4);
			}
		}
		
		$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have edited Workout Data successfully.");

		echo json_encode($response);

		exit;
	}
	
	public function print_exercise_history_group($groupid=null,$stD=null)
	{		
		$this->checkUserLogin();

	    $this->layout = "printlayout";		

		$dbusertype = $this->Session->read('UTYPE');

		$this->set("dbusertype",$dbusertype);

		$this->set("gid",$groupid);

		$this->set("schid",$stD);

	    $uid = $this->Session->read('USER_ID');		

	    $setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));		

		$this->set("setSpecalistArr",$setSpecalistArr);

		$showoff=1;	

		$this->set("groupid",$groupid);
		
		$setGroupArr=$this->Group->find("first",array("conditions"=>array("Group.id"=>$groupid)));		

		$this->set('clientDatas',$setGroupArr);				
		
		$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));	
		
		$strtDt = $schcaldt['ScheduleCalendar']['start'];

		$endDt  = $schcaldt['ScheduleCalendar']['end'];		

		$startvaldt = $strtDt;

		$endvaldt = $endDt;				

		$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.groupid"=>$groupid, "Goal.start"=>$strtDt,"Goal.end"=>$endDt),"Order"=>array("Goal.id"=>"DESC")));				

		$this->set('clientGoal',$setClientGoalArr);

		$this->set('schcaldt',$schcaldt);		
		
		$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$groupid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0','ScheduleCalendar.start >'=>date('Y-m-d H:i:s')),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status'),'limit'=>5));	

		$this->set('scheduleCalendars',$scheduleCalendars);			
		
		$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.groupid"=>$groupid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));	

		$this->set('setWarmupArr',$setWarmupArr);	

		$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.groupid"=>$groupid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));	

		$this->set('setCoreBalancePlyometricArr',$setCoreBalancePlyometricArr);

		$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.groupid"=>$groupid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));	

		$this->set('setSpeedAgilityQuicknessArr',$setSpeedAgilityQuicknessArr);

		$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.groupid"=>$groupid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

		$this->set('setResistenceArr',$setResistenceArr);
		
		$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.groupid"=>$groupid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));	

		$this->set('setCoolDownArr',$setCoolDownArr);
		
	}
	
	function edit_exercise_history_group_client_ind($groupid=null,$stD=null,$msdate=null,$clientid=null)
	{
		$this->checkUserLogin();

		$this->layout = "homelayout";		

		$this->set("leftcheck",'exercise_history');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));		

		$this->set("setSpecalistArr",$setSpecalistArr);

		$showoff=1;		

		$this->set("groupid",$groupid);			

		$this->set("clientid",$clientid);	
		
		$setGroupArr=$this->Group->find("first",array("conditions"=>array("Group.id"=>$groupid)));				

		$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));

		$strtDt = $schcaldt['ScheduleCalendar']['start'];

		$endDt  = $schcaldt['ScheduleCalendar']['end'];

		$startvaldt = $strtDt;

		$endvaldt = $endDt;
		
		$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.groupid"=>$groupid, "Goal.start"=>$strtDt,"Goal.end"=>$endDt),"Order"=>array("Goal.id"=>"DESC")));				

		$this->set('clientGoal',$setClientGoalArr);
		
		//echo "<pre>"; print_r($setClientGoalArr); echo "</pre>";
		
		$this->set('schcaldt',$schcaldt);

		$this->set('msdate',$msdate);
		//$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0','ScheduleCalendar.start >'=>date('Y-m-d H:i:s')),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));	
		
		$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$groupid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0',"ScheduleCalendar.status <>"=> 0),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));

		$this->set('scheduleCalendars',$scheduleCalendars);

		$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.groupid"=>$groupid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));

		$this->set('setWarmupArr',$setWarmupArr);		
		
		//echo "<pre>"; print_r($setWarmupArr); echo "</pre>";	
		
		$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.groupid"=>$groupid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));

		$this->set('setCoreBalancePlyometricArr',$setCoreBalancePlyometricArr);

		$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.groupid"=>$groupid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));

		$this->set('setSpeedAgilityQuicknessArr',$setSpeedAgilityQuicknessArr);

		$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.groupid"=>$groupid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

		$this->set('setResistenceArr',$setResistenceArr);

		$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.groupid"=>$groupid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

		$this->set('setCoolDownArr',$setCoolDownArr);	

	}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function addWorkoutDataGroupClientInd()
	{  		
		$this->layout = '';

		$this->autoRender = false;

		$TrainerId = $this->Session->read('USER_ID');

		$groupid = $_POST['groupid'];

		$clientid = $_POST['clientid'];
				
		$response=array();

		$exe1Count = count($_POST['nplayexercise']); 

		$exerciseCount1 = count($_POST['nplay1exercise']);

		$exerciseCount2 = count($_POST['nplay2exercise']);

		$exerciseCount3 = count($_POST['nplay3exercise']);

		$exerciseCount4 = count($_POST['nplay4exercise']);

		$GoalId=trim($_POST['GoalId']);
		

		$getClientGoalDetails=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$GoalId)));

		$startDate2		=	$getClientGoalDetails['Goal']['start'];

		$endDate2		=	$getClientGoalDetails['Goal']['end'];

		if(isset($_POST['changeTime']) && trim($_POST['changeTime'])=='yes')
		{
			if(trim($_POST['oldTime'])!=trim($_POST['sessType']))
			{
				$stD=trim($_POST['sessType']);
				

				$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));

				$startDate = $schcaldt['ScheduleCalendar']['start'];

				$endDate  = $schcaldt['ScheduleCalendar']['end'];

				$this->ScheduleCalendar->query("update schedule_calendar set mapwrkt=0 where id='".$_POST['oldTime']."'");

				$this->ScheduleCalendar->query("update schedule_calendar set mapwrkt=1 where id='".$_POST['sessType']."'");
			}
			else 
			{
				$startDate		=	$getClientGoalDetails['Goal']['start'];

				$endDate		=	$getClientGoalDetails['Goal']['end'];
			}
		} 
		else 
		{
			$startDate		=	$getClientGoalDetails['Goal']['start'];

			$endDate		=	$getClientGoalDetails['Goal']['end'];
		}
		$WarmUpsdataD['start']			=	$startDate;

		$WarmUpsdataD['end']			=	$endDate;

		$WarmUpsdataD['groupid']	=	$groupid;

		$WarmUpsdataD['trainer_id']	=	$TrainerId;

		$this->WarmUps->query("delete from warm_ups where trainer_id='".$TrainerId."' and trainee_id='".$clientid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->CoreBalancePlyometric->query("delete from corebalance_plyometric where trainer_id='".$TrainerId."' and trainee_id='".$clientid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->SpeedAgilityQuickness->query("delete from speedagility_quickness where trainer_id='".$TrainerId."' and trainee_id='".$clientid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->Resistence->query("delete from resistences where trainer_id='".$TrainerId."' and trainee_id='".$clientid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->CoolDown->query("delete from cool_down where trainer_id='".$TrainerId."' and trainee_id='".$clientid."' and start='".$startDate2."' and end='".$endDate2."'");

		$goalArr=array();

		$goalArr['Goal']['goal']=trim($_POST['goal']);

		$goalArr['Goal']['phase']=trim($_POST['phase']);

		$goalArr['Goal']['note']=trim($_POST['note']);

		$goalArr['Goal']['alert']=trim($_POST['alert']);

		$goalArr['Goal']['start']=trim($startDate);

		$goalArr['Goal']['end']=trim($endDate);
		
		$goalArr['Goal']['trainee_id']=$clientid;
		
		$goalArr['Goal']['added_date']=date('Y-m-d H:i:s');
		
		$goalArr['Goal']['modified_date']=date('Y-m-d H:i:s');
		
		$goalArr['Goal']['trainer_id']=$TrainerId;

		//echo $goalArr['Goal']['id']=$GoalId;

		$this->Goal->save($goalArr);
		
		for($i=0;$i<$exe1Count;$i++)
		{
			$exercisedata['WarmUps']['trainer_id']=$TrainerId;

			$exercisedata['WarmUps']['trainee_id']=$clientid;

			$exercisedata['WarmUps']['exercise']=trim($_POST['nplayexercise'][$i]);

			$exercisedata['WarmUps']['set']=trim($_POST['nplayset'][$i]);

			$exercisedata['WarmUps']['duration']=trim($_POST['nplayduration'][$i]);

			$exercisedata['WarmUps']['coaching_tip']=trim($_POST['nplaycoaching_tip'][$i]);

			$exercisedata['WarmUps']['added_date']=date('Y-m-d H:i:s');

			$exercisedata['WarmUps']['start']=$startDate;

			$exercisedata['WarmUps']['end']=$endDate;
			
			if($exercisedata['WarmUps']['exercise']!='') 
			{
				$this->WarmUps->saveAll($exercisedata);
			}
		}

		for($i=0;$i<$exerciseCount1;$i++)
		{
			$exercisedata1['CoreBalancePlyometric']['trainer_id']=$TrainerId;

			$exercisedata1['CoreBalancePlyometric']['trainee_id']=$clientid;
			
			$exercisedata1['CoreBalancePlyometric']['exercise']=trim($_POST['nplay1exercise'][$i]);
			$exercisedata1['CoreBalancePlyometric']['set']=trim($_POST['nplay1set'][$i]);

			$exercisedata1['CoreBalancePlyometric']['rep']=trim($_POST['nplay1rep'][$i]);

			$exercisedata1['CoreBalancePlyometric']['rest']=trim($_POST['nplay1rest'][$i]);

			$exercisedata1['CoreBalancePlyometric']['temp']=trim($_POST['nplay1temp'][$i]);

			$exercisedata1['CoreBalancePlyometric']['coaching_tip']=trim($_POST['nplay1coaching_tip'][$i]);

			$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d H:i:s');

			$exercisedata1['CoreBalancePlyometric']['start']=$startDate;

			$exercisedata1['CoreBalancePlyometric']['end']=$endDate;
			
			if($exercisedata1['CoreBalancePlyometric']['exercise']!='') 
			{
				$this->CoreBalancePlyometric->saveAll($exercisedata1);
			}
		}

		for($i=0;$i<$exerciseCount2;$i++)
		{
			$exercisedata2['SpeedAgilityQuickness']['trainer_id']=$TrainerId;

			$exercisedata2['SpeedAgilityQuickness']['trainee_id']=$clientid;

			$exercisedata2['SpeedAgilityQuickness']['exercise']=trim($_POST['nplay2exercise'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['set']=trim($_POST['nplay2set'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['rep']=trim($_POST['nplay2rep'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['rest']=trim($_POST['nplay2rest'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['temp']=trim($_POST['nplay2temp'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['coaching_tip']=trim($_POST['nplay2coaching_tip'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d H:i:s');

			$exercisedata2['SpeedAgilityQuickness']['start']=$startDate;

			$exercisedata2['SpeedAgilityQuickness']['end']=$endDate;

			if($exercisedata2['SpeedAgilityQuickness']['exercise']!='') 
			{
				$this->SpeedAgilityQuickness->saveAll($exercisedata2);
			}
		}
		
		for($i=0;$i<$exerciseCount3;$i++)
		{
			$exercisedata3['Resistence']['trainer_id']=$TrainerId;

			$exercisedata3['Resistence']['trainee_id']=$clientid;

			$exercisedata3['Resistence']['exercise']=trim($_POST['nplay3exercise'][$i]);

			$exercisedata3['Resistence']['set']=trim($_POST['nplay3set'][$i]);

			$exercisedata3['Resistence']['rep']=trim($_POST['nplay3rep'][$i]);

			$exercisedata3['Resistence']['rest']=trim($_POST['nplay3rest'][$i]);

			$exercisedata3['Resistence']['temp']=trim($_POST['nplay3temp'][$i]);

			$exercisedata3['Resistence']['coaching_tip']=trim($_POST['nplay3coaching_tip'][$i]);

			$exercisedata3['Resistence']['added_date']=date('Y-m-d H:i:s');

			$exercisedata3['Resistence']['start']=$startDate;

			$exercisedata3['Resistence']['end']=$endDate;

			if($exercisedata3['Resistence']['exercise']!='') 
			{
				$this->Resistence->saveAll($exercisedata3);
			}
		}
				
		for($i=0;$i<$exerciseCount4;$i++)
		{
			$exercisedata4['CoolDown']['trainer_id']=$TrainerId;

			$exercisedata4['CoolDown']['trainee_id']=$clientid;

			$exercisedata4['CoolDown']['exercise']=trim($_POST['nplay4exercise'][$i]);

			$exercisedata4['CoolDown']['set']=trim($_POST['nplay4set'][$i]);

			$exercisedata4['CoolDown']['duration']=trim($_POST['nplay4duration'][$i]);

			$exercisedata4['CoolDown']['coaching_tip']=trim($_POST['nplay4coaching_tip'][$i]);

			$exercisedata4['CoolDown']['added_date']=date('Y-m-d H:i:s');

			$exercisedata4['CoolDown']['start']=$startDate;

			$exercisedata4['CoolDown']['end']=$endDate;
			
			if($exercisedata4['CoolDown']['exercise']!='') 
			{
				$this->CoolDown->saveAll($exercisedata4);
			}
		}
		
		$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have edited Workout Data successfully.");
		
		echo json_encode($response);

		exit;
	}
	
	
	function orig_edit_exercise_history_group_client_ind($groupid=null,$stD=null,$msdate=null,$clientid=null)
	{
		$this->checkUserLogin();

		$this->layout = "homelayout";		

		$this->set("leftcheck",'exercise_history');

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));		

		$this->set("setSpecalistArr",$setSpecalistArr);

		$showoff=1;		

		$this->set("groupid",$groupid);			

		$this->set("clientid",$clientid);	
		
		$setGroupArr=$this->Group->find("first",array("conditions"=>array("Group.id"=>$groupid)));				

		$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));

		$strtDt = $schcaldt['ScheduleCalendar']['start'];

		$endDt  = $schcaldt['ScheduleCalendar']['end'];

		$startvaldt = $strtDt;

		$endvaldt = $endDt;
		
		$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid, "Goal.start"=>$strtDt,"Goal.end"=>$endDt),"Order"=>array("Goal.id"=>"DESC")));				

		$this->set('clientGoal',$setClientGoalArr);
		
		//echo "<pre>"; print_r($setClientGoalArr); echo "</pre>";
		
		$this->set('schcaldt',$schcaldt);

		$this->set('msdate',$msdate);
		
		
		$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientid,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0',"ScheduleCalendar.status <>"=> 0),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));

		$this->set('scheduleCalendars',$scheduleCalendars);

		$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));

		$this->set('setWarmupArr',$setWarmupArr);		
		
		//echo "<pre>"; print_r($setWarmupArr); echo "</pre>";	
		
		$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));

		$this->set('setCoreBalancePlyometricArr',$setCoreBalancePlyometricArr);

		$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));

		$this->set('setSpeedAgilityQuicknessArr',$setSpeedAgilityQuicknessArr);

		$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

		$this->set('setResistenceArr',$setResistenceArr);

		$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

		$this->set('setCoolDownArr',$setCoolDownArr);	

	}
	
	
	
	public function origaddWorkoutDataGroupClientInd()
	{  
		$this->layout = '';

		$this->autoRender = false;

		$TrainerId = $this->Session->read('USER_ID');

		$groupid = $_POST['groupid'];

		$clientid = $_POST['clientid'];
				
		$response=array();

		$exe1Count = count($_POST['nplayexercise']); 

		$exerciseCount1 = count($_POST['nplay1exercise']);

		$exerciseCount2 = count($_POST['nplay2exercise']);

		$exerciseCount3 = count($_POST['nplay3exercise']);

		$exerciseCount4 = count($_POST['nplay4exercise']);

		$GoalId=trim($_POST['GoalId']);

		$getClientGoalDetails=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$GoalId)));

		$startDate2		=	$getClientGoalDetails['Goal']['start'];

		$endDate2		=	$getClientGoalDetails['Goal']['end'];

		if(isset($_POST['changeTime']) && trim($_POST['changeTime'])=='yes')
		{
			if(trim($_POST['oldTime'])!=trim($_POST['sessType']))
			{
				$stD=trim($_POST['sessType']);

				$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$stD),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.start','ScheduleCalendar.end')));

				$startDate = $schcaldt['ScheduleCalendar']['start'];

				$endDate  = $schcaldt['ScheduleCalendar']['end'];

				$this->ScheduleCalendar->query("update schedule_calendar set mapwrkt=0 where id='".$_POST['oldTime']."'");

				$this->ScheduleCalendar->query("update schedule_calendar set mapwrkt=1 where id='".$_POST['sessType']."'");
			}
			else 
			{
				$startDate		=	$getClientGoalDetails['Goal']['start'];

				$endDate		=	$getClientGoalDetails['Goal']['end'];
			}
		} 
		else 
		{
			$startDate		=	$getClientGoalDetails['Goal']['start'];

			$endDate		=	$getClientGoalDetails['Goal']['end'];
		}
		$WarmUpsdataD['start']			=	$startDate;

		$WarmUpsdataD['end']			=	$endDate;

		$WarmUpsdataD['groupid']	=	$groupid;

		$WarmUpsdataD['trainer_id']	=	$TrainerId;

		$this->WarmUps->query("delete from warm_ups where trainer_id='".$TrainerId."' and trainee_id='".$clientid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->CoreBalancePlyometric->query("delete from corebalance_plyometric where trainer_id='".$TrainerId."' and trainee_id='".$clientid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->SpeedAgilityQuickness->query("delete from speedagility_quickness where trainer_id='".$TrainerId."' and trainee_id='".$clientid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->Resistence->query("delete from resistences where trainer_id='".$TrainerId."' and trainee_id='".$clientid."' and start='".$startDate2."' and end='".$endDate2."'");

		$this->CoolDown->query("delete from cool_down where trainer_id='".$TrainerId."' and trainee_id='".$clientid."' and start='".$startDate2."' and end='".$endDate2."'");

		$goalArr=array();

		$goalArr['Goal']['goal']=trim($_POST['goal']);

		$goalArr['Goal']['phase']=trim($_POST['phase']);

		$goalArr['Goal']['note']=trim($_POST['note']);

		$goalArr['Goal']['alert']=trim($_POST['alert']);

		$goalArr['Goal']['start']=trim($startDate);

		$goalArr['Goal']['end']=trim($endDate);

		$goalArr['Goal']['id']=$GoalId;	
		
		$this->Goal->save($goalArr);
		
		

		for($i=0;$i<$exe1Count;$i++)
		{
			$exercisedata['WarmUps']['trainer_id']=$TrainerId;

			$exercisedata['WarmUps']['trainee_id']=$clientid;

			$exercisedata['WarmUps']['exercise']=trim($_POST['nplayexercise'][$i]);

			$exercisedata['WarmUps']['set']=trim($_POST['nplayset'][$i]);

			$exercisedata['WarmUps']['duration']=trim($_POST['nplayduration'][$i]);

			$exercisedata['WarmUps']['coaching_tip']=trim($_POST['nplaycoaching_tip'][$i]);

			$exercisedata['WarmUps']['added_date']=date('Y-m-d H:i:s');

			$exercisedata['WarmUps']['start']=$startDate;

			$exercisedata['WarmUps']['end']=$endDate;
			
			if($exercisedata['WarmUps']['exercise']!='') 
			{
				$this->WarmUps->saveAll($exercisedata);
			}
		}

		for($i=0;$i<$exerciseCount1;$i++)
		{
			$exercisedata1['CoreBalancePlyometric']['trainer_id']=$TrainerId;

			$exercisedata1['CoreBalancePlyometric']['trainee_id']=$clientid;
			
			$exercisedata1['CoreBalancePlyometric']['exercise']=trim($_POST['nplay1exercise'][$i]);
			$exercisedata1['CoreBalancePlyometric']['set']=trim($_POST['nplay1set'][$i]);

			$exercisedata1['CoreBalancePlyometric']['rep']=trim($_POST['nplay1rep'][$i]);

			$exercisedata1['CoreBalancePlyometric']['rest']=trim($_POST['nplay1rest'][$i]);

			$exercisedata1['CoreBalancePlyometric']['temp']=trim($_POST['nplay1temp'][$i]);

			$exercisedata1['CoreBalancePlyometric']['coaching_tip']=trim($_POST['nplay1coaching_tip'][$i]);

			$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d H:i:s');

			$exercisedata1['CoreBalancePlyometric']['start']=$startDate;

			$exercisedata1['CoreBalancePlyometric']['end']=$endDate;
			
			if($exercisedata1['CoreBalancePlyometric']['exercise']!='') 
			{
				$this->CoreBalancePlyometric->saveAll($exercisedata1);
			}
		}

		for($i=0;$i<$exerciseCount2;$i++)
		{
			$exercisedata2['SpeedAgilityQuickness']['trainer_id']=$TrainerId;

			$exercisedata2['SpeedAgilityQuickness']['trainee_id']=$clientid;

			$exercisedata2['SpeedAgilityQuickness']['exercise']=trim($_POST['nplay2exercise'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['set']=trim($_POST['nplay2set'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['rep']=trim($_POST['nplay2rep'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['rest']=trim($_POST['nplay2rest'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['temp']=trim($_POST['nplay2temp'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['coaching_tip']=trim($_POST['nplay2coaching_tip'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d H:i:s');

			$exercisedata2['SpeedAgilityQuickness']['start']=$startDate;

			$exercisedata2['SpeedAgilityQuickness']['end']=$endDate;

			if($exercisedata2['SpeedAgilityQuickness']['exercise']!='') 
			{
				$this->SpeedAgilityQuickness->saveAll($exercisedata2);
			}
		}
		
		for($i=0;$i<$exerciseCount3;$i++)
		{
			$exercisedata3['Resistence']['trainer_id']=$TrainerId;

			$exercisedata3['Resistence']['trainee_id']=$clientid;

			$exercisedata3['Resistence']['exercise']=trim($_POST['nplay3exercise'][$i]);

			$exercisedata3['Resistence']['set']=trim($_POST['nplay3set'][$i]);

			$exercisedata3['Resistence']['rep']=trim($_POST['nplay3rep'][$i]);

			$exercisedata3['Resistence']['rest']=trim($_POST['nplay3rest'][$i]);

			$exercisedata3['Resistence']['temp']=trim($_POST['nplay3temp'][$i]);

			$exercisedata3['Resistence']['coaching_tip']=trim($_POST['nplay3coaching_tip'][$i]);

			$exercisedata3['Resistence']['added_date']=date('Y-m-d H:i:s');

			$exercisedata3['Resistence']['start']=$startDate;

			$exercisedata3['Resistence']['end']=$endDate;

			if($exercisedata3['Resistence']['exercise']!='') 
			{
				$this->Resistence->saveAll($exercisedata3);
			}
		}
				
		for($i=0;$i<$exerciseCount4;$i++)
		{
			$exercisedata4['CoolDown']['trainer_id']=$TrainerId;

			$exercisedata4['CoolDown']['trainee_id']=$clientid;

			$exercisedata4['CoolDown']['exercise']=trim($_POST['nplay4exercise'][$i]);

			$exercisedata4['CoolDown']['set']=trim($_POST['nplay4set'][$i]);

			$exercisedata4['CoolDown']['duration']=trim($_POST['nplay4duration'][$i]);

			$exercisedata4['CoolDown']['coaching_tip']=trim($_POST['nplay4coaching_tip'][$i]);

			$exercisedata4['CoolDown']['added_date']=date('Y-m-d H:i:s');

			$exercisedata4['CoolDown']['start']=$startDate;

			$exercisedata4['CoolDown']['end']=$endDate;
			
			if($exercisedata4['CoolDown']['exercise']!='') 
			{
				$this->CoolDown->saveAll($exercisedata4);
			}
		}
		
		$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Thanks, you have edited Workout Data successfully.");
		
		echo json_encode($response);

		exit;
	}
	
	public function getclientsessionstatus()
	{	
		$this->layout = "";	

		$this->autoRender=false;
		
		$gid=$_POST['gid'];

		$clid=trim($_POST['clid']);	
				
		$tid=$_POST['tid'];

		$sdate = $_POST['sdate'];
		
		$edate = $_POST['edate'];
		
		$uid = $this->Session->read('USER_ID');		
			    
		$trainerid=$uid;		
		
		$groupData = $this->GroupMember->find('all',array("conditions"=>array('GroupMember.group_id'=>$gid),'fields'=>array('GroupMember.group_name','GroupMember.client_id')));		
		
		$this->set("groupData",$groupData);
		
		//echo "<pre>";print_r($groupData);echo "</pre>"; die;
		$flag_satus = "success";
		foreach($groupData as $gd)
		{
			$clientsessionData=$this->GroupClientStat->find('first',array("conditions"=>array('GroupClientStat.client_id'=>$gd['GroupMember']['client_id'],'GroupClientStat.trainer_id'=>$tid,'GroupClientStat.start'=>$sdate,'GroupClientStat.end'=>$edate)));
			
			$sessionstatus = $clientsessionData['GroupClientStat']['session_status'];
		    
			if (empty($clientsessionData)|| $sessionstatus != 'Completed')
			{
				$flag_satus = "fail";
			}
			//echo "<pre>";print_r($workoutData);echo "</pre>"; 					
		}		
		echo json_encode($flag_satus);

		exit;
	}
	
	public function scheduler_calender_for_completed_session()
	{	
		$this->layout = "";	

		$this->autoRender=false;
		
		$gid=$_POST['gid'];

		$clid=trim($_POST['clid']);	
				
		$tid=$_POST['tid'];

		$sdate = $_POST['sdate'];
		
		$edate = $_POST['edate'];
		
		$uid = $this->Session->read('USER_ID');		
			    
		$trainerid=$uid;		
		
		$this->ScheduleCalendar->query("update schedule_calendar set appointment_type = 'Completed' where trainer_id='".$tid."' AND trainee_id='".$gid."' AND start='".$sdate."' AND end='".$edate."' AND posted_by='Group'");
		
		echo json_encode($flag_satus);

		exit;
	}
	
	
	public function savedwrktshowgroup()
	{
		$this->layout="";

		$this->autoRender=false;

		$groupidwithclient=trim($_REQUEST['groupidwithclient']);
		
		$groupid=trim($_REQUEST['groupid']);
		
		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');

		$tempwrkt=$this->TempWorkout->find('all',array('conditions'=>array('TempWorkout.trainer_id'=>$uid,'TempWorkout.group_id'=>$groupid),'order'=>array('TempWorkout.id ASC')));

		$groupData=$this->Group->find('first',array('conditions'=>array('Group.id'=>$groupidwithclient)));

		$goals=$this->Goal->find("first",array("conditions"=>array("Goal.groupid"=>$groupidwithclient),'order' => array('Goal.id' => 'DESC')));

		$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$groupidwithclient,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0', 'ScheduleCalendar.status <>'=>'0'),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status','ScheduleCalendar.posted_by')));

		echo '<form onsubmit="return validatefrmsfdgroup();" method="POST" action="" id="addexercise">

		<div style="display: none;" class="loaderResultFd"><img src="http://www.sampatti.com/fitnessAaland/images/ajax-loader.gif"></div> <div id="notificatin_mesFd" style="color:#ff0000; padding:4px 0 4px 0;"></div>

		<input type="hidden" value="'.$uid.'" id="trainer_id" name="trainer_id">

		<input type="hidden" value="'.$groupidwithclient.'" id="group_id" name="group_id">

		<input type="hidden" value="" id="added_date" name="added_date">

		<table width="100%" border="1" id="a">

		<tbody><tr class="slectedmn">

		<td width="100%" class="th2" colspan="4"><h3 style="text-align:left;float:left;">Group Name:   </h3> <span style="float: left; line-height: 32px;  padding: 10px 5px 5px;" id="groupname">'.$groupData['Group']['group_name'].'</span>

		</td>

		</tr>

		<tr class="slectedmn">

		<td width="100%" colspan="4"> <span style="line-height:34px;float:left;">Session Availability:</span>

		<div class="twelve  form-select columns"> <select name="sessType" class="sltbx" onchange="document.getElementById(\'CustomSessiontype\').value= this.options[this.selectedIndex].text" id="ScheduleCalendarTimeslot">

		<option value="">-- Session Availability --</option>';

		foreach($scheduleCalendars as $scheduleCalendar)
		{
			echo '<option value="'.$scheduleCalendar['ScheduleCalendar']['id'].'">'.date('m-d-Y h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['start'])).' - '.date('h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['end'])).'</option>';
		}                 

		echo '</select> <input type="text" value="-- Session Type --" name="sessTypet" id="CustomSessiontype"> </div> </td> </tr> </tbody></table> 

		<table width="100%" border="1" id="b">

		<tbody><tr class="slectedmn">

		<td class="th2" colspan="3"><span style="float: left; line-height: 36px;">Goal:</span> <input type="text" style="width:220px;" value="'.$goals['Goal']['goal'].'" id="goal" name="goal"></td><td> <span style="float: left; line-height: 36px;">Phase:</span> <input type="text" style="width:100px;" value="'.$goals['Goal']['phase'].'" id="phase" name="phase"></td>

		</tr>

		</tbody></table>	

		<table width="100%" border="1" id="c">

		<tbody><tr class="slectedmn">

		<td class="th2"><span style="float: left; line-height: 36px;">Note:</span><textarea style="width: 94%;" name="note" id="note">'.$goals['Goal']['note'].'</textarea></td>

		</tr>

		</tbody></table>

		<table width="100%" border="1" id="d">

		<tbody><tr class="slectedmn">

		<td class="th2"><span style="float: left; line-height: 36px;">Alert:</span><textarea style="width: 94%;" name="alert" id="alert" readonly="readonly">'.$goals['Goal']['alert'].'</textarea></td>

		</tr>

		</tbody></table>	

		<table width="100%" border="1" id="w">

		<tbody><tr class="slectedmn">

		<td class="th2" colspan="5"><h3 style="text-align:left;">Warm-Up </h3>

		</td>

		</tr>

		<tr><th class="throw">Exercise</th>

		<th class="throw">Sets</th>

		<th class="throw">Duration</th>

		<th class="throw">Coaching Tip</th>

		<th class="throw"></th>

		</tr>';

		$i = 1;

		foreach ($tempwrkt as $tempwrkts) 
		{	
			if($tempwrkts['TempWorkout']['exercise_type']=='Workout')
			{
				echo '<tr id="pn-play1_'.$i.'">

				<td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplayexercise[]" id="exercise"></td>

				<td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'"  id="set" name="nplayset[]"></td>

				<td><input type="text" placeholder="Duration" value="'.$tempwrkts['TempWorkout']['duration'].'"  id="duration" name="nplayduration[]"></td>

				<td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'"  id="coaching_tip" name="nplaycoaching_tip[]"></td>

				<td style="padding: 9px 10px;"> <a onclick="removeFilea(\'pn-play1_'.$i.'\')" href="javascript:void(0);">Remove</a></td>

				</tr>';
			}
			$i++;
		}

		echo '</tbody></table>   

		<table width="100%" border="1" id="cbp">

		<tbody><tr class="slectedmn">

		<td class="th2" colspan="7"><h3 style="text-align:left;">CORE/BALANCE/PLYOMETRIC </h3>

		</td>

		</tr>

		<tr><th class="throw">Exercise</th>

		<th class="throw">Sets</th>

		<th class="throw">Reps</th>

		<th class="throw">Weight</th>

		<th class="throw">Rest</th>

		<th class="throw">Coaching Tip</th>

		<th></th><th>

		</th></tr>';

		$i=1;

		foreach ($tempwrkt as $tempwrkts) 
		{
			if($tempwrkts['TempWorkout']['exercise_type']=='CORE')
			{
				echo '<tr id="pn-play2_'.$i.'">

				<td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplay1exercise[]" id="exercise"></td>

				<td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'" id="set" name="nplay1set[]"></td>

				<td><input type="text" placeholder="Reps" value="'.$tempwrkts['TempWorkout']['rep'].'" id="rep" name="nplay1rep[]"></td>

				<td><input type="text" placeholder="Weight" value="'.$tempwrkts['TempWorkout']['temp'].'" id="temp" name="nplay1temp[]"></td>

				<td><input type="text" placeholder="Rest" value="'.$tempwrkts['TempWorkout']['rest'].'" id="rest" name="nplay1rest[]"></td>

				<td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'" id="coaching_tip" name="nplay1coaching_tip[]"></td>

				<td style="padding: 9px 10px;"> <a onclick="removeFilea(\'pn-play2_'.$i.'\')" href="javascript:void(0);">Remove</a></td>    

				</tr>';

				$i++;
			}

		}

		echo  '</tbody></table> 

		<table width="100%" border="1" id="saq">

		<tbody><tr class="slectedmn">

		<td class="th2" colspan="7"><h3 style="text-align:left;">SPEED/AGILITY/QUICKNESS </h3>

		</td>

		</tr>

		<tr><th class="throw">Exercise</th>

		<th class="throw">Sets</th>

		<th class="throw">Reps</th>

		<th class="throw">Weight</th>

		<th class="throw">Rest</th>

		<th class="throw">Coaching Tip</th>

		<th></th><th>

		</th></tr>';

		$i = 1;

		foreach ($tempwrkt as $tempwrkts) 
		{
			if($tempwrkts['TempWorkout']['exercise_type']=='SPEED')
			{
				echo '<tr id="pn-play3_'.$i.'">

				<td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplay2exercise[]" id="exercise"></td>

				<td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'" id="set" name="nplay2set[]"></td>

				<td><input type="text" placeholder="Reps"  value="'.$tempwrkts['TempWorkout']['rep'].'" id="rep" name="nplay2rep[]"></td>

				<td><input type="text" placeholder="Weight" value="'.$tempwrkts['TempWorkout']['temp'].'" id="temp" name="nplay2temp[]"></td>

				<td><input type="text" placeholder="Rest" value="'.$tempwrkts['TempWorkout']['rest'].'"  id="rest" name="nplay2rest[]"></td>

				<td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'" id="coaching_tip" name="nplay2coaching_tip[]"></td>

				<td style="padding: 9px 10px;"> <a onclick="removeFilea(\'pn-play3_'.$i.'\')" href="javascript:void(0);">Remove</a></td>

				</tr>';
				$i++;
			}
		}

		echo '</tbody></table> 

		<table width="100%" border="1" id="res">

		<tbody><tr class="slectedmn">

		<td class="th2" colspan="7"><h3 style="text-align:left;">RESISTANCE </h3>

		</td>

		</tr>

		<tr><th class="throw">Exercise</th>

		<th class="throw">Sets</th>

		<th class="throw">Reps</th>

		<th class="throw">Weight</th>

		<th class="throw">Rest</th>

		<th class="throw">Coaching Tip</th>

		<th></th>

		</tr>';

		$i = 1;

		foreach ($tempwrkt as $tempwrkts)
		{
			if($tempwrkts['TempWorkout']['exercise_type']=='RESISTANCE')
			{
				echo '<tr id="pn-play4_'.$i.'">

				<td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplay3exercise[]" id="exercise"></td>

				<td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'" id="set" name="nplay3set[]"></td>

				<td><input type="text" placeholder="Reps" value="'.$tempwrkts['TempWorkout']['rep'].'"  id="rep" name="nplay3rep[]"></td>

				<td><input type="text" placeholder="Weight" value="'.$tempwrkts['TempWorkout']['temp'].'" id="temp" name="nplay3temp[]"></td>

				<td><input type="text" placeholder="Rest" value="'.$tempwrkts['TempWorkout']['rest'].'" id="rest" name="nplay3rest[]"></td>

				<td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'" id="coaching_tip" name="nplay3coaching_tip[]"></td>

				<td style="padding: 9px 10px;"> <a onclick="removeFilea(\'pn-play4_'.$i.'\')" href="javascript:void(0);">Remove</a></td>

				</tr>'; $i++;
			}
		}

		echo '</tbody></table> 

		<table width="100%" border="1" id="cd">

		<tbody><tr class="slectedmn">

		<td class="th2" colspan="5"><h3 style="text-align:left;">COOL-DOWN </h3>

		</td>

		</tr>

		<tr><th class="throw">Exercise</th>

		<th class="throw">Sets</th>

		<th class="throw">Duration</th>

		<th class="throw">Coaching Tip</th>

		<th></th>

		</tr>';

		$i = 1;

		foreach ($tempwrkt as $tempwrkts) 
		{
			if($tempwrkts['TempWorkout']['exercise_type']=='COOL')
			{
				echo '<tr id="pn-play5_'.$i.'">

				<td><input type="text" placeholder="Exercise" value="'.$tempwrkts['TempWorkout']['exercise'].'" name="nplay4exercise[]" id="exercise"></td>

				<td><input type="text" placeholder="Sets" value="'.$tempwrkts['TempWorkout']['set'].'" id="set" name="nplay4set[]"></td>

				<td><input type="text" placeholder="Duration" value="'.$tempwrkts['TempWorkout']['duration'].'" id="duration" name="nplay4duration[]"></td>

				<td><input type="text" placeholder="Coaching Tip" value="'.$tempwrkts['TempWorkout']['coaching_tip'].'" id="coaching_tip" name="nplay4coaching_tip[]"></td>

				<td style="padding: 9px 10px;"> <a onclick="removeFilea(\'pn-play5_'.$i.'\')" href="javascript:void(0);">Remove</a></td>

				</tr>';
				$i++;
			}
		}
		echo '</tbody></table>  

		<div class="twelve already-member columns">

		<input type="submit" class="submit-nav" name="" id="svca" value="Send To Calendar">

		</div>

		</form>';
	}
	
	public function add_exercise_history_group_from_wrkout()
	{
		$this->layout = '';

		$this->render = false;

		$id = $this->Session->read('USER_ID');

		$response=array();

		$exe1Count = count($_POST['nplayexercise']); 

		$exerciseCount1 = count($_POST['nplay1exercise']);

		$exerciseCount2 = count($_POST['nplay2exercise']);

		$exerciseCount3 = count($_POST['nplay3exercise']);

		$exerciseCount4 = count($_POST['nplay4exercise']);

		$ScheduleCalendarid=trim($_POST['sessType']);		

		$checkCalArr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.id"=>$ScheduleCalendarid)));

		$startDate=$checkCalArr['ScheduleCalendar']['start'];

		$endDate=$checkCalArr['ScheduleCalendar']['end'];		
		
		$goalArr=array();

		$goalArr['Goal']['goal']=trim($_POST['goal']);

		$goalArr['Goal']['phase']=trim($_POST['phase']);

		$goalArr['Goal']['note']=trim($_POST['note']);

		$goalArr['Goal']['alert']=trim($_POST['alert']);

		$goalArr['Goal']['trainer_id']=trim($_POST['trainer_id']);

		$goalArr['Goal']['groupid']=trim($_POST['group_id']);

		$goalArr['Goal']['added_date']=date('Y-m-d H:i:s');

		$goalArr['Goal']['modified_date']=date('Y-m-d H:i:s');

		$goalArr['Goal']['start']=$startDate;

		$goalArr['Goal']['end']=$endDate;
				
		$checkCalArr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.trainer_id"=>$_POST['trainer_id'],'ScheduleCalendar.trainee_id'=>$groupid,'ScheduleCalendar.posted_by'=>'Group','ScheduleCalendar.start'=>$startDate)));

		$this->ScheduleCalendar->id=$ScheduleCalendarid;
		
		$data=array();

		$this->request->data['ScheduleCalendar']['mapwrkt']=1;

		$this->ScheduleCalendar->save($this->data['ScheduleCalendar']);

		$this->Goal->save($goalArr);
		
		for($i=0;$i<$exe1Count;$i++)
		{
			$exercisedata['WarmUps']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata['WarmUps']['groupid']=trim($_POST['group_id']);

			$exercisedata['WarmUps']['exercise']=trim($_POST['nplayexercise'][$i]);

			$exercisedata['WarmUps']['set']=trim($_POST['nplayset'][$i]);

			$exercisedata['WarmUps']['duration']=trim($_POST['nplayduration'][$i]);

			$exercisedata['WarmUps']['coaching_tip']=trim($_POST['nplaycoaching_tip'][$i]);
			//$exercisedata['WarmUps']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

			$exercisedata['WarmUps']['added_date']=date('Y-m-d H:i:s');

			$exercisedata['WarmUps']['start']=$startDate;

			$exercisedata['WarmUps']['end']=$endDate;
			
			if($exercisedata['WarmUps']['exercise']!='') 
			{
				$this->WarmUps->saveAll($exercisedata);
			}
		}
		
		for($i=0;$i<$exerciseCount1;$i++)
		{
		
			$exercisedata1['CoreBalancePlyometric']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata1['CoreBalancePlyometric']['groupid']=trim($_POST['group_id']);

			$exercisedata1['CoreBalancePlyometric']['exercise']=trim($_POST['nplay1exercise'][$i]);

			$exercisedata1['CoreBalancePlyometric']['set']=trim($_POST['nplay1set'][$i]);

			$exercisedata1['CoreBalancePlyometric']['rep']=trim($_POST['nplay1rep'][$i]);

			$exercisedata1['CoreBalancePlyometric']['rest']=trim($_POST['nplay1rest'][$i]);

			$exercisedata1['CoreBalancePlyometric']['temp']=trim($_POST['nplay1temp'][$i]);

			$exercisedata1['CoreBalancePlyometric']['coaching_tip']=trim($_POST['nplay1coaching_tip'][$i]);

			//$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

			$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d h:i:s');

			$exercisedata1['CoreBalancePlyometric']['start']=$startDate;

			$exercisedata1['CoreBalancePlyometric']['end']=$endDate;
			
			if($exercisedata1['CoreBalancePlyometric']['exercise']!='') 
			{
				$this->CoreBalancePlyometric->saveAll($exercisedata1);
			}
		}
		
		for($i=0;$i<$exerciseCount2;$i++)
		{
			$exercisedata2['SpeedAgilityQuickness']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata2['SpeedAgilityQuickness']['groupid']=trim($_POST['group_id']);

			$exercisedata2['SpeedAgilityQuickness']['exercise']=trim($_POST['nplay2exercise'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['set']=trim($_POST['nplay2set'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['rep']=trim($_POST['nplay2rep'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['rest']=trim($_POST['nplay2rest'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['temp']=trim($_POST['nplay2temp'][$i]);

			$exercisedata2['SpeedAgilityQuickness']['coaching_tip']=trim($_POST['nplay2coaching_tip'][$i]);

			//$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

			$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d H:i:s');

			$exercisedata2['SpeedAgilityQuickness']['start']=$startDate;

			$exercisedata2['SpeedAgilityQuickness']['end']=$endDate;
			
			if($exercisedata2['SpeedAgilityQuickness']['exercise']!='') 
			{
				$this->SpeedAgilityQuickness->saveAll($exercisedata2);
			}
		}
		
		for($i=0;$i<$exerciseCount3;$i++)
		{
			$exercisedata3['Resistence']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata3['Resistence']['groupid']=trim($_POST['group_id']);

			$exercisedata3['Resistence']['exercise']=trim($_POST['nplay3exercise'][$i]);

			$exercisedata3['Resistence']['set']=trim($_POST['nplay3set'][$i]);

			$exercisedata3['Resistence']['rep']=trim($_POST['nplay3rep'][$i]);

			$exercisedata3['Resistence']['rest']=trim($_POST['nplay3rest'][$i]);

			$exercisedata3['Resistence']['temp']=trim($_POST['nplay3temp'][$i]);

			$exercisedata3['Resistence']['coaching_tip']=trim($_POST['nplay3coaching_tip'][$i]);
			//$exercisedata3['Resistence']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

			$exercisedata3['Resistence']['added_date']=date('Y-m-d h:i:s');

			$exercisedata3['Resistence']['start']=$startDate;

			$exercisedata3['Resistence']['end']=$endDate;

			if($exercisedata3['Resistence']['exercise']!='') 
			{
				$this->Resistence->saveAll($exercisedata3);
			}
		}
		for($i=0;$i<$exerciseCount4;$i++)
		{
			$exercisedata4['CoolDown']['trainer_id']=trim($_POST['trainer_id']);

			$exercisedata4['CoolDown']['groupid']=trim($_POST['group_id']);

			$exercisedata4['CoolDown']['exercise']=trim($_POST['nplay4exercise'][$i]);

			$exercisedata4['CoolDown']['set']=trim($_POST['nplay4set'][$i]);

			$exercisedata4['CoolDown']['duration']=trim($_POST['nplay4duration'][$i]);

			$exercisedata4['CoolDown']['coaching_tip']=trim($_POST['nplay4coaching_tip'][$i]);

			//$exercisedata4['CoolDown']['added_date']=date('Y-m-d',strtotime(trim($_POST['exdate'])));

			$exercisedata4['CoolDown']['added_date']=date('Y-m-d h:i:s');

			$exercisedata4['CoolDown']['start']=$startDate;

			$exercisedata4['CoolDown']['end']=$endDate;
			
			if($exercisedata4['CoolDown']['exercise']!='') 
			{
				$this->CoolDown->saveAll($exercisedata4);
			}
		}
		$rddate=date('Y-m-d',strtotime($endDate));
		
		$response = array("responseclassName"=>"nSuccess","errorMsg"=>"You have assigned a workout to the Group Successfully.");
		
		echo json_encode($response);
		
		exit;		
	}
	
	
	
	
	
	public function newpayment()
		{
			$emailtypesend = "Notification of Subscription Plan Activation";
			
			$ManagemaildetailInfo=$this->Managemail->find("first",array("conditions"=>array("Managemail.mails_type"=>$emailtypesend)));
			
			/*echo '<pre>';print_r($ManagemaildetailInfo);echo '</pre>';die();*/

			$this->layout='';

			$this->autoRender=false;

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$uid = $this->Session->read('USER_ID');	

			$id=trim($_POST['subsplanid']);
			//echo "<pre>";print_r($_POST);
			
			$cnumber=trim($_POST['data']['Trainer']['cardnumber']);
			
			$cNum = 'XXXXXXXXXXXX'.substr($cnumber,-4);
			
			$exmonth=trim($_POST['data']['Trainer']['exmonth']);
			
			$exyear=trim($_POST['data']['Trainer']['exyear']);
			
			$fcname=trim($_POST['data']['Trainer']['firstcardname']);
			
			$flname=trim($_POST['data']['Trainer']['lastcardname']);
			
			$temail=trim($_POST['data']['Trainer']['email']);
			
			$subtype=trim($_POST['data']['Trainer']['paymentmode']);
			
			$address=trim($_POST['data']['Trainer']['address1']);
			
			$city=trim($_POST['data']['Trainer']['city']);
			
			$state=trim($_POST['data']['Trainer']['state']);
			
			$zip=trim($_POST['data']['Trainer']['zip']);
			
			$phone=trim($_POST['data']['Trainer']['phone']);
			
			$tamount=trim($_POST['data']['Trainer']['total']);
			
			$coupon=trim($_POST['data']['Trainer']['coupon_code']);		

			if($coupon != '')
			{
				$couponappl = $coupon;
			}
			else
			{
				$couponappl = '---';
			}			
			
			$datetum = new DateTime();
						
			$invoice = $datetum->getTimestamp();
			
			
			
			if($id!='' && $uid!='' && $subtype=='Monthly')
			{
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
				
					$SubscriptionInfo=$this->Subscription->find("first",array("conditions"=>array('Subscription.id'=>$id)));
					
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

					$amount = $tamount; 
					
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
					 //echo $content;
					//send the xml via curl

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

							$aa['Payment']['paymenttype']              = $SubscriptionInfo['Subscription']['plan_type'];

							$aa['Payment']['paymentdate']              = date('Y-m-d H:i:s');

							$aa['Payment']['nextbillingdate']              = date('Y-m-d',strtotime("+1 months"));	
							
							$aa['Payment']['payusertype']              = "Trainer";

							//$aa['User']['ftext']               = $text;

							/* $this->User->set('status', '0');

							 $this->User->set('smonth', date('Y-m-d'));

							 $this->User->set('emonth', date('Y-m-d',strtotime("+1 months")));*/
							 
							/*print_r($aa);

							die();*/
							
							
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
							
							$cc2[$dbusertype]['after_sub_trial_end']=0;
							
							$cc2[$dbusertype]['club_cancel_status']=0;				

							$this->$dbusertype->save($cc2);							

							$ufullname=ucwords($setSpecalistArr[$dbusertype]['full_name']);

							// send password on the registered e-mail address

							$to      = $temail;

							//$to      = 'synapseindia8@gmail.com';

							$subject = $ManagemaildetailInfo['Managemail']['subject'];

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
							
							$newpaymentdate = date("m/d/Y", strtotime($aa['Payment']['paymentdate']));
							
							$newnextbillingdate = date("m/d/Y", strtotime($aa['Payment']['nextbillingdate']));
							
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
							
							$newpaymentdate = date("m/d/Y", strtotime($aa['Payment']['paymentdate']));
							
							$newnextbillingdate = date("m/d/Y", strtotime($aa['Payment']['nextbillingdate']));
							
							$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$ufullname.'!</p>
							
							<p>Congratulations!  Your subscription plan for Personal Training Partners has been activated.  Thank you!  We are looking forward to serving you and helping you grow your business.</p>
							
							<p>Please find your Subscription Details below:</p>
							
							<p>Subscription Plan: '.$aa['Payment']['subscriptionplan'].'<br/>

						   Amount: '.$aa['Payment']['amount'].'<br/>

						   Cycle: '.$aa['Payment']['paymenttype'].'<br/>

						   Payment Date: '.$newpaymentdate.'<br/>

						   Next Billing Date: '.$newnextbillingdate.'<br/>
						
							<br/>
				   
							'.$ManagemaildetailInfo['Managemail']['content'].'<br />
							
							</p>
							</td></tr><tr><td><br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
							
							
							
							
							
							//NEW MESSAGE START//
							
							$content2 = '<html><body><div style="width:700px; text-align:center; border:1px solid #21aded;">
							<div style="background:#21aded;height:30px; text-align:left;"><div align="center">';
							
							
							if($setTrainerArr)
							{
								//$content.='<img width="75" height="76" src="'.$this->config['url'].'uploads/'.$setTrainerArr['Trainer']['logo'].'"/>';	

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
								
								<div style="font-size:20px; font-weight:bold; margin:30px 0 0 0">
									Charges
								</div>
								
								<div style="clear:both"></div>
								
								<div style="float:left;width:150px;"> 
									<p style="font-weight:bold; font-size:18px; text-align:center;color:#999999;">
									Item </p>
									<p style="text-align:center;">Personal Trainer Subscription - '.$aa['Payment']['subscriptionplan'].'</p>
								</div>
								
								<div style="float:left;width:150px; margin: 0 0 0 10px;"> 
									<p style="font-weight:bold; font-size:18px;text-align:center;color:#999999;">
									Date </p>
									<p style="text-align:center;">'.$upnewpaymentdate.' -  '.$upnewnextbillingdate.'</p>
								</div>
								
								<div style="float:left;width:150px; margin: 0 0 0 10px;"> 
									<p style="font-weight:bold; font-size:18px;text-align:center;color:#999999;">
									Price x Qty </p>
									<p style="text-align:center;">$'.$tamount.' x 1</p>
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
								
								<div style="font-size:20px; font-weight:bold; margin:15px 0 0 0">
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
								
								<p style="text-align:center; font-size:16px; font-style:italic">Thank you for being a PTP customer, we appreciate your business!</p>
							
								<p style="text-align:left; font-size:16px; font-style:italic">If you have any questions or concerns about this invoice or your services, don’t hesitate to contact us at info@ptpfitpro.com.</p>
								
								
							</div>
							
							
							
							
							
							
							</div></body></html>';
							
							
							
							$this->sendEmailMessageSubsc(trim($to),$subject,$content2,null,null);
							//NEW MESSAGE END//
							if($this->sendEmailMessageSubsc(trim($to),$subject,$content,null,null))
							{	
								echo 'Your Subscription plan has been upgraded successfully, we have sent detail on your registered email address. Please check your emaill account.';
								
								$this->Session->setFlash('Thanks, your subscription has been activated.');

								$this->redirect('/home/index/');
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

					$amount = $tamount; 
					
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
					 //echo $content;
					//send the xml via curl

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

							$aa['Payment']['paymenttype']              = $SubscriptionInfo['Subscription']['plan_type'];
							
							$aa['Payment']['invoice']              = $invoice;

							$aa['Payment']['paymentdate']              = date('Y-m-d H:i:s');

							$aa['Payment']['nextbillingdate']              = date('Y-m-d',strtotime("+12 months"));	
							
							$aa['Payment']['payusertype']              = "Trainer";

							//$aa['User']['ftext']               = $text;

							/* $this->User->set('status', '0');

							 $this->User->set('smonth', date('Y-m-d'));

							 $this->User->set('emonth', date('Y-m-d',strtotime("+1 months")));*/
							 
							/*print_r($aa);

							die();*/
							
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
							
							$cc2[$dbusertype]['after_sub_trial_end']=0;
							
							$cc2[$dbusertype]['club_cancel_status']=0;				

							$this->$dbusertype->save($cc2);							

							$ufullname=ucwords($setSpecalistArr[$dbusertype]['full_name']);

							// send password on the registered e-mail address

							$to      = $temail;

							//$to      = 'synapseindia8@gmail.com';

							$subject = $ManagemaildetailInfo['Managemail']['subject'];

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
							
							$newpaymentdate = date("m/d/Y", strtotime($aa['Payment']['paymentdate']));
							
							$newnextbillingdate = date("m/d/Y", strtotime($aa['Payment']['nextbillingdate']));
							
							$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$ufullname.'!</p>
							
							<p>Congratulations!  Your subscription plan for Personal Training Partners has been activated.  Thank you!  We are looking forward to serving you and helping you grow your business.</p>
							
							<p>Please find your Subscription Details below:</p>
							
							<p>Subscription Plan: '.$aa['Payment']['subscriptionplan'].'<br/>

						   Amount: '.$aa['Payment']['amount'].'<br/>

						   Cycle: '.$aa['Payment']['paymenttype'].'<br/>

						   Payment Date: '.$newpaymentdate.'<br/>

						   Next Billing Date: '.$newnextbillingdate.'<br/>
						
							<br/>
				   
							'.$ManagemaildetailInfo['Managemail']['content'].'<br />
							
							</p>
							</td></tr><tr><td><br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
							
							
							
							
							
							//NEW MESSAGE START//
							
							$content2 = '<html><body><div style="width:700px; text-align:center; border:1px solid #21aded;">
							<div style="background:#21aded;height:30px; text-align:left;"><div align="center">';
							
							
							if($setTrainerArr)
							{
								//$content.='<img width="75" height="76" src="'.$this->config['url'].'uploads/'.$setTrainerArr['Trainer']['logo'].'"/>';	

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
								
								<div style="font-size:20px; font-weight:bold; margin:30px 0 0 0; text-align:left;">
									Charges
								</div>
								
								<div style="clear:both"></div>
								
								<div style="float:left;width:150px;"> 
									<p style="font-weight:bold; font-size:18px; text-align:center;color:#999999;">
									Item </p>
									<p style="text-align:center;">Personal Trainer Subscription - '.$aa['Payment']['subscriptionplan'].'</p>
								</div>
								
								<div style="float:left;width:150px; margin: 0 0 0 10px;"> 
									<p style="font-weight:bold; font-size:18px;text-align:center;color:#999999;">
									Date </p>
									<p style="text-align:center;">'.$upnewpaymentdate.' -  '.$upnewnextbillingdate.'</p>
								</div>
								
								<div style="float:left;width:150px; margin: 0 0 0 10px;"> 
									<p style="font-weight:bold; font-size:18px;text-align:center;color:#999999;">
									Price x Qty </p>
									<p style="text-align:center;">$'.$tamount.' x 1</p>
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
								
								<p style="text-align:center; font-size:16px; font-style:italic">Thank you for being a PTP customer, we appreciate your business!</p>
							
								<p style="text-align:left; font-size:16px; font-style:italic">If you have any questions or concerns about this invoice or your services, don’t hesitate to contact us at info@ptpfitpro.com.</p>
								
								
							</div>
							
							
							
							
							
							
							</div></body></html>';
							
							
							
							$this->sendEmailMessageSubsc(trim($to),$subject,$content2,null,null);
							//NEW MESSAGE END//
							
							
							if($this->sendEmailMessageSubsc(trim($to),$subject,$content,null,null))
							{	
								echo 'Your Subscription plan has been upgraded successfully, we have sent detail on your registered email address. Please check your emaill account.';
								
								$this->Session->setFlash('Thanks, your subscription has been activated.');

								$this->redirect('/home/index/');
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

}