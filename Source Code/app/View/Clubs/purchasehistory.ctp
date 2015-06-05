<?php
//echo "<pre>";print_r($paymentArr); echo "</pre>";
$logo=$config['url'].'images/avtar.png';

if($this->Session->read('USER_ID'))
{
	
if($setUser=='ClubBranch')
	{
		$utype='ClubBranch';
		$logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['website_logo'];
		//die();
	}
	else {
$utype=$this->Session->read('UTYPE');
	}


  if($utype=='Club' || $utype=='ClubBranch' || $utype=='Trainer')
  {
  	if($setSpecalistArr[$utype]['website_logo']!='')
  	{
  		$logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['website_logo'];
		
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

function popupOpenFd(str,str2){
		//var popupText = $(this).attr('title');
//		$('.buttons').children('span').text(popupText);
		$('#'+str).css('display','block');
		$('#'+str).animate({"opacity":"1"}, 300);
		$('#'+str).css('z-index','9999999999');	
		$('#fdtype').val(str2);			
	}
	
function setstatus(id,st)
{
	r = confirm("Are you sure want to change the status of the trainer ?");
	if(r){
		//elem.innerHTML = "Please Wait,while chnaging";
		$.ajax({
				url:"<?php echo $config['url'];?>clubs/setstatus/",
				type:"POST",
				data:"id="+id+"&st="+st,
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
function changeFunc() {
    var selectBox = document.getElementById("selectBox");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    if (selectedValue== "active")
	{
		document.location.href="<?php echo $config['url'];?>clubs/active_trainer/";
	}
	else if (selectedValue== "inactive")
	{
		document.location.href="<?php echo $config['url'];?>clubs/in_active_trainer/";
	}
	else if (selectedValue== "all" )
	{
		document.location.href="<?php echo $config['url'];?>clubs/manage_trainer/";
	}
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
		 var website_url ='<?php echo $config['url']?>clubs/invite_new_trainer';
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
	
</script>
<style>
.second-tabs { width:100px !important; word-wrap: break-word;}
.third-tabs {width:100px !important; word-wrap: break-word; }

<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
#calendar table{border:none;}
	.agreelink{	float: right;
font-weight: bold;
background: #000;
padding: 10px 18px;
color: #fff;
border-radius: 10px;}
</style>






<section class="contentContainer clearfix">
	<div class="inside-banner changecover-pic">
		<div class="row">
			<div class="eight inside-head offset-by-four columns">
				<h2 class="client-name"><?php echo $uname;?></h2>
				<h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['city'].', '.$setSpecalistArr[$utype]['state'];?></h3>
				<p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ echo $setSpecalistArr[$utype]['userfb_status'];}?></p>
			</div>
		</div>
	</div>

	<div class="row">
		<?php //echo $this->element('leftclub');?>
		<div class="twelve inside-head columns">
			<ul class="profile-tabs-list desktop-tabs clearfix">
				<li><a class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/trainerm.png"></span>Purchase History</a></li>
				<li><a href="#" class="active" onclick="history.go(-1)" ><span class="profile-ico9"></span>Back to Home</a></li>
			</ul> 
			
			<div class="main-responsive-box" style="margin:15px 0 0 0;">
				<table>
					<tr>
						<td style="border:1px solid #e5e5e5; font-weight:bold;">Name</td>
						<td style="border:1px solid #e5e5e5; font-weight:bold;">Email</td>
						<td style="border:1px solid #e5e5e5; font-weight:bold;">Plan</td>  
						<td style="border:1px solid #e5e5e5; font-weight:bold;">Amount</td>
						<td style="border:1px solid #e5e5e5; font-weight:bold;">Payment Type</td>
						<td style="border:1px solid #e5e5e5; font-weight:bold;">Coupon</td>
						<td style="border:1px solid #e5e5e5; font-weight:bold;">Payment Date</td>
						<td style="border:1px solid #e5e5e5; font-weight:bold;">Next Payment Date</td>
						<td style="border:1px solid #e5e5e5; font-weight:bold;">Trainer Purchased</td>
					</tr>		
				
					
						<?php 
							$cnt=1;
							foreach($paymentArr as $padata)
								{
						?>						
						
							<tr>								
								<td><?php if($padata['Payment']['trainer_name'] != ''){ echo $padata['Payment']['trainer_name']; }else {echo '-';} ?></td>
								<td><?php if($padata['Payment']['trainer_email'] != ''){ echo $padata['Payment']['trainer_email']; }else {echo '-';} ?></td>
								<td><?php if($padata['Payment']['subscriptionplan'] != ''){ echo $padata['Payment']['subscriptionplan']; }else {echo '-';} ?></td>
								<td><?php if($padata['Payment']['amount'] != ''){echo '$';echo $padata['Payment']['amount']; }else {echo '-';} ?></td>
								<td><?php if($padata['Payment']['paymenttype'] != ''){ echo $padata['Payment']['paymenttype']; }else {echo '-';} ?></td>
								<td><?php if($padata['Payment']['coupon_code'] != ''){ echo $padata['Payment']['coupon_code']; }else {echo '-';} ?></td>
								<td><?php if($padata['Payment']['paymentdate'] != ''){ echo $padata['Payment']['paymentdate']; }else {echo '-';} ?></td>
								<td><?php if($padata['Payment']['nextbillingdate'] != ''){ echo $padata['Payment']['nextbillingdate']; }else {echo '-';} ?></td>
								<td><?php if($padata['Payment']['no_of_trainer_purchased'] != ''){ echo $padata['Payment']['no_of_trainer_purchased']; }else {echo '-';} ?></td>								
							</tr>				
												
						<?php   $cnt++; ?>
						<?php  }?>
					
				</table>
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
                
   <!-- Food Popup  -->
                <div id="popFd" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popFd');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                       
                        
                        
                        <form id="addtrainer" action="" method="POST" onsubmit="return validatefrmsfd();">
      
        <h2>Invite New Trainer</h2>
         <div class="loaderResultFd" style="display: none;"><img src="<?php echo $config['url'];?>images/ajax-loader.gif"></div> <div style="color:#ff0000; padding:4px 0 4px 0;" id="notificatin_mesFd"></div>
         
         <?php
         $clubid=$setSpecalistArr['Club']['id'];
         $club_branch_id='';
         if($this->Session->read('ClubBr')!='')
         {
         	$club_branch_id=$this->Session->read('ClubBr');
         }
         ?>
         
         <input type="hidden" name="club_id" id="club_id" value="<?php echo $clubid;?>"/>
          <input type="hidden" name="club_branch_id " id="club_branch_id " value="<?php echo $club_branch_id;?>"/>
            <div class="row">
              <div class="twelve columns">
                 <input type="text" id="first_name" name="first_name" value="" placeholder="First Name" />
       
              </div>
            </div>
            
           <div class="row">
              <div class="twelve columns">
                <input type="text" name="last_name" id="last_name" value="" placeholder="Last Name" />
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
                <!-- Food Popup  End -->           
 <?php echo $this->Html->script('front/js/jquery.slimscroll.min');?>                 

<script type="text/javascript">
$(function(){
$('#testDivNested').slimscroll({ })
});
</script>   

<!-- poppaidtrainer popup -->
<div id="poppaidtrainer" class="main-popup">
<div class="overlaybox common-overlay"></div>
<div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('poppaidtrainer');" id="poppaidtrainer" href="javascript:void(0);"></a>
<div class="row register-popup-form">
<div class="twelve field-pad columns">
<p style="font-size:15px; font-weight:bold;">Please go to "billing information" to add another trainer.</p>
<a href="<?php echo $config['url']?>clubs/index?bipop=1" class="agreelink" style="float:left; margin:18px 0">Purchase Now</a>
</div>
</div>
</div>
</div>
<!-- poppaidtrainer popup -->


<!-- poppaidtrainer popup -->
<div id="popfreetrainer" class="main-popup">
<div class="overlaybox common-overlay"></div>
<div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popfreetrainer');" id="popfreetrainer" href="javascript:void(0);"></a>
<div class="row register-popup-form">
<div class="twelve field-pad columns">
<p style="font-size:15px; font-weight:bold;">In Free Trial Period you can not add more than 1 Trainer. Please go to "billing information" to purchase subscription and add another trainer.</p>
<a href="<?php echo $config['url']?>clubs/index?bipop=1" class="agreelink" style="float:left; margin:18px 0">Purchase Now</a>
</div>

</div>
</div>
</div>
<!-- poppaidtrainer popup -->

<?php
if($setSpecalistArr['Club']['no_trainer'] >= $setSpecalistArr['Club']['paid_trainer'] && $setSpecalistArr['Club']['subscriptionplan']!='')
{
		echo "<script type='text/javascript'>
		function codeAddress() {
            popupOpen('poppaidtrainer');
        }
		window.onload = codeAddress;
		</script>";
		
}
else if($setSpecalistArr['Club']['no_trainer'] >= 1 && $setSpecalistArr['Club']['subscriptionplan']=='')
{
		echo "<script type='text/javascript'>
		function codeAddress() {
            popupOpen('popfreetrainer');
        }
		window.onload = codeAddress;
		</script>";
		
}
?>             
                