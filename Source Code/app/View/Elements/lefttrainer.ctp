<?php
$logo=$config['url'].'images/avtar.png';

if($this->Session->read('USER_ID'))
{
	
$utype=$this->Session->read('UTYPE');


  if($utype=='Club' || $utype=='Trainer')
  {
  	if($setSpecalistArr[$utype]['logo']!='')
  	{
  		$logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['logo'];
  	}
  	$uname=$setSpecalistArr[$utype]['full_name'];
  	
  }
  elseif($utype=='Trainee')
  {
  	
  	if($setSpecalistArr[$utype]['photo']!='')
  	{
  		$logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['photo'];
  	}
  	$uname=$setSpecalistArr[$utype]['full_name'];
  }
  if($utype=='Corporation')
  {
  	$uname=$setSpecalistArr[$utype]['company_name'];
  }	
	
}

?>
<div class="four inside-head columns">
        <div class="euual-height add-height left-tab-wrap clearfix">
          <div class="profile-pic"><img src="<?php echo $logo;?>" width="209" height="209" /></div>
          <ul class="profile-navigation">
            <li><a href="<?php echo $this->Html->url(array('controller'=>'home', 'action'=>'index')); ?>" class="<?php if(isset($leftcheck) && $leftcheck=='homeindex'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/manegp_icon.png" /></i> <span>Manage My Account</span></a></li>
            <li><a href="<?php echo $config['url']?>home/exercise_history" class="<?php if(isset($leftcheck) && $leftcheck=='exercise_history'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/dumbbell.png" /></i> <span>Manage Exercise</span></a></li>
            <li><a href="<?php echo $config['url']?>home/scheduling_calendar" class="<?php if(isset($leftcheck) && $leftcheck=='homescheduling_calendar'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/calender_ico.png" /></i> <span>Scheduling Calendar</span></a></li>
            <li><a href="<?php echo $config['url']?>home/manage_workout" class="<?php if(isset($leftcheck) && $leftcheck=='manage_workout'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/calender_ico.png" /></i> <span>Manage Session</span></a></li>
            <li><a href="<?php echo $config['url']?>home/manage_clients" class="<?php if(isset($leftcheck) && $leftcheck=='homemy_clients'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/client_infoico.png" /></i> <span>My  Clients/My Groups</span></a></li>
            <li><a href="<?php echo $config['url']?>home/measurement_and_goal" class="<?php if(isset($leftcheck) && $leftcheck=='measurement_and_goal'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/mesurment_ico.png" /></i> <span>Measurements and Goals</span></a></li>
            <li><a href="<?php echo $config['url']?>home/communication_center" class="<?php if(isset($leftcheck) && $leftcheck=='communication_center'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/commication_ico.png" /></i> <span>Communication Center</span></a></li>
         <!--   <li><a href="<?php echo $config['url']?>home/daily_nutrition_diary" class="<?php if(isset($leftcheck) && $leftcheck=='daily_nutrition_diary'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/plate-cutlery.png" /></i> <span>Nutrition Log</span></a></li> -->
            <li><a href="<?php echo $config['url']?>home/add_daily_nutrition_diary" class="<?php if(isset($leftcheck) && $leftcheck=='add_daily_nutrition_diary'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/plate-cutlery.png" /></i> <span>Nutrition Log</span></a></li>
            <li><a href="<?php echo $config['url']?>home/exercise_library" class="<?php if(isset($leftcheck) && $leftcheck=='exercise_library'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/exercise_libraryico.png" /></i> <span>Exercise Library</span></a></li>
                        
                       <li><a href="<?php echo $config['url']?>home/forms" class="<?php if(isset($leftcheck) && $leftcheck=='forms'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/formsico.png" /></i> <span>Forms</span></a></li>
			
			<li><a href="<?php echo $config['url']?>home/helpguide" class="<?php if(isset($leftcheck) && $leftcheck=='helpguide'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/formsico.png" /></i> <span>View Help Guide Video</span></a></li>
			
			
         <!--   <li><a href="<?php echo $config['url']?>home/fitness_testing" class="<?php if(isset($leftcheck) && $leftcheck=='fitness_testing'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/fitness_testingico.png" /></i> <span>Fitness Testing</span></a></li>
            <li><a href="<?php echo $config['url']?>home/business_management" class="<?php if(isset($leftcheck) && $leftcheck=='business_management'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/business_managementico.png" /></i> <span>Business Management</span></a></li>-->
          </ul>
         <div class="join-trainess">
          </div>
        </div>
      </div>