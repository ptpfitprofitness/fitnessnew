<?php
/*echo '<pre>';
print_r($setSpecalistArr);
//print_r($certifications);
echo '</pre>';
die();*/
 //print_r($this->params);
 
 

$logo=$config['url'].'images/avtar.png';
$website_logo=$config['url'].'images/logo.png';
if($this->Session->read('USER_ID'))
{
	
$utype=$this->Session->read('UTYPE');


  if($utype=='Club' || $utype=='Trainer')
  {
  	if($setSpecalistArr[$utype]['logo']!='')
  	{
  		$logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['logo'];
  	}
  	if($setSpecalistArr[$utype]['website_logo']!='')
  	{
  		$website_logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['website_logo'];
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
<script>
function validuppic()
{
	var pic=$('#TrainerLogo').val();
	if(pic=='')
	{
		alert('Please select the photo');
		return false;
	}
	else
	{
		return true;
	}
	
}


function validcuppic()
{
	var pic=$('#<?php echo $this->Session->read('UTYPE');?>Cpic').val();
	if(pic=='')
	{
		alert('Please select the Cover photo');
		return false;
	}
	else
	{
		return true;
	}
	
}


function editstatus(str)
{
	//alert(str);
	var editsecHtml='<textarea name="userfb_status" id="userfb_statusid"></textarea><input type="button" name="submit" value="Save" onclick="saveedit('+str+');" class="change-pic-nav" style="width:50px;"/><input type="button" name="cancel" class="change-pic-nav" style="width:58px;margin-left:10px;" onclick="canceledit('+str+');" value="Cancel"/>';
	$('#userfb_status').html(editsecHtml);
	
}
function saveedit(str2)
{
	var sthtml=$('#userfb_statusid').val();
	//alert(sthtml);
	 $.post("<?php echo $config['url'];?>home/userfbstatus", {userfb_status: sthtml, id: str2}, function(data)
            {
            	if(data==1)
            	{
            		$('#userfb_status').html('<a href="javascript:void(0);" onclick="editstatus('+str2+');" style="color:#fff;">'+sthtml+'<a>');
            	}
            	else
            	{
            		$('#userfb_status').html('<a href="javascript:void(0);" onclick="editstatus('+str2+');" style="color:#fff;">Set your current status, click here!!!</a>');
            	}
            });
}
function canceledit(str3)
{
	
	 $.post("<?php echo $config['url'];?>home/userfbstatusget", {id: str3}, function(data)
	 {
	 	if(data!='')
	 	{
	 		$('#userfb_status').html('<a href="javascript:void(0);" onclick="editstatus('+str3+');" style="color:#fff;">'+data+'</a>');
	 	}
	 	else
	 	{
	 		$('#userfb_status').html('<a href="javascript:void(0);" onclick="editstatus('+str3+');" style="color:#fff;">Set your current status, click here!!!</a>');
	 	}
	 });
	
}

function newcorporation()
{
	
	//document.location.href="<?php echo $config['url'];?>home/manage_certifications/";
	
	document.location.href="<?php echo $config['url'];?>home/addcertification_trainer/";
}




function editprofile()
{
	
	document.location.href="<?php echo $config['url'];?>home/editprofile/";
}

/*function couponpost(coupon,amount)
{		
	document.location.href="<?php echo $config['url'];?>home/couponcode/"+coupon+'/'+amount;
}*/

function couponpost(coupon,amount)
{
	var coupon = document.getElementById("coupon_code").value;
	var amount = document.getElementById("trainertotal").value;
	var website_url ='<?php echo $config['url']?>home/couponcode';
	$.ajax({
		type: "POST",
		url: website_url,
		data: "coupon="+coupon+"&amount="+amount,
		beforeSend: function(){$('.loaderResult101').show()},
		success: function(msg)
		{	
			if(!isNaN(msg))
			{
				alert('Price after discount $' +msg);
				$('#trainertotal').val(msg);
				$("#discountedprice").html('Price after discount $' +msg);
				$("#coupon-button").hide();	
				$("#coupon-button-cancel").show();
				$('#coupon_code').attr('readonly', true);
				
			}
			else
			{
				alert(msg);				
				$("#discountedprice").html(msg);
			}
					
		}
	});	
}

function getcancelreset(coupon,amount,plan_value)
{
	$('#trainertotal').val(plan_value);	
	$('#coupon_code').val('');
	$('#coupon-button-cancel').hide();
	$('#coupon-button').show();
	$('#coupon_code').attr('readonly', false);
	
}












function newevent()
{
  document.location.href="<?php echo $config['url'];?>home/addevent/";
}
function deleteevent(str)
{
	if(str)
	{
		 var website_url ='<?php echo $config['url'];?>home/deleteevent';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "eventid="+str,							
		   		success: function(msg)
					{						
						alert(msg);
						$('#ev_'+str).css('display','none');
					}
				});	
		
	}
	
}

function deletecertifytrainer(str)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to delete this Certification Trainer?"))
		{
	         	$.ajax({
				url:"<?php echo $config['url'];?>home/deletecertifytrainer/",
				type:"POST",
				data:{id:str},
				success:function(e) {
					var response = eval(' ( '+e+' ) ');
					if( response.responseclassName == "nSuccess" ) {
						alert(response.errorMsg);
						document.location.href=document.location.href;
						
					}
					else
					{
							alert(response.errorMsg);
						
					}
				}
		      });
		}
	}
}

function cancelmyaccount(str)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to cancel your account?"))
			{
					$.ajax({
					url:"<?php echo $config['url'];?>home/cancelmyaccount/",
					type:"POST",
					data:{id:str},
					success:function(e) {
						var response = eval(' ( '+e+' ) ');
						if( response.responseclassName == "nSuccess" ) {
							alert(response.errorMsg);
							document.location.href=document.location.href;
							
						}
						else
						{
								alert(response.errorMsg);
							
						}
					}
				  });
			}
	}
}


</script>


<script type="text/javascript">
var maxLength=2000;
function charLimit(el) {
    if (el.value.length > maxLength) return false;
    return true;
}
function characterCount(el) {
    var charCount = document.getElementById('characterLeft');
    if (el.value.length > maxLength) el.value = el.value.substring(0,maxLength);
    if (charCount) charCount.innerHTML = maxLength - el.value.length;
    return true;
}
function characterCount2(el) {
    var charCount = document.getElementById('characterLeft2');
    if (el.value.length > maxLength) el.value = el.value.substring(0,maxLength);
    if (charCount) charCount.innerHTML = maxLength - el.value.length;
    return true;
}
</script>

