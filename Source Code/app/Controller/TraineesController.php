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

	class TraineesController extends AppController {



		public $name 		= 'Trainees';

		public $helpers 	= array('Html','Session','Cksource','GoogleChart','Csv');

		public $uses 		= array('Country','Member','Club','Trainer','Trainee','TraineeClub','TraineeTrainer','SevensiteBodyfat','ThreesiteBodyfat','BodymassIndex','EstimatedenergyRequirement','ScheduleCalendar','Certification','CertificationOrganization','Degree','FoodNutritionLog','AdddailyNutritionDiary','Goal','ExerciseHistorys','WarmUps','CoreBalancePlyometric','SpeedAgilityQuickness','Resistence','CoolDown','FoodUsda','Emessage','MessageBoard','Measurement','HelpGuide','TraineesessionPurchase','SessionPurchase','GroupMember');

		public $components  = array('Upload');			

		public $facebook;

		public $amazon;

		

			

		public function scheduling_calendar()
		{		
			$this->checkUserLogin();

			$this->layout = "homelayout";		

			$this->set("leftcheck",'homescheduling_calendar');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$uid = $this->Session->read('USER_ID');
			
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

			$this->set("setSpecalistArr",$setSpecalistArr);
			
			//echo $setSpecalistArr['Trainee']['trainer_id'];			
			
			//echo"<pre>";print_r($groupmemData);echo"</pre>";
			
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			$sccondition=array();

			if(isset($dbusertype) && $dbusertype=='Trainer')
			{
				$sccondition=array('ScheduleCalendar.trainer_id'=>$uid);
			}

			if(isset($dbusertype) && $dbusertype=='Trainee')
			{
				$sccondition=array('ScheduleCalendar.trainee_id'=>$uid,'ScheduleCalendar.status'=>1);	
			}

			$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>$sccondition,'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.appointment_type','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.posted_by')));
						
			$mainData = array();
			$i = 0;
			foreach($scheduleCalendars as $value){
			$mainData[$i]['ScheduleCalendar']['id'] = $value['ScheduleCalendar']['id'];
			$mainData[$i]['ScheduleCalendar']['title'] = $value['ScheduleCalendar']['title'];
			$mainData[$i]['ScheduleCalendar']['appointment_type'] = $value['ScheduleCalendar']['appointment_type'];
			$mainData[$i]['ScheduleCalendar']['description'] = $value['ScheduleCalendar']['description'];
			$mainData[$i]['ScheduleCalendar']['trainer_id'] = $value['ScheduleCalendar']['trainer_id'];
			$mainData[$i]['ScheduleCalendar']['trainee_id'] = $value['ScheduleCalendar']['trainee_id'];
			$mainData[$i]['ScheduleCalendar']['start'] = $value['ScheduleCalendar']['start'];
			$mainData[$i]['ScheduleCalendar']['end'] = $value['ScheduleCalendar']['end'];
			$mainData[$i]['ScheduleCalendar']['posted_by'] = $value['ScheduleCalendar']['posted_by'];
			$i++;
			}
			
			$groupmemData=$this->GroupMember->find('all',array("conditions"=>array('GroupMember.client_id'=>$uid,'GroupMember.trainer_id'=>$setSpecalistArr['Trainee']['trainer_id'])));
			
			$this->set("groupmemData",$groupmemData);
			
			//echo"<pre>";print_r($groupmemData);echo"</pre>";
			
			foreach($groupmemData as $gd)
			{
				$sccondition1=array('ScheduleCalendar.trainee_id'=>$gd['GroupMember']['group_id'],'ScheduleCalendar.status'=>1,'ScheduleCalendar.posted_by'=>Group);
				
				$scheduleCalendars1=$this->ScheduleCalendar->find('all',array('conditions'=>$sccondition1,'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.appointment_type','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.posted_by')));
						
			
			
			foreach($scheduleCalendars1 as $value){
			$mainData[$i]['ScheduleCalendar']['id'] = $value['ScheduleCalendar']['id'];
			$mainData[$i]['ScheduleCalendar']['title'] = $value['ScheduleCalendar']['title'];
			$mainData[$i]['ScheduleCalendar']['appointment_type'] = $value['ScheduleCalendar']['appointment_type'];
			$mainData[$i]['ScheduleCalendar']['description'] = $value['ScheduleCalendar']['description'];
			$mainData[$i]['ScheduleCalendar']['trainer_id'] = $value['ScheduleCalendar']['trainer_id'];
			$mainData[$i]['ScheduleCalendar']['trainee_id'] = $value['ScheduleCalendar']['trainee_id'];
			$mainData[$i]['ScheduleCalendar']['start'] = $value['ScheduleCalendar']['start'];
			$mainData[$i]['ScheduleCalendar']['end'] = $value['ScheduleCalendar']['end'];
			$mainData[$i]['ScheduleCalendar']['posted_by'] = $value['ScheduleCalendar']['posted_by'];
			$i++;
			}
			}
			$this->set("mainData",$mainData);
			$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

			$this->set("degrees",$this->Degree->find('all',array('conditions'=>array('Degree.status'=>1),'fields'=>array('Degree.id','Degree.name'))));	

			$this->set("certificationsorg",$this->CertificationOrganization->find('all',array('conditions'=>array('CertificationOrganization.status'=>1),'fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));	

			

			$club_trai_id = $setSpecalistArr['Trainee']['club_id'];
			$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
			$this->set("setSpecalistArr1",$setSpecalistArr1);
		}

		

			

		public function evdetail()

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

		

		if($schcaldt['ScheduleCalendar']['trainee_id'] !='')

		{

			$sccondition9=array('Trainee.id'=>$schcaldt['ScheduleCalendar']['trainee_id']);

			$trainedt=$this->Trainee->find('first',array('conditions'=>$sccondition9,'fields'=>array('Trainee.id','Trainee.first_name','Trainee.last_name','Trainee.photo')));

			$this->set("trainedt",$trainedt);

		}

		

		$sccondition91=array('Trainer.id'=>$schcaldt['ScheduleCalendar']['trainer_id']);

			$trainerdt=$this->Trainer->find('first',array('conditions'=>$sccondition91,'fields'=>array('Trainer.id','Trainer.first_name','Trainer.last_name','Trainer.logo')));

			$this->set("trainerdt",$trainerdt);

		

		$this->set("scheduleCalendars",$schcaldt);	

		

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

		

		public function daily_nutrition_diary($clientid=null,$datva=null)

		{

			$this->layout = "homelayout";	 

		    $this->set("leftcheck",'daily_nutrition_diary');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);
			
			$club_trai_id = $setSpecalistArr['Trainee']['club_id'];
		$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
		$this->set("setSpecalistArr1",$setSpecalistArr1);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			

			$clientid=base64_encode($id);

			

			if($clientid!='')

			{

				$this->set("clientid",base64_decode($clientid));

			}

			$datefd='';

			if($datva!='')

			{

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

			$surl=$this->config['url'].'trainees/daily_nutrition_diary/'.$clientid;

			$this->set("surl",$surl);

			$clid=base64_decode($clientid);

			

						

//			$breakfast=$this->FoodNutritionLog->find("all",array("conditions"=>array("FoodNutritionLog.type"=>'Breakfast'), 'order' => array('FoodNutritionLog.id' => 'DESC')));

//		 

//		  $this->set("breakfasts",$breakfast);

		  

		  $breakfast=$this->FoodUsda->find("all",array("conditions"=>array("FoodUsda.type"=>'Lunch'), 'order' => array('FoodUsda.id' => 'DESC')));

		  

		  $this->set("breakfasts",$breakfast);

		  

		  $setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clid)));

				

				$trainer_id=$setClientArr['Trainee']['trainer_id'];

		       

		      	$this->set("trainer_id",$trainer_id);

		  

		  $logdata=$this->AdddailyNutritionDiary->find("all",array("conditions"=>array("AdddailyNutritionDiary.client_id"=>$clid,"AdddailyNutritionDiary.trainer_id"=>$setSpecalistArr[$dbusertype]['trainer_id'],"AdddailyNutritionDiary.foodlogdate"=>$datefd), 'order' => array('AdddailyNutritionDiary.id' => 'DESC')));

		 

		  $this->set("logdata",$logdata);

		  

			

			

		}

		
		
		public function purchasehistory($clientid=null)

		{	
			
			$this->checkUserLogin();

			$this->layout = "homelayout";	

		    $this->set("leftcheck",'homemy_clients');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);
			$trainer_s_id = $setSpecalistArr['Trainee']['trainer_id'];
			
			$club_trai_id = $setSpecalistArr['Trainee']['club_id'];
			$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
			$this->set("setSpecalistArr1",$setSpecalistArr1);
			
			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));
			//$traneesdata=$this->TraineesessionPurchase->find('all',array('conditions'=>array('TraineesessionPurchase.trainee_id'=>$id)));

			//$this->set("traneesdata",$traneesdata);
			
			$traneesdata=$this->Trainee->find('list',array('conditions'=>array('Trainee.id'=>$id,'Trainee.status'=>1),'fields'=>array('Trainee.id','Trainee.full_name','Trainee.address','Trainee.email'),'order'=>array('Trainee.last_name ASC'),));
			
			$this->set("tranee",$traneesdata);
			
			//echo "<pre>";print_r($traneesdata);echo "</pre>";
			//die();

		    $sccondition=array('TraineesessionPurchase.trainee_id'=>$id);
			
			
			//echo "<pre>";print_r($sccondition);echo "</pre>";
            if(isset($clientid))

			{

              $this->set("clientid",$clientid);

			  $sccondition=array('TraineesessionPurchase.trainee_id'=>$id,'TraineesessionPurchase.trainee_id'=>$clientid);

			}

	    	   

			$this->TraineesessionPurchase->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id"))));

		    $this->TraineesessionPurchase->bindModel(array("belongsTo"=>array("Workout"=>array("foreignKey"=>"SessTypeId"))));
			
			
			 //$results= $this->SessionPurchase->find('all', array('fields'=> array('SessionPurchase.*','TraineesessionPurchase.*'), 'joins'=> array(array('table'=>'traineesession_purchases', 'type'=>'INNER','conditions'=>array('SessionPurchase.client_id=TraineesessionPurchase.trainee_id')))));
			 
			/*$this->SessionPurchase->find('all', array('joins' => array(array('table' => 'traineesession_purchases',
                                   'alias' => 'TraineesessionPurchase',
                                   'type' => 'INNER',
                                   'conditions' => array('TraineesessionPurchase.trainee_id = SessionPurchase.client_id')))));*/
			
			
			 
		   

			//$this->TraineesessionPurchase->find('all', array('contain' => array('SessionPurchase')'conditions' => array('TraineesessionPurchase.id' => 24)));
			
			//SELECT session_purchases.client_id FROM session_purchases LEFT JOIN traineesession_purchases ON session_purchases.client_id=traineesession_purchases.trainee_id;
			


			
			
		    $this->TraineesessionPurchase->recursive = 2;

		    	   

		    $tranrsdata=$this->TraineesessionPurchase->find('all',array('conditions'=>$sccondition));	

		    	

			

			$this->set("trainees",$tranrsdata);
			
			//$session_purc_data = $this->SessionPurchase->query('SELECT * FROM session_purchases, traineesession_purchases WHERE session_purchases.client_id = traineesession_purchases.trainee_id AND session_purchases.session_id = traineesession_purchases.SessTypeId AND session_purchases.trainer_id = traineesession_purchases.trainer_id' );
			
			//$session_purc_data = $this->SessionPurchase->query('SELECT * FROM session_purchases WHERE session_purchases.client_id = traineesession_purchases.trainee_id' );
			//echo $id;
			
			//$session_purc_data= $this->SessionPurchase->find('all', array('fields'=> array('SessionPurchase.*','w.workout_name'), 'joins'=> array(array('table'=>'workouts', 'type'=>'inner','conditions'=>array('sp.session_id=w.id','sp.trainer_id'=>$trainer_s_id,'sp.client_id'=>$id)))));
						
			//$session_purc_data = $this->SessionPurchase->query('SELECT sp.*,w.workout_name FROM `session_purchases` as sp, workouts as w, traineesession_purchases as t WHERE sp.client_id=t.trainee_id AND sp.trainer_id=t.trainer_id AND sp.session_id=w.id');
			
			//$session_purc_data = $this->SessionPurchase->query("SELECT sp.*,w.workout_name FROM `session_purchases` as sp, workouts as w WHERE sp.client_id='$id' AND sp.trainer_id='$trainer_s_id' AND sp.session_id=w.id");
			
			
			
			
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
                        'SessionPurchase.client_id' => $id,'SessionPurchase.trainer_id'=>$trainer_s_id),
                   
                    'fields' => array("SessionPurchase.*","workout.workout_name"),
                )    
                );

			
			/*print "<pre>";
			print_r($session_purc_data1);
			print "</pre>";
			
			die();*/
			
			$this->set("session_purc_data",$session_purc_data);
			
			
			
			
			//echo "<pre>";print_r($session_purc_data); echo "</pre>";
			//print_r($results);
			//die();
		}		
		
		

		public function add_daily_diary()

		{

		  $this->layout = '';

			$this->render = false;

			$id = $this->Session->read('USER_ID');

			//"food_type":"Breakfast","food_list":"Pasta","food_qty":"1","client_id":"2"

				$fooddata=array();

				$response=array();

				

			if( $_POST['food_id']!='' && $_POST['food_list']!='' && $_POST['food_qty']!='' && $_POST['client_id']!='')

			{



				$fdtype=trim($_POST['food_id']);

				

				$fdname=trim($_POST['food_list']);

				$fddate=trim($_POST['fooddate']);

				$trainer_id = $_POST['trainer_id'];

				

				

				

				$fooddata2=$this->FoodNutritionLog->find("first",array("conditions"=>array("FoodNutritionLog.type"=>$fdtype,"FoodNutritionLog.name"=>$fdname), 'order' => array('FoodNutritionLog.name' => 'ASC')));

				

				

				$fooddata['AdddailyNutritionDiary']['client_id']=trim($_POST['client_id']);

				$fooddata['AdddailyNutritionDiary']['trainer_id']=trim($trainer_id);

				$fooddata['AdddailyNutritionDiary']['food_type']=trim($fdtype);

				$fooddata['AdddailyNutritionDiary']['food_name']=trim($fdname);

				$fooddata['AdddailyNutritionDiary']['quantity']=trim($_POST['food_qty']);

				$fooddata['AdddailyNutritionDiary']['calorie']=trim($fooddata2['FoodNutritionLog']['calories']);

				$fooddata['AdddailyNutritionDiary']['carb']=trim($fooddata2['FoodNutritionLog']['carbs']);

				$fooddata['AdddailyNutritionDiary']['fat']=trim($fooddata2['FoodNutritionLog']['fat']);

				$fooddata['AdddailyNutritionDiary']['protein']=trim($fooddata2['FoodNutritionLog']['protein']);

				$fooddata['AdddailyNutritionDiary']['mineral']=trim($fooddata2['FoodNutritionLog']['mineral']);

				$fooddata['AdddailyNutritionDiary']['vitamin']=trim($fooddata2['FoodNutritionLog']['vitamin']);

				$fooddata['AdddailyNutritionDiary']['status']=1;

				$fooddata['AdddailyNutritionDiary']['foodlogdate']=date('Y-m-d', strtotime("$fddate"));

				

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

		

		public function postmessage()

		{

			

			$this->layout = "";

			$this->autoRender=false;

			$uid = $this->Session->read('USER_ID');

			$sentfor=trim($_REQUEST['sentfor']);

			$subject=trim($_REQUEST['subject']);

			$message2=trim($_REQUEST['message']);

			$sendto=trim($_REQUEST['sendto']);

			$mestype=trim($_REQUEST['mestype']);

			$setSpecalistArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$uid)));

			if($sentfor=='Trainer')

			{

				//$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$uid)));

				 $traineeDataArr=$this->Trainer->find('first',array('conditions'=>array('Trainer.id'=>$sendto),'fields'=>array('Trainer.id','Trainer.username','Trainer.email','Trainer.phone','Trainer.first_name','Trainer.last_name')));	

				$to=$traineeDataArr['Trainer']['email'];
				
				$toname=$traineeDataArr['Trainer']['first_name'].$traineeDataArr['Trainer']['last_name'];

				$from=$setSpecalistArr['Trainee']['email'];

				$fromName=$setSpecalistArr['Trainee']['full_name'];
				
				$fromNameEmail= EMAILNAME;

				

				

				

				

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td>

				<p> '.$fromName.' (<a href="mailto:'.$from.'" target="_top">'.$from.'</a>) has sent you a message. </p>

				<p>'.$message2.' </p>

				

				</td></tr><tr><td><br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					

					

					$dataSet['Emessage']['sender_id']=$uid;

					$dataSet['Emessage']['sender_type']='Client';

					$dataSet['Emessage']['receiver_id']=$sendto;

					$dataSet['Emessage']['receiver_type']=$sentfor;

					$dataSet['Emessage']['subject']=$subject;

					$dataSet['Emessage']['detail']=$message2;

					$dataSet['Emessage']['usefor']=$mestype;

					$dataSet['Emessage']['sent_date']=date('Y-m-d H:i:s');

					

					$msgdetail=$subject;

					

					if($this->Emessage->save($dataSet)) {	

						

							//$this->sendEmailMessage(trim($to),$subject,$content,null,null);	
							
							$this->send_email_communication_trainee(trim($to),$toname,$subject,$content,$fromName,$from,null,null);

							

			if($mestype=='T')

			{

				  App::import('Vendor', 'Twilio', array('file' => 'twilio'.DS.'Services'.DS.'Twilio.php'));

$account_sid = Configure::read("twilio_details.account_sid");

$auth_token = Configure::read("twilio_details.auth_token");

$fromno = Configure::read("twilio_details.fromno");

$phone1=$traineeDataArr['Trainee']['phone'];

$client = new Services_Twilio($account_sid, $auth_token);







 if(trim($phone1)!='' && strlen(trim($phone1))>=10)

 {

 //exit;
$msgdetail =$msgdetail.'. This is NoReply Message.';
	try {  $sms = $client->account->sms_messages->create(

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

		
		
		public function send_email_communication_trainee($to, $toname, $subject, $message, $fromname, $from, $templete, $layout){
		$this->Email->template($templete, $layout)
		->emailFormat('html')
		->from(array(FROM_EMAIL => $this->config['base_title_trainer']))
		->to(array("$to" => "$toname"))
		->subject(trim($subject))
		->replyTo(array(FROM_EMAIL => $this->config['base_title_trainer']));
		if($this->Email->send($message)){
			return true;
		}else{
			return false;
		}
	}
		

		public function communication_center(){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'communication_center');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		  $this->set("setSpecalistArr",$setSpecalistArr);
		  
		  $club_trai_id = $setSpecalistArr['Trainee']['club_id'];
		$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
		$this->set("setSpecalistArr1",$setSpecalistArr1);

		  

		    $this->set("emessageclientArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'Trainer','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));	

		     

		     $this->set("emessageclientsentArr",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Client','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC'))));

		     

		     

		      $this->set("emessageclientArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'Trainer','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));	

		     

		     $this->set("emessageclientsentArrTxt",$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Client','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC'))));

		     

		     

		     $trid=$setSpecalistArr['Trainee']['trainer_id'];

		     

		     $clientDataArr=$this->Trainer->find('list',array('conditions'=>array('Trainer.id'=>$trid),'fields'=>array('Trainer.id','Trainer.full_name')));

		      $this->set("clientDataArr",$clientDataArr);

		  

		      

		       $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id","fields"=>array("Trainer.full_name","Trainer.website_logo","Trainer.logo"),"conditions"=>array()))));

		      $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainee"=>array("foreignKey"=>"client_id","fields"=>array("Trainee.full_name","Trainee.photo"),"conditions"=>array()))));

		      $this->MessageBoard->recursive = 2;

		      

		       $this->set("emessageArrIMSesTxt",$this->MessageBoard->find('all',array('conditions'=>array('MessageBoard.client_id'=>$uid,'MessageBoard.parent_message'=>0,'MessageBoard.status'=>1),'order'=>array('MessageBoard.id DESC'))));

		         $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainer"=>array("foreignKey"=>"trainer_id","fields"=>array("Trainer.full_name","Trainer.website_logo","Trainer.logo"),"conditions"=>array()))));

		      $this->MessageBoard->bindModel(array("belongsTo"=>array("Trainee"=>array("foreignKey"=>"client_id","fields"=>array("Trainee.full_name","Trainee.photo"),"conditions"=>array()))));

		      $this->MessageBoard->recursive = 2;

		        $this->set("emessageArrIMSesTxt2",$this->MessageBoard->find('all',array('conditions'=>array('MessageBoard.client_id'=>$uid,'MessageBoard.parent_message >'=>0,'MessageBoard.status'=>1),'order'=>array('MessageBoard.id ASC'))));

		     

		

		      

		  

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

	

		public function admin_add(){

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name','Club.email'),'order' => array('Club.club_name' => 'ASC'))));	

			$this->set("trainers",$this->Trainer->find('list',array('fields'=>array('Trainer.id','Trainer.full_name','Trainer.email'),'order' => array('Trainer.first_name' => 'ASC'))));

			

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

					    

					    $this->request->data["Trainee"]["username"] 	    = $this->data["Trainee"]["email"];

					    $this->request->data["Trainee"]["created_date"] 	    = date("Y-m-d h:i:s");

						$this->request->data["Trainee"]["update_date"] 		    = date("Y-m-d h:i:s");	
						
						$this->request->data["Trainee"]["status"] = 1;	

					    	

						if($this->Trainee->save($this->data['Trainee'])) {		

							

							$lastId = $this->Trainee->getLastInsertID();

							

							foreach($this->data['TraineeClub_Id'] as $val)

							{

								$allTask = $this->Trainee->query("insert into trainee_clubs set trainee_id ='$lastId', club_id='$val'");

							}

							

							foreach($this->data['TraineeTrainer'] as $tran)

							{

								$allTask = $this->Trainee->query("insert into trainee_trainers set trainee_id ='$lastId', trainerId='$tran'");

							}

									

							$this->Session->setFlash('Client has been created successfully.');

							$this->redirect('/admin/trainees/');

						} else {

							$this->Session->setFlash('Some error has been occured. Please try again.');

						}

				}	

			}

		}

		

		public function admin_view(){

		

			if(!empty($this->params["pass"][0])) {

				$this->set("traineeInfo",$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$this->params["pass"][0]))));

				$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));	

			}else{

				$this->redirect($_SERVER["HTTP_REFERER"]);

			}	

		}

		

		

		public function admin_edit($id=null)

		{

			

			//pr($this->Trainee->getAllTrainee());

			//die;

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

			$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name','Club.email'),'order' => array('Club.club_name' => 'ASC'))));

			$this->set("trainers",$this->Trainer->find('list',array('fields'=>array('Trainer.id','Trainer.full_name','Trainer.email'),'order' => array('Trainer.first_name' => 'ASC'))));

			

			

			

		

			$selecteddClub=$this->Trainee->find('all',array('conditions'=>array('Trainee.id'=>$id)));

			//pr($selectedClub);

			$myarray=array();

			foreach ($selecteddClub[0]['Club'] as $clubs){

				$myarray[$clubs['id']]=$clubs['club_name'];

				

			}

			$this->set("selectedClub",$myarray);

			

			

		

			$myarray1=array();

			foreach ($selecteddClub[0]['Trainer'] as $clubs){

				$myarray1[$clubs['id']]=$clubs['full_name'];

				

			}

			$this->set("selectedTrainer",$myarray1);

			

			

			//pr($myarray);

			if(!empty($this->data)){

			

			//$this->Trainee->set($this->data);

			$this->Trainee->id = $id;		

			

							

			if($this->Trainee->validates()) {

				

					if(!empty($this->data['TraineeClub_Id'])) {		

							

							

							$mydata=array();

							$this->TraineeClub->deleteAll(array('TraineeClub.trainee_id' =>$id), false);

							

							foreach($this->data['TraineeClub_Id'] as $val)

							{

								

								$this->TraineeClub->query("insert into trainee_clubs set trainee_id ='$id', club_id='$val'");

								

							}



					}



					if(!empty($this->data['TraineeTrainer'])) {	

							

						$this->TraineeTrainer->deleteAll(array('TraineeTrainer.traineeId' =>$id), false);

							$trainerData=array();

							foreach($this->data['TraineeTrainer'] as $tran)

							{

								

								$this->TraineeTrainer->query("insert into trainee_trainers set traineeId ='$id', trainerId='$tran'");								

							}

						} 

				

			

				

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

				 $this->request->data["Trainee"]["username"] 	    = $this->data["Trainee"]["email"];

				$this->request->data["Trainee"]["update_date"] 		    = date("Y-m-d h:i:s");

				if($this->Trainee->save($this->data)) {

					//die();

					$this->Session->setFlash('Clients information has been updated successfully.');

					$this->redirect('/admin/trainees/');

				} else {

					$this->Session->setFlash('Some error has been occured. Please try again.');

				}

			}

			else{				

				$this->request->data["Trainee"]["photo"]=$this->request->data["Trainee"]["old_image"];				

			}				

		 } else{

				if(is_numeric($id) && $id > 0) {

						$this->Trainee->id = $id;

						$this->request->data = $this->Trainee->read();

					} else {

						$this->Session->setFlash('Invalid Trainee id.');

						$this->redirect('/admin/trainees/');

				}

			}	

		}

		

		public function admin_index($status = null)

		{

				

			$conditions = array();

			$keyword 	= ""; 

			

			if(!empty($this->data)){				

				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by email or Client Name...") ) {					

					$conditions["OR"] = array(

												"Trainee.first_name LIKE" => "%".$this->data["keyword"]."%",

												"Trainee.last_name LIKE" => "%".$this->data["keyword"]."%",

												"Trainee.email LIKE" => "%".$this->data["keyword"]."%",

												"Trainee.full_name LIKE" => "%".$this->data["keyword"]."%"

											);

					if( !empty($this->params["named"]["keyword"]) )						

						$keyword = $this->params["named"]["keyword"];					

					

				}else{						

						if( !empty($this->data['Trainee']['statusTop']) ) {

							

							$action = $this->data['Trainee']['statusTop'];

						}elseif( !empty($this->data['Trainee']['status'])) {

							$action = $this->data['Trainee']['status'];

						}

						

						if(isset($this->data['Trainee']['id']) && count($this->data['Trainee']['id']) > 0) {

							$this->update_status(trim($action), $this->data['Trainee']['id'], count($this->data['Trainee']['id']));

						} else {

							

							

							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by email or Client Name...') && $this->data["submit"]=='Search'){

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

									"Trainee.first_name LIKE" => "%".$this->params["named"]["keyword"]."%",

									"Trainee.last_name LIKE" => "%".$this->params["named"]["keyword"]."%",

									"Trainee.email LIKE" => "%".$this->params["named"]["keyword"]."%"

								);

				$keyword = $this->params["named"]["keyword"];

			}			

					

			

			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Trainee.first_name' => 'ASC'));

			$trainees = $this->paginate('Trainee'); //default take the current

			$this->set('trainees', $trainees);

			$this->set('mode', array('delete'=>'Delete'));

			$this->set('status', $status);

			$this->set('tab', '');

			$this->set('keyword', $keyword);

			

			

			$this->set('limit', $this->params['request']['paging']['Trainee']['options']['limit']);

			$this->set('page', $this->params['request']['paging']['Trainee']['options']['page']);

		}
		
		
		
		
		public function admin_unassignclient($status = null)

		{			
			$conditions = array();

			$keyword 	= ""; 

			

			if(!empty($this->data)){				

				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by email or Client Name...") ) {					

					$conditions["OR"] = array(

												"Trainee.first_name LIKE" => "%".$this->data["keyword"]."%",

												"Trainee.last_name LIKE" => "%".$this->data["keyword"]."%",

												"Trainee.email LIKE" => "%".$this->data["keyword"]."%",

												"Trainee.full_name LIKE" => "%".$this->data["keyword"]."%"

											);

					if( !empty($this->params["named"]["keyword"]) )						

						$keyword = $this->params["named"]["keyword"];					

					

				}else{						

						if( !empty($this->data['Trainee']['statusTop']) ) {

							

							$action = $this->data['Trainee']['statusTop'];

						}elseif( !empty($this->data['Trainee']['status'])) {

							$action = $this->data['Trainee']['status'];

						}

						

						if(isset($this->data['Trainee']['id']) && count($this->data['Trainee']['id']) > 0) {

							$this->update_status(trim($action), $this->data['Trainee']['id'], count($this->data['Trainee']['id']));

						} else {

							

							

							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by email or Client Name...') && $this->data["submit"]=='Search'){

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

									"Trainee.first_name LIKE" => "%".$this->params["named"]["keyword"]."%",

									"Trainee.last_name LIKE" => "%".$this->params["named"]["keyword"]."%",

									"Trainee.email LIKE" => "%".$this->params["named"]["keyword"]."%"

								);

				$keyword = $this->params["named"]["keyword"];

			}			

					

			

			$this->paginate = array("conditions"=>array('Trainee.trainer_id'=>NULL),'limit' => '10', 'order' => array('Trainee.first_name' => 'ASC'));
			
			

			$trainees = $this->paginate('Trainee'); //default take the current

			$this->set('trainees', $trainees);
			
			/*echo "<pre>";
			print_r($trainees);
			echo "</pre>";
			die();*/
			
			$this->set('mode', array('delete'=>'Delete'));

			$this->set('status', $status);

			$this->set('tab', '');

			$this->set('keyword', $keyword);

			

			

			$this->set('limit', $this->params['request']['paging']['Trainee']['options']['limit']);

			$this->set('page', $this->params['request']['paging']['Trainee']['options']['page']);

		}
		

		

		public function index(){		

		$this->checkUserLogin();

		$this->layout = "homelayout";	

		 $this->set("leftcheck",'homeindex');	

		//echo $this->Session->read('UNAME');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

	

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		  $this->set("setSpecalistArr",$setSpecalistArr);

		$club_trai_id = $setSpecalistArr['Trainee']['club_id'];
		$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
		$this->set("setSpecalistArr1",$setSpecalistArr1);
		

		}

		

//		public function measurement_and_goal(){		

//		$this->checkUserLogin();

//		$this->layout = "homelayout";		

//		 $this->set("leftcheck",'measurement_and_goal');

//		

//		$dbusertype = $this->Session->read('UTYPE');					

//		$this->set("dbusertype",$dbusertype);

//		$uid = $this->Session->read('USER_ID');				

//		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

//	

//			

//			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

//		  $this->set("setSpecalistArr",$setSpecalistArr);

//		 

//		  

//		  $setSvftArr=$this->SevensiteBodyfat->find("first",array("conditions"=>array("SevensiteBodyfat.client_id"=>$uid), 'order' => array('SevensiteBodyfat.id' => 'DESC')));

//		 

//		  $this->set("setSvftArr",$setSvftArr);

//		  

//

//		

//		}



        public function measurement_and_goal($clientid=null){		

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'measurement_and_goal');

		$clientid=$this->Session->read('USER_ID');

		if($clientid!='')

		{

			$this->set("clientid",$clientid);

			$response=$this->Goal->find("all",array("conditions"=>array("Goal.trainee_id"=>$clientid),'order' => array('Goal.id' => 'DESC')));
		}

				

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	

		

		$this->set("uid",$uid);



		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	    $this->set("degrees",$this->Degree->find('all',array('conditions'=>array('Degree.status'=>1),'fields'=>array('Degree.id','Degree.name'))));	

	    $this->set("certificationsorg",$this->CertificationOrganization->find('all',array('conditions'=>array('CertificationOrganization.status'=>1),'fields'=>array('CertificationOrganization.id','CertificationOrganization.name'))));	

			

			

	    

	    $this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.id'=>$uid),'fields'=>array('Trainee.id','Trainee.username'))));

	    

	    

	    $setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);

		 $club_trai_id = $setSpecalistArr['Trainee']['club_id'];
		$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
		$this->set("setSpecalistArr1",$setSpecalistArr1); 

		  /* ----*/

		 

		  

		   

		 

//		  $uid2=2;

//		  $setSvftArr=$this->SevensiteBodyfat->find("first",array("conditions"=>array("SevensiteBodyfat.client_id"=>$uid2), 'order' => array('SevensiteBodyfat.id' => 'DESC')));

//		 

//		  $this->set("setSvftArr",$setSvftArr);

//		  

//		   $setThrftArr=$this->ThreesiteBodyfat->find("first",array("conditions"=>array("ThreesiteBodyfat.client_id"=>$uid2), 'order' => array('ThreesiteBodyfat.id' => 'DESC')));

//		  $this->set("setThrftArr",$setThrftArr);

//		  

//		  

//		   $setBMIArr=$this->BodymassIndex->find("first",array("conditions"=>array("BodymassIndex.client_id"=>$uid2), 'order' => array('BodymassIndex.id' => 'DESC')));

//		  $this->set("setBMIArr",$setBMIArr);



       $response=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$uid), 'order' => array('Goal.goal ' => 'Desc')));

		  /*echo"<pre>";
		  print_r($response);
		  echo"</pre>";*/

		$this->set("response",$response);  

		

			

       

		  $response19 =$this->SevensiteBodyfat->find("all",array("conditions"=>array("SevensiteBodyfat.client_id"=>$uid), 'order' => array('SevensiteBodyfat.id ' => 'Desc')));

		 	

		 	$this->set("response19",$response19);

		 	 

		 	$response20 =$this->ThreesiteBodyfat->find("all",array("conditions"=>array("ThreesiteBodyfat.client_id"=>$uid), 'order' => array('ThreesiteBodyfat.id ' => 'Desc')));

		 	

		 	$this->set("response20",$response20);

		 	

		 	$response21 =$this->BodymassIndex->find("all",array("conditions"=>array("BodymassIndex.client_id"=>$uid), 'order' => array('BodymassIndex.id ' => 'Desc')));

		 	

		 	$this->set("response21",$response21);

		  $listdata=$this->Measurement->find("all",array("conditions"=>array("Measurement.trainee_id"=>$clientid),'order'=>array('Measurement.show_date DESC')));


        $listingmes='';
			

           if(!empty($listdata))

			{

              $listingmes .= "<table border='1' class='newst'>

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

			

	        </tr>";

             foreach($listdata as $listdatas=>$listdatav)

				{

			$listingmes .= "<tr id='g_".$listdatav['Measurement']['id']."'>

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

			

			</tr>";

				}

				$listingmes .= " </table>";

			}

		  $this->set("listingmes",$listingmes);

		}

		

		

		

		public function food_serv()

		{

			$this->layout = "";

			$this->autoRender=false;

			if(trim($_REQUEST['searchParam'])!='' )

			{

				

             $food = $_REQUEST['searchParam']; 

				//$datav=array();

				

				

				$response=$this->FoodUsda->find("first",array("conditions"=>array("FoodUsda.name LIKE"=>"%".$food."%")));

				if(!empty($response)){

				 echo json_encode($response);

				 exit;

				} else {

					$response['FoodUsda']['gmwtdesc1']=1;

					echo json_encode($response);

				 exit;

				}

			}

		}

		

		public function search_food()

		{	

			$this->layout = "ajax";

			//$this->autoRender=false;

			

			

			if(trim($_REQUEST['searchParam'])!='' )

			{

				

             $food = $_REQUEST['searchParam']; 

				//$datav=array();

				

				

				$response=$this->FoodUsda->find("all",array("conditions"=>array("FoodUsda.name LIKE"=>"%".$food."%"), 'order' => array('FoodUsda.id' => 'DESC')));

				

//				echo "<pre>";

//				print_r($response);

//				echo "</pre>";

//				die();

					  // echo json_encode($response);

			$this->set("response",$response);

						

						

							

				

			

			}

			else {

							

							$this->set("response","1");

						}

			

			

		}

		

		

		public function search_daily_food()

		{	

			$this->layout = "ajax";

			//$this->autoRender=false;

			

			

			if(trim($_POST['search_food'])!='' )

			{

				

             $food = $_POST['search_food']; 

				//$datav=array();

				

				

				$response=$this->FoodUsda->find("all",array("conditions"=>array("FoodUsda.name LIKE"=>"%".$food."%"), 'order' => array('FoodUsda.id' => 'DESC')));

					    	

			$this->set("response",$response);

						

						

							

				

			

			}

			else {

							

							$this->set("response","1");

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
				
		$this->set("videos",$this->HelpGuide->find('all',array('conditions'=>array('HelpGuide.user_type'=>array("Trainee","All")),'fields'=>array('HelpGuide.id','HelpGuide.doc_name','HelpGuide.description','HelpGuide.user_type'))));
		
		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);
		$club_trai_id = $setSpecalistArr['Trainee']['club_id'];
		$setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
		$this->set("setSpecalistArr1",$setSpecalistArr1);
	
}
		
		
		
		
		
		
		
		
		

				

		public function clientmesdetail($client_id=null,$date=null)

		{

			//echo "hello"; die(); 

			

			$this->checkUserLogin();

		    $this->layout = "ajax1";

		

		//$this->layout = "homelayout";		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'measurement_and_goal');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	  	

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		  $this->set("setSpecalistArr",$setSpecalistArr);

			



			

			$response=$this->SevensiteBodyfat->find("all",array("conditions"=>array("SevensiteBodyfat.client_id"=>$client_id,'SevensiteBodyfat.created_date <='=>$date), 'order' => array('SevensiteBodyfat.id' => 'DESC'),'limit'=>2));

			

			//$conditions = array('SevensiteBodyfat.created_date <=' => $date, 'SevensiteBodyfat.created_date >=' => $start);

			

			$this->set("response",$response);

			



		 	 

		 	$response_threesite =$this->ThreesiteBodyfat->find("all",array("conditions"=>array("ThreesiteBodyfat.client_id"=>$client_id,'ThreesiteBodyfat.created_date <='=>$date), 'order' => array('ThreesiteBodyfat.id ' => 'Desc'),'limit'=>2));

		 	

		 	$this->set("response_threesite",$response_threesite);

		 	

		 	$response_bodyindex =$this->BodymassIndex->find("all",array("conditions"=>array("BodymassIndex.client_id"=>$client_id,'BodymassIndex.created_date <='=>$date), 'order' => array('BodymassIndex.id ' => 'Desc'),'limit'=>2));

		 	

		 	$this->set("response_bodyindex",$response_bodyindex);

		 	



		

		}

		

		public function exercise_history($uid=null,$datva=null)

		{		

		

			

		$this->checkUserLogin();

		$this->layout = "homelayout";		

		

		$this->set("leftcheck",'exercise_history');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	





		if($datva!='')

			{

					

				

               //$dtsv=CakeTime::format($datva, '%d-%m-%Y');

               $dtsv=$datva;

                

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

				$this->set("datva2",$datefd);

			}

			else {

				$dtsv=date('m/d/Y');				

				$datefd=date('Y-m-d');

				$this->set("datva2",$datefd);

				

				$this->set("datva",$dtsv);

			}

		

			

		

		if($uid!='')

		{

			

			

			$this->set("clientid",$uid);

			

			$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$uid)));
			
			
			$club_trai_id = $setClientArr['Trainee']['club_id'];
		    $setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
		    $this->set("setSpecalistArr1",$setSpecalistArr1);

			$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$setClientArr['Trainee']['trainer_id'])));

		    $this->set("setSpecalistArr",$setSpecalistArr);	
              $dt1 = date('Y-m-d H:i:s', strtotime($datefd));
                
			 $dt2 = date('Y-m-d H:i:s', strtotime($datefd.' 23:59:59'));
			

			
			 $setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$uid,'Goal.start between ? and ?' => array($dt1, $dt2)),'order' => array('Goal.id' => 'DESC')));

			
            $startvaldt=$setClientGoalArr['Goal']['start'];

			$endvaldt=$setClientGoalArr['Goal']['end'];
			

