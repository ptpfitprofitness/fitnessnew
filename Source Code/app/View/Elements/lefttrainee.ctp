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
            <li><a href="<?php echo $config['url']?>trainees/index" class="<?php if(isset($leftcheck) && $leftcheck=='homeindex'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/manegp_icon.png" /></i> <span>My Profile</span></a></li>
            
             <li><a href="<?php echo $config['url']?>trainees/editprofile" class="<?php if(isset($leftcheck) && $leftcheck=='editprofile'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/pencial_icon.png" /></i> <span>Edit Profile</span></a></li>
            
            <li><a href="<?php echo $config['url']?>trainees/exercise_history" class="<?php if(isset($leftcheck) && $leftcheck=='exercise_history'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/dumbbell.png" /></i> <span>Exercise  History</span></a></li>
            <li><a href="<?php echo $config['url']?>trainees/scheduling_calendar" class="<?php if(isset($leftcheck) && $leftcheck=='homescheduling_calendar'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/calender_ico.png" /></i> <span>Scheduling Calendar</span></a></li>
      
            <li><a href="<?php echo $config['url']?>trainees/measurement_and_goal" class="<?php if(isset($leftcheck) && $leftcheck=='measurement_and_goal'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/mesurment_ico.png" /></i> <span>Measurement & Goal</span></a></li>
            <li><a href="<?php echo $config['url']?>trainees/communication_center" class="<?php if(isset($leftcheck) && $leftcheck=='communication_center'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/commication_ico.png" /></i> <span>Communication Center</span></a></li>
            <li><a href="<?php echo $config['url']?>trainees/daily_nutrition_diary" class="<?php if(isset($leftcheck) && $leftcheck=='daily_nutrition_diary'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/plate-cutlery.png" /></i> <span>Nutrition Log</span></a></li>
			<li><a href="<?php echo $config['url']?>trainees/helpguide" class="<?php if(isset($leftcheck) && $leftcheck=='helpguide'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/formsico.png" /></i> <span>View Help Guide Video</span></a></li>
         <!--   <li><a href="<?php echo $config['url']?>trainees/exercise_library" class="<?php if(isset($leftcheck) && $leftcheck=='exercise_library'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/exercise_libraryico.png" /></i> <span>Exercise Library</span></a></li>-->
        
         
          </ul>
          <div class="join-trainess">
           
           </div>
        </div>
      </div>