<?php
/*echo '<pre>';
print_r($SubscriptionInfo);
//print_r($trainers);
echo '</pre>';
die;*/
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
   	document.location.href="<?php echo $config['url'];?>home/editclient/"+str;
   	
   }

}

function newtrainee()
{
	
	document.location.href="<?php echo $config['url'];?>home/addclient/";
}


function deletetrainer(str)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to delete this Client?"))
		{
	         	$.ajax({
				url:"<?php echo $config['url'];?>home/deleteclient/",
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

function removePic(elem) {
		
	r = confirm("Are you sure want to remove the image ?");
	if(r){
		elem.innerHTML = "Please Wait,while deleting";
		$.ajax({
				url:"<?php echo $config['url'];?>home/removePic/",
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

function popupOpenFd(str,str2){
		//var popupText = $(this).attr('title');
//		$('.buttons').children('span').text(popupText);
		$('#'+str).css('display','block');
		$('#'+str).animate({"opacity":"1"}, 300);
		$('#'+str).css('z-index','9999999999');	
		$('#fdtype').val(str2);			
	}

function validatefrmsfd()
{
	//alert('hello');
	 $('.loaderResultFd').show();
	 
	 //var range=$('#rangeA').val();
	 
		var firstname  = $('#first_name').val();
	   var lastname=$('#last_name').val();
	   var email=$('#email').val();
	  var club_id  = $('#club_id').val();
	  var club_branch_id  = $('#club_branch_id').val();
	
	 
		if( firstname!='' && lastname!='' && email!='' ){
		
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		 var website_url ='<?php echo $config['url']?>home/invite_new_trainee';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "firstname="+firstname+"&lastname="+lastname+"&email="+email+"&club_id="+club_id+"&club_branch_id="+club_branch_id,
		   		
				beforeSend: function(){$('.loaderResultFd').show()},
				
		   		success: function(e)
					{
						var response = eval(' ( '+e+' ) ');
						$('.loaderResultFd').hide();
						
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
		return false;
		}
		else
		{
			$('.loaderResultFd').hide();
			alert('Please fill all fields.');
		}
	return false;
}

function upgradesubs(str)
{
	if(str!='')
	{
			 var website_url ='<?php echo $config['url']?>home/upgradesubs';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "subsplanid="+str,						
		   		success: function(e)
					{
						alert(e);
						
						
					}
				});	
		
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
							document.location.href="<?php echo $config['url'];?>";
							
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
     <?php echo $this->element('lefttrainer');?>
      <div class="eight inside-head columns">
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/client_infoico.png"></span>Subscriptions</a></li>
        
        </ul> 
<!--<input type="button" style="width:200px;margin-right:10px;" class="change-pic-nav" onclick="popupOpen('pop555');" value="Manage Card Details" name="submit">-->
<?php if ($setSpecalistArr['Trainer']['trainer_type']=='I') { ?>
		<div style="float:right">
          <input type="button" style="width:200px;margin-right:10px;" class="change-pic-nav" onclick="cancelmyaccount(<?php echo $setSpecalistArr['Trainer']['id'];?>);" value="Cancel My Account" name="submit">
        </div>
		<?php } ?>	
<div style="clear:both"></div>	
        <?php ?>
        <div style="margin-bottom:10px;">
         <?php if($setSpecalistArr[$utype]['subscriptionplan']!=''){?>
         	<p> <h4>Currently <?php echo $setSpecalistArr[$utype]['subscriptionplan'];?> Activated.</h4></p>
        <?php }?>
        
       
        </div>
		
        <?php  ?>
        <div class="main-responsive-box"><ul class="listing-box all-headtabs">
          <li class="listing-heading">
            <!--<div class="list-colum first-tabs" style="min-width:50px;">S.No.</div>-->
            <div class="list-colum second-tabs">Subscription Name</div>
            <div class="list-colum third-tabs">Subscription Type</div>
            <div class="list-colum four-tabs" style="">Subscription Cost</div>
           <!-- <div class="list-colum fifth-tabs" style="min-width:105px;">Action</div>-->
          </li>
        </ul>
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
          <?php 
          $cnt=1;
         //pr($clients);
          foreach ($SubscriptionInfo as $subscription)
          {
          	
          ?>
            <li>
              <!--<div class="list-colum first-tabs" style="min-width:50px;"><?php //echo $cnt; ?></div>-->
              <div class="list-colum second-tabs"><?php if(!empty($subscription['Subscription']['plan_name'])){echo $subscription['Subscription']['plan_name']; };  ?></div>
              <div class="list-colum third-tabs"><?php if(!empty($subscription['Subscription']['plan_type'])){echo  $subscription['Subscription']['plan_type']; };  ?></div>
              <div class="list-colum four-tabs"><?php if(!empty($subscription['Subscription']['plan_cost'])){echo  "$ ".$subscription['Subscription']['plan_cost']; };  ?></div>
              
              <!--<div class="list-colum fifth-tabs">  <a style="width:90px;" href="javascript:void(0);" onclick="upgradesubs('<?php// echo $subscription['Subscription']['id'];?>');" class="change-pic-nav">Upgrade</a></div>-->
            </li>
         <?php   $cnt++; ?>
            <?php  }?>
            
          </div>
        </ul>
        
        
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
         
       
          
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
  <!-- Client Popup  -->
                <div id="popFd" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popFd');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                       
                        
                        
                        <form id="addtrainee" action="" method="POST" onsubmit="return validatefrmsfd();">
      
        <h2>Invite New Client</h2>
         <div class="loaderResultFd" style="display: none;"><img src="<?php echo $config['url'];?>images/ajax-loader.gif"></div> <div style="color:#ff0000; padding:4px 0 4px 0;" id="notificatin_mesFd"></div>
        
        <?php //print_r($setSpecalistArr); ?>
        
        
        <input type="hidden" name="club_id" id="club_id" value="<?php echo $setSpecalistArr[$utype]['club_id'];?>"/>
        <input type="hidden" name="trainer_id" id="trainer_id" value="<?php echo $setSpecalistArr[$utype]['id'];?>"/>
        <input type="hidden" name="club_branch_id" id="club_branch_id" value="<?php echo $setSpecalistArr[$utype]['club_branch_id'];?>"/>
         
            <div class="row">
              <div class="twelve columns">
                 <input type="text" id="first_name" name="first_name" value="" placeholder="First Name" />
           
              </div>
            </div>
            <div class="row">
              <div class="twelve columns">
                 <input type="text" id="last_name" name="last_name" value="" placeholder="Last Name" />
           
              </div>
            </div>
            
           
            
            <div class="row">
              <div class="twelve columns">
                 <input type="text" name="email" id="email" value="" placeholder="Email" />
              </div>
               <div class="twelve already-member columns">
                          <input type="submit" value="Submit" name="" class="submit-nav" >
                       </div>
            </div>   
         
       
     
      
    </form>
                        
                        
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Client Popup  End --> 

			<!--Manage Card Pop Up-->
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
			<!-- Manage Card Pop up-->

				
 <?php echo $this->Html->script('front/js/jquery.slimscroll.min');?>                 

<script type="text/javascript">
$(function(){
$('#testDivNested').slimscroll({ })
});
</script>                
                