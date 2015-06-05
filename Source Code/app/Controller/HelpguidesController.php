<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		25/04/2014
##  Description :		This file contains function for Exercise Library
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
	class HelpguidesController extends AppController {

		public $name 		= 'Helpguides';
		public $helpers 	= array('Html','Session','Cksource');
		public $uses 		= array('Country','HelpGuide','PhotosLibrary');
		public $components  = array('Upload');			
		
	    
		
		
	/**************Exercise Library Start Here******************/
	
		public function admin_helpguide($status = null)
		{			
			//echo "hello23";
			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by type or Name...") ) {					
					$conditions["OR"] = array(
												"HelpGuide.doc_name LIKE" => "%".$this->data["keyword"]."%",
												"HelpGuide.doc_name LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['HelpGuide']['statusTop']) ) {
							$action = $this->data['HelpGuide']['statusTop'];
						}elseif( !empty($this->data['HelpGuide']['status'])) {
							$action = $this->data['HelpGuide']['status'];
						}
						
						if(isset($this->data['HelpGuide']['id']) && count($this->data['HelpGuide']['id']) > 0) {
							$this->update_status(trim($action), $this->data['HelpGuide']['id'], count($this->data['HelpGuide']['id']));
						} else {
							
							
							if(isset($this->data["submit"]) && isset($this->data["keyword"]) && ($this->data["keyword"]=='' || $this->data["keyword"]=='Search by type or Name...') && $this->data["submit"]=='Search'){
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
									"HelpGuide.doc_name LIKE" => "%".$this->params["named"]["keyword"]."%",
									"HelpGuide.doc_name LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('HelpGuide.doc_name' => 'ASC'));
			$exerciselib = $this->paginate('HelpGuide'); //default take the current
			$this->set('branches', $exerciselib);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
//			
//			
			$this->set('limit', $this->params['request']['paging']['HelpGuide']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['HelpGuide']['options']['page']);
		}
		public function admin_addhelpguide(){
			
			
			if(!empty($this->data)) {
			/*echo "<pre>";
			print_r($this->data);
			echo "</pre>";
			die();*/
				
				$this->HelpGuide->set($this->data);
				if($this->HelpGuide->validates()) {
					
									
							 $this->request->data["HelpGuide"]["video_name"]=$this->data["HelpGuide"]["video_file"];						
					  
						$this->request->data["HelpGuide"]["added_date"] 		    = date("Y-m-d h:i:s");
						
					    //$this->request->data["HelpGuide"]["video_url"] = $_FILES["Filedata"]["name"];
					   
						if($this->HelpGuide->save($this->request->data)) 
						{
							
								
						$this->Session->setFlash('Video has been created successfully.');
							$this->redirect('/admin/Helpguides/helpguide/');
						}
						//}
				
				 else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		/*It will upload the video to the webroor/uploads/exercise folder
		*The selected video can be converted into flv format and stores the video in specified location.
		*/
		public function uploadVideo() {			
			$return=0;
			try{					
				if(!empty($_FILES["Filedata"]["name"]) ){
					$extension = explode(".",$_FILES["Filedata"]["name"]);
					$count     = count($extension);
					$count--;
					$temp_name="exercise_".substr(time(),0,5).substr(rand(),0,5).".";
					$name   = $temp_name.$extension[$count];
					$flv_name   = $temp_name."flv";
					
					$temp_target = '/var/www/html/app/webroot/plupload/'.$name;
					
					
					if(move_uploaded_file($_FILES["Filedata"]["tmp_name"],$temp_target)){
						
					 $input=$temp_target;
					 //$target = '/var/www/html/app/webroot/plupload/'.$flv_name;	
					 $target = '/var/www/html/app/webroot/plupload/'.$name;	
					 /*$temp_ext=strpos($temp_target, '.flv');
						
						if($temp_ext<=0 || $temp_ext=="") {													
							//echo exec("/usr/local/bin/ffmpeg -i $input -f flv -b 768 -ar 22050 -ab 96 -s 1024x720 $target");		
							echo exec("/usr/bin/ffmpeg -i $input -f flv -b 768 -ar 22050 -ab 96 -s 1024x720 $target");		
						
							if(file_exists($temp_target)) {
								@unlink($temp_target);
							}
						}*/
						$return=$name;
					}
					else { echo "Not Uploaded, Try Again!!"; exit; }
					
					echo $return;	
					//echo $name;	
					exit;
				}
				else { echo "Not Uploaded, Try Again!!"; exit;}
			}
			catch(Exception $e)
			{
				echo $e;
				die;
			}
		}
		
		public function viewvideo($videos=null)
		{
			$this->layout = "ajax";
			if($videos!='')
			{
				//ExerciseLibrary
				$vid=base64_decode($videos);
				$setVideoArr=$this->HelpGuide->find("first",array("conditions"=>array("HelpGuide.id"=>$vid)));
				$videoName=$setVideoArr['HelpGuide']['video_name'];
				$this->set("videoname",$videoName);
				$this->set("setVideoArr",$setVideoArr);
			}
		}
		
		public function admin_viewlibrary(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("foodInfo",$this->HelpGuide->find("first",array("conditions"=>array("HelpGuide.id"=>$this->params["pass"][0]))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_edithelpguide($id = null)
		{
						
			if(!empty($this->data)){
			$id=base64_decode($id);
			$this->set("id",$id);
			$this->HelpGuide->set($this->data);
			$this->HelpGuide->id = $this->data['HelpGuide']['id'];		
			
							
			if($this->HelpGuide->validates()) {
				
				
				
				
				$dir = WWW_ROOT.'video';
    	
    	    $target_pathdir = $dir.'/'.$this->data["HelpGuide"]["video_name"]["name"]; 
   	

    	   if(move_uploaded_file($_FILES['data']['tmp_name']["HelpGuide"]["video_name"], $target_pathdir)) {
           
    		
            
    		$this->request->data["HelpGuide"]["video_name"]=$this->request->data["HelpGuide"]["video_name"]["name"];
    		
    		 
          }

					   else{	
					
					if(!empty($this->request->data["HelpGuide"]["old_video"])){
						$this->request->data["HelpGuide"]["video_name"] = $this->request->data["HelpGuide"]["old_video"];			
					}
					else{
						$this->request->data["HelpGuide"]["video_name"] = "";
					}
				}
					       
					    
					    
				    $this->request->data["HelpGuide"]["added_date"] 		    = date("Y-m-d h:i:s");
						
				if($this->HelpGuide->save($this->data)) {
					
					
					$this->Session->setFlash('Video information has been updated successfully.');
					$this->redirect('/admin/helpguides/helpguide/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
							
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->HelpGuide->id = $id;
						$this->request->data = $this->HelpGuide->read();
					} else {
						$this->Session->setFlash('Invalid Video id.');
						$this->redirect('/admin/helpguides/helpguide/');
				}
			}	
		}
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->HelpGuide->id = $ids[$ctr];
						$this->HelpGuide->saveField("status", '1');
					}
					$this->Session->setFlash('Video(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->HelpGuide->id = $ids[$ctr];
						$this->HelpGuide->saveField("status", '0');
					}
					$this->Session->setFlash('Video(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->HelpGuide->create();
						$this->HelpGuide->id = $ids[$i];
						
						$this->HelpGuide->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Video(s) has been deleted successfully.');
					break;
			}
		}
	
		
	}