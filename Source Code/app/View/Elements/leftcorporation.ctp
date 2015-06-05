<?php
$logo=$config['url'].'images/avtar.png';

if($this->Session->read('USER_ID'))
{
	
$utype=$this->Session->read('UTYPE');


  if($utype=='Club' || $utype=='Trainer' )
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
  	if($setSpecalistArr[$utype]['logo']!='')
  	{
  		$logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['logo'];
  	}
  	$uname=$setSpecalistArr[$utype]['company_name'];
  }	
	
}

?>
<div class="four inside-head columns">
        <div class="euual-height add-height left-tab-wrap clearfix">
          <div class="profile-pic"><img src="<?php echo $logo;?>" width="209" height="209" /></div>
          <ul class="profile-navigation">
            <li><a href="<?php echo $this->Html->url(array('controller'=>'corporations', 'action'=>'editprofile')); ?>" class="<?php if(isset($leftcheck) && $leftcheck=='homeindex'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/manegp_icon.png" /></i> <span>Edit Profile</span></a></li>
          
          
            <li><a href="<?php echo $config['url']?>corporations/manage_employees" class="<?php if(isset($leftcheck) && $leftcheck=='homemy_emps'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/client_infoico.png" /></i> <span>My  Employee</span></a></li>
            
            <li><a href="<?php echo $config['url']?>corporations/manage_corporationsbranch" class="<?php if(isset($leftcheck) && $leftcheck=='homemy_corporations'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/client_infoico.png" /></i> <span>My  Branch</span></a></li>
            
             <li><a href="<?php echo $config['url']?>corporations/manage_contacts" class="<?php if(isset($leftcheck) && $leftcheck=='homemy_contacts'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/client_infoico.png" /></i> <span>My  Contact</span></a></li>
           
          </ul>
          <div class="join-trainess">
         
           <!-- <a href="<?php //echo $this->Html->url(array('controller'=>'corporations', 'action'=>'editprofile')); ?>" class="submit-nav edit-profile">Edit Profile</a>--> </div>
        </div>
      </div>