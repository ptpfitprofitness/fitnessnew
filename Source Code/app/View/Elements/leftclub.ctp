<?php
$logo=$config['url'].'images/avtar.png';

if($this->Session->read('USER_ID'))
{
	
if($setUser=='ClubBranch')
	{
		$utype='ClubBranch';
	}
	else {
$utype=$this->Session->read('UTYPE');
	}


  if($utype=='Club' || $utype=='ClubBranch' || $utype=='Trainer')
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
            <li><a href="<?php echo $config['url']?>clubs/index" class="<?php if(isset($leftcheck) && $leftcheck=='clubindex'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/manegp_icon.png" /></i> <span>My Account</span></a></li>
           <!-- <li><a href="<?php echo $config['url']?>clubs/sub_admin" class="<?php if(isset($leftcheck) && $leftcheck=='sub_admin'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/subadmin.png" /></i> <span>Manage Sub Admin</span></a></li>-->
            
            <li><a href="<?php echo $config['url']?>clubs/manage_trainer" class="<?php if(isset($leftcheck) && $leftcheck=='ctrainer'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/trainerm.png" /></i> <span>Manage Trainer</span></a></li>
            <?php if($utype=='Club'){?>
            <li><a href="<?php echo $config['url']?>clubs/manage_branchs" class="<?php if(isset($leftcheck) && $leftcheck=='cbranch'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/arrow-branch.png" /></i> <span>Manage Branchs</span></a></li>
            <?php }?>
           
            <li><a href="<?php echo $config['url']?>clubs/manage_trainee" class="<?php if(isset($leftcheck) && $leftcheck=='homemy_clients'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/client_infoico.png" /></i> <span>Manage Clients</span></a></li>
			
			
			
			
          <!--  <li><a href="<?php echo $config['url']?>clubs/payment_report_trainer" class="<?php if(isset($leftcheck) && $leftcheck=='reporttrainer'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/paymentr.png" /></i> <span>Payment Report Trainer</span></a></li>
            
             <li><a href="<?php echo $config['url']?>clubs/payment_report_trainee" class="<?php if(isset($leftcheck) && $leftcheck=='reporttrainee'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/paymentr.png" /></i> <span>Payment Report Clients</span></a></li>-->
             <?php if($setUser=='ClubBranch'){?>
             <li><a href="<?php echo $config['url']?>clubs/communication_center_branch" class="<?php if(isset($leftcheck) && $leftcheck=='communication_center'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/commication_ico.png" /></i> <span>Communication Center</span></a></li>
            <?php } else{?>
            <li><a href="<?php echo $config['url']?>clubs/communication_center" class="<?php if(isset($leftcheck) && $leftcheck=='communication_center'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/commication_ico.png" /></i> <span>Communication Center</span></a></li>
            <?php }?>
            
            <!--<li><a href="<?php echo $config['url']?>clubs/theme_setting" class="<?php if(isset($leftcheck) && $leftcheck=='themesetting'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/themesetting.png" /></i> <span>Public Theme settings</span></a></li>-->
            
            
           <!-- <li><a href="<?php echo $config['url']?>clubs/trainee_request" class="<?php if(isset($leftcheck) && $leftcheck=='trainee_request'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/request_receive.png" /></i> <span>Manage Client Request</span></a></li>-->
            
            
           <!-- <li><a href="<?php echo $config['url']?>clubs/notifications" class="<?php if(isset($leftcheck) && $leftcheck=='notifications'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/business_managementico.png" /></i> <span>Notifications</span></a></li>-->
          
		  
		  <li><a href="<?php echo $config['url']?>clubs/helpguide" class="<?php if(isset($leftcheck) && $leftcheck=='helpguide'){ echo 'slectedmn';} else{ echo '';}?>"><i><img src="<?php echo $config['url']?>images/formsico.png" /></i> <span>View Help Guide Video</span></a></li>
          </ul>
          <div class="join-trainess">
          
            <!--<a href="<?php //echo $this->Html->url(array('controller'=>'clubs', 'action'=>'editprofile')); ?>" class="submit-nav edit-profile">Edit Profile</a>--> </div>
        </div>
      </div>