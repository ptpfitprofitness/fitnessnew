<?php

##******************************************************************

##  Project		:		Fitness

##  Done by		:		921

##	Create Date	:		03/03/2014

##  Description :		This file contains function related to the index page

## *****************************************************************



App::uses('AppController', 'Controller');



	class IndexController extends AppController {

		public $name 		= 'Index';

		public $helpers 	= array('Html','Session','Cksource');

		public $uses 		= array('Country','Member','Club','Trainer','Corporation','Trainee','CertificationOrganization','Certification','Degree','Page','Nutritional','ClubBranch','Contact','Managemail');

		

		

		public $components  = array('Upload');	

		

		public function index()

		{
           
			$this->layout = 'homelayout';

			$pageContent = $this->Page->find("first",array("conditions"=>array("Page.id"=>2)));

             $this->set('title_for_layout',$pageContent["Page"]["page_title"]);

			$this->set('content',$pageContent["Page"]["page_content"]);

			$this->set('cookieUname',$this->Cookie->read('myname'));

			$this->set('cookieUpwd',$this->Cookie->read('mykey'));
			
			

			if($this->Session->read('USER_ID'))

			{

				$uid=$this->Session->read('USER_ID');

				$dbusertype=$this->Session->read('UTYPE');

			  	$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

		        $this->set("setSpecalistArr",$setSpecalistArr);	

			}

			

			

		}

	 function Login() 

	 { 

				//$this->layout = 'homelayout';

			    //echo "<pre>"; print_r($_POST); echo"</pre>";				    		    

			    $username = trim($this->data['Login']['username']);

				$password = trim($this->data['Login']['password']);

				$usertype = trim($this->data['Login']['usertype']);

				$condition= array('username'=>$username,'password'=>$password,'status'=>'1');	

							

				if ($usertype!= ''){

				  $dbusertype =$usertype;					  				

				} 

									 

				else{

				    $this->set('notify','error');

					$this->Session->setFlash('Wrong Username or Password!');	

					$this->redirect('/index/');	

			 	}

			 	

				$data_array = $this->$dbusertype->find('first',array('conditions'=>$condition));

				

				if($usertype=='Club')

				{

					if(empty($data_array))

					{

						

						$condition= array('ClubBranch.username'=>$username,'ClubBranch.password'=>$password,'ClubBranch.status'=>'1');	

						$data_array2 = $this->ClubBranch->find('first',array('conditions'=>$condition));

						if (!empty($data_array2))

				         {

						$this->Session->write('ClubBr', $data_array2['ClubBranch']['id']);

					

					if ($this->request->data['Login']['remember'] == 1) {	

						

					$this->Cookie->write("myname",$this->data['Login']['username'],false,'+2 weeks');

					$this->Cookie->write("mykey",$this->data['Login']['password'],false,'+2 weeks');

					$this->Cookie->write("myutype",$this->data['Login']['usertype'],false,'+2 weeks');

					}	

						

						$this->Session->write('USER_ID', $data_array2['Club']['id']);

						$this->Session->write('USER_NAME', $data_array2['ClubBranch']['username']);

						$this->Session->write('UNAME', $data_array2['ClubBranch']['first_name']);

						$this->Session->write('UTYPE', 'Club');

						

						$vdata=array();

						$vdata[$dbusertype]['id']=$data_array[$dbusertype]['id'];

						$vdata[$dbusertype]['login_status']='1';

						//$this->redirect('/clubs/communication_center/');
						$this->redirect('/clubs/communication_center_branch/');

				         }

					}

					

				}

				

				if (!empty($data_array))

				{	

					if ($this->request->data['Login']['remember'] == 1) {	

						

					$this->Cookie->write("myname",$this->data['Login']['username'],false,'+2 weeks');

					$this->Cookie->write("mykey",$this->data['Login']['password'],false,'+2 weeks');

					

					$this->Cookie->write("myutype",$this->data['Login']['usertype'],false,'+2 weeks');

					}	

					

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

						

						if($dbusertype=='Trainer'){				

					$this->redirect('/home/communication_center/');

						}	

						if($dbusertype=='Club'){				

					$this->redirect('/clubs/communication_center/');

						}

						if($dbusertype=='Corporation'){				

					$this->redirect('/corporations/index/');

						}

						if($dbusertype=='Trainee'){				

					$this->redirect('/trainees/communication_center/');

						}

					}							

			    }

				else 

				{						

					$this->set('notify','error');

					$this->Session->setFlash('Sorry username/password invalid.');

					$this->redirect('/index/');				

				}	

				

					

	  }

	  

	  function Loginclient() 

	 { 

				//$this->layout = 'homelayout';

			    //echo "<pre>"; print_r($_POST); echo"</pre>";				    		    

			    $username = trim($this->data['Login']['username']);

				$password = trim($this->data['Login']['password']);

				$usertype = trim($this->data['Login']['usertype']);

				$condition= array('username'=>$username,'password'=>$password,'status'=>'1');	

							

				if ($usertype!= ''){

				  $dbusertype =$usertype;					  				

				} 

									 

				else{

				    $this->set('notify','error');

					$this->Session->setFlash('Wrong Username or Password!');	

					$this->redirect($this->referer());

			 	}

			 	

				$data_array = $this->$dbusertype->find('first',array('conditions'=>$condition));

				

				if($usertype=='Club')

				{

					if(empty($data_array))

					{

						

						$condition= array('ClubBranch.username'=>$username,'ClubBranch.password'=>$password);	

						$data_array2 = $this->ClubBranch->find('first',array('conditions'=>$condition));

						if (!empty($data_array2))

				         {

						$this->Session->write('ClubBr', $data_array2['ClubBranch']['id']);

					

					if ($this->request->data['Login']['remember'] == 1) {	

						

					$this->Cookie->write("myname",$this->data['Login']['username'],false,'+2 weeks');

					$this->Cookie->write("mykey",$this->data['Login']['password'],false,'+2 weeks');

					$this->Cookie->write("myutype",$this->data['Login']['usertype'],false,'+2 weeks');

					}	

						

						$this->Session->write('USER_ID', $data_array2['Club']['id']);

						$this->Session->write('USER_NAME', $data_array2['ClubBranch']['username']);

						$this->Session->write('UNAME', $data_array2['ClubBranch']['first_name']);

						$this->Session->write('UTYPE', 'Club');

						

						$vdata=array();

						$vdata[$dbusertype]['id']=$data_array[$dbusertype]['id'];

						$vdata[$dbusertype]['login_status']='1';

						$this->redirect('/clubs/communication_center/');

				         }

					}

					

				}

				

				if (!empty($data_array))

				{	

					if ($this->request->data['Login']['remember'] == 1) {	

						

					$this->Cookie->write("myname",$this->data['Login']['username'],false,'+2 weeks');

					$this->Cookie->write("mykey",$this->data['Login']['password'],false,'+2 weeks');

					

					$this->Cookie->write("myutype",$this->data['Login']['usertype'],false,'+2 weeks');

					}	

					

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

						

						if($dbusertype=='Trainer'){				

					$this->redirect('/home/index/');

						}	

						if($dbusertype=='Club'){				

					$this->redirect('/clubs/communication_center/');

						}

						if($dbusertype=='Corporation'){				

					$this->redirect('/corporations/index/');

						}

						if($dbusertype=='Trainee'){				

					$this->redirect('/trainees/index/');

						}

					}							

			    }

				else 

				{						

					$this->set('notify','error');

					$this->Session->setFlash('Sorry username/password invalid.');

					$this->redirect($this->referer());				

				}	

				

					

	  }

	  

	  		

		public function nutrionalguiderq()

		{	
			
			$mailfetchtype = 'Free Nutritional Guide';
			$condition= array('mails_type'=>$mailfetchtype,'status'=>'1');	
			$mailcontentfetch = $this->Managemail->find('first',array('conditions'=>$condition));
			$this->set("mailcontentfetch",$mailcontentfetch);
			
			$this->layout = "ajax";

			$this->autoRender=false;

			

			if(trim($_POST['fname'])!='' && trim($_POST['lname'])!='' && trim($_POST['email'])!='')

			{

			 

				

				

				

				

							

							$user_names=$_POST['fname'].' '.$_POST['lname'];

							$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$user_names.'!</p>							
							</td></tr><tr><td><br/>'.$mailcontentfetch['Managemail']['content'].' <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
							
							$content_admin = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello Admin!</p>
							<p>A Free Nutritional Guide has been downloaded by a User</p>
							<p>Please Find Below User details</p>
							<p>Name'.' '.$_POST['fname'].' '.$_POST['lname'].'</p>
							<p>Email is'.' '.$_POST['email'].'</p>
							<p>Please find below Attachement for the Nutritional Guides</p>
							</td></tr><tr><td><br/>'.$mailcontentfetch['Managemail']['content'].' <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

									

							

							

													 

							$subject = $mailcontentfetch['Managemail']['subject']; 

						  

							$nutri = $this->Nutritional->find("all",array("fields"=>array("guide_file"),"conditions"=>array("Nutritional.status"=>1)));                  

							$attachments=array();

							foreach($nutri as $key=>$val)

							{

																

								$attachments[]=$this->config["upload_path"].$val['Nutritional']['guide_file'];

								

							}

							

							

								if($_SERVER["REMOTE_ADDR"] == "121.242.47.195" || $_SERVER["REMOTE_ADDR"] == "121.242.47.194" ) { 

									//$this->sendEmailMessageAttachment("synapse235@gmail.com",$subject,$content,null,null,$attachments);
									
									
									$this->sendEmailMessageAttachment($_POST['email'],$subject,$content,null,null,$attachments);
									$this->sendEmailMessageAttachment($this->config['email_admin_guide'],$subject,$content_admin,null,null,$attachments);
									
									echo 'Thanks for the visiting our site, we have sent Nutritional Guides on your email address.';

									exit;

								}else{

									$this->sendEmailMessageAttachment($_POST['email'],$subject,$content,null,null,$attachments);
									
									$this->sendEmailMessageAttachment($this->config['email_admin_guide'],$subject,$content_admin,null,null,$attachments);

									echo 'Thanks for the visiting our site, we have sent Nutritional Guides on your email address.';

									exit;

								}

			             	

							

				       

					

				

				

				

				

				

			

			/*if($this->$dbusertype->save($this->data))

			{

				$this->set("data",'1');

			}

			else {

				$this->set("data",'2');

			}*/

			}else {

				//$this->set("data",'2');

				echo 'Please Enter Valid Data';

				exit;

			}

			

			

		}

	  

	  	  function Logout() {

	  	$dbusertype=$this->Session->read('UTYPE');

	  	$vdata[$dbusertype]['id']=$this->Session->read('USER_ID');

		$vdata[$dbusertype]['login_status']='0';

					if($this->$dbusertype->save($vdata)) {

					

					

					}							

	  	

	  	$this->Session->delete('USER_ID');

	  	$this->Session->delete('USER_NAME');

	  	$this->Session->delete('UNAME');

	  	/*$this->Cookie->delete('myname');

	  	$this->Cookie->delete('mykey');

	  	$this->Cookie->delete('myutype');*/

		$this->Session->destroy();

		$this->Session->setFlash('Logged Out Successfully!');

		$this->redirect('/index/');	

	}

	

	function jointoday(){
			$mailfetchtype = '30 Days Free Trial';
			$condition= array('mails_type'=>$mailfetchtype,'status'=>'1');	
			$mailcontentfetch = $this->Managemail->find('first',array('conditions'=>$condition));
			$this->set("mailcontentfetch",$mailcontentfetch);
			
			/*echo "<pre>";
			print_r($mailcontentfetch);			
			echo "</pre>";
			$mailcontentfetch['Managemail']['content'];
			die('HEre');*/
			//$this->layout='register';
			$this->autoRender=false;
			$response=array();
			//pr($this->request->data);
			//die('Here');
			if(!empty($this->request->data)){
				if($this->request->data['password']===$this->request->data['con_password']){
					if(!empty($this->request->data['user_type'])){
						$data=array();
						if($this->request->data['user_type']=='Club Owner')	{
							$data['Club']['username']=$this->request->data['email'];
							$data['Club']['password']=$this->request->data['password'];
							$data['Club']['con_password']=$this->request->data['con_password'];
							$data['Club']['first_name']=$this->request->data['first_name'];
							$data['Club']['last_name']=$this->request->data['last_name'];
							$data['Club']['email']=$this->request->data['email'];
							$data['Club']['phone']=$this->request->data['phone'];
							$data['Club']['notification_status']= 1;
							/*$data['Club']['cardname']=$this->request->data['cardname'];
							$data['Club']['cardtype']=$this->request->data['cardtype'];
							$data['Club']['cardnumber']=$this->request->data['cardnumber'];
							$data['Club']['exmonth']=$this->request->data['exmonth'];
							$data['Club']['exyear']=$this->request->data['exyear'];
							$data['Club']['cvv']=$this->request->data['cvv']; */
							$data['Club']['status']=1;
							$this->Club->set($this->data);							
							if($this->Club->validates()) {
									if(!empty($data)) {
										if(!empty($data["Club"]["password"]) && ($data["Club"]["password"]==$data["Club"]["con_password"])){
												$data["Club"]["added_date"] = date("Y-m-d h:i:s");
												$data["Club"]["modified_date"] = date("Y-m-d h:i:s");
													if($this->Club->save($data)){	
														$this->send_welcome_email($data["Club"]["email"],$data["Club"]["first_name"],$data["Club"]["password"],$data["Club"]["last_name"],$data["Club"]["username"],$mailcontentfetch['Managemail']['content'],$mailcontentfetch['Managemail']['subject']);	
														$this->send_welcome_email_admin($data["Club"]["email"],$data["Club"]["first_name"],$data["Club"]["password"],$data["Club"]["last_name"],$data["Club"]["username"],$mailcontentfetch['Managemail']['content'],$mailcontentfetch['Managemail']['subject']);
														$this->Session->setFlash('Your account has been created successfully.We have sent welcome mail in your registered email address.');					$dbusertype='Club';						$data_array=array();				$data_array[$dbusertype]['username']=$data["Club"]["username"];				$data_array[$dbusertype]['id']=$this->Club->getLastInsertId();				$data_array[$dbusertype]['first_name']=$data["Club"]["first_name"];				$this->Session->write('USER_ID', $data_array[$dbusertype]['id']);		$this->Session->write('USER_NAME', $data_array[$dbusertype]['username']);	$this->Session->write('UNAME', $data_array[$dbusertype]['first_name']);
														$this->Session->write('UTYPE', $dbusertype);							//$this->redirect('/Clubs/index');
														//$response=array('success'=>'Your registration successful');
														//echo json_encode($response);
														$this->Session->setFlash('Your Registration Successful.');
														$this->redirect('/Clubs/index');
														/*echo "Your Registration Successful.";
														exit();*/
													}
													else{
														$this->Session->setFlash('Some error has been occured. Please try again.');
														//$response=array('error'=>'Some error has been occured. Please try again.');
														//echo json_encode($response);
														//$this->redirect($this->referer());
														echo "Oops some error has been occured.";
														exit();
														}
										}
										else {
										$this->Session->setFlash('Please Enter Confirm  Password same as Password.');
										//$response=array('error'=>'Please Enter Confirm  Password same as Password.');
										//echo json_encode($response);
										echo "Confirm Password Not Matched";
										exit();
										//$this->redirect($this->referer());
										}
									}else{}
									}else{
									echo "Oops some error occured during registration .Please try again!!";
									exit();
									}
						}
						else{
							$data['Trainer']['username']=$this->request->data['email'];
							$data['Trainer']['password']=$this->request->data['password'];
							$data['Trainer']['con_password']=$this->request->data['con_password'];
							$data['Trainer']['first_name']=$this->request->data['first_name'];
							$data['Trainer']['last_name']=$this->request->data['last_name'];
							$data['Trainer']['email']=$this->request->data['email'];
							$data['Trainer']['phone']=$this->request->data['phone'];
							/*$data['Trainer']['cardname']=$this->request->data['cardname'];
							$data['Trainer']['cardtype']=$this->request->data['cardtype'];
							$data['Trainer']['cardnumber']=$this->request->data['cardnumber'];
							$data['Trainer']['exmonth']=$this->request->data['exmonth'];
							$data['Trainer']['exyear']=$this->request->data['exyear'];
							$data['Trainer']['cvv']=$this->request->data['cvv'];*/							
							$data['Trainer']['status']=1;
							$this->Trainer->set($data);
							if($this->Trainer->validates()) {
								if(!empty($data)) {
									if(!empty($data["Trainer"]["password"]) && ($data["Trainer"]["password"]==$data["Trainer"]["con_password"])) {
										$data["Trainer"]["added_date"]= date("Y-m-d h:i:s");
										$data["Trainer"]["modified_date"] = date("Y-m-d h:i:s");
										if($this->Trainer->save($data))	{
											$this->send_welcome_email_trainer($data["Trainer"]["email"],$data["Trainer"]["first_name"],$data["Trainer"]["password"],$data["Trainer"]["last_name"],$data["Trainer"]["username"],$mailcontentfetch['Managemail']['content'],$mailcontentfetch['Managemail']['subject']);
											
											$this->send_welcome_email_admin($data["Trainer"]["email"],$data["Trainer"]["first_name"],$data["Trainer"]["password"],$data["Trainer"]["last_name"],$data["Trainer"]["username"],$mailcontentfetch['Managemail']['content'],$mailcontentfetch['Managemail']['subject']);
											$this->Session->setFlash('Your account has been created successfully.We have sent welcome mail in your registered email address.');				$dbusertype='Trainer';						$data_array=array();							$data_array[$dbusertype]['username']=$data["Trainer"]["username"];
											$data_array[$dbusertype]['id']=$this->Trainer->getLastInsertId();							$data_array[$dbusertype]['first_name']=$data["Trainer"]["first_name"];							$this->Session->write('USER_ID', $data_array[$dbusertype]['id']);
											$this->Session->write('USER_NAME', $data_array[$dbusertype]['username']);
											$this->Session->write('UNAME', $data_array[$dbusertype]['first_name']);
											$this->Session->write('UTYPE', $dbusertype);
											$this->Session->setFlash('Your Registration Successful.');
											$this->redirect('/home/index');
											//echo "Your Registration Successful.";				//exit();					//$response=array('success'=>'Your Registration Successful.');
											//echo json_encode($response);							//$this->redirect('/home/index');
										}
										else {
										$this->Session->setFlash('Some error has been occured. Please try again.');						//$response=array('error'=>'Some error has been occured. Please try again.');
										//echo json_encode($response);
										echo "Oops some error has been occured.";				exit();
										}//}	
									}
									else {
										$this->Session->setFlash('Please Enter Confirm  Password same as Password.');			//$response=array('error'=>'Please Enter Confirm  Password same as Password.');
										//echo json_encode($response);
										//$this->redirect($this->referer());
										echo "Confirm Password Not Matched";
										exit();
										}

								}else{}
							}
							else {
							echo "Oops some error occured during registration .Please try again!!";
							exit();
							}
						}

					}

				}

				else {
				$this->Session->setFlash('Please Enter Confirm  Password same as Password.');
				$this->redirect($this->referer());
				}
			}

		}

		function send_welcome_email($emailaddress,$name,$pass,$lname,$username,$mail_con,$mail_sub) {

		App::uses('CakeEmail', 'Network/Email');		

		$email = new CakeEmail();		

		$email->emailFormat('html');		
	
		$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$name.' '.$lname.'!</p>

				
				<p>Please find below your login credentials</p>

				<p> Your Email is'.' '.$username.'</p>

				<p>Your Password is'.' '.$pass.'</p>

				</td></tr><tr><td><br/>'.$mail_con.' <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';	 
            

		$email->from(array(WEBSITE_FROM_EMAIL => WEBSITENAME));

		$email->to($emailaddress);

		//$email->cc('rprasad@sampatti.com');

		$subtxt = __($mail_sub);

		$email->subject($mail_sub);

		$email->send($content);

	}
	
	
	function send_welcome_email_trainer($emailaddress,$name,$pass,$lname,$username,$mail_con,$mail_sub) {

		App::uses('CakeEmail', 'Network/Email');		

		$email = new CakeEmail();		

		$email->emailFormat('html');		
	
		$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$name.' '.$lname.'!</p>

				
				</td></tr><tr><td><br/>'.$mail_con.' <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';	 
            

		$email->from(array(WEBSITE_FROM_EMAIL => WEBSITENAME));

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

				<p>A user with following details has been registered for 30 Day Free trial on '.$this->config["base_title"].' site. </p>

				<p>Please find below the login credentials</p>

				<p>Email is'.' '.$username.'</p>

				<p>Password is'.' '.$pass.'</p>

				</td></tr><tr><td><br/>'.$mail_con.' <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';	 
            

		$email->from(array(WEBSITE_FROM_EMAIL => WEBSITENAME));

		$email->to($this->config['email_admin_free_trial']);

		//$email->cc('rprasad@sampatti.com');

		$subtxt = __('30 Day Free Trial New User Registration');

		$email->subject($subtxt);

		$email->send($content);

	}

		public function contactus(){

			$this->layout = "homelayout";

			

			if($this->Session->read('USER_ID'))

			{

			$dbusertype = $this->Session->read('UTYPE');					

		$this->set("dbusertype",$dbusertype);

		$uid = $this->Session->read('USER_ID');		

				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));

				$this->set("setSpecalistArr",$setSpecalistArr);

			}	

		}

		public function contact()

		{

			$this->autoRender=false;

			$response=array();



			//pr($this->request->data);

			//die('Here');

			if(!empty($this->request->data)){

				$usernm=trim($_POST['first_name']).' '.trim($_POST['last_name']);

				$to=$this->config["emailto"];

				

				$dataArr=array();

				$dataArr['Contact']['first_name']=trim($_POST['first_name']);

				$dataArr['Contact']['last_name']=trim($_POST['last_name']);

				$dataArr['Contact']['email']=trim($_POST['email']);

				$dataArr['Contact']['phone']=trim($_POST['phone']);

				$dataArr['Contact']['comment']=trim($_POST['comments']);

				$dataArr['Contact']['added_date']=date('Y-m-d H:i:s');

				if($this->Contact->save($dataArr))

				{

				

				$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello Admin!</p>

				<p>'.$usernm.' sent query. </p>

				<p>Please find below User detail and query.</p>

				<p>Name : '.$usernm.'</p>

				<p>Email : '.trim($_POST['email']).'</p>';

				if(trim($_POST['phone'])!='')

				{

				  $content .= '<p>Phone : '.trim($_POST['phone']).'</p>';	

				}

				 $content .= '<p>Query/comment : '.trim($_POST['comments']).'</p>';

				$content .= '</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

									

							

							

													 

							$subject = $this->config["base_title"]." : User Query"; 

						  

							

				

				$this->sendEmailMessage($to,$subject,$content,null,null);

									echo 'Thanks for the visiting our site, our customer support team will contact you shortly.';

				}

				

				else {

					echo 'Sorry, some issue occur. Please try again!!';

				}

					

				}

				else {

					echo 'Please Enter Valid Data.';

				}

				

			

		}

		

		public function admin_contactrequest($status = null)

		{			

			//echo "hello23";

			

			$conditions = array();

			$keyword 	= ""; 

			

			if(!empty($this->data)){				

				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by First Name OR Last Name...") ) {					

					$conditions["OR"] = array(

												"Contact.first_name LIKE" => "%".$this->data["keyword"]."%",

												"Contact.last_name LIKE" => "%".$this->data["keyword"]."%"

											);

					if( !empty($this->params["named"]["keyword"]) )						

						$keyword = $this->params["named"]["keyword"];					

					

				}else{						

						if( !empty($this->data['Contact']['statusTop']) ) {

							$action = $this->data['Contact']['statusTop'];

						}elseif( !empty($this->data['Contact']['status'])) {

							$action = $this->data['Contact']['status'];

						}

						

						if(isset($this->data['Contact']['id']) && count($this->data['Contact']['id']) > 0) {

							$this->update_status(trim($action), $this->data['Contact']['id'], count($this->data['Contact']['id']));

						} else {

							

							

							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by First Name OR Last Name...') && $this->data["submit"]=='Search'){

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

									"Contact.first_name LIKE" => "%".$this->params["named"]["keyword"]."%",

									"Contact.last_name LIKE" => "%".$this->params["named"]["keyword"]."%"

								);

				$keyword = $this->params["named"]["keyword"];

			}			

					

			

			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('Contact.first_name' => 'ASC'));

			$exerciselib = $this->paginate('Contact'); //default take the current

			$this->set('contactslist', $exerciselib);

			$this->set('mode', array('delete'=>'Delete'));

			$this->set('status', $status);

			$this->set('tab', '');

			$this->set('keyword', $keyword);

//			

//			

			$this->set('limit', $this->params['request']['paging']['Contact']['options']['limit']);

			$this->set('page', $this->params['request']['paging']['Contact']['options']['page']);

		}

		

			public function update_status($status, $ids, $count){



			switch(trim($status)){

				case "activate":

					for($ctr=0;$ctr<$count;$ctr++){

						$this->Contact->id = $ids[$ctr];

						$this->Contact->saveField("status", '1');

					}

					$this->Session->setFlash('Query has been activated successfully.');

					break;

				case "deactivate":

					for($ctr=0;$ctr<$count;$ctr++){

						$this->Contact->id = $ids[$ctr];

						$this->Contact->saveField("status", '0');

					}

					$this->Session->setFlash('Query has been deactivated successfully.');

					break;

				case "delete":

					for($i=0;$i<$count;$i++){

						$this->Contact->create();

						$this->Contact->id = $ids[$i];

						

						$this->Contact->delete($ids[$i]);

						

					}

					$this->Session->setFlash('Query has been deleted successfully.');

					break;

			}

		}



		



		

	  



}