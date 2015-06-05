<?php

##******************************************************************

##  Project		:		Fitness

##  Done by		:		921

##	Create Date	:		11/03/2014

##  Description :		This file contains function for Webservices 

## *****************************************************************



App::uses('AppController', 'Controller');

App::uses('CakeTime', 'Utility');

/**

 * Static content controller

 *

 * Override this controller by placing a copy in controllers directory of an application

 *

 * @package       app.Controller

 * @link http://book.cakephp.org/2.0/en/controllers/members-controller.html

 */

	class WebservicesController extends AppController {



		public $name 		= 'Webservices';

		public $helpers 	= array('Html','Session');

		

		public $uses 		= array('Country','Member','Club','Trainer','Corporation','Trainee','CertificationOrganization','Certification','Degree','Page','Nutritional','ClubBranch','CorporationBranch','CorporationContact','Employee','TraineeClub','TraineeTrainer','ScheduleCalendar','SevensiteBodyfat','ThreesiteBodyfat','BodymassIndex','EstimatedenergyRequirement','FoodNutritionLog','AdddailyNutritionDiary','CertificationTrainers','ExerciseHistorys','Goal','WarmUps','CoreBalancePlyometric','SpeedAgilityQuickness','Resistence','CoolDown','WorkOuts','ExerciseLibrary','FoodUsda','Emessage','Event','Subscription','Gallery','Form','Doc','Payment','MessageBoard','TempWorkout','WorkoutCategory','Measurement','TraineesessionPurchase');

		public $components  = array('Upload','Autharb','Email');			

	

	

		public function login($username=null,$password=null,$usertype=null){

			

				$this->layout = "ajax";

			   // $this->autoRender=false;

			   /* echo "<pre>"; print_r($_REQUEST); echo"</pre>";	

			    die();	*/		    		    

			    $username = trim($_REQUEST['username']);

				$password = trim($_REQUEST['password']);

				$usertype = trim($_REQUEST['usertype']);

				

				

				if($username!='' && $password!='' && $usertype!='')

				{

				

				$condition= array('username'=>$username,'password'=>$password,'status'=>'1');	

							

				

				$dbusertype =$usertype;					  				

				

			 	

				$data_array = $this->$dbusertype->find('first',array('conditions'=>$condition));

				$data_array2=array();

				if($dbusertype=='Club')

				{

					if(empty($data_array))

					{

						

						$condition= array('ClubBranch.username'=>$username,'ClubBranch.password'=>$password);	

						$data_array2 = $this->ClubBranch->find('first',array('conditions'=>$condition));

						if (!empty($data_array2))

				         {

						$this->Session->write('subusertype','Club Branch');

						$this->Session->write('subuser', $data_array2['ClubBranch']['id']);			

						

						$this->Session->write('USER_ID', $data_array2['ClubBranch']['id']);

						$this->Session->write('USER_NAME', $data_array2['ClubBranch']['username']);

						$this->Session->write('UNAME', $data_array2['ClubBranch']['first_name']);

						$this->Session->write('UTYPE', 'Club');

						

						$vdata=array();

						$vdata[$dbusertype]['id']=$data_array2[$dbusertype]['id'];

						$vdata[$dbusertype]['login_status']='1';		

						/* echo '<pre>';

						 print_r($data_array2);

						 echo '</pre>';

						die();*/

						$callresponse=array('status'=>'True','UserId'=>$data_array2['ClubBranch']['id'],'Subuser'=>'Club Branch');

						$callresponse2=json_encode($callresponse);

						$this->set('flagv', $callresponse2);

								

						

						

				         }

				         

					}

					

				}

				

				

				if (!empty($data_array))

				{			

					

					$this->Session->write('USER_ID', $data_array[$dbusertype]['id']);

					$this->Session->write('USER_NAME', $data_array[$dbusertype]['username']);

					$this->Session->write('UNAME', $data_array[$dbusertype]['first_name']);

					$this->Session->write('UTYPE', $dbusertype);

					//echo "<pre>"; print_r($_SESSION); echo"</pre>";exit;	

					//$this->redirect(array('controller'=>'Home','action'=>'Index'));

					//$this->Session->setFlash('User Logged-In successfully.');	

					$vdata=array();

					$vdata[$dbusertype]['id']=$data_array[$dbusertype]['id'];

					$vdata[$dbusertype]['login_status']='1';

					

					

					

					if($this->$dbusertype->save($vdata)) {	

						$callresponse=array('status'=>'True','UserId'=>$data_array[$dbusertype]['id'],'Subuser'=>'');

						$callresponse2=json_encode($callresponse);

						$this->set('flagv', $callresponse2);

						

					}							

			    }

				else 

				{	

					if(empty($data_array2) && empty($data_array))

					{					

					$callresponse=array('status'=>'False','error_mes'=>'not valid user name and password');

					$callresponse2=json_encode($callresponse);

						$this->set('flagv', $callresponse2);	

					}				

				}	

				}

				else {

					$callresponse=array('status'=>'False','error_mes'=>'Please Enter Vaild Data');

					$callresponse2=json_encode($callresponse);

						$this->set('flagv', $callresponse2);			

				}

		}

		

		public function forgotpassword()

		{

			    $this->layout = "ajax";

				$useremail=trim($_REQUEST['email']);

				$usertype=trim($_REQUEST['usertype']);

				if($useremail!='' && $usertype!='')

				{

				    $condition= array('email'=>$useremail,'status'=>'1');

				    $dbusertype =$usertype;	

				    $data_array = $this->$dbusertype->find('first',array('conditions'=>$condition));		

					    if(!empty($data_array))

					    {		

							$usernm=$data_array[$dbusertype]['first_name'];

							$usernme=$data_array[$dbusertype]['username'];

							$usernpw=$data_array[$dbusertype]['password'];

							$to=$useremail;

						

						$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$usernm.'!</p>

						<p>'.$usernm.' '.$this->config["base_title"].' Credential given below. </p>

						

						<p>Email : '.trim($_REQUEST['email']).'</p>

						<p>Password : '.$usernpw.'</p>

						<p>User Type : '.$dbusertype.'</p>';

						

						

						$content .= '</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

											

									

									

															 

									$subject = $this->config["base_title"]." : Credential Recovery"; 

								  

									

						

						$this->sendEmailMessage($to,$subject,$content,null,null);

						

						$callresponse=array('status'=>'True','result'=>'Your credential has been sent you your registered email address.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

				      }

				      else {

						$callresponse=array('status'=>'False','result'=>'Sorry, you email address not valid. Please re-enter email address and select your user type.');

						$callresponse2=json_encode($callresponse);

						$this->set('flagv', $callresponse2);

					

					  }		

					

					}

					else {

						$callresponse=array('status'=>'False','result'=>'Please enter email address and select your user type.');

						$callresponse2=json_encode($callresponse);

						$this->set('flagv', $callresponse2);

					

					}			

				

		}

		

		public function registration()

		{

			    $this->layout = "ajax";

				$useremail=trim($_REQUEST['email']);

				$usertype=trim($_REQUEST['usertype']);

				

				

				

				if($usertype=='Trainer')

				{

					$expld=explode("@",$useremail);

					$usernm=trim($expld[0]);

				}

				else {

					$usernm=trim($_REQUEST['username']);

				}

				$usernm=$useremail;

				

			/*	address = synapse;

    city = noida;

    country = 1234;

    email = "an@sampatti.com";

    "first_name" = anil;

    "last_name" = jain;

    password = 123456;

    phone = 123456;

    state = UP;

    username = Anil;

    usertype = Trainer;

    zip = 201301;*/

			

			$this->data=array();

				

    //$this->request->data[$usertype]["username"]

				

				$this->request->data[$usertype]["username"]=trim($usernm);

				

				$this->request->data[$usertype]["email"]=trim($_REQUEST['email']);

				$this->request->data[$usertype]["password"]=trim($_REQUEST['password']);

				$this->request->data[$usertype]["address"]=trim($_REQUEST['address']);

				$this->request->data[$usertype]["city"]=trim($_REQUEST['city']);

				$this->request->data[$usertype]["state"]=trim($_REQUEST['state']);

				$this->request->data[$usertype]["zip"]=trim($_REQUEST['zip']);

				$this->request->data[$usertype]["country"]=trim($_REQUEST['country']);

				$this->request->data[$usertype]["phone"]=trim($_REQUEST['phone']);

				

				

				

				$this->request->data[$usertype]["status"]=1;

			    if($usertype=='Trainer')

				{

					$this->request->data[$usertype]["trainer_type"]='I';

				}

				if($usertype=='Trainee')

				{

					$this->request->data[$usertype]["created_date"]=date('Y-m-d H:i:s');

				    $this->request->data[$usertype]["update_date"]=date('Y-m-d H:i:s');

				}

				else 

				{

				  $this->request->data[$usertype]["added_date"]=date('Y-m-d H:i:s');

				  $this->request->data[$usertype]["modified_date"]=date('Y-m-d H:i:s');	

				}

				

				if($usertype!='Corporation')

				{

					$this->request->data[$usertype]["first_name"]=trim($_REQUEST['first_name']);

				$this->request->data[$usertype]["last_name"]=trim($_REQUEST['last_name']);

				}else{

					$this->request->data[$usertype]["company_name"]=trim($_REQUEST['company_name']);

				}

					

				    $condition= array('email'=>$useremail);				    

				    $data_array1 = $this->$usertype->find('first',array('conditions'=>$condition));

				    

				     $condition= array('username'=>$usernm);				    

				    $data_array2 = $this->$usertype->find('first',array('conditions'=>$condition));	

				    

				    

				    

				    

				if(empty($data_array1) && empty($data_array2))

				{

					if(strlen($this->request->data[$usertype]["password"])>=8)

					{

						if($this->$usertype->save($this->data)) {
							 $dbusertype=$usertype;
							if($usertype=='Trainee')
							{
								$dbusertype='Client';
							}

							

							$usrid=$this->$usertype->getLastInsertId();

								$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$usernm.'!</p>

						<p>'.$usernm.' '.$this->config["base_title"].' Credential given below. </p>

						

						<p>Email : '.trim($_REQUEST['email']).'</p>

						<p>Password : '.trim($_REQUEST['password']).'</p>

						<p>User Type : '.$dbusertype.'</p>';

						

						

						$content .= '</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

											

						$subject = $this->config["base_title"]." : Registration has been completed successfully."; 

								  

									

						$to=trim($_REQUEST['email']);

						 if($this->sendEmailMessage($to,$subject,$content,null,null)){

							 	$callresponse=array('status'=>'True','userid'=>$usrid,'result'=>'Your Registration has been completed successfully and notify your registered email address.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

							 }

							else {

								$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

							}

						

							

						

							

						} else {

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

							

							

						}

					}

					else {

						$callresponse=array('status'=>'False','result'=>'Please enter the password atleast 8 charactor.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

					}

				}

				else 

				{

                       if(!empty($data_array2))

                       {

					         $callresponse=array('status'=>'False','result'=>'Sorry this username already exist in our database.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

                       }	

                       

                        if(!empty($data_array1))

                       {

					         $callresponse=array('status'=>'False','result'=>'Sorry this email address already exist in our database.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

                       }	

					

				}

				

				

		}

		

		public function countriesshow()

		{

			  $this->layout = "ajax";

				$countries=$this->Country->find('all',array('fields'=>array('Country.id','Country.name')));

				$countries2=array();

				foreach ($countries as $key=>$val)

				{

					$countries2[]=$val['Country'];

				}

			       $callresponse=array('result'=>$countries2);

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

		}

		

		public function nutrionalguiderq()

		{	

			$this->layout = "ajax";

			

			$useremail=trim($_REQUEST['email']);

				$fname=trim($_REQUEST['fname']);

				$lname=trim($_REQUEST['lname']);

				$phn=trim($_REQUEST['phone']);

			

			if(trim($_REQUEST['fname'])!='' && trim($_REQUEST['lname'])!='' && trim($_REQUEST['email'])!='')

			{

			 				

							

							$user_names=$_POST['fname'].' '.$_POST['lname'];

							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

				<p>Thanks for the visiting '.$this->config["base_title"].' site. </p>

				<p>Please find below Attachement for the Nutritional Guides</p>

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

							

													 

							$subject = $this->config["base_title"]." : Nutritional Guide"; 

						  

							$nutri = $this->Nutritional->find("all",array("fields"=>array("guide_file"),"conditions"=>array("Nutritional.status"=>1)));                  

							$attachments=array();

							foreach($nutri as $key=>$val)

							{

																

								$attachments[]=$this->config["upload_path"].$val['Nutritional']['guide_file'];

								

							}

							

							

							

									$this->sendEmailMessageAttachment($_POST['email'],$subject,$content,null,null,$attachments);

									$callresponse=array('status'=>'True','result'=>'Thanks for the visiting our app, we have sent Nutritional Guides on your email address..');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

								

			}else {

			             	$callresponse=array('status'=>'False','result'=>'Please enter vaild data.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

			}

			

			

		}

		

		public function editprofile()

		{

			    $this->layout = "ajax";				

				$usertype=trim($_REQUEST['usertype']);

				$usrid=trim($_REQUEST['id']);				

			    $this->data=array();

				$this->request->data[$usertype]["username"]=trim($_REQUEST['email']);

				$this->request->data[$usertype]["email"]=trim($_REQUEST['email']);

				$this->request->data[$usertype]["password"]=trim($_REQUEST['password']);

				$this->request->data[$usertype]["address"]=trim($_REQUEST['address']);

				$this->request->data[$usertype]["city"]=trim($_REQUEST['city']);

				$this->request->data[$usertype]["state"]=trim($_REQUEST['state']);

				$this->request->data[$usertype]["zip"]=trim($_REQUEST['zip']);

				$this->request->data[$usertype]["country"]=trim($_REQUEST['country']);

				$this->request->data[$usertype]["phone"]=trim($_REQUEST['phone']);

				$this->request->data[$usertype]["mobile"]=trim($_REQUEST['mobile']);

				$this->request->data[$usertype]["publicproname"]=trim($_REQUEST['publicproname']);

				$this->request->data[$usertype]["id"]=trim($_REQUEST['id']);

				

				

				

				$this->request->data[$usertype]["status"]=1;

			    if($usertype=='Trainer')

				{

					//$this->request->data[$usertype]["trainer_type"]='I';

				}

				if($usertype=='Trainee')

				{

					//$this->request->data[$usertype]["created_date"]=date('Y-m-d H:i:s');

				    $this->request->data[$usertype]["update_date"]=date('Y-m-d H:i:s');

				}

				else 

				{

				 // $this->request->data[$usertype]["added_date"]=date('Y-m-d H:i:s');

				  $this->request->data[$usertype]["modified_date"]=date('Y-m-d H:i:s');	

				}

				

				if($usertype!='Corporation')

				{

					$this->request->data[$usertype]["first_name"]=trim($_REQUEST['first_name']);

				    $this->request->data[$usertype]["last_name"]=trim($_REQUEST['last_name']);

				    $this->request->data[$usertype]["about_us"]=trim($_REQUEST['about_us']);

				}else{

					$this->request->data[$usertype]["company_name"]=trim($_REQUEST['company_name']);

					$this->request->data[$usertype]["about_us"]=trim($_REQUEST['about_us']);

				}				

				   		    

				    $data_array1 = array();

				    				    

				    $data_array2 = array();	

				    

				if(empty($data_array1) && empty($data_array2))

				{

					if(strlen($this->request->data[$usertype]["password"])>=8)

					{

						if($this->$usertype->save($this->data)) {						

						$callresponse=array('status'=>'True','userid'=>$usrid,'result'=>'Your Profile has been updated successfully.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

							

						} else {

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

						}

					}

					else {

						$callresponse=array('status'=>'False','result'=>'Please enter the password atleast 8 charactor.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

					}

				}

				else 

				{

                       if(!empty($data_array2))

                       {

					         $callresponse=array('status'=>'False','result'=>'Sorry this username already exist in our database.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

                       }	

                       

                        if(!empty($data_array1))

                       {

					         $callresponse=array('status'=>'False','result'=>'Sorry this email address already exist in our database.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

                       }	

					

				}

		}

		

		public function editprofileclub()

		{

			

			

		    $this->layout = "ajax";			

		    

		     $subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']);

			 

		    if($subuser!='')

		    {

		    		    

			$dbusertype = 'ClubBranch';				

		    

		    }

		 

			

			

			if(!empty($this->data)){

			

			$this->$dbusertype->set($this->data);

			$this->$dbusertype->id = $id;		

			

			$this->request->data[$dbusertype]["username"] 		    = trim($_REQUEST['email']);

			$this->request->data[$dbusertype]["first_name"] 		    = trim($_REQUEST['first_name']);

			$this->request->data[$dbusertype]["last_name"] 		    = trim($_REQUEST['last_name']);

			if($subuser!='')

		    {

		    

			//$this->request->data[$dbusertype]["branch_name"] 		    = trim($_REQUEST['club_name']);

		    }

		    else {

		    	 

			//$this->request->data[$dbusertype]["club_name"] 		    = trim($_REQUEST['club_name']);

		    }

			$this->request->data[$dbusertype]["email"] 		    = trim($_REQUEST['email']);

			$this->request->data[$dbusertype]["password"] 		    = trim($_REQUEST['password']);

			$this->request->data[$dbusertype]["address"] 		    = trim($_REQUEST['address']);

			$this->request->data[$dbusertype]["city"] 		    = trim($_REQUEST['city']);

			$this->request->data[$dbusertype]["state"] 		    = trim($_REQUEST['state']);

			$this->request->data[$dbusertype]["country"] 		    = trim($_REQUEST['country']);

			$this->request->data[$dbusertype]["zip"] 		    = trim($_REQUEST['zip']);

			$this->request->data[$dbusertype]["no_trainer"] 		    = trim($_REQUEST['no_trainer']);

			$this->request->data[$dbusertype]["phone"] 		    = trim($_REQUEST['phone']);

			$this->request->data[$dbusertype]["about_us"] 		    = trim($_REQUEST['about_us']);

		

			//$this->request->data[$dbusertype]['id']=$id;

			

							

			if($this->$dbusertype->validates()) {

				

				

				$this->request->data[$dbusertype]["modified_date"] 		    = date("Y-m-d h:i:s");

				

				/*echo '<pre>';

				print_r($this->data);

				echo '</pre>';

				die();*/

				if($this->$dbusertype->save($this->data)) {

					

					$callresponse=array('status'=>'True','userid'=>$usrid,'result'=>'Your Profile has been updated successfully.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

				} else {

					$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

				}

			}

			else 

			{

				$callresponse=array('status'=>'False','result'=>'Username/Email Address Already Exist.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

			}

							

		 } 

			

		}

		

		public function userfbstatus()

		    {	

			$this->layout = "ajax";

			

			   $dbusertype=trim($_REQUEST['usertype']);

				$uid=trim($_REQUEST['id']);

			$this->set("dbusertype",$dbusertype);

		

			if(trim($_POST['userfb_status'])!='')

			{

			$this->request->data[$dbusertype]["userfb_status"]=$_POST['userfb_status'];

			$this->request->data[$dbusertype]["id"]=$_POST['id'];

			

			if($this->$dbusertype->save($this->data))

			{

				//$this->set("data",'1');

				 $callresponse=array('status'=>'True','result'=>'Your Status has been updated successfully.','status_result'=>$_POST['userfb_status']);

				 $callresponse2=json_encode($callresponse);

				$this->set('flagv', $callresponse2);

			}

			else {

				               $callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

			}

			}else {

				               $callresponse=array('status'=>'False','result'=>'Please fill the status!!!!');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

			}

		}

		

	public function userfbstatusget()

		{

			$this->layout = "ajax";

			$dbusertype=trim($_REQUEST['usertype']);

				$uid=trim($_REQUEST['id']);

			$this->set("dbusertype",$dbusertype);

			$id=$_POST['id'];

			$setArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

			 $userfb_status=$setArr[$dbusertype]['userfb_status'];

		   if($userfb_status!='')

		    {

		      

		    	$callresponse=array('status'=>'True','result'=>$userfb_status);

				 $callresponse2=json_encode($callresponse);

				$this->set('flagv', $callresponse2);

		    }

		    else {

				               $callresponse=array('status'=>'False','result'=>'Please set your status!!!');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

			}

		}

		

    public function profilegetinfo()

		{

              $this->layout = "ajax";

			

			//$dbusertype='Trainer';

			$uid=trim($_REQUEST['id']);

			//$uid=1;

			 $subuser=trim($_REQUEST['Subuser']);

			if( $subuser!='')

			{

				$dbusertype='ClubBranch';

			}

			else {

			$dbusertype=trim($_REQUEST['usertype']);	

			}

			

			$this->set("dbusertype",$dbusertype);

			$setArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

			/*echo '<pre>';

			print_r($setArr);

			echo '</pre>';

			die();*/

			if(!empty($setArr))

			{

				$profilepid=$config['url'].'images/avtar.png';

				$coverpic=$config['url'].'images/profile_bg.jpg';

				

				if($dbusertype=='Trainee')

				{

					if($setArr[$dbusertype]['photo']!='')

					{

						$profilepid=$config['url'].'uploads/'.$setArr[$dbusertype]['photo'];

					}

				}

				else {

					if($setArr[$dbusertype]['logo']!='')

					{

						$profilepid=$config['url'].'uploads/'.$setArr[$dbusertype]['logo'];

					}

				}

				

				if($setArr[$dbusertype]['cpic']!='')

				{

					$coverpic=$config['url'].'uploads/'.$setArr[$dbusertype]['cpic'];

				}

				

			$callresponse=array('status'=>'True','result'=>$setArr,'coverpic'=>$coverpic,'profilepic'=>$profilepid);

				 $callresponse2=json_encode($callresponse);

				$this->set('flagv', $callresponse2);

			}

			else {

				               $callresponse=array('status'=>'False','result'=>'Sorry, you are not valid user!!!');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

			}

		}



	 public function uploadcover()

		{

              $this->layout = "ajax";

			$dbusertype=trim($_REQUEST['usertype']);

			//$dbusertype='Trainer';

			$uid=trim($_REQUEST['id']);

			//$uid=1;

			

			

			$this->$dbusertype->set($this->data);

			$this->$dbusertype->id = $id;	

			

			  if(!empty($_FILES["photo"]["name"]))

				{

					$filename = $_FILES["photo"]["name"];

					$target = $this->config["upload_path"];

					$this->Upload->upload($_FILES["photo"], $target, null, null);

					$coverpic = $this->Upload->result; 

  					$this->request->data["$dbusertype"]["cpic"] = $coverpic;

  					//$picPath = $this->config["upload_path"].$this->request->data["$dbusertype"]["old_covimage"];

					//@unlink($picPath);

					

					$this->request->data["$dbusertype"]["id"] 		    = $uid;

					if($this->$dbusertype->save($this->data)) {

					$coverpic='uploads/'.$coverpic;

						$callresponse=array('status'=>'True','result'=>'Cover Pic Uploaded Successfully.','coverpic'=>$coverpic);

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							

					} else {

					$callresponse=array('status'=>'False','result'=>'Sorry,not uploaded!!!');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

					}

				}

			

		}

		

	public function uploadprofilepic()

		{

              $this->layout = "ajax";

			$dbusertype=trim($_REQUEST['usertype']);

			//$dbusertype='Trainer';

			$uid=trim($_REQUEST['id']);

			//$uid=1;

			

			

			$this->$dbusertype->set($this->data);

			$this->$dbusertype->id = $id;	

			

			  if(!empty($_FILES["photo"]["name"]))

				{

					$filename = $_FILES["photo"]["name"];

					$target = $this->config["upload_path"];

					$this->Upload->upload($_FILES["photo"], $target, null, null);

					

					$upfield='logo';

					if($dbusertype=='Trainee')

					{

						$upfield='photo';

					}

					$profilepic=$this->Upload->result;

  					$this->request->data["$dbusertype"][$upfield] = $profilepic; 

  					//$picPath = $this->config["upload_path"].$this->request->data["$dbusertype"]["old_covimage"];

					//@unlink($picPath);

					

					$this->request->data["$dbusertype"]["id"] 		    = $uid;

					if($this->$dbusertype->save($this->data)) {

					$profilepic='uploads/'.$profilepic;

						$callresponse=array('status'=>'True','result'=>'Profile Pic Uploaded Successfully.','profilepic'=>$profilepic);

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							

					} else {

					$callresponse=array('status'=>'False','result'=>'Sorry,not uploaded!!!');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

					}

				}

			

		}

		

		

	public function corporationmybranch()

		{

			 $this->layout = "ajax";

			$dbusertype=trim($_REQUEST['usertype']);	

			$id = trim($_REQUEST['id']);

			 

			 $branches=$this->CorporationBranch->find('all',array("conditions"=>array("CorporationBranch.corporation_id"=>$id),'fields'=>array('CorporationBranch.id','CorporationBranch.branch_name','CorporationBranch.email')));

						

			if(!empty($branches))

			{

			

			         $callresponse=array('status'=>'True','result'=>$branches);

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

			}

			else {

				       $callresponse=array('status'=>'False','result'=>'Sorry, Records not exist.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

			}

			

		}	

		

		public function deletecorpbranch()

		{

			 $this->layout = "ajax";

			

			if(trim($_POST['id'])!='')

			{

				$datav=array();				

				$datav['id']=trim($_POST['id']);

				if($this->CorporationBranch->delete($datav)) {

							

							  $callresponse=array('status'=>'True','result'=>'Successfully deleted.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

						else {

							

							

							

							$callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

			}

			else 

			{

				

				$callresponse=array('status'=>'False','result'=>'Please select the branch.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

			

			

				

			

		}

		

	public function deletecorpemp()

		{

			 $this->layout = "ajax";

			

			if(trim($_POST['id'])!='')

			{

				$datav=array();				

				$datav['id']=trim($_POST['id']);

				if($this->Employee->delete($datav)) {

							

							  $callresponse=array('status'=>'True','result'=>'Successfully deleted.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

						else {

							

							

							

							$callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

			}

			else 

			{

				

				$callresponse=array('status'=>'False','result'=>'Please select the branch.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

			

			

				

			

		}

		

	public function deletecorpcontact()

		{

			 $this->layout = "ajax";

			

			if(trim($_POST['id'])!='')

			{

				$datav=array();				

				$datav['id']=trim($_POST['id']);

				if($this->CorporationContact->delete($datav)) {

							

							  $callresponse=array('status'=>'True','result'=>'Successfully deleted.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

						else {

							

							

							

							$callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

			}

			else 

			{

				

				$callresponse=array('status'=>'False','result'=>'Please select the branch.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

			

			

				

			

		}

		

		

			

	public function corporationmycontact()

		{

			 $this->layout = "ajax";

			$dbusertype=trim($_REQUEST['usertype']);	

			$id = trim($_REQUEST['id']);

			 

			

			 

			 $setSvftArr=$this->CorporationContact->find("all",array("conditions"=>array("CorporationContact.corporation_id"=>$id), 'order' => array('CorporationContact.id' => 'DESC')));

						

			if(!empty($setSvftArr))

			{

			

			         $callresponse=array('status'=>'True','result'=>$setSvftArr);

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

			}

			else {

				       $callresponse=array('status'=>'False','result'=>'Sorry, Records not exist.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

			}

			

		}	

		

	public function corporationmyemp()

		{

			 $this->layout = "ajax";

			$dbusertype=trim($_REQUEST['usertype']);	

			 //$dbusertype='Corporation';

		    $id = trim($_REQUEST['id']);

		   // $id ='1';

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $this->set("setSpecalistArr",$setSpecalistArr);

			$countries=$this->Country->find('list',array('fields'=>array('Country.id','Country.name')));

			$tranrsdata=$this->Employee->find('all',array('conditions'=>array('Employee.corporation_id'=>$id),'fields'=>array('Employee.id','Employee.full_name','Employee.address','Employee.email')));

						

			if(!empty($tranrsdata))

			{

			

			           $callresponse=array('status'=>'True','result'=>$tranrsdata);

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

			}

			else {

				       $callresponse=array('status'=>'False','result'=>'Sorry, Records not exist.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

			}

			

		}

		

		public function add_employeegui(){

			 $this->layout = "ajax";

			$dbusertype = $this->Session->read('UTYPE');	

			$id = trim($_REQUEST['id']);

			 $countries=$this->Country->find('list',array('fields'=>array('Country.id','Country.name')));

			 $branches=$this->CorporationBranch->find('list',array("conditions"=>array("CorporationBranch.corporation_id"=>$id),'fields'=>array('CorporationBranch.id','CorporationBranch.branch_name')));

			 

			           $callresponse=array('status'=>'True','result'=>'GUI','corporation_branch'=>$branches);

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

			

		}



		public function add_employee(){

				

			  $this->layout = "ajax";							

			

			$id = trim($_REQUEST['id']);

			/*$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setSpecalistArr",$setSpecalistArr);*/ 

			

			

					    $this->request->data["Employee"]["username"] = trim($_REQUEST['email']);							

					    $this->request->data["Employee"]["first_name"] = trim($_REQUEST['first_name']);							

					    $this->request->data["Employee"]["last_name"] = trim($_REQUEST['last_name']);							

					    $this->request->data["Employee"]["designation"] = trim($_REQUEST['designation']);							

					    $this->request->data["Employee"]["email"] = trim($_REQUEST['email']);							

					    $this->request->data["Employee"]["password"] = trim($_REQUEST['password']);							

					    $this->request->data["Employee"]["address"] = trim($_REQUEST['address']);							

					    $this->request->data["Employee"]["city"] = trim($_REQUEST['city']);							

					    $this->request->data["Employee"]["state"] = trim($_REQUEST['state']);							

					    $this->request->data["Employee"]["country"] = trim($_REQUEST['country']);							

					    $this->request->data["Employee"]["zip"] = trim($_REQUEST['zip']);							

					    $this->request->data["Employee"]["phone"] = trim($_REQUEST['phone']);							

					    $this->request->data["Employee"]["mobile"] = trim($_REQUEST['mobile']);							

					    $this->request->data["Employee"]["branch_id"] = trim($_REQUEST['branch_id']);							

					    $this->request->data["Employee"]["corporation_id"] = $id;							

					    $this->request->data["Employee"]["notification_status"] = '1';							

					    $this->request->data["Employee"]["trainee_flag"] = '1';							

					    $this->request->data["Employee"]["photo"] = '';	

					    $this->request->data["Employee"]["created_date"]= date("Y-m-d h:i:s");

						$this->request->data["Employee"]["update_date"]= date("Y-m-d h:i:s");	

					    

						//$this->request->data['Employee']['trainee_flag']==1;	

						

						/*echo "<pre>";

						print_r($this->request->data);

						echo "</pre>";

						die('here');*/

						if($this->Employee->save($this->request->data["Employee"])) {

							

							

							if(isset($this->request->data['Employee']['trainee_flag']) &&($this->request->data['Employee']['trainee_flag']==1)){

								

								$makeTrainee=array();

								$makeTrainee['Trainee']['employee_id']=$this->Employee->getInsertID();

								$makeTrainee['Trainee']['corporation_id']=$this->request->data['Employee']['corporation_id'];

								$makeTrainee['Trainee']['corporation_branch_id']=$this->request->data['Employee']['branch_id'];

								//$makeTrainee['Trainee']['date_enrolled']=$this->request->data['Employee']['date_enrolled'];

								$makeTrainee['Trainee']['mobile']=$this->request->data['Employee']['mobile'];

								$makeTrainee['Trainee']['phone']=$this->request->data['Employee']['phone'];

								$makeTrainee['Trainee']['notification_status']=$this->request->data['Employee']['notification_status'];

								$makeTrainee['Trainee']['update_date']=$this->request->data["Employee"]["update_date"];

								$makeTrainee['Trainee']['created_date']=$this->request->data["Employee"]["created_date"];

								$makeTrainee['Trainee']['status']=1;

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

								$this->Trainee->set($makeTrainee['Trainee']);

							$this->Trainee->save($makeTrainee['Trainee']);

							

						}

							

									

							

							

							

							

							$usernm=$makeTrainee['Trainee']['first_name'];

							$usernme=$makeTrainee['Trainee']['email'];

							$usernpw=$makeTrainee['Trainee']['password'];

							$to=$makeTrainee['Trainee']['email'];

							

							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$usernm.'!</p>

							<p>'.$usernm.' '.$this->config["base_title"].' Credential given below. </p>

							

							<p>Email : '.$usernme.'</p>

							<p>Password : '.$usernpw.'</p>

							<p>User Type : Client </p>';

							

							

							$content .= '</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

									

							

							

													 

							$subject = $this->config["base_title"]." : Client Registration Successfully"; 

							

							

							

							if($this->sendEmailMessage($to,$subject,$content,null,null)){

							

							$callresponse=array('status'=>'True','result'=>'Employee has been created successfully.');

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

							}else{

								$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try with different email.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							}

				       

						} else {

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							

						}

				

		}

		

	public function view_employee(){

		

		 $this->layout = "ajax";							

			

			$id = trim($_REQUEST['id']);

				//Employee

			 $setSpecalistArr=$this->Employee->find("first",array("conditions"=>array("Employee.id"=>$id)));

			 if(!empty($setSpecalistArr))

			 {

			 	     $callresponse=array('status'=>'True','result'=>$setSpecalistArr);

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

			 }

			 else {

			 	$callresponse=array('status'=>'False','result'=>'Sorry, not found.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

			 }

			}

		

		public function view_branch(){

		

		 $this->layout = "ajax";							

			

			$id = trim($_REQUEST['id']);

				//Employee

			 $setSpecalistArr=$this->CorporationBranch->find("first",array("conditions"=>array("CorporationBranch.id"=>$id)));

			 if(!empty($setSpecalistArr))

			 {

			 	     $callresponse=array('status'=>'True','result'=>$setSpecalistArr);

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

			 }

			 else {

			 	$callresponse=array('status'=>'False','result'=>'Sorry, not found.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

			 }

			}		

		

		public function add_corpbranch(){

				

			  $this->layout = "ajax";							

			

			$id = trim($_REQUEST['id']);

			/*$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setSpecalistArr",$setSpecalistArr);*/ 

			

			

					    $this->request->data["CorporationBranch"]["username"] = trim($_REQUEST['email']);							

					    $this->request->data["CorporationBranch"]["first_name"] = trim($_REQUEST['first_name']);							

					    $this->request->data["CorporationBranch"]["last_name"] = trim($_REQUEST['last_name']);							

					    $this->request->data["CorporationBranch"]["branch_name"] = trim($_REQUEST['branch_name']);							

					    $this->request->data["CorporationBranch"]["email"] = trim($_REQUEST['email']);							

					    $this->request->data["CorporationBranch"]["password"] = trim($_REQUEST['password']);							

					    $this->request->data["CorporationBranch"]["address"] = trim($_REQUEST['address']);							

					    $this->request->data["CorporationBranch"]["city"] = trim($_REQUEST['city']);							

					    $this->request->data["CorporationBranch"]["state"] = trim($_REQUEST['state']);							

					    $this->request->data["CorporationBranch"]["country"] = trim($_REQUEST['country']);							

					    $this->request->data["CorporationBranch"]["zip"] = trim($_REQUEST['zip']);							

					    $this->request->data["CorporationBranch"]["phone"] = trim($_REQUEST['phone']);							

					    $this->request->data["CorporationBranch"]["mobile"] = trim($_REQUEST['mobile']);							

					 						

					    $this->request->data["CorporationBranch"]["corporation_id"] = $id;							

					    $this->request->data["CorporationBranch"]["notification_status"] = '1';							

					  	$this->request->data["CorporationBranch"]["no_trainer"] = trim($_REQUEST['no_trainer']);				

					    $this->request->data["CorporationBranch"]["photo"] = '';	

					    $this->request->data["CorporationBranch"]["added_date"]= date("Y-m-d h:i:s");

						$this->request->data["CorporationBranch"]["modified_date"]= date("Y-m-d h:i:s");	

					    

						//$this->request->data['Employee']['trainee_flag']==1;	

					$this->CorporationBranch->set($this->data);	

					if($this->CorporationBranch->validates()) {

						if($this->CorporationBranch->save($this->data['CorporationBranch'])) {

							

						

							

									

							

							

							

							

							$usernm=trim($_REQUEST['first_name']);

							$usernme=trim($_REQUEST['email']);

							$usernpw=trim($_REQUEST['password']);	

							$to=trim($_REQUEST['email']);

							

							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$usernm.'!</p>

							<p>'.$usernm.' '.$this->config["base_title"].' Credential given below. </p>

							

							<p>Email : '.$usernme.'</p>

							<p>Password : '.$usernpw.'</p>

							<p>User Type : Corporation </p>';

							

							

							$content .= '</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

									

							

							

													 

							$subject = $this->config["base_title"]." : Corporation Branch Registration Successfully"; 

							

							

							

							$this->sendEmailMessage($to,$subject,$content,null,null);

							

							$callresponse=array('status'=>'True','result'=>'Corporation Branch has been created successfully.');

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

				       

						} else {

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							

						}

					}

					else {

							$callresponse=array('status'=>'False','result'=>'Username/Email Address Already Exist.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							

						}

				

		}

		

		public function edit_corpbranch(){

				

			  $this->layout = "ajax";							

			

			

			 $subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']);

			 

			

					

			 $this->request->data["CorporationBranch"]["username"] = trim($_REQUEST['email']);							

			 $this->request->data["CorporationBranch"]["first_name"] = trim($_REQUEST['first_name']);							

			 $this->request->data["CorporationBranch"]["last_name"] = trim($_REQUEST['last_name']);							

			 $this->request->data["CorporationBranch"]["branch_name"] = trim($_REQUEST['branch_name']);							

			 $this->request->data["CorporationBranch"]["email"] = trim($_REQUEST['email']);							

			 $this->request->data["CorporationBranch"]["password"] = trim($_REQUEST['password']);							

			 $this->request->data["CorporationBranch"]["address"] = trim($_REQUEST['address']);							

			 $this->request->data["CorporationBranch"]["city"] = trim($_REQUEST['city']);							

			 $this->request->data["CorporationBranch"]["state"] = trim($_REQUEST['state']);							

			 $this->request->data["CorporationBranch"]["country"] = trim($_REQUEST['country']);							

			 $this->request->data["CorporationBranch"]["zip"] = trim($_REQUEST['zip']);							

			 $this->request->data["CorporationBranch"]["phone"] = trim($_REQUEST['phone']);							

			 $this->request->data["CorporationBranch"]["mobile"] = trim($_REQUEST['mobile']);							

			  						

			 $this->request->data["CorporationBranch"]["corporation_id"] = $id;							

			 $this->request->data["CorporationBranch"]["notification_status"] = '1';							

			 $this->request->data["CorporationBranch"]["no_trainer"] = trim($_REQUEST['no_trainer']);				

			 $this->request->data["CorporationBranch"]["photo"] = '';	

			 $this->request->data["CorporationBranch"]["added_date"]= date("Y-m-d h:i:s");

			 $this->request->data["CorporationBranch"]["modified_date"]= date("Y-m-d h:i:s");	

			

			

			

			 $this->CorporationBranch->set($this->data['CorporationBranch']);

			 $this->CorporationBranch->id = trim($_REQUEST['branch_id']);	



				if($this->CorporationBranch->validates()) {

			

					  						

						if($this->CorporationBranch->save($this->data['CorporationBranch'])) {

							

													

							

							$usernm=trim($_REQUEST['first_name']);

							$usernme=trim($_REQUEST['email']);

							$usernpw=trim($_REQUEST['password']);	

							$to=trim($_REQUEST['email']);

							

							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$usernm.'!</p>

							<p>'.$usernm.' '.$this->config["base_title"].' Credential given below. </p>

							

							<p>Email : '.$usernme.'</p>

							<p>Password : '.$usernpw.'</p>

							<p>User Type : Corporation </p>';

							

							

							$content .= '</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

									

							

							

													 

							$subject = $this->config["base_title"]." : Corporation Updated Successfully"; 

							

							

							

							$this->sendEmailMessage($to,$subject,$content,null,null);

							

							$callresponse=array('status'=>'True','result'=>'Corporation has been updated successfully.');

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

				       

						} else {

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							

						}

				}

				else 

				{

					$callresponse=array('status'=>'False','result'=>'Username/Email Address already exist.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

				}

		

				

		}	

			

		public function edit_employee(){

				

			  $this->layout = "ajax";							

			

			

			$subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']);

			 $employeeid=trim($_REQUEST['employee_id']);

			

					

			$this->request->data["Employee"]["username"] = trim($_REQUEST['email']);							

			$this->request->data["Employee"]["first_name"] = trim($_REQUEST['first_name']);							

			$this->request->data["Employee"]["last_name"] = trim($_REQUEST['last_name']);							

			$this->request->data["Employee"]["designation"] = trim($_REQUEST['designation']);							

			$this->request->data["Employee"]["email"] = trim($_REQUEST['email']);							

			$this->request->data["Employee"]["password"] = trim($_REQUEST['password']);							

			$this->request->data["Employee"]["address"] = trim($_REQUEST['address']);							

			$this->request->data["Employee"]["city"] = trim($_REQUEST['city']);							

			$this->request->data["Employee"]["state"] = trim($_REQUEST['state']);							

			$this->request->data["Employee"]["country"] = trim($_REQUEST['country']);							

			$this->request->data["Employee"]["zip"] = trim($_REQUEST['zip']);							

			$this->request->data["Employee"]["phone"] = trim($_REQUEST['phone']);							

			$this->request->data["Employee"]["mobile"] = trim($_REQUEST['mobile']);							

			$this->request->data["Employee"]["branch_id"] = trim($_REQUEST['branch_id']);							

			$this->request->data["Employee"]["corporation_id"] = $id;							

							

			

			$this->request->data["Employee"]["update_date"]= date("Y-m-d h:i:s");	

			

			

			

			$this->Employee->set($this->data['Employee']);

				$this->Employee->id = $employeeid;

//				echo '<pre>';

//				print_r($_POST);

//				echo '</pre>';

//				die();

				if($this->Employee->validates()) {

			

					  						

						if($this->Employee->save($this->data['Employee'])) {

							

													

							

							$usernm=trim($_REQUEST['first_name']);

							$usernme=trim($_REQUEST['email']);

							$usernpw=trim($_REQUEST['password']);

							$to=trim($_REQUEST['email']);

							

							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$usernm.'!</p>

							<p>'.$usernm.' '.$this->config["base_title"].' Credential given below. </p>

							

							<p>Email : '.$usernme.'</p>

							<p>Password : '.$usernpw.'</p>

							<p>User Type : Client </p>';

							

							

							$content .= '</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

									

							

							

													 

							$subject = $this->config["base_title"]." : Employee Updated Successfully"; 

							

							

							

							$this->sendEmailMessage($to,$subject,$content,null,null);

							

							$callresponse=array('status'=>'True','result'=>'Employee has been updated successfully.');

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

				       

						} else {

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							

						}

				}

				else 

				{

					$callresponse=array('status'=>'False','result'=>'Username/Email Address already exist.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

				}

		

				

		}

		

		

		public function manage_trainer()

		{

			   $this->layout = "ajax";

		   

			 //'Subuser'=>'Club Branch'

			 $subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']);

			 

		    if($subuser!='')

		    {

		    		    

			$dbusertype = 'ClubBranch';					

						

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setSpecalistArr",$setSpecalistArr);

		

			$tranrsdata=$this->Trainer->find('all',array('conditions'=>array('Trainer.club_branch_id'=>$id,'Trainer.trainer_type'=>'C'),'fields'=>array('Trainer.id','Trainer.full_name','Trainer.address','Trainer.email')));

			/*echo '<pre>';

			print_r($tranrsdata);

			echo '</pre>';

			die();*/

			$this->set("trainers",$tranrsdata);

					if(!empty($tranrsdata))

					{

					$callresponse=array('status'=>'True','result'=>$tranrsdata);

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

					}

					else {

						$callresponse=array('status'=>'False','result'=>'No Records Found.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

					}

		    }

		    else {

		    	

			

				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setSpecalistArr",$setSpecalistArr);

			

			$tranrsdata=$this->Trainer->find('all',array('conditions'=>array('Trainer.club_id'=>$id,'Trainer.trainer_type'=>'C'),'fields'=>array('Trainer.id','Trainer.full_name','Trainer.address','Trainer.email')));

			

			$this->set("trainers",$tranrsdata);

			if(!empty($tranrsdata))

					{

					$callresponse=array('status'=>'True','result'=>$tranrsdata);

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

					}

					else {

						$callresponse=array('status'=>'False','result'=>'No Records Found.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

					}

		    }

		    				

			

		}

		

		public function manage_client()

		{

			$this->layout = "ajax";

		   

			 //'Subuser'=>'Club Branch'

			 $subuser=trim($_REQUEST['Subuser']);

			

			 $id=trim($_REQUEST['id']);

			

		

			 $dbusertype=trim($_REQUEST['usertype']);

			 

		    if(trim($subuser)!='')

		    {

		    		    

			$dbusertype = 'ClubBranch';			

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setSpecalistArr",$setSpecalistArr);

			

			$tranrsdata=$this->Trainee->find('all',array('conditions'=>array('Trainee.club_branch_id'=>$id),'fields'=>array('Trainee.id','Trainee.username','Trainee.full_name','Trainee.address','Trainee.email')));

			if(!empty($tranrsdata))

					{

					$callresponse=array('status'=>'True','result'=>$tranrsdata);

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

					}

					else {

						$callresponse=array('status'=>'False','result'=>'No Client List Found.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

					}

			

		    } else {

		    	

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setSpecalistArr",$setSpecalistArr);

			if($dbusertype=='Trainer')

			{

				

				$tranrsdata=$this->Trainee->find('all',array('conditions'=>array('Trainee.trainer_id'=>$id),'fields'=>array('Trainee.id','Trainee.username','Trainee.full_name','Trainee.address','Trainee.email')));

			}

			if($dbusertype=='Club')

			{

				

				$tranrsdata=$this->Trainee->find('all',array('conditions'=>array('Trainee.club_id'=>$id),'fields'=>array('Trainee.id','Trainee.username','Trainee.full_name','Trainee.address','Trainee.email')));

			}

			

			  if(!empty($tranrsdata))

					{

					$callresponse=array('status'=>'True','result'=>$tranrsdata);

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

					}

					else {

						$callresponse=array('status'=>'False','result'=>'No Records Found.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

					}

			

		    }

			

				

			

		}

		

		

		public function clubbranchlist()

		{

			 $this->layout = "ajax";

			 $subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']);

			 if($subuser=='')

			 {

			$cbranchs=$this->ClubBranch->find('all',array("conditions"=>array("ClubBranch.club_id"=>$id),'fields'=>array('ClubBranch.id','ClubBranch.full_name','ClubBranch.branch_name','ClubBranch.email')));

			 if(!empty($cbranchs))

					{

					$callresponse=array('status'=>'True','result'=>$cbranchs);

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

					}

					else {

						$callresponse=array('status'=>'False','result'=>'No Records Found.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

					}

			

			 }

			 else 

			 {

			 	$callresponse=array('status'=>'False','result'=>'No Records found.');

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

			 }

			

		}

		

		public function deletebranch()

		{

			 $this->layout = "ajax";

			

			if(trim($_POST['id'])!='')

			{

				$datav=array();				

				$datav['id']=trim($_POST['id']);

				if($this->ClubBranch->delete($datav)) {

							

							  $callresponse=array('status'=>'True','result'=>'Successfully deleted.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

						else {

							

							

							

							$callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

			}

			else 

			{

				

				$callresponse=array('status'=>'False','result'=>'Please select the branch.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

			

			

				

			

		}

		

	public function deleteclient()

		{

			 $this->layout = "ajax";

			if(trim($_POST['id'])!='')

			{

				$datav=array();				

				$datav['id']=trim($_POST['id']);

				if($this->Trainee->delete($datav)) {

							

							$callresponse=array('status'=>'True','result'=>'Successfully deleted.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

						else {

							

							

							$callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

			}

			else 

			{

				

				$callresponse=array('status'=>'False','result'=>'Please select the Client.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

			

			

				

			

		}

		

  	public function deletetrainer()

		{

			 $this->layout = "ajax";

			if(trim($_POST['id'])!='')

			{

				$datav=array();				

				$datav['id']=trim($_POST['id']);

				if($this->Trainer->delete($datav)) {

							

							$callresponse=array('status'=>'True','result'=>'Successfully deleted.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

						else {

							$callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

			}

			else 

			{

				

				

				$callresponse=array('status'=>'False','result'=>'Please select the Client.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

			

			

					

			

		}

		

		public function add_corpcontactbranch(){

				

			  $this->layout = "ajax";							

			

			$id = trim($_REQUEST['id']);

			/*$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		  $this->set("setSpecalistArr",$setSpecalistArr);*/ 

			

			

					    $this->request->data["CorporationContact"]["title"] = trim($_REQUEST['title']);							

					    							

					    $this->request->data["CorporationContact"]["email"] = trim($_REQUEST['email']);							

					    							

					    $this->request->data["CorporationContact"]["phone"] = trim($_REQUEST['phone']);							

					    $this->request->data["CorporationContact"]["mobile"] = trim($_REQUEST['mobile']);

					    $this->request->data["CorporationContact"]["branch_id"] = trim($_REQUEST['branch_id']);							

					 						

					    $this->request->data["CorporationContact"]["corporation_id"] = $id;							

					    $this->request->data["CorporationContact"]["status"] = '1';							

					  	

					    $this->request->data["CorporationContact"]["added_date"]= date("Y-m-d h:i:s");

						$this->request->data["CorporationContact"]["modified_date"]= date("Y-m-d h:i:s");	

					    

						//$this->request->data['Employee']['trainee_flag']==1;	

					$this->CorporationContact->set($this->data);	

					if($this->CorporationContact->validates()) {

						if($this->CorporationContact->save($this->data['CorporationContact'])) {

							

						

							

									

							

							

							

							

							/*$title=trim($_REQUEST['title']);

							//$usernme=trim($_REQUEST['username']);

							//$usernpw=$makeTrainee['Trainee']['password'];

							$to=trim($_REQUEST['email']);

							

							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$title.'!</p>

							<p>'.$title.' '.$this->config["base_title"].' Credential given below. </p>

							

							<p>Title : '.$title.'</p>

							<p>User Type : Corporation Contact </p>

							<p>Email : '.trim($_REQUEST['email']).'</p>';

							

							

							$content .= '</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

									

							

							

													 

							$subject = $this->config["base_title"]." : Corporation Contact Branch Registration Successfully"; 

							

							

							

							$this->sendEmailMessage($to,$subject,$content,null,null);*/

							

							$callresponse=array('status'=>'True','result'=>'Corporation Contact Branch has been created successfully.');

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

				       

						} else {

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							

						}

					}

					else {

							$callresponse=array('status'=>'False','result'=>'Username/Email Address Already Exist.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							

						}

				

		}

		public function corpcontactinfo(){

				

			  $this->layout = "ajax";	

			  

			$id = trim($_REQUEST['id']);

				//Employee

			 $setSpecalistArr=$this->CorporationContact->find("first",array("conditions"=>array("CorporationContact.id"=>$id)));

			 if(!empty($setSpecalistArr))

			 {

			 	     $callresponse=array('status'=>'True','result'=>$setSpecalistArr);

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

			 }

			 else {

			 	$callresponse=array('status'=>'False','result'=>'Sorry, not found.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

			 }

			

		}

		public function edit_corpcontactbranch(){

				

			  $this->layout = "ajax";							

			

			$subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']); 

			$contacti=trim($_REQUEST['contact_id']);

			

					    $this->request->data["CorporationContact"]["title"] = trim($_REQUEST['title']);							

					    							

					    $this->request->data["CorporationContact"]["email"] = trim($_REQUEST['email']);							

					    							

					    $this->request->data["CorporationContact"]["phone"] = trim($_REQUEST['phone']);							

					    $this->request->data["CorporationContact"]["mobile"] = trim($_REQUEST['mobile']);

					    $this->request->data["CorporationContact"]["branch_id"] =trim($_REQUEST['branch_id']);						

					 						

					    $this->request->data["CorporationContact"]["corporation_id"] = $id;							

					    $this->request->data["CorporationContact"]["status"] = '1';							

					  	

					    $this->request->data["CorporationContact"]["added_date"]= date("Y-m-d h:i:s");

						$this->request->data["CorporationContact"]["modified_date"]= date("Y-m-d h:i:s");	

					   

					$this->CorporationContact->set($this->data["CorporationContact"]);	

					$this->CorporationContact->id=trim($_REQUEST['contact_id']);

					

					

//				echo '<pre>';

//				print_r($_POST);

//				echo '</pre>';

//				die();

				

					

					

					if($this->CorporationContact->validates()) {

						if($this->CorporationContact->save($this->data['CorporationContact'])) {

							

								

							

							

							/*$title=trim($_REQUEST['title']);

							//$usernme=trim($_REQUEST['username']);

							//$usernpw=$makeTrainee['Trainee']['password'];

							$to=trim($_REQUEST['email']);

							

							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$title.'!</p>

							<p>'.$title.' '.$this->config["base_title"].' Credential given below. </p>

							

							<p>Title : '.$title.'</p>

							<p>User Type : Corporation Contact </p>

							<p>Email : '.trim($_REQUEST['email']).'</p>';

							

							

							$content .= '</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

									

							

							

													 

							$subject = $this->config["base_title"]." : Corporation Contact Branch Registration Successfully"; 

							

							

							

							$this->sendEmailMessage($to,$subject,$content,null,null);*/

							

							$callresponse=array('status'=>'True','result'=>'Corporation Contact Branch has been updated successfully.');

				       $callresponse2=json_encode($callresponse);

				       $this->set('flagv', $callresponse2);

				       

						} else {

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							

						}

					}

					else {

							$callresponse=array('status'=>'False','result'=>'Username/Email Address Already Exist.');

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							

						}

				

		}

		

		

		

 

		public function addbranch()

		{

			 $this->layout = "ajax";

			 

			 $subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']);

			 

			 $username=trim($_REQUEST['email']);

			 $password=trim($_REQUEST['password']);

			 $emailb=trim($_REQUEST['email']);

			 $branchname=trim($_REQUEST['branch_name']);

			 $first_name=trim($_REQUEST['first_name']);

			 $last_name=trim($_REQUEST['last_name']);

			 $address=trim($_REQUEST['address']);

			 $city=trim($_REQUEST['city']);

			 $state=trim($_REQUEST['state']);

			 $country=trim($_REQUEST['country']);

			 $zip=trim($_REQUEST['zip']);

			 $phone=trim($_REQUEST['phone']);

			 $notrainer=trim($_REQUEST['notrainer']);

			 $clubid=$id;

			 

			 			

			if($username!='' && $emailb!='') {

				

				$data=array();

				//club_id

				$this->request->data['ClubBranch']['username']=$username;

				$this->request->data['ClubBranch']['password']=$password;

				$this->request->data['ClubBranch']['first_name']=$first_name;

				$this->request->data['ClubBranch']['last_name']=$last_name;

				

				$this->request->data['ClubBranch']['branch_name']=$branchname;

				

				$this->request->data['ClubBranch']['email']=$emailb;

				$this->request->data['ClubBranch']['address']=$address;

				$this->request->data['ClubBranch']['city']=$city;

				$this->request->data['ClubBranch']['state']=$state;

				$this->request->data['ClubBranch']['country']=$country;

				$this->request->data['ClubBranch']['zip']=$zip;

				$this->request->data['ClubBranch']['phone']=$phone;

				$this->request->data['ClubBranch']['club_id']=$clubid;

				$this->request->data['ClubBranch']['no_trainer']=$notrainer;

		

				$this->ClubBranch->set($this->data['ClubBranch']);

				if($this->ClubBranch->validates()) {

						

					    

					    $this->request->data["ClubBranch"]["added_date"] 		    = date("Y-m-d h:i:s");

						$this->request->data["ClubBranch"]["modified_date"] 		= date("Y-m-d h:i:s");

					    	//pr($this->request->data);

					    //$this->loadModel('ClubBranch');

					   

						if($this->ClubBranch->save($this->request->data)) {	

							

							

								$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

				<p>You have successfully registered on'.$this->config["base_title"].' site. </p>

				<p>Please find below Your Credential for Login</p>

				<p>Email:'.trim($username).'<br/>

				   Password:'.trim($password).'<br/>

				   UserType: Club<br/>

				</p>

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = $this->config["base_title"]." : Club Branch Registered Successfully"; 

						  

						 if($this->sendEmailMessage($emailb,$subject,$content,null,null)){

							 	$callresponse=array('status'=>'True','result'=>'Successfully Added.');

						      $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);

							 }

							else {

								$callresponse=array('status'=>'False','result'=>'Email not valid. Please give vaild email.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

							}

							

						} else {

							

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

				}

				else {

				  $callresponse=array('status'=>'False','result'=>'Username/email already exist.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

				}	

			}

			

		}

		

		

		public function branchinfo()

		{

			 $this->layout = "ajax";

			  $subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $brid=trim($_REQUEST['branch_id']);

			 $dbusertype=trim($_REQUEST['usertype']);

			 

			 $setSpecalistArr=$this->ClubBranch->find("first",array("conditions"=>array("ClubBranch.id"=>$brid)));

			 if(!empty($setSpecalistArr))

			 {

			 	$callresponse=array('status'=>'True','result'=>$setSpecalistArr);

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			 }

			 else {

			 	 $callresponse=array('status'=>'False','result'=>'This is not valid branch.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

			 }

		}



		public function editbranch()

		{

			 $this->layout = "ajax";

			 

			 $subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $brid=trim($_REQUEST['branch_id']);

			 $dbusertype=trim($_REQUEST['usertype']);

			 

			 $username=trim($_REQUEST['email']);

			 $password=trim($_REQUEST['password']);

			 $emailb=trim($_REQUEST['email']);

			 $branchname=trim($_REQUEST['branch_name']);

			 $first_name=trim($_REQUEST['first_name']);

			 $last_name=trim($_REQUEST['last_name']);

			 $address=trim($_REQUEST['address']);

			 $city=trim($_REQUEST['city']);

			 $state=trim($_REQUEST['state']);

			 $country=trim($_REQUEST['country']);

			 $zip=trim($_REQUEST['zip']);

			 $phone=trim($_REQUEST['phone']);

			 $notrainer=trim($_REQUEST['notrainer']);

			 $clubid=$id;

			 

			 			

			if($username!='' && $emailb!='') {

				

				$data=array();

				//club_id

				$this->request->data['ClubBranch']['username']=$username;

				$this->request->data['ClubBranch']['password']=$password;

				$this->request->data['ClubBranch']['first_name']=$first_name;

				$this->request->data['ClubBranch']['last_name']=$last_name;

				$this->request->data['ClubBranch']['branch_name']=$branchname;

				$this->request->data['ClubBranch']['email']=$emailb;

				$this->request->data['ClubBranch']['address']=$address;

				$this->request->data['ClubBranch']['city']=$city;

				$this->request->data['ClubBranch']['state']=$state;

				$this->request->data['ClubBranch']['country']=$country;

				$this->request->data['ClubBranch']['zip']=$zip;

				$this->request->data['ClubBranch']['phone']=$phone;

				$this->request->data['ClubBranch']['club_id']=$clubid;

				$this->request->data['ClubBranch']['id']=$brid;

				$this->request->data['ClubBranch']['no_trainer']=$notrainer;

		

				$this->ClubBranch->set($this->data);

				$this->ClubBranch->id = $brid;

				/*echo '<pre>';

				print_r($_POST);

				echo '</pre>';

				die();*/

				if($this->ClubBranch->validates()) {

						

					    

					    

						$this->request->data["ClubBranch"]["modified_date"] 		= date("Y-m-d h:i:s");

					    	//pr($this->request->data);

					    //$this->loadModel('ClubBranch');

					  

						if($this->ClubBranch->save($this->request->data)) {	

							

							

								$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

				<p>You have successfully registered on'.$this->config["base_title"].' site. </p>

				<p>Please find below Your Credential for Login</p>

				<p>Email:'.trim($username).'<br/>

				   Password:'.trim($password).'<br/>

				   UserType: Club<br/>

				</p>

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = $this->config["base_title"]." : Club Branch Updated Successfully"; 

						  

						

							

								

									$this->sendEmailMessage($emailb,$subject,$content,null,null);

							

										

							$callresponse=array('status'=>'True','result'=>'Successfully Updated.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						} else {

							

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

				}

				else {

				  $callresponse=array('status'=>'False','result'=>'Username/email already exist.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

				}	

			}

			

		}	



  public function addclient()

		{

			 $this->layout = "ajax";

		    

		   $subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']);

			

			

			 $username=trim($_REQUEST['email']);

			 $password=trim($_REQUEST['password']);

			 $emailb=trim($_REQUEST['email']);

			 

			 $first_name=trim($_REQUEST['first_name']);

			 $last_name=trim($_REQUEST['last_name']);

			 $address=trim($_REQUEST['address']);

			 $city=trim($_REQUEST['city']);

			 $state=trim($_REQUEST['state']);

			 $country=trim($_REQUEST['country']);

			 $zip=trim($_REQUEST['zip']);

			 $phone=trim($_REQUEST['phone']);

			 $mobile=trim($_REQUEST['mobile']);

			 $aboutus=trim($_REQUEST['about_us']);

			 $clubid=$clubid;

			 $clubbrid=$clubbr_id;

			 $trinaerid=trim($_REQUEST['trainer_id']);

			

			if($username!='' && $emailb!='') {

				

				$data=array();

				//club_id

				$this->request->data['Trainee']['username']=$username;

				$this->request->data['Trainee']['password']=$password;

				$this->request->data['Trainee']['first_name']=$first_name;

				$this->request->data['Trainee']['last_name']=$last_name;

			

				$this->request->data['Trainee']['email']=$emailb;

				$this->request->data['Trainee']['address']=$address;

				$this->request->data['Trainee']['city']=$city;

				$this->request->data['Trainee']['state']=$state;

				$this->request->data['Trainee']['country']=$country;

				$this->request->data['Trainee']['zip']=$zip;

				$this->request->data['Trainee']['phone']=$phone;

				$this->request->data['Trainee']['mobile']=$mobile;

				$this->request->data['Trainee']['about_us']=$aboutus;

				

				if($subuser=='')

			    {

				$this->request->data['Trainee']['club_id']=trim($_REQUEST['id']);

				$this->request->data['Trainee']['club_branch_id']=trim($_REQUEST['branch_id']);

			    }

			    else 

			    {

			    	$id=trim($_REQUEST['id']);

			    	$setSpecalistArr=$this->ClubBranch->find("first",array("conditions"=>array("ClubBranch.id"=>$id)));

		   

		    $this->request->data['Trainee']['club_id']=$setSpecalistArr['ClubBranch']['club_id'];

				$this->request->data['Trainee']['club_branch_id']=$id;

		    

			    }

				$this->request->data['Trainee']['trainer_id']=trim($_REQUEST['trainer_id']);

		

			   

		

				$this->Trainee->set($this->data['Trainee']);

				if($this->Trainee->validates()) {

						

													

					   

					    

					    $this->request->data["Trainee"]["created_date"] 		    = date("Y-m-d h:i:s");

						$this->request->data["Trainee"]["update_date"] 		    = date("Y-m-d h:i:s");

						$this->request->data["Trainee"]["status"] 		    = 1;

					    	$user_names=$first_name.' '.$last_name;

						if($this->Trainee->save($this->data["Trainee"])) {	

							

								$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

				<p>You have successfully registered on'.$this->config["base_title"].' site. </p>

				<p>Please find below Your Credential for Login</p>

				<p>Email:'.trim($username).'<br/>

				   Password:'.trim($password).'<br/>

				   Usertype: Client <br/>

				</p>

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = $this->config["base_title"]." : Client Registered Successfully"; 

						  

						

							

								

									/*$this->sendEmailMessage($emailb,$subject,$content,null,null);

								

							$callresponse=array('status'=>'True','result'=>'Successfully Added.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);*/

						       

						        if($this->sendEmailMessage($emailb,$subject,$content,null,null)){

							 	$callresponse=array('status'=>'True','result'=>'Successfully Added.');

						     $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);

							 }

							else {

								$callresponse=array('status'=>'False','result'=>'Email not valid. Please give vaild email.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

							}

						       

						       

						} else {

							

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

				}

				else {

					$callresponse=array('status'=>'False','result'=>'Username/email already exist.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

					

				}

					

			}

			

		}



public function clientinfo()

		{

			$this->layout = "ajax";	

			

		   $subuser=trim($_REQUEST['Subuser']);

			 $id2=trim($_REQUEST['id']);

			 $id=trim($_REQUEST['client_id']);

			$dbusertype=trim($_REQUEST['usertype']);			

			if($id!='')

			{

				

				$client=$this->Trainee->find('all',array("conditions"=>array("Trainee.id"=>$id)));

				

				

			if(!empty($client))

			{

			  	            $callresponse=array('status'=>'True','result'=>$client);

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

			}

			else {

				$callresponse=array('status'=>'False','result'=>'No Record Found.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

			}

			}

			else 

			{

				              $callresponse=array('status'=>'False','result'=>'Sorry, please select client.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

		}

		

public function trainerinfo()

		{

			$this->layout = "ajax";	

			

		   $subuser=trim($_REQUEST['Subuser']);

			 $id2=trim($_REQUEST['id']);

			 $id=trim($_REQUEST['trainer_id']);

			$dbusertype=trim($_REQUEST['usertype']);			

			if($id!='')

			{

				

				$client=$this->Trainer->find('all',array("conditions"=>array("Trainer.id"=>$id)));

				

				

			if(!empty($client))

			{

			  	            $callresponse=array('status'=>'True','result'=>$client);

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

			}

			else {

				$callresponse=array('status'=>'False','result'=>'No Record Found.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

			}

			}

			else 

			{

				              $callresponse=array('status'=>'False','result'=>'Sorry, please select Trainer.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

		}



		

public function invite_new_trainer()

		{

		    $this->layout = "ajax";	

			

		     $subuser=trim($_REQUEST['Subuser']);			

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']);	

			//$username=trim($_REQUEST['username']);

			//$password=trim($_REQUEST['password']);

			$email=trim($_REQUEST['email']);

			

			/*

			$username="Mohit";

			$subuser= "";  

            $id = 1;

          $dbusertype = 'Club';

          $password = "123456789";

          $email = "mohit@gmail.com";*/

			 

			 

			

			if($subuser!='')

		     {

		     	 

			     $clubnranchid = trim($id);

			     $setSpecalistArr=$this->ClubBranch->find("first",array("conditions"=>array("ClubBranch.id"=>$clubnranchid)));

			     $clubid=$setSpecalistArr['ClubBranch']['club_id'];

		     }

		     else {

		     	

			$clubid =trim($id);

		     $clubnranchid ='';	

		     }

			

		        $expldv=explode("@",$email);

				$username=$email;

				$password=substr(md5(microtime()),rand(0,26),8);

				$first_name=trim($_POST['first_name']);

				$last_name=trim($_POST['last_name']);

		   			

			

				$data=array();

				$response=array();

				

			if( trim($username)!='' && trim($password)!='' && trim($email)!='' )

			{



				

				

				//$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));

				

				$this->request->data['Trainer']['club_id']=trim($clubid);

				$this->request->data['Trainer']['club_branch_id']=trim($clubnranchid);

				$this->request->data['Trainer']['first_name']=trim($first_name);

				$this->request->data['Trainer']['last_name']=trim($last_name);

				$this->request->data['Trainer']['username']=trim($username);

				$this->request->data['Trainer']['password']=trim($password);

				$this->request->data['Trainer']['email']=trim($email);

				$this->request->data['Trainer']['trainer_type']='C';

				$this->request->data['Trainer']['status']=1;

				$this->request->data['Trainer']['added_date']=date('Y-m-d H:i:s');

				$this->request->data['Trainer']['modified_date']=date('Y-m-d H:i:s');

				

				

				$chk1=$this->Trainer->find('first',array("conditions"=>array("Trainer.username"=>trim($username))));

				$chk2=$this->Trainer->find('first',array("conditions"=>array("Trainer.email"=>trim($email))));

			   

		

				$this->Trainer->set($this->data);

				

				if(empty($chk1) && empty($chk2) ){

				

				if($this->Trainer->save($this->data)) {

					

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

				<p>You have successfully registered on '.$this->config["base_title"].' site. </p>

				<p>Please find below Your Credential for Login</p>

				<p>Email:'.trim($username).'<br/>

				   Password:'.trim($password).'<br/>

				   Usertype: Trainer <br/>

				</p>

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = $this->config["base_title"]." : Trainer Registered Successfully"; 

						  

						

							

								

									$this->sendEmailMessage(trim($email),$subject,$content,null,null);		

					

							

							 $callresponse=array('status'=>'True','result'=>'Thanks, you have added Trainer successfully and Invite mail has been sent to trainer.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

						}

						else {

						  $callresponse=array('status'=>'False','result'=>'Sorry, please try again!');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

						}

				}else {

							

							

							$callresponse=array('status'=>'False','result'=>'Username/Email Address already exist.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

			}

			else {

				$callresponse=array('status'=>'False','result'=>'Please fill all fields.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

			

			

			

		}

		

		public function invite_new_client()

		{

		   $this->layout = "ajax";	

			

		    //echo "hello";

			

						

			$id=trim($_REQUEST['id']);

			$dbusertype=trim($_REQUEST['usertype']);	

			//$username=trim($_REQUEST['username']);

			//$password=trim($_REQUEST['password']);

			$email=trim($_REQUEST['email']);

			

			

                $expldv=explode("@",$email);

				$username=$email;

				$password=substr(md5(microtime()),rand(0,26),8);

				$first_name=trim($_POST['first_name']);

				$last_name=trim($_POST['last_name']);

			

			

//			$username="Deepansh";

//			$subuser= "Club";  

//            $id = 1;

//            $dbusertype = 'Club';

//            $password = "123456789";

//            $email = "dpandiyar@samaptti.com";

			

				$data=array();

				$response=array();

				

			if( trim($username)!='' && trim($password)!='' && trim($email)!='' )

			{



				

				$this->request->data['Trainee']['trainer_id']=trim($id);				

				$this->request->data['Trainee']['first_name']=trim($first_name);

				$this->request->data['Trainee']['last_name']=trim($last_name);

				$this->request->data['Trainee']['username']=trim($username);

				$this->request->data['Trainee']['password']=trim($password);

				$this->request->data['Trainee']['email']=trim($email);

				//$traineedata['Trainee']['trainer_type']='C';

				$this->request->data['Trainee']['status']=1;

				$this->request->data['Trainee']['created_date']=date('Y-m-d H:i:s');

				$this->request->data['Trainee']['update_date']=date('Y-m-d H:i:s');

				

			

				

				$this->Trainee->set($this->data['Trainee']);

				

				$chk1=$this->Trainee->find('first',array("conditions"=>array("Trainee.username"=>trim($username))));

				$chk2=$this->Trainee->find('first',array("conditions"=>array("Trainee.email"=>trim($email))));

			   				

				

			  if(empty($chk1) && empty($chk2)){

			  	

			  		

								 

				if($this->Trainee->save($this->data)) {

					

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

				<p>You have successfully registered on '.$this->config["base_title"].' site. </p>

				<p>Please find below Your Credential for Login</p>

				<p>Email:'.trim($username).'<br/>

				   Password:'.trim($password).'<br/>

				   Usertype: Client <br/>

				</p>

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = $this->config["base_title"]." : Client Registered Successfully"; 

						  

						

							    

							$to      = $email;



$message = $content;
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

//$headers .= 'From: '.$this->config['email'] . "\r\n" .

  //  'Reply-To: '.$this->config['email']. "\r\n" .

  //  'X-Mailer: PHP/' . phpversion();

  
  $headers .= 'From: '.$this->config['email'] . "\r\n";
  $headers .= 'Reply-To: '.$this->config['email']. "\r\n";


mail($to, $subject, $message, $headers);

							

							$callresponse=array('status'=>'True','result'=>'Thanks, you have added Client successfully and Invite mail has been sent to Client.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

						}

						else {

							$callresponse=array('status'=>'False','result'=>'Sorry, please try again.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

			   }

						else {

							

						

							$callresponse=array('status'=>'False','result'=>'Username/Email Address already exist.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						       

							

						}

			}

			else {

				$callresponse=array('status'=>'False','result'=>'Please fill all fields.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

			

			

			

		}

		

		public function invite_new_trainee()

		{

		   $this->layout = "ajax";	

			

		    //echo "hello";

			

						

			$id=trim($_REQUEST['id']);

			$dbusertype=trim($_REQUEST['usertype']);	

			//$username=trim($_REQUEST['username']);

			//$password=trim($_REQUEST['password']);

			$email=trim($_REQUEST['email']);

			

			

//			$username="Deepansh";

//			$subuser= "Club";  

//            $id = 1;

//            $dbusertype = 'Club';

//            $password = "123456789";

//            $email = "dpandiyar@samaptti.com";

			



			

			if(trim($_REQUEST['Subuser'])!='')

		     {

		     	 $subuser=trim($_REQUEST['Subuser']);

			     $clubnranchid = trim($id);

			     $setSpecalistArr=$this->ClubBranch->find("first",array("conditions"=>array("ClubBranch.id"=>$clubnranchid)));

			     $clubid=$setSpecalistArr['ClubBranch']['club_id'];

		     }

		     else {

		     	

			 $clubid =trim($id);

		     $clubnranchid ='';	

		     }

			

		        $expldv=explode("@",$email);

				$username=$email;

				$password=substr(md5(microtime()),rand(0,26),8);

				$first_name=trim($_POST['first_name']);

				$last_name=trim($_POST['last_name']);

		   			

			

				$data=array();

				$response=array();

				

			if( trim($username)!='' && trim($password)!='' && trim($email)!='' )

			{



				

				//if()

				//$this->set("clubs",$this->Club->find('list',array('fields'=>array('Club.id','Club.club_name'))));

				

				$this->request->data['Trainee']['club_id']=trim($clubid);

				$this->request->data['Trainee']['club_branch_id']=trim($clubnranchid);

				$this->request->data['Trainee']['first_name']=trim($first_name);

				$this->request->data['Trainee']['last_name']=trim($last_name);

				$this->request->data['Trainee']['username']=trim($username);

				$this->request->data['Trainee']['password']=trim($password);

				$this->request->data['Trainee']['email']=trim($email);

				//$traineedata['Trainee']['trainer_type']='C';

				$this->request->data['Trainee']['status']=1;

				$this->request->data['Trainee']['created_date']=date('Y-m-d H:i:s');

				$this->request->data['Trainee']['update_date']=date('Y-m-d H:i:s');

				

			

				

				$this->Trainee->set($this->data['Trainee']);

				

				$chk1=$this->Trainee->find('first',array("conditions"=>array("Trainee.username"=>trim($username))));

				$chk2=$this->Trainee->find('first',array("conditions"=>array("Trainee.email"=>trim($email))));

			   

		

				

				

				

			  if(empty($chk1) && empty($chk2)){

			  	

			  		

								 

				if($this->Trainee->save($this->data)) {

					

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

				<p>You have successfully registered on '.$this->config["base_title"].' site. </p>

				<p>Please find below Your Credential for Login</p>

				<p>Email:'.trim($username).'<br/>

				   Password:'.trim($password).'<br/>				  

				   Usertype: Client <br/>

				</p>

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = $this->config["base_title"]." : Client Registered Successfully"; 

						  

						

							    //@$this->sendEmailMessage(trim($email),$subject,$content,null,null);		

					

							    

							$to      = $email;



$message = $content;
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  $headers .= 'From: '.$this->config['email'] . "\r\n";
  $headers .= 'Reply-To: '.$this->config['email']. "\r\n";


//$headers = 'From: '.$this->config['email'] . "\r\n" .

 //   'Reply-To: '.$this->config['email']. "\r\n" .

 //   'X-Mailer: PHP/' . phpversion();



mail($to, $subject, $message, $headers);				
							
							
							
							

							$callresponse=array('status'=>'True','result'=>'Thanks, you have added Client successfully and Invite mail has been sent to Client.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

						}

						else {

							$callresponse=array('status'=>'False','result'=>'Sorry, please try again.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

			   }

						else {

							

						

							$callresponse=array('status'=>'False','result'=>'Username/Email Address already exist.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						       

							

						}

			}

			else {

				$callresponse=array('status'=>'False','result'=>'Please fill all fields.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

			

			

			

		}			



		public function editclient()

		{

			$this->layout = "ajax";

		    

		    $subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']);

			

			

			 $username=trim($_REQUEST['email']);

			 $password=trim($_REQUEST['password']);

			 $emailb=trim($_REQUEST['email']);

			 

			 $first_name=trim($_REQUEST['first_name']);

			 $last_name=trim($_REQUEST['last_name']);

			 $address=trim($_REQUEST['address']);

			 $city=trim($_REQUEST['city']);

			 $state=trim($_REQUEST['state']);

			 $country=trim($_REQUEST['country']);

			 $zip=trim($_REQUEST['zip']);

			 $phone=trim($_REQUEST['phone']);

			 $mobile=trim($_REQUEST['mobile']);

			 $aboutus=trim($_REQUEST['about_us']);

			 

			 $brnchidv=trim($_REQUEST['branch_id']);

			 

			 $trinaerid=trim($_REQUEST['trainer_id']);

			

			if($username!='' && $emailb!='') {

				

				$data=array();

				//club_id

				$this->request->data['Trainee']['username']=$username;

				$this->request->data['Trainee']['password']=$password;

				$this->request->data['Trainee']['first_name']=$first_name;

				$this->request->data['Trainee']['last_name']=$last_name;

			

				$this->request->data['Trainee']['email']=$emailb;

				$this->request->data['Trainee']['address']=$address;

				$this->request->data['Trainee']['city']=$city;

				$this->request->data['Trainee']['state']=$state;

				$this->request->data['Trainee']['country']=$country;

				$this->request->data['Trainee']['zip']=$zip;

				$this->request->data['Trainee']['phone']=$phone;

				$this->request->data['Trainee']['mobile']=$mobile;

				$this->request->data['Trainee']['about_us']=$aboutus;

				

				if($subuser=='')

			    {

				$this->request->data['Trainee']['club_id']=trim($_REQUEST['id']);

				

				$this->request->data['Trainee']['club_branch_id']=trim($_REQUEST['branch_id']);

				

				

			    }

			    else 

			    {

			    	$id=trim($_REQUEST['id']);

			    	$setSpecalistArr=$this->ClubBranch->find("first",array("conditions"=>array("ClubBranch.id"=>$id)));

		   

		    $this->request->data['Trainee']['club_id']=$setSpecalistArr['ClubBranch']['club_id'];

				$this->request->data['Trainee']['club_branch_id']=$id;

				

				

		    

			    }

				$this->request->data['Trainee']['trainer_id']=trim($_REQUEST['trainer_id']);

		

			   

		

				$this->Trainee->set($this->data);

				$this->Trainee->id = trim($_REQUEST['client_id']);

				if($this->Trainee->validates()) {

						

													

					   

					    

					   

						$this->request->data["Trainee"]["update_date"] 		    = date("Y-m-d h:i:s");

					

					    	$user_names=$first_name.' '.$last_name;

						if($this->Trainee->save($this->data)) {	

							

								$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

				<p>You have successfully updated on'.$this->config["base_title"].' site. </p>

				<p>Please find below Your Credential for Login</p>

				<p>Email:'.trim($username).'<br/>

				   Password:'.trim($password).'<br/>				   

				   Usertype: Client <br/>

				</p>

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = $this->config["base_title"]." : Client Updated Successfully"; 

						  

						

							

								

									$this->sendEmailMessage($emailb,$subject,$content,null,null);

								

							$callresponse=array('status'=>'True','result'=>'Successfully Updated.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						} else {

							

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

				}

				else {

					$callresponse=array('status'=>'False','result'=>'Username/email already exist.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

					

				}

					

			}

			

		}	

		



		public function addtrainer()

		{

			 $this->layout = "ajax";

			 

			 

		    //'Subuser'=>'Club Branch'

			 $subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']);

		    

		    if($subuser!='')

		     {

               

               $dbusertype ='ClubBranch';					

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $clubid=$setSpecalistArr['ClubBranch']['club_id'];

		    $clubbranchid=$setSpecalistArr['ClubBranch']['id'];

               

		     } else {

		     	

		     	

			$clubid=$id;

			$clubbranchid=trim($_REQUEST['branch_id']);

			

		     	

		     }

		    

		     $club_id=$clubid;

		     $clubbranchid=$clubbranchid;

			 $username=trim($_REQUEST['email']);

			 $email=trim($_REQUEST['email']);

			 $password=trim($_REQUEST['password']);

			 $first_name=trim($_REQUEST['first_name']);

			 $last_name=trim($_REQUEST['last_name']);

			 $address=trim($_REQUEST['address']);

			 $city=trim($_REQUEST['city']);

			 $state=trim($_REQUEST['state']);

			 $country=trim($_REQUEST['country']);

			 $zip=trim($_REQUEST['zip']);

			 $phone=trim($_REQUEST['phone']);

			 $mobile=trim($_REQUEST['mobile']);

			 $certifications=trim($_REQUEST['certifications']);

			 $bio=trim($_REQUEST['Bio']);

			 $about_us=trim($_REQUEST['about_us']);

			  

		    

		     	

		     	$data=array();

				

		     	$this->request->data['Trainer']['username']=$username;

				$this->request->data['Trainer']['password']=$password;

				$this->request->data['Trainer']['first_name']=$first_name;

				$this->request->data['Trainer']['last_name']=$last_name;

			

				$this->request->data['Trainer']['email']=$email;

				$this->request->data['Trainer']['address']=$address;

				$this->request->data['Trainer']['city']=$city;

				$this->request->data['Trainer']['state']=$state;

				$this->request->data['Trainer']['country']=$country;

				$this->request->data['Trainer']['zip']=$zip;

				$this->request->data['Trainer']['phone']=$phone;

				$this->request->data['Trainer']['mobile']=$mobile;

				$this->request->data['Trainer']['certifications']=$certifications;

				$this->request->data['Trainer']['Bio']=$bio;

				$this->request->data['Trainer']['about_us']=$about_us;

				

				

				if($subuser=='')

			    {

				$this->request->data['Trainer']['club_id']=trim($_REQUEST['id']);

				$this->request->data['Trainer']['club_branch_id']=trim($_REQUEST['branch_id']);

			    }

			    else 

			    {

			    	$id=trim($_REQUEST['id']);

			    	$setSpecalistArr=$this->ClubBranch->find("first",array("conditions"=>array("ClubBranch.id"=>$id)));

		   

		        $this->request->data['Trainer']['club_id']=$setSpecalistArr['ClubBranch']['club_id'];

				$this->request->data['Trainer']['club_branch_id']=$id;

		    

			    }

				

		         

			if(!empty($this->data)) {

				/*echo "<pre>";

				print_r($this->data['Trainer']);

				echo"</pre>";

		die('Here');*/

				$this->Trainer->set($this->data['Trainer']);

				if($this->Trainer->validates()) {

						

							$this->request->data["Trainer"]["logo"] = '';							

					    

					    

					    $this->request->data["Trainer"]["added_date"] 		    = date("Y-m-d h:i:s");

						$this->request->data["Trainer"]["modified_date"] 		    = date("Y-m-d h:i:s");

						$this->request->data["Trainer"]["status"] 		    = 1;

						$this->request->data["Trainer"]["trainer_type"]='C';

					    	

						if($this->Trainer->save($this->data)) {		

							$user_names=trim($this->data["Trainer"]["first_name"]).' '.trim($this->data["Trainer"]["last_name"]);

							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

				<p>You have successfully registered on'.$this->config["base_title"].' site. </p>

				<p>Please find below Your Credential for Login</p>

				<p>Email:'.trim($this->data["Trainer"]["username"]).'<br/>

				   Password:'.trim($this->data["Trainer"]["password"]).'<br/>				  

				</p>

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = $this->config["base_title"]." : Trainer Registered Successfully"; 

						  

						

							

							  if( $this->sendEmailMessage($this->data["Trainer"]["email"],$subject,$content,null,null)){

							 	$callresponse=array('status'=>'True','result'=>'Successfully Added.');

						     $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);

							 }

							else {

								$callresponse=array('status'=>'False','result'=>'Email not valid. Please give vaild email.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

							}

											

														

						} else {

							

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

				}

				 else {

					     $callresponse=array('status'=>'False','result'=>'Username/email already exist.');

						 $callresponse2=json_encode($callresponse);

						 $this->set('flagv', $callresponse2);	

					

				}	

			}

			

		

			

		}	

		

		

		public function edittrainer()

		{

			 $this->layout = "ajax";

			 

			 

		    //'Subuser'=>'Club Branch'

			 $subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']);

		    

		    if($subuser!='')

		     {

               

               $dbusertype ='ClubBranch';					

			

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$id)));

		    $clubid=$setSpecalistArr['ClubBranch']['club_id'];

		    $clubbranchid=$setSpecalistArr['ClubBranch']['id'];

               

		     } else {

		     	

		     	

			$clubid=$id;

			$clubbranchid=trim($_REQUEST['branch_id']);

			

		     	

		     }

		    

		     $club_id=$clubid;

		     $clubbranchid=$clubbranchid;

			 $username=trim($_REQUEST['email']);

			 $email=trim($_REQUEST['email']);

			 $password=trim($_REQUEST['password']);

			 $first_name=trim($_REQUEST['first_name']);

			 $last_name=trim($_REQUEST['last_name']);

			 $address=trim($_REQUEST['address']);

			 $city=trim($_REQUEST['city']);

			 $state=trim($_REQUEST['state']);

			 $country=trim($_REQUEST['country']);

			 $zip=trim($_REQUEST['zip']);

			 $phone=trim($_REQUEST['phone']);

			 $mobile=trim($_REQUEST['mobile']);

			 $certifications=trim($_REQUEST['certifications']);

			 $bio=trim($_REQUEST['Bio']);

			 $about_us=trim($_REQUEST['about_us']);

			  

		    

		     	

		     	$data=array();

				

		     	$this->request->data['Trainer']['username']=$username;

				$this->request->data['Trainer']['password']=$password;

				$this->request->data['Trainer']['first_name']=$first_name;

				$this->request->data['Trainer']['last_name']=$last_name;

				$this->request->data['Trainer']['email']=$email;

				$this->request->data['Trainer']['address']=$address;

				$this->request->data['Trainer']['city']=$city;

				$this->request->data['Trainer']['state']=$state;

				$this->request->data['Trainer']['country']=$country;

				$this->request->data['Trainer']['zip']=$zip;

				$this->request->data['Trainer']['phone']=$phone;

				$this->request->data['Trainer']['mobile']=$mobile;

				$this->request->data['Trainer']['certifications']=$certifications;

				$this->request->data['Trainer']['Bio']=$bio;

				$this->request->data['Trainer']['about_us']=$about_us;

				$this->request->data["Trainer"]["trainer_type"]= 'C';

				

				if($subuser=='')

			    {

				$this->request->data['Trainer']['club_id']=trim($_REQUEST['id']);

				$this->request->data['Trainer']['club_branch_id']=trim($_REQUEST['branch_id']);

			    }

			    else 

			    {

			    	$id=trim($_REQUEST['id']);

			    	$setSpecalistArr=$this->ClubBranch->find("first",array("conditions"=>array("ClubBranch.id"=>$id)));

		   

		        $this->request->data['Trainer']['club_id']=$setSpecalistArr['ClubBranch']['club_id'];

				$this->request->data['Trainer']['club_branch_id']=$id;

		    

			    }

				

		         

			if(!empty($this->data)) {

		        $this->Trainer->id = trim($_REQUEST['trainer_id']);

		        

		       /*echo '<pre>';

		        print_r($this->data);

		        echo '</pre>';

		        exit;*/

				$this->Trainer->set($this->data['Trainer']);

				

				if($this->Trainer->validates()) {

						

					    

					    $this->request->data["Trainer"]["added_date"] 		    = date("Y-m-d h:i:s");

						$this->request->data["Trainer"]["modified_date"] 		    = date("Y-m-d h:i:s");

						$this->request->data["Trainer"]["status"] 		    = 1;

					    	

						if($this->Trainer->save($this->data)) {		

							$user_names=trim($this->data["Trainer"]["first_name"]).' '.trim($this->data["Trainer"]["last_name"]);

							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

				<p>You have successfully registered on'.$this->config["base_title"].' site. </p>

				<p>Please find below Your Credential for Login</p>

				<p>Email:'.trim($this->data["Trainer"]["username"]).'<br/>

				   Password:'.trim($this->data["Trainer"]["password"]).'<br/>

				   </p>

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = $this->config["base_title"]." : Trainer Updated Successfully"; 

						  

						

							

							 $this->sendEmailMessage($this->data["Trainer"]["email"],$subject,$content,null,null);

							

							 $callresponse=array('status'=>'True','result'=>'Successfully Updated.');

						     $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);

											

														

						} else {

							

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

				}

				 else {

					     $callresponse=array('status'=>'False','result'=>'Username/email already exist.');

						 $callresponse2=json_encode($callresponse);

						 $this->set('flagv', $callresponse2);	

					

				}	

			}

			

		

			

		}

		

		public function gettrner($clientid=null){	

				$this->layout = "ajax";

				if($clientid!=''){

				$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));                if($setClientArr['Trainee']['trainer_id']!=''){ 

				 $callresponse=array('status'=>'True','result'=>$setClientArr['Trainee']['trainer_id']);

						     $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);

				  }

				  else {

				  	$callresponse=array('status'=>'False','result'=>'Sorry record not found');

						 $callresponse2=json_encode($callresponse);

						 $this->set('flagv', $callresponse2);	

				  }

				}else {

					$callresponse=array('status'=>'False','result'=>'Please select client');

						 $callresponse2=json_encode($callresponse);

						 $this->set('flagv', $callresponse2);	

				}

		}

		

		public function exercise_history_old($clientid=null,$datva=null,$trnid=null){		

			

		//$this->checkUserLogin();

		$this->layout = "ajax";

		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'exercise_history');

		$dbusertype = 'Trainer';					

		$this->set("dbusertype",$dbusertype);

		$uid = $trnid;

		if($datva!='')

			{

				          

			 $datefd=$datva;

			

				 

				

				$this->set("datva",$dtsv);

				$this->set("datva2",$datva);

			}

			else {

							

				$datefd=date('Y-m-d');

				$this->set("datva2",$datefd);

				

				

			}

		$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$uid)));

		  $this->set("setSpecalistArr",$setSpecalistArr);

		  $showoff=1;

		if($clientid!='')

		{

			$this->set("clientid",$clientid);

			//echo $clientid;

			

			$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));

			$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid),"order"=>array("Goal.id DESC")));

			/*print_r($setClientGoalArr);

			die();*/

			$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,"SpeedAgilityQuickness.added_date"=>$datefd)));

			$jtms='';



		 $resultdt=array();

		 $setWarmupArr=array();

		 $setCoreBalancePlyometricArr=array();

		 $resultdt['TrainerName']=ucwords($setSpecalistArr['Trainer']['full_name']);

		 $resultdt['ClientName']=ucwords($setClientArr['Trainee']['username']);

		 $resultdt['Date']=$datefd;

		 $resultdt['Goal']=$setClientGoalArr['Goal']['goal'];

		 $resultdt['notes']=$setClientGoalArr['Goal']['note'];

		 $resultdt['phase']=$setClientGoalArr['Goal']['phase'];

		 $resultdt['alert']=$setClientGoalArr['Goal']['alert'];

		 $resultdt['start']=$setClientGoalArr['Goal']['start'];

		 $resultdt['end']=$setClientGoalArr['Goal']['end'];

		

					$cnt=1;

				$jtms;

         

      

				



			

			$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,"WarmUps.added_date"=>$datefd)));

			

			

			

			 $resultdt['Warmup']=$setWarmupArr;

			 

			

			$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,"CoreBalancePlyometric.added_date"=>$datefd)));

			

			$resultdt['CORE']=$setCoreBalancePlyometricArr;

			$resultdt['SPEED']=$setSpeedAgilityQuicknessArr;

			

			

			

			

			

      

			$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,"Resistence.added_date"=>$datefd)));

			

			$resultdt['Resistence']=$setResistenceArr;

			

		



      $setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,"CoolDown.added_date"=>$datefd)));

      $resultdt['CoolDown']=$setCoolDownArr;

	    $callresponse=array('status'=>'True','result'=>$resultdt);

						     $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);

			

		}

		else{

		$callresponse=array('status'=>'False','result'=>'Please select Client.');

						     $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);

		}

				

		}

		

		public function exercise_history_add($clientid=null,$trnid=null,$date=null){		

			

		//$this->checkUserLogin();

		$this->layout = "ajax";

		

		$dbusertype = 'Trainer';

		if($clientid!='' && $trnid!='' && $date!=''){

			$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid,"Goal.trainer_id"=>$trnid),"Order"=>array("Goal.id"=>"DESC")));

			$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));

			$setTrainerArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$trnid)));

			                 $callresponse=array('status'=>'True','Client'=>$setClientArr,'Trainer'=>$setTrainerArr,'Goal'=>$setClientGoalArr,'date'=>$date);

						     $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);

		     }

		     else{

		$callresponse=array('status'=>'False','result'=>'Please select Client.');

						     $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);

		}

		

		}

		

		

		public function addwarmup9(){

			$this->layout='';

			$this->autoRender=false;

			/*echo '<pre>';

			print_r($_REQUEST);

			echo '</pre>';*/

			

			$trnid=trim($_POST['Trainer_Id']);

			$clientid=trim($_POST['Client_Id']);

			$postdate=trim($_POST['Date']);

			

			$varr=array();

			$varr2=array();

			$varr3=array();

			$varr4=array();

			$varr5=array();

		    $goalArr=array();

					$goalArr['Goal']['goal']=trim($_POST['Goal']);

					$goalArr['Goal']['phase']=trim($_POST['Phase']);

					$goalArr['Goal']['note']=trim($_POST['notes']);

					$goalArr['Goal']['alert']=trim($_POST['alert']);

					$goalArr['Goal']['trainer_id']=trim($_POST['Trainer_Id']);

					$goalArr['Goal']['trainee_id']=trim($_POST['Client_Id']);

					$goalArr['Goal']['added_date']=date('Y-m-d H:i:s');

					$goalArr['Goal']['modified_date']=date('Y-m-d H:i:s');

					

					$sessionType=trim($_POST['sessionType']);

					

					$sessionTypeArr=$this->WorkOuts->find("first",array("conditions"=>array("WorkOuts.id"=>$sessionType)));

			$exType=trim($_POST['Date']);

				$extimestamp=strtotime($exType);

				 $exType=date('Y-m-d',$extimestamp);

				 

				  //2014-09-02 17:00 2014-09-02 07:00:00

				

				$sessType=$sessionTypeArr['WorkOuts']['workout_time'];

				$startTime=trim($_POST['time']);

				 $ttime = strtotime($startTime);

				$endTime = date("h:i:s", strtotime("+$sessType minutes", $ttime));

				 

				echo $startDate=$exType.' '.$startTime.':00';

				echo $endDate=$exType.' '.$endTime;

			$checkCalArr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.trainer_id"=>$_POST['Trainer_Id'],'ScheduleCalendar.trainee_id'=>$_POST['Client_Id'],'ScheduleCalendar.start'=>$startDate)));

			

			$checkCalArr2=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.trainer_id"=>$_POST['Trainer_Id'],'ScheduleCalendar.start'=>$startDate)));

			

			echo '<pre>';

			print_r($checkCalArr);

			echo '</pre>';

			echo '<pre>';

			print_r($checkCalArr2);

			echo '</pre>';

			

			

			

		}

		

		public function addwarmup(){		

			/*$this->layout='';

			$this->autoRender=false;*/

		//$this->checkUserLogin();

		$trnid=trim($_POST['Trainer_Id']);

		$clientid=trim($_POST['Client_Id']);

		$postdate=trim($_POST['Date']);

		

		$this->layout = "ajax";

		$varr=array();

		$varr2=array();

		$varr3=array();

		$varr4=array();

		$varr5=array();
		

		

		//'WarmUps','CoreBalancePlyometric','SpeedAgilityQuickness','Resistence','CoolDown'

		

	

					

					$sessionType=trim($_POST['sessionType']);

					

					$sessionTypeArr=$this->WorkOuts->find("first",array("conditions"=>array("WorkOuts.id"=>$sessionType)));

					

					

					$exType=trim($_POST['Date']);

				$extimestamp=strtotime($exType);

				 $exType=date('Y-m-d',$extimestamp);

				

				$sessType=$sessionTypeArr['WorkOuts']['workout_time'];

				$startTime=trim($_POST['time']);

				 $ttime = strtotime($startTime);

				$endTime = date("h:i:s", strtotime("+$sessType minutes", $ttime));

				 

				 $startDate=$exType.' '.$startTime.':00';

				 $endDate=$exType.' '.$endTime;

				

				

					

					$checkCalArr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.trainer_id"=>$_POST['Trainer_Id'],'ScheduleCalendar.trainee_id'=>$_POST['Client_Id'],'ScheduleCalendar.start'=>$startDate)));

			

			$checkCalArr2=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.trainer_id"=>$_POST['Trainer_Id'],'ScheduleCalendar.start'=>$startDate)));

				

			if(empty($checkCalArr2) || ($checkCalArr2['ScheduleCalendar']['trainee_id']==$_POST['Client_Id']) ){	

						if(empty($checkCalArr)){

					

					 $setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$_POST['Client_Id'])));

		    $aptitle=$setClientArr['Trainee']['full_name'];

					

						$data=array();

					$this->request->data['ScheduleCalendar']['appointment_type']='Booked';

					$this->request->data['ScheduleCalendar']['title']=$aptitle;

					$this->request->data['ScheduleCalendar']['description']='Session  - '.$aptitle;

					$this->request->data['ScheduleCalendar']['trainer_id']=$_POST['Trainer_Id'];

					$this->request->data['ScheduleCalendar']['trainee_id']=$_POST['Client_Id'];

					$this->request->data['ScheduleCalendar']['start']=$startDate;

					$this->request->data['ScheduleCalendar']['end']=$endDate;

					$this->request->data['ScheduleCalendar']['added_date']=date('Y-m-d');

					$this->request->data['ScheduleCalendar']['modification_date']=date('Y-m-d');

					$this->request->data['ScheduleCalendar']['status']='1';

								    	

						if($this->ScheduleCalendar->save($this->data['ScheduleCalendar']))

						{

							

						}

						

				}

				

					  $goalArr=array();

					$goalArr['Goal']['goal']=trim($_POST['Goal']);

					$goalArr['Goal']['phase']=trim($_POST['Phase']);

					$goalArr['Goal']['note']=trim($_POST['notes']);

					$goalArr['Goal']['alert']=trim($_POST['alert']);

					$goalArr['Goal']['trainer_id']=trim($_POST['Trainer_Id']);

					$goalArr['Goal']['trainee_id']=trim($_POST['Client_Id']);

					$goalArr['Goal']['added_date']=date('Y-m-d H:i:s');

					$goalArr['Goal']['modified_date']=date('Y-m-d H:i:s');

					$goalArr['Goal']['start']=$startDate;

					$goalArr['Goal']['end']=$endDate;

					$this->Goal->save($goalArr);

		

		if(!empty($_POST['Warmup']))

		{

			foreach ($_POST['Warmup'] as $key=>$val)

			{

				$exprd=explode(",",$val[0]);

				

				

				$exerciseA=explode("=",$exprd[0]);

				$exercise=str_replace("\'","",$exerciseA[1]);

				$varr['WarmUps']['exercise']=$exercise;

				

				$setA=explode("=",$exprd[1]);

				$set=str_replace("\'","",$setA[1]);				

				$varr['WarmUps']['set']=$set;

				

				$durationA=explode("=",$exprd[2]);

				$duration=str_replace("\'","",$durationA[1]);				

				$varr['WarmUps']['duration']=$duration;

				

				$coaching_tipA=explode("=",$exprd[3]);

				$coaching_tip=str_replace("\'","",$coaching_tipA[1]);				

				$varr['WarmUps']['coaching_tip']=$coaching_tip;

				$varr['WarmUps']['trainer_id']=$trnid;

				$varr['WarmUps']['trainee_id']=$clientid;

				$varr['WarmUps']['added_date']=$postdate;

				

				$this->WarmUps->saveAll($varr);

			}

			

		}

		

		if(!empty($_POST['CoolDown']))

		{

			foreach ($_POST['CoolDown'] as $key=>$val)

			{

				$exprd=explode(",",$val[0]);

				

				

				$exerciseA=explode("=",$exprd[0]);

				$exercise=str_replace("\'","",$exerciseA[1]);

				$varr4['CoolDown']['exercise']=$exercise;

				

				$setA=explode("=",$exprd[1]);

				$set=str_replace("\'","",$setA[1]);				

				$varr4['CoolDown']['set']=$set;

				

				$durationA=explode("=",$exprd[2]);

				$duration=str_replace("\'","",$durationA[1]);				

				$varr4['CoolDown']['duration']=$duration;

				

				$coaching_tipA=explode("=",$exprd[3]);

				$coaching_tip=str_replace("\'","",$coaching_tipA[1]);				

				$varr4['CoolDown']['coaching_tip']=$coaching_tip;

				$varr4['CoolDown']['trainer_id']=$trnid;

				$varr4['CoolDown']['trainee_id']=$clientid;

				$varr4['CoolDown']['added_date']=$postdate;

				$this->CoolDown->saveAll($varr4);

			}

			

		}

		

		if(!empty($_POST['CORE']))

		{

			foreach ($_POST['CORE'] as $key=>$val)

			{

				$exprd=explode(",",$val[0]);

				

				

				$exerciseA=explode("=",$exprd[0]);

				$exercise=str_replace("\'","",$exerciseA[1]);

				$varr2['CoreBalancePlyometric']['exercise']=$exercise;

				

				$setA=explode("=",$exprd[1]);

				$set=str_replace("\'","",$setA[1]);				

				$varr2['CoreBalancePlyometric']['set']=$set;

				

				$repA=explode("=",$exprd[2]);

				$rep=str_replace("\'","",$repA[1]);				

				$varr2['CoreBalancePlyometric']['rep']=$rep;

				

				$weightA=explode("=",$exprd[3]);

				$weight=str_replace("\'","",$weightA[1]);				

				$varr2['CoreBalancePlyometric']['temp']=$weight;

				

				$rstA=explode("=",$exprd[4]);

				$rst=str_replace("\'","",$rstA[1]);				

				$varr2['CoreBalancePlyometric']['rest']=$rst;

				

				$coaching_tipA=explode("=",$exprd[4]);

				$coaching_tip=str_replace("\'","",$coaching_tipA[1]);				

				$varr2['CoreBalancePlyometric']['coaching_tip']=$coaching_tip;

				$varr2['CoreBalancePlyometric']['trainer_id']=$trnid;

				$varr2['CoreBalancePlyometric']['trainee_id']=$clientid;

				$varr2['CoreBalancePlyometric']['added_date']=$postdate;

				$this->CoreBalancePlyometric->saveAll($varr2);

			}

			

		}

		

		if(!empty($_POST['SPEED']))

		{

			foreach ($_POST['SPEED'] as $key=>$val)

			{

				$exprd=explode(",",$val[0]);

				

				

				$exerciseA=explode("=",$exprd[0]);

				$exercise=str_replace("\'","",$exerciseA[1]);

				$varr3['SpeedAgilityQuickness']['exercise']=$exercise;

				

				$setA=explode("=",$exprd[1]);

				$set=str_replace("\'","",$setA[1]);				

				$varr3['SpeedAgilityQuickness']['set']=$set;

				

				$repA=explode("=",$exprd[2]);

				$rep=str_replace("\'","",$repA[1]);				

				$varr3['SpeedAgilityQuickness']['rep']=$rep;

				

				$weightA=explode("=",$exprd[3]);

				$weight=str_replace("\'","",$weightA[1]);				

				$varr3['SpeedAgilityQuickness']['temp']=$weight;

				

				$rstA=explode("=",$exprd[4]);

				$rst=str_replace("\'","",$rstA[1]);				

				$varr3['SpeedAgilityQuickness']['rest']=$rst;

				

				$coaching_tipA=explode("=",$exprd[4]);

				$coaching_tip=str_replace("\'","",$coaching_tipA[1]);				

				$varr3['SpeedAgilityQuickness']['coaching_tip']=$coaching_tip;

				$varr3['SpeedAgilityQuickness']['trainer_id']=$trnid;

				$varr3['SpeedAgilityQuickness']['trainee_id']=$clientid;

				$varr3['SpeedAgilityQuickness']['added_date']=$postdate;

				$this->SpeedAgilityQuickness->saveAll($varr3);

			}

			

		}

		

		

		if(!empty($_POST['Resistence']))

		{

			foreach ($_POST['Resistence'] as $key=>$val)

			{

				$exprd=explode(",",$val[0]);

				

				

				$exerciseA=explode("=",$exprd[0]);

				$exercise=str_replace("\'","",$exerciseA[1]);

				$varr5['Resistence']['exercise']=$exercise;

				

				$setA=explode("=",$exprd[1]);

				$set=str_replace("\'","",$setA[1]);				

				$varr5['Resistence']['set']=$set;

				

				$repA=explode("=",$exprd[2]);

				$rep=str_replace("\'","",$repA[1]);				

				$varr5['Resistence']['rep']=$rep;

				

				$weightA=explode("=",$exprd[3]);

				$weight=str_replace("\'","",$weightA[1]);				

				$varr5['Resistence']['temp']=$weight;

				

				$rstA=explode("=",$exprd[4]);

				$rst=str_replace("\'","",$rstA[1]);				

				$varr5['Resistence']['rest']=$rst;

				

				$coaching_tipA=explode("=",$exprd[4]);

				$coaching_tip=str_replace("\'","",$coaching_tipA[1]);				

				$varr5['Resistence']['coaching_tip']=$coaching_tip;

				$varr5['Resistence']['trainer_id']=$trnid;

				$varr5['Resistence']['trainee_id']=$clientid;

				$varr5['Resistence']['added_date']=$postdate;

				$this->Resistence->saveAll($varr5);

			}

			

		}

		

		     $callresponse=array('status'=>'True','result'=>'Save Successfully');

						     

		 } else 

		  {

		  $callresponse = array("status"=>"False","result"=>"Sorry, this date already workout added.");

		  }



		 

				

						  

						      $callresponse2=json_encode($callresponse);

						    $this->set('flagv', $callresponse2);

					

		

		}

/******************************************************************************************/		

		/*****************For Trainer Add Client**************/

		

/********************************************************************************************/

 public function add_trainer_client()

		{

			 $this->layout = "ajax";

		    

		   $subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']);

			

			

			 $username=trim($_REQUEST['email']);

			 $password=trim($_REQUEST['password']);

			 $emailb=trim($_REQUEST['email']);

			 

			 $first_name=trim($_REQUEST['first_name']);

			 $last_name=trim($_REQUEST['last_name']);

			 $address=trim($_REQUEST['address']);

			 $city=trim($_REQUEST['city']);

			 $state=trim($_REQUEST['state']);

			 $country=trim($_REQUEST['country']);

			 $zip=trim($_REQUEST['zip']);

			 $phone=trim($_REQUEST['phone']);

			 $mobile=trim($_REQUEST['mobile']);

			 $aboutus=trim($_REQUEST['about_us']);

			 $clubid=$clubid;

			 $clubbrid=$clubbr_id;

			 $trinaerid=trim($_REQUEST['trainer_id']);

			

			if($username!='' && $emailb!='') {

				

				$data=array();

				//club_id

				$this->request->data['Trainee']['username']=$username;

				$this->request->data['Trainee']['password']=$password;

				$this->request->data['Trainee']['first_name']=$first_name;

				$this->request->data['Trainee']['last_name']=$last_name;

			

				$this->request->data['Trainee']['email']=$emailb;

				$this->request->data['Trainee']['address']=$address;

				$this->request->data['Trainee']['city']=$city;

				$this->request->data['Trainee']['state']=$state;

				$this->request->data['Trainee']['country']=$country;

				$this->request->data['Trainee']['zip']=$zip;

				$this->request->data['Trainee']['phone']=$phone;

				$this->request->data['Trainee']['mobile']=$mobile;

				$this->request->data['Trainee']['about_us']=$aboutus;

				

				

				$this->request->data['Trainee']['trainer_id']=trim($_REQUEST['id']);

		

			   

		

				$this->Trainee->set($this->data['Trainee']);

				if($this->Trainee->validates()) {

						

													

					   

					    

					    $this->request->data["Trainee"]["created_date"] 		    = date("Y-m-d h:i:s");

						$this->request->data["Trainee"]["update_date"] 		    = date("Y-m-d h:i:s");

						$this->request->data["Trainee"]["status"] 		    = 1;

					    	$user_names=$first_name.' '.$last_name;

						if($this->Trainee->save($this->data)) {	

							

								$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

				<p>You have successfully registered on'.$this->config["base_title"].' site. </p>

				<p>Please find below Your Credential for Login</p>

				<p>Email:'.trim($username).'<br/>

				   Password:'.trim($password).'<br/>

				   Usertype: Client <br/>

				</p>

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = $this->config["base_title"]." : Client Registered Successfully"; 

						  

						

							

								

									/*$this->sendEmailMessage($emailb,$subject,$content,null,null);

								

							$callresponse=array('status'=>'True','result'=>'Successfully Added.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);*/

						       

						        if($this->sendEmailMessage($emailb,$subject,$content,null,null)){

							 	$callresponse=array('status'=>'True','result'=>'Successfully Added.');

						     $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);

							 }

							else {

								$callresponse=array('status'=>'False','result'=>'Email not valid. Please give vaild email.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

							}

						       

						       

						} else {

							

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

				}

				else {

					$callresponse=array('status'=>'False','result'=>'Username/email already exist.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

					

				}

					

			}

			

		}

		/********************************Add Trainer Client End Here***************/	

		

		

		public function edit_trainer_client()

		{

			$this->layout = "ajax";

		    

		    $subuser=trim($_REQUEST['Subuser']);

			 $id=trim($_REQUEST['id']);

			 $dbusertype=trim($_REQUEST['usertype']);

			

			

			 $username=trim($_REQUEST['email']);

			 $password=trim($_REQUEST['password']);

			 $emailb=trim($_REQUEST['email']);

			 

			 $first_name=trim($_REQUEST['first_name']);

			 $last_name=trim($_REQUEST['last_name']);

			 $address=trim($_REQUEST['address']);

			 $city=trim($_REQUEST['city']);

			 $state=trim($_REQUEST['state']);

			 $country=trim($_REQUEST['country']);

			 $zip=trim($_REQUEST['zip']);

			 $phone=trim($_REQUEST['phone']);

			 $mobile=trim($_REQUEST['mobile']);

			 $aboutus=trim($_REQUEST['about_us']);

			 

			 $brnchidv=trim($_REQUEST['branch_id']);

			 

			

			

			if($username!='' && $emailb!='') {

				

				$data=array();

				//club_id

				$this->request->data['Trainee']['username']=$username;

				$this->request->data['Trainee']['password']=$password;

				$this->request->data['Trainee']['first_name']=$first_name;

				$this->request->data['Trainee']['last_name']=$last_name;

			

				$this->request->data['Trainee']['email']=$emailb;

				$this->request->data['Trainee']['address']=$address;

				$this->request->data['Trainee']['city']=$city;

				$this->request->data['Trainee']['state']=$state;

				$this->request->data['Trainee']['country']=$country;

				$this->request->data['Trainee']['zip']=$zip;

				$this->request->data['Trainee']['phone']=$phone;

				$this->request->data['Trainee']['mobile']=$mobile;

				$this->request->data['Trainee']['about_us']=$aboutus;

				

				

		

			   

		

				$this->Trainee->set($this->data);

				$this->Trainee->id = trim($_REQUEST['id']);

				if($this->Trainee->validates()) {

											   

						$this->request->data["Trainee"]["update_date"] 		    = date("Y-m-d h:i:s");

					

					    	$user_names=$first_name.' '.$last_name;

						if($this->Trainee->save($this->data)) {	

							

								$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

				<p>You have successfully updated on'.$this->config["base_title"].' site. </p>

				<p>Please find below Your Credential for Login</p>

				<p>Email:'.trim($username).'<br/>

				   Password:'.trim($password).'<br/>

				   Usertype: Client <br/>

				</p>

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = $this->config["base_title"]." : Client Updated Successfully"; 

						  

						

							

								

									$this->sendEmailMessage($emailb,$subject,$content,null,null);

								

								$traineeDataArrv=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$id)));

			               

							$callresponse=array('status'=>'True','result'=>'Successfully Updated.','ClientDetail'=>$traineeDataArrv);

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						} else {

							

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

				}

				else {

					$callresponse=array('status'=>'False','result'=>'Username/email already exist.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

					

				}

					

			}

			

		}

		

		public function view_trainer_client()

		{

			$this->layout = "ajax";		    

		   

			 $id=trim($_REQUEST['id']);

				if($id!='')

				{

		

		  $traineeDataArrv=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$id)));

		  if(!empty($traineeDataArrv))

		  {

	$callresponse=array('status'=>'True','result'=>$traineeDataArrv);

					       $callresponse2=json_encode($callresponse);

					       $this->set('flagv', $callresponse2);

		  }

		  else {

		  	

		  	$callresponse=array('status'=>'False','result'=>'Sorry, this client data not exist.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

		  }

						       

				} else {

					$callresponse=array('status'=>'False','result'=>'Sorry, this client data not exist.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);	

					

				}

		}

		

		public function manage_workout()

		{

			$this->layout = "ajax";		    

			 $id=trim($_REQUEST['id']);

				if($id!='')

				{

					$workoutDataArrv=$this->WorkOuts->find("all",array("conditions"=>array("WorkOuts.trainer_id"=>$id)));

					if(!empty($workoutDataArrv))

					{

						   $callresponse=array('status'=>'True','result'=>$workoutDataArrv);

					       $callresponse2=json_encode($callresponse);

					       $this->set('flagv', $callresponse2);

					}else {

					           $callresponse=array('status'=>'False','result'=>'This trainer did not any workouts, please add new workout.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

				   }

				}

				else {

					           $callresponse=array('status'=>'False','result'=>'Sorry, please select trainer.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

				}

			

		}

		

		public function add_workout()

		{

			$this->layout = "ajax";		

			if(isset($_REQUEST['id']) && $_REQUEST['id']!='' && isset($_REQUEST['workout_name']) && $_REQUEST['workout_name']!='' && isset($_REQUEST['workout_time']) && $_REQUEST['workout_time']!='' && isset($_REQUEST['workout_price']) && $_REQUEST['workout_price']!=''  && isset($_REQUEST['status']) && $_REQUEST['status']!='')

			{    

				 $id=trim($_REQUEST['id']);

				 $workout_name=trim($_REQUEST['workout_name']);

				 $workout_time=trim($_REQUEST['workout_time']);

				 $workout_price=trim($_REQUEST['workout_price']);

				 $added_date=date('Y-m-d H:i:s');

				 $modified_date=date('Y-m-d H:i:s');

				 $status=$_REQUEST['status'];

				 $dataArr=array();

				 $dataArr['WorkOuts']['workout_name']=$workout_name;

				 $dataArr['WorkOuts']['workout_time']=$workout_time;

				 $dataArr['WorkOuts']['workout_price']=$workout_price;

				 $dataArr['WorkOuts']['trainer_id']=$id;

				 $dataArr['WorkOuts']['added_date']=$added_date;

				 $dataArr['WorkOuts']['modified_date']=$modified_date;

				 $dataArr['WorkOuts']['status']=$status;

				 if($this->WorkOuts->save($dataArr))

				 {

				 	           $callresponse=array('status'=>'True','result'=>'Successfully Added.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

				 }

			}

			else {

				 $callresponse=array('status'=>'False','result'=>'Please fill all fields value.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

		}

		

	public function edit_workout()

		{

			$this->layout = "ajax";		

			if(isset($_REQUEST['id']) && $_REQUEST['id']!='' && isset($_REQUEST['workout_name']) && $_REQUEST['workout_name']!='' && isset($_REQUEST['workout_time']) && $_REQUEST['workout_time']!='' && isset($_REQUEST['workout_price']) && $_REQUEST['workout_price']!=''  && isset($_REQUEST['status']) && $_REQUEST['status']!='')

			{    

				 $id=trim($_REQUEST['id']);

				 $workout_name=trim($_REQUEST['workout_name']);

				 $workout_time=trim($_REQUEST['workout_time']);

				  $workout_price=trim($_REQUEST['workout_price']);

				 $added_date=date('Y-m-d H:i:s');

				 $modified_date=date('Y-m-d H:i:s');

				  $status=$_REQUEST['status'];

				 $dataArr=array();

				 $dataArr['WorkOuts']['workout_name']=$workout_name;

				 $dataArr['WorkOuts']['workout_time']=$workout_time;

				 $dataArr['WorkOuts']['workout_price']=$workout_price;

				 //$dataArr['WorkOuts']['trainer_id']=$id;

				 //$dataArr['WorkOuts']['added_date']=$added_date;

				 $dataArr['WorkOuts']['modified_date']=$modified_date;

				 //$dataArr['WorkOuts']['status']=$status;

				 $this->WorkOuts->id=$id;

				 if($this->WorkOuts->save($dataArr))

				 {

				 	           $callresponse=array('status'=>'True','result'=>'Successfully updated.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

				 }

			}

			else {

				 $callresponse=array('status'=>'False','result'=>'Please fill all fields value.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

		}

		

		public function delete_workout()

		{

			$this->layout = "ajax";		

			if(isset($_REQUEST['id']) && $_REQUEST['id']!='')

			{    

				 $id=trim($_REQUEST['id']);

			

				 if($this->WorkOuts->delete($id))

				 {

				 	           $callresponse=array('status'=>'True','result'=>'Successfully deleted.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

				 }

			}

			else {

				 $callresponse=array('status'=>'False','result'=>'Please select workout.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

		}

		

		public function getlibrary()

		{

		 $this->layout = "ajax";		

			$videos=$this->ExerciseLibrary->find('all',array('conditions'=>array('ExerciseLibrary.status'=>1),'fields'=>array('ExerciseLibrary.id','ExerciseLibrary.doc_name','ExerciseLibrary.description')));	

			if(!empty($videos))

			{

				$callresponse=array('status'=>'True','result'=>$videos);

				$callresponse2=json_encode($callresponse);

				$this->set('flagv', $callresponse2);

			}

			else 

			{

				               $callresponse=array('status'=>'False','result'=>'No Result Found.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

			

		}

		

		public function sendlibrarydoc()

		{

		 $this->layout = "ajax";		

			

		/* echo '<pre>';

		 print_r($_POST);

		 echo '</pre>';

		 die();*/

		 			

	$clientsemail=		$this->Trainee->find('all',array('conditions'=>array('Trainee.id'=>$_POST['client_ids']),'fields'=>array('Trainee.email')));

	

	$videoslink=$this->ExerciseLibrary->find('all',array('conditions'=>array('ExerciseLibrary.id'=>$_POST['video_ids']),'fields'=>array('ExerciseLibrary.doc_name','ExerciseLibrary.id')));

			

		/*echo "<pre>";

			print_r($clientsemail);

			

			print_r($videoslink);

		die();	*/

		

		foreach($videoslink as $vids)

		

		{

			 $videosmaillink.='<p>'.trim($vids['ExerciseLibrary']['doc_name']).'<br/>

			<a href='.$this->config['url'].'librarys/viewvideo/'.base64_encode($vids['ExerciseLibrary']['id']).' target="_blank">Click to view</a></p>';

			

		}

		$msgv=$_POST['message'];

			foreach($clientsemail as $details)

			{

				if($details['Trainee']['email']!='')

				{

					

					

							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello!</p>

				

				<p>'.$msgv.'</p>';

							

					$content .=$videosmaillink;	

				$content .='</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

								

								$subject = $this->config["base_title"]." : Videos Links"; 

						  

						

							

								//$ps=1;

								$emailb=trim($details['Trainee']['email']);

								 if($this->sendEmailMessage($emailb,$subject,$content,null,null)){

							 	$callresponse=array('status'=>'True','result'=>'Successfully sent.');

						     $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);

							 }

							else {

								$callresponse=array('status'=>'False','result'=>'Email not valid. Please give vaild email.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

							}

							

							

							

								/*if($this->sendEmailMessage(trim($details['Trainee']['email']),$subject,$content,null,null))

								{

										$ps=1;

								}

								else {

										$ps=0;

								}*/

								

					

					

					

					

					

				}

			}

			/*$callresponse=array('status'=>'True','result'=>'Successfully sent.');

				$callresponse2=json_encode($callresponse);

				$this->set('flagv', $callresponse2);*/

			

		}

		

		public function send_nutritional_log()

		{

			$resPonse=array();

		 $this->layout = "ajax";		

				

		if(!empty($_REQUEST['client_id'])){

				$clientid=$_REQUEST['client_id'];

		}

		if(!empty($_REQUEST['datva'])){

				$datva=$_REQUEST['datva'];

				$originalDate = $datva;

$newDate = date("Y-m-d", strtotime($originalDate));

		}	

		if(!empty($_REQUEST['trainer_id'])){

				$trainer_id=$_REQUEST['trainer_id'];

		}	

			

		  

		  $logdata=$this->AdddailyNutritionDiary->find("all",array("conditions"=>array("AdddailyNutritionDiary.client_id"=>$clientid,"AdddailyNutritionDiary.trainer_id"=>$trainer_id,"AdddailyNutritionDiary.foodlogdate"=>$newDate), 'order' => array('AdddailyNutritionDiary.id' => 'DESC')));

		 

		  /*echo "<pre>";

		  print_r($logdata);

		  echo "</pre>";

		  die('here');*/

		  

		  $breakfastArr=array();

		  $lunchArr=array();

		  $dinnerArr=array();

		  $snacksArr=array();

		  

		  

		  if(!empty($logdata))

			{

				$i=0;

				foreach ($logdata as $singlelog)

				{

					

					if($singlelog['AdddailyNutritionDiary']['food_type']=='Breakfast')

					{

						//$resPonse['Breakfast']=$logdata;

						$breakfastArr[]=$logdata[$i];

					}/*else{

						$resPonse['Breakfast']=array();

					}*/	

					if($singlelog['AdddailyNutritionDiary']['food_type']=='Lunch')

					{

						//$resPonse['Lunch']=$logdata;

						$lunchArr[]=$logdata[$i];

					}/*else{

						$resPonse['Lunch']=array();

					}*/	

					

					if($singlelog['AdddailyNutritionDiary']['food_type']=='Dinner')

					{

						//$resPonse['Dinner']=$logdata;

						$dinnerArr[]=$logdata[$i];

					}/*else{

						$resPonse['Dinner']=array();

					}*/	

					

					if($singlelog['AdddailyNutritionDiary']['food_type']=='Snacks')

					{

						//$resPonse['Snacks']=$logdata;

						$snacksArr[]=$logdata[$i];

					}/*else{

						$resPonse['Snacks']=array();

					}*/	

					$i++;	

				}

				

				

						$callresponse=array('status'=>'True','result'=>'Please check All data','Breakfast'=>$breakfastArr,'Lunch'=>$lunchArr,'Dinner'=>$dinnerArr,'Snacks'=>$snacksArr);

					$callresponse2=json_encode($callresponse);

					$this->set('flagv', $callresponse2);

				

			}

				

			

			else 

			{

				               $callresponse=array('status'=>'False','result'=>'No Result Found.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}	

			

	

			

		}

		public function measurement_and_goal(){		

			

		$this->layout = "ajax";	

		$respons=array();

			

			//$clientid=$this->params['pass'][0];

			//$clientid=18;

		if(!empty($_REQUEST['client_id'])){

			

				$clientid=$_REQUEST['client_id'];

		}

		if($clientid!='')

		{

			$response=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid), 'order' => array('Goal.goal ' => 'Desc')));

		 	 

		 	

		 	$respons['goal_id'] = $response['Goal']['id'];

		 	$respons['goal_name'] = $response['Goal']['goal'];

		 	

	

			$response19 =$this->SevensiteBodyfat->find("all",array("conditions"=>array("SevensiteBodyfat.client_id"=>$clientid), 'order' => array('SevensiteBodyfat.id ' => 'Desc')));

		 	

		 	$response20 =$this->ThreesiteBodyfat->find("all",array("conditions"=>array("ThreesiteBodyfat.client_id"=>$clientid), 'order' => array('ThreesiteBodyfat.id ' => 'Desc')));

			

		$cntv=0;	

		$cntv1=0;	

		$cntv2=0;	

		if(!empty($response19))

		{

			$cntv1=count($response19);

		}

		if(!empty($response20))

		{

			$cntv2=count($response20);

		}

		

		if($cntv2>$cntv1)

		{

			$cntv=$cntv2;	

		}else{

		  if($cntv1>$cntv2)

		  {

		  	$cntv=$cntv1;	

		  }

		}

		

	    for($i=0;$i<=$cntv;$i++)

				

				{

					

						if(isset($response19[$i]['SevensiteBodyfat']['created_date']))

						{

						

							 $dtvs=$response19[$i]['SevensiteBodyfat']['created_date'];

						}

						if(isset($response20[$i]['ThreesiteBodyfat']['created_date']))

						{

							 $dtvs=$response20[$i]['ThreesiteBodyfat']['created_date'];

						}

						/*if(isset($response21[$i]['BodymassIndex']['created_date']))

						{

							echo $dtvs=$response21[$i]['BodymassIndex']['created_date'];

						}*/

						 $baseurl=Router::url('/', true);

					

					$respons['Records'][$i]['Created']=date('Y-m-d',strtotime($dtvs));

					$respons['Records'][$i]['Seven_Site_Body_Fat']=$response19[$i]['SevensiteBodyfat']['body_fat'];

					$respons['Records'][$i]['Three_Site_Body_Fat']=$response20[$i]['ThreesiteBodyfat']['body_fat'];

					$respons['Records'][$i]['graph_url']=$baseurl."home/clientmesdetail/".$clientid."/".date('Y-m-d',strtotime($dtvs));

					

				 $cnt++;

				};



		 

		  

		 

		  if(!empty($respons))

		  {

		  	$callresponse=array('status'=>'True','result'=>'Successfully sent.','measurement_goal'=>$respons);



					$callresponse2=json_encode($callresponse);

					$this->set('flagv', $callresponse2);

		  }

		  else{

		  	 $callresponse=array('status'=>'False','result'=>'No Result Found.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

		  	

		  }

		  

		  }

		  

			

		}

		

	public function deletemeasurement()

		{

						

			$this->layout = 'ajax';

			$created_date=$_REQUEST['created_date'];

			$client_id=$_REQUEST['client_id'];

			

			if(trim($created_date)!='' && trim($client_id)!='')

			{

				$datavt=array();				

				 $datavt['client_id']=trim($client_id);

			 $datavt['created_date']=$created_date;

				



				

				//$datavb['id']=trim($_POST['id3']);

				$this->SevensiteBodyfat->query("delete from sevensite_bodyfats where client_id='".$datavt['client_id']."' and created_date='".$datavt['created_date']."'");

						

						

				$this->ThreesiteBodyfat->query("delete from threesite_bodyfat where client_id='".$datavt['client_id']."' and created_date='".$datavt['created_date']."'");

						

						

				$this->BodymassIndex->query("delete from bodymass_index where client_id='".$datavt['client_id']."' and created_date='".$datavt['created_date']."'");

				

				

			$callresponse=array('status'=>'True','result'=>'Successfully Deleted.');

			$callresponse2=json_encode($callresponse);

			$this->set('flagv', $callresponse2);	

						

			}

			else 

			{

				

				 $callresponse=array('status'=>'False','result'=>'Oops Some Error Occured.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

			

			

					

			

		}

		

	public function  editgoal()

		{

			$this->layout = 'ajax';

			$goal_id=$_REQUEST['goal_id'];

			$goal=$_REQUEST['goal'];

			if(trim($goal_id)!='')

			{

				$data=array();				

				

				$this->request->data['Goal']['goal']=trim($goal);

				

				$this->Goal->id=trim($goal_id);

				

				if($this->Goal->save($this->data)) {

							

							

					$callresponse=array('status'=>'True','result'=>'Successfully updated.');

				$callresponse2=json_encode($callresponse);

				$this->set('flagv', $callresponse2);			

						}

						else {

							

							

							 $callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

			}

			else 

			{

				

				

				 $callresponse=array('status'=>'False','result'=>'Sorry, please refresh the page and try again!!.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

			

			

		}

		

		public function  addgoal()

		{

			$this->layout = '';

			$this->autoRender=false;

			$tainer_id=$_REQUEST['trainer_id'];

			$tainee_id=$_REQUEST['client_id'];

			$goal=$_REQUEST['goal'];

			if(trim($tainer_id)!='' && trim($tainee_id)!='' && trim($goal)!='')

			{

				$data=array();				

				

				$this->request->data['Goal']['goal']=trim($goal);

				$this->request->data['Goal']['trainer_id']=trim($tainer_id);

				$this->request->data['Goal']['trainee_id']=trim($tainee_id);

				$this->request->data['Goal']['added_date']=date('Y-m-d H:i:s');

				$this->request->data['Goal']['modified_date']=date('Y-m-d H:i:s');

				

				

				

				if($this->Goal->save($this->data)) {

							$goalid=$this->Goal->getLastInsertID();

							

					$callresponse=array('status'=>'True','result'=>'Successfully added.','GoalID'=>$goalid,'Goal'=>$goal);

				echo $callresponse2=json_encode($callresponse);

				exit;

				//$this->set('flagv', $callresponse2);			

						}

						else {

							

							

							 $callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!.');

						       echo $callresponse2=json_encode($callresponse);

						       exit;

						       //$this->set('flagv', $callresponse2);

						}

			}

			else 

			{

				

				

				 $callresponse=array('status'=>'False','result'=>'Sorry, please refresh the page and try again!!.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

			}

			

			

		}

	public function add_measurement_goal(){	

		$this->layout = "ajax";

			

		$flg=0;

		if(trim($_REQUEST['client_id'])!='')

		{

			if(trim($_REQUEST['skinfold'])=='7')

	         {

			$setSpecalistArr99=$this->SevensiteBodyfat->find("all",array("conditions"=>array("SevensiteBodyfat.created_date"=>date("Y-m-d"),"SevensiteBodyfat.client_id"=>trim($_REQUEST['client_id']))));

	         }

	         if(trim($_REQUEST['skinfold'])=='3')

	         {

			$setSpecalistArr99=$this->ThreesiteBodyfat->find("all",array("conditions"=>array("ThreesiteBodyfat.created_date"=>date("Y-m-d"),"ThreesiteBodyfat.client_id"=>trim($_REQUEST['client_id']))));

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

	

		$client_id=$_REQUEST['client_id'];

		$skinfold=$_REQUEST['skinfold'];

		$gender=$_REQUEST['gender'];

	

	  

		

		if($flg==0)

		{

		if(trim($skinfold)=='7'){

				if($_REQUEST['gender']=='Male')

				{

					if(trim($_REQUEST['age'])!=''  && trim($_REQUEST['chest'])!=''&& trim($_REQUEST['abdominal'])!='' && trim($_REQUEST['thigh'])!='' && trim($_REQUEST['tricep'])!='' && trim($_REQUEST['subscanpularis'])!='' && trim($_REQUEST['illaccrest'])!='' && trim($_REQUEST['midaxillary'])!=''  && trim($_REQUEST['client_id'])!='') 

					{

						//echo "Male";

						

						$measuremenv=array();

						

						

						

						//$measuremenv['SevensiteBodyfat']['weight']=trim($_REQUEST['weight']);

						//$measuremenv['SevensiteBodyfat']['height']=trim($_REQUEST['height']);

						$measuremenv['SevensiteBodyfat']['age']=trim($_REQUEST['age']);

						$measuremenv['SevensiteBodyfat']['gender']=trim($_REQUEST['gender']);

						

						

						

						$measuremenv['SevensiteBodyfat']['chest']=trim($_REQUEST['chest']);

						$measuremenv['SevensiteBodyfat']['abs']=trim($_REQUEST['abdominal']);

						$measuremenv['SevensiteBodyfat']['thigh']=trim($_REQUEST['thigh']);

						$measuremenv['SevensiteBodyfat']['triceps']=trim($_REQUEST['tricep']);

						$measuremenv['SevensiteBodyfat']['subscapularis']=trim($_REQUEST['subscanpularis']);

						$measuremenv['SevensiteBodyfat']['illiaccrest']=trim($_REQUEST['illaccrest']);

						$measuremenv['SevensiteBodyfat']['midaxillary']=trim($_REQUEST['midaxillary']);

						$measuremenv['SevensiteBodyfat']['status']=1;

						$measuremenv['SevensiteBodyfat']['client_id']=trim($_REQUEST['client_id']);

					

						

						$measuremenv['SevensiteBodyfat']["created_date"]  = date("Y-m-d");

						

						$Sum=intval(trim($_REQUEST['chest']))+intval(trim($_REQUEST['abdominal']))+intval(trim($_REQUEST['thigh']))+intval(trim($_REQUEST['tricep']))+intval(trim($_REQUEST['subscanpularis']))+intval(trim($_REQUEST['illaccrest']))+intval(trim($_REQUEST['midaxillary']));

						$age=intval(trim($_REQUEST['age']));

		               $BD = 1.112 - ((0.000435)*$Sum) + (((0.00000055)*$Sum)*2) - ((0.000288)*$age);

		               //$BD=round($BD, 2);

		                

		                $bodymalefat = 495/$BD - 450;

		                $bodymalefat = round($bodymalefat);

		              $measuremenv['SevensiteBodyfat']['body_fat']=$bodymalefat;

						$this->SevensiteBodyfat->save($measuremenv);

						

						

							

					$callresponse=array('status'=>'True','result'=>'Successfully Added your Seven site details.','bodyfat'=>$bodymalefat);

				$callresponse2=json_encode($callresponse);

				$this->set('flagv', $callresponse2);	

					}

				}

				

				elseif($_REQUEST['gender']=='Female')

				{

				  

					if(trim($_REQUEST['age'])!='' && trim($_REQUEST['chest'])!=''&& trim($_REQUEST['abdominal'])!='' && trim($_REQUEST['thigh'])!='' && trim($_REQUEST['tricep'])!='' && trim($_REQUEST['subscanpularis'])!='' && trim($_REQUEST['illaccrest'])!='' && trim($_REQUEST['midaxillary'])!=''  && trim($_REQUEST['client_id'])!='') 

				  

				  {

				     //echo "Female";

				     $measuremenv=array();

						

						

						//$measuremenv['SevensiteBodyfat']['weight']=trim($_REQUEST['weight']);

						//$measuremenv['SevensiteBodyfat']['height']=trim($_REQUEST['height']);

						$measuremenv['SevensiteBodyfat']['age']=trim($_REQUEST['age']);

						$measuremenv['SevensiteBodyfat']['gender']=trim($_REQUEST['gender']);

						

						

						

						$measuremenv['SevensiteBodyfat']['chest']=trim($_REQUEST['chest']);

						$measuremenv['SevensiteBodyfat']['abs']=trim($_REQUEST['abdominal']);

						$measuremenv['SevensiteBodyfat']['thigh']=trim($_REQUEST['thigh']);

						$measuremenv['SevensiteBodyfat']['triceps']=trim($_REQUEST['tricep']);

						$measuremenv['SevensiteBodyfat']['subscapularis']=trim($_REQUEST['subscanpularis']);

						$measuremenv['SevensiteBodyfat']['illiaccrest']=trim($_REQUEST['illaccrest']);

						$measuremenv['SevensiteBodyfat']['midaxillary']=trim($_REQUEST['midaxillary']);

						$measuremenv['SevensiteBodyfat']['status']=1;

						$measuremenv['SevensiteBodyfat']['client_id']=trim($_REQUEST['client_id']);

					

						

						$measuremenv['SevensiteBodyfat']["created_date"] = date("Y-m-d");

						

						$Sum=intval(trim($_REQUEST['chest']))+intval(trim($_REQUEST['abdominal']))+intval(trim($_REQUEST['thigh']))+intval(trim($_REQUEST['tricep']))+intval(trim($_REQUEST['subscanpularis']))+intval(trim($_REQUEST['illaccrest']))+intval(trim($_REQUEST['midaxillary']));

						$age=intval(trim($_REQUEST['age']));

		               $BD = 1.097 - ((0.00047)*$Sum) + (((0.00000056)*$Sum)*2) - ((0.000128)*$age);

		              // $BD=round($BD, 2);

		                

		                $bodyfemalefat = 496/$BD - 451;

		                $bodyfemalefat = round($bodyfemalefat);

		              $measuremenv['SevensiteBodyfat']['body_fat']=$bodyfemalefat;

		              $this->SevensiteBodyfat->save($measuremenv);

		              

		              

						

						

								

					$callresponse=array('status'=>'True','result'=>'Successfully Added your Seven site details.','bodyfat'=>$bodymalefat);

				$callresponse2=json_encode($callresponse);

				$this->set('flagv', $callresponse2);	

		              

		              

		              

				  }

				

				  }

		      }

		  if(trim($_REQUEST['skinfold'])=='3')

		  {

		  	if($_REQUEST['gender']=='Male')

				{

					if(trim($_REQUEST['age'])!='' && trim($_REQUEST['chest'])!=''&& trim($_REQUEST['abdominal'])!='' && trim($_REQUEST['thigh'])!='' && trim($_REQUEST['client_id'])!='') 

					{

						

						$threesiteArr=array();

						

						$threesiteArr['ThreesiteBodyfat']['age']=trim($_REQUEST['age']);

						$threesiteArr['ThreesiteBodyfat']['gender']=trim($_REQUEST['gender']);

						$threesiteArr['ThreesiteBodyfat']['abdominal']=trim($_REQUEST['abdominal']);

						

						

						

						$threesiteArr['ThreesiteBodyfat']['chest']=trim($_REQUEST['chest']);

					

						$threesiteArr['ThreesiteBodyfat']['thigh']=trim($_REQUEST['thigh']);

						$threesiteArr['ThreesiteBodyfat']['triceps']='';

					   $threesiteArr['ThreesiteBodyfat']['suprailiac']='';

						

						

						

						$threesiteArr['ThreesiteBodyfat']['status']=1;

						$threesiteArr['ThreesiteBodyfat']['client_id']=trim($_REQUEST['client_id']);

					

						

						$threesiteArr['ThreesiteBodyfat']["created_date"] 		    = date("Y-m-d");

						

						

						

						$Sum2=intval(trim($_REQUEST['chest']))+intval(trim($_REQUEST['abdominal']))+intval(trim($_REQUEST['thigh']));

						$age=intval(trim($_REQUEST['age']));

						

						

						  $BodyDensity = 1.10938- ((0.0008267)*$Sum2) + (((0.0000016)*($Sum2))*2) - ((0.0001392)*$age);

						 $BodyFat = 457/$BodyDensity - 414;

						 $BodyFat = round($BodyFat,2);

						

						

						$threesiteArr['ThreesiteBodyfat']['body_fat']=$BodyFat;

						

						

						$this->ThreesiteBodyfat->save($threesiteArr);

						

						

					

								

					$callresponse=array('status'=>'True','result'=>'Successfully Added your Three site details.','bodyfat'=>$BodyFat);

				$callresponse2=json_encode($callresponse);

				$this->set('flagv', $callresponse2);	

					}

				}

				

				elseif($_REQUEST['gender']=='Female')

				{

				  

					if(trim($_REQUEST['age'])!='' && trim($_REQUEST['thigh'])!='' && trim($_REQUEST['chest'])!='' && trim($_REQUEST['abdominal'])!=''  && trim($_REQUEST['client_id'])!='') 

				  

				  {

				     

		              

		                $threesiteArr=array();

						

						$threesiteArr['ThreesiteBodyfat']['age']=trim($_REQUEST['age']);

						$threesiteArr['ThreesiteBodyfat']['gender']=trim($_REQUEST['gender']);

						

						

					

						$threesiteArr['ThreesiteBodyfat']['thigh']=trim($_REQUEST['thigh']);

						$threesiteArr['ThreesiteBodyfat']['triceps']=trim($_REQUEST['abdominal']);

						$threesiteArr['ThreesiteBodyfat']['suprailiac']=trim($_REQUEST['chest']);

						

						

						

						$threesiteArr['ThreesiteBodyfat']['status']=1;

						$threesiteArr['ThreesiteBodyfat']['client_id']=trim($_REQUEST['client_id']);;

					

						

						$threesiteArr['ThreesiteBodyfat']["created_date"] 		    = date("Y-m-d");

						

						

						

						$Sum2=intval(trim($_REQUEST['thigh']))+intval(trim($_REQUEST['chest']))+intval(trim($_REQUEST['abdominal']));

						$age=intval(trim($_REQUEST['age']));

						

						

						 $BodyDensity = 1.099421- ((0.0009929)*$Sum2) + (((0.0000023)*($Sum2))*2) - ((0.0001392)*$age);

						$BodyFat = (457/$BodyDensity)-414;

						$BodyFat = round($BodyFat);

						$threesiteArr['ThreesiteBodyfat']['body_fat']=$BodyFat;

						

						$this->ThreesiteBodyfat->save($threesiteArr);

						

						

						

						$callresponse=array('status'=>'True','result'=>'Successfully Added your Three site details.','bodyfat'=>$BodyFat);

				$callresponse2=json_encode($callresponse);

				$this->set('flagv', $callresponse2);

		              

		              

		              

				  }

				

				  }

		  	

		  }

		}

		else {

			

			$callresponse=array('status'=>'False','result'=>'Sorry, you need to first delete this date entry then you can able to add new one!!.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

		}

			

		}

		

		public function search_daily_food($food=null)

		{	

			

			

			$this->layout = "ajax";

			

			

			

			if(trim($food)!='' )

			{

				

             //$food = $_REQUEST['search_food']; 

				//$datav=array();

				

				

				$response=$this->FoodUsda->find("all",array("conditions"=>array("FoodUsda.name LIKE"=>"%".$food."%"), 'order' => array('FoodUsda.id' => 'DESC')));

				

					$callresponse=array('status'=>'True','result'=>'Successfully sent.','resultSearchFood'=>$response);

					$callresponse2=json_encode($callresponse);

					$this->set('flagv', $callresponse2);

			}

			else {

						$callresponse=array('status'=>'False','result'=>'Sorry!!Not Found');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

						}

			

			

		}

		

		public function add_daily_diary()

		{

		  $this->layout = '';

		  $this->autoRender = false;

	

			

		

				$fooddata=array();

				$response=array();

				

			if( $_REQUEST['food_list']!='' && $_REQUEST['food_qty']!='' && $_REQUEST['client_id']!='')

			{

$fdtype=trim($_POST['food_id']);

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

				

				$id = trim($_REQUEST['client_id']);

				

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

							

							

							$response=array('status'=>'True','result'=>'Thanks, you have added Food log successfully.');

						      

						}

						else {

							

							

							$response=array('status'=>'False','result'=>'Sorry, please refresh the page and try again!!');

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

							

							

							$response=array('status'=>'True','result'=>'Successfully deleted');

						}

						else {

							

							

						

							$response=array('status'=>'False','result'=>'Some issue occur, please try again!!');

						}

			}

			else 

			{

				

				$response=array('status'=>'False','result'=>'Some issue occur, please try again!!');

			}

			

			

				echo json_encode($response);

				exit;	

			

		}

		

			public function gettrnertype($trid=null){	

				$this->layout = "";

				$this->autoRender=false;

				if($trid!=''){

				$setTrArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$trid)));                if($setTrArr['Trainer']['id']!=''){ 

				 $callresponse=array('status'=>'True','result'=>$setTrArr['Trainer']['trainer_type']);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						    // $this->set('flagv', $callresponse2);

				  }

				  else {

				  	$callresponse=array('status'=>'False','result'=>'Sorry record not found');

						 echo $callresponse2=json_encode($callresponse);

						 exit;

						// $this->set('flagv', $callresponse2);	

				  }

				}else {

					$callresponse=array('status'=>'False','result'=>'Please select Trainer');

						 echo $callresponse2=json_encode($callresponse);

						 exit;

						// $this->set('flagv', $callresponse2);	

				}

		}

		

		/* Communication center Trainer*/

		

		public function communication_centertr(){		

		

		$this->layout = "";		

		$this->autoRender=false;	

		

		//$dbusertype = trim($_REQUEST['usertype']);					

		$dbusertype ='Trainer';					

		

		$uid = trim($_REQUEST['trainer_id']);	

		//$uid = 51;	

            

	   $communicationtype=trim($_REQUEST['ctype']);

	   //$communicationtype='email';

	   $sessionfor=trim($_REQUEST['sessionfor']);

	   //$sessionfor='client';

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$clientDataArr=$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$uid),'fields'=>array('Trainee.id','Trainee.username')));

		// $this->set("clientDataArr",$clientDataArr);

	   if($communicationtype=='email')

	   {

	   	

	   	 if($sessionfor=='Client')

	   	 {

	   	 	

	   	 	 $emessageclientInArr=$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Client','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC')));	

	   	 	

	   	 	

		     

		     $emessageclientsentArr=$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'Trainer','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC')));	

		     

		      $callresponse=array('status'=>'True','result'=>'Set result','InboxE'=>$emessageclientInArr,'OutboxE'=>$emessageclientsentArr,'ClientList'=>$clientDataArr);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		     	     

	   	 }

	   	 if($sessionfor=='Club')

	   	 {

	   	 	  $clubid=$setSpecalistArr['Trainer']['club_id'];

		      $clubDataArr=$this->Club->find('first',array('conditions'=>array('Club.id'=>$clubid),'fields'=>array('Club.id','Club.username','Club.email','Club.club_name')));	

		       //$this->set("clubDataArr",$clubDataArr);

		       

		        $emessageclubInArr=$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Club','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC')));

		       

		       $emessageclubsentArr=$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Club','Emessage.sender_type'=>'Trainer','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC')));

		       

		        $callresponse=array('status'=>'True','result'=>'Set result','InboxCE'=>$emessageclubInArr,'OutboxCE'=>$emessageclubsentArr,'ClubData'=>$clubDataArr);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

	   	 }

	   	

	   	

	   }

	   

	   if($communicationtype=='text')

	   {

	   	   if($sessionfor=='Client')

	   	  {

	   	  	$emessageclientArrTxt=$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Client','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC')));	

		     

		     $emessageclientsentArrTxt=$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'Trainer','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC')));

		     

		      $callresponse=array('status'=>'True','result'=>'Set result','InboxT'=>$emessageclientArrTxt,'OutboxT'=>$emessageclientsentArrTxt,'ClientList'=>$clientDataArr);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		     

	   	  }

	   	  if($sessionfor=='Club')

	   	 {

	   	 	 $clubid=$setSpecalistArr['Trainer']['club_id'];

		      $clubDataArr=$this->Club->find('first',array('conditions'=>array('Club.id'=>$clubid),'fields'=>array('Club.id','Club.username','Club.email','Club.club_name')));	

	   	 	  $emessageclubArrTxt=$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Club','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC')));

		     

		      $emessageclubsentArrTxt=$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Club','Emessage.sender_type'=>'Trainer','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC')));

		       $callresponse=array('status'=>'True','result'=>'Set result','InboxCT'=>$emessageclubArrTxt,'OutboxCT'=>$emessageclubsentArrTxt,'ClubData'=>$clubDataArr);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

	   	 }

	   	

	   } 

     		

	}

	/* Communication Center for Client*/

	public function communication_centerclient(){		

		

		$this->layout = "";		

		$this->autoRender=false;

		

		$dbusertype = 'Trainee';					

		$communicationtype=trim($_REQUEST['ctype']);

		$uid = trim($_REQUEST['client_id']);	

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		$trid=$setSpecalistArr['Trainee']['trainer_id'];

		     

		     $trainerDataArr=$this->Trainer->find('first',array('conditions'=>array('Trainer.id'=>$trid),'fields'=>array('Trainer.id','Trainer.username','Trainer.full_name')));

		    

		

		   if($communicationtype=='email')

	       {

		    $emessageclientInArr=$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'Trainer','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC')));	

		     

		     $emessageclientsentArr=$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Client','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC')));

		     

		      $callresponse=array('status'=>'True','result'=>'Set result','InboxE'=>$emessageclientInArr,'OutboxE'=>$emessageclientsentArr,'TrainerData'=>$trainerDataArr);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		     

	       } 

	    if($communicationtype=='text')

	     {

		     

		      $emessageclientArrTxt=$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'Trainer','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC')));	

		     

		     $emessageclientsentArrTxt=$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Client','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC')));

		     

		      $callresponse=array('status'=>'True','result'=>'Set result','InboxT'=>$emessageclientArrTxt,'OutboxT'=>$emessageclientsentArrTxt,'TrainerData'=>$trainerDataArr);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		     

	     }  

		     

		  

		  

		}

		

		/* Communication center for club start */

		public function communication_centerclub(){		

		

		$this->layout = "";	

		$this->autoRender=false;			

		$dbusertype = 'Club';		

		

		/*$uid = 1;

		$ctype = 'text';

		$sentfor = 'Trainer';*/

		/*echo '<pre>';

		print_r($_POST);

		echo '</pre>';

		die();*/

		$uid = trim($_REQUEST['club_id']);

		$ctype = trim($_REQUEST['ctype']);

		$sentfor = trim($_REQUEST['sessionfor']);

		

	

		

			if($sentfor=='Trainer')

			{

			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

			 $clubTrainerDataArr=$this->Trainer->find('list',array('conditions'=>array('Trainer.club_id'=>$uid),'fields'=>array('Trainer.id','Trainer.username')));

		  //Emessage for Mail Session

		     if($ctype=='email'){

		     

		     $emessageclubArr=$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Club','Emessage.sender_type'=>'Trainer','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC')));

		     

		     

		       

		       $emessageclubsentArr=$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Club','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC')));

		       

		          $callresponse=array('status'=>'True','result'=>'Set result','InboxE'=>$emessageclubArr,'OutboxE'=>$emessageclubsentArr,'TrainerData'=>$clubTrainerDataArr);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		       

		     }

		       

		     //Emessage for Text Session   

		     if($ctype=='text'){

		       

		     $emessageclubArrTxt=$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Club','Emessage.sender_type'=>'Trainer','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC')));

		     

		      $emessageclubsentArrTxt=$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Trainer','Emessage.sender_type'=>'Club','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC')));

		      

		       $callresponse=array('status'=>'True','result'=>'Set result','InboxT'=>$emessageclubArrTxt,'OutboxT'=>$emessageclubsentArrTxt,'TrainerData'=>$clubTrainerDataArr);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		     

		     }

			}

			if($sentfor=='Client')

			{

				$setSpecalistArr=$this->Club->find("first",array("conditions"=>array("Club.id"=>$uid)));

			 $clubTrainerDataArr=$this->Trainee->find('list',array('conditions'=>array('Trainee.club_id'=>$uid),'fields'=>array('Trainee.id','Trainee.username')));

		  //Emessage for Mail Session

		     if($ctype=='email'){

		     

		     $emessageclubArr=$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Club','Emessage.sender_type'=>'Client','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC')));

		     

		     

		       

		       $emessageclubsentArr=$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'Club','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'E'),'order'=>array('Emessage.id DESC')));

		       

		          $callresponse=array('status'=>'True','result'=>'Set result','InboxE'=>$emessageclubArr,'OutboxE'=>$emessageclubsentArr,'ClientData'=>$clubTrainerDataArr);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		       

		     }

		       

		     //Emessage for Text Session   

		     if($ctype=='text'){

		       

		     $emessageclubArrTxt=$this->Emessage->find('all',array('conditions'=>array('Emessage.receiver_id'=>$uid,'Emessage.receiver_type'=>'Client','Emessage.sender_type'=>'Club','Emessage.delflag_receiver'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC')));

		     

		      $emessageclubsentArrTxt=$this->Emessage->find('all',array('conditions'=>array('Emessage.sender_id'=>$uid,'Emessage.receiver_type'=>'Club','Emessage.sender_type'=>'Client','Emessage.delflag_sender'=>'N','Emessage.usefor'=>'T'),'order'=>array('Emessage.id DESC')));

		      

		       $callresponse=array('status'=>'True','result'=>'Set result','InboxT'=>$emessageclubArrTxt,'OutboxT'=>$emessageclubsentArrTxt,'TrainerData'=>$clubTrainerDataArr);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		     

		     }

			}

		}

		/* Communication center for club end */

		/* Post message for club start */

		public function postmessageclub()

		{

			

			$this->layout = "";

			$this->autoRender=false;

			$uid = trim($_REQUEST['club_id']);

			$sentfor=trim($_REQUEST['sentfor']);

			$mestype=trim($_REQUEST['mestype']);

			if($mestype=='T')

			{

			$subject=trim($_REQUEST['message']);

			} else {

				$subject=trim($_REQUEST['subject']);

			}

			$message2=trim($_REQUEST['message']);

			$sendto=trim($_REQUEST['sendto']);

			

			$setSpecalistArr=$this->Club->find("first",array("conditions"=>array("Club.id"=>$uid)));

			if($sentfor=='Trainer')

			{

				//$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$uid)));

				 $traineeDataArr=$this->Trainer->find('first',array('conditions'=>array('Trainer.id'=>$sendto),'fields'=>array('Trainer.id','Trainer.username','Trainer.email','Trainer.phone')));	

				$to=$traineeDataArr['Trainer']['email'];

				$from=$setSpecalistArr['Club']['email'];

				$fromName=$setSpecalistArr['Club']['full_name'];

				

				

				

				

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello !</p>

				<p> Trainee - '.$fromName.' sent message </p>

				<p>'.$message2.' </p>

				

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					

					

					$dataSet['Emessage']['sender_id']=$uid;

					$dataSet['Emessage']['sender_type']='Club';

					$dataSet['Emessage']['receiver_id']=$sendto;

					$dataSet['Emessage']['receiver_type']=$sentfor;

					$dataSet['Emessage']['subject']=$subject;

					$dataSet['Emessage']['detail']=$message2;

					$dataSet['Emessage']['usefor']=$mestype;

					$dataSet['Emessage']['sent_date']=date('Y-m-d H:i:s');

					

					$msgdetail=$subject;

					

					/*echo '<pre>';

					print_r($dataSet);

					echo '</pre>';

					exit;

					*/

					$flg=0;

			if($mestype=='E')	

			{

				$flg=0;

			}	

if($mestype=='T')

			{

				  App::import('Vendor', 'Twilio', array('file' => 'twilio'.DS.'Services'.DS.'Twilio.php'));

$account_sid = Configure::read("twilio_details.account_sid");

$auth_token = Configure::read("twilio_details.auth_token");

$fromno = Configure::read("twilio_details.fromno");

$phone1=$traineeDataArr['Trainer']['phone'];

$client = new Services_Twilio($account_sid, $auth_token);







 if(trim($phone1)!='' && strlen(trim($phone1))>=10)

 {

 //exit;

	try {  $sms = $client->account->sms_messages->create(

			"$fromno", // From this number			

			"$phone1",

			$msgdetail

			);

			$flg=0;

	    }

	catch (Services_Twilio_RestException $e) {

	//echo $e->getMessage();

	$flg=1;

	}



 }





			}

					

					if($flg==0){

					if($this->Emessage->save($dataSet)) {	

						

							$this->sendEmailMessage(trim($to),$subject,$content,null,null);	

							

			

							

							$callresponse=array('status'=>'True','result'=>'Successfully sent message');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

							

						}	

						else 

						{

						  $callresponse=array('status'=>'False','result'=>'Sorry, message not sent.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						}	



					}

					else 

						{

						  $callresponse=array('status'=>'False','result'=>'Sorry, message not sent.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						}							

				

			}

			if($sentfor=='Client' && $mestype=='T')

			{

				//$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$uid)));

				 $traineeDataArr=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>$sendto),'fields'=>array('Trainee.id','Trainee.username','Trainee.email','Trainee.phone')));	

				$to=$traineeDataArr['Trainee']['email'];

				$from=$setSpecalistArr['Club']['email'];

				$fromName=$setSpecalistArr['Club']['full_name'];

				

				

				

				

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello !</p>

				<p> Trainee - '.$fromName.' sent message </p>

				<p>'.$message2.' </p>

				

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					

					

					$dataSet['Emessage']['sender_id']=$uid;

					$dataSet['Emessage']['sender_type']='Club';

					$dataSet['Emessage']['receiver_id']=$sendto;

					$dataSet['Emessage']['receiver_type']=$sentfor;

					$dataSet['Emessage']['subject']=$subject;

					$dataSet['Emessage']['detail']=$message2;

					$dataSet['Emessage']['usefor']=$mestype;

					$dataSet['Emessage']['sent_date']=date('Y-m-d H:i:s');

					

					$msgdetail=$subject;

					

					$flg=0;

					 App::import('Vendor', 'Twilio', array('file' => 'twilio'.DS.'Services'.DS.'Twilio.php'));

						$account_sid = Configure::read("twilio_details.account_sid");

						$auth_token = Configure::read("twilio_details.auth_token");

						$fromno = Configure::read("twilio_details.fromno");

						$phone1=$traineeDataArr['Trainee']['phone'];

						$client = new Services_Twilio($account_sid, $auth_token);

						

						

						

						 if(trim($phone1)!='' && strlen(trim($phone1))>=10)

						 {

						 //exit;

							try {  $sms = $client->account->sms_messages->create(

									"$fromno", // From this number			

									"$phone1",

									$msgdetail

									);

									$flg=0;

							    }

							catch (Services_Twilio_RestException $e) {

							//echo $e->getMessage();

							$flg=1;

							}

						

						 }

					if($flg==0){

					if($this->Emessage->save($dataSet)) {	

						

							$this->sendEmailMessage(trim($to),$subject,$content,null,null);	

							

			

				 	



							$callresponse=array('status'=>'True','result'=>'Successfully sent message');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

							

						}	

						else 

						{

						  $callresponse=array('status'=>'False','result'=>'Sorry, message not sent.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						}	

						 										

					}

					else 

						{

						  $callresponse=array('status'=>'False','result'=>'Sorry, message not sent.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						}	

			}

			

			

			

		}

		/* Post message for club end */

		

		public function postmessageclient()

		{

			

			$this->layout = "";

			$this->autoRender=false;

			$uid = trim($_REQUEST['client_id']);

			$sentfor=trim($_REQUEST['sentfor']);

			$subject=trim($_REQUEST['subject']);

			$message2=trim($_REQUEST['message']);

			$sendto=trim($_REQUEST['sendto']);

			$mestype=trim($_REQUEST['mestype']);

			$setSpecalistArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$uid)));

			if($sentfor=='Trainer')

			{

				//$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$uid)));

				 $traineeDataArr=$this->Trainer->find('first',array('conditions'=>array('Trainer.id'=>$sendto),'fields'=>array('Trainer.id','Trainer.username','Trainer.email','Trainer.phone')));	

				$to=$traineeDataArr['Trainer']['email'];

				$from=$setSpecalistArr['Trainee']['email'];

				$fromName=$setSpecalistArr['Trainee']['full_name'];

				

				

				

				

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello !</p>

				<p> Trainee - '.$fromName.' sent message </p>

				<p>'.$message2.' </p>

				

				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					

					

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

						

							$this->sendEmailMessage(trim($to),$subject,$content,null,null);	

							

			if($mestype=='T')

			{

				  App::import('Vendor', 'Twilio', array('file' => 'twilio'.DS.'Services'.DS.'Twilio.php'));

$account_sid = Configure::read("twilio_details.account_sid");

$auth_token = Configure::read("twilio_details.auth_token");

$fromno = Configure::read("twilio_details.fromno");

$phone1=$traineeDataArr['Trainer']['phone'];

$client = new Services_Twilio($account_sid, $auth_token);







 if(trim($phone1)!='' && strlen(trim($phone1))>=10)

 {

 //exit;

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

							

							$callresponse=array('status'=>'True','result'=>'Successfully sent message');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

							

						}	

						else 

						{

						  $callresponse=array('status'=>'False','result'=>'Sorry, message not sent.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						}	

						 										

				

			}

			

			

			

		}

	

	public function postmessagetr()

		{

			

			$this->layout = "";

			$this->autoRender=false;

			$uid = trim($_REQUEST['trainer_id']);

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

				

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

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

					

					if($this->Emessage->save($dataSet)) {	

						

							$this->sendEmailMessage(trim($to),$subject,$content,null,null);	

							

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

			 $callresponse=array('status'=>'True','result'=>'Successfully sent message');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

							

						

							

						}	

						else 

						{

						 $callresponse=array('status'=>'False','result'=>'Sorry, your message not send successfully. Please try again.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						}	

						 										

				

			}

			if($sentfor=='Club')

			{

				 $traineeDataArr=$this->Club->find('first',array('conditions'=>array('Club.id'=>$sendto),'fields'=>array('Club.id','Club.username','Club.email','Club.phone')));	

				$to=$traineeDataArr['Club']['email'];

				$from=$setSpecalistArr['Trainer']['email'];

				$fromName=$setSpecalistArr['Trainer']['full_name'];

				

					$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>

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

							

							$callresponse=array('status'=>'True','result'=>'Successfully sent message');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

							

							

						}	

						else 

						{

						 $callresponse=array('status'=>'False','result'=>'Sorry, your message not send successfully. Please try again.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						}	

						 										

				

			}

			

			

		}

		

		public function deletemessage(){		

		

		$this->layout = "";	

		$this->autoRender=false;

		

		$uid = trim($_REQUEST['trainer_id']);	

		$id=trim($_REQUEST['messageid']);

		 $emessageclubArr=$this->Emessage->find('first',array('conditions'=>array('Emessage.id'=>$id)));

		 

				 if($emessageclubArr['Emessage']['receiver_id']==$uid)

				 {

				 	$this->Emessage->id=$id;

				 	$dataAr['Emessage']['delflag_receiver']='Y';

				 	$this->Emessage->save($dataAr);

				 	

							$callresponse=array('status'=>'True','result'=>'Deleted Successfully.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		 		    //delflag_receiver

				 }

				 else {

				 	//delflag_sender

				 	$this->Emessage->id=$id;

				 	$dataAr['Emessage']['delflag_sender']='Y';

				 	$this->Emessage->save($dataAr);

				 	$callresponse=array('status'=>'True','result'=>'Deleted Successfully.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

				 }

			}

			

	public function getchatuserclub()

		{

			$this->layout = "";

			$this->autoRender=false;

			$uid = trim($_REQUEST['club_id']);

			$strreturn=array();

			$userfor=trim($_REQUEST['userfor']);

			if($userfor=='Client')

			{

				$traineeDataArr=$this->Trainee->find('all',array('conditions'=>array('Trainee.club_id'=>$uid),'fields'=>array('Trainee.id','Trainee.username')));	

				

				 if(!empty($traineeDataArr))

				 {

				 	for($i=0;$i<count($traineeDataArr);$i++)

				 	{

				 		$strreturn[] =$traineeDataArr[$i]['Trainee']['username'].'_Client';

				 	}

				 	$callresponse=array('status'=>'True','result'=>$strreturn);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

				 }

				 else {

				 	$callresponse=array('status'=>'False','result'=>'No Result Found.');

						    echo  $callresponse2=json_encode($callresponse);

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

				 	$strreturn[] =$traineeDataArr[$i]['Trainer']['username'].'_Trainer';

				 	}

				 	

				 	$callresponse=array('status'=>'True','result'=>$strreturn);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

				 }

				 else {

				 $callresponse=array('status'=>'False','result'=>'No Result Found.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;	

				 }

				

			}

		}		

			

	public function getchatusertr()

		{

			$this->layout = "";

			$this->autoRender=false;

			//$uid = $this->Session->read('USER_ID');

			$uid = trim($_REQUEST['trainer_id']);

			$userfor=trim($_REQUEST['userfor']);

			if($userfor=='Client')

			{

				$traineeDataArr=$this->Trainee->find('all',array('conditions'=>array('Trainee.trainer_id'=>$uid),'fields'=>array('Trainee.id','Trainee.username')));	

				$strreturn=array();

				 if(!empty($traineeDataArr))

				 {

				 	for($i=0;$i<count($traineeDataArr);$i++)

				 	{

				 		$strreturn[]=$traineeDataArr[$i]['Trainee']['username'].'_Client';

				 	}

				 	$callresponse=array('status'=>'True','result'=>$strreturn);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

				 }

				 else {

				 	 $callresponse=array('status'=>'False','result'=>'No Result Found.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;			 	

				 }

			}

			else {

				$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$uid)));

				

				 $clubid=$setSpecalistArr['Trainer']['club_id'];

				

				 $traineeDataArr=$this->Club->find('first',array('conditions'=>array('Club.id'=>$clubid),'fields'=>array('Club.id','Club.username')));	

				 $strreturn=array();

				 if(!empty($traineeDataArr))

				 {

				 	$strreturn[]=$traineeDataArr['Club']['username'].'_Club';

				 		

				 	$callresponse=array('status'=>'True','result'=>$strreturn);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

				 }

				 else {

				  $callresponse=array('status'=>'False','result'=>'No Result Found.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;	

				 }

				

			}

		}

		

		public function scheduling_calendartr(){		

		

		$this->layout = "";		

		$this->autoRender=false;

		

		$dbusertype = 'Trainer';					

		

		$uid = trim($_REQUEST['trainer_id']);

		//$uid = 51;

		

		$clientid='';

		$workout='';



		if(isset($_REQUEST['client_id']) && trim($_REQUEST['client_id'])!='')

		{

			$clientid=trim($_REQUEST['client_id']);

		}

		

		if(isset($_REQUEST['workout']) && trim($_REQUEST['workout'])!='')

		{

			$workout=trim($_REQUEST['workout']);

		}

		

		$startDt='';

		$endDt='';

		$sccondition=array();

		

		

		

		if($_REQUEST['dt_type']=='M')		

		{

			$mth=$_REQUEST['month'];

			

			$currentDate=date('Y-m-t',strtotime($mth));

			$sccondition['ScheduleCalendar.start >=']=$mth.'-01';
			
			$currentDate2=date('Y-m-d',strtotime("+1 days $currentDate"));

			$sccondition['ScheduleCalendar.end <=']=$currentDate2;

			

			

		}

		else {

			$currentDate=$_REQUEST['date'];

			$sccondition['ScheduleCalendar.start >=']=$currentDate;

			$nextdate=date('Y-m-d',strtotime("+1 days $currentDate"));

			$sccondition['ScheduleCalendar.end <']=$nextdate;

			

		}

			

		

		

		/*$this->set("workoutname",$this->WorkOuts->find('all',array('conditions'=>array('WorkOuts.trainer_id'=>$uid),'fields'=>array('WorkOuts.id','WorkOuts.workout_name','WorkOuts.workout_time'))));*/

		

		//ScheduleCalendar

		

			if($clientid!=''){

					   

				    if($workout!=''){

				    	//$sccondition['ScheduleCalendar.trainer_id']=$uid;			

				    	$sccondition['ScheduleCalendar.trainer_id']=$uid;

						$sccondition['ScheduleCalendar.trainee_id']=$clientid;		    

					}

					else 

					{

						$sccondition['ScheduleCalendar.trainer_id']=$uid;

						$sccondition['ScheduleCalendar.trainee_id']=$clientid;						

					}

		  }

		  else 

		  {

		  	

		  	$sccondition['ScheduleCalendar.trainer_id']=$uid;

		  }

		

		$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>$sccondition,'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.appointment_type','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end')));	

			if(!empty($scheduleCalendars))

			{

	                $callresponse=array('status'=>'True','result'=>$scheduleCalendars);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

			}

			else {

				$callresponse=array('status'=>'False','result'=>'No Result Found.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

			}

		}

		

		public function fitnessim($frm=null,$tov=null)

		{

			$this->layout = "ajax";

            $this->set('from', $frm);		

            $this->set('to', $tov);		

					

		

		}

		public function getusernmval($id=null,$utype=null)

		{

			$this->layout = "";

			$this->autoRender=false;

		    if($utype!='' && $id!='')

		    {

		    	if($utype=='Client')

		    	{

		    		

		    		$setUserArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$id)));

				$username=$setUserArr['Trainee']['username'].'_Client';

				$callresponse=array('status'=>'True','result'=>$username);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		    		

		    		

		    	}else {

		    		

		    		$setUserArr=$this->$utype->find("first",array("conditions"=>array("$utype.id"=>$id)));

				$username=$setUserArr[$utype]['username'].'_'.$utype;

				$callresponse=array('status'=>'True','result'=>$username);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		    	}

		    	

		    }else {

		    	$callresponse=array('status'=>'False','result'=>'Sorry, please send id and usertype.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;	

		    }

					

		

		}

		public function evdetail()

		{
			$this->layout = "";
			$this->autoRender=false;
			$dbusertype = trim($_POST['usertype']);
			$uid = trim($_POST['id']);	
			if(trim($_POST['evid'])!='')
			{
				$sccondition=array();
				$evid=trim($_POST['evid']);
				if(isset($dbusertype) && $dbusertype=='Trainer') {
					$sccondition=array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.id'=>$evid);
				}
				if(isset($dbusertype) && $dbusertype=='Client')	{
					$sccondition=array('ScheduleCalendar.trainee_id'=>$uid,'ScheduleCalendar.status'=>1,'ScheduleCalendar.id'=>$evid);
				}
				$schcaldt=$this->ScheduleCalendar->find('first',array('conditions'=>$sccondition,'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.appointment_type','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.session_type')));
				if($schcaldt['ScheduleCalendar']['trainee_id'] !='') {

					$sccondition9=array('Trainee.id'=>$schcaldt['ScheduleCalendar']['trainee_id']);
					$trainedt=$this->Trainee->find('first',array('conditions'=>$sccondition9,'fields'=>array('Trainee.id','Trainee.first_name','Trainee.last_name','Trainee.photo','Trainee.no_ses_purchased','Trainee.booked_ses')));
				}
				$sccondition91=array('Trainer.id'=>$schcaldt['ScheduleCalendar']['trainer_id']);
				$trainerdt=$this->Trainer->find('first',array('conditions'=>$sccondition91,'fields'=>array('Trainer.id','Trainer.first_name','Trainer.last_name','Trainer.logo')));
				if(!empty($schcaldt)) {
				$startdt2=$schcaldt['ScheduleCalendar']['start'];
				$end2=$schcaldt['ScheduleCalendar']['end'];
				$startdtv=date('m/d/Y H:i A',strtotime("$startdt2"));
				$endv=date('H:i A',strtotime("$end2"));
				
				$clientFname=$trainedt['Trainee']['first_name'];
				$clientLname=$trainedt['Trainee']['last_name'];
				$clientlogo="";
				if($trainedt['Trainee']['photo']!=''){
				$clientlogo="http://www.ptpfitpro.com/uploads/".$trainedt['Trainee']['photo'];
				} else
				{
				$clientlogo="http://www.ptpfitpro.com/images/avtar.png";
				}
				$sessionNo=$trainedt['Trainee']['no_ses_purchased'];
				$chargedSession=$trainedt['Trainee']['booked_ses'];
				
				$rst=array("appointment_type"=>$schcaldt['ScheduleCalendar']['appointment_type'],"description"=>$schcaldt['ScheduleCalendar']['description'],"start"=>$startdtv,"end"=>$endv,"id"=>$schcaldt['ScheduleCalendar']['id'],"title"=>$schcaldt['ScheduleCalendar']['title'],"trainee_id"=>$schcaldt['ScheduleCalendar']['trainee_id'],"trainer_id"=>$schcaldt['ScheduleCalendar']['trainer_id'],"session_type"=>$schcaldt['ScheduleCalendar']['session_type'],"client_fname"=>$clientFname,"client_lname"=>$clientLname,"client_logo"=>$clientlogo,"session_no"=>$sessionNo,"session_charged"=>$chargedSession);
				
					/*$callresponse=array('status'=>'True','result'=>$schcaldt,'trainer'=>$trainerdt,'client'=>$trainedt);*/
					$callresponse=array('status'=>'True','result'=>$rst);
										
				    echo  $callresponse2=json_encode($callresponse);
					exit;
				}
				else {
					$callresponse=array('status'=>'False','result'=>'Sorry, please select correct session.');
				    echo  $callresponse2=json_encode($callresponse);
				    exit;	
				}
			}

				else {

		    	$callresponse=array('status'=>'False','result'=>'Sorry, please select correct session.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;	

		    }

		}

		public function markcompleted()
		{
			$this->layout = "";
			$this->autoRender=false;
			if(trim($_POST['completed'])!='' )
			{
				$datav=array();				
				//$datav['id']=trim($_POST['completed']);
				$this->ScheduleCalendar->id = trim($_POST['completed']);	
				$datav['ScheduleCalendar']['appointment_type']='Completed';
				$setScheduleCalendarAr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.id"=>trim($_POST['completed']))));
				$trnId = $setScheduleCalendarAr['ScheduleCalendar']['trainee_id'];
				$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$trnId)));
				$bokedSession = $setClientArr['Trainee']['booked_ses'];
				if($this->ScheduleCalendar->save($datav)) {
					$bokedSessionn = $bokedSession + 1; 
					$callresponse=array('status'=>'True','result'=>'Your availability has been Marked Completed successfully.');
				    echo  $callresponse2=json_encode($callresponse);
					$this->Trainee->query("update trainees set booked_ses = '".$bokedSessionn."' where id='".$trnId."'");
				    exit;	
				}
				else {
					$callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!');
				    echo  $callresponse2=json_encode($callresponse);
				    exit;						
				}
			}
			else {
				$callresponse=array('status'=>'False','result'=>'Sorry, please refresh the page and try again!!');
			    echo  $callresponse2=json_encode($callresponse);
			    exit;	
			}
		}

		

		public function markcomp()

		{

			$this->layout = "";

			$this->autoRender=false;

			if(trim($_POST['comp'])!='' )

			{

				$datav=array();				

				$this->ScheduleCalendar->id = trim($_POST['comp']);	

				$datav['ScheduleCalendar']['appointment_type']='Comp';

				if($this->ScheduleCalendar->save($datav)) {

														

							$callresponse=array('status'=>'True','result'=>'Your availability has been Marked Comp successfully.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;	

						}

						else {

							

							

							$callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;	

						}

			}

			else 

			{

				

				$callresponse=array('status'=>'False','result'=>'Sorry, please refresh the page and try again!!');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;	

			}

			

			

		}

		

		public function markcancel()
		{
			$this->layout = "";
			$this->autoRender=false;
			if(trim($_POST['cancel'])!='' )	{
				$datav=array();				
				$this->ScheduleCalendar->id = trim($_POST['cancel']);	
				$datav['ScheduleCalendar']['appointment_type']='Cancel';
				if($this->ScheduleCalendar->save($datav)) {
					$callresponse=array('status'=>'True','result'=>'Your availability has been Marked Cancel successfully.');
				    echo  $callresponse2=json_encode($callresponse);
				    exit;	
				}
				else {
					$callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!');
				    echo  $callresponse2=json_encode($callresponse);
				    exit;	
				}
			}
			else {
				$callresponse=array('status'=>'False','result'=>'Sorry, please refresh the page and try again!!');
			    echo  $callresponse2=json_encode($callresponse);
			    exit;	
			}
		}
		public function markcancel_charged()
		{
			$this->layout = "";
			$this->autoRender=false;
			if(trim($_POST['cancel'])!='' )	{
				$datav=array();				
				$this->ScheduleCalendar->id = trim($_POST['cancel']);	
				$datav['ScheduleCalendar']['appointment_type']='Cancel';
				$setScheduleCalendarAr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.id"=>trim($_POST['cancel']))));
				$trnId = $setScheduleCalendarAr['ScheduleCalendar']['trainee_id'];
				$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$trnId)));
		        $bokedSession = $setClientArr['Trainee']['booked_ses'];
				if($this->ScheduleCalendar->save($datav)) {
					$bokedSessionn = $bokedSession + 1; 
					$this->Trainee->query("update trainees set booked_ses = '".$bokedSessionn."' where id='".$trnId."'");
					$callresponse=array('status'=>'True','result'=>'Your availability has been Marked Cancel successfully.');
				    echo  $callresponse2=json_encode($callresponse);
				    exit;	
				}
				else {
					$callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!');
				    echo  $callresponse2=json_encode($callresponse);
				    exit;	
				}
			}
			else {
				$callresponse=array('status'=>'False','result'=>'Sorry, please refresh the page and try again!!');
			    echo  $callresponse2=json_encode($callresponse);
			    exit;	
			}
		}

		public function deleteslot()

		{	

			$this->layout = "";

			$this->autoRender=false;

			if(trim($_POST['evid'])!='')

			{

				$datav=array();				

				$datav['id']=trim($_POST['evid']);

				if($this->ScheduleCalendar->delete($datav)) {

							

							

							$callresponse=array('status'=>'True','result'=>'Your availability has been deleted successfully.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;	

						}

						else {

							

							

							$callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						}

			}

			else 

			{

				

				$callresponse=array('status'=>'False','result'=>'Sorry, please refresh the page and try again!!');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

			}

		}

		public function createavailability()

		{	

			$this->layout = "";

			$this->autoRender=false;

			

			

			if(trim($_POST['client_id'])!='' && trim($_POST['workout_time'])!='' && trim($_POST['datentime'])!='' && trim($_POST['trainer_id'])!='')

			{

			     $clientid=trim($_POST['client_id']);
				$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));

		         $aptitle=$setClientArr['Trainee']['full_name'];
                   
		         $SessionTypeVal = $_POST['SessionTypeVal'];
		         

		         $purchSession = $setClientArr['Trainee']['no_ses_purchased'];

		         $bokedSession = $setClientArr['Trainee']['booked_ses'];

			     

		         $leftSession = $purchSession - $bokedSession;

		        $dvstart=date('Y-m-d H:i:s', strtotime($_POST['datentime']));

				$endv=date('Y-m-d H:i:s', strtotime($_POST['datentime']));

				$workw=trim($_POST['workout_time']);

				$enddate=date('Y-m-d H:i:s', strtotime("+$workw minutes",strtotime($endv)));
				

				$dvend=trim($enddate);
				$uid=trim($_POST['trainer_id']);
		         
		         $CheckDataExist=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.start"=>$dvstart,"ScheduleCalendar.end"=>$dvend,"ScheduleCalendar.trainer_id"=>$uid,"ScheduleCalendar.trainee_id"=>$clientid,"ScheduleCalendar.status"=>1)));

		         
		         if(!empty($CheckDataExist))
		         {
		         	
				
				$callresponse=array('status'=>'False','result'=>'Sorry this time slot already booked.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		         }
		         

		         if($leftSession > 0)

		         {
		         	$datav=array();

				$datav['ScheduleCalendar']['title']='Booked';

				$datav['ScheduleCalendar']['appointment_type']='Booked';

				$datav['ScheduleCalendar']['description']='Booked';

				$datav['ScheduleCalendar']['trainer_id']=trim($_POST['trainer_id']);

				$datav['ScheduleCalendar']['trainee_id']=trim($_POST['client_id']);

				

				/*$datav['ScheduleCalendar']['start']=trim($_POST['startd']);

				$datav['ScheduleCalendar']['end']=trim($_POST['endd']);*/

				
  $dvstart=date('Y-m-d H:i:s', strtotime($_POST['datentime']));
				$datav['ScheduleCalendar']['start']=trim($dvstart);

				$endv=trim($_POST['datentime']);

				$workw=trim($_POST['workout_time']);

				$enddate=date('Y-m-d H:i:s', strtotime("+$workw minutes",strtotime($endv)));

				

				$datav['ScheduleCalendar']['end']=trim($enddate);

				

				$datav['ScheduleCalendar']["added_date"] 		    = date("Y-m-d");

				$datav['ScheduleCalendar']["modification_date"] 		    = date("Y-m-d");

				$datav['ScheduleCalendar']['status']='1';
		  	     $datav['ScheduleCalendar']['session_type']= $SessionTypeVal;


					    	

						if($this->ScheduleCalendar->save($datav)) {
								$callresponse=array('status'=>'True','result'=>'Your availability has been marked successfully.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						}

						else {

							$callresponse=array('status'=>'False','result'=>'Some issue occur, please try again!!');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						}

						
		         } else {
		          $callresponse=array('status'=>'False','result'=>'Sorry this client all the session has been booked.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;	
		         }

				

			}

			else 

			{				

				$callresponse=array('status'=>'False','result'=>'Please fill valid data!!');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

			}

			

		}

		public function scheduling_calendarclient(){		

		

		$this->layout = "";		

		$this->autoRender = false;		

		

		$dbusertype = 'Trainee';					

		

		$uid =trim($_POST['client_id']);				

		

		//ScheduleCalendar

		$sccondition=array();

		

		

		

		if($_REQUEST['dt_type']=='M')		

		{

			$mth=$_REQUEST['month'];

			

			$currentDate=date('Y-m-t',strtotime($mth));

			$sccondition['ScheduleCalendar.start >=']=$mth.'-01';

			$sccondition['ScheduleCalendar.end <=']=$currentDate;

			

			

		}

		else {

			$currentDate=$_REQUEST['date'];

			$sccondition['ScheduleCalendar.start >=']=$currentDate;

			$nextdate=date('Y-m-d',strtotime("+1 days $currentDate"));

			$sccondition['ScheduleCalendar.end <']=$nextdate;

			

		}

		

		

			$sccondition['ScheduleCalendar.trainee_id']=$uid;

			$sccondition['ScheduleCalendar.status']=1;

			

		

		

		

		$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>$sccondition,'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.title','ScheduleCalendar.appointment_type','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end')));	

		if(!empty($scheduleCalendars))

		{

			$callresponse=array('status'=>'True','result'=>$scheduleCalendars);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		}

		else {

			$callresponse=array('status'=>'False','result'=>'Sorry, no session assigned.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

			

		}

		

		}

		

		public function displayhide(){		

		

		$this->layout = "";		

		$this->autoRender = false;		

		$loginData = $this->Admin->find('first', array());

		

		

		$thrtydaysshow=1;

		$corporationshow=1;

		

		if($loginData['Admin']['thirtydaytrial']=='')

		{

			$thrtydaysshow=0;

		}

		if($loginData['Admin']['on_off']=='')

		{

			$corporationshow=0;

		}

		  $callresponse=array('status'=>'True','corporate'=>$corporationshow,'thirty'=>$thrtydaysshow);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		

		

		}

		public function displayEvent($uid=null){	

				

		

		$this->layout = "";		

		$this->autoRender = false;	

		

		$events=$this->Event->find('all',array('conditions'=>array('Event.trainer_id'=>$uid)));

		

		

		

		if(!empty($events)){

		  $callresponse=array('status'=>'True','events'=>$events,);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		}else{

			$callresponse=array('status'=>'False','result'=>'Sorry, no event exists.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

			

			

		}

		

		}

		public function addevent(){		

			

		$this->layout = "";		

		$this->autoRender = false;	

		$dataevArr=array();	

		$dataevArr['Event']['trainer_id']= trim($_POST['trainer_id']);

		$uid=trim($_POST['trainer_id']);

		$dataevArr['Event']['events']= $_POST['events'];

		$dataevArr['Event']['added_date']= trim($_POST['added_date']);

		$dbusertype='Trainer';

				

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		  if(!empty($dataevArr)) {

		  	

				$this->Event->set($this->request->data);

			

				if($this->Event->validates()) {

					

						if($this->Event->save($dataevArr)) {	

									

							$callresponse=array('status'=>'True','result'=>'Event added succesfully');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						} else {

							$callresponse=array('status'=>'False','result'=>'Sorry..Some Error Occurs!!');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						}

				}	

			

			}

		}

		public function deleteevent()

		{

			$this->layout = "";		

			$this->autoRender = false;		

			if(isset($_REQUEST['id']) && $_REQUEST['id']!='')

			{    

				 $id=trim($_REQUEST['id']);

			

				 if($this->Event->delete($id))

				 {

				 	           $callresponse=array('status'=>'True','result'=>'Successfully deleted.');

						       echo $callresponse2=json_encode($callresponse);

						      exit;

				 }

			}

			else {

				 $callresponse=array('status'=>'False','result'=>'Please select workout.');

						       echo $callresponse2=json_encode($callresponse);

						       exit;

			}

		}

		

		public function certificationdata(){

			$cert_org=$this->CertificationOrganization->find('all',array('fields'=>array('CertificationOrganization.id','CertificationOrganization.name')));

			

			$cntv1=count($cert_org);

			

			$cert_org[$cntv1]['CertificationOrganization']['id']='';

			$cert_org[$cntv1]['CertificationOrganization']['name']='Other';

			

			

			

			

			$certifications=$this->Certification->find('all',array('fields'=>array('Certification.id','Certification.course')));

			

			$cntv2=count($certifications);

			

			$certifications[$cntv2]['Certification']['id']='';

			$certifications[$cntv2]['Certification']['course']='Other';

			

			

			$degrees=$this->Degree->find('all',array('fields'=>array('Degree.id','Degree.name')));

			

			$cntv3=count($degrees);

			

			$degrees[$cntv3]['Degree']['id']='';

			$degrees[$cntv3]['Degree']['name']='Other';

			

			if(!empty($cert_org) && !empty($certifications) && !empty($degrees)){

				$callresponse=array('status'=>'True','result1'=>$cert_org,'result2'=>$certifications,'result3'=>$degrees);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

			}else{

				$callresponse=array('status'=>'False','result'=>'Sorry Some error occured.');

						       echo $callresponse2=json_encode($callresponse);

						       exit;

			}

			

		}

			public function addcertification_trainer()

		{

			$this->layout = "";	

			$this->autoRender = false;	

		   $data['CertificationTrainers']['trainer_id']=$_REQUEST['trainer_id'];

		   $data['CertificationTrainers']['certification_org']=$_REQUEST['certification_org'];

		   $data['CertificationTrainers']['certification_org1']=$_REQUEST['certification_org1'];

		   $data['CertificationTrainers']['certification_name']=$_REQUEST['certification_name'];

		   $data['CertificationTrainers']['certification_name1']=$_REQUEST['certification_name1'];

			$data['CertificationTrainers']['certification_degree']=$_REQUEST['certification_degree'];

			$data['CertificationTrainers']['certification_degree1']=$_REQUEST['certification_degree1'];

			if(!empty($this->data)) {

			

				$this->CertificationTrainers->set($this->data);

				//$this->Trainer->id = $this->data['Trainer']['id'];	

				if($this->CertificationTrainers->validates()) {

						

					    

					    $data["CertificationTrainers"]["added_date"] 		    = date("Y-m-d");

						$data["CertificationTrainers"]["modified_date"] 		= date("Y-m-d");

					    	//pr($this->request->data);

					    //$this->loadModel('ClubBranch');

					   

						if($this->CertificationTrainers->save($data)) {	

							$callresponse=array('status'=>'True','result'=>'Certification added succesfully');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						} else {

							$callresponse=array('status'=>'False','result'=>'Sorry..Some Error Occurs!!');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

						}

				}	

			}

			

		}

		public function displayCertifications($uid=false){

			$this->layout = "";		

		$this->autoRender = false;	

			

			$tranrsdata=$this->CertificationTrainers->find('all',array('conditions'=>array('CertificationTrainers.trainer_id'=>$uid)));

			

			

		if(!empty($tranrsdata)){

		  $callresponse=array('status'=>'True','tranrsdata'=>$tranrsdata,);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

		}else{

			$callresponse=array('status'=>'False','result'=>'Sorry, no certifications exists.');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

			

			

		}

		}

		public function deletecertifytrainer()

		{

			$this->layout = '';

			$this->render = false;

			if(trim($_REQUEST['id'])!='')

			{

				$datav=array();				

				$ide=trim($_REQUEST['id']);

				if($this->CertificationTrainers->delete($ide)) {

							

							  $callresponse=array('status'=>'True','result'=>'Successfully deleted.');

						       echo $callresponse2=json_encode($callresponse);

						      exit;

						}

						else {

							

						 $callresponse=array('status'=>'False','result'=>'Some error occured.');

						       echo $callresponse2=json_encode($callresponse);

						       exit;

						}

			}

			else 

			{

				

					

						 $callresponse=array('status'=>'False','result'=>'Some error occured.');

						       echo $callresponse2=json_encode($callresponse);

						       exit;

			}

			

			

				echo json_encode($response);

				exit;	

			

		}

		public function getBio($id=false){

			$this->layout = '';

			$this->autoRender=false;

			if($id!=''){

			$this->Trainer->id = $id;

			$bio = $this->Trainer->field('Bio');

			$callresponse=array('status'=>'True','bio'=>$bio,);

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

			}else{

				 $callresponse=array('status'=>'False','result'=>'Some error occured.');

						       echo $callresponse2=json_encode($callresponse);

						       exit;

			}

			

			

		}

		public function editBio(){

			$this->layout = '';

			$this->autoRender=false;

			$id=trim($_POST['trainer_id']);

			if($id!=''){

			$this->Trainer->id = $id;

			$bio['Trainer']['Bio']=trim($_POST['Bio']);

			if($this->Trainer->save($bio)){

			$callresponse=array('status'=>'True','result'=>'Bio Saved');

						    echo  $callresponse2=json_encode($callresponse);

						    exit;

			}else{

				 $callresponse=array('status'=>'False','result'=>'Some error occured.');

						       echo $callresponse2=json_encode($callresponse);

						       exit;

			}

			

			}

		}

		

		public function uploadWebsiteLogo(){

			  $this->layout = "ajax";

			$dbusertype=trim($_REQUEST['usertype']);

			//$dbusertype='Trainer';

			$uid=trim($_REQUEST['id']);

			//$uid=1;

			

			

			$this->$dbusertype->set($this->data);

			$this->$dbusertype->id = $id;	

			

			  if(!empty($_FILES["photo"]["name"]))

				{

					$filename = $_FILES["photo"]["name"];

					$target = $this->config["upload_path"];

					$this->Upload->upload($_FILES["photo"], $target, null, null);

					

					$upfield='website_logo';

					

					$profilepic=$this->Upload->result;

  					$this->request->data["$dbusertype"][$upfield] = $profilepic; 

  					//$picPath = $this->config["upload_path"].$this->request->data["$dbusertype"]["old_covimage"];

					//@unlink($picPath);

					

					$this->request->data["$dbusertype"]["id"] 		    = $uid;

					if($this->$dbusertype->save($this->data)) {

					$profilepic='uploads/'.$profilepic;

						$callresponse=array('status'=>'True','result'=>'Website logo Uploaded Successfully.','profilepic'=>$profilepic);

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							

					} else {

					$callresponse=array('status'=>'False','result'=>'Sorry,not uploaded!!!');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

					}

				}

			

		}

		

		function removeWebsiteLogoTrainer() {

				

			  $this->layout = "ajax";

			$uid=trim($_REQUEST['id']);

			

		

			if($uid) {

				

				$userPic = $this->Trainer->find("first",array("fields"=>array("website_logo"),"conditions"=>array("Trainer.id"=>$uid)));

				$picPath = $this->config["upload_path"].$userPic["Trainer"]["website_logo"];

				unlink($picPath);

				

				$dataa["website_logo"] = null;

				if( $this->Trainer->updateAll($dataa,array("Trainer.id"=>$uid)) ) {

					$callresponse=array('status'=>'True','result'=>'Website logo Uploaded deleted.');

					$callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

					

				}else{

					

					$callresponse=array('status'=>'False','result'=>'Sorry,not deleted!!!');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

					//$callresponse = array("responseclassName"=>"nFailure","errorMsg"=>"unable to process the request");

				}

				

			}

		

		}

		function subscriptions(){

			

			 $this->layout = "ajax";

			//$this->autoRender = false;	

			$uid=trim($_REQUEST['trainer_id']);

			$subscription=$this->Subscription->find("all",array("conditions"=>array('OR' => array(

			array('Subscription.plan_for' => 'All'),

			array('Subscription.plan_for' => 'Trainer')),'Subscription.status'=>1)));

			

			

			$subscription2=array();

			$counter=0;

				foreach ($subscription as $key=>$val)

				{

					$subscription2[$counter]=$val['Subscription'];

					$counter++;

				}

			      

		   $plndetails = $this->Trainer->find('first',array('conditions'=>array('Trainer.id'=>$uid),'fields'=>array('Trainer.subscriptionplan')));	

		   $planmy='';

		   if(!empty($plndetails))

		   {

		   	

		   	  $planmy=$plndetails['Trainer']['subscriptionplan'];

		   }	

				 

			$callresponse=array('status'=>'True','subscriptions'=>$subscription2,'myplan'=>$planmy);

			

			$callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

	}

		

		function savecard(){

				 $this->layout = "ajax";

				

				$uid=trim($_REQUEST['id']);

			   // $this->data=array();

			    $usertype='Trainer';

				$this->request->data['Trainer']["cardname"]=trim($_REQUEST['cardname']);

				$this->request->data['Trainer']["cardnumber"]=trim($_REQUEST['cardnumber']);

				$this->request->data['Trainer']["exmonth"]=trim($_REQUEST['exmonth']);

				$this->request->data['Trainer']["exyear"]=trim($_REQUEST['exyear']);

				$this->request->data['Trainer']["cvv"]=trim($_REQUEST['cvv']);

				$this->request->data['Trainer']["cardtype"]=trim($_REQUEST['cardtype']);

				$this->Trainer->id = $uid;

				

				if($this->Trainer->save($this->request->data)) {						

						$callresponse=array('status'=>'True','userid'=>$uid,'result'=>'Your Credit Card Details Saved Successfully');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

							

						} else {

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

						}

				

				

			}

			

			function displayccdetails(){

				 $this->layout = "ajax";

				

				$uid=trim($_REQUEST['id']);

			    $this->data=array();

			    

			    //$this->Trainer->id = $id;

				$ccdetails = $this->Trainer->find('first',array('conditions'=>array('Trainer.id'=>$uid),'fields'=>array('Trainer.cardname','Trainer.cardtype','Trainer.cardnumber','Trainer.exmonth','Trainer.exyear','Trainer.cvv')));

				if(!empty($ccdetails)){

					$callresponse=array('status'=>'True','ccdetails'=>$ccdetails);

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

				}else{

					$callresponse=array('status'=>'False','result'=>'No Record Found.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

				}

				

				

				

				

			}

			

			function gettestimonial(){

				 $this->layout = "ajax";

				

				$uid=trim($_REQUEST['id']);

			    $this->data=array();

			    

			    //$this->Trainer->id = $id;

				$ccdetails = $this->Trainer->find('first',array('conditions'=>array('Trainer.id'=>$uid),'fields'=>array('Trainer.testimonials','Trainer.Bio','Trainer.publicproname')));

				

				$publicurl='';

				

				

				if(!empty($ccdetails)){

					if($ccdetails['Trainer']['publicproname']!='')

					{

						$publicurl=$this->config['url'].'home/myprofile/'.$ccdetails['Trainer']['publicproname'];

					}

					

					$callresponse=array('status'=>'True','ccdetails'=>$ccdetails,'publicurl'=>$publicurl);

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

				}else{

					$callresponse=array('status'=>'False','result'=>'No Record Found.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

				}

				

				

				

				

			}

			function savetestimonial(){

				 $this->layout = "ajax";

				

				$uid=trim($_REQUEST['id']);

				$usertype=trim($_REQUEST['usertype']);

			   // $this->data=array();

			    

				//$this->request->data["$usertype"]["Bio"]=trim($_REQUEST['Bio']);

				$this->request->data["$usertype"]["testimonials"]=trim($_REQUEST['testimonials']);

				

				$this->$usertype->id = $uid;

				

				if($this->Trainer->save($this->request->data)) {						

						$callresponse=array('status'=>'True','userid'=>$uid,'result'=>'Your Webpage Details Saved Successfully');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

							

						} else {

							$callresponse=array('status'=>'False','result'=>'Some error has been occured. Please try again.');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

						}

				

				

			}

			

			public function gallery($id=null)

			{

				$this->layout = "";	

				$this->autoRender=false;	

		     if($id!='')

		     {

				 $uid = $id;	

				

				$galleries=$this->Gallery->find('all',array('conditions' => array ('Gallery.trainer_id'=>$uid)));

				$vgallery=array();

				if(!empty($galleries))

				{

					//print_r($galleries);

					$i=0;

					foreach($galleries as $gal)

					{

						$vgallery[$i]['id']=$gal['Gallery']['id'];

						$vgallery[$i]['Title']=$gal['Gallery']['gallery_titile'];

						$vgallery[$i]['img']=$this->config['url'].'galleryuploads/'.$gal['Gallery']['gallery_image'];

						$i++;

					}

					

					$callresponse=array('status'=>'True','result'=>$vgallery);

						

						

				} else {

					$callresponse=array('status'=>'False','result'=>'No Pics Available.');

				}             

		     }else {

		     	$callresponse=array('status'=>'False','result'=>'Please select Trainer');

		     }

		     

		     echo $callresponse2=json_encode($callresponse);

		     exit;

			}

			

		public function addgallery(){	

			

		$this->layout = "";		

		$this->autoRender = false;		

		

		$uid = trim($_REQUEST['trainer_id']);		

			

			  if(!empty($_FILES["photo"]["name"]))

				{

					$filename = $_FILES["photo"]["name"];

					$target = $this->config["upload_gallery"];

					$this->Upload->upload($_FILES["photo"], $target, null, null);

					

					$upfield='gallery_image';

					

					$profilepic=$this->Upload->result;

  					$this->request->data['Gallery'][$upfield] = $profilepic; 

  					//$picPath = $this->config["upload_path"].$this->request->data["$dbusertype"]["old_covimage"];

					//@unlink($picPath);

					

					$this->request->data["Gallery"]["trainer_id"] 		    = $uid;

					 $this->request->data["Gallery"]["gallery_titile"]  = trim($_REQUEST['title']);

					 $this->request->data["Gallery"]["status"]  = 1;

					if($this->Gallery->save($this->data)) {

					$profilepic=$this->config['url'].'galleryuploads/'.$profilepic;

						$callresponse=array('status'=>'True','result'=>'Gallery Pic Uploaded Successfully.','Pic'=>$profilepic);

				       $callresponse2=json_encode($callresponse);

				        $this->set('flagv', $callresponse2);

							

					} else {

					$callresponse=array('status'=>'False','result'=>'Sorry,not uploaded!!!');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

					}

				} else {

					$callresponse=array('status'=>'False','result'=>'Please upload pic!');

								$callresponse2=json_encode($callresponse);

								$this->set('flagv', $callresponse2);

				}

		    echo $callresponse2=json_encode($callresponse);

		     exit;

		 

				

		}

		

		public function forms(){								

		$this->layout = "";		

		$this->autoRender=false;						

		$dbusertype='Trainer';

		$uid = trim($_REQUEST['trainer_id']);	

		$trainee=$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$uid),'fields'=>array('Trainee.id','Trainee.full_name')));

		  $forms=$this->Form->find('all',array('conditions' => array (

        'OR' => array(array('Form.type' =>'All'),array('Form.type' => 'Trainer')))));

        

        $this->set('forms',$forms);

		

        $callresponse=array('status'=>'True','Client List'=>$trainee,'Form List'=>$forms);

		echo $callresponse2=json_encode($callresponse);

		exit;

				       

		

		}

		public function formsend() {								
			$this->layout = "";		
			$this->autoRender=false;						
			$dbusertype='Trainer';
			$uid = trim($_POST['trainer_id']);	
			$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
			$clients=$_POST['clients'];
			$formid=$_POST['formid'];
			$messageval=trim($_POST['message']);
			
			
				//$callresponse=array('status'=>'False','result'=>'Please select client');
				
			
			
			
			if(isset($formid) && isset($clients) )
				{
					
					$attach=array();		
					$upath= $this->config["upload_form"];	
					
					
					
					$clientsemail=		$this->Trainee->find('all',array('conditions'=>array('Trainee.id'=>$clients),'fields'=>array('Trainee.email')));

				
					
					if(is_array($formid)) {
						/*foreach (trim($_REQUEST['formid']) as $calue) {
							$forms=$this->Form->find('all',array('conditions' =>array('Form.id'=>$calue)));
							foreach($forms as $vids){
								$filename=$vids['Form']['document'];
								//$attach[]=$filename;
								$attach[]=$upath.$filename;
								}
						}*/
						$forms=$this->Form->find('all',array('conditions' =>array('Form.id'=>$formid)));
							foreach($forms as $vids){
								$filename=$vids['Form']['document'];
								//$attach[]=$filename;
								$attach[]=$upath.$filename;
								}
					} 
					else{ 
						$attach[]=$upath.$filename;
						}
					
					foreach($clientsemail as $details) {
						if($details['Trainee']['email']!='') {
							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
							if($dbusertype=='Trainer' && $setSpecalistArr['Trainer']['website_logo']){
								$content.='<img src="'.$this->config['url'].'uploads/'.$setSpecalistArr['Trainer']['website_logo'].'"/>';
							}else{
							$content.='<img src="'.$this->config['url'].'images/logo.png"/>';
							}
							$content.='</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello!</p>
							<p>'.trim($_REQUEST['message']).'</p>';
							//$content .=$videosmaillink;	
							$content .='</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
							$subject = $this->config["base_title"]." : Forms with attachments"; 
							//$details['Trainee']['email']='synapse0451@gmail.com';
							//$attachments='';
							
							
							
							$this->sendEmailMessageAttachment(trim($details['Trainee']['email']),$subject,$content,null,null,$attach);	

						}
					}
					$callresponse=array('status'=>'True','result'=>'Emails has been sent successfully.');
				} else {
				$callresponse=array('status'=>'False','result'=>'Please select client');
				}	
			echo $callresponse2=json_encode($callresponse);
			exit;

		}

		

		public function sessiontypelist()

		{

			$this->layout = "";

			$this->autoRender=false;		    

			 $id=trim($_REQUEST['trainer_id']);

				if($id!='')

				{

					$workoutDataArrv=$this->WorkOuts->find("all",array("conditions"=>array("WorkOuts.trainer_id"=>$id,'WorkOuts.status'=>1)));

					if(!empty($workoutDataArrv))

					{

						   $callresponse=array('status'=>'True','result'=>$workoutDataArrv);

					       $callresponse2=json_encode($callresponse);

					       $this->set('flagv', $callresponse2);

					}else {

					           $callresponse=array('status'=>'False','result'=>'This trainer dld not any session type, please add new session type.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

				   }

				}

				else {

					           $callresponse=array('status'=>'False','result'=>'Sorry, please select trainer.');

						       $callresponse2=json_encode($callresponse);

						       $this->set('flagv', $callresponse2);

				}

			echo $callresponse2=json_encode($callresponse);

		     exit;

		}

		

		public function starttimes()

		{

			$this->layout = "";

			$this->autoRender=false;	



			$starttm=array('08:00'=>'08:00 AM',

			               '08:30'=>'08:30 AM',

			               '09:00'=>'09:00 AM',

			               '09:30'=>'09:30 AM',

			               '10:00'=>'10:00 AM',

			               '10:30'=>'10:30 AM',

			               '11:00'=>'11:00 AM',

			               '11:30'=>'11:30 AM',

			               '12:00'=>'12:00 PM',

			               '12:30'=>'12:30 PM',

			               '13:00'=>'01:00 PM',

			               '13:30'=>'01:30 PM',

			               '14:00'=>'02:00 PM',

			               '14:30'=>'02:30 PM',

			               '15:00'=>'03:00 PM',

			               '15:30'=>'03:30 PM',

			               '16:00'=>'04:00 PM',

			               '16:30'=>'04:30 PM',

			               '17:00'=>'05:00 PM'

			);

			

			$callresponse=array('status'=>'True','result'=>$starttm);

					       $callresponse2=json_encode($callresponse);

			  

		

			echo $callresponse2=json_encode($callresponse);

		     exit;

		}

		public function upgradesubs_trainer()

		{

			$this->layout='';

			$this->autoRender=false;

			

			$dbusertype = 'Trainer';					

			

			$uid = trim($_REQUEST['trainer_id']);	

			$id=trim($_REQUEST['subsplanid']);

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

						        

						        //echo $content;

			

			//send the xml via curl

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

							$aa['Payment']['nextbillingdate']              = date('Y-m-d',strtotime("+1 months"));	

							//$aa['User']['ftext']               = $text;

							/* $this->User->set('status', '0');

							 $this->User->set('smonth', date('Y-m-d'));

							 $this->User->set('emonth', date('Y-m-d',strtotime("+1 months")));*/

							

								

							

							/*print_r($aa);

							die();*/

							

							$this->Payment->save($aa);	

							$this->$dbusertype->id=$uid;

							$cc2[$dbusertype]['subscriptionplan']=$SubscriptionInfo['Subscription']['plan_name'];

							

							

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

							

							/*echo 'Your Subscription plan has been upgraded successfully, we have sent detail on your registered email address. Please check your emaill account.';*/

							

							  $callresponse=array('status'=>'True','result'=>'Your Subscription plan has been upgraded successfully, we have sent detail on your registered email address. Please check your emaill account.');

						       echo $callresponse2=json_encode($callresponse);

							   exit;

							

							}

							else {

							

							$callresponse=array('status'=>'True','result'=>'Your Subscription plan has been upgraded successfully, but unable to send detail on your registered email address.');

						       echo $callresponse2=json_encode($callresponse);

							   exit;

							}

							

															

						}

						

						else {

							$rs= 'Transaction Failed!. Try Again!  '.$code.' \r\n'.$text;

							$callresponse=array('status'=>'False','result'=>$rs);

						       echo $callresponse2=json_encode($callresponse);

							   exit;

										

						}

							

							

							

						}

			

			

			

			

			

			######## Payment Gateway End   ########

				

				

					

				} else {

					

					$callresponse=array('status'=>'False','result'=>'Sorry, first you need to set you credit card detail in Dashboard - Manage Card Detail.');

						       echo $callresponse2=json_encode($callresponse);

							   exit;

				}

		

		

	

				

				

				

			}

			else {

				

				$callresponse=array('status'=>'False','result'=>'Sorry, please select subscription plan.');

						       echo $callresponse2=json_encode($callresponse);

							   exit;

			

			}

			

		}

		public function addmeasurement()

		{

            $this->layout='';

			$this->autoRender=false;

			$TrainerId = trim($_REQUEST['trainer_id']);



           $data=array();



           $showdate=trim($_POST['date']);





            $data['Measurement']['trainee_id']=trim($_POST['traineeid']);

			$data['Measurement']['trainer_id']=trim($TrainerId);

			//$data['Measurement']['gender']=trim($_POST['mgender']);

			$data['Measurement']['show_date']=date('Y-m-d',strtotime($showdate));

			$data['Measurement']['age']=trim($_POST['age']);

			$data['Measurement']['height']=trim($_POST['height']);

			$data['Measurement']['weight']=trim($_POST['weight']);

			$data['Measurement']['neck']=trim($_POST['neck']);

			$data['Measurement']['chest']=trim($_POST['chest']);

			$data['Measurement']['waist']=trim($_POST['waist']);

			$data['Measurement']['hips']=trim($_POST['hips']);

			$data['Measurement']['thigh']=trim($_POST['thigh']);

			$data['Measurement']['calf']=trim($_POST['calf']);

			$data['Measurement']['bicep']=trim($_POST['bicep']);

			$data['Measurement']['added_date']=date('Y-m-d H:i:s');

			$data['Measurement']['modified_date']=date('Y-m-d H:i:s');

			if($this->Measurement->save($data))

			{

                 

                  $callresponse=array('status'=>'True','result'=>'Successfully saved.');

						       echo $callresponse2=json_encode($callresponse);

							   exit;

			} else

			{

              

               $callresponse=array('status'=>'False','result'=>'Sorry, some issue occur. Please fill again correct data.');

						       echo $callresponse2=json_encode($callresponse);

							   exit;

			}

			

			

		}

		

		public function getmeasurement()

		{

            $this->layout='';

			$this->autoRender=false;

			$clientid=trim($_POST['trainee_id']);

			$uid = trim($_REQUEST['trainer_id']);



			$listdata=$this->Measurement->find("all",array("conditions"=>array("Measurement.trainee_id"=>$clientid,"Measurement.trainer_id"=>$uid),'order'=>array('Measurement.show_date DESC')));



			

           if(!empty($listdata))

			{

				

				 $callresponse=array('status'=>'True','result'=>$listdata);

						       echo $callresponse2=json_encode($callresponse);

							   exit;

			

			}



			else{

                $callresponse=array('status'=>'False','result'=>'No Results Found.');

						       echo $callresponse2=json_encode($callresponse);

							   exit;

			}



		}

		public function deleteMeasurementsAndGoals()

		{

					

			/*http://www.sampatti.com/fitnessAaland/webservices/deleteMeasurementsAndGoals	*/

			$this->layout = '';

			$this->render = false;

			if(trim($_REQUEST['client_id'])!='' && trim($_REQUEST['mes_id'])!='' && trim($_REQUEST['trainer_id'])!='')

			{

								

				 $client_id=trim($_REQUEST['client_id']);

				 $trainer_id=trim($_REQUEST['trainer_id']);

			     $mes_id=trim($_REQUEST['mes_id']);

				//echo $_POST['id2'];

				//die;

			



				

				//$datavb['id']=trim($_POST['id3']);

				if($this->Measurement->query("delete from measurements where trainer_id='".$trainer_id."' AND trainee_id='".$client_id."' AND id='".$mes_id."'")) {

							

							

						}

					$response = array("status"=>"True","result"=>"Successfully deleted");

							 echo $callresponse2=json_encode($response);

							   exit;

			}

			else 

			{

				

				$response = array("status"=>"False","result"=>"Sorry, please refresh the page and try again!!");

				

				 echo $callresponse2=json_encode($response);

							   exit;

			}

			

		}

		

		public function viewclientsessions()

		{

			/*http://www.sampatti.com/fitnessAaland/webservices/viewclientsessions

              trainer_id

              for filter client need one more field "client_id"

			*/

			 $this->layout = "";	

			 $this->autoRender=false;

		    

			$trainer_id = trim($_REQUEST['trainer_id']);

			//$trainer_id = 167;

			

			$dbusertype='Trainer';

			

			

			 if(isset($_REQUEST['client_id']))

			{

              $clientid = trim($_REQUEST['client_id']);

			  $sccondition=" AND tn.id='".$clientid."'";

			}

			

			$clientworkout=$this->TraineesessionPurchase->query("select tp.id,tp.SessTypeId,tp.trainee_id,tp.purchase_session,tp.cost,tp.purchased_date,tn.id,tn.first_name,tn.last_name,w.id,w.workout_name from traineesession_purchases as tp,trainees as tn,workouts as w where tp.trainer_id='".$trainer_id."' AND tn.id=tp.trainee_id AND w.id=tp.SessTypeId $sccondition");

			

			$clientworkoutArr=array();

			

			if(!empty($clientworkout))

			{

				$i=0;

				foreach ($clientworkout as $key=>$val)

				{

					$clientworkoutArr[$i]['id']=$val['tp']['id'];

					$clientworkoutArr[$i]['client_name']=$val['tn']['first_name'].' '.$val['tn']['last_name'];

					$clientworkoutArr[$i]['session_type']=$val['w']['workout_name'];

					$clientworkoutArr[$i]['session']=$val['tp']['purchase_session'];

					$clientworkoutArr[$i]['cost']='$'.$val['tp']['cost'];

					$clientworkoutArr[$i]['date']=date('m/d/Y',strtotime($val['tp']['purchased_date']));

					

					$i++;

				}

			}

			 

			

			

			

		  

		    	

			

		    	$response = array("status"=>"True","list_data"=>$clientworkoutArr);

							 echo $callresponse2=json_encode($response);

							   exit;

			

		}

		public function addsession()

		{

			/*http://www.sampatti.com/fitnessAaland/webservices/addsession

              trainer_id

              client_id

              purchaseddate

              Sestype_id

              purchasesession

              cost

			*/

			 $this->layout = "";	

			 $this->autoRender=false;

		    

		

			/*

			$this->set("tranee",$this->Trainee->find('list',array('conditions'=>array('Trainee.trainer_id'=>$trainer_id),'fields'=>array('Trainee.id','Trainee.full_name'))));

			

			$workoutdata=$this->WorkOuts->find('list',array('conditions'=>array('WorkOuts.trainer_id'=>$trainer_id),'fields'=>array('WorkOuts.id','WorkOuts.workout_name')));

			$this->set("workoutdata",$workoutdata);

			*/

			

			

			if(trim($_REQUEST['purchaseddate'])!='' && trim($_REQUEST['trainer_id'])!='' && trim($_REQUEST['client_id'])!='' && trim($_REQUEST['Sestype_id'])!='' && trim($_REQUEST['purchasesession'])!='' && trim($_REQUEST['cost'])!='') {

					

						$stringDt = $_REQUEST['purchaseddate'];

						if(stristr($string, '/') === FALSE) {

						$stringDt=str_replace("-","/",$stringDt);

						}

							$trainer_id = trim($_REQUEST['trainer_id']);

			

			               $dbusertype='Trainer';

			

					$exercisedata['TraineesessionPurchase']['trainee_id']=trim($_REQUEST['client_id']);

					$exercisedata['TraineesessionPurchase']['SessTypeId']=trim($_REQUEST['Sestype_id']);

				    $exercisedata['TraineesessionPurchase']['trainer_id']=$trainer_id;;

					$exercisedata['TraineesessionPurchase']['purchase_session']=trim($_REQUEST['purchasesession']);

					$exercisedata['TraineesessionPurchase']['cost']=trim($_REQUEST['cost']);

					$exercisedata['TraineesessionPurchase']['purchased_date']=date('Y-m-d',strtotime(trim($stringDt)));

					

				

				//$TraineesessionPurchase;

					$this->TraineesessionPurchase->saveAll($exercisedata);					

					

					$traneeDT=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>trim($_REQUEST['client_id'])),'fields'=>array('Trainee.id','Trainee.no_ses_purchased')));



                   $totalSessTr=$traneeDT['Trainee']['no_ses_purchased']+$this->data['Trainee']['purchasesession'];



				   $this->Trainee->id=trim($_REQUEST['client_id']);

				   $this->request->data["Trainee"]["no_ses_purchased"]=$totalSessTr;

                  

                   

				   $this->Trainee->save($this->request->data['Trainee']);



					

					$response = array("status"=>"True","result"=>'Thanks, you have add the session data successfully');

							 echo $callresponse2=json_encode($response);

							   exit;

						} else {

							$response = array("status"=>"False","result"=>"Sorry, please fill all the fields!!");

				

				                echo $callresponse2=json_encode($response);

							   exit;

						}

			

			

		}
		
		
		
		
		
		public function exercise_history($trnid,$clientid=null,$rangeA=null,$rangeB=null){		

			

		//$this->checkUserLogin();

		$this->layout = "ajax";

		

		//echo $this->Session->read('UNAME');

		$this->set("leftcheck",'exercise_history');

		$dbusertype = 'Trainer';					

		$this->set("dbusertype",$dbusertype);

		$uid = $trnid;

		if($datva!='')

			{

				          

			 $datefd=$datva;

			

				 

				

				$this->set("datva",$dtsv);

				$this->set("datva2",$datva);

			}

			else {

							

				$datefd=date('Y-m-d');

				$this->set("datva2",$datefd);

				

				

			}

		$setSpecalistArr=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$uid)));

		  $this->set("setSpecalistArr",$setSpecalistArr);

		  $showoff=1;

		if($clientid!='')

		{

			$this->set("clientid",$clientid);

			//echo $clientid;

			$dt1 = date('Y-m-d h:i:s', strtotime($rangeA));

			$dt2 = date('Y-m-d h:i:s', strtotime($rangeB));

			$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$clientid)));

			//$setClientGoalArr=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientid),"order"=>array("Goal.id DESC")));
			
			
			if (!empty($dt1) && $dt1!='1970-01-01 01:00:00' && (!empty($dt2) && $dt2!='1970-01-01 01:00:00')) 
			{
				 $this->set("rangeA",date('m/d/Y', strtotime($rangeA)));
				 $this->set("rangeB",date('m/d/Y', strtotime($rangeB)));

				$setClientGoalArrco=$this->Goal->find("count",array("conditions"=>array("Goal.trainee_id"=>$clientid,'Goal.start between ? and ?' => array($dt1, $dt2)),'order' => array('Goal.start' => 'DESC')));
				 				 
				 $setClientGoalArr=$this->Goal->find("all",array("conditions"=>array("Goal.trainee_id"=>$clientid,'Goal.start between ? and ?' => array($dt1, $dt2)),'order' => array('Goal.start' => 'ASC')));			 

			}
			else 
			{
				$setClientGoalArrco=$this->Goal->find("count",array("conditions"=>array("Goal.trainee_id"=>$clientid),'order' => array('Goal.start' => 'DESC')));
				
				$setClientGoalArr=$this->Goal->find("all",array("conditions"=>array("Goal.trainee_id"=>$clientid),'order' => array('Goal.start' => 'ASC'),'limit'=> 5));			
				
			}

			/*print_r($setClientGoalArr);

			die();*/

			

			$jtms='';
			$tgvs = 0;



		 $resultdt=array();

		 $setWarmupArr=array();

		 $setCoreBalancePlyometricArr=array();
		 
		 /*echo"<pre>";
		 print_r($setClientGoalArr);
		 echo"</pre>";
		 exit;*/
		 $totalGl=count($setClientGoalArr);
		 
		 for($tg=0;$tg<$totalGl;$tg++){  
		 	
		 	   

		 $resultdt[$tgvs]['TrainerName']=ucwords($setSpecalistArr['Trainer']['full_name']);

		 $resultdt[$tgvs]['ClientName']=ucwords($setClientArr['Trainee']['first_name'].' '.$setClientArr['Trainee']['last_name']);

		 $resultdt[$tgvs]['Date']=$datefd;

		 $resultdt[$tgvs]['Goal']=$setClientGoalArr[$tg]['Goal']['goal'];
		 $resultdt[$tgvs]['GoalID']=$setClientGoalArr[$tg]['Goal']['id'];

		 $resultdt[$tgvs]['notes']=$setClientGoalArr[$tg]['Goal']['note'];

		 $resultdt[$tgvs]['phase']=$setClientGoalArr[$tg]['Goal']['phase'];

		 $resultdt[$tgvs]['alert']=$setClientGoalArr[$tg]['Goal']['alert'];

		 $resultdt[$tgvs]['start']=date("m/d/Y h:i A", strtotime($setClientGoalArr[$tg]['Goal']['start']));

		 $resultdt[$tgvs]['end']=date("m/d/Y h:i A", strtotime($setClientGoalArr[$tg]['Goal']['end']));
		 
		$startvaldt=$setClientGoalArr[$tg]['Goal']['start'];

		$endvaldt=$setClientGoalArr[$tg]['Goal']['end'];

		

					$cnt=1;

				$jtms;

         

      

			//$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,"SpeedAgilityQuickness.added_date"=>$datefd)));	
			
			$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));
			
			
			
			

			//$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,"WarmUps.added_date"=>$datefd)));
			
			$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));

			
	/*echo"<pre>";
		 print_r($setWarmupArr);
		 echo"</pre>";
		 exit;*/
			

			

			 $resultdt[$tgvs]['Warmup']=$setWarmupArr;

			 

			

			//$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,"CoreBalancePlyometric.added_date"=>$datefd)));
			
			$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));

			

			$resultdt[$tgvs]['CORE']=$setCoreBalancePlyometricArr;

			$resultdt[$tgvs]['SPEED']=$setSpeedAgilityQuicknessArr;

			

			

			/*echo"<pre>";
			echo($startvaldt);
			echo"</pre>";*/

			

			

      

			//$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,"Resistence.added_date"=>$datefd)));
			
			$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));

			

			$resultdt[$tgvs]['Resistence']=$setResistenceArr;

			

		



      //$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,"CoolDown.added_date"=>$datefd)));
      
      $setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));

      $resultdt[$tgvs]['CoolDown']=$setCoolDownArr;

	    

			$tgvs++;

		}
		/*echo "<pre>";
		print_r($resultdt);
		echo "</pre>";exit;*/
		$callresponse=array('status'=>'True','result'=>$resultdt);

						    echo $callresponse2=json_encode($callresponse);

						    // $this->set('flagv', $callresponse2);
						     
						    /* echo"<pre>";
		 print_r(json_encode($callresponse));
		 echo"</pre>";
		 exit;*/
		}

		else{

		$callresponse=array('status'=>'False','result'=>'Please select Client.');

						    echo $callresponse2=json_encode($callresponse);

						    // $this->set('flagv', $callresponse2);

		}

				exit;

		}
		
		
		
		
		
	public function workout_cate($trnid=null)
	{		
		$this->set("leftcheck",'exercise_history');
		$this->layout = "ajax";

		$dbusertype = 'Trainer';	

		$resultdt=array();
	
 
		$this->set("dbusertype",$dbusertype);

		$uid = $trnid;

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		

		$this->set("setSpecalistArr",$setSpecalistArr);

		

		 

		 $thisWorkoutCate = $this->WorkoutCategory->find('all',array('conditions'=>array('WorkoutCategory.trainerId'=>$uid),'fields'=>array('WorkoutCategory.id','WorkoutCategory.name','WorkoutCategory.status')));
		 
		 
		 /*echo"<pre>";
		 print_r($thisWorkoutCate);
		 echo"</pre>";*/
		 
		 $resultdt = $thisWorkoutCate;
		 
		 $callresponse=array('status'=>'True','result'=>$resultdt);

						     $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);

		  

	}
	
	
	
	public function add_workout_cate($trnid=null)
	{

		$this->layout = '';
		$this->autoRender = false;
		$id = $trnid;
		$na = trim($_REQUEST['catname']);
		
		$response=array();		

		$checkCalArr=$this->WorkoutCategory->find("all",array("conditions"=>array('WorkoutCategory.trainerId'=>$id,'WorkoutCategory.name'=>$na)));		

		if(count($checkCalArr)==0)
		{

			$catArr=array();
			$catArr['WorkoutCategory']['name']=trim($_REQUEST['catname']);
			$catArr['WorkoutCategory']['trainerId']=$id;

			$this->WorkoutCategory->save($catArr);
			
			$callresponse=array('status'=>'True','result'=>"Thanks, you have added Workout Category successfully.");

						     return $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);
			
		}
		else {
			
			$callresponse=array('status'=>'False','result'=>"Sorry, This Workout Category Name Already Exits.");

						     return $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);
		}		
				

	}
	
	
	
	public function edit_workout_cate($trnid=null)

	{

		$this->layout = '';

		$this->autoRender = false;

		$id = $trnid;

		$na = trim($_REQUEST['catnameed']);

		$cId = $_REQUEST['workCat'];

			

		

		$response=array();

		

		$checkCalArr=$this->WorkoutCategory->find("all",array("conditions"=>array('WorkoutCategory.trainerId'=>$id,'WorkoutCategory.name'=>$na,'WorkoutCategory.id <>'=>$cId)));

		

		

		if(count($checkCalArr)==0)

		{

			$catArr=array();

			$catArr['WorkoutCategory']['name']=trim($_REQUEST['catnameed']);

			$catArr['WorkoutCategory']['trainerId']=$id;

			$catArr['WorkoutCategory']['id']=$cId;

					

			$this->WorkoutCategory->save($catArr);
			
			
			$callresponse=array('status'=>'True','result'=>"Thanks, you have edited Workout Category successfully.");

						    return $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);  

		}

		else {			
			$callresponse=array('status'=>'False','result'=>"Sorry, This Workout Category Name Already Exits.");

						     return $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);

		}

			

		//echo json_encode($response);

		//exit;		

	}
	
	
	
	public function exercise_viewsaveworkout($trnid=null,$wrkid=null)

	{

		

		$this->layout = 'ajax';
		//$this->autoRender = false;			
		
		//$wrkid = '7';	
		
		//$trnid=162;

		$this->set("leftcheck",'exercise_history');

		$this->set("wrkid",$wrkid);

		$dbusertype = 'Trainer';					

		$this->set("dbusertype",$dbusertype);

		$uid = $trnid;
		
		$resultdt = array();

		$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
		
		 $this->set("setSpecalistArr",$setSpecalistArr);		 

				
		 
		 //$resultdt['WorkoutCategory'] = $WorkoutCate; 

		 $WorkoutCatenew = $this->WorkoutCategory->find('list',array('conditions'=>array('WorkoutCategory.trainerId'=>$uid),'fields'=>array('WorkoutCategory.id','WorkoutCategory.name')));	
		 
		 //$resultdt['WorkoutCategory'] = $WorkoutCatenew; 	 

		 if($wrkid!='') 
		 {	  	
		  	
		$this->TempWorkout->bindModel(array("belongsTo"=>array("WorkoutCategory"=>array("foreignKey"=>"category_id","fields"=>array(),"conditions"=>array()))));
		 
		 $tempwrkt = $this->TempWorkout->find('all', array(        
                'conditions'=>array('TempWorkout.trainer_id'=>$uid,'WorkoutCategory.id'=>$wrkid),
                'fields'=>array('DISTINCT TempWorkout.group_id,TempWorkout.trainer_id,TempWorkout.category_id,TempWorkout.name,WorkoutCategory.name')        
    )); 
		  	 
		 }else{		  		  
		  
		 $this->TempWorkout->bindModel(array("belongsTo"=>array("WorkoutCategory"=>array("foreignKey"=>"category_id","fields"=>array(),"conditions"=>array()))));
		 
		 $tempwrkt = $this->TempWorkout->find('all', array(        
                'conditions'=>array('TempWorkout.trainer_id'=>$uid),
                'fields'=>array('DISTINCT TempWorkout.group_id,TempWorkout.trainer_id,TempWorkout.category_id,TempWorkout.name,WorkoutCategory.name as catname')        
    ));
    
		 }
		 
		 
    
    

		 
		 /*$log = $this->TempWorkout->getDataSource()->getLog(false, false);
  					debug($log);*/
		 
		/* echo"<pre>";
		 print_r($tempwrkt);
		 echo"</pre>";*/
		 $a = 0;
		 foreach($tempwrkt as $arr)
		 {
			 $resultdt[$a]['TempWorkoutn']  = array_merge($arr['TempWorkout'],$arr['WorkoutCategory']);
			 $a++;
		 }
		 
		 
		 $callresponse=array('status'=>'True','result'=>$resultdt);

						     echo $callresponse2=json_encode($callresponse);

						     $this->set('flagv', $callresponse2);
						     
						     exit;

	}
	
	
	
	public function viewsaveworkout($trnid=null,$grpid=null)
	{
		
		$this->layout = 'ajax';
		$resultdt = array();
		
		$uid = $trnid;
		$i = 0 ;
		
		$tempwrkt=$this->TempWorkout->find('all',array('conditions'=>array('TempWorkout.trainer_id'=>$uid,'TempWorkout.group_id'=>$grpid)));
		
		foreach ($tempwrkt as $tempwrkts) {

			if($tempwrkts['TempWorkout']['exercise_type']=='Workout'){
								
				$resultdt['Warm'][$i]['exercise'] = $tempwrkts['TempWorkout']['exercise'];
				$resultdt['Warm'][$i]['set'] = $tempwrkts['TempWorkout']['set'];
				$resultdt['Warm'][$i]['duration'] = $tempwrkts['TempWorkout']['duration'];
				$resultdt['Warm'][$i]['coaching_tip'] = $tempwrkts['TempWorkout']['coaching_tip'];
			}
			
			if($tempwrkts['TempWorkout']['exercise_type']=='CORE'){
								
				$resultdt['CORE'][$i]['exercise'] = $tempwrkts['TempWorkout']['exercise'];
				$resultdt['CORE'][$i]['set'] = $tempwrkts['TempWorkout']['set'];
				$resultdt['CORE'][$i]['rep'] = $tempwrkts['TempWorkout']['rep'];
				$resultdt['CORE'][$i]['temp'] = $tempwrkts['TempWorkout']['temp'];
				$resultdt['CORE'][$i]['rest'] = $tempwrkts['TempWorkout']['rest'];
				$resultdt['CORE'][$i]['coaching_tip'] = $tempwrkts['TempWorkout']['coaching_tip'];
			}	
			
			if($tempwrkts['TempWorkout']['exercise_type']=='SPEED'){
								
				$resultdt['SPEED'][$i]['exercise'] = $tempwrkts['TempWorkout']['exercise'];
				$resultdt['SPEED'][$i]['set'] = $tempwrkts['TempWorkout']['set'];
				$resultdt['SPEED'][$i]['rep'] = $tempwrkts['TempWorkout']['rep'];
				$resultdt['SPEED'][$i]['temp'] = $tempwrkts['TempWorkout']['temp'];
				$resultdt['SPEED'][$i]['rest'] = $tempwrkts['TempWorkout']['rest'];
				$resultdt['SPEED'][$i]['coaching_tip'] = $tempwrkts['TempWorkout']['coaching_tip'];
			}
			
			if($tempwrkts['TempWorkout']['exercise_type']=='RESISTANCE'){
								
				$resultdt['RESISTANCE'][$i]['exercise'] = $tempwrkts['TempWorkout']['exercise'];
				$resultdt['RESISTANCE'][$i]['set'] = $tempwrkts['TempWorkout']['set'];
				$resultdt['RESISTANCE'][$i]['rep'] = $tempwrkts['TempWorkout']['rep'];
				$resultdt['RESISTANCE'][$i]['temp'] = $tempwrkts['TempWorkout']['temp'];
				$resultdt['RESISTANCE'][$i]['rest'] = $tempwrkts['TempWorkout']['rest'];
				$resultdt['RESISTANCE'][$i]['coaching_tip'] = $tempwrkts['TempWorkout']['coaching_tip'];
			}
			
			if($tempwrkts['TempWorkout']['exercise_type']=='COOL'){
								
				$resultdt['COOL'][$i]['exercise'] = $tempwrkts['TempWorkout']['exercise'];
				$resultdt['COOL'][$i]['set'] = $tempwrkts['TempWorkout']['set'];
				$resultdt['COOL'][$i]['duration'] = $tempwrkts['TempWorkout']['duration'];
				$resultdt['COOL'][$i]['coaching_tip'] = $tempwrkts['TempWorkout']['coaching_tip'];
			}
			
			$i++;	
			
			
			
		}
		
		$resultdt['COMMON'][]['trainer_id'] = $tempwrkt[0]['TempWorkout']['trainer_id'];
		$resultdt['COMMON'][]['workoutcategory'] = $tempwrkt[0]['TempWorkout']['category_id'];
		$resultdt['COMMON'][]['workoutname'] = $tempwrkt[0]['TempWorkout']['name'];
		$resultdt['COMMON'][]['group_id'] = $grpid;
		
		foreach($resultdt as $key=>$val)
		{
			foreach($val as $nval)
			{
				$res[$key][] = $nval;
			}
		}
		
		/*echo"<pre>";
		print_r($res);
		echo"</pre>";*/
		 echo $callresponse2=json_encode($res);
		//echo $resultdt;
		
		
		
		/*$callresponse=array('result'=>$resultdt);

						     echo $callresponse2=json_encode($res);*/
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
			
		if(!empty($_POST['Warm']))
		{
			foreach ($_POST['Warm'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);		
				
				$response1 = $val;	
				$responsen[] = $key; 	
				
				

				$exerciseA=explode("=",$exprd[0]);
				$exercise=str_replace("'","",$exerciseA[1]);
				$varr['TempWorkout']['exercise']=$exercise;				

				$setA=explode("=",$exprd[1]);
				$set=str_replace("'","",$setA[1]);				
				$varr['TempWorkout']['set']=$set;				

				$durationA=explode("=",$exprd[2]);
				$duration=str_replace("'","",$durationA[2]);				
				$varr['TempWorkout']['duration']=$duration;				

				$coaching_tipA=explode("=",$exprd[3]);
				$coaching_tip=str_replace("'","",$coaching_tipA[3]);				
				$varr['TempWorkout']['coaching_tip']=$coaching_tip;
				
				
				$varr['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);
				$varr['TempWorkout']['added_date']=date('Y-m-d');			
				$varr['TempWorkout']['group_id']=$group_id;			
				$varr['TempWorkout']['exercise_type']='Workout';			
				$varr['TempWorkout']['name']=trim($_POST['workoutname']);			
				$varr['TempWorkout']['category_id']=trim($_POST['workoutcategory']);			

				if($varr['TempWorkout']['exercise']!='') {		
				$this->TempWorkout->saveAll($varr);
				}
			}
		}	
			
			
		if(!empty($_POST['CORE']))
		{
			foreach ($_POST['CORE'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);			

				$exerciseA=explode("=",$exprd[0]);
				$exercise=str_replace("'","",$exerciseA[1]);
				$varr2['TempWorkout']['exercise']=$exercise;				

				$setA=explode("=",$exprd[1]);
				$set=str_replace("'","",$setA[1]);				
				$varr2['TempWorkout']['set']=$set;
				

				$repA=explode("=",$exprd[2]);
				$rep=str_replace("'","",$repA[1]);				
				$varr2['TempWorkout']['rep']=$rep;				

				$weightA=explode("=",$exprd[3]);
				$weight=str_replace("'","",$weightA[1]);				
				$varr2['TempWorkout']['temp']=$weight;				

				$rstA=explode("=",$exprd[4]);
				$rst=str_replace("'","",$rstA[1]);				
				$varr2['TempWorkout']['rest']=$rst;				

				$coaching_tipA=explode("=",$exprd[5]);
				$coaching_tip=str_replace("'","",$coaching_tipA[1]);				
				$varr2['TempWorkout']['coaching_tip']=$coaching_tip;
				
				
				$varr2['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);
				$varr2['TempWorkout']['added_date']=date('Y-m-d');			
				$varr2['TempWorkout']['group_id']=$group_id;			
				$varr2['TempWorkout']['exercise_type']='CORE';			
				$varr2['TempWorkout']['name']=trim($_POST['workoutname']);			
				$varr2['TempWorkout']['category_id']=trim($_POST['workoutcategory']);
				
				if($varr2['TempWorkout']['exercise']!='') {
				$this->TempWorkout->saveAll($varr2);
				}	
			}
		}	
			
		if(!empty($_POST['SPEED']))
		{
			foreach ($_POST['SPEED'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);			

				$exerciseA=explode("=",$exprd[0]);
				$exercise=str_replace("'","",$exerciseA[1]);
				$varr3['TempWorkout']['exercise']=$exercise;				

				$setA=explode("=",$exprd[1]);
				$set=str_replace("'","",$setA[1]);				
				$varr3['TempWorkout']['set']=$set;				

				$repA=explode("=",$exprd[2]);
				$rep=str_replace("'","",$repA[1]);				
				$varr3['TempWorkout']['rep']=$rep;				

				$weightA=explode("=",$exprd[3]);
				$weight=str_replace("'","",$weightA[1]);				
				$varr3['TempWorkout']['temp']=$weight;				

				$rstA=explode("=",$exprd[4]);
				$rst=str_replace("'","",$rstA[1]);				
				$varr3['TempWorkout']['rest']=$rst;				

				$coaching_tipA=explode("=",$exprd[5]);
				$coaching_tip=str_replace("'","",$coaching_tipA[1]);				
				$varr3['TempWorkout']['coaching_tip']=$coaching_tip;
				
				
				$varr3['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);
				$varr3['TempWorkout']['added_date']=date('Y-m-d');			
				$varr3['TempWorkout']['group_id']=$group_id;			
				$varr3['TempWorkout']['exercise_type']='SPEED';			
				$varr3['TempWorkout']['name']=trim($_POST['workoutname']);			
				$varr3['TempWorkout']['category_id']=trim($_POST['workoutcategory']);
				
				if($varr3['TempWorkout']['exercise']!='') {
				$this->TempWorkout->saveAll($varr3);
				}
			}
		}	
			
			if(!empty($_POST['RESISTANCE']))
			{
				foreach ($_POST['RESISTANCE'] as $key=>$val)
				{
					$exprd=explode(",",$val[0]);				
	
					$exerciseA=explode("=",$exprd[0]);
					$exercise=str_replace("'","",$exerciseA[1]);
					$varr5['TempWorkout']['exercise']=$exercise;				
	
					$setA=explode("=",$exprd[1]);
					$set=str_replace("'","",$setA[1]);				
					$varr5['TempWorkout']['set']=$set;				
	
					$repA=explode("=",$exprd[2]);
					$rep=str_replace("'","",$repA[1]);				
					$varr5['TempWorkout']['rep']=$rep;				
	
					$weightA=explode("=",$exprd[3]);
					$weight=str_replace("'","",$weightA[1]);				
					$varr5['TempWorkout']['temp']=$weight;				
	
					$rstA=explode("=",$exprd[4]);
					$rst=str_replace("'","",$rstA[1]);				
					$varr5['TempWorkout']['rest']=$rst;				
	
					$coaching_tipA=explode("=",$exprd[5]);
					$coaching_tip=str_replace("'","",$coaching_tipA[1]);				
					$varr5['TempWorkout']['coaching_tip']=$coaching_tip;
					
					
					$varr5['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);
					$varr5['TempWorkout']['added_date']=date('Y-m-d');			
					$varr5['TempWorkout']['group_id']=$group_id;			
					$varr5['TempWorkout']['exercise_type']='RESISTANCE';			
					$varr5['TempWorkout']['name']=trim($_POST['workoutname']);			
					$varr5['TempWorkout']['category_id']=trim($_POST['workoutcategory']);
					
					if($varr5['TempWorkout']['exercise']!='') {
					$this->TempWorkout->saveAll($varr5);
					}
				}
			}
			
		if(!empty($_POST['COOL']))
		{
			foreach ($_POST['COOL'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);		

				$exerciseA=explode("=",$exprd[0]);
				$exercise=str_replace("'","",$exerciseA[1]);
				$varr4['TempWorkout']['exercise']=$exercise;				

				$setA=explode("=",$exprd[1]);
				$set=str_replace("'","",$setA[1]);				
				$varr4['TempWorkout']['set']=$set;
				
				$durationA=explode("=",$exprd[2]);
				$duration=str_replace("'","",$durationA[1]);				
				$varr4['TempWorkout']['duration']=$duration;				

				$coaching_tipA=explode("=",$exprd[3]);
				$coaching_tip=str_replace("'","",$coaching_tipA[1]);				
				$varr4['TempWorkout']['coaching_tip']=$coaching_tip;
				
				$varr4['TempWorkout']['trainer_id']=trim($_POST['trainer_id']);
				$varr4['TempWorkout']['added_date']=date('Y-m-d');			
				$varr4['TempWorkout']['group_id']=$group_id;			
				$varr4['TempWorkout']['exercise_type']='COOL';			
				$varr4['TempWorkout']['name']=trim($_POST['workoutname']);			
				$varr4['TempWorkout']['category_id']=trim($_POST['workoutcategory']);
				
				if($varr4['TempWorkout']['exercise']!='') {
					$this->TempWorkout->saveAll($varr4);
				}
			}
		}		
		
		

		$callresponse=array('status'=>'True','result'=>'Thanks, you have successfully edited the saved workout.');
		//$callresponse=array('status'=>'True','result'=>$response1,'aa'=>$exprd);

						     echo $callresponse2=json_encode($callresponse);
			
		
		exit;		
	}
	
	
	
	function deletewrktview($groupid)
	{	

		$datav['TempWorkout']['group_id']=trim($groupid);
			//$this->TempWorkout->deleteAll(array('TempWorkout.group_id' => $groupid));
		if($this->TempWorkout->deleteAll(array('TempWorkout.group_id' => $groupid)))
		{			
		
			$callresponse=array('status'=>'True','result'=>'Thanks, you have successfully deleted the saved Workout Data.');
			echo $callresponse2=json_encode($callresponse);		
		}
		else 
		{
			$callresponse=array('status'=>'False','result'=>'Sorry, there is error, please try again.');
			echo $callresponse2=json_encode($callresponse);	
			//
		}

		exit;
	}
	
	
	public function savedwrktshow($trnid,$clientId,$grpid)
	{
		$this->layout="";

		$this->autoRender=false;

		$clientId=trim($clientId);
		
		$resultdt2 = array();
		
		$uid = $trnid;

		$grpid = trim($grpid);
		
		$clientData=$this->Trainee->find('first',array('conditions'=>array('Trainee.id'=>$clientId)));
		
		$goals=$this->Goal->find("first",array("conditions"=>array("Goal.trainee_id"=>$clientId),'order' => array('Goal.id' => 'DESC')));
		
		$scheduleCalendars=$this->ScheduleCalendar->find('all',array('conditions'=>array('ScheduleCalendar.trainer_id'=>$uid,'ScheduleCalendar.trainee_id'=>$clientId,'ScheduleCalendar.appointment_type'=>'Booked', 'ScheduleCalendar.mapwrkt'=>'0', 'ScheduleCalendar.status <>'=>'0'),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.appointment_type','ScheduleCalendar.title','ScheduleCalendar.description','ScheduleCalendar.trainer_id','ScheduleCalendar.trainee_id','ScheduleCalendar.start','ScheduleCalendar.end','ScheduleCalendar.added_date','ScheduleCalendar.modification_date','ScheduleCalendar.status')));
		
		if(count($scheduleCalendars)>0)

		{
		
		
		$tempwrkt=$this->TempWorkout->find('all',array('conditions'=>array('TempWorkout.trainer_id'=>$uid,'TempWorkout.group_id'=>$grpid)));
		
		foreach ($tempwrkt as $tempwrkts) {

			if($tempwrkts['TempWorkout']['exercise_type']=='Workout'){
								
				$resultdt['Warm'][$i]['exercise'] = $tempwrkts['TempWorkout']['exercise'];
				$resultdt['Warm'][$i]['set'] = $tempwrkts['TempWorkout']['set'];
				$resultdt['Warm'][$i]['duration'] = $tempwrkts['TempWorkout']['duration'];
				$resultdt['Warm'][$i]['coaching_tip'] = $tempwrkts['TempWorkout']['coaching_tip'];
			}
			
			if($tempwrkts['TempWorkout']['exercise_type']=='CORE'){
								
				$resultdt['CORE'][$i]['exercise'] = $tempwrkts['TempWorkout']['exercise'];
				$resultdt['CORE'][$i]['set'] = $tempwrkts['TempWorkout']['set'];
				$resultdt['CORE'][$i]['rep'] = $tempwrkts['TempWorkout']['rep'];
				$resultdt['CORE'][$i]['temp'] = $tempwrkts['TempWorkout']['temp'];
				$resultdt['CORE'][$i]['rest'] = $tempwrkts['TempWorkout']['rest'];
				$resultdt['CORE'][$i]['coaching_tip'] = $tempwrkts['TempWorkout']['coaching_tip'];
			}	
			
			if($tempwrkts['TempWorkout']['exercise_type']=='SPEED'){
								
				$resultdt['SPEED'][$i]['exercise'] = $tempwrkts['TempWorkout']['exercise'];
				$resultdt['SPEED'][$i]['set'] = $tempwrkts['TempWorkout']['set'];
				$resultdt['SPEED'][$i]['rep'] = $tempwrkts['TempWorkout']['rep'];
				$resultdt['SPEED'][$i]['temp'] = $tempwrkts['TempWorkout']['temp'];
				$resultdt['SPEED'][$i]['rest'] = $tempwrkts['TempWorkout']['rest'];
				$resultdt['SPEED'][$i]['coaching_tip'] = $tempwrkts['TempWorkout']['coaching_tip'];
			}
			
			if($tempwrkts['TempWorkout']['exercise_type']=='RESISTANCE'){
								
				$resultdt['RESISTANCE'][$i]['exercise'] = $tempwrkts['TempWorkout']['exercise'];
				$resultdt['RESISTANCE'][$i]['set'] = $tempwrkts['TempWorkout']['set'];
				$resultdt['RESISTANCE'][$i]['rep'] = $tempwrkts['TempWorkout']['rep'];
				$resultdt['RESISTANCE'][$i]['temp'] = $tempwrkts['TempWorkout']['temp'];
				$resultdt['RESISTANCE'][$i]['rest'] = $tempwrkts['TempWorkout']['rest'];
				$resultdt['RESISTANCE'][$i]['coaching_tip'] = $tempwrkts['TempWorkout']['coaching_tip'];
			}
			
			if($tempwrkts['TempWorkout']['exercise_type']=='COOL'){
								
				$resultdt['COOL'][$i]['exercise'] = $tempwrkts['TempWorkout']['exercise'];
				$resultdt['COOL'][$i]['set'] = $tempwrkts['TempWorkout']['set'];
				$resultdt['COOL'][$i]['duration'] = $tempwrkts['TempWorkout']['duration'];
				$resultdt['COOL'][$i]['coaching_tip'] = $tempwrkts['TempWorkout']['coaching_tip'];
			}
			
			$i++;	
			
			
			
		}
		$ikp=0;
		foreach($scheduleCalendars as $scheduleCalendar)
		{
			
			$resultdt['ScheduleCalendar'][$ikp]['id']=$scheduleCalendar['ScheduleCalendar']['id'];
			$resultdt['ScheduleCalendar'][$ikp]['availability']=date('Y-m-d h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['start'])).' - '.date('h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['end']));
			
			//$resultdt['ScheduleCalendar'][][$scheduleCalendar['ScheduleCalendar']['id']] = date('Y-m-d h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['start'])).' - '.date('h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['end']));
			$ikp++;
		}
		
		
		$resultdt3['COMMON']['Trainee'] = $clientData['Trainee']['full_name'];
		$resultdt3['COMMON']['Goal'] = $goals['Goal']['goal'];
		$resultdt3['COMMON']['Phase'] = $goals['Goal']['phase'];
		$resultdt3['COMMON']['Note'] = $goals['Goal']['note'];
		$resultdt3['COMMON']['Alert'] = $goals['Goal']['alert'];
		
		$resultdt3['COMMON']['trainer_id'] = $tempwrkt[0]['TempWorkout']['trainer_id'];
		$resultdt3['COMMON']['workoutcategory'] = $tempwrkt[0]['TempWorkout']['category_id'];
		$resultdt3['COMMON']['workoutname'] = $tempwrkt[0]['TempWorkout']['name'];
		$resultdt3['COMMON']['group_id'] = $grpid;
		
		foreach($resultdt as $key=>$val)
		{
			foreach($val as $nval)
			{
				$res[$key][] = $nval;
			}
		}
		
		
		
		$resultdt2 = array_merge($res,$resultdt3);
		//echo $callresponse2=json_encode($resultdt2);
		
		$callresponse2=array('status'=>'True','result'=>$resultdt2);
		echo $callresponse=json_encode($callresponse2);
		}		
		else 
		{
			$callresponse=array('status'=>'False','result'=>"Sorry, No schedule exits for this client.");

			echo $callresponse2=json_encode($callresponse);
		}
		exit;

	}
	
	public function assigntoclient($trnid,$clientId)
	{
		
		$this->layout="";

		$this->autoRender=false;
		
		$clientId = trim($clientId);
		$trnid = trim($trnid);
		
		$ScheduleCalendarid=trim($_POST['sessionType']);			

		$checkCalArr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.id"=>$ScheduleCalendarid)));
		
		$startDate=$checkCalArr['ScheduleCalendar']['start'];
		$endDate=$checkCalArr['ScheduleCalendar']['end'];
		
		/*echo"<pre>";
		print_r($_POST);
		echo"</pre>"; exit;*/
		
		$goalArr=array();

		$goalArr['Goal']['goal']=trim($_POST['goal']);
		$goalArr['Goal']['phase']=trim($_POST['phase']);
		$goalArr['Goal']['note']=trim($_POST['note']);
		$goalArr['Goal']['alert']=trim($_POST['alert']);
		$goalArr['Goal']['trainer_id']=$trnid;
		$goalArr['Goal']['trainee_id']=$clientId;
		$goalArr['Goal']['added_date']=date('Y-m-d H:i:s');
		$goalArr['Goal']['modified_date']=date('Y-m-d H:i:s');
		$goalArr['Goal']['start']=$startDate;
		$goalArr['Goal']['end']=$endDate;
		
		$checkCalArr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.trainer_id"=>$trnid,'ScheduleCalendar.trainee_id'=>$clientId,'ScheduleCalendar.start'=>$startDate)));

		$this->ScheduleCalendar->id=$ScheduleCalendarid;

		$data=array();

		$this->request->data['ScheduleCalendar']['mapwrkt']=1;
		$this->ScheduleCalendar->save($this->data['ScheduleCalendar']);
		$this->Goal->save($goalArr);
		
		
		
		if(!empty($_POST['Warm']))
		{
			foreach ($_POST['Warm'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);		
				
				$response1 = $val;	
				$responsen[] = $key; 	
				
				

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));
				

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));				
				

				$durationA=explode("=",$exprd[2]);
				$duration=trim(str_replace("'","",$durationA[2]));				
				

				$coaching_tipA=explode("=",$exprd[3]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[3]));				
				
				$exercisedata['WarmUps']['trainer_id']=$trnid;
				$exercisedata['WarmUps']['trainee_id']=$clientId;
				$exercisedata['WarmUps']['exercise']=$exercise;
				$exercisedata['WarmUps']['set']=$set;
				$exercisedata['WarmUps']['duration']=$duration;
				$exercisedata['WarmUps']['coaching_tip']=$coaching_tip;
				$exercisedata['WarmUps']['added_date']=date('Y-m-d');
				$exercisedata['WarmUps']['start']=$startDate;
				$exercisedata['WarmUps']['end']=$endDate;

				if($exercisedata['WarmUps']['exercise']!='') {						
					$this->WarmUps->saveAll($exercisedata);
				}
			}
		}	
			
			
		if(!empty($_POST['CORE']))
		{
			foreach ($_POST['CORE'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);			

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));				

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));			

				$repA=explode("=",$exprd[2]);
				$rep=trim(str_replace("'","",$repA[1]));			

				$weightA=explode("=",$exprd[3]);
				$weight=trim(str_replace("'","",$weightA[1]));				

				$rstA=explode("=",$exprd[4]);
				$rst=trim(str_replace("'","",$rstA[1]));				

				$coaching_tipA=explode("=",$exprd[5]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));								
				
				$exercisedata1['CoreBalancePlyometric']['trainer_id']=$trnid;
			    $exercisedata1['CoreBalancePlyometric']['trainee_id']=$clientId;
				$exercisedata1['CoreBalancePlyometric']['exercise']=$exercise;
				$exercisedata1['CoreBalancePlyometric']['set']=$set;
				$exercisedata1['CoreBalancePlyometric']['rep']=$rep;
				$exercisedata1['CoreBalancePlyometric']['rest']=$rst;
				$exercisedata1['CoreBalancePlyometric']['temp']=$weight;
				$exercisedata1['CoreBalancePlyometric']['coaching_tip']=$coaching_tip;
				$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d');
				$exercisedata1['CoreBalancePlyometric']['start']=$startDate;
				$exercisedata1['CoreBalancePlyometric']['end']=$endDate;			

				if($exercisedata1['CoreBalancePlyometric']['exercise']!='') {
					$this->CoreBalancePlyometric->saveAll($exercisedata1);
				}
			}
		}	
			
		if(!empty($_POST['SPEED']))
		{
			foreach ($_POST['SPEED'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);			

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));			

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));				

				$repA=explode("=",$exprd[2]);
				$rep=trim(str_replace("'","",$repA[1]));				

				$weightA=explode("=",$exprd[3]);
				$weight=trim(str_replace("'","",$weightA[1]));			

				$rstA=explode("=",$exprd[4]);
				$rst=trim(str_replace("'","",$rstA[1]));				

				$coaching_tipA=explode("=",$exprd[5]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));				
				
				
				$exercisedata2['SpeedAgilityQuickness']['trainer_id']=$trnid;
			    $exercisedata2['SpeedAgilityQuickness']['trainee_id']=$clientId;
				$exercisedata2['SpeedAgilityQuickness']['exercise']=$exercise;
				$exercisedata2['SpeedAgilityQuickness']['set']=$set;
				$exercisedata2['SpeedAgilityQuickness']['rep']=$rep;
				$exercisedata2['SpeedAgilityQuickness']['rest']=$rst;
				$exercisedata2['SpeedAgilityQuickness']['temp']=$weight;
				$exercisedata2['SpeedAgilityQuickness']['coaching_tip']=$coaching_tip;
				$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d');
				$exercisedata2['SpeedAgilityQuickness']['start']=$startDate;
				$exercisedata2['SpeedAgilityQuickness']['end']=$endDate;

				if($exercisedata2['SpeedAgilityQuickness']['exercise']!='') {
					$this->SpeedAgilityQuickness->saveAll($exercisedata2);
				}
			}
		}	
			
			if(!empty($_POST['RESISTANCE']))
			{
				foreach ($_POST['RESISTANCE'] as $key=>$val)
				{
					$exprd=explode(",",$val[0]);				
	
					$exerciseA=explode("=",$exprd[0]);
					$exercise=trim(str_replace("'","",$exerciseA[1]));			
	
					$setA=explode("=",$exprd[1]);
					$set=trim(str_replace("'","",$setA[1]));				
	
					$repA=explode("=",$exprd[2]);
					$rep=trim(str_replace("'","",$repA[1]));				
	
					$weightA=explode("=",$exprd[3]);
					$weight=trim(str_replace("'","",$weightA[1]));			
	
					$rstA=explode("=",$exprd[4]);
					$rst=trim(str_replace("'","",$rstA[1]));				
	
					$coaching_tipA=explode("=",$exprd[5]);
					$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));									
					
					
					$exercisedata3['Resistence']['trainer_id']=$trnid;
				    $exercisedata3['Resistence']['trainee_id']=$clientId;
					$exercisedata3['Resistence']['exercise']=$exercise;
					$exercisedata3['Resistence']['set']=$set;
					$exercisedata3['Resistence']['rep']=$rep;
					$exercisedata3['Resistence']['rest']=$rst;
					$exercisedata3['Resistence']['temp']=$weight;
					$exercisedata3['Resistence']['coaching_tip']=$coaching_tip;
					$exercisedata3['Resistence']['added_date']=date('Y-m-d');
					$exercisedata3['Resistence']['start']=$startDate;
					$exercisedata3['Resistence']['end']=$endDate;

					if($exercisedata3['Resistence']['exercise']!='') {
						$this->Resistence->saveAll($exercisedata3);
					}
				}
			}
			
		if(!empty($_POST['COOL']))
		{
			foreach ($_POST['COOL'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);		

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));				
				
				$durationA=explode("=",$exprd[2]);
				$duration=trim(str_replace("'","",$durationA[1]));				

				$coaching_tipA=explode("=",$exprd[3]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));				
				
				
				if($varr4['TempWorkout']['exercise']!='') {
					$this->TempWorkout->saveAll($varr4);
				}
				
				
				$exercisedata4['CoolDown']['trainer_id']=$trnid;
			    $exercisedata4['CoolDown']['trainee_id']=$clientId;
				$exercisedata4['CoolDown']['exercise']=$exercise;
				$exercisedata4['CoolDown']['set']=$set;
				$exercisedata4['CoolDown']['duration']=$duration;
				$exercisedata4['CoolDown']['coaching_tip']=$coaching_tip;
				$exercisedata4['CoolDown']['added_date']=date('Y-m-d');
				$exercisedata4['CoolDown']['start']=$startDate;
				$exercisedata4['CoolDown']['end']=$endDate;
					
				if($exercisedata4['CoolDown']['exercise']!='') {
					$this->CoolDown->saveAll($exercisedata4);
				}
			}
		}
		
		$callresponse=array('status'=>'True','result'=>"Thanks, you have successfully assigned the saved workout.");
		echo $callresponse2=json_encode($callresponse);
		
		exit;
		
		
	}
	
	
	
	
	public function saveworkoutdata($trainerId,$clientId,$goalId)
	{

		$this->layout="";
		$this->autoRender=false;
		
		$uid = $trainerId;
		$clientid=trim($clientId);
		$goalid_sw=trim($goalId);
		
		$workoutname1=trim($_POST['workoutname']);
		$workoutcategory1=trim($_POST['workoutcategory']);		
		
		/*echo"<pre>";
		print_r($_POST);
		echo"</pre>";exit;*/

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
			foreach($setWarmupArr as $key=>$val)
			{	

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
			  foreach($setCoreBalancePlyometricArr as $key=>$val)
			  {
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
			  foreach($setSpeedAgilityQuicknessArr as $key=>$val)
			  {	  		
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
			  foreach($setResistenceArr as $key=>$val)
			  {
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
			  foreach($setCoolDownArr as $key=>$val)
			  {	  	

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
		
		$callresponse=array('status'=>'True','result'=>"Thanks, you have saved this workout.");
		echo json_encode($callresponse);
		exit;		
	}
	
	
	public function getSavedWorkoutList($trainerId,$clientId,$goalId)
	{
		$goalId    = $goalId;
		$traineeId = $clientId;

		$setGoalArrs=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$goalId)));			

		$trainerId = $trainerId;						
		$startDate = $setGoalArrs['Goal']['start'];
		$endDate   = $setGoalArrs['Goal']['end'];		

		$getCalendarDetails=$this->ScheduleCalendar->find("all",array("conditions"=>array("ScheduleCalendar.trainer_id"=>$trainerId,"ScheduleCalendar.trainee_id "=>$traineeId,"ScheduleCalendar.start >"=> $startDate,"ScheduleCalendar.mapwrkt <>"=> 1,"ScheduleCalendar.status <>"=> 0),'limit'=>5));			

		$schList = array();
		$i = 0;
		foreach($getCalendarDetails as $totSch)
		{		
			$schList['ScheduleCalendar'][$i]['id']=$totSch['ScheduleCalendar']['id'];
			$schList['ScheduleCalendar'][$i]['availability']= date('m/d/Y h:i A',strtotime($totSch['ScheduleCalendar']['start'])).' - '.date('h:i A',strtotime($totSch['ScheduleCalendar']['end']));			
			$i++;
		}	
		
		$callresponse=array('status'=>'True','result'=>$schList);
		
		echo json_encode($callresponse);
		exit;
	}
	
	
	
	public function repeatWorkoutData($trainerId,$goalId)
	{	

		$this->layout = '';
		$this->render = false;
		$uid = $trainerId;
		$goalid_sw=trim($goalId);
		
		$goalArr=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$goalid_sw)));		

		$clientid=$goalArr['Goal']['trainee_id'];
		$startvaldt=$goalArr['Goal']['start'];
		$endvaldt=$goalArr['Goal']['end'];
		$nextdt=trim($_POST['sessType']);		

		$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$clientid,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));

		$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$clientid,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));

		$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$clientid,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));

		$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$clientid,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));
		
 		$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$clientid,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC'))); 

 		$scheduleCalendars=$this->ScheduleCalendar->find('first',array('conditions'=>array('ScheduleCalendar.id'=>$nextdt),'fields'=>array('ScheduleCalendar.id','ScheduleCalendar.start','ScheduleCalendar.end')));

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
        		
		$callresponse=array('status'=>'True','result'=>"Thanks, you have repeat this workout.");
		
		echo json_encode($callresponse);
		exit;		
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

                      
                      $callresponse=array('status'=>'True','result'=>"Thanks, Workout Successfully Deleted.");
				}
				else
				{
                  $callresponse=array('status'=>'False','result'=>"Some issue occur, please try again.");
				}			 
			} 
			else
			{				  
				  $callresponse=array('status'=>'False','result'=>"Please select the Workout.");
			}
              echo json_encode($callresponse);
			  exit;	
		}	
		
		
		
	public function getEditWorkoutList($goalId,$clientId,$trainerId)
	{
		$this->layout = '';
		$this->autoRender = false;
		
		$id = $goalId;
		$traineeId = $clientId;
		$uid = $trainerId;
		
		$resultdt = array();	

		$getClientGoalDetails=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$id)));
		
		//$resultdt[] = $getClientGoalDetails;	

		$startvaldt = $getClientGoalDetails['Goal']['start'];	
		$endvaldt   = $getClientGoalDetails['Goal']['end'];	
		
		$resultdt['Goal'] = $getClientGoalDetails['Goal']['goal'];	
		$resultdt['note'] = $getClientGoalDetails['Goal']['note'];	
		$resultdt['phase'] = $getClientGoalDetails['Goal']['phase'];	
		$resultdt['alert'] = $getClientGoalDetails['Goal']['alert'];	

		$setClientArr=$this->Trainee->find("first",array("conditions"=>array("Trainee.id"=>$traineeId)));	
		
		

		$setWarmupArr=$this->WarmUps->find("all",array("conditions"=>array("WarmUps.trainee_id"=>$traineeId,"WarmUps.trainer_id"=>$uid,'WarmUps.start'=>$startvaldt,'WarmUps.end'=>$endvaldt),'order'=>array('WarmUps.id ASC')));	
		
		
		foreach($setWarmupArr as $warma)
		{
			$resultdt['Warm'][] = $warma['WarmUps'];
		}
		
		/*echo"<pre>";
		print_r($resultdt);
		echo"</pre>"; exit;*/
		
		
		//$resultdt[] = $setWarmupArr;

		$setCoreBalancePlyometricArr=$this->CoreBalancePlyometric->find("all",array("conditions"=>array("CoreBalancePlyometric.trainee_id"=>$traineeId,"CoreBalancePlyometric.trainer_id"=>$uid,'CoreBalancePlyometric.start'=>$startvaldt,'CoreBalancePlyometric.end'=>$endvaldt),'order'=>array('CoreBalancePlyometric.id ASC')));
		
		//$resultdt[] = $setCoreBalancePlyometricArr;
		
		foreach($setCoreBalancePlyometricArr as $warmac)
		{
			$resultdt['CORE'][] = $warmac['CoreBalancePlyometric'];
		}

		$setSpeedAgilityQuicknessArr=$this->SpeedAgilityQuickness->find("all",array("conditions"=>array("SpeedAgilityQuickness.trainee_id"=>$traineeId,"SpeedAgilityQuickness.trainer_id"=>$uid,'SpeedAgilityQuickness.start'=>$startvaldt,'SpeedAgilityQuickness.end'=>$endvaldt),'order'=>array('SpeedAgilityQuickness.id ASC')));
		
		//$resultdt[] = $setSpeedAgilityQuicknessArr;
		
		foreach($setSpeedAgilityQuicknessArr as $warmas)
		{
			$resultdt['SPEED'][] = $warmas['SpeedAgilityQuickness'];
		}

		$setResistenceArr=$this->Resistence->find("all",array("conditions"=>array("Resistence.trainee_id"=>$traineeId,"Resistence.trainer_id"=>$uid,'Resistence.start'=>$startvaldt,'Resistence.end'=>$endvaldt),'order'=>array('Resistence.id ASC')));
		
		//$resultdt[] = $setResistenceArr;
		
		foreach($setResistenceArr as $warmar)
		{
			$resultdt['RESISTANCE'][] = $warmar['Resistence'];
		}

		$setCoolDownArr=$this->CoolDown->find("all",array("conditions"=>array("CoolDown.trainee_id"=>$traineeId,"CoolDown.trainer_id"=>$uid,'CoolDown.start'=>$startvaldt,'CoolDown.end'=>$endvaldt),'order'=>array('CoolDown.id ASC')));
		
		//$resultdt[] = $setCoolDownArr;
		
		foreach($setCoolDownArr as $warmaco)
		{
			$resultdt['COOL'][] = $warmaco['CoolDown'];
		}
		
		
		$callresponse=array('status'=>'True','result'=>$resultdt);

              echo json_encode($callresponse);
			  exit;
	
	}
	
	
	public function editWorkoutData($trnid,$clientId,$GoalId)
	{
		
		$this->layout="";

		$this->autoRender=false;
		
		$clientId = trim($clientId);
		$trnid = trim($trnid);
		$GoalId  = trim($GoalId);
		
		$getClientGoalDetails=$this->Goal->find("first",array("conditions"=>array("Goal.id"=>$GoalId)));

      	$startDate		=	$getClientGoalDetails['Goal']['start'];
	    $endDate		=	$getClientGoalDetails['Goal']['end'];
		
		/*echo"<pre>";
		print_r($_POST);
		echo"</pre>"; exit;*/
		
		$goalArr=array();

		$this->WarmUps->query("delete from warm_ups where trainer_id='".$trnid."' and trainee_id='".$clientId."' and start='".$startDate."' and end='".$endDate."'");

		$this->CoreBalancePlyometric->query("delete from corebalance_plyometric where trainer_id='".$trnid."' and trainee_id='".$clientId."' and start='".$startDate."' and end='".$endDate."'");

		$this->SpeedAgilityQuickness->query("delete from speedagility_quickness where trainer_id='".$trnid."' and trainee_id='".$clientId."' and start='".$startDate."' and end='".$endDate."'");

		$this->Resistence->query("delete from resistences where trainer_id='".$trnid."' and trainee_id='".$clientId."' and start='".$startDate."' and end='".$endDate."'");

		$this->CoolDown->query("delete from cool_down where trainer_id='".$trnid."' and trainee_id='".$clientId."' and start='".$startDate."' and end='".$endDate."'");
			

        $goalArr=array();

		$goalArr['Goal']['goal']=trim($_POST['Goal']);
		$goalArr['Goal']['phase']=trim($_POST['phase']);
		$goalArr['Goal']['note']=trim($_POST['note']);
		$goalArr['Goal']['alert']=trim($_POST['alert']);
		$goalArr['Goal']['start']=trim($startDate);
		$goalArr['Goal']['end']=trim($endDate);
		$goalArr['Goal']['id']=$GoalId;				

		$this->Goal->save($goalArr);		
		
		
		if(!empty($_POST['Warm']))
		{
			foreach ($_POST['Warm'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);		
				
				$response1 = $val;	
				$responsen[] = $key; 	
				
				

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));
				

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));				
				

				$durationA=explode("=",$exprd[2]);
				$duration=trim(str_replace("'","",$durationA[1]));				
				

				$coaching_tipA=explode("=",$exprd[3]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));				
				
				$exercisedata['WarmUps']['trainer_id']=$trnid;
				$exercisedata['WarmUps']['trainee_id']=$clientId;
				$exercisedata['WarmUps']['exercise']=$exercise;
				$exercisedata['WarmUps']['set']=$set;
				$exercisedata['WarmUps']['duration']=$duration;
				$exercisedata['WarmUps']['coaching_tip']=$coaching_tip;
				$exercisedata['WarmUps']['added_date']=date('Y-m-d');
				$exercisedata['WarmUps']['start']=$startDate;
				$exercisedata['WarmUps']['end']=$endDate;

				if($exercisedata['WarmUps']['exercise']!='') {						
					$this->WarmUps->saveAll($exercisedata);
				}
			}
		}	
			
			
		if(!empty($_POST['CORE']))
		{
			foreach ($_POST['CORE'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);			

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));				

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));			

				$repA=explode("=",$exprd[2]);
				$rep=trim(str_replace("'","",$repA[1]));			

				$weightA=explode("=",$exprd[3]);
				$weight=trim(str_replace("'","",$weightA[1]));				

				$rstA=explode("=",$exprd[4]);
				$rst=trim(str_replace("'","",$rstA[1]));				

				$coaching_tipA=explode("=",$exprd[5]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));								
				
				$exercisedata1['CoreBalancePlyometric']['trainer_id']=$trnid;
			    $exercisedata1['CoreBalancePlyometric']['trainee_id']=$clientId;
				$exercisedata1['CoreBalancePlyometric']['exercise']=$exercise;
				$exercisedata1['CoreBalancePlyometric']['set']=$set;
				$exercisedata1['CoreBalancePlyometric']['rep']=$rep;
				$exercisedata1['CoreBalancePlyometric']['rest']=$rst;
				$exercisedata1['CoreBalancePlyometric']['temp']=$weight;
				$exercisedata1['CoreBalancePlyometric']['coaching_tip']=$coaching_tip;
				$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d');
				$exercisedata1['CoreBalancePlyometric']['start']=$startDate;
				$exercisedata1['CoreBalancePlyometric']['end']=$endDate;			

				if($exercisedata1['CoreBalancePlyometric']['exercise']!='') {
					$this->CoreBalancePlyometric->saveAll($exercisedata1);
				}
			}
		}	
			
		if(!empty($_POST['SPEED']))
		{
			foreach ($_POST['SPEED'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);			

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));			

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));				

				$repA=explode("=",$exprd[2]);
				$rep=trim(str_replace("'","",$repA[1]));				

				$weightA=explode("=",$exprd[3]);
				$weight=trim(str_replace("'","",$weightA[1]));			

				$rstA=explode("=",$exprd[4]);
				$rst=trim(str_replace("'","",$rstA[1]));				

				$coaching_tipA=explode("=",$exprd[5]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));				
				
				
				$exercisedata2['SpeedAgilityQuickness']['trainer_id']=$trnid;
			    $exercisedata2['SpeedAgilityQuickness']['trainee_id']=$clientId;
				$exercisedata2['SpeedAgilityQuickness']['exercise']=$exercise;
				$exercisedata2['SpeedAgilityQuickness']['set']=$set;
				$exercisedata2['SpeedAgilityQuickness']['rep']=$rep;
				$exercisedata2['SpeedAgilityQuickness']['rest']=$rst;
				$exercisedata2['SpeedAgilityQuickness']['temp']=$weight;
				$exercisedata2['SpeedAgilityQuickness']['coaching_tip']=$coaching_tip;
				$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d');
				$exercisedata2['SpeedAgilityQuickness']['start']=$startDate;
				$exercisedata2['SpeedAgilityQuickness']['end']=$endDate;

				if($exercisedata2['SpeedAgilityQuickness']['exercise']!='') {
					$this->SpeedAgilityQuickness->saveAll($exercisedata2);
				}
			}
		}	
			
			if(!empty($_POST['RESISTANCE']))
			{
				foreach ($_POST['RESISTANCE'] as $key=>$val)
				{
					$exprd=explode(",",$val[0]);				
	
					$exerciseA=explode("=",$exprd[0]);
					$exercise=trim(str_replace("'","",$exerciseA[1]));			
	
					$setA=explode("=",$exprd[1]);
					$set=trim(str_replace("'","",$setA[1]));				
	
					$repA=explode("=",$exprd[2]);
					$rep=trim(str_replace("'","",$repA[1]));				
	
					$weightA=explode("=",$exprd[3]);
					$weight=trim(str_replace("'","",$weightA[1]));			
	
					$rstA=explode("=",$exprd[4]);
					$rst=trim(str_replace("'","",$rstA[1]));				
	
					$coaching_tipA=explode("=",$exprd[5]);
					$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));									
					
					
					$exercisedata3['Resistence']['trainer_id']=$trnid;
				    $exercisedata3['Resistence']['trainee_id']=$clientId;
					$exercisedata3['Resistence']['exercise']=$exercise;
					$exercisedata3['Resistence']['set']=$set;
					$exercisedata3['Resistence']['rep']=$rep;
					$exercisedata3['Resistence']['rest']=$rst;
					$exercisedata3['Resistence']['temp']=$weight;
					$exercisedata3['Resistence']['coaching_tip']=$coaching_tip;
					$exercisedata3['Resistence']['added_date']=date('Y-m-d');
					$exercisedata3['Resistence']['start']=$startDate;
					$exercisedata3['Resistence']['end']=$endDate;

					if($exercisedata3['Resistence']['exercise']!='') {
						$this->Resistence->saveAll($exercisedata3);
					}
				}
			}
			
		if(!empty($_POST['COOL']))
		{
			foreach ($_POST['COOL'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);		

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));				
				
				$durationA=explode("=",$exprd[2]);
				$duration=trim(str_replace("'","",$durationA[1]));				

				$coaching_tipA=explode("=",$exprd[3]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));				
				
				
				if($varr4['TempWorkout']['exercise']!='') {
					$this->TempWorkout->saveAll($varr4);
				}
				
				
				$exercisedata4['CoolDown']['trainer_id']=$trnid;
			    $exercisedata4['CoolDown']['trainee_id']=$clientId;
				$exercisedata4['CoolDown']['exercise']=$exercise;
				$exercisedata4['CoolDown']['set']=$set;
				$exercisedata4['CoolDown']['duration']=$duration;
				$exercisedata4['CoolDown']['coaching_tip']=$coaching_tip;
				$exercisedata4['CoolDown']['added_date']=date('Y-m-d');
				$exercisedata4['CoolDown']['start']=$startDate;
				$exercisedata4['CoolDown']['end']=$endDate;
					
				if($exercisedata4['CoolDown']['exercise']!='') {
					$this->CoolDown->saveAll($exercisedata4);
				}
			}
		}
		
		$callresponse=array('status'=>'True','result'=>"Thanks, you have successfully edited the workout.");
		echo $callresponse2=json_encode($callresponse);
		
		exit;
		
		
	}
	
	
	public function addwarmup_new(){
		
		$this->layout = '';
		$this->render = false;
		//$id = $this->Session->read('USER_ID');
		
		$ScheduleCalendarid=trim($_POST['sessionType']);	
				
		$checkCalArr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.id"=>$ScheduleCalendarid)));
		
		$startDate=$checkCalArr['ScheduleCalendar']['start'];
		$endDate=$checkCalArr['ScheduleCalendar']['end'];
		
		
		$trnid = trim($_POST['Trainer_Id']);
		
		$clientId = trim($_POST['trainee_id']);
		
		/*echo"<pre>";
		print_r($_POST);
		echo"</pre>";exit;*/
		
		
		$goalArr=array();

		$goalArr['Goal']['goal']=trim($_POST['goal']);
		$goalArr['Goal']['phase']=trim($_POST['phase']);
		$goalArr['Goal']['note']=trim($_POST['note']);
		$goalArr['Goal']['alert']=trim($_POST['alert']);
		$goalArr['Goal']['trainer_id']=trim($_POST['Trainer_Id']);
		$goalArr['Goal']['trainee_id']=trim($_POST['trainee_id']);
		$goalArr['Goal']['added_date']=date('Y-m-d H:i:s');
		$goalArr['Goal']['modified_date']=date('Y-m-d H:i:s');
		$goalArr['Goal']['start']=$startDate;
		$goalArr['Goal']['end']=$endDate;

		$checkCalArr=$this->ScheduleCalendar->find("first",array("conditions"=>array("ScheduleCalendar.trainer_id"=>$_POST['Trainer_Id'],'ScheduleCalendar.trainee_id'=>$_POST['trainee_id'],'ScheduleCalendar.start'=>$startDate)));

		$this->ScheduleCalendar->id=$ScheduleCalendarid;

		$data=array();

		$this->request->data['ScheduleCalendar']['mapwrkt']=1;
		
		$this->ScheduleCalendar->save($this->data['ScheduleCalendar']);

		$this->Goal->save($goalArr);
		
		
		if(!empty($_POST['Warm']))
		{
			foreach ($_POST['Warm'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);		
				
				$response1 = $val;	
				$responsen[] = $key; 	
				
				

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));
				

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));				
				

				$durationA=explode("=",$exprd[2]);
				$duration=trim(str_replace("'","",$durationA[1]));				
				

				$coaching_tipA=explode("=",$exprd[3]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));				
				
				$exercisedata['WarmUps']['trainer_id']=$trnid;
				$exercisedata['WarmUps']['trainee_id']=$clientId;
				$exercisedata['WarmUps']['exercise']=$exercise;
				$exercisedata['WarmUps']['set']=$set;
				$exercisedata['WarmUps']['duration']=$duration;
				$exercisedata['WarmUps']['coaching_tip']=$coaching_tip;
				$exercisedata['WarmUps']['added_date']=date('Y-m-d');
				$exercisedata['WarmUps']['start']=$startDate;
				$exercisedata['WarmUps']['end']=$endDate;

				if($exercisedata['WarmUps']['exercise']!='') {						
					$this->WarmUps->saveAll($exercisedata);
				}
			}
		}	
			
			
		if(!empty($_POST['CORE']))
		{
			foreach ($_POST['CORE'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);			

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));				

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));			

				$repA=explode("=",$exprd[2]);
				$rep=trim(str_replace("'","",$repA[1]));			

				$weightA=explode("=",$exprd[3]);
				$weight=trim(str_replace("'","",$weightA[1]));				

				$rstA=explode("=",$exprd[4]);
				$rst=trim(str_replace("'","",$rstA[1]));				

				$coaching_tipA=explode("=",$exprd[5]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));								
				
				$exercisedata1['CoreBalancePlyometric']['trainer_id']=$trnid;
			    $exercisedata1['CoreBalancePlyometric']['trainee_id']=$clientId;
				$exercisedata1['CoreBalancePlyometric']['exercise']=$exercise;
				$exercisedata1['CoreBalancePlyometric']['set']=$set;
				$exercisedata1['CoreBalancePlyometric']['rep']=$rep;
				$exercisedata1['CoreBalancePlyometric']['rest']=$rst;
				$exercisedata1['CoreBalancePlyometric']['temp']=$weight;
				$exercisedata1['CoreBalancePlyometric']['coaching_tip']=$coaching_tip;
				$exercisedata1['CoreBalancePlyometric']['added_date']=date('Y-m-d');
				$exercisedata1['CoreBalancePlyometric']['start']=$startDate;
				$exercisedata1['CoreBalancePlyometric']['end']=$endDate;			

				if($exercisedata1['CoreBalancePlyometric']['exercise']!='') {
					$this->CoreBalancePlyometric->saveAll($exercisedata1);
				}
			}
		}	
			
		if(!empty($_POST['SPEED']))
		{
			foreach ($_POST['SPEED'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);			

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));			

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));				

				$repA=explode("=",$exprd[2]);
				$rep=trim(str_replace("'","",$repA[1]));				

				$weightA=explode("=",$exprd[3]);
				$weight=trim(str_replace("'","",$weightA[1]));			

				$rstA=explode("=",$exprd[4]);
				$rst=trim(str_replace("'","",$rstA[1]));				

				$coaching_tipA=explode("=",$exprd[5]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));				
				
				
				$exercisedata2['SpeedAgilityQuickness']['trainer_id']=$trnid;
			    $exercisedata2['SpeedAgilityQuickness']['trainee_id']=$clientId;
				$exercisedata2['SpeedAgilityQuickness']['exercise']=$exercise;
				$exercisedata2['SpeedAgilityQuickness']['set']=$set;
				$exercisedata2['SpeedAgilityQuickness']['rep']=$rep;
				$exercisedata2['SpeedAgilityQuickness']['rest']=$rst;
				$exercisedata2['SpeedAgilityQuickness']['temp']=$weight;
				$exercisedata2['SpeedAgilityQuickness']['coaching_tip']=$coaching_tip;
				$exercisedata2['SpeedAgilityQuickness']['added_date']=date('Y-m-d');
				$exercisedata2['SpeedAgilityQuickness']['start']=$startDate;
				$exercisedata2['SpeedAgilityQuickness']['end']=$endDate;

				if($exercisedata2['SpeedAgilityQuickness']['exercise']!='') {
					$this->SpeedAgilityQuickness->saveAll($exercisedata2);
				}
			}
		}	
			
			if(!empty($_POST['RESISTANCE']))
			{
				foreach ($_POST['RESISTANCE'] as $key=>$val)
				{
					$exprd=explode(",",$val[0]);				
	
					$exerciseA=explode("=",$exprd[0]);
					$exercise=trim(str_replace("'","",$exerciseA[1]));			
	
					$setA=explode("=",$exprd[1]);
					$set=trim(str_replace("'","",$setA[1]));				
	
					$repA=explode("=",$exprd[2]);
					$rep=trim(str_replace("'","",$repA[1]));				
	
					$weightA=explode("=",$exprd[3]);
					$weight=trim(str_replace("'","",$weightA[1]));			
	
					$rstA=explode("=",$exprd[4]);
					$rst=trim(str_replace("'","",$rstA[1]));				
	
					$coaching_tipA=explode("=",$exprd[5]);
					$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));									
					
					
					$exercisedata3['Resistence']['trainer_id']=$trnid;
				    $exercisedata3['Resistence']['trainee_id']=$clientId;
					$exercisedata3['Resistence']['exercise']=$exercise;
					$exercisedata3['Resistence']['set']=$set;
					$exercisedata3['Resistence']['rep']=$rep;
					$exercisedata3['Resistence']['rest']=$rst;
					$exercisedata3['Resistence']['temp']=$weight;
					$exercisedata3['Resistence']['coaching_tip']=$coaching_tip;
					$exercisedata3['Resistence']['added_date']=date('Y-m-d');
					$exercisedata3['Resistence']['start']=$startDate;
					$exercisedata3['Resistence']['end']=$endDate;

					if($exercisedata3['Resistence']['exercise']!='') {
						$this->Resistence->saveAll($exercisedata3);
					}
				}
			}
			
		if(!empty($_POST['COOL']))
		{
			foreach ($_POST['COOL'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);		

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));				
				
				$durationA=explode("=",$exprd[2]);
				$duration=trim(str_replace("'","",$durationA[1]));				

				$coaching_tipA=explode("=",$exprd[3]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));				
								
				$exercisedata4['CoolDown']['trainer_id']=$trnid;
			    $exercisedata4['CoolDown']['trainee_id']=$clientId;
				$exercisedata4['CoolDown']['exercise']=$exercise;
				$exercisedata4['CoolDown']['set']=$set;
				$exercisedata4['CoolDown']['duration']=$duration;
				$exercisedata4['CoolDown']['coaching_tip']=$coaching_tip;
				$exercisedata4['CoolDown']['added_date']=date('Y-m-d');
				$exercisedata4['CoolDown']['start']=$startDate;
				$exercisedata4['CoolDown']['end']=$endDate;
					
				if($exercisedata4['CoolDown']['exercise']!='') {
					$this->CoolDown->saveAll($exercisedata4);
				}
			}
		}
		
		$callresponse=array('status'=>'True','result'=>"Thanks, you have successfully assigned the saved workout.");
		echo $callresponse2=json_encode($callresponse);
		
		exit;

		
		
	}
	
	public function buildwithoutslclient(){
		
		$this->layout = '';
		$this->render = false;
		$trnid = trim($_POST['Trainer_Id']);
		$workoutcategory1=trim($_POST['category_id']);		
		$workoutname1=trim($_POST['workoutname']);		
		$group_id=mt_rand();
		
		   
		
		
		if(!empty($_POST['Warm']))
		{
			foreach ($_POST['Warm'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);		
				
				$response1 = $val;	
				$responsen[] = $key; 	
				
				

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));
				

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));				
				

				$durationA=explode("=",$exprd[2]);
				$duration=trim(str_replace("'","",$durationA[1]));				
				

				$coaching_tipA=explode("=",$exprd[3]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));				
				
				$exercisedata['TempWorkout']['trainer_id']=$trnid;
				$exercisedata['TempWorkout']['group_id']=$group_id;
				$exercisedata['TempWorkout']['name']=$workoutname1;
				$exercisedata['TempWorkout']['exercise_type']="Workout";
				$exercisedata['TempWorkout']['category_id']=$workoutcategory1; 	 
				$exercisedata['TempWorkout']['exercise']=$exercise;
				$exercisedata['TempWorkout']['set']=$set;
				$exercisedata['TempWorkout']['duration']=$duration;
				$exercisedata['TempWorkout']['coaching_tip']=$coaching_tip;
				$exercisedata['TempWorkout']['added_date']=date('Y-m-d');
				
			
				if($exercisedata['TempWorkout']['exercise']!='') {
					$this->TempWorkout->saveAll($exercisedata);
				}
				
			}
		}	
			
			
		if(!empty($_POST['CORE']))
		{
			foreach ($_POST['CORE'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);			

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));				

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));			

				$repA=explode("=",$exprd[2]);
				$rep=trim(str_replace("'","",$repA[1]));			

				$weightA=explode("=",$exprd[3]);
				$weight=trim(str_replace("'","",$weightA[1]));				

				$rstA=explode("=",$exprd[4]);
				$rst=trim(str_replace("'","",$rstA[1]));				

				$coaching_tipA=explode("=",$exprd[5]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));		
				
				    $exercisedata1['TempWorkout']['group_id']=$group_id;	
					$exercisedata1['TempWorkout']['exercise_type']="CORE";	
					$exercisedata1['TempWorkout']['name']=$workoutname1; 	
					$exercisedata1['TempWorkout']['category_id']=$workoutcategory1; 	    
					$exercisedata1['TempWorkout']['trainer_id']=$trnid;		    
					$exercisedata1['TempWorkout']['exercise']=trim($exercise);
					$exercisedata1['TempWorkout']['set']=trim($set);
					$exercisedata1['TempWorkout']['rep']=trim($rep);
					$exercisedata1['TempWorkout']['rest']=trim($rst);
					$exercisedata1['TempWorkout']['temp']=trim($weight);
					$exercisedata1['TempWorkout']['coaching_tip']=trim($coaching_tip);
					$exercisedata1['TempWorkout']['added_date']=date('Y-m-d');		
		
					if($exercisedata1['TempWorkout']['exercise']!='') {
						$this->TempWorkout->saveAll($exercisedata1);
					}
				
				
				
			}
		}	
			
		if(!empty($_POST['SPEED']))
		{
			foreach ($_POST['SPEED'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);			

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));			

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));				

				$repA=explode("=",$exprd[2]);
				$rep=trim(str_replace("'","",$repA[1]));				

				$weightA=explode("=",$exprd[3]);
				$weight=trim(str_replace("'","",$weightA[1]));			

				$rstA=explode("=",$exprd[4]);
				$rst=trim(str_replace("'","",$rstA[1]));				

				$coaching_tipA=explode("=",$exprd[5]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));		
				
				$exercisedata2['TempWorkout']['group_id']=$group_id;		    
					$exercisedata2['TempWorkout']['exercise_type']="SPEED";
					$exercisedata2['TempWorkout']['name']=$workoutname1; 	    
					$exercisedata2['TempWorkout']['category_id']=$workoutcategory1;
					$exercisedata2['TempWorkout']['trainer_id']=$trnid;
					$exercisedata2['TempWorkout']['exercise']=trim($exercise);
					$exercisedata2['TempWorkout']['set']=trim($set);
					$exercisedata2['TempWorkout']['rep']=trim($rep);
					$exercisedata2['TempWorkout']['rest']=trim($rst);
					$exercisedata2['TempWorkout']['temp']=trim($weight);
					$exercisedata2['TempWorkout']['coaching_tip']=trim($coaching_tip);
					$exercisedata2['TempWorkout']['added_date']=date('Y-m-d');		

					if($exercisedata2['TempWorkout']['exercise']!='') {
						$this->TempWorkout->saveAll($exercisedata2);
					}
				
			}
		}	
			
			if(!empty($_POST['RESISTANCE']))
			{
				foreach ($_POST['RESISTANCE'] as $key=>$val)
				{
					$exprd=explode(",",$val[0]);				
	
					$exerciseA=explode("=",$exprd[0]);
					$exercise=trim(str_replace("'","",$exerciseA[1]));			
	
					$setA=explode("=",$exprd[1]);
					$set=trim(str_replace("'","",$setA[1]));				
	
					$repA=explode("=",$exprd[2]);
					$rep=trim(str_replace("'","",$repA[1]));				
	
					$weightA=explode("=",$exprd[3]);
					$weight=trim(str_replace("'","",$weightA[1]));			
	
					$rstA=explode("=",$exprd[4]);
					$rst=trim(str_replace("'","",$rstA[1]));				
	
					$coaching_tipA=explode("=",$exprd[5]);
					$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));									
					
					
					
					
					
					$exercisedata3['TempWorkout']['group_id']=$group_id;		    
					$exercisedata3['TempWorkout']['exercise_type']="RESISTANCE";
					$exercisedata3['TempWorkout']['name']=$workoutname1; 	    
					$exercisedata3['TempWorkout']['category_id']=$workoutcategory1;
					$exercisedata3['TempWorkout']['trainer_id']=$trnid;
					$exercisedata3['TempWorkout']['exercise']=trim($exercise);
					$exercisedata3['TempWorkout']['set']=trim($set);
					$exercisedata3['TempWorkout']['rep']=trim($rep);
					$exercisedata3['TempWorkout']['rest']=trim($rst);
					$exercisedata3['TempWorkout']['temp']=trim($weight);
					$exercisedata3['TempWorkout']['coaching_tip']=trim($coaching_tip);
					$exercisedata3['TempWorkout']['added_date']=date('Y-m-d');

					if($exercisedata3['TempWorkout']['exercise']!='') {
						$this->TempWorkout->saveAll($exercisedata3);
					}
					
					
				}
			}
			
		if(!empty($_POST['COOL']))
		{
			foreach ($_POST['COOL'] as $key=>$val)
			{
				$exprd=explode(",",$val[0]);		

				$exerciseA=explode("=",$exprd[0]);
				$exercise=trim(str_replace("'","",$exerciseA[1]));

				$setA=explode("=",$exprd[1]);
				$set=trim(str_replace("'","",$setA[1]));				
				
				$durationA=explode("=",$exprd[2]);
				$duration=trim(str_replace("'","",$durationA[1]));				

				$coaching_tipA=explode("=",$exprd[3]);
				$coaching_tip=trim(str_replace("'","",$coaching_tipA[1]));				
				
				
				$exercisedata4['TempWorkout']['group_id']=$group_id;	
					$exercisedata4['TempWorkout']['exercise_type']="COOL";
					$exercisedata4['TempWorkout']['name']=$workoutname1;  
					$exercisedata4['TempWorkout']['category_id']=$workoutcategory1;
					$exercisedata4['TempWorkout']['trainer_id']=trim($trnid);
					$exercisedata4['TempWorkout']['exercise']=trim($exercise);
					$exercisedata4['TempWorkout']['set']=trim($set);
					$exercisedata4['TempWorkout']['duration']=trim($duration);
					$exercisedata4['TempWorkout']['coaching_tip']=trim($coaching_tip);
					$exercisedata4['TempWorkout']['added_date']=date('Y-m-d');
			
					if($exercisedata4['TempWorkout']['exercise']!='') {
						$this->TempWorkout->saveAll($exercisedata4);
					}  
				
				
			
			}
		}
		
		$callresponse=array('status'=>'True','result'=>"Thanks, you have successfully saved workout.");
		echo $callresponse2=json_encode($callresponse);
		
		exit;

		
		
	}

}