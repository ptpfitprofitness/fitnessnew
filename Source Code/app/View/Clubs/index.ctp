<?php
/*echo '<pre>';
print_r($checkPayment);
echo '</pre>';*/
//$setSpecalistArr['ClubBranch']['id'];

  

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

function purchasehistory()
{	
	document.location.href="<?php echo $config['url']?>clubs/purchasehistory/";
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




function couponpost(coupon,amount)
{
	var coupon = document.getElementById("coupon_code").value;
	var amount = document.getElementById("clubtotal").value;
	var website_url ='<?php echo $config['url']?>clubs/couponcode';
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
				$('#clubtotal').val(msg);
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
	$('#clubtotal').val(plan_value);
	$('#trainernumber').val(1);
	$('#coupon_code').val('');
	$('#coupon-button-cancel').hide();
	$('#coupon-button').show();
	$('#coupon_code').attr('readonly', false);		
	
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
          <li><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
         <!-- <li><a href="#Subscriptions"><span class="subscription-ico"></span>Subscriptions</a></li>-->
          <!--<li><a href="#Certification"><span class="certification-ico"></span>Certification</a></li>
          <li class="nomarg"><a href="#Bio"><span class="bio-ico"></span>Bio</a></li>-->
        </ul>    
        
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
          <div id="Profile" class="euual-height desktop-tab profile-tabs-content clearfix">
          <div class="row">
           <div style="float:right">
          <input type="button" style="width:150px;margin-right:10px;" class="change-pic-nav" onclick="editprofile();" value="Edit Account" name="submit">
		  
		  <?php if ($setSpecalistArr['ClubBranch']['id']=='') { ?>
		  <!--<input type="button" style="width:150px;margin-right:10px;" class="change-pic-nav" onclick="popupOpen('pop555');" value="Manage Card Details" name="submit">-->
		  <input type="button" style="width:150px;margin-right:10px;" class="change-pic-nav" onclick="popupOpen('popbillinginfochoice');" value="Billing Information" name="submit">
		  <?php } ?>
		  
		   <input type="button" style="width:150px;margin-right:10px;" class="change-pic-nav" onclick="purchasehistory();" value="Purchase History" name="submit">
		  
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
         <!-- <input type="button" style="width:200px;margin-right:10px;" class="change-pic-nav" onclick="popupOpen('pop555');" value="Manage Card Details" name="submit">-->
		 <!-- <input type="button" style="width:150px;margin-right:10px;" class="change-pic-nav" onclick="cancelmyaccount(<?php //echo $setSpecalistArr['Club']['id']; ?>);" value="Cancel My Account" name="submit">-->
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
            <div class="list-colum fifth-tabs" style="min-width:105px;">Action</div>
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
              
              <div class="list-colum fifth-tabs">  <a style="width:90px;" href="javascript:void(0);"  onclick="upgradesubs('<?php echo $subscription['Subscription']['id'];?>');" class="change-pic-nav">Upgrade</a></div>
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

<!--POP UP BILLING INFORMATION-->
<style type="text/css">
.register-form-popup.billing{left: 40% !important; width: 800px !important;}
.field-pad-billing{padding: 10px 15px;}
</style>
<script type="text/javascript">

<?php if (empty($checkPayment)) { ?>

 function getRate(plan,cost,id)
 {		
		var plan_cost = $('#clubcost').val(cost);		
		$('#subsplanid').val(id);
		$('#plan_value').val(cost);
		var numtrainer = $('#trainernumber').val();		
		//var total_cost = cost*parseInt(numtrainer);		
		var total_cost = ((cost/2)*parseInt(numtrainer-1))+cost;
		$('#clubtotal').val(total_cost);
		$('#coupon-block').show();
		$('#tnumber').show();
		$('#tcost').show();
		$('#totalvalue').show();
		$('#sign').show();
		$('#trainerhave').show();
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
 $(document).ready(function(){
    $("#trainernumber").blur(function(){
		var club_cost = $("#plan_value").val();
		var ac = parseFloat(club_cost);
		var itrainer_cost = $("#trainernumber").val();
		var total_cost = ((club_cost/2)*parseInt(itrainer_cost-1)) + ac;
		var final_cost = total_cost.toFixed(2);
		$("#clubtotal").val(final_cost);
        //alert(total_cost);		
	});
});
<?php } else { $nextpaymdate = $checkPayment['Payment']['nextbillingdate']; ?>

var nxtpaydate = '<?php echo $nextpaymdate ;?>';
var today = new Date();

/*var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
var firstDate = new Date(nxtpaydate);
var secondDate = new Date(today);
var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));*/

var start = new Date(today);
var end = new Date(nxtpaydate);
var diff = new Date(end - start);
var days = Math.round(diff/1000/60/60/24);
alert(days);

function getRate(plan,cost,id)
 {		
		var plan_cost = $('#clubcost').val(cost);		
		$('#subsplanid').val(id);
		$('#plan_value').val(cost);
		var numtrainer = $('#trainernumber').val();		
		//var total_cost = cost*parseInt(numtrainer);
		
		if(days > 0)
		{
			var total_cost = ((((cost/2)/30)*parseInt(numtrainer))*days);
		}
		else
		{
			var total_cost = ((cost/2)*parseInt(numtrainer));
		}
		
		
		$('#clubtotal').val(total_cost);
		$('#coupon-block').show();
		$('#tnumber').show();
		$('#tcost').show();
		$('#totalvalue').show();
		$('#sign').show();
		$('#trainerhave').show();
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
 $(document).ready(function(){
    $("#trainernumber").blur(function(){
		var club_cost = $("#plan_value").val();
		var ac = parseFloat(club_cost);
		var itrainer_cost = $("#trainernumber").val();		
		if(days > 0)
		{
			var total_cost = ((((club_cost/2)/30)*parseInt(itrainer_cost))*days);
		}
		else
		{
			var total_cost = ((club_cost/2)*parseInt(itrainer_cost));
		}
		var final_cost = total_cost.toFixed(2);
		$("#clubtotal").val(final_cost);
        //alert(total_cost);		
	});
});
<?php } ?>

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
					<p>We want Personal Training Partners to hep your business grow. If that's not happening, let us know or you can <a href="#" onclick="cancelmyaccount(<?php echo $setSpecalistArr['Club']['id'];?>);">close your account.</a></p>		
				</div>
				<div class="nine field-pad-billing columns">
					<form action="/clubs/newpayment/" controller="clubs" enctype="multipart/form-data" class="resform-wrap" id="billingform" method="post" accept-charset="utf-8">		
					<h2>Your Billing Information</h2>
					<hr />					
					<div class="row">
						<div class="twelve columns">
							<div class="six columns">
								<p style="color: hsl(0, 0%, 50%);font-size: 16px; font-weight: bold;">Club </p>
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
											<input type="radio" class="validate[required]" id="mode" name="data[Club][paymentmode]" value="Monthly" onclick="getRate('<?php echo $ch_plan['Subscription']['plan_type']?>','<?php echo $ch_plan['Subscription']['plan_cost']?>','<?php echo $ch_plan['Subscription']['id']?>');">
											</div>
											<div class="card_img" style="float:left;margin:0 0 0 5px;"><?php echo$ch_plan['Subscription']['plan_name']. ' ' .$ch_plan['Subscription']['plan_type']?></div>
											
										</div>										
								 <?php }
									if($ch_plan['Subscription']['plan_type']=='Yearly')
									{?>
										<div class="six check-condition columns">
											<div class="radio rad" id="box-single" style="float:left;">
											<input type="radio" id="mode" class="validate[required]" name="data[Club][paymentmode]" value="Yearly"onclick="getRate('<?php echo $ch_plan['Subscription']['plan_type']?>','<?php echo $ch_plan['Subscription']['plan_cost']?>','<?php echo $ch_plan['Subscription']['id']?>');" >
											</div>	
											<div class="card_img" style="float:left; margin:0 0 0 5px;"><?php echo$ch_plan['Subscription']['plan_name']. ' ' .$ch_plan['Subscription']['plan_type']?></div>
											
												
										</div>										
								 <?php }								
								}
								?>								
								<input type="hidden" value="" id="subsplanid" name="subsplanid" />			
								<input type="hidden" value="" id="plan_value" name="plan_value" />								
								<div class="twelve already-member columns" style="margin:15px 0 0 0;">
								<div style="clear:both"></div>
								<cite id="trainerhave" style="display:none;clear:both; color:#ff0000;">(How many trainers do you have?)<br /><br />50% of the original cost will be charged after single trainer.</cite>								
								<div style="clear:both"></div>
									<div class="three columns" id="tnumber" style="display:none;">
									<p style="margin-bottom: 0px;">Trainer</p>
										<input type="text" name="data[Trainer][number]" value="1" id="trainernumber" />
									</div>
									<div class="one columns" id="signmul" style="display:none;">
										<p style="text-align:center; font-size:15px;">x</p>
									</div>
									<div class="two columns" id="tcost" style="display:none;">
										<p style="margin-bottom: 0px;">Cost</p>
										<input type="text" name="data[Club][cost]" value="" id="clubcost" style="width:44px;" readonly />
									</div>
									<div class="one columns" id="sign" style="display:none;">
										<p style="text-align:center; font-size:15px;">=</p>
									</div>
									<div class="five columns" id="totalvalue" style="display:none;">
										<p style="margin-bottom: 0px;">Total Cost</p>
										<p style="float: left;padding: 5px;">$</p><input type="text" name="data[Club][total]" value="" id="clubtotal" readonly style="float: left; width: 65px;" />
									</div>									
								</div>
								<div id="duration" style="color: hsl(0, 100%, 50%);    font-weight: bold; clear:both;"></div>
								
								<br />
								<div id="coupon-block" style="display:none">
								<p style="color: hsl(0, 0%, 50%);font-size: 16px; font-weight: bold;">Apply Coupon Code</p>
								<div class="row" id="discountedprice" style="padding: 0 0 10px 10px;color: hsl(0, 100%, 50%);font-size: 15px; font-weight: bold;"></div>  
								<div class="twelve already-member columns">
									<input type="text" name="data[Club][coupon_code]" value="" id="coupon_code" placeholder="Coupon Code" class=" text-input"/>
								</div>
								<input type="button" id="coupon-button" onclick="couponpost(document.getElementById('coupon_code').value,document.getElementById('clubtotal').value);" value="Go" name="" class="submit-nav" />
								<input style="display:none;" type="button" id="coupon-button-cancel" onclick="getcancelreset(document.getElementById('coupon_code').value,document.getElementById('clubtotal').value,document.getElementById('plan_value').value);" value="Cancel" name="" class="submit-nav" />
								</div>
								<div style="clear:both"></div>
								
								<p style="color: hsl(0, 0%, 50%);font-size: 16px; font-weight: bold;">Credit Card Info</p>
								<div class="twelve already-member columns">
									<input type="text" name="data[Club][firstcardname]" value="" id="firstcardname" placeholder="FIRST NAME ON CARD" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Club][lastcardname]" value="" id="lastcardname" placeholder="LAST NAME ON CARD" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input   type="text" name="data[Club][cardnumber]" value="" id="cardnumber" placeholder="CARD NUMBER" class="validate[required,creditCard] text-input"/>
								</div> 
								<div class="four form-select columns">
									<select id="exmonth" name="data[Club][exmonth]"  onchange="document.getElementById('customExpmon2').value= this.options[this.selectedIndex].text; ">
									<?php for($n=01;$n<=12;$n++){?>
									<option  <?php if(isset($setSpecalistArr['Club']['exmonth'])&&$setSpecalistArr['Club']['exmonth']==$y){ echo "selected=selected";}else{' ';}?> value="<?php if ($n<10){ echo "0".$n;}else{echo $n;}?>"  ><?php if ($n<10){ echo "0".$n;} else {echo $n;}?></option>
									<?php }?>
									</select>
									<input type="text" value="" id="customExpmon2">	
								</div> 
								<div class="four form-select columns">
									<select id="exyear" name="data[Club][exyear]" onchange="document.getElementById('customExyear2').value= this.options[this.selectedIndex].text; " >
									<?php for($y=date("Y");$y<=date("Y")+10;$y++)
									{?>
									<option value="<?php echo $y;?>" ><?php echo $y;?></option>
									<?php }?>
									</select>
									<input type="text" value="" id="customExyear2">
								</div>
								<div class="four already-member columns">
									<input type="text" name="data[Club][cvv]" value=""  maxlength="3" id="cvv" placeholder="CVV CODE" class="validate[required] text-input"/>
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
									
									<div class="twelve check-condition columns">
										<?php echo $this->Form->input('checkbox',  array('label'=>false,'name'=>'tnc','id'=>'tnc','class'=>'validate[required]','type'=>'checkbox','div' => false)); ?>
										<span>Yes I agree to Personal Training Partners <a href="<?php echo $config['url']?>terms-of-use" target="_blank">Terms of Use</a> and <a href="<?php echo $config['url']?>privacy-policy" target="_blank">Privacy Policy</a>.</span> 
									</div>
								</div>
							</div>
							<div class="six columns">
								<p style="color: hsl(0, 0%, 50%);font-size: 16px; font-weight: bold;">Billing Address</p>
								<div class="twelve already-member columns">
									<input type="text" name="data[Club][email]" value="" id="email" placeholder="Email" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Club][phone]" value="" id="phone" placeholder="Phone Number" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Club][address1]" value="" id="address1" placeholder="Address 1" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Club][address2]" value="" id="address2" placeholder="Address 2"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Club][city]" value="" id="city" placeholder="City" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Club][state]" value="" id="state" placeholder="State" class="validate[required] text-input"/>
								</div>
								<div class="twelve already-member columns">
									<input type="text" name="data[Club][zip]" value="" id="zip" placeholder="Zip" class="validate[required] text-input"/>
								</div>
								<div class="twelve form-select columns">
									  <?php $default3=array('226'); ?>
										<select name="data[Club][country]" id="dd" onChange="document.getElementById('customSelect').value= this.options[this.selectedIndex].text">		   
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




