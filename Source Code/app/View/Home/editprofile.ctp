<?php
/*echo '<pre>';
//print_r($setSpecalistArr);
print_r($this->data);
echo '</pre>';*/

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
<style type="text/css">
.change-pic { width:120px!important; }
</style>
<script>
function editforma()
{	
	var str = $("#publicproname").val();
	var flg=1;
	var mes='';
	if( trimString(str)=='')
	{
	    flg=1;
	    mes="Please enter public profile name";
	}
	else
	{
		$.ajax({
				url:"<?php echo $config['url'];?>home/checkduplicatename/",
				type:"POST",
				data:{str:str},
				success:function(e) {
					var response = eval(' ( '+e+' ) ');
					if( response.responseclassName == "nSuccess" ) {
					     flg=0;
	                     mes="";
	                     
					}
					else
					{
						
						flg=1;
	                     mes=response.errorMsg;
					}
				}
		});
		
			
	}
	//alert(flg);
	 if(flg==1)
	 {
	 	alert('Please wait we are checking the form data.');
		//alert(mes);
		
		if(mes!='This public profile name is available.' && mes!='')
		{
		alert(mes);
	 	return false;
		} else
		{
                 return true;
		}
	 } else
	 {
	 	
	    return true;	
	 }
}

$(document).ready(function(){
	//$("#Phone").intlTelInput();
	//$("#Mobile").intlTelInput();
});
function editstatus(str)
{
	//alert(str);
	var editsecHtml='<textarea name="userfb_status" id="userfb_statusid"></textarea><input type="button" name="submit" value="Save" onclick="saveedit('+str+');" class="change-pic-nav" style="width:50px;"/><input type="button" name="cancel" class="change-pic-nav" style="width:58px;margin-left:10px;" onclick="canceledit('+str+');" value="Cancel"/>';
	$('#userfb_status').html(editsecHtml);
	
}
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

function removePic(elem) {
		
	r = confirm("Are you sure want to remove the image ?");
	if(r){
		elem.innerHTML = "Please Wait,while deleting";
		$.ajax({
				url:"<?php echo $config['url'];?>trainers/removePicTrainer/",
				type:"POST",
				data:{id:elem.id},
				success:function(e) {
					var response = eval(' ( '+e+' ) ');
					if( response.responseclassName == "nSuccess" ) {
						elem.innerHTML = "Successfully deleted";
						$("#imgCont").slideUp("slow");
						$("#image").val("");
						$("#new_image").val("");
						$("#CategoryImagePath").val("");
						$("#ClubOldImage").val("");
						$("#file").className  = 'validate[required]';
					}
				}
		});
	}
}
function removeWebsiteLogo(elem) {
		
	r = confirm("Are you sure want to remove the image ?");
	if(r){
		elem.innerHTML = "Please Wait,while deleting";
		$.ajax({
				url:"<?php echo $config['url'];?>home/removeWebsiteLogoTrainer/",
				type:"POST",
				data:{id:elem.id},
				success:function(e) {
					var response = eval(' ( '+e+' ) ');
					if( response.responseclassName == "nSuccess" ) {
						elem.innerHTML = "Successfully deleted";
						$("#imgCont").slideUp("slow");
						$("#image").val("");
						$("#new_image").val("");
						$("#CategoryImagePath").val("");
						$("#ClubOldImage").val("");
						$("#file").className  = 'validate[required]';
					}
					window.location.assign("<?php echo $config['url'];?>home");
				}
		});
	}
}
function validateconfirmpass()
{
	   var oldpassword=$('#oldpassword').val();
	   var newpassword=$('#newpassword').val();
	   var conpassword= $('#conpassword').val();
	  
		
		if(oldpassword=='' || newpassword=='' || conpassword=='')
		{
		alert('Please Fill all fields');
		return false;
		}
		
		
	else
	{
		return true;
	}

}

