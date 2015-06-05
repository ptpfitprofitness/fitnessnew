<?php
/*echo '<pre>';
//print_r($setSpecalistArr);
print_r($this->data);
echo '</pre>';*/
echo "<pre>"; print_r($setcertiname2); echo "</pre>";
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
<script>
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
function changecertorg(str)
{	
	var certi = $("#customSelectOrgid").val();
	var website_url ='<?php echo $config['url']?>home/changecertorg';
	$.ajax({
		type: "POST",
		url: website_url,
		data: {str:certi},
		beforeSend: function(){$('.loaderResult101').show()},
		success: function(msg)
		{			
			$("#CertificationTrainersCertificationName").html(msg);
					
		}		
	});	
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



//function dothis(val)
//{
//if(val=='')
//{
// $("#otherhide").show();	
//}
//else
//$("#otherhide").hide();
//
//}
//
//function dothis2(val)
//{
//if(val=='')
//{
// $("#otherhide2").show();	
//}
//else
//$("#otherhide2").hide();
//
//}
//
//function dothis3(val)
//{
//if(val=='')
//{
// $("#otherhide3").show();	
//}
//else
//$("#otherhide3").hide();
//
//}


$(document).ready(function(){
	$('#CertificationTrainersCertificationOrg').on('change', function() {
  //alert( 'Hello' ); // or $(this).val()
  if(this.value==' ')
  {
   $("#otherhide").show();	
  }
  else
  {
  $("#otherhide").hide();

}
  
});
});

$(document).ready(function(){
	$('#CertificationTrainersCertificationName').on('change', function() {
  //alert( 'Hello' ); // or $(this).val()
  if(this.value==' ')
  {
   $("#otherhide2").show();	
  }
  else
  {
  $("#otherhide2").hide();

}
  
});
});

$(document).ready(function(){
	$('#CertificationTrainersCertificationDegree').on('change', function() {
  //alert( 'Hello' ); // or $(this).val()
  if(this.value==' ')
  {
   $("#otherhide3").show();	
  }
  else
  {
  $("#otherhide3").hide();

}
  
});
});

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
    <!--<div class="change-coverpic" onclick="popupOpen('pop5');"><img src="<?php echo $config['url'];?>images/pencial_icon.png" /> Change Cover </div>-->
      <div class="row">
        <div class="eight inside-head offset-by-four columns">
          <h2 class="client-name"><?php echo $uname;?></h2>
          <h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['state'];?></h3>
         <p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ echo $setSpecalistArr[$utype]['userfb_status'];}?></p>
        </div>
      </div>
    </div>
    <div class="row">
       <?php echo $this->element('lefttrainer');?>
      <div class="eight inside-head columns">
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <li><a href="#Profile" class="active"><span class="profile-ico"></span>Add Certification</a></li>
       
        </ul>    
       
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Add Certification</a></li>
           <div class="clear">&nbsp;</div>
           

 <form accept-charset="utf-8" method="post" id="validcertificationtrainers" class="resform-wrap" enctype="multipart/form-data" controller="home" action="/home/addcertification_trainer/">
		<?php //echo $this->Form->hidden('Trainer.id'); ?>
		
		<input type="hidden"  name="data[CertificationTrainers][trainer_id]" id="CertificationTrainers_trainer_id" value="<?php echo $setSpecalistArr[$utype]['id'];?>"/>
		
	<div class="row">
		<div class="twelve form-select columns">
			<?php
				$option=array();
				
				$options = array(' ' => 'Other');
				
				$cert_org1 = array_merge($cert_org,$options);
				
				echo $this->Form->select('CertificationTrainers.certification_org',$cert_org1,array('empty'=>'Select','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectOrgid\').value= this.options[this.selectedIndex].text; changecertorg(document.getElementById(\'customSelectOrgid\').value= this.options[this.selectedIndex].text);')); 
			?>
			<input type="text" id="customSelectOrgid" value="<?php if($this->data['Trainer']['certification_org_id']!=''){
					foreach($cert_org as $key=>$val)
					{
						if($key==$this->data['Trainer']['certification_org_id'])
						{
							echo $val;
						}	
					}
				}
				else{echo '-- Select Certification Organization--';}?>"/>
		</div>
	</div>
	
	<div class="row">
		<div class="six columns"  id='otherhide' style="display:none;">
			<?php 
				echo $this->Form->text('CertificationTrainers.certification_org1', array('maxlength'=>255,'id'=>'Certification Organisation','class'=>'validate[required]','placeholder'=>'Other Certification Organization')); 
			?>
			<?php 
				echo $this->Form->error('CertificationTrainers.certification_org1', null, array('class' => 'error')); 
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="twelve form-select columns">
		<?php
			$option2=array();
			
			$options2 = array(' ' => 'Other');
			
			$certifications1 = array_merge($certifications,$options2);
			
			//echo "<pre>";print_r($certifications);echo "<pre>";
			
			echo $this->Form->select('CertificationTrainers.certification_name',$certifications1,array('empty'=>'Select','class'=>'topAction','onchange'=>'document.getElementById(\'customSelectCrtid\').value= this.options[this.selectedIndex].text')); 
		?>
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

	<div class="row">
		<div class="six columns"  id='otherhide2' style="display:none;">
			<?php 
				echo $this->Form->text('CertificationTrainers.certification_name1', array('maxlength'=>255,'id'=>'Certification','class'=>'validate[required]','placeholder'=>'Other Certification')); 
			?>
			<?php 
				echo $this->Form->error('CertificationTrainers.certification_name1', null, array('class' => 'error')); 
			?>
		</div>
	</div>
	
	<div class="row">
		<?php 
			echo $this->Form->text('CertificationTrainers.certification_code', array('maxlength'=>255,'id'=>'certification_code', 'class'=>'validate[required]','placeholder'=>'certification number')); 
		?>
		<?php 
			echo $this->Form->error('CertificationTrainers.certification_code', null, array('class' => 'error')); 
		?>
	</div>
	
	<div class="row">				
		<?php /* $this->Form->text('CertificationTrainers.certification_degree1', array('maxlength'=>255,'id'=>'Degree','class'=>'validate[required]','placeholder'=>'Degree')); */?>

		<?php /*echo $this->Form->error('CertificationTrainers.certification_degree1', null, array('class' => 'error')); */?>
                
               
            
             <!-- <div class="twelve form-select columns">
               <?php  
               
             /*  $option3=array();
			
			$options3 = array(
            ' ' => 'Other',
            
            );
            $degrees1 = array_merge($degrees,$options3);
               
               echo $this->Form->select('CertificationTrainers.certification_degree',$degrees1,array('empty'=>'Select','class'=>'topAction','onchange'=>'document.getElementById(\'customSelectDegid\').value= this.options[this.selectedIndex].text')); */?>         
              				
                <input type="text" id="customSelectDegid" value="<?php //if($this->data['Trainer']['degree_id']!=''){
               /* foreach($degrees as $key=>$val)
                {
                  if($key==$this->data['Trainer']['degree_id'])
                  {
                  	 echo $val;
                  }	
                	
                }
                }else{echo '-- Select Degree --';}*/?>"/>
              </div>-->
            </div>
            
             <div class="row">
            <div class="six columns"  id='otherhide3' style="display:none;">
             
				