<style>
<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
.contentContainer{height:2800px;}
</style>
<section class="contentContainer clearfix">
    <div class="inside-banner changecover-pic">
    <!--<div class="change-coverpic" onclick="popupOpen('pop5');"><img src="<?php //echo $config['url'];?>images/pencial_icon.png" /> Change Cover </div>-->
      <div class="row">
        <div class="eight inside-head offset-by-four columns">
          <h2 class="client-name"><?php echo $uname;?></h2>
          <h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['city'].', '. $setSpecalistArr[$utype]['state'];?></h3>
          <p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ echo $setSpecalistArr[$utype]['userfb_status'];}?></p>
        </div>
      </div>
    </div>
    <div class="row">
     <?php echo $this->element('lefttrainer');?>
      <div class="eight inside-head columns">
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <!--<li><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
          <li><a href="#Subscriptions"><span class="subscription-ico"></span>Classes and Events</a></li>
          <li><a href="#Certification"><span class="certification-ico"></span>Certifications</a></li>
          <li class="nomarg"><a href="#Bio"><span class="bio-ico"></span>Bio</a></li>-->
          <li><a href="#Profile" class="active"><span class="profile-ico"></span>Edit My Account</a></li>
          <li><a href="javascript:void(0);" onclick="editprofile();"><span class="subscription-ico"></span>Edit My Profile</a></li>
          <li><a href="#Certification"><span class="certification-ico"></span>Edit My Certifications</a></li>
          <li class="nomarg"><a href="#Bio"><span class="bio-ico"></span>Edit My Webpage</a></li>
        </ul>    
        
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Edit My Account</a></li>
          <div id="Profile" class="euual-height desktop-tab profile-tabs-content clearfix">
          <div class="row">
       <div style="float: right; width: 212px;">
        <!--<div style="float:right">
          <input type="button" style="width:200px;margin-right:10px;" class="change-pic-nav" onclick="editprofile();" value="Edit Account" name="submit">
        </div>-->
        
       <!-- <div style="float:right">
          <input type="button" style="width:200px;margin-right:10px;" class="change-pic-nav" onclick="javascript:void(0);" value="Upgrdae Subscriptions" name="submit"
          <a style="width:200px;margin-right:10px;" href="<?php echo $config['url']?>home/subscriptions" class="change-pic-nav">Subscriptions</a>
        </div>
        
        <div style="float:right">
          <input type="button" style="width:200px;margin-right:10px;" class="change-pic-nav" onclick="popupOpen('pop555');" value="Manage Card Details" name="submit">
        </div>-->
		<div style="float:right">
          <input type="button" style="width:200px;margin-right:10px;" class="change-pic-nav" onclick="popupOpen('popbillinginfo');" value="Billing Information" name="submit">
        </div>
		<?php /*if ($setSpecalistArr['Trainer']['trainer_type']=='I') { ?>
		<div style="float:right">
          <input type="button" style="width:200px;margin-right:10px;" class="change-pic-nav" onclick="cancelmyaccount(<?php echo $setSpecalistArr['Trainer']['id'];?>);" value="Cancel My Account" name="submit">
        </div>
		<?php } */?>
        </div>
        
        
        
            <div class="two columns change-pic">
              <div class="change-pic-img"> <img src="<?php echo $logo;?>" width="75" height="76" /> </div> 
                <a style="width:105px;" href="#" class="change-pic-nav" onclick="popupOpen('pop4');">Change Picture</a> 
                 
                </div>
                
            <div class="ten columns profile-change-pictext">
              <!--<h2>About Me</h2>-->
              <p><?php echo $setSpecalistArr[$utype]['about_us'];?></p>
            </div>
            <ul class="twelve columns about-details-list">
              <li class="pro-heading">About Me</li>
             
              <li class="gray">
                <div class="row">
                  <div class="four columns about-detailshead">Email address:</div>
                  <div class="eight columns about-detailsdet"><?php echo $setSpecalistArr[$utype]['email'];?> </div>
                </div>
              </li>
              <li>
                <div class="row">
                  <div class="four columns about-detailshead">Password:</div>
                  <div class="eight columns about-detailsdet">***********<?php //echo $setSpecalistArr[$utype]['email'];?></div>
                </div>
              </li>
              <li class="gray">
                <div class="row">
                  <div class="four columns about-detailshead">First name:</div>
                  <div class="eight columns about-detailsdet"><?php echo $setSpecalistArr[$utype]['first_name'];?></div>
                </div>
              </li>
              <li>
                <div class="row">
                  <div class="four columns about-detailshead">Last name:</div>
                  <div class="eight columns about-detailsdet"><?php echo $setSpecalistArr[$utype]['last_name'];?></div>
                </div>
              </li>
              <li class="gray">
                <div class="row">
                  <div class="four columns about-detailshead">Address:</div>
                  <div class="eight columns about-detailsdet"><?php if($setSpecalistArr[$utype]['address']!=''){echo $setSpecalistArr[$utype]['address'];} else{echo '--';}?></div>
                </div>
              </li>
              <li>
                <div class="row">
                  <div class="four columns about-detailshead">City:</div>
                  <div class="eight columns about-detailsdet"><?php if($setSpecalistArr[$utype]['city']!=''){echo $setSpecalistArr[$utype]['city'];} else{echo '--';}?></div>
                </div>
              </li>
              <li class="gray">
                <div class="row">
                  <div class="four columns about-detailshead">State:</div>
                  <div class="eight columns about-detailsdet"><?php if($setSpecalistArr[$utype]['state']!=''){echo $setSpecalistArr[$utype]['state'];} else{echo '--';}?></div>
                </div>
              </li>
           
              <li>
                <div class="row">
                  <div class="four columns about-detailshead">Phone:</div>
                  <div class="eight columns about-detailsdet"><?php if($setSpecalistArr[$utype]['phone']!=''){echo $setSpecalistArr[$utype]['phone'];} else{echo '--';}?></div>
                </div>
              </li>
             
              <li class="gray">
                <div class="row">
                  <div class="four columns about-detailshead">Logo:</div>
                  <div class="eight columns about-detailsdet"><img src="<?php echo $website_logo;?>" width="65" height="44"/></div>
                </div>
              </li>
         
            </ul>
          </div>
        </div>
          <li class="mobile-tab-list"><a href="#Subscriptions" onclick="editprofile();"><span class="subscription-ico"></span>Edit My Profile</a></li>
          <div id="Subscriptions" class="euual-height desktop-tab profile-tabs-content clearfix" style=" width: 100%;">
         <div class="row">
             
                 
            <div class="ten columns profile-change-pictext">
              <!--<h2>About Me</h2>-->
              <p><?php echo $setSpecalistArr[$utype]['about_us'];?></p>
            </div>
            <ul class="twelve columns about-details-list">
              <li class="pro-heading">Classes and Events</li>
              <li>
                <div class="row">
                  <input type="button" style="width:120px;" class="change-pic-nav" onclick="newevent();" value="Add Event" name="submit">
        </div>
        <?php /*if(!empty($events)){?>
        <style>
#Subscriptions .about-details-list li{padding:0;}
        </style>
        <div class="main-responsive-box"><ul class="listing-box all-headtabs">
          <li class="listing-heading">
            <div class="list-colum first-tabs" style="min-width:50px;">S.No.</div>
            <div class="list-colum second-tabs">Classes and Events</div>
            <div class="list-colum third-tabs">Date</div>
           
            <div class="list-colum fifth-tabs">Action</div>
          </li>
        </ul>
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
          <?php 
          $cnt=1;
         //pr($clients);
          foreach ($events as $events)
          {
          	
          ?>
            <li id="ev_<?php echo $events['Event']['id'];?>">
              <div class="list-colum first-tabs" style="min-width:50px;"><?php echo $cnt; ?></div>
              <div class="list-colum second-tabs"><?php if(!empty($events['Event']['events'])){echo $events['Event']['events']; };  ?></div>
              <div class="list-colum third-tabs"><?php if(!empty($events['Event']['added_date'])){echo  $events['Event']['added_date']; };  ?></div>
            
              <div class="list-colum fifth-tabs">  <a href="javascript:void(0);" onclick="deleteevent(<?php echo $events['Event']['id'];?>);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a></div>
            </li>
         <?php   $cnt++; ?>
            <?php  }?>
            
          </div>
        </ul>
        
         <?php }
         if(!empty($events)){ echo '</div>';}*/
         ?>
                </div>
             </div>
            
             
      
          <li class="mobile-tab-list"><a href="#Certification"><span class="certification-ico"></span>Edit My Certifications</a></li>
          <div id="Certification" class="euual-height desktop-tab profile-tabs-content clearfix" style=" width: 100%;">
          
          
          <div class="row">
           <div style="float:right">
          
            <input type="button" style="width:200px;margin-right:10px;" class="change-pic-nav" onclick="newcorporation();" value="Add Certification" name="submit">
        </div>
        <div class="main-responsive-box"><ul class="listing-box all-headtabs">
          <li class="listing-heading">
            <!--<div class="list-colum first-tabs" style="min-width:50px;">S.No.</div>-->
            <div class="list-colum second-tabs">Certification Organization</div>
            <div class="list-colum third-tabs">Certification Name</div>
           <!-- <div class="list-colum third-tabs">Degree</div>-->
            <div class="list-colum third-tabs">Certification Number</div>
            <div class="list-colum fifth-tabs">Action</div>
          </li>
        </ul>
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
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
            <li>
              <!--<div class="list-colum first-tabs" style="min-width:50px;"><?php //echo $cnt; ?></div>-->
              <div class="list-colum second-tabs" style="min-width: 122px !important;" ><?php echo $full1;  ?></div>
              <div class="list-colum third-tabs"><?php echo $full2;  ?></div>
             <!-- <div class="list-colum third-tabs"><?php //echo $full3;  ?></div>-->
              <div class="list-colum third-tabs"><?php if($certification['CertificationTrainers']['certification_code']!=''){echo $certification['CertificationTrainers']['certification_code'];} else {echo '--';}  ?></div>
              
              <div class="list-colum fifth-tabs"><a href="javascript:void(0);" onclick="deletecertifytrainer(<?php echo $certification['CertificationTrainers']['id'];?>);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a>  </div>
            </li>
         <?php   $cnt++; ?>
            <?php  }?>
            
          </div>
        </ul>
           
         </div>
        </div>
        
        
        </div>
       
          <li class="mobile-tab-list"><a href="#Bio"><span class="bio-ico"></span>Edit My Webpage</a></li>
          <div id="Bio" class="euual-height desktop-tab profile-tabs-content clearfix" style=" width: 100%;">
          <div class="row">
          
          <div style="float: right; width: 212px;">
        
        
        <div style="float:right">
        
		  
          <a style="width:200px;margin-right:10px;" href="#events" class="change-pic-nav">Manage Classes and Events</a>
		  
		  <a style="width:200px;margin-right:10px;" href="<?php echo $config['url']?>home/gallery" class="change-pic-nav">Manage Gallery</a>
        </div>
        
        
        </div>
           
         <div class="ten columns profile-change-pictext">
              <h2>Public Profile URL</h2>
              <p>
               <?php if($setSpecalistArr[$utype]['publicproname']!=''){echo '<a href="'.$config['url'].'home/myprofile/'.$setSpecalistArr[$utype]['publicproname'].'" target="blank">'.$config['url'].'home/myprofile/'.$setSpecalistArr[$utype]['publicproname'].'</a>';} else {echo 'Please save your public profile name from the Edit My Profile Section';}?>
               </p>
             
             
            </div>
            
            
            <div class="clear"></div>
              <div class="ten columns profile-change-pictext">
              <h2>Edit Bio</h2>
              <p></p>
             
              <?php echo $this->Form->create('Trainer', array('url' => array('controller' => 'home', 'action' => 'editbio')));
               ?>
               <?php echo $this->Form->hidden('Trainer.id',array('value'=>$this->Session->read('USER_ID'))); ?>
               
               <?php 
						echo $this->Cksource->create('CKSource');
						echo $this->Cksource->ckeditor('Biodt',array('name'=>'data[Trainer][Bio]','value'=>$setSpecalistArr[$utype]['Bio']));
						
						
					?>
               
               
              <?php //echo $this->Form->textarea('Trainer.Bio', array('maxlength'=>2000, 'id'=>'BioDt','placeholder'=>'Bio' ,'value'=>$setSpecalistArr[$utype]['Bio'],'onKeyUp'=>"return characterCount(this)" )); ?>
              <div id="characterLeft" style="float: left; background: none repeat scroll 0% 0% rgb(204, 204, 204); font-family: 'HelveticaLTCondensedRegular'; padding: 3px;">Only 2000 Char. Limit</div> <div class="clear"></div>
             <?php $boptions = array(
    'label' => 'Update',
   'class' => 'submit-nav'
);
              ?>
              <?php echo $this->Form->end($boptions); ?>
            </div>
            
            
            <div class="clear"></div>
            
            <div class="ten columns profile-change-pictext" style="margin-top:25px;">
           <h2>Bio</h2>
            <p><?php echo $setSpecalistArr[$utype]['Bio'];?></p>
            </div>
           
            <div class="clear"></div>
            <div class="ten columns profile-change-pictext">
              <h2>Edit Testimonial </h2>
              <p></p>
             
              <?php echo $this->Form->create('Trainer', array('url' => array('controller' => 'home', 'action' => 'editbio')));
               ?>
               <?php echo $this->Form->hidden('Trainer.id',array('value'=>$this->Session->read('USER_ID'))); ?>
                <?php 
						echo $this->Cksource->create('CKSource');
						echo $this->Cksource->ckeditor('testimonials',array('name'=>'data[Trainer][testimonials]','value'=>$setSpecalistArr[$utype]['testimonials']));
						
						
					?>
              <?php //echo $this->Form->textarea('Trainer.testimonials', array('maxlength'=>2000, 'id'=>'testimonials','placeholder'=>'Testimonials' ,'value'=>$setSpecalistArr[$utype]['testimonials'],'onKeyUp'=>"return characterCount2(this)" )); ?>
              <div id="characterLeft2" style="float: left; background: none repeat scroll 0% 0% rgb(204, 204, 204); font-family: 'HelveticaLTCondensedRegular'; padding: 3px;">Only 2000 Char. Limit</div> <!--<span style="float: left; font-family: 'HelveticaLTCondensedRegular'; padding: 3px; background: none repeat scroll 0% 0% rgb(204, 204, 204);">&nbsp; characters left </span>--><div class="clear"></div>
              <?php
              $boptions = array(
    'label' => 'Update',
   'class' => 'submit-nav'
);
              ?>
              <?php echo $this->Form->end($boptions);  ?> <a id="events"></a>
            </div>
            
            
            
            <div class="clear"></div>
            <br><br>
            <div class="profile-change-pictext">
             <h2>Manage Classes and Events</h2>
            </div>
            <div class="row" style="float:right;">
                  <input type="button" style="width:120px;" class="change-pic-nav" onclick="newevent();" value="Add Event" name="submit">
        </div>
        <?php if(!empty($events)){?>
        <style>
#Subscriptions .about-details-list li{padding:0;}
        </style>
        <div class="main-responsive-box"><ul class="listing-box all-headtabs">
          <li class="listing-heading">
           <!-- <div class="list-colum first-tabs" style="min-width:50px;">S.No.</div>-->
            <div class="list-colum second-tabs">Classes and Events</div>
            <div class="list-colum third-tabs">Date</div>
           
            <div class="list-colum fifth-tabs">Action</div>
          </li>
        </ul>
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
          <?php 
          $cnt=1;
         //print_r($events);
          foreach ($events as $events)
          {
          	
          ?>
            <li id="ev_<?php echo $events['Event']['id'];?>">
            <!--  <div class="list-colum first-tabs" style="min-width:50px;"><?php //echo $cnt; ?></div>-->
              <div class="list-colum second-tabs" style="min-width: 122px !important;"><?php if(!empty($events['Event']['events'])){echo $events['Event']['events']; };  ?></div>
              <div class="list-colum third-tabs"><?php if(!empty($events['Event']['added_date'])){echo  $events['Event']['added_date']; };  ?></div>
            
              <div class="list-colum fifth-tabs">  <a href="javascript:void(0);" onclick="deleteevent(<?php echo $events['Event']['id'];?>);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a></div>
            </li>
         <?php   $cnt++; ?>
            <?php  }?>
            
          </div>
        </ul>
        
         <?php }?>
            
            
            
            
            
          </div>
        </div>
        </ul>      
      </div>
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
   <!-- Change Pic popup -->
                <div id="pop4" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('pop4');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="/home/uploadpic/" controller="home" enctype="multipart/form-data" class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validuppic();">
                          <h2>Upload Profile Pic</h2>
                           <input type="file" name="data[Trainer][logo]" id="TrainerLogo" />
                           <?php echo $this->Form->hidden('Trainer.id',array('value'=>$this->Session->read('USER_ID')));?>
                           <?php echo $this->Form->hidden('Trainer.old_image',array('value'=>$setSpecalistArr[$utype]['logo']));?>
                          <!--<input type="file" name="" value="" placeholder="upload pic" />-->
                               
                            <div class="row">
                        <p><i>(Please upload the pic with in 2MB in size)</i></p>
                        <div class="twelve already-member columns">
                          <input type="submit" value="Submit" name="" class="submit-nav">
                       </div>   
                      </div>                    
                        </form>
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Change Pic popup End -->
   <!-- Change Cover popup -->
                <div id="pop5" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('pop5');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="/home/coverpic/" controller="home" enctype="multipart/form-data" class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validcuppic();">
                          <h2>Upload Cover Pic</h2>
                           <input type="file" name="data[<?php echo $this->Session->read('UTYPE');?>][cpic]" id="<?php echo $this->Session->read('UTYPE');?>Cpic" />
                           <?php echo $this->Form->hidden($this->Session->read('UTYPE').'id',array('value'=>$this->Session->read('USER_ID')));?>
                           <?php echo $this->Form->hidden($this->Session->read('UTYPE').'old_covimage',array('value'=>$setSpecalistArr[$utype]['logo']));?>
                          <!--<input type="file" name="" value="" placeholder="upload pic" />-->
                               
                            <div class="row">
                        
                        <div class="twelve already-member columns">
                          <input type="submit" value="Submit" name="" class="submit-nav">
                       </div>   
                      </div>                    
                        </form>
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Change Cover End -->        
                 <!-- Change Cover popup -->
                <div id="pop555" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
				  <?php if($setSpecalistArr['Trainer']['cardnumber']=='') { ?>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> 
				  
				  <a class="close-nav" onclick="popupClose('pop555');" id="pop5554" href="javascript:void(0);"></a>
				  
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="/home/savecard/" controller="home" enctype="multipart/form-data" class="resform-wrap" id="creditCardForm" method="post" accept-charset="utf-8" onsubmit="return validcard();">
                          <h2>Save Card Detail</h2>
                   
						<?php if($setSpecalistArr['Trainer']['cardname']=='') {?>
						<p>You may cancel your membership at any time during the free trial and you will not be charged. Your credit card will be validated at the time you submit this form and will automatically be charged the membership fee at the end of your free trial.
						<br />Thank you.</br />Personal Training Partners</p>
						<?php } ?>
                               
                            <div class="row">
                        
                       <div class="twelve already-member columns">
                         <input type="text" name="data[Trainer][firstcardname]" value="<?php if(isset($setSpecalistArr['Trainer']['firstcardname'])){echo $setSpecalistArr['Trainer']['firstcardname'];} ?>" id="firstcardname" placeholder="FIRST NAME ON CARD" class="validate[required] text-input"/>
                       </div>
					   <div class="twelve already-member columns">
                         <input type="text" name="data[Trainer][lastcardname]" value="<?php if(isset($setSpecalistArr['Trainer']['lastcardname'])){echo $setSpecalistArr['Trainer']['lastcardname'];} ?>" id="lastcardname" placeholder="LAST NAME ON CARD" class="validate[required] text-input"/>
                       </div>
                       <div class="twelve already-member columns">
                         <input   type="text" name="data[Trainer][cardnumber]" value="<?php if(isset($setSpecalistArr['Trainer']['cardnumber'])){echo $setSpecalistArr['Trainer']['cardnumber'];} ?>" id="cardnumber" placeholder="CARD NUMBER" class="validate[required,creditCard] text-input"/>
                       </div>  
                        <div class="four form-select columns">
							<select id="exmonth" name="data[Trainer][exmonth]"  onchange="document.getElementById('customExpmon').value= this.options[this.selectedIndex].text; ">
								<?php for($n=01;$n<=12;$n++){?>
								<option  <?php if(isset($setSpecalistArr['Trainer']['exmonth'])&&$setSpecalistArr['Trainer']['exmonth']==$y){ echo "selected=selected";}else{' ';}?> value="<?php if ($n<10){ echo "0".$n;}else{echo $n;}?>"  ><?php if ($n<10){ echo "0".$n;} else {echo $n;}?></option>
								<?php }?>
							</select>
							<input type="text" value=" <?php if(isset($setSpecalistArr['Trainer']['exmonth'])){ echo $setSpecalistArr['Trainer']['exmonth'];}else{'-- Select Month--';}?>" id="customExpmon">
							
           
          				</div>  
						<div class="four form-select columns">
							<select id="exyear" name="data[Trainer][exyear]" onchange="document.getElementById('customExyear').value= this.options[this.selectedIndex].text; " >
							<?php for($y=date("Y");$y<=date("Y")+10;$y++)
							{?>
							<option <?php if(isset($setSpecalistArr['Trainer']['exyear'])&&$setSpecalistArr['Trainer']['exyear']==$y){ echo "selected=selected";}else{' ';}?>  value="<?php echo $y;?>" ><?php echo $y;?></option>
							<?php }?>
							
							</select>
					<input type="text" value="<?php if(isset($setSpecalistArr['Trainer']['exyear'])){ echo $setSpecalistArr['Trainer']['exyear'];}else{'-- Select Year--';}?>" id="customExyear">
						</div> 
						 
          				<div class="four already-member columns">
                         <input type="text" name="data[Trainer][cvv]" value="<?php if(isset($setSpecalistArr['Trainer']['cvv'])){echo $setSpecalistArr['Trainer']['cvv'];} ?>"  maxlength="3" id="cvv" placeholder="CVV CODE" class="validate[required] text-input"/>
                       </div>
						<div class="twelve register-radio columns">
							<div class="radio rad" id="box-single" style="float:left;">
							<input type="radio" id="cardtype1" <?php if(isset($setSpecalistArr['Trainer']['cardtype']) && ($setSpecalistArr['Trainer']['cardtype']=='Visa' || $setSpecalistArr['Trainer']['cardtype']=='')){echo 'checked="checked"';}else{ echo ' ';} ?>  name="data[Trainer][cardtype]" value="Visa" >
							
							</div>
							<div class="card_img" style="float:left;"><img src="<?php echo BASE_URL;?>img/visa.png" /></div>
							
							<div class="radio rad" id="box-single" style="float:left;">
							<input type="radio" <?php if(isset($setSpecalistArr['Trainer']['cardtype']) && $setSpecalistArr['Trainer']['cardtype']=='Mastercard'){echo 'checked="checked"';}else{ echo ' ';} ?> id="cardtype2" name="data[Trainer][cardtype]" value="Mastercard">							
							</div>
							<div class="card_img" style="float:left;"><img src="<?php echo BASE_URL;?>img/master.png" /></div>
							
							<div class="radio rad" id="box-single" style="float:left;">
							<input type="radio" <?php if(isset($setSpecalistArr['Trainer']['cardtype']) && $setSpecalistArr['Trainer']['cardtype']=='AmericanExpress'){echo 'checked="checked"';}else{ echo ' ';} ?>  id="cardtype3" name="data[Trainer][cardtype]" value="AmericanExpress">
							</div>
							<div class="card_img" style="float:left;"><img src="<?php echo BASE_URL;?>img/american.png" /></div>
							</div> 
						</div> 
                        <div class="twelve already-member columns">
                          <input type="submit" value="Submit" name="" class="submit-nav">
                       </div>   
                      </div>                    
                        </form>
                      </div>
                     
                    </div>
					<?php }elseif($setSpecalistArr['Trainer']['cardnumber']!='') {?>
					
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> 
				  <?php if($setSpecalistArr['Trainer']['cardname']!='') { ?>
				  <a class="close-nav" onclick="popupClose('pop555');" id="pop5554" href="javascript:void(0);"></a>
				  <?php } ?>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="/home/updatecard/" controller="home" enctype="multipart/form-data" class="resform-wrap" id="creditCardForm" method="post" accept-charset="utf-8" onsubmit="return validcard();">
                          <h2>Update Card Detail</h2>                
						
                               
                            <div class="row">
                        
                        <div class="twelve already-member columns">
                         <input type="text" name="data[Trainer][firstcardname]" value="<?php if(isset($setSpecalistArr['Trainer']['firstcardname'])){echo $setSpecalistArr['Trainer']['firstcardname'];} ?>" id="firstcardname" placeholder="FIRST NAME ON CARD" class="validate[required] text-input"/>
                       </div>
					   <div class="twelve already-member columns">
                         <input type="text" name="data[Trainer][lastcardname]" value="<?php if(isset($setSpecalistArr['Trainer']['lastcardname'])){echo $setSpecalistArr['Trainer']['lastcardname'];} ?>" id="lastcardname" placeholder="LAST NAME ON CARD" class="validate[required] text-input"/>
                       </div>
                       <div class="twelve already-member columns">
                         <input   type="text" name="data[Trainer][cardnumber]" value="<?php if(isset($setSpecalistArr['Trainer']['cardnumber'])){echo $setSpecalistArr['Trainer']['cardnumber'];} ?>" id="cardnumber" placeholder="CARD NUMBER" class="validate[required,creditCard] text-input"/>
                       </div>  
                        <div class="four form-select columns">
							<select id="exmonth" name="data[Trainer][exmonth]"  onchange="document.getElementById('customExpmon').value= this.options[this.selectedIndex].text; ">
								<?php for($n=01;$n<=12;$n++){?>
								<option  <?php if(isset($setSpecalistArr['Trainer']['exmonth'])&&$setSpecalistArr['Trainer']['exmonth']==$y){ echo "selected=selected";}else{' ';}?> value="<?php if ($n<10){ echo "0".$n;}else{echo $n;}?>"  ><?php if ($n<10){ echo "0".$n;} else {echo $n;}?></option>
								<?php }?>
							</select>
							<input type="text" value=" <?php if(isset($setSpecalistArr['Trainer']['exmonth'])){ echo $setSpecalistArr['Trainer']['exmonth'];}else{'-- Select Month--';}?>" id="customExpmon">
							
           
          				</div>  
						<div class="four form-select columns">
							<select id="exyear" name="data[Trainer][exyear]" onchange="document.getElementById('customExyear').value= this.options[this.selectedIndex].text; " >
							<?php for($y=date("Y");$y<=date("Y")+10;$y++)
							{?>
							<option <?php if(isset($setSpecalistArr['Trainer']['exyear'])&&$setSpecalistArr['Trainer']['exyear']==$y){ echo "selected=selected";}else{' ';}?>  value="<?php echo $y;?>" ><?php echo $y;?></option>
							<?php }?>
							
							</select>
					<input type="text" value="<?php if(isset($setSpecalistArr['Trainer']['exyear'])){ echo $setSpecalistArr['Trainer']['exyear'];}else{'-- Select Year--';}?>" id="customExyear">
						</div> 
						 
          				<div class="four already-member columns">
                         <input type="text" name="data[Trainer][cvv]" value="<?php if(isset($setSpecalistArr['Trainer']['cvv'])){echo $setSpecalistArr['Trainer']['cvv'];} ?>"  maxlength="3" id="cvv" placeholder="CVV CODE" class="validate[required] text-input"/>
                       </div>
						<div class="twelve register-radio columns">
							<div class="radio rad" id="box-single" style="float:left;">
							<input type="radio" id="cardtype1" <?php if(isset($setSpecalistArr['Trainer']['cardtype']) && ($setSpecalistArr['Trainer']['cardtype']=='Visa' || $setSpecalistArr['Trainer']['cardtype']=='')){echo 'checked="checked"';}else{ echo ' ';} ?>  name="data[Trainer][cardtype]" value="Visa" >
							
							</div>
							<div class="card_img" style="float:left;"><img src="<?php echo BASE_URL;?>img/visa.png" /></div>
							
							<div class="radio rad" id="box-single" style="float:left;">
							<input type="radio" <?php if(isset($setSpecalistArr['Trainer']['cardtype']) && $setSpecalistArr['Trainer']['cardtype']=='Mastercard'){echo 'checked="checked"';}else{ echo ' ';} ?> id="cardtype2" name="data[Trainer][cardtype]" value="Mastercard">							
							</div>
							<div class="card_img" style="float:left;"><img src="<?php echo BASE_URL;?>img/master.png" /></div>
							
							<div class="radio rad" id="box-single" style="float:left;">
							<input type="radio" <?php if(isset($setSpecalistArr['Trainer']['cardtype']) && $setSpecalistArr['Trainer']['cardtype']=='AmericanExpress'){echo 'checked="checked"';}else{ echo ' ';} ?>  id="cardtype3" name="data[Trainer][cardtype]" value="AmericanExpress">
							</div>
							<div class="card_img" style="float:left;"><img src="<?php echo BASE_URL;?>img/american.png" /></div>
							</div> 
						</div> 
                        <div class="twelve already-member columns">
                          <input type="submit" value="Submit" name="" class="submit-nav">
                       </div>   
                      </div>                    
                        </form>
                      </div>
                     
                    </div>
					<?php }?>
                  </div>
				  
				  
