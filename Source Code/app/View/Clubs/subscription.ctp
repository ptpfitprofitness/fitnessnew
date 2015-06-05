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
<script>
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
	 $.post("<?php echo $config['url'];?>clubs/userfbstatus", {userfb_status: sthtml, id: str2}, function(data)
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
	
	 $.post("<?php echo $config['url'];?>clubs/userfbstatusget", {id: str3}, function(data)
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
function editprofile()
{
	
	document.location.href="<?php echo $config['url']?>clubs/<?php if($setUser=='ClubBranch'){ echo 'editprofiles';} else{echo 'editprofile';}?>/";
}

function upgradesubs(str)
{
	if(str!='')
	{
			 var website_url ='<?php echo $config['url']?>clubs/upgradesubs';
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
					url:"<?php echo $config['url'];?>clubs/cancelmyaccount/",
					type:"POST",
					data:{id:str},
					success:function(e) {
						var response = eval(' ( '+e+' ) ');
						if( response.responseclassName == "nSuccess" ) {
							alert(response.errorMsg);
							//document.location.href=document.location.href;
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
<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
</style>

<?php 
//echo '<pre>'; print_r($setSpecalistArr); echo '</pre>'; die();
?>


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
          
          <li><a href="#Subscriptions" class="active"><span class="subscription-ico"></span>Subscriptions</a></li>
		 <!-- <li><a href="#Profile" ><span class="profile-ico"></span>Profile</a></li>-->
          <!--<li><a href="#Certification"><span class="certification-ico"></span>Certification</a></li>
          <li class="nomarg"><a href="#Bio"><span class="bio-ico"></span>Bio</a></li>-->
        </ul>    
        
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
          <div id="Profile" class="euual-height desktop-tab profile-tabs-content clearfix">
          <div class="row">
           <div style="float:right">
          <input type="button" style="width:150px;margin-right:10px;" class="change-pic-nav" onclick="editprofile();" value="Edit Account" name="submit">
		  
		  <?php /*if ($setSpecalistArr['ClubBranch']['id']=='') { ?>
		  <input type="button" style="width:150px;margin-right:10px;" class="change-pic-nav" onclick="popupOpen('pop555');" value="Manage Card Details" name="submit">
		  <?php } */?>
		  
        </div>
            <div class="two columns change-pic">
              <div class="change-pic-img"> <img src="<?php echo $logo;?>" width="75" height="76" /> </div>
              <a href="#" class="change-pic-nav" onclick="popupOpen('pop4');">Change Pic</a> </div>
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
            <!--  <li>
                <div class="row">
                  <div class="four columns about-detailshead">Country:</div>
                  <div class="eight columns about-detailsdet">USA</div>
                </div>
              </li>
              <li class="gray">
                <div class="row">
                  <div class="four columns about-detailshead">Zip code:</div>
                  <div class="eight columns about-detailsdet">254351</div>
                </div>
              </li>-->
              <li>
                <div class="row">
                  <div class="four columns about-detailshead">Phone:</div>
                  <div class="eight columns about-detailsdet"><?php if($setSpecalistArr[$utype]['phone']!=''){echo $setSpecalistArr[$utype]['phone'];} else{echo '--';}?></div>
                </div>
              </li>
             
              <li class="gray">
                <div class="row">
                  <div class="four columns about-detailshead">Picture:</div>
                  <div class="eight columns about-detailsdet"><img src="<?php echo $logo;?>" width="65" height="44"/></div>
                </div>
              </li>
          <!--    <li>
                <div class="row">
                  <div class="four columns about-detailshead">Certifcation Organisation:</div>
                  <div class="eight columns about-detailsdet">Lorem Ipsum emits</div>
                </div>
              </li>
              <li class="gray">
                <div class="row">
                  <div class="four columns about-detailshead">Certifications:</div>
                  <div class="eight columns about-detailsdet">Lorem</div>
                </div>
              </li>
              <li>
                <div class="row">
                  <div class="four columns about-detailshead">Degrees:</div>
                  <div class="eight columns about-detailsdet">Bachelore of Fine Arts</div>
                </div>
              </li>-->
            </ul>
          </div>
        </div>
          <li class="mobile-tab-list"><a href="#Subscriptions"><span class="subscription-ico"></span>Subscriptions</a></li>
          <div id="Subscriptions" class="euual-height desktop-tab profile-tabs-content clearfix">
          <div class="row">
            
            <div class="twelve columns profile-change-pictext">
              
            
            
            
        <?php if ($setSpecalistArr['ClubBranch']['id']=='') { ?>
        <div style="float:right">
          <!--<input type="button" style="width:200px;margin-right:10px;" class="change-pic-nav" onclick="popupOpen('pop555');" value="Manage Card Details" name="submit">-->
		  <input type="button" style="width:150px;margin-right:10px;" class="change-pic-nav" onclick="cancelmyaccount(<?php echo $setSpecalistArr['Club']['id']; ?>);" value="Cancel My Account" name="submit">
        </div>
		<?php } ?>
            
            
            
            <div style="margin-bottom:10px;">
         <?php if($setSpecalistArr[$utype]['subscriptionplan']!=''){?>
         	<p> <h4>Currently <?php echo $setSpecalistArr[$utype]['subscriptionplan'];?> Activated.</h4></p>
        <?php }?>
        
       
        </div>
        <?php  ?>
        <div class="main-responsive-box"><ul class="listing-box all-headtabs">
          <li class="listing-heading">
            <!--<div class="list-colum first-tabs" style="min-width:50px;">S.No.</div>-->
            <div class="list-colum second-tabs" style="min-width: 120px;">Subscription Name</div>
            <div class="list-colum third-tabs">Subscription Type</div>
            <div class="list-colum four-tabs" style="">Subscription Cost</div>
            <!--<div class="list-colum fifth-tabs" style="min-width:105px;">Action</div>-->
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
              <div class="list-colum second-tabs" style="min-width: 120px;"><?php if(!empty($subscription['Subscription']['plan_name'])){echo $subscription['Subscription']['plan_name']; };  ?></div>
              <div class="list-colum third-tabs"><?php if(!empty($subscription['Subscription']['plan_type'])){echo  $subscription['Subscription']['plan_type']; };  ?></div>
              <div class="list-colum four-tabs"><?php if(!empty($subscription['Subscription']['plan_cost'])){echo  "$ ".$subscription['Subscription']['plan_cost']; };  ?></div>
              
              <!--<div class="list-colum fifth-tabs">  <a style="width:90px;" href="javascript:void(0);"  onclick="upgradesubs('<?php //echo $subscription['Subscription']['id'];?>');" class="change-pic-nav">Upgrade</a></div>-->
            </li>
         <?php   $cnt++; /*onclick="upgradesubs('<?php echo $subscription['Subscription']['id'];?>');"*/?>
            <?php  }?>
            
          </div>
        </ul></div>
            
            
            
            
            
            
            
            
            
            
            
            
             <!-- <p>Phasellus ac purus metus. Etiam id urna imperdiet, convallis nisl eu, varius quam. Nunc mattis neque rutrum lacinia pellentesque. Integer pharetra, nibh molestie vulputate bibendum, lacus est auctor nisl, ut dictum mauris dolor vulputate ipsum. </p>-->
            </div>
            
            
          </div>
        </div>
          <li class="mobile-tab-list"><a href="#Certification"><span class="certification-ico"></span>Certification</a></li>
          <div id="Certification" class="euual-height desktop-tab  profile-tabs-content clearfix">
          <div class="row">
            <div class="two columns change-pic">
              <div class="change-pic-img"> <!--<img src="<?php echo $config['url']?>images/sm_picc.png" />--> </div>
              <!--<a href="#" class="change-pic-nav">Change Pic</a> --></div>
            <div class="ten columns profile-change-pictext">
              <h2>Coming Soon</h2>
              <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </p>
             <!-- <p>Phasellus ac purus metus. Etiam id urna imperdiet, convallis nisl eu, varius quam. Nunc mattis neque rutrum lacinia pellentesque. Integer pharetra, nibh molestie vulputate bibendum, lacus est auctor nisl, ut dictum mauris dolor vulputate ipsum. </p>-->
            </div>
            
          </div>
        </div>
          <li class="mobile-tab-list"><a href="#Bio"><span class="bio-ico"></span>Bio</a></li>
          <div id="Bio" class="euual-height desktop-tab profile-tabs-content clearfix">
          <div class="row">
             <div class="two columns change-pic">
              <div class="change-pic-img"> <!--<img src="<?php echo $config['url']?>images/sm_picc.png" />--> </div>
              <!--<a href="#" class="change-pic-nav">Change Pic</a> --></div>
            <div class="ten columns profile-change-pictext">
              <h2>Coming Soon</h2>
              <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </p>
             <!-- <p>Phasellus ac purus metus. Etiam id urna imperdiet, convallis nisl eu, varius quam. Nunc mattis neque rutrum lacinia pellentesque. Integer pharetra, nibh molestie vulputate bibendum, lacus est auctor nisl, ut dictum mauris dolor vulputate ipsum. </p>-->
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
                
                
                
                 <div id="pop555" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> 
				  <?php if($setSpecalistArr['Club']['cardname']!='') {?>
				  <a class="close-nav" onclick="popupClose('pop555');" id="pop5554" href="javascript:void(0);"></a>
				  <?php } ?>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
					 
                        <form action="/clubs/savecard/" controller="home" enctype="multipart/form-data" class="resform-wrap" id="creditCardForm" method="post" accept-charset="utf-8" onsubmit="return validcard();">
                          <h2>Save Card Detail</h2>
							
						<?php if($setSpecalistArr['Club']['cardname']=='') {?>
						<p>You may cancel your membership at any time during the free trial and you will not be charged. Your credit card will be validated at the time you submit this form and will automatically be charged the membership fee at the end of your free trial.
						<br />Thank you.</br />Personal Training Partners</p>
						<?php } ?>
                      
                               
                            <div class="row">
                        
                        <div class="twelve already-member columns">
                         <input type="text" name="data[Club][cardname]" value="<?php if(isset($setSpecalistArr['Club']['cardname'])){echo $setSpecalistArr['Club']['cardname'];} ?>" id="cardname" placeholder="NAME ON CARD" class="validate[required] text-input"/>
                       </div>
                       <div class="twelve already-member columns">
                         <input   type="text" name="data[Club][cardnumber]" value="<?php if(isset($setSpecalistArr['Club']['cardnumber'])){echo $setSpecalistArr['Club']['cardnumber'];} ?>" id="cardnumber" placeholder="CARD NUMBER" class="validate[required,creditCard] text-input"/>
                       </div>  
                        <div class="four form-select columns">
							<select id="exmonth" name="data[Club][exmonth]"  onchange="document.getElementById('customExpmon').value= this.options[this.selectedIndex].text; ">
								<?php for($n=1;$n<=12;$n++){?>
								<option  <?php if(isset($setSpecalistArr['Club']['exmonth'])&&$setSpecalistArr['Club']['exmonth']==$y){ echo "selected=selected";}else{' ';}?> value="<?php echo $n;?>"  ><?php echo $n;?></option>
								<?php }?>
							</select>
							<input type="text" value=" <?php if(isset($setSpecalistArr['Club']['exmonth'])){ echo $setSpecalistArr['Club']['exmonth'];}else{'-- Select Month--';}?>" id="customExpmon">
							
           
          				</div>  
						<div class="four form-select columns">
							<select id="exyear" name="data[Club][exyear]" onchange="document.getElementById('customExyear').value= this.options[this.selectedIndex].text; " >
							<?php for($y=date("Y");$y<=date("Y")+10;$y++)
							{?>
							<option <?php if(isset($setSpecalistArr['Club']['exyear'])&&$setSpecalistArr['Club']['exyear']==$y){ echo "selected=selected";}else{' ';}?>  value="<?php echo $y;?>" ><?php echo $y;?></option>
							<?php }?>
							
							</select>
					<input type="text" value="<?php if(isset($setSpecalistArr['Club']['exyear'])){ echo $setSpecalistArr['Club']['exyear'];}else{'-- Select Year--';}?>" id="customExyear">
						</div> 
						 
          				<div class="four already-member columns">
                         <input type="text" name="data[Club][cvv]" value="<?php if(isset($setSpecalistArr['Club']['cvv'])){echo $setSpecalistArr['Club']['cvv'];} ?>"  maxlength="3" id="cvv" placeholder="CVV CODE" class="validate[required] text-input"/>
                       </div>
						<div class="twelve register-radio columns">
							<div class="radio rad" id="box-single" style="float:left;">
							<input type="radio" id="cardtype1" <?php if(isset($setSpecalistArr['Club']['cardtype']) && ($setSpecalistArr['Club']['cardtype']=='Visa' || $setSpecalistArr['Club']['cardtype']=='')){echo 'checked="checked"';}else{ echo ' ';} ?>  name="data[Club][cardtype]" value="Visa" >
							
							</div>
							<div class="card_img" style="float:left;"><img src="<?php echo BASE_URL;?>img/visa.png" /></div>
							
							<div class="radio rad" id="box-single" style="float:left;">
							<input type="radio" <?php if(isset($setSpecalistArr['Club']['cardtype']) && $setSpecalistArr['Club']['cardtype']=='Mastercard'){echo 'checked="checked"';}else{ echo ' ';} ?> id="cardtype2" name="data[Club][cardtype]" value="Mastercard">							
							</div>
							<div class="card_img" style="float:left;"><img src="<?php echo BASE_URL;?>img/master.png" /></div>
							
							<div class="radio rad" id="box-single" style="float:left;">
							<input type="radio" <?php if(isset($setSpecalistArr['Club']['cardtype']) && $setSpecalistArr['Club']['cardtype']=='AmericanExpress'){echo 'checked="checked"';}else{ echo ' ';} ?>  id="cardtype3" name="data[Club][cardtype]" value="AmericanExpress">
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
                  </div>
                </div>       
<?php
/*if ($setSpecalistArr['Club']['cardnumber'] == '')
{
		echo "<script type='text/javascript'>
		function codeAddress() {
            popupOpen('pop555');
        }
		window.onload = codeAddress;
		</script>";
		
}*/
?>