<!--Billing Pop Up Choice -->
<div id="popbillinginfochoice" class="main-popup">
	
	<div class="overlaybox common-overlay"></div>
	
	<div id="thirtydays" class="register-form-popup billing common-overlaycontent"> 
		
		<a class="close-nav" onclick="popupClose('popbillinginfochoice');" id="" href="javascript:void(0);"></a>
		
		<div class="row register-popup-form">
			<div class="twelve columns">
				<a style="background: none repeat scroll 0 0 hsl(0, 0%, 0%); color: hsl(0, 0%, 100%);display: block;font-weight: bold;margin: 15px;   padding: 15px; text-align: center; width: 45%; float:left;"onclick="popupOpen('popbillinginfo'); popupClose('popbillinginfochoice');" href="javascript:void(1);">
					Add New Trainer
				</a>
				<a style="background: none repeat scroll 0 0 hsl(0, 0%, 0%); color: hsl(0, 0%, 100%);display: block;font-weight: bold;margin: 15px;   padding: 15px; text-align: center;  width: 45%; float:right;" onclick="popupOpen('popbillinginfo1'); popupClose('popbillinginfochoice');" href="javascript:void(2);">
					Renew Existing Trainer
				</a>
			</div>
		</div>
	</div>
</div>
<!--Billing Pop Up Choice -->






				
<?php
$billingpopup = $_GET['bipop'];
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