<!--POP UP BILLING INFORMATION-->
<style type="text/css">
.register-form-popup.billing{left: 40% !important; width: 800px !important;}
.field-pad-billing{padding: 10px 15px;}
</style>
<script type="text/javascript">
 function getRate(plan,cost,id)
 {
		
		var plan_cost = $('#trainercost').val(cost);		
		$('#subsplanid').val(id);		
		var total_cost = cost*1;		
		$('#trainertotal').val(total_cost);
		$('#coupon-block').show();
		$('#tnumber').show();
		$('#tcost').show();
		$('#totalvalue').show();
		$('#sign').show();
		$('#signmul').show();
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if (plan=='Yearly')
		{
			var someDate = new Date();
			var numberOfDaysToAdd = 365;
			someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
			var dd = someDate.getDate();
			var mm = someDate.getMonth() + 1;
			var y = someDate.getFullYear();
			var someFormattedDate = dd + '/'+ mm + '/'+ y;
			var du = "Billed Yearly on day "+dd;			
			$('#duration').html(du);
		}
		if (plan=='Monthly')
		{
			var someDate = new Date();
			var numberOfDaysToAdd = 30;
			someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
			var dd = someDate.getDate();
			var mm = someDate.getMonth() + 1;
			var y = someDate.getFullYear();
			var someFormattedDate = dd + '/'+ mm + '/'+ y;
			var du = "Billed Monthly on day "+dd;
			$('#duration').html(du);
		} 
		
 }