//			$response=$this->ExerciseHistorys->find("all",array("conditions"=>array("ExerciseHistorys.trainee_id"=>$uid,'ExerciseHistorys.added_date'=>$datefd ), 'order' => array('ExerciseHistorys.id' => 'DESC')));

				

			

                $jtms='';

                $setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt)));

                $setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt)));

                

                $setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt)));

                

                $setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt)));

                

                $setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt)));

                

                if(!empty($setWarmupArr) || !empty($setCoreBalancePlyometricArr) || !empty($setSpeedAgilityQuicknessArr) || !empty($setResistenceArr) || !empty($setCoolDownArr))

				{

				

				$jtms = "<div style=\"float: left;margin-top: 10px;width: 150%;\" ><a href=\"javascript:void(0);\" style=\" border-right: none; font-weight:700;\" onclick=\"viewdetail('$uid' ,'$datefd');\" class=\"add_food\">Print Exercise History</a></div>

				<table border='1' width='100%'>

				

				<tr class='slectedmn'>

				<td colspan='4' class=\"th2\"><h3 style='text-align:left;float:left;'>PROFESSIONAL'S NAME: </h3> <span id=\"trsname\" style=\"float: left; line-height: 32px;  padding: 10px 5px 5px;\">".ucwords($setSpecalistArr['Trainer']['full_name'])."</span>

				

				</td>

				

				</tr>

			</table>

         

         <table border='1' width='100%'>

				

				<tr class='slectedmn'>

				<td colspan='3' class=\"th2\"><h3 style='text-align:left;float:left;'>Client Name: </h3> <span id=\"clname\" style=\"float: left; line-height: 32px;  padding: 10px 5px 5px;\">".ucwords($setClientArr['Trainee']['full_name'])."</span>

				</td>

				<td  style=\"padding-left:220px;\"> <span style=\"line-height:34px;float:left;\">Date:".$dtsv."</span></td>

				

				

				

				</tr>

			</table>

				



			<table border='1' width='100%'>

			<tr class='slectedmn'>

				<td colspan='3' class=\"th2\"><h3 style='text-align:left;'>Goal:".$setClientGoalArr['Goal']['goal']." </h3></td><td  style=\"padding-left:300px;\"> </td>

				

				

				</tr>

				<tr class='slectedmn'>

				<td colspan='3' class=\"th2\"><h3 style='text-align:left;'>Note:".$setClientGoalArr['Goal']['note']." </h3></td><td  style=\"padding-left:300px;\"> </td>

				

				

				</tr>

				<tr class='slectedmn'>

				<td colspan='3' class=\"th2\"><h3 style='text-align:left;'>Alert:".$setClientGoalArr['Goal']['alert']." </h3></td><td  style=\"padding-left:300px;\"> </td>

				

				

				</tr>

			</table>";

				}

				

		

			if(!empty($setWarmupArr))

			{

			//$showoff=0;

			 $jtms .= "<table border='1' width='100%' id=\"w\">

				<tr class='slectedmn'>

				<td colspan='5' class=\"th2\"><h3 style='text-align:left;'>Warm-Up </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th  class=\"throw\">Duration</th>

				<th  class=\"throw\">Coaching Tip</th>

				<th  class=\"throw\"></th>

				

				</tr>";

			

				foreach($setWarmupArr as $key=>$val){

					

				 $jtms .= "<tr>

	    

		     <td>".$val['WarmUps']['exercise']."</td>

		     <td>".$val['WarmUps']['set']."</td>

		     <td>".$val['WarmUps']['duration']."</td>

		     <td>".$val['WarmUps']['coaching_tip']."</td>

		     <td></td>		     

		     </tr>";

				  

				}

      $jtms .= "</table> ";  

			}

				

			



			

			if(!empty($setCoreBalancePlyometricArr))

			{

	      

     $jtms .= "<table border='1' width='100%' id=\"cbp\">

     <tr class='slectedmn'>

				<td colspan='7' class=\"th2\"><h3 style='text-align:left;'>CORE/BALANCE/PLYOMETRIC </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th  class=\"throw\">Reps</th>

				<th  class=\"throw\">Weight</th>

				<th  class=\"throw\">Rest</th>

				<th  class=\throw\">Coaching Tip</th>

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

             <td></td>		    

		          

	     

	     </tr>";

			}		 

	     

       $jtms .= "</table>";

			}

			

				

			if(!empty($setSpeedAgilityQuicknessArr))

			{

      

       $jtms .= "<table border='1' width='100%' id=\"saq\">

     <tr class='slectedmn'>

				<td colspan='7' class=\"th2\"><h3 style='text-align:left;'>SPEED/AGILITY/QUICKNESS </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th class=\"throw\">Reps</th>

				<th class=\"throw\">Weight</th>

				<th class=\"throw\">Rest</th>

				<th class=\"throw\">Coaching Tip</th>

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

		     <td></td>

	     

	    </tr>";

		}

      $jtms .= "</table>"; 

		}

		

		

		if(!empty($setResistenceArr))

			{

      

      $jtms .= "<table border='1' width='100%' id=\"res\">

     <tr class='slectedmn'>

				<td colspan='7' class=\"th2\"><h3 style='text-align:left;'>RESISTANCE </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th class=\"throw\">Reps</th>

				<th class=\"throw\">Weight</th>

				<th class=\"throw\">Rest</th>

				<th class=\"throw\">Coaching Tip</th>

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

		     <td></td>

	     

	    </tr>";

		}

      $jtms .= "</table>"; 

		}

		



		if(!empty($setCoolDownArr))

			{

     $jtms .= " <table border='1' width='100%' id=\"cd\">

				<tr class='slectedmn'>

				<td colspan='5' class=\"th2\"><h3 style='text-align:left;'>COOL-DOWN </h3>

				

				</td>

				</tr>

				

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th  class=\"throw\">Duration</th>

				<th  class=\"throw\">Coaching Tip</th>

				<th></th>

				</tr>";

				

			 foreach($setCoolDownArr as $key=>$val){	

       	

			$jtms .="<tr>

	    

		     <td>".$val['CoolDown']['exercise']."</td>

		     <td>".$val['CoolDown']['set']."</td>

		     <td>".$val['CoolDown']['duration']."</td>		   

		     <td>".$val['CoolDown']['coaching_tip']."</td>

		     <td></td>

	     

	    </tr>";

		}

      $jtms .= "</table>"; 

		}



				$this->set("rst",$jtms);

			

		}

		

				

		//echo "hello45";

		$surl=$this->config['url'].'trainees/exercise_history/'.$uid;

			$this->set("surl",$surl);	

			

			//echo $surl;

			

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	



		$this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.id'=>$uid),'fields'=>array('Trainee.id','Trainee.username'))));

		

		

			

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$this->set("setSpecalistArr",$setSpecalistArr);

		

		

		}

		

		

		

		public function clientdownloadpdf($uid=null,$datva=null)

		{

			//echo "hello"; die(); 

			

			$this->checkUserLogin();

		    $this->layout = "ajax1";

		

		

		$this->set("leftcheck",'exercise_history');

		

		$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');				

		$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

		$this->set("certifications",$this->Certification->find('all',array('conditions'=>array('Certification.status'=>1),'fields'=>array('Certification.id','Certification.course'))));	

	  	

		

		if($datva!='')

			{

					

				

               //$dtsv=CakeTime::format($datva, '%d-%m-%Y');

               $dtsv=$datva;

                

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

				$this->set("datva2",$datefd);

			}

			else {

				$dtsv=date('m/d/Y');				

				$datefd=date('Y-m-d');

				$this->set("datva2",$datefd);

				

				$this->set("datva",$dtsv);

			}

		$strv ='';	

		

		if($uid!='')

		{

			

			$this->set("clientid",$uid);

			

			$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$uid)));

			//$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$uid),"Order"=>array("Goal.id"=>"DESC")));

			  $dt1 = date('Y-m-d H:i:s', strtotime($datefd));
           
			 $dt2 = date('Y-m-d H:i:s', strtotime($datefd.' 23:59:59'));
			

			
			 $setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$uid,'Goal.start between ? and ?' => array($dt1, $dt2)),'order' => array('Goal.id' => 'DESC')));

			
             $startvaldt=$setClientGoalArr['Goal']['start'];
           
			 $endvaldt=$setClientGoalArr['Goal']['end'];
			$traineridv=$setClientGoalArr['Goal']['trainer_id'];

			$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$traineridv)));

		    //$this->set("setSpecalistArr",$setSpecalistArr);

			
        
		    
		    
		    
			

				$strv = "<a href='#' onclick='window.print();'><img src='http://www.ptpfitpro.com/img/print.png' /></a><table width='900px'  border='1' >

				

				<tr class='slectedmn'>

				<td colspan='4' class=\"th2\"><h3 style='text-align:left;float:left;'>PROFESSIONAL'S NAME: </h3> <span id=\"trsname\" style=\"float: left; line-height: 32px;  padding: 10px 5px 5px;\">".ucwords($setSpecalistArr['Trainer']['full_name'])."</span>

				

				</td>

				

				</tr>
				

			</table>

         

         <table border='1' width='900px'>

				

				<tr class='slectedmn'>

				<td colspan='3' class=\"th2\"><h3 style='text-align:left;float:left;'>Client Name: </h3> <span id=\"clname\" style=\"float: left; line-height: 32px;  padding: 10px 5px 5px;\">".ucwords($setClientArr['Trainee']['full_name'])."</span>

				</td>

				<td  style=\"padding-left:220px;\"> <span style=\"line-height:34px;float:left;\">Date:".$dtsv."</span></td>

				

				

				

				</tr>

			</table>";

			


			$strv .="<table border='1' width='900px'>

			<tr class='slectedmn'>

				<td colspan='3' class=\"th2\"><h3 style='text-align:left;'>Goal:".$setClientGoalArr['Goal']['goal']." </h3></td><td  style=\"padding-left:300px;\"> </td>

				

				

				</tr>

			</table>"; 

				//}

				$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt)));

			

			if(!empty($setWarmupArr))

			{

			//$showoff=0;

		 $strv .= "<table border='1' width='900px' id=\"w\">

				<tr class='slectedmn'>

				<td colspan='5' class=\"th2\"><h3 style='text-align:left;'>Warm-Up </h3>

				

				</td>

				</tr>

				
				<tr>
				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th  class=\"throw\">Duration</th>

				<th  class=\"throw\">Coaching Tip</th>

				

				

				</tr>"; 

			

				foreach($setWarmupArr as $key=>$val){

					

			 $strv .= "<tr>

	    

		     <td>".$val['WarmUps']['exercise']."</td>

		     <td>".$val['WarmUps']['set']."</td>

		     <td>".$val['WarmUps']['duration']."</td>

		     <td>".$val['WarmUps']['coaching_tip']."</td>

		   

		     </tr>";

				  

				}

     $strv .= "</table> "; 

			}

				

			

			$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt)));

			

			if(!empty($setCoreBalancePlyometricArr))

			{

	      

    $strv .= "<table border='1' width='900px' id=\"cbp\">

     <tr class='slectedmn'>

				<td colspan='7' class=\"th2\"><h3 style='text-align:left;'>CORE/BALANCE/PLYOMETRIC </h3>

				

				</td>

				</tr>

				
				<tr>
				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th  class=\"throw\">Reps</th>

				<th  class=\"throw\">Weight</th>

				<th  class=\"throw\">Rest</th>

				<th  class=\"throw\">Coaching Tip</th>

				

				</tr>"; 

				

	foreach($setCoreBalancePlyometricArr as $key=>$val){			 

   $strv .= "<tr>

	    

		     <td>".$val['CoreBalancePlyometric']['exercise']."</td>

		     <td>".$val['CoreBalancePlyometric']['set']."</td>

		     <td>".$val['CoreBalancePlyometric']['rep']."</td>

		     <td>".$val['CoreBalancePlyometric']['temp']."</td>

		     <td>".$val['CoreBalancePlyometric']['rest']."</td>

		     <td>".$val['CoreBalancePlyometric']['coaching_tip']."</td>

            	    

		          

	     

	     </tr>"; 

			}		 

	     

      $strv .= "</table>";

			}

			

			$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt)));

				

			if(!empty($setSpeedAgilityQuicknessArr))

			{

      

       $strv .= "<table border='1' width='900px' id=\"saq\">

     <tr class='slectedmn'>

				<td colspan='7' class=\"th2\"><h3 style='text-align:left;'>SPEED/AGILITY/QUICKNESS </h3>

				

				</td>

				</tr>

				<tr>

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th class=\"throw\">Reps</th>

				<th class=\"throw\">Weight</th>

				<th class=\"throw\">Rest</th>

				<th class=\"throw\">Coaching Tip</th>

				

				</tr>";

		foreach($setSpeedAgilityQuicknessArr as $key=>$val){	

       	

			$strv .="<tr>

	    

		     <td>".$val['SpeedAgilityQuickness']['exercise']."</td>

		     <td>".$val['SpeedAgilityQuickness']['set']."</td>

		     <td>".$val['SpeedAgilityQuickness']['rep']."</td>

		     <td>".$val['SpeedAgilityQuickness']['temp']."</td>

		     <td>".$val['SpeedAgilityQuickness']['rest']."</td>

		     <td>".$val['SpeedAgilityQuickness']['coaching_tip']."</td>

		     

	     

	    </tr>"; 

		}

     $strv .= "</table>"; 

		}

		

		$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt)));

		

		if(!empty($setResistenceArr))

			{

      

    $strv .= "<table border='1' width='900px' id=\"res\">

     <tr class='slectedmn'>

				<td colspan='7' class=\"th2\"><h3 style='text-align:left;'>RESISTANCE </h3>

				

				</td>

				</tr>

				<tr>

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th class=\"throw\">Reps</th>

				<th class=\"throw\">Weight</th>

				<th class=\"throw\">Rest</th>

				<th class=\"throw\">Coaching Tip</th>

				<th></th>

				</tr>"; 

				

				

	    

		    foreach($setResistenceArr as $key=>$val){	

       	

$strv .="<tr>

	    

		     <td>".$val['Resistence']['exercise']."</td>

		     <td>".$val['Resistence']['set']."</td>

		     <td>".$val['Resistence']['rep']."</td>

		     <td>".$val['Resistence']['temp']."</td>

		     <td>".$val['Resistence']['rest']."</td>

		     <td>".$val['Resistence']['coaching_tip']."</td>

		     <td></td>

	     

	    </tr>"; 

		}

    $strv .= "</table>";

		}

		

		$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt)));

		if(!empty($setCoolDownArr))

			{

    $strv .= " <table border='1' width='900px' id=\"cd\">

				<tr class='slectedmn'>

				<td colspan='5' class=\"th2\"><h3 style='text-align:left;'>COOL-DOWN </h3>

				

				</td>

				</tr>

				<tr>

				<th  class=\"throw\">Exercise</th>

				<th  class=\"throw\">Sets</th>

				<th  class=\"throw\">Duration</th>

				<th  class=\"throw\">Coaching Tip</th>

				<th></th>

				</tr>";

				

			 foreach($setCoolDownArr as $key=>$val){	

       	

			$strv .="<tr>

	    

		     <td>".$val['CoolDown']['exercise']."</td>

		     <td>".$val['CoolDown']['set']."</td>

		     <td>".$val['CoolDown']['duration']."</td>		   

		     <td>".$val['CoolDown']['coaching_tip']."</td>

		     <td></td>

	     

	    </tr>"; 

		}

   $strv .= "</table>"; 

		}

				
             
				

				$this->set("rst",$strv);

			

		}

		

         

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		  $this->set("setSpecalistArr",$setSpecalistArr);

		  

		  App::uses('Folder', 'Utility');

          App::uses('File', 'Utility');



			$dir = new Folder($this->config['webrt'].'tmp_pdfs/');

			$files = $dir->find('.*\.html');

			$contents ='';



