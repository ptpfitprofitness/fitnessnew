<?php
/*echo '<pre>';
print_r($setSpecalistArr);
echo '</pre>';*/
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
  	if($setSpecalistArr[$utype]['logo']!='')
  	{
  		$logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['logo'];
  	}
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
</script>
<style>
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
          <h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['state'];?></h3>
          <p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ if($this->Session->read('USER_ID') && ($this->Session->read('USER_ID')==$setSpecalistArr[$utype]['id'])){ echo '<a href="javascript:void(0);" onclick="editstatus('.$setSpecalistArr[$utype]['id'].');" style="color:#fff;">'.stripslashes($setSpecalistArr[$utype]['userfb_status']).'</a>';} else {echo stripslashes($setSpecalistArr[$utype]['userfb_status']);}} elseif($this->Session->read('USER_ID') && ($this->Session->read('USER_ID')==$setSpecalistArr[$utype]['id'])){ echo '<a href="javascript:void(0);" onclick="editstatus('.$setSpecalistArr[$utype]['id'].');" style="color:#fff;">Set your current status, click here!!!</a>';}?></p>
        </div>
      </div>
    </div>
    <div class="row">
      <?php echo $this->element('leftcorporation');?>
      <div class="eight inside-head columns">
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <li><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
          <li><a href="#Subscriptions"><span class="subscription-ico"></span>Subscriptions</a></li>
      
        </ul>    
        
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
          <div id="Profile" class="euual-height desktop-tab profile-tabs-content clearfix">
          <div class="row">
            <div class="two columns change-pic">
              <div class="change-pic-img"> <img src="<?php echo $logo;?>" width="75" height="76" /> </div>
              <a href="#" class="change-pic-nav" onclick="popupOpen('pop4');">Change Pic</a> </div>
            <div class="ten columns profile-change-pictext">
              <!--<h2>About Me</h2>-->
              <p><?php echo $setSpecalistArr[$utype]['about_us'];?></p>
            </div>
            <ul class="twelve columns about-details-list">
              <li class="pro-heading">About Me</li>
              <li>
                <div class="row">
                  <div class="four columns about-detailshead">Username:</div>
                  <div class="eight columns about-detailsdet"><?php echo $setSpecalistArr[$utype]['username'];?></div>
                </div>
              </li>
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
                  <div class="four columns about-detailshead">Company Name:</div>
                  <div class="eight columns about-detailsdet"><?php echo $setSpecalistArr[$utype]['company_name'];?></div>
                </div>
              </li>
             
              <li >
                <div class="row">
                  <div class="four columns about-detailshead">Address:</div>
                  <div class="eight columns about-detailsdet"><?php if($setSpecalistArr[$utype]['address']!=''){echo $setSpecalistArr[$utype]['address'];} else{echo '--';}?></div>
                </div>
              </li>
              <li class="gray">
                <div class="row">
                  <div class="four columns about-detailshead">City:</div>
                  <div class="eight columns about-detailsdet"><?php if($setSpecalistArr[$utype]['city']!=''){echo $setSpecalistArr[$utype]['city'];} else{echo '--';}?></div>
                </div>
              </li>
              <li >
                <div class="row">
                  <div class="four columns about-detailshead">State:</div>
                  <div class="eight columns about-detailsdet"><?php if($setSpecalistArr[$utype]['state']!=''){echo $setSpecalistArr[$utype]['state'];} else{echo '--';}?></div>
                </div>
              </li>
            <li class="gray">
                <div class="row">
                  <div class="four columns about-detailshead">Country:</div>
                  <div class="eight columns about-detailsdet"><?php if($setSpecalistArr[$utype]['country']!=''){echo $con_name;} else{echo '--';}?></div>
                </div>
              </li>
              <li >
                <div class="row">
                  <div class="four columns about-detailshead">Zip:</div>
                  <div class="eight columns about-detailsdet"><?php if($setSpecalistArr[$utype]['zip']!=''){echo $setSpecalistArr[$utype]['zip'];} else{echo '--';}?></div>
                </div>
              </li>
              <li class="gray">
                <div class="row">
                  <div class="four columns about-detailshead">About Us:</div>
                  <div class="eight columns about-detailsdet"><?php if($setSpecalistArr[$utype]['about_us']!=''){echo $setSpecalistArr[$utype]['about_us'];} else{echo '--';}?></div>
                </div>
              </li>
              <li >
                <div class="row">
                  <div class="four columns about-detailshead">Phone:</div>
                  <div class="eight columns about-detailsdet"><?php if($setSpecalistArr[$utype]['phone']!=''){echo $setSpecalistArr[$utype]['phone'];} else{echo '--';}?></div>
                </div>
              </li>
             
              <li class="gray">
                <div class="row">
                  <div class="four columns about-detailshead">Logo:</div>
                  <div class="eight columns about-detailsdet"><img src="<?php echo $logo;?>" width="65" height="44"/></div>
                </div>
              </li>
         
            </ul>
          </div>
        </div>
          <li class="mobile-tab-list"><a href="#Subscriptions"><span class="subscription-ico"></span>Subscriptions</a></li>
          <div id="Subscriptions" class="euual-height desktop-tab profile-tabs-content clearfix">
          <div class="row">
            <div class="two columns change-pic">
              <div class="change-pic-img"> <img src="<?php echo $config['url']?>images/sm_picc.png" /> </div>
              <a href="#" class="change-pic-nav">Change Pic</a> </div>
            <div class="ten columns profile-change-pictext">
              <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit.1</h2>
              <p>Phasellus ac purus metus. Etiam id urna imperdiet, convallis nisl eu, varius quam. Nunc mattis neque rutrum lacinia pellentesque. Integer pharetra, nibh molestie vulputate bibendum, lacus est auctor nisl, ut dictum mauris dolor vulputate ipsum. </p>
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
                        <form action="/fitnessAaland/home/coverpic/" controller="home" enctype="multipart/form-data" class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validcuppic();">
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
                        <form action="/fitnessAaland/corporations/uploadpic/" controller="home" enctype="multipart/form-data" class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validuppic();">
                          <h2>Upload Profile Pic</h2>
                           <input type="file" name="data[Corporation][logo]" id="CorporationLogo" />
                           <?php echo $this->Form->hidden('Corporation.id',array('value'=>$this->Session->read('USER_ID')));?>
                           <?php echo $this->Form->hidden('Corporation.old_image',array('value'=>$setSpecalistArr[$utype]['logo']));?>
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