<?php
//echo '<pre>';
//print_r($setSpecalistArr);
//print_r($session_purc_data);
//echo '</pre>';
//die();
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
/*echo"<pre>";
print_r($trainees);
echo"</pre>";*/
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

function newsession()
{
	
	document.location.href="<?php echo $config['url'];?>home/addsession/";
}

function back()
{
	
	document.location.href="<?php echo $config['url'];?>home/manage_clients/";
}


function deletesessionhistory(str)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to delete this Session?"))
		{
	         	$.ajax({
				url:"<?php echo $config['url'];?>home/deletesession/",
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

function chngurl(str)
{
	if(str!='')
	{
		document.location.href='<?php echo $config['url'];?>home/viewclientsessions/'+str;
	} else
	{
              document.location.href='<?php echo $config['url'];?>home/viewclientsessions/';
	}
}

</script>
<style>
.second-tabs { min-width:120px; }
.third-tabs {min-width:120px; }
.four-tabs {min-width:120px; }
<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
#calendar table{border:none;}
img, object, embed{max-width:none;}
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
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/client_infoico.png"></span>My Clients</a></li>
        
        </ul>    
	 <div class="row">
              <div class="four form-select columns" style="top:10px;">
              
            
              <?php
                    //echo $clientid;
				
              echo $this->Form->select('Trainee.id',$tranee,array('empty'=>'-- All Client --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectid\').value= this.options[this.selectedIndex].text; chngurl(this.value);')); ?>          
                
                <input type="text" id="customSelectid" value="<?php if(isset($clientid) && $clientid!=''){
                foreach($tranee as $key=>$val)
                {
				  if($key==$clientid)
                  {
                  	 echo $val;
                  	 
                  }	
                	
                }
                }else{echo '-- All Client--';}?>"/>
                
              </div>
              
              <script>
              document.getElementById('TraineeId').value='<?php echo $clientid;?>';
              </script>
        <div style="float:right">
	        <input type="button" style="width:180px;margin-right:10px;" class="change-pic-nav" onclick="newsession();" value="Add New Session" name="submit"> 
	        <input type="button" style="width:120px;" class="change-pic-nav" onclick="back();" value="Back" name="submit">
        </div>
		<div style="clear:both"></div>
		<br />
<?php if(!empty($session_purc_data))
		{ ?>	 
			<!--<h2>Sessions History</h2>-->
			<?php foreach ($session_purc_data as $session_purc)
          {	?>
		<div class="list-colum second-tabs"><b>Session Type-:</b> <?php if(!empty($session_purc['workout']['workout_name'])){echo $session_purc['workout']['workout_name']; };  ?></div>
		<div class="list-colum second-tabs"><b>Sessions Purchased-:</b> <?php if(!empty($session_purc['SessionPurchase']['no_of_purchase'])){echo $session_purc['SessionPurchase']['no_of_purchase']; };  ?></div>
		<div class="list-colum second-tabs"><b>Sessions Used-:</b> <?php if(!empty($session_purc['SessionPurchase']['no_of_booked'])){echo $session_purc['SessionPurchase']['no_of_booked']; } else {echo 0;};  ?></div>
		<br />
		<?php }?>
		<?php } ?>
		<br />
		
        <?php if(!empty($trainees))
	{ ?>

        <div class="main-responsive-box"><ul class="listing-box all-headtabs">
          <li class="listing-heading">
            <div class="list-colum first-tabs" style="display:none">S.No.</div>
            <div class="list-colum second-tabs">Client Name</div>
            <div class="list-colum second-tabs">Session Type</div>
            <div class="list-colum third-tabs">Session</div>
            <div class="list-colum four-tabs" style="">Cost</div>
            <div class="list-colum fifth-tabs" style="">Date</div>
			<div class="list-colum sixth-tabs">Action</div>
          </li>
        </ul>
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
          <?php 
          $cnt=1;
	/* echo '<pre>';
         print_r($trainees);
	  echo '</pre>';*/
          foreach ($trainees as $trainee)
          {
          	
          ?>
            <li>
              <div class="list-colum first-tabs" style="display:none"><?php if(!empty($trainee['TraineesessionPurchase']['id'])){echo $trainee['TraineesessionPurchase']['id']; };  ?></div>
              <div class="list-colum second-tabs"><?php if(!empty($trainee['Trainee']['full_name'])){echo $trainee['Trainee']['full_name']; };  ?></div>
              <div class="list-colum second-tabs"><?php if(!empty($trainee['Workout']['workout_name'])){echo $trainee['Workout']['workout_name']; };  ?></div>
              <div class="list-colum third-tabs"><?php if(!empty($trainee['TraineesessionPurchase']['purchase_session'])){echo  $trainee['TraineesessionPurchase']['purchase_session']; };  ?></div>
              <div class="list-colum four-tabs" style=""><?php if(!empty($trainee['TraineesessionPurchase']['cost'])){echo  '$'.$trainee['TraineesessionPurchase']['cost']; };  ?></div>
              <div class="list-colum fifth-tabs" style=""><?php if(!empty($trainee['TraineesessionPurchase']['purchased_date'])){echo  date('m/d/y',strtotime($trainee['TraineesessionPurchase']['purchased_date'])); };  ?></div>
			  <div class="list-colum sixth-tabs"><a href="javascript:void(0);" onclick="deletesessionhistory(<?php echo $trainee['TraineesessionPurchase']['id'];?>);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a></div>
              
              
              
            </li>
         <?php   $cnt++; ?>
            <?php  }?>
            
          </div>
        </ul>
        
        
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
         
       
          
        </ul>      
      </div>
      <?php } else { echo '<div class="row" style=" color: #636363; float: left; font-family: HelveticaLTCondensedRegular; font-size: 15px;
      clear: both; margin-top: 81px;">No records found</div>';}?>
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
 <?php echo $this->Html->script('front/js/jquery.slimscroll.min');?>                 

<script type="text/javascript">
$(function(){
$('#testDivNested').slimscroll({ })
});
</script>                
                