</script>
<style>
.sltbx{font-family: Arial, Helvetica, sans-serif;
height: 36px;
left: 6px;
opacity: 0;
position: absolute;
top: 0;
width: 97%;
z-index: 99999;}

<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
</style>
<section class="contentContainer clearfix">
    <div class="inside-banner changecover-pic">
    <div class="change-coverpic" onclick="popupOpen('pop5');"><img src="<?php echo $config['url'];?>images/pencial_icon.png" /> Change Cover </div>
      <div class="row">
        <div class="eight inside-head offset-by-four columns">
          <h2 class="client-name"><?php echo $uname;?></h2>
          <h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['city'].', '.$setSpecalistArr[$utype]['state'];?></h3>
          <p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ if($this->Session->read('USER_ID') && ($this->Session->read('USER_ID')==$setSpecalistArr[$utype]['id'])){ echo '<a href="javascript:void(0);" onclick="editstatus('.$setSpecalistArr[$utype]['id'].');" style="color:#fff;">'.$setSpecalistArr[$utype]['userfb_status'].'</a>';} else {echo $setSpecalistArr[$utype]['userfb_status'];}} elseif($this->Session->read('USER_ID') && ($this->Session->read('USER_ID')==$setSpecalistArr[$utype]['id'])){ echo '<a href="javascript:void(0);" onclick="editstatus('.$setSpecalistArr[$utype]['id'].');" style="color:#fff;">Set your current status, click here!!!</a>';}?></p>
        </div>
      </div>
    </div>
    <div class="row">
       <?php echo $this->element('lefttrainer');?>
      <div class="eight inside-head columns">
        <ul class="profile-tabs-list desktop-tabs clearfix">
        
         <li><a href="<?php echo $config['url'];?>home" ><span class="profile-ico"></span>Edit My Account</a></li>
          <li><a href="#Profile" class="active"><span class="profile-ico"></span>Edit My Profile</a></li>
          
        
          <li><a href="<?php echo $config['url'];?>home/#Certification" ><span class="certification-ico"></span>Edit My Certifications</a></li>
          <li class="nomarg"><a href="<?php echo $config['url'];?>home/#Bio" ><span class="bio-ico"></span>Edit My Webpage</a></li>
       
        </ul>    
       
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Edit Profile</a></li>
           <div class="clear">&nbsp;</div>
          <div id="Profile" class="euual-height desktop-tab profille-tabs-content clearfix">
          <div class="row">
            <div class="two columns change-pic">
              <div class="change-pic-img"> <img src="<?php echo $logo;?>" width="75" height="76" /> </div>
              <a href="#" class="change-pic-nav" onclick="popupOpen('pop4');">Change Picture</a> 
                 <!-- Singup popup -->
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
                        <p><i>(Please upload your logo no larger than 2MB in size)</i></p>
                        <div class="twelve already-member columns">
                          <input type="submit" value="Submit" name="" class="submit-nav">
                       </div>   
                      </div>                    
                        </form>
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Singup popup End --> 
              </div>
			<!-- CHANGE PASSWORD-->
			<div class="two columns change-pic" style="float:right">
               <a href="#" class="change-pic-nav" onclick="popupOpen('popchangepass');">Change Password</a> 
            </div>
			<!-- CHANGE PASSWORD-->
            <div class="ten columns profile-change-pictext">
              <!--<h2>About Me</h2>-->
              <p><?php echo $setSpecalistArr[$utype]['about_us'];?></p>
            </div>
            
          </div>
          <div>
          
            <form accept-charset="utf-8" method="post" id="validc" class="resform-wrap" enctype="multipart/form-data" controller="home" action="/home/editprofile/" onsubmit="return editforma();">
		<?php echo $this->Form->hidden('Trainer.id'); ?>
		<?php /* ?>
            <div class="row">
              <div class="twelve form-select columns">
               
              	<?php  echo $this->Form->select('Trainer.certification_org_id',$cert_org,array('empty'=>'-- Select Certification Organization--','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectOrgid\').value= this.options[this.selectedIndex].text')); ?>     
                
			
                <input type="text" id="customSelectOrgid" value="<?php if($this->data['Trainer']['certification_org_id']!=''){
                foreach($cert_org as $key=>$val)
                {
                  if($key==$this->data['Trainer']['certification_org_id'])
                  {
                  	 echo $val;
                  }	
                	
                }
                }else{echo '-- Select Certification Organization--';}?>"/>
              </div>
            </div>
            
              <div class="row">
              <div class="twelve form-select columns">
               
              <?php  echo $this->Form->select('Trainer.certification_id',$certifications,array('empty'=>'-- Select Certification --','class'=>'topAction','onchange'=>'document.getElementById(\'customSelectCrtid\').value= this.options[this.selectedIndex].text')); ?>
              				
                <input type="text" id="customSelectCrtid" value="<?php if($this->data['Trainer']['certification_id']!=''){
                foreach($certifications as $key=>$val)
                {
                  if($key==$this->data['Trainer']['certification_id'])
                  {
                  	 echo $val;
                  }	
                	
                }
                }else{echo '-- Select Certification --';}?>"/>
              </div>
            </div>
            
            <?php echo $this->Form->text('Trainer.certification_no', array('maxlength'=>255,'placeholder'=>'Certification No.')); ?>

				<?php echo $this->Form->error('Trainer.certification_no', null, array('class' => 'error')); ?>
				
			 <div class="row">
              <div class="twelve form-select columns">
               <?php  echo $this->Form->select('Trainer.degree_id',$degrees,array('empty'=>'-- Select Degree --','class'=>'topAction','onchange'=>'document.getElementById(\'customSelectDegid\').value= this.options[this.selectedIndex].text')); ?>         
              				
                <input type="text" id="customSelectDegid" value="<?php if($this->data['Trainer']['degree_id']!=''){
                foreach($degrees as $key=>$val)
                {
                  if($key==$this->data['Trainer']['degree_id'])
                  {
                  	 echo $val;
                  }	
                	
                }
                }else{echo '-- Select Degree --';}?>"/>
              </div>
            </div>	
			<?php */ ?>	
            
            <?php //echo $this->Form->text('Trainer.username', array('maxlength'=>255,'id'=>'Username','readonly'=>'readonly', 'class'=>'validate[required]','placeholder'=>'Username')); ?>

				<?php //echo $this->Form->error('Trainer.username', null, array('class' => 'error')); ?>
           <?php echo $this->Form->text('Trainer.email', array('maxlength'=>255,'id'=>'EmailAddress','readonly'=>'readonly', 'class'=>'validate[required,custom[email],ajax[agantEmailValidate]]','placeholder'=>'Email Address')); ?>

				<?php echo $this->Form->error('Trainer.email', null, array('class' => 'error')); ?>
				 <?php //echo $this->Form->password('Trainer.password', array('maxlength'=>255, 'class'=>'validate[required]','placeholder'=>'Password')); ?>

				<?php //echo $this->Form->error('Trainer.password', null, array('class' => 'error')); ?>
				 <?php echo $this->Form->text('Trainer.publicproname', array('maxlength'=>255,'id'=>'publicproname', 'class'=>'validate[required]','placeholder'=>'Please create a unique public profile name for your website','style'=>'background:none repeat scroll 0 0 #dbeae3')); ?> <span style="position: absolute; z-index: 99; right: 52px; margin-top: -38px; color: rgb(255, 0, 0);">* Public Profile Name</span>

				<?php echo $this->Form->error('Trainer.publicproname', null, array('class' => 'error')); ?>
            <div class="row">
              <div class="six columns">
             
				
