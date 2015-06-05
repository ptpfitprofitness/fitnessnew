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
	class LibrarysController extends AppController {

		public $name 		= 'Librarys';
		public $helpers 	= array('Html','Session','Cksource');
		public $uses 		= array('Country','ExerciseLibrary','PhotosLibrary');
		public $components  = array('Upload');			
		public $facebook;
		public $amazon;
	    
		
		
	/**************Exercise Library Start Here******************/
	
		public function admin_exerciselibrary($status = null)
		{			
			//echo "hello23";
			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by type or Name...") ) {					
					$conditions["OR"] = array(
												"ExerciseLibrary.doc_name LIKE" => "%".$this->data["keyword"]."%",
												"ExerciseLibrary.doc_name LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['ExerciseLibrary']['statusTop']) ) {
							$action = $this->data['ExerciseLibrary']['statusTop'];
						}elseif( !empty($this->data['ExerciseLibrary']['status'])) {
							$action = $this->data['ExerciseLibrary']['status'];
						}
						
						if(isset($this->data['ExerciseLibrary']['id']) && count($this->data['ExerciseLibrary']['id']) > 0) {
							$this->update_status(trim($action), $this->data['ExerciseLibrary']['id'], count($this->data['ExerciseLibrary']['id']));
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
									"ExerciseLibrary.doc_name LIKE" => "%".$this->params["named"]["keyword"]."%",
									"ExerciseLibrary.doc_name LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('ExerciseLibrary.doc_name' => 'ASC'));
			$exerciselib = $this->paginate('ExerciseLibrary'); //default take the current
			$this->set('branches', $exerciselib);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
//			
//			
			$this->set('limit', $this->params['request']['paging']['ExerciseLibrary']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['ExerciseLibrary']['options']['page']);
		}
		public function admin_addlibrary(){
			
			
			if(!empty($this->data)) {
		
				$this->ExerciseLibrary->set($this->data);
				if($this->ExerciseLibrary->validates()) {
					
									
							 $this->request->data["ExerciseLibrary"]["video_name"]=$this->data["ExerciseLibrary"]["video_file"];						
					  
						$this->request->data["ExerciseLibrary"]["added_date"] 		    = date("Y-m-d h:i:s");
						
					    	
					   
						if($this->ExerciseLibrary->save($this->request->data)) 
						{
							
								
						$this->Session->setFlash('Library has been created successfully.');
							$this->redirect('/admin/librarys/exerciselibrary/');
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
				$setVideoArr=$this->ExerciseLibrary->find("first",array("conditions"=>array("ExerciseLibrary.id"=>$vid)));
				$videoName=$setVideoArr['ExerciseLibrary']['video_name'];
				$this->set("videoname",$videoName);
				$this->set("setVideoArr",$setVideoArr);
			}
		}
		
		public function admin_viewlibrary(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("foodInfo",$this->ExerciseLibrary->find("first",array("conditions"=>array("ExerciseLibrary.id"=>$this->params["pass"][0]))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_editlibrary($id = null)
		{
						
			if(!empty($this->data)){
			$id=base64_decode($id);
			$this->set("id",$id);
			$this->ExerciseLibrary->set($this->data);
			$this->ExerciseLibrary->id = $this->data['ExerciseLibrary']['id'];		
			
							
			if($this->ExerciseLibrary->validates()) {
				
				
				
				
				$dir = WWW_ROOT.'video';
    	
    	    $target_pathdir = $dir.'/'.$this->data["ExerciseLibrary"]["video_name"]["name"]; 
   	

    	   if(move_uploaded_file($_FILES['data']['tmp_name']["ExerciseLibrary"]["video_name"], $target_pathdir)) {
           
    		
            
    		$this->request->data["ExerciseLibrary"]["video_name"]=$this->request->data["ExerciseLibrary"]["video_name"]["name"];
    		
    		 
          }

					   else{	
					
					if(!empty($this->request->data["ExerciseLibrary"]["old_video"])){
						$this->request->data["ExerciseLibrary"]["video_name"] = $this->request->data["ExerciseLibrary"]["old_video"];			
					}
					else{
						$this->request->data["ExerciseLibrary"]["video_name"] = "";
					}
				}
					       
					    
					    
				    $this->request->data["ExerciseLibrary"]["added_date"] 		    = date("Y-m-d h:i:s");
						
				if($this->ExerciseLibrary->save($this->data)) {
					
					
					$this->Session->setFlash('Library information has been updated successfully.');
					$this->redirect('/admin/librarys/exerciselibrary/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
							
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->ExerciseLibrary->id = $id;
						$this->request->data = $this->ExerciseLibrary->read();
					} else {
						$this->Session->setFlash('Invalid Library id.');
						$this->redirect('/admin/librarys/exerciselibrary/');
				}
			}	
		}
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->ExerciseLibrary->id = $ids[$ctr];
						$this->ExerciseLibrary->saveField("status", '1');
					}
					$this->Session->setFlash('Library(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->ExerciseLibrary->id = $ids[$ctr];
						$this->ExerciseLibrary->saveField("status", '0');
					}
					$this->Session->setFlash('Library(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->ExerciseLibrary->create();
						$this->ExerciseLibrary->id = $ids[$i];
						
						$this->ExerciseLibrary->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Library(s) has been deleted successfully.');
					break;
			}
		}
	
		
	}