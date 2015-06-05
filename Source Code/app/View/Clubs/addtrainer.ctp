<?php
/*echo '<pre>';
//print_r($setSpecalistArr);
print_r($trainers);
echo '</pre>';*/
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



<script>
function editstatus(str)
{
	//alert(str);
	var editsecHtml='<textarea name="userfb_status" id="userfb_statusid"></textarea><input type="button" name="submit" value="Save" onclick="saveedit('+str+');" class="change-pic-nav" style="width:50px;"/><input type="button" name="cancel" class="change-pic-nav" style="width:58px;margin-left:10px;" onclick="canceledit('+str+');" value="Cancel"/>';
	$('#userfb_status').html(editsecHtml);
	
}
function validuppic()
{
	var pic=$('#ClubLogo').val();
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

function edittrainer(str)
{

   if(str!='')
   {
   	document.location.href="<?php echo $config['url'];?>clubs/traineredit/"+str;
   	
   }

}

function newtrainer()
{
	
	document.location.href="<?php echo $config['url'];?>clubs/addtrainer/";
}


function deletetrainer(str)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to delete this trainer?"))
		{
	         	$.ajax({
				url:"<?php echo $config['url'];?>clubs/deletetrainer/",
				type:"POST",
				data:{id:str},
				success:function(e) {
					
					if( e == "Success" ) {
						alert("Trainer has been deleted successfully.");
						
					}
				}
		      });
		}
	}
}

