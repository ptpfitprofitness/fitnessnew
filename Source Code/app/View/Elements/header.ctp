<?php
/*echo '<pre>';
print_r($setSpecalistArr);
echo '</pre>';
$uname='';
$logo=$config['url'].'images/profile_droimg.jpg';*/

//$setSpecalistArr1['Club']['website_logo'];
//$setSpecalistArr['Trainer']['website_logo'];



$logo=$config['url'].'images/avtar.png';
$logo_url=$config['url'];
if($this->Session->read('USER_ID'))
{
	
if($setUser=='ClubBranch')
	{
		$utype='ClubBranch';
		$logo_url=$config['url'].'clubs/';
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
  	$logo_url=$config['url'].'trainees/';
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
	$logo_url=$config['url'].'corporations/';
  }
if($utype=='Club')
{
$logo_url=$config['url'].'clubs/';
}  
if($utype=='Trainer')
{
$logo_url=$config['url'].'home/';
} 	
	
}

/*echo "<pre>";
print_r($setSpecalistArr);
echo "</pre>";
echo "<pre>";
print_r($setSpecalistArr1);
echo "</pre>";
die();*/
?>
<header <?php if($this->Session->read('USER_ID')) { ?>class="inside-header"<?php }?>>
    <div class="row">
		<?php //echo $dbusertype; echo $setSpecalistArr[$dbusertype]['website_logo']; die();?>
      <div class="four columns logo" style="text-align:center;"> <a href="<?php echo $logo_url;?>">
      <?php if($this->Session->read('USER_ID') && $dbusertype=='Trainer' && !empty($setSpecalistArr[$dbusertype]['website_logo']) && $setSpecalistArr['Trainer']['trainer_type']!='C' || $this->Session->read('USER_ID') && $dbusertype=='Club' && !empty($setSpecalistArr[$dbusertype]['website_logo']) || $this->Session->read('USER_ID') && $dbusertype=='Trainee' && !empty($setSpecalistArr[$dbusertype]['website_logo']) || $this->Session->read('USER_ID') && $dbusertype=='ClubBranch' && !empty($setSpecalistArr[$dbusertype]['website_logo'])) {?>
      	<img  src="<?php echo $config['url']?>uploads/timthumb.php?src=<?php echo $setSpecalistArr[$dbusertype]['website_logo']; ?>&h=80&w=105&zc=1" alt="" style="width:150px; height:100px"/>
      <?php } else if($setSpecalistArr['Trainer']['trainer_type']=='C') {?>
	  <img src="<?php echo $config['url']?>uploads/timthumb.php?src=<?php echo $setSpecalistArr1['Club']['website_logo']; ?>&h=80&w=105&zc=1" alt="" style="width:150px; height:100px"/>
	  <?php } else if($this->Session->read('USER_ID') && $dbusertype=='ClubBranch' && !empty($setSpecalistArr['Club']['website_logo'])) {?>
	  <img src="<?php echo $config['url']?>uploads/timthumb.php?src=<?php echo $setSpecalistArr['Club']['website_logo']; ?>&h=80&w=105&zc=1" alt="" style="width:150px; height:100px"/>
	  <?php } else if($this->Session->read('USER_ID') && $dbusertype=='Trainee' && !empty($setSpecalistArr1['Club']['website_logo'])) {?>
	   <img src="<?php echo $config['url']?>uploads/timthumb.php?src=<?php echo $setSpecalistArr1['Club']['website_logo']; ?>&h=80&w=105&zc=1" alt="" style="width:150px; height:100px"/>
	  <?php } else { ?>
      	<img src="<?php echo $config['url']?>images/logo.png" alt="" style="height:100px" />
      	<?php } ?>
      </a> </div>
      
      <?php if($this->Session->read('USER_ID')) { 
      	   
      	?>
        <div class="four columns">
        <div class="row">
          <div class="twelve login-tab columns">
            <div class="already-sign">              
               <a href="<?php echo $config['url']?>index/logout">Logout</a>
            </div>
          </div>
        </div>
      </div>
     
      	
     <?php  
      	   
      	   } else {?>
      <div class="eight columns">
        <div class="row">
          <div class="six thirty-days-tab mobile-one columns">
           <?php  $thon_off=$thrtydaysshow; 
          ?>
            <div class="thirty-days-nav"  <?php if($thon_off=='0') { echo 'style="display:block;"';} else{ echo 'style="display:none;"';}?>><span>30 Day FREE TRIAL <span class="thirtyfor">For CLUB OWNER/TRAINER</span> <a href="javascript:void(0);">Click Here</a></span></div>
            
          </div>
          <div class="six login-tab columns">
            <ul class="login-nav">
              <li><a href="#" class="Login">Login</a></li>
              <li><a href="javascript:void(0);" class="Register">Register</a></li>
            </ul>
          </div>
          <div class="six corporation-tab columns btns">
            <ul class="top-band-nav">
             <?php $on_off=$corporationshow; ?>
          <?php if($on_off=='1') {?>
            <li><a href="<?php echo $config['url'];?>our-corporate"><span>CORPORATE</span></a> </li>
            <?php } ?>
            <li><a href="<?php echo $config['url'];?>our-club"><span>CLUB&nbsp;&nbsp;&nbsp;&nbsp;OWNER</span></a></li>
             <li><a href="<?php echo $config['url'];?>our-trainer"><span>Trainer</span></a></li>
             
              
             
              
            </ul>
          </div>
        </div>
      </div>
      <?php }?>
    </div>
    <!-- header row ends  --> 
  </header>
  <!--/header ends -->
  <script type="text/javascript">
  $(document).ready(function(){
  	 $("#flashMessage").delay(10000).fadeOut();
 });
  </script>