<?php echo $this->Form->text('Trainer.first_name', array('maxlength'=>255,'id'=>'FirstName','class'=>'validate[required]','placeholder'=>'First name')); ?>

				<?php echo $this->Form->error('Trainer.first_name', null, array('class' => 'error')); ?>
                
               
              </div>
              <div class="six columns">
             
				
				<?php echo $this->Form->text('Trainer.last_name', array('maxlength'=>255,'id'=>'LastName','class'=>'validate[required]','placeholder'=>'Last name')); ?>

				<?php echo $this->Form->error('Trainer.last_name', null, array('class' => 'error')); ?>

               
              
              </div>
            </div>
            	<?php echo $this->Form->text('Trainer.address', array('maxlength'=>255,'id'=>'Address','placeholder'=>'Address')); ?>

				<?php echo $this->Form->error('Trainer.address', null, array('class' => 'error')); ?>
           
            <div class="row">
              <div class="six columns">
              <?php echo $this->Form->text('Trainer.city', array('maxlength'=>255, 'id'=>'city','placeholder'=>'City')); ?>
				
				<?php echo $this->Form->error('Trainer.city', null, array('class' => 'error')); ?>
               
              </div>
              <div class="six columns">
              <?php echo $this->Form->text('Trainer.state', array('maxlength'=>255, 'id'=>'state','placeholder'=>'State')); ?>
				
				<?php echo $this->Form->error('Trainer.state', null, array('class' => 'error')); ?>
               
              </div>
            </div>
            <div class="row">
              <div class="twelve form-select columns">
              
              
				<?php echo $this->Form->select('Trainer.country', $countries, array('style'=>'','empty'=>'-- Select Country --','onChange'=>'document.getElementById(\'customSelect\').value= this.options[this.selectedIndex].text','default'=>226));?>
				
				<?php echo $this->Form->error('Trainer.country', null, array('class' => 'error')); ?>
              
               
                <input type="text" id="customSelect" value="<?php if($this->data['Trainer']['country']!=''){
                foreach($countries as $key=>$val)
                {
                  if($key==$this->data['Trainer']['country'])
                  {
                  	 echo $val;
                  }	
                	
                }
                }else{echo 'UNITED STATES';}?>"/>
              </div>
            </div>
       
            

            
            <?php echo $this->Form->text('Trainer.zip', array('maxlength'=>255, 'id'=>'zip','placeholder'=>'Zip code')); ?>
				
				<?php echo $this->Form->error('Trainer.zip', null, array('class' => 'error')); ?>
            
            <div class="row">
              <div class="six columns">
              	<?php echo $this->Form->text('Trainer.phone', array('maxlength'=>255,'id'=>'Phone','placeholder' => 'Phone 555-555-5555')); ?>

				<?php echo $this->Form->error('Trainer.phone', null, array('class' => 'error')); ?>
              </div>
              <div class="six columns">
                <?php echo $this->Form->text('Trainer.mobile', array('maxlength'=>255,'id'=>'Mobile','placeholder' => 'Mobile 555-555-5555')); ?>

				<?php echo $this->Form->error('Trainer.mobile', null, array('class' => 'error')); ?>
              </div>
            </div>
           	<?php /*echo $this->Form->textarea('Trainer.certifications', array('maxlength'=>500, 'id'=>'certifications','placeholder'=>'Certifications')); ?>
				
				<?php echo $this->Form->error('Trainer.certifications', null, array('class' => 'error')); ?>
					<?php echo $this->Form->textarea('Trainer.testimonials', array('maxlength'=>500, 'id'=>'testimonials','placeholder'=>'Testimonials')); ?>
				
				<?php echo $this->Form->error('Trainer.testimonials', null, array('class' => 'error')); ?>
				
           <?php echo $this->Form->textarea('Trainer.Bio', array('maxlength'=>500, 'id'=>'Bio','placeholder'=>'Bio')); ?>
				
				<?php echo $this->Form->error('Trainer.Bio', null, array('class' => 'error')); */?>
           
            <div class="row">
              <div class="six columns"><span class="file-wrapper">
              <?php ?>
              	<?php echo $this->Form->file('Trainer.website_logo');?>
								<?php echo $this->Form->error('Trainer.website_logo', null, array('class' => 'error'));?>
							</div>
							<div class="fix"></div>
							<?php echo $this->Form->hidden('Trainer.id'); ?>
							
							 <?php echo $this->Form->hidden('Trainer.old_image',array('value'=>$this->request->data["Trainer"]["website_logo"]));?>
							
							 <?php  ?>
						</div>
							<?php if($setSpecalistArr[$dbusertype]['trainer_type']!= 'C') { ?>
							<div id="imgCont" class="rowElem noborder">
							<p style="margin:0 0 0 0;"><i>Please upload your logo no larger than 2MB in size</i></p>
						<div class="formRight">
						
							<div style="float:left;<?php if( array_key_exists("website_logo",$this->request->data["Trainer"]) && !empty($this->request->data["Trainer"]["website_logo"]) ) { ?>border:1px solid #d8d8d8;<?php } ?>padding:8px;" id="video_container">
							<?php if( array_key_exists("website_logo",$this->request->data["Trainer"]) && !empty($this->request->data["Trainer"]["website_logo"]) ) { ?>
								<img border="1"  width="100px" src="<?php echo $config["imgurl"];?>uploads/<?php echo $this->data["Trainer"]["website_logo"];?>"/>
								<span style="margin-left:11px;margin-top:-22px;position:absolute;">
									<a id="<?php echo $this->data["Trainer"]["id"];?>" onclick="removeWebsiteLogo(this);"  style="cursor:pointer" title="click to delete">
										<img border="1" src="<?php echo $config["imgurl"];?>img/cross.png"/>
									</a>
								</span>
							<?php 	} ?>	
							</div>
						</div>
						
					<div class="clear"></div>
					<?php  ?>
						<?php echo $this->Form->file('Trainer.website_logo');?>
								<?php echo $this->Form->error('Trainer.website_logo', null, array('class' => 'error'));?>
							
							<?php echo $this->Form->hidden('Trainer.id'); ?>
							
							 <?php echo $this->Form->hidden('Trainer.old_image',array('value'=>$this->request->data["Trainer"]["website_logo"]));?>
							 <?php ?>
                
               </div>
			   <?php } else{} ?>
             
            </div>
            <!--<input type="text" name="" value="" placeholder="Certifications" />
            <input type="text" name="" value="" placeholder="Degrees" />-->
         
            <input type="submit" class="submit-nav" name="submit" value="Save"  />
          </form>
          
         

          </div>
        </div>
          
         
        </div>
        </ul>      
      </div>
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
    <!-- Change Cover popup -->
                <div id="pop5" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('pop5');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="/home/coverpic/" controller="home" enctype="multipart/form-data" class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validcuppic();">
                          <h2>Upload Cover Pic</h2>
						  <p><i>(Please upload your picture within 2 MB in size)</i></p>
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
<!-- Change Password popup -->
                <div id="popchangepass" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popchangepass');" id="popchangepass" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
					       
                        <form action="/home/changepass/" controller="home" enctype="multipart/form-data" class="resform-wrap" id="changepassword" method="post" accept-charset="utf-8" onsubmit="return validateconfirmpass();">
                          <h2>Change Password</h2>
                          
						  <input type="password" class="validate[required,minSize[8]] text-input" placeholder="Old Password" id="oldpassword" value="" name="oldpassword">
						  <?php //echo $this->Form->error('Trainee.password', null, array('class' => 'error')); ?>						  
						  <input type="password" class="validate[required,minSize[8]] text-input" placeholder="New Password" id="newpassword" value="" name="newpassword">
						  
						  <input type="password" class="validate[required,equals[newpassword],minSize[8]]" placeholder="Comfirm Password" id="conpassword" value="" name="conpassword">
						  
						  <input type="hidden" id="originalpassword" value="<?php echo $pas = $this->data[Trainer][password]; ?>" name="originalpassword">
						  
						  
                          
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
<!-- Change Password popup End --> 	