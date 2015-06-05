<?php
$logo=$config['url'].'images/avtar.png';

if(isset($setSpecalistArr[$dbusertype]['id']))
{
	

$utype=$dbusertype;


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
<style>
.profile-navigation li a i {
    float: left;
    text-align: center;
    width: 100%;
}
</style>

<div class="three inside-head columns">
        <div class="euual-height add-height left-tab-wrap clearfix">
          <div class="profile-pic"><img src="<?php echo $logo;?>" width="209" height="209" /></div>
          <h5><b style="font-family: 'HelveticaLTCondensedRegular';">Certifications and Credentials</b></h5>
          <ul class="profile-navigation">
           <?php 
          $cnt=1;
         //pr($clients);
         
          foreach ($certificationstr as $certification)
          {
          	  if(trim($certification['CertificationTrainers']['certification_org']))
						$full1 = trim($certification['CertificationTrainers']['certification_org']);
					else
						$full1 = trim($certification['CertificationTrainers']['certification_org1']);	
						
					if(trim($certification['CertificationTrainers']['certification_name']))
						$full2 = trim($certification['CertificationTrainers']['certification_name']);
					else
						$full2 = trim($certification['CertificationTrainers']['certification_name1']);	
						
					if(trim($certification['CertificationTrainers']['certification_degree']))
						$full3 = trim($certification['CertificationTrainers']['certification_degree']);
					else
						$full3 = trim($certification['CertificationTrainers']['certification_degree1']);	
          ?>
            <li><a href="javascript:void(0);" class=""><i> <span><?php echo $full1.' - '.$full2;  ?> <?php /*if($certification['CertificationTrainers']['certification_code']!=''){echo ' - '.$certification['CertificationTrainers']['certification_code'];}*/   ?></span></a></li>
        
                  <?php } ?>      
                     
          </ul>
         <div class="join-trainess">
          </div>
        </div>
      </div>