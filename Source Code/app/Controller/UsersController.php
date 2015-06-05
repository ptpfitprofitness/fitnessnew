<?php
##***********************************************************************
## Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		This file contains function related to the users
## ************************************************************************

App::uses('AppController', 'Controller'); 

/** 
 * Static content controller 
 *
 * Override this controller by placing a copy in controllers directory of an application 
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html 
 */
class UsersController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Users';

/**
 * Default helper
 *
 * @var array
 */
	public $helpers = array('Html', 'Session');

	
	
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Member', 'Admin','Country');

/**
 * Displays a view 
 *
 * @param mixed What page to display
 * @return void
 */

	/**
	*Summary of Method: 	function to login into admin
	*created date: 			10th Aug 2013      	              
	*created by:			313
	*Database Table Access:	admins
	*last modified date:    
	*last modified by:		
	*/

	public function admin_login(){
		
		$this->layout = '';
		
		if(!empty($this->data)){
			$loginData = $this->Admin->find('all', array('conditions'=>array('Admin.login'=>trim($this->data['Admin']['login']), 'Admin.password'=>md5(trim($this->data['Admin']['password'])))));
		
			if(count($loginData) > 0){
				$this->Session->write('Admin', $loginData[0]);
				$this->redirect(array('controller'=>'users', 'action'=>'index'));
			}else{
				$this->set('errorMessage' , 'Username or password is invalid.');
			}
		}
		
	}
	
	/**
	*Summary of Method: 	function to display the application statistics
	*created date: 			10th Aug 2013      	              
	*created by:			313
	*Database Table Access:	members
	*last modified date:    
	*last modified by:		
	*/
	
	public function admin_index(){
		
	}
	
	/**
	*Summary of Method: 	function to logout from the admin
	*created date: 			10th Aug 2013  	              
	*created by:			313
	*Database Table Access:	admins
	*last modified date:    
	*last modified by:		
	*/
	
	public function admin_logout(){
		if($this->Session->check('Admin')){
			$this->Session->delete('Admin');
		}
		$this->set('errorMessage' , 'You have logout successfully.');
		$this->redirect(array('controller'=>'users', 'action'=>'login'));
	}
	
	/**
	*Summary of Method: 	function to retrieve the admin password
	*created date: 			09th Aug 2013  	              
	*created by:			313
	*Database Table Access:	admins
	*last modified date:    
	*last modified by:		
	*/
	
	public function admin_forgotpassword() {
		$this->layout = '';
		
		if(!empty($this->data)){
			$this->Admin->set($this->data);
			if($this->Admin->validates()){
				$this->Admin->email = $this->data['Admin']['email'];
				$admin_data = $this->Admin->find('all', array('conditions'=>array('Admin.email'=>$this->data['Admin']['email'])));
				if(count($admin_data) > 0){
					$message  = '';
					$admin_data = $admin_data[0];
					$new_pass = $this->genPassword();
					$message .= 'Hi '.$admin_data['Admin']['name'].", \n\n";
					$message .= 'Admin password for '.$this->config['base_title'] . ' has been changed,'."\n\n";
					$message .= 'Below are the updated login details:'."\n\n";
					$message .= 'UserName: ' . $admin_data['Admin']['login'] . "\n\n";
					$message .= 'Password: ' . $new_pass . "\n\n";
					
					if($this->sendEmailMessage($admin_data['Admin']['email'], $this->config['base_title']." : Admin Panel reset Password", $message, 'forgotpassword', 'admin_mail')){
						$this->Admin->id = $admin_data['Admin']['id'];
						$this->Admin->saveField('password', md5($new_pass));
						$this->Session->setFlash('Password has sent to email');
					}
										
				}else{
					$this->set('errorMessage', "Invalid Email Address");
				}
			}
		}
	}
	
	/**
	*Summary of Method: 	function to change the admin password
	*created date: 			10th Aug 2013 	              
	*created by:			313
	*Database Table Access:	admins
	*last modified date:    
	*last modified by:		
	*/
	
	public function admin_changepassword() {

		if(!empty($this->data)){
			$adminData = $this->Session->read('Admin');

			$this->Admin->set($this->data);

			if($this->Admin->validates(array('fieldList'=>array('old_password','new_password','confirm_password'))))
			{
				$validate_old_password = $this->Admin->find('all', array('conditions'=>array('Admin.password'=>md5($this->data['Admin']['old_password']), 'Admin.email'=>$adminData['Admin']['email'])));
				if(count($validate_old_password) > 0){
					$this->Admin->id = $validate_old_password[0]['Admin']['id'];
					$this->Admin->saveField('password', md5($this->data['Admin']['new_password']));
					$this->Session->setFlash('Password has been changed successfully');					
					$this->redirect(array('controller'=>'users', 'action'=>'changepassword'));
				}else{

					$this->set('errorMessage', "Current password is wrong !");
				}

			}

			
		}
	}
	
	/**
	*Summary of Method: 	function to update the admin basic information
	*created date: 			10th Aug 2013     	              
	*created by:			313
	*Database Table Access:	admins
	*last modified date:    
	*last modified by:		
	*/
	
	public function admin_updateprofile(){
		if(!empty($this->data)){
			$session_data = $this->Session->read('Admin');
			
			$this->Admin->save($this->data);
			$session_data['Admin'] = $this->data['Admin'];
			$this->Session->write('Admin', $session_data);
			//echo "<pre>";print_r($session_data);echo "</pre>"; die();
			$this->Session->setFlash('Profile has been updated successfully');
		}else{
			$this->data = $this->Session->read('Admin');
		}
	}
	
	/**
	*Summary of Method: 	List of users.
	*created date: 			10th Aug 2013      	              
	*created by:			313
	*Database Table Access:	members
	*last modified date:    	 
	*last modified by:		
	*/
	
	public function admin_list(){
		
		if(!empty($this->data)){
			if(isset($this->data['Member']['id']) && count($this->data['Member']['id']) > 0){
				
				$this->update_status(trim($this->data['Member']['status']), $this->data['Member']['id'], count($this->data['Member']['id']));
				
			} else {
				$this->Session->setFlash('Please select any checkbox to perform any action.');
			}
		}	
		
		$this->paginate = array('limit' => '10', 'order' => array('Member.created' => 'DESC'));
		$members = $this->paginate('Member'); //default take the current
		$this->set('members', $members);

		$this->set('limit', $this->params['request']['paging']['Member']['options']['limit']);
		$this->set('page', $this->params['request']['paging']['Member']['options']['page']);
	}
	
	
	/**
	*Summary of Method: 	To update the status for the member i.e. activate [1], deactivate [2] and deletion from database
	*created date: 			10th aug 2013     	              
	*created by:			313
	*Database Table Access:	members
	*last modified date:    
	*last modified by:		
	*/
	
	public function update_status($status, $ids, $count){

		switch(trim($status)){
			case "activate":
				for($ctr=0;$ctr<$count;$ctr++){
					$this->Member->id = $ids[$ctr];
					$this->Member->saveField("status", '1');
				}
				$this->Session->setFlash('Member(s) has been activated successfully.');
				break;
			case "deactivate":
				for($ctr=0;$ctr<$count;$ctr++){
					$this->Member->id = $ids[$ctr];
					$this->Member->saveField("status", '2');
				}
				$this->Session->setFlash('Member(s) has been deactivated successfully.');
				break;
			case "delete":
				for($i=0;$i<$count;$i++){
					$this->Member->create();
					$this->Member->id = $ids[$i];
					$this->Member->saveField("status", '4');
					
				}
				
				$this->Session->setFlash('Member(s) has been deleted successfully.');
				break;
		}
	}
	
	
	/**
	*Summary of Method: 	View the details of user.
	*created date: 			10th Aug 2013     	              
	*created by:			313
	*Database Table Access:	members
	*last modified date:    
	*last modified by:		
	*/
	
	public function admin_view($id = null){
		
		
		
	}
	
	public function registration() {
	
		$this->layout = "marketplace_inner";
		if($this->data){
			
		}		
		$this->set("country",$this->Country->find("list"));
	
	}
	
}