$wrcontent='<html>

<head><title>sdfsdf</title>

</head>

<style>

.inside {

    

}

.header {

   /* background: url("'.$this->config['url'].'images/transparent.png") repeat scroll 0 0 rgba(0, 0, 0, 0); */

    display: block;

    left: 0;

    padding: 0px;

    padding-bottom:10px;

    padding-top:10px;

    top: 0;

    width: 100%;

    z-index: 9999;

}

.tbls{margin-top:2px;}

.tbls table{border-collapse: collapse;

    border-spacing: 0;

   background: none repeat scroll 0 0 #FFFFFF;

    border: 1px solid #DDDDDD;

    border-radius: 3px;

    margin: 0 0 18px;

}

.slectedmn {

    background: none repeat scroll 0 0 #F3F3F3;

    box-shadow: 0 1px 2px #D7D7D7 inset;

}

.main{background: none repeat scroll 0 0 #262930;

    padding: 5px 0;}



.footer{background: none repeat scroll 0 0 #262930;

    padding: 30px 0;}

body{padding:0;margin:0;}

a{ color: #183F6C;font-size: 31px;font-weight: 700;text-decoration: none;}

</style>

<body>



 <div class="header">

  

<div  align="center"> <a href="'.$this->config['url'].'">Personal Training Partners</a> </div>

      

    </div>

   

    <div class="main"></div>

<div class="tbls">';

$wrcontent .=$strv;

$wrcontent .='</div>

<div class="footer"></div>

</body>

</html>';

//echo $wrcontent;
//die();

foreach ($files as $file) {

    $file = new File($dir->pwd() . DS . $file);

    $contents = $file->write($wrcontent);

 

    $file->close(); // Be sure to close the file when you're done

}



	/* CODE ADDED */
	//$wrcontent = ob_get_clean();
 
		   /*require_once(DIRECT_WEBROOT_PATH.'/html2pdf/html2pdf.class.php');
		   App::import('Vendor', 'html2pdf', array('file' => 'html2pdf' .DS . 'html2pdf.class.php'));
		   $name='Exercise_History.pdf';
		   $user_lang = '';
		   $html2pdf = new HTML2PDF();
		   $html2pdf->WriteHTML($wrcontent);
		   $html2pdf->Output($name);
		   header("Expires: 0");
		   header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		   header("Cache-Control: no-store, no-cache, must-revalidate");
		   header("Cache-Control: post-check=0, pre-check=0", false);
		   header("Pragma: no-cache");
	       header("Content-type: application/pdf"); 
		   header('Content-length: '.filesize($name));
		   header('Content-disposition: attachment; filename='.$name);
		   readfile($name);*/


	/* CODE ADDED */

			



		//	 App::import('Component', 'Pdf');

        // Make instance

      //  $Pdf = new PdfComponent();

        // Invoice name (output name)

     //   $Pdf->filename = 'Exercise_History'; // Without .pdf

        // You can use download or browser here

        //$Pdf->output = 'file';

      //  $Pdf->output = 'download';

     //   $Pdf->init();

        // Render the view

 //      $fnm=$this->config['url'].'tmp_pdfs/exercise.html';

    //    $Pdf->process($fnm);

      //  $this->render(false); 

			

		 	



		

		}

		

		

		public function add_new_body_measurement()

		{

			$this->layout = "homelayout";	 

		    $this->set("leftcheck",'measurement_and_goal');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));

			$tranrsdata=$this->SevensiteBodyfat->find('all',array('conditions'=>array('SevensiteBodyfat.id'=>$id),'fields'=>array('SevensiteBodyfat.id')));

			 

			if(!empty($this->data)) {

		

				$this->SevensiteBodyfat->set($this->data);

				if($this->SevensiteBodyfat->validates()) {

						

					    

					    $this->request->data["SevensiteBodyfat"]["created_date"] 		= date("Y-m-d h:i:s");

						$this->request->data["SevensiteBodyfat"]["modified_date"] 		= date("Y-m-d h:i:s");

					    	

					   

						if($this->SevensiteBodyfat->save($this->request->data)) {	

										

							$this->Session->setFlash('Measurement has been created successfully.');

							$this->redirect('/trainees/measurement_and_goal/');

						} else {

							$this->Session->setFlash('Some error has been occured. Please try again.');

						}

				}	

			}

							

			

		}

		

		

		public function clientmeasurement(){	

		$this->layout = "ajax";

			$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');	

		

		/*echo '<pre>';

		print_r($_POST);

		echo '</pre>';*/

		if($_REQUEST['gender']=='Male')

		{

			if(trim($_REQUEST['age'])!='' && trim($_REQUEST['weight'])!='' && trim($_REQUEST['height'])!='' && trim($_REQUEST['chestm'])!=''&& trim($_REQUEST['abdominalm'])!='' && trim($_REQUEST['thighm'])!='' && trim($_REQUEST['tricepsm'])!='' && trim($_REQUEST['subscapularism'])!='' && trim($_REQUEST['illiaccrestm'])!='' && trim($_REQUEST['midaxillarym'])!='') 

			{

				//echo "Male";

				

				$measuremenv=array();

				

				

				$measuremenv['SevensiteBodyfat']['weight']=trim($_REQUEST['weight']);

				$measuremenv['SevensiteBodyfat']['height']=trim($_REQUEST['height']);

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

				$measuremenv['SevensiteBodyfat']['client_id']=$uid;

			

				

				$measuremenv['SevensiteBodyfat']["created_date"] 		    = date("Y-m-d h:i:s");

				

				$Sum=intval(trim($_REQUEST['chestm']))+intval(trim($_REQUEST['abdominalm']))+intval(trim($_REQUEST['thighm']))+intval(trim($_REQUEST['tricepsm']))+intval(trim($_REQUEST['subscapularism']))+intval(trim($_REQUEST['illiaccrestm']))+intval(trim($_REQUEST['midaxillarym']));

				$age=intval(trim($_REQUEST['age']));

               $BD = 1.112 - ((0.000435)*$Sum) + (((0.00000055)*$Sum)*2) - ((0.000288)*$age);

               //$BD=round($BD, 2);

                

                $bodymalefat = 495/$BD - 450;

                $bodymalefat = round($bodymalefat);

              $measuremenv['SevensiteBodyfat']['body_fat']=$bodymalefat;

				$this->SevensiteBodyfat->save($measuremenv);

				//'ThreesiteBodyfat','BodymassIndex','EstimatedenergyRequirement'

				

				$threesiteArr=array();

				

				$threesiteArr['ThreesiteBodyfat']['age']=trim($_REQUEST['age']);

				$threesiteArr['ThreesiteBodyfat']['gender']=trim($_REQUEST['gender']);

				$threesiteArr['ThreesiteBodyfat']['abdominal']=trim($_REQUEST['abdominalm']);

				

				

				

				$threesiteArr['ThreesiteBodyfat']['chest']=trim($_REQUEST['chestm']);

			

				$threesiteArr['ThreesiteBodyfat']['thigh']=trim($_REQUEST['thighm']);

				$threesiteArr['ThreesiteBodyfat']['triceps']=trim($_REQUEST['tricepsm']);

			   $threesiteArr['ThreesiteBodyfat']['suprailiac']='';

				

				

				

				$threesiteArr['ThreesiteBodyfat']['status']=1;

				$threesiteArr['ThreesiteBodyfat']['client_id']=$uid;

			

				

				$threesiteArr['ThreesiteBodyfat']["created_date"] 		    = date("Y-m-d h:i:s");

				

				

				

				$Sum2=intval(trim($_REQUEST['chestm']))+intval(trim($_REQUEST['abdominalm']))+intval(trim($_REQUEST['thighm']));

				$age=intval(trim($_REQUEST['age']));

				

				

				  $BodyDensity = 1.10938- ((0.0008267)*$Sum2) + (((0.0000016)*($Sum2))*2) - ((0.0001392)*$age);

				 $BodyFat = 457/$BodyDensity - 414;

				 $BodyFat = round($BodyFat,2);

				

				

				$threesiteArr['ThreesiteBodyfat']['body_fat']=$BodyFat;

				

				

				$this->ThreesiteBodyfat->save($threesiteArr);

				

				$weight=trim($_REQUEST['weight']);

				

				$height=trim($_REQUEST['height']);

				

				$bodyMassindex2=$height*$height;

				

				$bodyMassindex1=($weight)/($bodyMassindex2);

			

				$bodyMassindex=($bodyMassindex1)*703;

				$bodyMassindex=round($bodyMassindex1,2);

				

				

				$bmiArr=array();

				

				$bmiArr['BodymassIndex']['weight']=$weight;

				$bmiArr['BodymassIndex']['height']=$height;

				$bmiArr['BodymassIndex']['body_fat']=$bodyMassindex;

				$bmiArr['BodymassIndex']['status']=1;

				$bmiArr['BodymassIndex']['client_id']=$uid;				

				$bmiArr['BodymassIndex']["created_date"] 		    = date("Y-m-d h:i:s");

				

				$this->BodymassIndex->save($bmiArr);

				

				echo 'Successfully Added your Sevensite details. Your Seven Site Body Fat is '.$bodymalefat.'%, Three Site Body Fat is '.$BodyFat.'%, BMI is '.$bodyMassindex;

			}

		}

		

		elseif($_REQUEST['gender']=='Female')

		{

		  

			if(trim($_REQUEST['age'])!='' && trim($_REQUEST['weight'])!='' && trim($_REQUEST['height'])!='' && trim($_REQUEST['chestf'])!=''&& trim($_REQUEST['abdominalf'])!='' && trim($_REQUEST['thighf'])!='' && trim($_REQUEST['tricepsf'])!='' && trim($_REQUEST['subscapularisf'])!='' && trim($_REQUEST['illiaccrestf'])!='' && trim($_REQUEST['midaxillaryf'])!='' && trim($_REQUEST['suprailiacf'])!='') 

		  

		  {

		     //echo "Female";

		     $measuremenv=array();

				

				

				$measuremenv['SevensiteBodyfat']['weight']=trim($_REQUEST['weight']);

				$measuremenv['SevensiteBodyfat']['height']=trim($_REQUEST['height']);

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

				$measuremenv['SevensiteBodyfat']['client_id']=$uid;

			

				

				$measuremenv['SevensiteBodyfat']["created_date"] 		    = date("Y-m-d h:i:s");

				

				$Sum=intval(trim($_REQUEST['chestm']))+intval(trim($_REQUEST['abdominalm']))+intval(trim($_REQUEST['thighm']))+intval(trim($_REQUEST['tricepsm']))+intval(trim($_REQUEST['subscapularism']))+intval(trim($_REQUEST['illiaccrestm']))+intval(trim($_REQUEST['midaxillarym']));

				$age=intval(trim($_REQUEST['age']));

               $BD = 1.097 - ((0.00047)*$Sum) + (((0.00000056)*$Sum)*2) - ((0.000128)*$age);

              // $BD=round($BD, 2);

                

                $bodyfemalefat = 496/$BD - 451;

                $bodyfemalefat = round($bodyfemalefat);

              $measuremenv['SevensiteBodyfat']['body_fat']=$bodyfemalefat;

              $this->SevensiteBodyfat->save($measuremenv);

              

              

                $threesiteArr=array();

				

				$threesiteArr['ThreesiteBodyfat']['age']=trim($_REQUEST['age']);

				$threesiteArr['ThreesiteBodyfat']['gender']=trim($_REQUEST['gender']);

				

				

			

				$threesiteArr['ThreesiteBodyfat']['thigh']=trim($_REQUEST['thighf']);

				$threesiteArr['ThreesiteBodyfat']['triceps']=trim($_REQUEST['tricepsf']);

				$threesiteArr['ThreesiteBodyfat']['suprailiac']=trim($_REQUEST['suprailiacf']);

				

				

				

				$threesiteArr['ThreesiteBodyfat']['status']=1;

				$threesiteArr['ThreesiteBodyfat']['client_id']=$uid;

			

				

				$threesiteArr['ThreesiteBodyfat']["created_date"] 		    = date("Y-m-d h:i:s");

				

				

				

				$Sum2=intval(trim($_REQUEST['thighf']))+intval(trim($_REQUEST['tricepsf']))+intval(trim($_REQUEST['suprailiacf']));

				$age=intval(trim($_REQUEST['age']));

				

				

				 $BodyDensity = 1.099421- ((0.0009929)*$Sum2) + (((0.0000023)*($Sum2))*2) - ((0.0001392)*$age);

				$BodyFat = (457/$BodyDensity)-414;

				$BodyFat = round($BodyFat);

				$threesiteArr['ThreesiteBodyfat']['body_fat']=$BodyFat;

				

				$this->ThreesiteBodyfat->save($threesiteArr);

				

				$weight=trim($_REQUEST['weight']);

				

				$height=trim($_REQUEST['height']);

				

				$bodyMassindex2=$height*$height;

				

				$bodyMassindex1=($weight)/($bodyMassindex2);

			

				$bodyMassindex=($bodyMassindex1)*703;

				$bodyMassindex=round($bodyMassindex1,2);

				

				

				$bmiArr=array();

				

				$bmiArr['BodymassIndex']['weight']=$weight;

				$bmiArr['BodymassIndex']['height']=$height;

				$bmiArr['BodymassIndex']['body_fat']=$bodyMassindex;

				$bmiArr['BodymassIndex']['status']=1;

				$bmiArr['BodymassIndex']['client_id']=$uid;				

				$bmiArr['BodymassIndex']["created_date"] 		    = date("Y-m-d h:i:s");

				

				$this->BodymassIndex->save($bmiArr);

				

				

				

				echo 'Successfully Added your Sevensite details. Your Seven Site Body Fat is '.$bodyfemalefat.'%, Three Site Body Fat is '.$BodyFat.'%, BMI is '.$bodyMassindex;

              

              

              

		  }

		

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

		    $this->Trainee->set($this->data);

			$this->Trainee->id = $id;	

			

			  if(!empty($this->request->data["Trainee"]["photo"]["name"]))

				{

					$filename = $this->request->data["Trainee"]["photo"]["name"];

					$target = $this->config["upload_path"];

					$this->Upload->upload($this->data["Trainee"]["photo"], $target, null, null);

  					$this->request->data["Trainee"]["photo"] = $this->Upload->result; 

  					$picPath = $this->config["upload_path"].$this->request->data["Trainee"]["old_image"];

					@unlink($picPath);

					$this->request->data["Trainee"]["update_date"] 		    = date("Y-m-d h:i:s");

					$this->request->data["Trainee"]["id"] 		    = $id;

					if($this->Trainee->save($this->data)) {

					$this->Session->setFlash('Client information has been updated successfully.');

					$this->redirect($_SERVER["HTTP_REFERER"]);	

					} else {

					$this->Session->setFlash('Some error has been occured. Please try again.');

					$this->redirect($_SERVER["HTTP_REFERER"]);	

					}

				}

			

				

		    }

		    $this->redirect($_SERVER["HTTP_REFERER"]);	

		}

		

		public function editprofile()

		{

			

			 

		    $this->layout = "homelayout";	

		    $this->set("leftcheck",'editprofile');

			$dbusertype = $this->Session->read('UTYPE');					

			$this->set("dbusertype",$dbusertype);

			$id = $this->Session->read('USER_ID');

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setSpecalistArr",$setSpecalistArr);
		  
		  $club_trai_id = $setSpecalistArr['Trainee']['club_id'];
		  $setSpecalistArr1=$this->Club->find("first",array("conditions"=>array("Club.id"=>$club_trai_id)));
		 $this->set("setSpecalistArr1",$setSpecalistArr1);

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

	

			

			if(!empty($this->data)){

			

			$this->Trainee->set($this->data);

			$this->Trainee->id = $this->data['Trainee']['id'];		

			

							

			if($this->Trainee->validates()) {

				

				if(!empty($this->request->data["Trainee"]["website_logo"]["name"]))

				{

					$filename = $this->request->data["Trainee"]["website_logo"]["name"];

					$target = $this->config["upload_path"];

					$this->Upload->upload($this->data["Trainee"]["website_logo"], $target, null, null);

  					$this->request->data["Trainee"]["website_logo"] = $this->Upload->result; 

  					$picPath = $this->config["upload_path"].$this->request->data["Trainee"]["old_image"];

					@unlink($picPath);

				}else{	

					

					if(!empty($this->request->data["Trainee"]["old_image"])){

						$this->request->data["Trainee"]["website_logo"] = $this->request->data["Trainee"]["old_image"];			

					}

					else{

						$this->request->data["Trainee"]["website_logo"] = "";

					}

				}

				$this->request->data["Trainee"]["username"] 		    = $this->data["Trainee"]["email"];

				$this->request->data["Trainee"]["update_date"] 		    = date("Y-m-d h:i:s");

				if($this->Trainee->save($this->data)) {

					$this->Session->setFlash('Client information has been updated successfully.');

					$this->redirect('/trainees/index/');

				} else {

					$this->Session->setFlash('Some error has been occured. Please try again.');

				}

			}

			else{				

				$this->request->data["Trainee"]["website_logo"]=$this->request->data["Trainee"]["old_image"];				

			}				

		 } else{

				if(is_numeric($id) && $id > 0) {

						$this->Trainee->id = $id;

						$this->request->data = $this->Trainee->read();

					} else {

						$this->Session->setFlash('Invalid Client id.');

						$this->redirect('/trainees/index/');

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

			
			$this->Trainee->set($this->data);
			$this->Trainee->id = $this->data['Trainee']['id'];	
			$orig_pass = $this->Trainee->data['Trainee']['originalpassword'];
			$oldpassuser = $this->Trainee->data['Trainee']['oldpassword'];
			$new_pass = $this->Trainee->data['Trainee']['newpassword'];
			$conf_pass = $this->Trainee->data['Trainee']['conpassword'];
			
			
				 if( ($orig_pass==$oldpassuser) && ($new_pass==$conf_pass) )
					{
					$this->Trainee->query("update trainees set password = '".$new_pass."' where id='".$id."'");
					$this->Session->setFlash('Password updated successfully.');		
					$this->redirect('/trainees/index/');
					}
				else if($orig_pass!=$oldpassuser)
					{
						$this->Session->setFlash('Old Password is Incorrect.');
						$this->redirect('/trainees/editprofile/');
					}
				else if($new_pass!=$conf_pass)
					{
						$this->Session->setFlash('New Password and Confirm password not Match.');
						$this->redirect('/trainees/editprofile/');
					}
				else
				{
					$this->Session->setFlash('Some error.');
					$this->redirect('/trainees/editprofile/');
				}
		}
		
		
		
		
		
		
		
		
		

		

		public function update_status($status, $ids, $count){



			switch(trim($status)){

				case "activate":

					for($ctr=0;$ctr<$count;$ctr++){

						$this->Trainee->id = $ids[$ctr];

						$this->Trainee->saveField("status", '1');

					}

					$this->Session->setFlash('Trainee(s) has been activated successfully.');

					break;

				case "deactivate":

					for($ctr=0;$ctr<$count;$ctr++){

						$this->Trainee->id = $ids[$ctr];

						$this->Trainee->saveField("status", '0');

					}

					$this->Session->setFlash('Trainee(s) has been deactivated successfully.');

					break;

				case "delete":

					for($i=0;$i<$count;$i++){

						$this->Trainee->create();

						$this->Trainee->id = $ids[$i];

						

						$this->Trainee->delete($ids[$i]);

						

					}

					$this->Session->setFlash('Trainee(s) has been deleted successfully.');

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

					$dataCheck = $this->Trainee->find('all', array('conditions'=>array('Trainee.email'=>trim($validateValue), 'Trainee.id !='=>trim($row_id))));

				}else{

					$dataCheck = $this->Trainee->find('all', array('conditions'=>array('Trainee.email'=>trim($validateValue))));

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

				

				$userPic = $this->Trainee->find("first",array("fields"=>array("photo"),"conditions"=>array("Trainee.id"=>$this->data["id"])));

				$picPath = $this->config["upload_path"].$userPic["Trainee"]["photo"];

				unlink($picPath);

				

				$data["photo"] = null;

				if( $this->Trainee->updateAll($data,array("Trainee.id"=>$this->data["id"])) ) {

					$response = array("responseclassName"=>"nSuccess","errorMsg"=>"Successfully updated");

				}else{

					$response = array("responseclassName"=>"nFailure","errorMsg"=>"unable to process the request");

				}

				echo json_encode($response);

				exit;	

			}

		

		}

		

		function listtrainers()

		{

			$this->layout = '';

			$this->render = false;

			if($this->data)

			{

			 	$array = $_POST['clubs']; // order in 'In' clause

				$condition = array('Trainer.club_id' => $array);

				$trainerData = $this->Trainer->find('all',array('fields'=>array('Trainer.id','Trainer.first_name','Trainer.last_name'),"conditions"=>$condition));

			 			

			 	$tra = '<select id="TraineeTrainers" size="5" style="width:62%;height:80px;" multiple="multiple" class="validate[required]" name="TraineeTrainers[]">';

				foreach($trainerData as $val)

			 	{

			 		$tra .='<option value="'.$val['Trainer']['id'].'">'.$val['Trainer']['first_name']." ".$val['Trainer']['last_name'].'</option';

			 	}

			 	

			 	$tra .='</select>';

			}

			echo $tra;

			exit;

		}

		

				function register(){

			$this->layout='register';

			

			$this->set("countries",$this->Country->find('list',array('fields'=>array('Country.id','Country.name'))));	

			//pr($this->request->data);

			//die;

			$this->Trainee->set($this->data);

			if($this->Trainee->validates()) {

			if(!empty($this->data)) {

				

				

				if(!empty($this->data["Trainee"]["password"]) && ($this->data["Trainee"]["password"]==$this->data["Trainee"]["con_password"]))

					    {

					   

		

				//$this->Club->set($this->data);

				//if($this->Club->validates()) {

						if( !empty($this->data["Trainee"]["logo"]) ) {

							

							$filename = $this->data["Trainee"]["logo"]["name"];

							$target = $this->config["upload_path"];

							$this->Upload->upload($this->data["Trainee"]["logo"], $target, null, null);

  					        $this->request->data["Trainee"]["logo"] = $this->Upload->result; 					

						}else{	

							

							unset($this->request->data["Trainee"]["logo"]);

							$this->request->data["Trainee"]["logo"] = '';							

					    }

					    

					    

					    $this->request->data["Trainee"]["added_date"] 		    = date("Y-m-d h:i:s");

						$this->request->data["Trainee"]["modified_date"] 		    = date("Y-m-d h:i:s");

						 $this->request->data["Trainee"]["status"]=1;

					    	

						if($this->Trainee->save($this->data)) {

							

							

							$this->send_welcome_email($this->request->data["Trainee"]["email"],$this->request->data["Trainee"]["first_name"],$this->request->data["Trainee"]["password"],$this->request->data["Trainee"]["last_name"],$this->request->data["Trainee"]["username"]);	

							$this->Session->setFlash('Your account has been created successfully.We have sent welcome mail in your registered email address.');

							$dbusertype='Trainee';

							$data_array=array();

							$data_array[$dbusertype]['username']=$this->request->data["Trainee"]["username"];

							$data_array[$dbusertype]['id']=$this->Trainee->getLastInsertId();

							$data_array[$dbusertype]['first_name']=$this->request->data["Trainee"]["first_name"];

							

							$this->Session->write('USER_ID', $data_array[$dbusertype]['id']);

					$this->Session->write('USER_NAME', $data_array[$dbusertype]['username']);

					$this->Session->write('UNAME', $data_array[$dbusertype]['first_name']);

					$this->Session->write('UTYPE', $dbusertype);

							$this->redirect('/Trainees/index');

							

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

		function send_welcome_email($emailaddress,$name,$pass,$lname,$username) {

		App::uses('CakeEmail', 'Network/Email');		

		$email = new CakeEmail();		

		$email->emailFormat('html');



				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Dear '.$name.' '.$lname.'!</p>

				<p>Thanks for the Registration on '.$this->config["base_title"].' site. </p>

				<p>You have registered as Trainee</p>

				<p>Please find below your login credentials</p>

				<p> Your Username is'.' '.$username.'</p>

				<p>Your Password is'.' '.$pass.'</p>

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

				 

				 

                

		$email->from(array(WEBSITE_FROM_EMAIL => WEBSITENAME));

		$email->to($emailaddress);

		//$email->cc('rprasad@sampatti.com');

		$subtxt = __('Your Registration was Successful.');

		$email->subject($subtxt);

		$email->send($content);

	}

	

	

		

public function messageclient()

		{

			

			$this->layout = "";

			$this->autoRender=false;

			$uid = $this->Session->read('USER_ID');

			

			/*echo"<pre>";

			print_r($_REQUEST);

			echo"</pre>";

			die();*/

			$sentfor="Trainer";

		

			$message2=trim($_REQUEST['message']);

			$sendto=trim($_REQUEST['sendto']);

			$mestype=trim($_REQUEST['mestype']);

			$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$sendto)));

			$traineeDataArr=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>$uid),'fields'=>array('Trainee.id','Trainee.username','Trainee.email','Trainee.phone')));	

			if($sentfor=='Trainer')

			{

				 

				$from=$traineeDataArr['Trainee']['email'];

				$to=$setSpecalistArr['Trainer']['email'];

				$fromName=$traineeDataArr['Trainee']['full_name'];

				

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';

					if($setSpecalistArr['Trainer']['website_logo']){

					$content.='<img src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';

					}else{

						$content.='<img src="'.$this->config['url'].'images/logo.png"/>';

					}

					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$traineeDataArr['Trainer']['full_name'].'!</p>

				<p> Client - '.$fromName.' sent message </p>

				<p>'.$message2.' </p>

				

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					

					

					$dataSet['MessageBoard']['trainer_id']=$sendto;

					

					$dataSet['MessageBoard']['client_id']=$uid;

					$dataSet['MessageBoard']['parent_message']=0;

					$dataSet['MessageBoard']['posted_by']='C';

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

		
		
		
		public function firstlogin()
		{
			//echo "<pre>";
			//print_r($this->params['pass']);
			//echo "</pre>";
			if($this->params['pass'][0]=='g')
			{
					$dbusertype = $this->Session->read('UTYPE');					
					$this->set("dbusertype",$dbusertype);
					$first_time = 1;
					$id = $this->Session->read('USER_ID');
					$this->Trainee->id=$id;
					$this->Trainee->query("update trainees set first_time_login = '".$first_time."' where id='".$id."'");					
					$this->redirect('/trainees/communication_center/');

			}
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

					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$traineeDataArr['Trainee']['full_name'].'!</p>

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

					$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$traineeDataArr['Trainee']['full_name'].'!</p>

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

		/* Message reply fucntionality end */

		public function admin_download()
		{	
			$this->set('trainees', $this->Trainee->find('all',array('fields'=>array('Trainee.username','Trainee.first_name','Trainee.last_name','Trainee.email','Trainee.address','Trainee.city','Trainee.state','Trainee.country','Trainee.status','Trainee.mobile','Trainee.phone','Trainee.date_enrolled'))));
			$this->layout = null;
			$this->autoLayout = false;
			Configure::write('debug', '0');
		}

	}