</script>
<div id="popbillinginfo" class="main-popup">
	
	<div class="overlaybox common-overlay"></div>
	
	<div id="thirtydays" class="register-form-popup billing common-overlaycontent"> 
		
		<a class="close-nav" onclick="popupClose('popbillinginfo');" id="pop5554" href="javascript:void(0);"></a>
		
		<div class="row register-popup-form">
			<div class="twelve columns">
				<div class="three field-pad-billing columns" style="border: 2px solid hsl(0, 0%, 0%); margin: 27px 0; padding: 13px; text-align: justify;">
					<p style="color: hsl(0, 100%, 50%); font-weight: bold;text-align: center;">Billing Support</p>
					<p>See our <a target="_blank" href="<?php echo $config['url']?>manage-pricing">Pricing Page</a> for more information. You can also <a target="_blank"  href="<?php echo $config['url']?>contact-us">contact support</a> with any question.</p>
					<p style="color: hsl(0, 100%, 50%); font-weight: bold;text-align: center;">Need to go?</p>
					<p>We want Personal Training Partners to hep your business grow. If that's not happening, let us know or you can <a href="#" onclick="cancelmyaccount(<?php echo $setSpecalistArr['Trainer']['id'];?>);">close your account.</a></p>					
				</div>
				<div class="nine field-pad-billing columns">					
					<div style="clear:both"></div>					
					<form action="/home/newpayment/" controller="home" enctype="multipart/form-data" class="resform-wrap" id="billingform" method="post" accept-charset="utf-8">		
					<h2>Your Billing Information</h2>
					<hr />
					<?php //echo "<pre>"; print_r($checksubsplan); echo "</pre>"; ?>
					<div class="row">
						<div class="twelve columns">
							<div class="six columns">
								<p style="color: hsl(0, 0%, 50%);font-size: 16px; font-weight: bold;">Individual Trainer</p>
								<p style="color: hsl(0, 100%, 50%); font-weight: bold;">Select Payment Mode</p>
								<?php
								foreach($checksubsplan as $ch_plan)
								{
									$vpt[]=$ch_plan['Subscription']['plan_type'];
									$ch_plan['Subscription']['id'];
									if($ch_plan['Subscription']['plan_type']=='Monthly')
									{?>
										<div class="six check-condition columns">
											<div class="radio rad" id="box-single" style="float:left;">
											<input type="radio" class="validate[required]" id="mode" name="data[Trainer][paymentmode]" value="Monthly" onclick="getRate('<?php echo $ch_plan['Subscription']['plan_type']?>','<?php echo $ch_plan['Subscription']['plan_cost']?>','<?php echo $ch_plan['Subscription']['id']?>');">
											</div>
											<div class="card_img" style="float:left;margin:0 0 0 5px;"><?php echo$ch_plan['Subscription']['plan_name']. ' ' .$ch_plan['Subscription']['plan_type']?></div>
											
										</div>
								 <?php }
									if($ch_plan['Subscription']['plan_type']=='Yearly')
									{?>
										<div class="six check-condition columns">
											<div class="radio rad" id="box-single" style="float:left;">
											<input type="radio" id="mode" class="validate[required]" name="data[Trainer][paymentmode]" value="Yearly"onclick="getRate('<?php echo $ch_plan['Subscription']['plan_type']?>','<?php echo $ch_plan['Subscription']['plan_cost']?>','<?php echo $ch_plan['Subscription']['id']?>');" >
											</div>	
											<div class="card_img" style="float:left; margin:0 0 0 5px;"><?php echo$ch_plan['Subscription']['plan_name']. ' ' .$ch_plan['Subscription']['plan_type']?></div>										
										</div>
								 <?php }}
								?>
								<input type="hidden" value="" id="subsplanid" name="subsplanid" />
								<div class="twelve already-member columns" style="margin:15px 0 0 0;">
									<div class="two columns" id="tnumber" style="display:none;">
									<p style="margin-bottom: 0px;">Trainer</p>
										<input type="text" name="data[Trainer][number]" value="1" id="trainernumber" readonly />
									</div>
									<div class="one columns" id="signmul" style="display:none;">
										<p style="text-align:center; font-size:15px;">x</p>
									</div>
									<div class="three columns" id="tcost" style="display:none;">
										<p style="margin-bottom: 0px;">Cost</p>
										<input type="text" name="data[Trainer][cost]" value="" id="trainercost" readonly />
									</div>
									<div class="one columns" id="sign" style="display:none;">
										<p style="text-align:center; font-size:15px;">=</p>
									</div>
									<div class="five columns" id="totalvalue" style="display:none;">
										<p style="margin-bottom: 0px;">Total Cost</p>
										<p style="float: left;padding: 5px;">$</p><input type="text" name="data[Trainer][total]" value="" id="trainertotal" readonly style="float: left; width: 58px;" />
									</div>									
								</div>
								<div id="duration" style="color: hsl(0, 100%, 50%);    font-weight: bold; clear:both;"></div>
								<br />
								<div id="coupon-block" style="display:none">
								<p style="color: hsl(0, 0%, 50%);font-size: 16px; font-weight: bold;">Apply Coupon Code</p>
								<div class="row" id="discountedprice" style="padding: 0 0 10px 10px;color: hsl(0, 100%, 50%);font-size: 15px; font-weight: bold;"></div>  
								<div class="twelve already-member columns">
									<input type="text" name="data[Trainer][coupon_code]" value="" id="coupon_code" placeholder="Coupon Code" class=" text-input"/>
								</div>
								<input type="button" id="coupon-button" onclick="couponpost(document.getElementById('coupon_code').value,document.getElementById('trainertotal').value);" value="Go" name="" class="submit-nav" />
								<input style="display:none;" type="button" id="coupon-button-cancel" onclick="getcancelreset(document.getElementById('coupon_code').value,document.getElementById('trainertotal').value,document.getElementById('trainercost').value);" value="Cancel" name="" class="submit-nav" />
								</div>
								<div style="clear:both"></div>
								
								<div style="clear:both"></div>
								<p style="color: hsl(0, 0%, 50%);font-size: 16px; font-weight: bold;">Credit Card Info</p>
								<div class="twelve already-member columns">
									<input type="text" name="data[Trainer][firstcardname]" value="" id="firstcardname" placeholder="FIRST NAME ON CARD" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Trainer][lastcardname]" value="" id="lastcardname" placeholder="LAST NAME ON CARD" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input   type="text" name="data[Trainer][cardnumber]" value="" id="cardnumber" placeholder="CARD NUMBER" class="validate[required,creditCard] text-input"/>
								</div> 
								<div class="four form-select columns">
									<select id="exmonth" name="data[Trainer][exmonth]"  onchange="document.getElementById('customExpmon2').value= this.options[this.selectedIndex].text; ">
									<?php for($n=01;$n<=12;$n++){?>
									<option  <?php if(isset($setSpecalistArr['Trainer']['exmonth'])&&$setSpecalistArr['Trainer']['exmonth']==$y){ echo "selected=selected";}else{' ';}?> value="<?php if ($n<10){ echo "0".$n;}else{echo $n;}?>"  ><?php if ($n<10){ echo "0".$n;} else {echo $n;}?></option>
									<?php }?>
									</select>
									<input type="text" value="" id="customExpmon2">	
								</div> 
								<div class="four form-select columns">
									<select id="exyear" name="data[Trainer][exyear]" onchange="document.getElementById('customExyear2').value= this.options[this.selectedIndex].text; " >
									<?php for($y=date("Y");$y<=date("Y")+10;$y++)
									{?>
									<option value="<?php echo $y;?>" ><?php echo $y;?></option>
									<?php }?>
									</select>
									<input type="text" value="" id="customExyear2">
								</div>
								<div class="four already-member columns">
									<input type="text" name="data[Trainer][cvv]" value=""  maxlength="3" id="cvv" placeholder="CVV CODE" class="validate[required] text-input"/>
								</div>
								<div class="twelve register-radio columns">
									<div class="radio rad" id="box-single" style="float:left;">
										<input type="radio" id="cardtype1" <?php if(isset($setSpecalistArr['Trainer']['cardtype']) && ($setSpecalistArr['Trainer']['cardtype']=='Visa' || $setSpecalistArr['Trainer']['cardtype']=='')){echo 'checked="checked"';}else{ echo ' ';} ?>  name="data[Trainer][cardtype]" value="Visa" >
									</div>
									<div class="card_img" style="float:left;"><img src="<?php echo BASE_URL;?>img/visa.png" /></div>
									<div class="radio rad" id="box-single" style="float:left;">
										<input type="radio" <?php if(isset($setSpecalistArr['Trainer']['cardtype']) && $setSpecalistArr['Trainer']['cardtype']=='Mastercard'){echo 'checked="checked"';}else{ echo ' ';} ?> id="cardtype2" name="data[Trainer][cardtype]" value="Mastercard">							
									</div>
									<div class="card_img" style="float:left;"><img src="<?php echo BASE_URL;?>img/master.png" /></div>

									<div class="radio rad" id="box-single" style="float:left;">
										<input type="radio" <?php if(isset($setSpecalistArr['Trainer']['cardtype']) && $setSpecalistArr['Trainer']['cardtype']=='AmericanExpress'){echo 'checked="checked"';}else{ echo ' ';} ?>  id="cardtype3" name="data[Trainer][cardtype]" value="AmericanExpress">
									</div>
									<div class="card_img" style="float:left;"><img src="<?php echo BASE_URL;?>img/american.png" /></div>
									
									<div class="twelve check-condition columns">
										<?php echo $this->Form->input('checkbox',  array('label'=>false,'name'=>'tnc','id'=>'tnc','class'=>'validate[required]','type'=>'checkbox','div' => false)); ?>
										<span>Yes I agree to Personal Training Partners <a href="<?php echo $config['url']?>terms-of-use" target="_blank">Terms of Use</a> and <a href="<?php echo $config['url']?>privacy-policy" target="_blank">Privacy Policy</a>.</span> 
									</div>
								</div>
							</div>
							<div class="six columns">
								<p style="color: hsl(0, 0%, 50%);font-size: 16px; font-weight: bold;">Billing Address</p>
								<div class="twelve already-member columns">
									<input type="text" name="data[Trainer][email]" value="" id="email" placeholder="Email" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Trainer][phone]" value="" id="phone" placeholder="Phone Number" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Trainer][address1]" value="" id="address1" placeholder="Address 1" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Trainer][address2]" value="" id="address2" placeholder="Address 2"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Trainer][city]" value="" id="city" placeholder="City" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Trainer][state]" value="" id="state" placeholder="State" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Trainer][zip]" value="" id="zip" placeholder="Zip" class="validate[required] text-input"/>
								</div>
								<div class="twelve form-select columns">
									  <?php $default3=array('226'); ?>
										<select name="data[Trainer][country]" id="dd" onChange="document.getElementById('customSelect').value= this.options[this.selectedIndex].text">		   
										<?php foreach ($countries as $key=>$country){ ?>
											<option value="<?php echo $key; ?>" <?php if(in_array($key,$default3)) { echo 'selected="selected"';} ?>><?php echo $country; ?></option>
										<?php  }?>							 
										</select>					
										<input type="text" id="customSelect" value="UNITED STATES"/>
								</div>            
							</div>
						</div>
							
					 
					
					 

					
					 
					</div> 
					<div class="twelve already-member columns">
					<input type="submit" value="Submit" name="" class="submit-nav">
					</div>   
					</div>                    
					</form>
				</div>
			</div>

		
			

</div>


</div>
<!--POP UP BILLING INFORMATION-->
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
                </div>
                <!-- Change Cover End -->         
<script type="text/javascript">
$(document).ready(function(){
		var hash = window.location.hash;
       if(hash=='#Certification'){
       
       	$("#Profile").css('display','none');
       	$("#Certification").css('display','block');
       	$("html, body").animate({ scrollTop: 0 }, "slow");
       	$('a[href=' + hash + ']').addClass('active');
       	var shref='#Profile';
       	$('a[href=' + shref + ']').removeClass('active');
       }
       if(hash=='#Bio'){
       	$("#Profile").css('display','none');
       	$("#Bio").css('display','block');
       	$("html, body").animate({ scrollTop: 0 }, "slow");
       	$('a[href=' + hash + ']').addClass('active');
       	var sshref='#Profile';
       	$('a[href=' + sshref + ']').removeClass('active');
       }
});
	 

</script>
<?php
$billingpopup = $_GET['billpop'];
if ($billingpopup==1)
{
		echo "<script type='text/javascript'>
		function codeAddress() {
            popupOpen('popbillinginfo');
        }
		window.onload = codeAddress;
		</script>";
		
}
?>