<?php echo $this->Form->text('CertificationTrainers.certification_degree1', array('maxlength'=>255,'id'=>'Degree','class'=>'validate[required]','placeholder'=>'Other Degree')); ?>

				<?php echo $this->Form->error('CertificationTrainers.certification_degree1', null, array('class' => 'error')); ?>
                
               
              </div>
              </div>	
				

				
            <div class="row">
            <?php /* ?>
              <div class="six columns">
             
				
<?php echo $this->Form->text('CertificationTrainers.certification_link', array('maxlength'=>255,'id'=>'certification_link','class'=>'validate[required]','placeholder'=>'Certification link')); ?>

				<?php echo $this->Form->error('CertificationTrainers.certification_link', null, array('class' => 'error')); ?>
                
               
              </div>
              <?php */ ?>
              <div class="row">
              <?php /* ?>
              <div class="twelve form-select columns">
               <select id="TrainerDegreeId" onchange="document.getElementById('customSelectStatus').value= this.options[this.selectedIndex].text" class="topAction" name="data[CertificationTrainers][status]">
<option value="">-- Select --</option>
<option value="0">No</option>
<option value="1">Yes</option>
</select>         
              				
                <input type="text" value="-- Select Status --" id="customSelectStatus">
              </div>
              <?php */ ?>
            </div>
            
            
            
            </div>
            
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