function removePic(elem) {
		
	r = confirm("Are you sure want to remove the image ?");
	if(r){
		elem.innerHTML = "Please Wait,while deleting";
		$.ajax({
				url:"<?php echo $config['url'];?>clubs/removePic/",
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
</script>
<style>
.second-tabs { min-width:178px; }
.third-tabs {min-width:178px; }
.four-tabs {min-width:178px; }
<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
#calendar table{border:none;}
</style>
<section class="contentContainer clearfix">
    <div class="inside-banner changecover-pic">
    <!--<div class="change-coverpic" onclick="popupOpen('pop5');"><img src="<?php echo $config['url'];?>images/pencial_icon.png" /> Change Cover </div>-->
      <div class="row">
        <div class="eight inside-head offset-by-four columns">
          <h2 class="client-name"><?php echo $uname;?></h2>
          <h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['city'].', '.$setSpecalistArr[$utype]['state'];?></h3>
         <p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ echo $setSpecalistArr[$utype]['userfb_status'];}?></p>
        </div>
      </div>
    </div>
    <div class="row">
     <?php echo $this->element('leftclub');?>
      <div class="eight inside-head columns">
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/trainerm.png"></span>Manage Trainer</a></li>
        
        </ul>    
       
        <div>
        <h2>Add Trainer</h2>
        <form accept-charset="utf-8" method="post" id="validclubtrainer" class="resform-wrap" enctype="multipart/form-data" controller="clubs" action="/clubs/addtrainer/">
		
        <input type="hidden" id="TrainerTrainerType" value="C"  name="data[Trainer][trainer_type]"/>
        <input type="hidden" id="TrainerClubId" value="<?php echo $setSpecalistArr['Club']['id'];?>"  name="data[Trainer][club_id]"/>
        
		
          <?php if($setUser!='ClubBranch')
             	{?>
            
             <div class="row">
              <div class="twelve form-select columns">
               
              <?php  echo $this->Form->select('Trainer.club_branch_id',$cbranchs,array('empty'=>'-- Select Club Branch --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectClubid\').value= this.options[this.selectedIndex].text')); ?>      
			
                <input type="text" id="customSelectClubid" value="<?php if($this->data['Trainer']['club_branch_id']!=''){
                foreach($cbranchs as $key=>$val)
                {
                  if($key==$this->data['Trainer']['club_branch_id'])
                  {
                  	 echo $val;
                  }	
                	
                }
                }else{echo '-- Select Club Branch --';}?>"/>
              </div>
            </div>
           <?php } else{?> 
           <input type="hidden" id="TrainerClubBranchId" value="<?php echo $setSpecalistArr[$utype]['id'];?>"  name="data[Trainer][club_branch_id]"/>
           <?php }?>
           <?php /*<div class="row">
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
			*/ ?>	
            
            <?php //echo $this->Form->text('Trainer.username', array('maxlength'=>255,'id'=>'Username', 'class'=>'validate[required]','placeholder'=>'Username')); ?>

				<?php //echo $this->Form->error('Trainer.username', null, array('class' => 'error')); ?>
           <?php echo $this->Form->text('Trainer.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email]]','placeholder'=>'Email Address')); ?>

				<?php echo $this->Form->error('Trainer.email', null, array('class' => 'error')); ?>
				 <?php /*echo $this->Form->password('Trainer.password', array('maxlength'=>255, 'class'=>'validate[required]','placeholder'=>'Password')); ?>

				<?php echo $this->Form->error('Trainer.password', null, array('class' => 'error'));*/?>
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
              	<?php echo $this->Form->text('Trainer.phone', array('maxlength'=>255,'id'=>'Phone','placeholder'=>'Phone')); ?>

				<?php echo $this->Form->error('Trainer.phone', null, array('class' => 'error')); ?>
              </div>
              <div class="six columns">
                <?php echo $this->Form->text('Trainer.mobile', array('maxlength'=>255,'id'=>'Mobile','placeholder'=>'Mobile')); ?>

				<?php echo $this->Form->error('Trainer.mobile', null, array('class' => 'error')); ?>
              </div>
            </div>
           	<?php /*echo $this->Form->textarea('Trainer.certifications', array('maxlength'=>500, 'id'=>'certifications','placeholder'=>'Certifications')); ?>
				
				<?php echo $this->Form->error('Trainer.certifications', null, array('class' => 'error')); ?>
           <?php echo $this->Form->textarea('Trainer.Bio', array('maxlength'=>500, 'id'=>'Bio','placeholder'=>'Bio')); ?>
				
				<?php echo $this->Form->error('Trainer.Bio', null, array('class' => 'error')); ?>
				
		   <?php echo $this->Form->textarea('Trainer.about_us', array('maxlength'=>500, 'id'=>'AboutUs','placeholder'=>'About Us')); ?>
				
				<?php echo $this->Form->error('Trainer.about_us', null, array('class' => 'error')); */?>		
           
            <div class="row">
              <div class="six columns"><span class="file-wrapper">
              	<?php echo $this->Form->file('Trainer.logo');?>
								<?php echo $this->Form->error('Trainer.logo', null, array('class' => 'error'));?>
							</div>
							<div class="fix"></div>
							<?php echo $this->Form->hidden('Trainer.id'); ?>
							
							 <?php echo $this->Form->hidden('Trainer.old_image',array('value'=>$this->request->data["Trainer"]["logo"]));?>
							
						</div>
							<div id="imgCont" class="rowElem noborder">
						<div class="formRight">
						
							<div style="float:left;<?php if( array_key_exists("logo",$this->request->data["Trainer"]) && !empty($this->request->data["Trainer"]["logo"]) ) { ?>border:1px solid #d8d8d8;<?php } ?>padding:8px;" id="video_container">
							<?php if( array_key_exists("logo",$this->request->data["Trainer"]) && !empty($this->request->data["Trainer"]["logo"]) ) { ?>
								<img border="1"  width="100px" src="<?php echo $config["imgurl"];?>uploads/<?php echo $this->data["Trainer"]["logo"];?>"/>
								<span style="margin-left:11px;margin-top:-22px;position:absolute;">
									<a id="<?php echo $this->data["Trainer"]["id"];?>" onclick="removePic(this);"  style="cursor:pointer" title="click to delete">
										<img border="1" src="<?php echo $config["imgurl"];?>img/cross.png"/>
									</a>
								</span>
							<?php 	} ?>	
							</div>
						</div>
						
					<div class="clear"></div>
						<?php echo $this->Form->file('Trainer.logo');?>
								<?php echo $this->Form->error('Trainer.logo', null, array('class' => 'error'));?>
							
							<?php echo $this->Form->hidden('Trainer.id'); ?>
							
							 <?php echo $this->Form->hidden('Trainer.old_image',array('value'=>$this->request->data["Trainer"]["logo"]));?>
                
               </div>
             
            </div>
            <!--<input type="text" name="" value="" placeholder="Certifications" />
            <input type="text" name="" value="" placeholder="Degrees" />-->
         
            <input type="submit" class="submit-nav" name="submit" value="Save"  />
          </form>
        </div>
        
           
      </div>
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
   <!-- Change Cover popup -->
                <div id="pop5" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('pop5');" id="pop5" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="/<?php if($setUser=='ClubBranch'){ echo 'clubs/coverpicbr/';} else{echo 'home/coverpic/';}?>" controller="home" enctype="multipart/form-data" class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validcuppic();">
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
                
   <!-- Change Pic popup -->
                <div id="pop4" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('pop4');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="/clubs/<?php if($setUser=='ClubBranch'){ echo 'uploadpicbr/';} else{echo 'uploadpic/';}?>" controller="home" enctype="multipart/form-data" class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validuppic();">
                          <h2>Upload Profile Pic</h2>
                           <input type="file" name="data[Club][logo]" id="ClubLogo" />
                           <?php echo $this->Form->hidden('Club.id',array('value'=>$this->Session->read('USER_ID')));?>
                           <?php echo $this->Form->hidden('Club.old_image',array('value'=>$setSpecalistArr[$utype]['logo']));?>
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
                <!-- Change Pic popup End -->            
 <?php echo $this->Html->script('front/js/jquery.slimscroll.min');?>                 

<script type="text/javascript">
$(function(){
$('#testDivNested').slimscroll({ })
});
</script>                
                