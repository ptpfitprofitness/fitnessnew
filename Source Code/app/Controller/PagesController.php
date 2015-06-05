<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		This file contains function static pages
## *****************************************************************

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
	class PagesController extends AppController {

	/*** Controller name
	*
	* @var string
	*/
	public $name = 'Pages';

	/**
	* Default helper
	*
	* @var array
	*/
	public $helpers = array('Html', 'Session','Cksource');
	
	/**
	* This controller does not use a model
	*
	* @var array
	*/
	public $uses 		= array('Country','Member','Club','Trainer','Corporation','Trainee','CertificationOrganization','Certification','Degree','Page');

	/**
	* Displays a view
	*
	* @param mixed What page to display
	* @return void
	*/
	
	public function display() 
	{
		//$this->layout = "pageslayout";
		$this->layout = "homelayout";
		if( !empty($this->params->url) ) {
			$pageContent = $this->Page->find("first",array("conditions"=>array("Page.page_slug"=>$this->params->url)));
			//echo "<pre>"; print_r($pageContent); echo "</pre>";	
			if($this->Session->read('USER_ID'))
			{
			$dbusertype = $this->Session->read('UTYPE');					
		$this->set("dbusertype",$dbusertype);
		$uid = $this->Session->read('USER_ID');		
				$setSpecalistArr=$this->$dbusertype->find("first",array("conditions"=>array("$dbusertype.id"=>$uid)));
				$this->set("setSpecalistArr",$setSpecalistArr);
			}
					
			if( !empty($pageContent) ) {	
				if(isset($_COOKIE["language"]) && $_COOKIE["language"]=='en_UK')
				{			
				$this->set('title_for_layout',$pageContent["Page"]["page_title"]);
				$this->set('content',$pageContent["Page"]["page_content_uk"]);
				
				}
				else {
				 $this->set('title_for_layout',$pageContent["Page"]["page_title"]);
				$this->set('content',$pageContent["Page"]["page_content"]);
				}
			}else{
				$this->redirect($this->config["url"]);
			}
		}else{
			$this->redirect($this->config["url"]);
		}	 
	}
	
	
	public function admin_add(){
		
	}
	public function admin_edit($id = null){
		
		if(!empty($this->data)){
		$this->Page->set($this->data);
		if($this->Page->validates()) {	
				if($this->Page->save($this->data)) {
					$this->Session->setFlash('Page information has been updated successfully.');
					$this->redirect('/admin/pages/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
					//$this->redirect('/admin/pages/');
				}
		}	
	 }else{
			if(is_numeric($id) && $id > 0) {
					$this->Page->id = $id;
					$this->request->data = $this->Page->read();
				} else {
					$this->Session->setFlash('Invalid content id.');
					$this->redirect('/admin/pages/');
			}
	 	}	
	}
	
	public function admin_index($status = null){

		if(!empty($this->data)){
			// check for status change
			if(isset($this->data['Page']['submit']) && trim($this->data['Page']['submit']) == 'Submit') {
				if(isset($this->data['Page']['id']) && count($this->data['Page']['id']) > 0){
					$this->update_status(trim($this->data['Page']['status']), $this->data['Page']['id'], count($this->data['Page']['id']));
				} else {
					$this->Session->setFlash('Please select any checkbox to perform any action.');
				}
			}
		}
		
		$this->paginate = array('limit' => '20', 'order' => array('Page.id' => 'ASC'));
		$pages = $this->paginate('Page'); //default take the current
		$this->set('pages', $pages);
		$this->set('mode', array('delete'=>'Delete'));
		$this->set('status', $status);
		
		
		$this->set('limit', $this->params['request']['paging']['Page']['options']['limit']);
		$this->set('page', $this->params['request']['paging']['Page']['options']['page']);
	}
	
	public function admin_validslug(){
		$this->layout = '';
		$this->autoRender = false;
		if(isset($_GET['fieldId'])){
			$validateValue = $_GET['fieldValue'];
			$validateId = $_GET['fieldId'];
			$arrayToJs = array();
			$arrayToJs[0] = $validateId;
			$dataCheck = $this->Page->find('all', array('conditions'=>array('Page.page_slug'=>trim($validateValue))));
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
	public function checkCaptchacode(){
		
		$this->layout = '';
		$this->autoRender = false;
		if(isset($_GET['fieldId'])){
			$validateValue = $_GET['fieldValue'];
			$validateId = $_GET['fieldId'];
			$arrayToJs = array();
			$arrayToJs[0] = $validateId;
			
			if($this->Session->read('captcha') == $validateValue){ // validate??
				$arrayToJs[1] = true; // RETURN TRUE
				echo json_encode($arrayToJs); // RETURN ARRAY WITH success
			}else{
				$arrayToJs[1] = false; // RETURN false
				echo json_encode($arrayToJs); // RETURN ARRAY WITH success
			}
		}
		
		exit;		
	}
}
