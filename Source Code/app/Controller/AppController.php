<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');



/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them. 
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	public $config     = '';	
	public $helpers    = array("Form","Html","Session");
	public $components = array('Email','Session','RequestHandler','Cookie');
	public $uses 	   = array('Admin','Club','Trainer','Corporation','Trainee');
	public $Email;
	public $settings;
	
	
    
	function _setErrorLayout() {  
	   if ($this->name == 'CakeError') {  
		 $this->layout = 'error404';  
	   }    
	 }              
 
	function beforeRender () {  
	   $this->_setErrorLayout();
	 }
	
    
	public function beforeFilter(){		
		//echo $this->Session->read('UTYPE');
		$this->Cookie->httpOnly = true;
		$this->config = Configure::read('Website');
		$this->Email = new CakeEmail('smtp');	
		$this->disableCache();
		if(isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			$this->layout = $this->params['prefix'];
		}
		if(!$this->Session->check('USER_ID') && $this->Cookie->read('myname') && $this->Cookie->read('mykey') && $this->Cookie->read('myutype')) {
			
			
		
			$cookie['username'] = $this->Cookie->read('myname');
			$cookie['password'] = $this->Cookie->read('mykey');
			$cookie['usertype'] = $this->Cookie->read('myutype');
			$this->set('cookiesDatas',$cookie);
			/*
			$username = trim($cookie['username']);
			 $password = trim($cookie['password']);
			$usertype = trim($cookie['usertype']);
				$condition= array('username'=>$username,'password'=>$password,'status'=>'1');	
							
				if ($usertype!= ''){
				  $dbusertype =$usertype;					  				
				} 
									 
				else{
				    $this->set('notify','error');
					$this->Session->setFlash('Wrong Username or Password!');	
					$this->redirect('/index/');	
			 	}
			 	echo $dbusertype;
			 	
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
						//$this->Cookie->write("myname",$this->data['Login']['username'],false,'+2 weeks');
						//$this->Cookie->write("mykey",$this->data['Login']['password'],false,'+2 weeks');
						
						$this->Session->write('USER_ID', $data_array2['Club']['id']);
						$this->Session->write('USER_NAME', $data_array2['ClubBranch']['username']);
						$this->Session->write('UNAME', $data_array2['ClubBranch']['first_name']);
						$this->Session->write('UTYPE', 'Club');
						
						$vdata=array();
						$vdata[$dbusertype]['id']=$data_array[$dbusertype]['id'];
						$vdata[$dbusertype]['login_status']='1';
						$this->redirect('/clubs/index/');
				         }
					}
					
				}
				
				if (!empty($data_array))
				{	
					//$this->Cookie->write("myname",$this->data['Login']['username'],false,'+2 weeks');
					//$this->Cookie->write("mykey",$this->data['Login']['password'],false,'+2 weeks');
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
					$this->redirect('/clubs/index/');
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
					$this->redirect('/index/');				
				}	

			
			*/
			
		}
		
		if(trim($this->params['action']) != 'admin_login' && trim($this->params['action']) != 'admin_logout' && trim($this->params['action']) != 'admin_forgotpassword'  && $this->params['prefix'] == 'admin' ) {
			$this->checkLogin();
		}
	$servicetype=$this->servicetype=array('Video Call', 'Voice Call', 'IM Session', 'Email Session');
		$this->set(compact('servicetype'));
		
		$this->set('config', $this->config);		
		Configure::write('controller', $this);
		
		$loginData = $this->Admin->find('first', array());
		
		//print_r($loginData['Admin']['on_off']);
		$this->set('corporationshow',$loginData['Admin']['on_off']);
		$this->set('thrtydaysshow',$loginData['Admin']['thirtydaytrial']);
		
		/* Facebook Sign-in */
		/* $this->Auth->authenticate = array(
                'SocialSignIn.Facebook' => array(
                    'userModel' => 'User',
                    'fields' => array('username' => 'facebook_user_id'),
                    'app_id' => '1437941609787896',
                    'app_secret' => '42c7802b4a8e1d8daead1a3e89f42fb3',
                    'redirect_uri' => 'http://www.sampatti.com/fitnessAaland/home/index',
                    'session' => 'FaecbookAuthenticate',
                )
            );
           
        
        $this->helpers['SocialSignIn.Facebook'] = array(
            'app_id' => '1437941609787896',
            'redirect_uri' => 'http://www.sampatti.com/fitnessAaland/home/index',
        );*/
			
	
		
		//echo "<pre>"; 
		//print_r($_SESSION);
	}
	
	
	
	public function checkLogin(){
		if(!$this->Session->check('Admin')) {
			$this->redirect(array('controller'=>'users', 'action'=>'login'));
		}
	}
	
	public function checkUserLogin(){
		if(!$this->Session->check('USER_ID')) {
			$this->redirect('/index/');	
		}
		$id = $this->Session->read('USER_ID');
		$data_read=$this->Trainer->find("first",array("conditions"=>array("Trainer.id"=>$id)));	
		if ($data_read['Trainer']['after_sub_trial_end'] == 1 && $data_read['Trainer']['trainer_type'] == 'I' && ($data_read['Trainer']['subscriptionplan'] == NULL || $data_read['Trainer']['subscriptionplan'] == ""))
		{
			$this->redirect('/home/communication_center');	
		}
		$data_read_club=$this->Club->find("first",array("conditions"=>array("Club.id"=>$id)));
		if ($data_read_club['Club']['after_sub_trial_end'] == 1 && ($data_read_club['Club']['subscriptionplan'] == NULL || $data_read_club['Club']['subscriptionplan'] == ""))
		{
			$this->redirect('/clubs/communication_center');	
		}
		
		
		//echo "<pre>";print_r($datadfjkad);echo "</pre>";
		//die();
	}
	
	
	public function sendEmailMessage($to, $subject, $message, $templete, $layout){
		$this->Email->template($templete, $layout)
		->emailFormat('html')
		->from(array($this->config['email'] => $this->config['base_title_trainer']))
		->to(trim($to))
		->subject(trim($subject))
		->replyTo(array($this->config['email'] => $this->config['base_title_trainer']));
		if($this->Email->send($message)){
			return true;
		}else{
			return false;
		}
	}
	
	public function sendEmailMessageSubsc($to, $subject, $message, $templete, $layout){
		$this->Email->template($templete, $layout)
		->emailFormat('html')
		->from(array($this->config['email'] => $this->config['base_title_mail']))
		->to(trim($to))
		->subject(trim($subject))
		->replyTo(array($this->config['email'] => $this->config['base_title_mail']));
		if($this->Email->send($message)){
			return true;
		}else{
			return false;
		}
	}
	
		public function sendEmailMessageAttachment($to, $subject, $message, $templete, $layout,$attachments){
		$this->Email->template($templete, $layout)
		->emailFormat('html')
		->from(array($this->config['email'] => $this->config['base_title_trainer']))
		->to(trim($to))
		->subject(trim($subject))
		->attachments($attachments)
		->replyTo(array($this->config['email'] => $this->config['base_title_trainer']));
		if($this->Email->send($message)){
			return true;
		}else{
			return false;
		}
	}
	
	public function genPassword(){
		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$pass = '' ;
		while ($i <= 7) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		return $pass;
	}
	
	function rememberUser($data)
	{
		$this->Cookie->write('isRemember',"1",false);
		$this->Cookie->write('user',$data["username"],false);
		$this->Cookie->write('pass',$data["password"],false);
	}
	
	function removeUser(){
			
		$this->Cookie->write('isRemember',"0",false);
		$this->Cookie->write('user',"",false);
		$this->Cookie->write('pass',"",false);
		
	}
	
	function addQuote($dataFields) {
		
		if( is_array($dataFields)){
			foreach($dataFields as $key=>$value){
				$fields[$key] = "'".$value."'";
			}
		}else{
			$fields = "'".$dataFields."'";
		}
		return $fields;
	
	}
	function send_welcome_email($emailaddress,$name,$pass,$lname,$username) {
		App::uses('CakeEmail', 'Network/Email');		
		$email = new CakeEmail();		
		$email->emailFormat('html');
	
	$content = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center"><img src="'.$this->config['url'].'images/logo.png"/></div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Dear '.$name.' '.$lname.'!</p>
				<p>Thanks for the Registration on '.$this->config["base_title"].' site. </p>
				<p>Please find below your login credentials</p>
				<p> Your Enmail is'.' '.$username.'</p>
				<p>Your Password is'.' '.$pass.'</p>
				</td></tr><tr><td><br/>Thanks,<br/>'.$this->config['base_title'].' Team <br/></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
				 
                
		$email->from(array(WEBSITE_FROM_EMAIL => WEBSITENAME));
		$email->to($emailaddress);
		//$email->cc('rprasad@sampatti.com');
		$subtxt = __('Your Registration was Successful.');
		$email->subject($subtxt);
		$email->send($content);
	}
}
?>