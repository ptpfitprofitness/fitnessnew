<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		This file contains function for clubs
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
	class FoodsController extends AppController {

		public $name 		= 'Foods';
		public $helpers 	= array('Html','Session','Cksource');
		public $uses 		= array('Country','FoodNutritionLog','FoodUsda');
		public $components  = array('Upload');			
		public $facebook;
		public $amazon;
	
		
		
	/**************Food Nutrition lOG Start Here******************/
	
		public function admin_food($status = null)
		{			
			$conditions = array();
			$keyword 	= ""; 
			
			if(!empty($this->data)){				
				if( array_key_exists("keyword",$this->data) && !empty($this->data["keyword"]) && ($this->data["keyword"] != "Search by type or Name...") ) {					
					$conditions["OR"] = array(
												"FoodNutritionLog.name LIKE" => "%".$this->data["keyword"]."%",
												"FoodNutritionLog.type LIKE" => "%".$this->data["keyword"]."%"
											);
					if( !empty($this->params["named"]["keyword"]) )						
						$keyword = $this->params["named"]["keyword"];					
					
				}else{						
						if( !empty($this->data['FoodNutritionLog']['statusTop']) ) {
							$action = $this->data['FoodNutritionLog']['statusTop'];
						}elseif( !empty($this->data['FoodNutritionLog']['status'])) {
							$action = $this->data['FoodNutritionLog']['status'];
						}
						
						if(isset($this->data['FoodNutritionLog']['id']) && count($this->data['FoodNutritionLog']['id']) > 0) {
							$this->update_status(trim($action), $this->data['FoodNutritionLog']['id'], count($this->data['FoodNutritionLog']['id']));
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
									"FoodNutritionLog.name LIKE" => "%".$this->params["named"]["keyword"]."%",
									"FoodNutritionLog.type LIKE" => "%".$this->params["named"]["keyword"]."%"
								);
				$keyword = $this->params["named"]["keyword"];
			}			
					
			
			$this->paginate = array("conditions"=>$conditions,'limit' => '10', 'order' => array('FoodNutritionLog.name' => 'ASC'));
			$branches = $this->paginate('FoodNutritionLog'); //default take the current
			$this->set('branches', $branches);
			$this->set('mode', array('delete'=>'Delete'));
			$this->set('status', $status);
			$this->set('tab', '');
			$this->set('keyword', $keyword);
			
			
			$this->set('limit', $this->params['request']['paging']['FoodNutritionLog']['options']['limit']);
			$this->set('page', $this->params['request']['paging']['FoodNutritionLog']['options']['page']);
		}
		public function admin_addfood(){
			
			
			if(!empty($this->data)) {
		
				$this->FoodNutritionLog->set($this->data);
				if($this->FoodNutritionLog->validates()) {
						
					    
					    $this->request->data["FoodNutritionLog"]["added_date"] 		    = date("Y-m-d h:i:s");
						$this->request->data["FoodNutritionLog"]["modified_date"] 		    = date("Y-m-d h:i:s");
					    	//pr($this->request->data);
					    //$this->loadModel('ClubBranch');
					   
						if($this->FoodNutritionLog->save($this->request->data)) {	
										
							$this->Session->setFlash('Food has been created successfully.');
							$this->redirect('/admin/foods/food/');
						} else {
							$this->Session->setFlash('Some error has been occured. Please try again.');
						}
				}	
			}
		}
		
		public function admin_viewfood(){
		
			if(!empty($this->params["pass"][0])) {
				$this->set("foodInfo",$this->FoodNutritionLog->find("first",array("conditions"=>array("FoodNutritionLog.id"=>$this->params["pass"][0]))));	
			}else{
				$this->redirect($_SERVER["HTTP_REFERER"]);
			}	
		}
		
		
		public function admin_editfood($id = null)
		{
						
			if(!empty($this->data)){
			$id=base64_decode($id);
			$this->set("id",$id);
			$this->FoodNutritionLog->set($this->data);
			$this->FoodNutritionLog->id = $this->data['FoodNutritionLog']['id'];		
			
							
			if($this->FoodNutritionLog->validates()) {
				
				
				$this->request->data["FoodNutritionLog"]["modified_date"] 		    = date("Y-m-d h:i:s");
				if($this->FoodNutritionLog->save($this->data)) {
					$this->Session->setFlash('Food information has been updated successfully.');
					$this->redirect('/admin/foods/food/');
				} else {
					$this->Session->setFlash('Some error has been occured. Please try again.');
				}
			}
							
		 } else{
				if(is_numeric($id) && $id > 0) {
						$this->FoodNutritionLog->id = $id;
						$this->request->data = $this->FoodNutritionLog->read();
					} else {
						$this->Session->setFlash('Invalid Food id.');
						$this->redirect('/admin/foods/food/');
				}
			}	
		}
		
		public function admin_usdaimport(){
			
						
			if(!empty($this->data)) {
		
				$this->FoodNutritionLog->set($this->data);
				if($this->FoodNutritionLog->validates()) {
						if( !empty($this->data["FoodNutritionLog"]["usda"]) ) {
							$filename = $this->data["FoodNutritionLog"]["usda"]["name"];
							$target = $this->config["upload_path_usda"];
							$this->Upload->upload($this->data["FoodNutritionLog"]["usda"], $target, null, null);
  					        $this->request->data["FoodNutritionLog"]["usda"] = $this->Upload->result; 					
						}else{	
							
							unset($this->request->data["FoodNutritionLog"]["usda"]);
							$this->request->data["FoodNutritionLog"]["usda"] = '';							
					    }
					    
					    $this->Session->setFlash('Usda Data has been imported successfully.');
						$this->redirect('/admin/foods/food/');
					    

				}	
			}
		}
		
		public function admin_usdaimportdata(){
			
						
///////////////////////////////////////////////////////////////////////////////////

$dir = WWW_ROOT.'usda';

$scan_dir	=	scandir("usda",1);


//$filepath	=	$dir."usdadata0.xls";
$filepath	=	$dir."/".$scan_dir[0];



if(file_exists( $filepath ) && $scan_dir[0] ){

	
	
	$openedFileArray	=	file($filepath,FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	
	
//	echo count($openedFileArray);die;
	$i	=	0;
	foreach ($openedFileArray as $key => $value) {
		
//		echo "<pre>";
//		print_r($value);
//		echo "</pre>";
//		die();
		

		$valueArray	=	explode('~^~',$value);
//		echo "<pre>2";print_r($valueArray);
//		echo "</pre>"; die();
		foreach ($valueArray as $k=>$val) {
			
			
		
			$newResultArray[$i]	=	$val;
		}
		
		$i++;
		}
	$dataval=array();
	$dts=array();
		if(!empty($newResultArray))
		{
			$k=0;
			foreach($newResultArray as $key=>$val)
			{
				$dts[$k]=explode("^",str_replace('~', "", $val));
				
				$insdata=array();
				
				$insdata['FoodUsda']['type']='Lunch';
				$insdata['FoodUsda']['name']=$dts[$k][0];
				$insdata['FoodUsda']['water_g']=$dts[$k][1];
				$insdata['FoodUsda']['energy_kcal']=$dts[$k][2];
				$insdata['FoodUsda']['protein_g']=$dts[$k][3];
				$insdata['FoodUsda']['lipid_tot_g']=$dts[$k][4];
				$insdata['FoodUsda']['ash_g']=$dts[$k][5];
				$insdata['FoodUsda']['carbohydrt_g']=$dts[$k][6];
				$insdata['FoodUsda']['fiber_td_g']=$dts[$k][7];
				$insdata['FoodUsda']['sugar_tot_g']=$dts[$k][8];
				$insdata['FoodUsda']['calcium_mg']=$dts[$k][9];
				$insdata['FoodUsda']['iron_mg']=$dts[$k][10];
				$insdata['FoodUsda']['magnesium_mg']=$dts[$k][11];
				$insdata['FoodUsda']['phosphorus_mg']=$dts[$k][12];
				$insdata['FoodUsda']['potassium_mg']=$dts[$k][13];
				$insdata['FoodUsda']['sodium_mg']=$dts[$k][14];
				$insdata['FoodUsda']['zinc_mg']=$dts[$k][15];
				$insdata['FoodUsda']['copper_mg']=$dts[$k][16];
				$insdata['FoodUsda']['manganese_mg']=$dts[$k][17];
				$insdata['FoodUsda']['selenium_ug']=$dts[$k][18];
				$insdata['FoodUsda']['vit_c_mg']=$dts[$k][19];
				$insdata['FoodUsda']['thiamin_mg']=$dts[$k][20];
				$insdata['FoodUsda']['riboflavin_mg']=$dts[$k][21];
				$insdata['FoodUsda']['niacin_mg']=$dts[$k][22];
				$insdata['FoodUsda']['panto_acid_mg']=$dts[$k][23];
				$insdata['FoodUsda']['vit_b6_mg']=$dts[$k][24];
				$insdata['FoodUsda']['folate_fot_ug']=$dts[$k][25];
				$insdata['FoodUsda']['folic_acid_ug']=$dts[$k][26];
				$insdata['FoodUsda']['food_folate_ug']=$dts[$k][27];
				$insdata['FoodUsda']['folate_dfe_ug']=$dts[$k][28];
				$insdata['FoodUsda']['choline_tot_mg']=$dts[$k][29];
				$insdata['FoodUsda']['vit_b12_ug']=$dts[$k][30];
				$insdata['FoodUsda']['vit_a_iu']=$dts[$k][31];
				$insdata['FoodUsda']['vit_a_rae_ug']=$dts[$k][32];
				$insdata['FoodUsda']['retinol_ug']=$dts[$k][33];
				$insdata['FoodUsda']['alpha_carot_ug']=$dts[$k][34];
				$insdata['FoodUsda']['beta_carot_ug']=$dts[$k][35];
				$insdata['FoodUsda']['beta_crypt_ug']=$dts[$k][36];
				$insdata['FoodUsda']['lycopene_ug']=$dts[$k][37];
				$insdata['FoodUsda']['lutzea_ug']=$dts[$k][38];
				$insdata['FoodUsda']['vit_e_mg']=$dts[$k][39];
				$insdata['FoodUsda']['vit_d_ug']=$dts[$k][40];
				$insdata['FoodUsda']['vit_d_iu']=$dts[$k][41];
				$insdata['FoodUsda']['vit_k_ug']=$dts[$k][42];
				$insdata['FoodUsda']['fa_sat_g']=$dts[$k][43];
				$insdata['FoodUsda']['fa_mono_g']=$dts[$k][44];
				$insdata['FoodUsda']['cholestrl_mg']=$dts[$k][46];
				$insdata['FoodUsda']['gmwt_1']=$dts[$k][47];
				$insdata['FoodUsda']['gmwtdesc1']=$dts[$k][48];
				$insdata['FoodUsda']['gmwt_2']=$dts[$k][49];
				$insdata['FoodUsda']['gmwt_desc2']=$dts[$k][50];
				$insdata['FoodUsda']['refuse_pct']=$dts[$k][51];
				$insdata['FoodUsda']['added_date']=date('Y-m-d');
				$insdata['FoodUsda']['modified_date']=date('Y-m-d');
				$insdata['FoodUsda']['status']='1';
				
				/*echo '<pre>';
				print_r($insdata);
				echo '</pre>';
				die();*/
				
				$this->FoodUsda->saveAll($insdata);
				
				$k++;
			}
			
		}
		
		
	/*echo "<pre> ";
		print_r($dts);
		echo "</pre>";
	exit;	*/
	
	
	
} else {
	echo "There is no file to read!";
}


		}
		
		public function update_status($status, $ids, $count){

			switch(trim($status)){
				case "activate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->FoodNutritionLog->id = $ids[$ctr];
						$this->FoodNutritionLog->saveField("status", '1');
					}
					$this->Session->setFlash('Food(s) has been activated successfully.');
					break;
				case "deactivate":
					for($ctr=0;$ctr<$count;$ctr++){
						$this->FoodNutritionLog->id = $ids[$ctr];
						$this->FoodNutritionLog->saveField("status", '0');
					}
					$this->Session->setFlash('Food(s) has been deactivated successfully.');
					break;
				case "delete":
					for($i=0;$i<$count;$i++){
						$this->FoodNutritionLog->create();
						$this->FoodNutritionLog->id = $ids[$i];
						
						$this->FoodNutritionLog->delete($ids[$i]);
						
					}
					$this->Session->setFlash('Food(s) has been deleted successfully.');
					break;
			}
		}
	
		
	}