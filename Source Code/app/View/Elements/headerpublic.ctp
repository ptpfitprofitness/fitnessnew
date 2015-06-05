<?php
/*echo '<pre>';
print_r($setSpecalistArr);
echo '</pre>';
$uname='';
$logo=$config['url'].'images/profile_droimg.jpg';*/
$logo=$config['url'].'images/avtar.png';
if(isset($setSpecalistArr[$dbusertype]['id']))
{
	

$utype=$dbusertype;
	

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
  	if($setSpecalistArr[$utype]['logo']!='')
  	{
  		$logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['logo'];
  	}
  	$uname=$setSpecalistArr[$utype]['company_name'];
  }	
	
}

/*echo "<pre>";
print_r($setSpecalistArr);
echo "</pre>";*/
?>
<header <?php if(isset($setSpecalistArr[$dbusertype]['id'])) { ?>class="inside-header"<?php }?>>
    <div class="row">
   
      <div class="three columns logo" style="text-align:center;"> <a href="<?php echo $config['url']?>">
      <?php if(isset($setSpecalistArr[$dbusertype]['id']) && $dbusertype=='Trainer' && !empty($setSpecalistArr['Trainer']['website_logo'])) {?>
      	<img width="135" height="90" src="<?php echo $config['url']?>uploads/<?php echo $setSpecalistArr['Trainer']['website_logo']; ?>" alt=""/>
      <?php } else{?>
      	<img src="<?php echo $config['url']?>images/logo.png" alt=""/>
      	<?php } ?>
      </a> </div>
      
      <?php if(isset($setSpecalistArr[$dbusertype]['id'])) { 
      	   if($this->Session->read('USER_ID') && $this->Session->read('UTYPE')=='Trainee') { 
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
      <?php } else{?>
        <div class="four columns">
        <div class="row">
          <div class="twelve login-tab columns">
            <div class="six login-tab columns">
            <ul class="login-nav">
            
              <li><a href="#" class="Login">Login</a></li>
              
            </ul>
          </div>
          </div>
        </div>
      </div>
     
      	
     <?php  
      }
      	   } else {?>
      <div class="eight columns">
        <div class="row">
         
          <div class="six login-tab columns">
            <ul class="login-nav">
              <li><a href="#" class="Login">Login</a></li>
             
            </ul>
          </div>
          <div class="six corporation-tab columns btns">
            
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