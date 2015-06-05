<?php
/*echo '<pre>';
print_r($setSpecalistArr);
print_r($setSpecalistArrPayment);
//print_r($certifications);
echo '</pre>';
//die();*/
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

/* delete thread start */

function deletethrd(str2)
{
	if(str2!='')
	{
		if(confirm("Are you sure, you want to delete this message?"))
		{
	 $.post("<?php echo $config['url'];?>home/deletethrd", {id: str2}, function(data)
            {
            	document.location.href=document.location.href;
            });
		}
	}
}
/* delete thread end */


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

function emailsession()
{
	$('#tsession').css('display','none');
	$('#csession').css('display','none');
	$('#esession').css('display','block');
	$('#clientch').css('display','none');
	$('#pcontentclientTxt').css('display','none');
	$('#pcontentclubTxt').css('display','none');
}

function textsession()
{
	
	$('#csession').css('display','none');
	$('#esession').css('display','none');
	$('#pcontentclient').css('display','none');
	$('#pcontentclub').css('display','none');
	$('#tsession').css('display','block');
	$('#clientch').css('display','none');
	
}
function chatSession()
{
	$('#esession').css('display','none');
	$('#tsession').css('display','none');
	$('#csession').css('display','block');
	$('#pcontentclient').css('display','none');
	$('#pcontentclub').css('display','none');
	$('#pcontentclientTxt').css('display','none');
	$('#pcontentclubTxt').css('display','none');
}
function emailses(str)
{
	$('#clientch').css('display','none');
	$('#pcontentclubTxt').css('display','none');
	    $('#pcontentclientTxt').css('display','none');
	if(str=='client')
	{
		$('#pcontentclub').css('display','none');
	    $('#pcontentclient').css('display','block');
	}
	if(str=='club')
	{		
	    $('#pcontentclient').css('display','none');
	    $('#pcontentclub').css('display','block');
	}
}

function textses(str)
{
	$('#clientch').css('display','none');
	   $('#pcontentclub').css('display','none');
	    $('#pcontentclient').css('display','none');
	if(str=='client')
	{
		$('#pcontentclubTxt').css('display','none');
	    $('#pcontentclientTxt').css('display','block');
	}
	if(str=='club')
	{		
	    $('#pcontentclientTxt').css('display','none');
	    $('#pcontentclubTxt').css('display','block');
	}
}
function chatsess(str)
{
	 $('#clientch').css('display','block');
	 if(str=='client')
	 {
	 	 $('#pcontentclubIMTxt').css('display','none');
	 	  $('#pcontentclientIMTxt').css('display','block');
	 } else
	 {
	 	 $('#pcontentclubIMTxt').css('display','block');
	 	  $('#pcontentclientIMTxt').css('display','none');
	 }
	 
	
	 $('#pcontentclientTxt').css('display','none');
	 $('#pcontentclubTxt').css('display','none');
	 $('#pcontentclub').css('display','none');
	 $('#pcontentclient').css('display','none');
	 if(str!='')
	 {
	 	 var website_url ='<?php echo $config['url']?>home/getchatuser';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "userfor="+str,
				success: function(response)
					{
						if(response!='404')
						{
							var chtdt='<div style="clear: both; font-family: arial; width: 100%; padding: 5px; background: none repeat scroll 0px 0px rgb(204, 204, 204); border-bottom: 1px solid rgb(0, 0, 0);"><a onclick="javascript:chatWith(\'anil\')" href="javascript:void(0);"><img src="<?php echo $config['url'];?>images/widget_online_icon.gif"> Anil2</a></div>';
							$('#chatmdcnt').html('');
							$('#chatmdcnt').html(response);
							
						}
						
						
					}
				});		 	
	 }
	
}

function popupOpenMail(str,popCm)
{
	 var website_url ='<?php echo $config['url']?>home/gettrainersuser';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "userfor="+str,
				success: function(response)
					{
						if(response!='404')
						{
							$('#sendto').html('');
							$('#sendto').html(response);
							popupOpen('popCm');
						}
						
						
					}
				});	
	
	$('#sentfor').val(str);
	//sendto
}

function popupOpenTxt(str,popCm)
{
	 var website_url ='<?php echo $config['url']?>home/gettrainersuser';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "userfor="+str,
				success: function(response)
					{
						if(response!='404')
						{
							$('#sendto2').html('');
							$('#sendto2').html(response);
							popupOpen('popCmTxt');
						}
						
						
					}
				});	
	
	$('#sentfor2').val(str);
	//sendto
}

function popupOpenTxtIM(str,popCm)
{
	 var website_url ='<?php echo $config['url']?>home/gettrainersuser';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "userfor="+str,
				success: function(response)
					{
						if(response!='404')
						{
							$('#sendto2IM').html('');
							$('#sendto2IM').html(response);
							$('#sentfor2IM').val(str);
							
							popupOpen('popCmTxtIM');
						}
						
						
					}
				});	
	
	$('#sentfor2').val(str);
	//sendto
}


function validCompose()
{
	
	var sendto=$('#sendto').val();
	var subject=$('#csubject').val();
	var message=$('#messagesd').val();
	var sendfor=$('#sentfor').val();
	var messageRt='';
	var flag=0;
	/*if(trimString(sendto)=='')
	{
		messageRt +="Please Select User \n";
		flag=1;
	}*/
	if(trimString(subject)=='')
	{
		messageRt +="Please Enter Subject \n";
		flag=1;
	}
	if(trimString(message)=='')
	{
		messageRt +="Please Enter Message \n";
		flag=1;
	}
	if(flag>0)
	{
		alert(messageRt);
		return false;
	}
	else
	{
		 var website_url ='<?php echo $config['url']?>home/postmessage';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "sentfor="+sendfor+"&sendto="+sendto+"&subject="+subject+"&mestype=E&message="+message,
				success: function(response)
					{
						if(trimString(response)=='1')
						{
							alert('Mail has been sent successfully');
							window.location.href=window.location.href;
							popupClose('popCm');
							$('#csubject').val('');
							$('#messagesd').val('');
						}
						else
						{
							alert('Sorry, mail not sent. Some issue occur. Please try again');
						}
						
						
					}
				});	
				return false;
	}
	
	return false;
	
}

//validComposeTxt

function validComposeTxt()
{
	
	var sendto=$('#sendto2').val();

	var message=$('#messagesdtxt').val();
	var sendfor=$('#sentfor2').val();
	var messageRt='';
	var flag=0;
	/*if(trimString(sendto)=='')
	{
		messageRt +="Please Select User \n";
		flag=1;
	}*/
	
	if(trimString(message)=='')
	{
		messageRt +="Please Enter Message \n";
		flag=1;
	}
	if(flag>0)
	{
		alert(messageRt);
		return false;
	}
	else
	{
		 var website_url ='<?php echo $config['url']?>home/postmessage';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "sentfor="+sendfor+"&sendto="+sendto+"&subject="+message+"&mestype=T&message="+message,
				success: function(response)
					{
						if(trimString(response)=='1')
						{
							alert('Mail/SMS has been sent successfully');
							window.location.href=window.location.href;
							popupClose('popCm');
							$('#csubject').val('');
							$('#messagesd').val('');
						}
						else
						{
							alert('Sorry, mail not sent. Some issue occur. Please try again');
						}
						
						
					}
				});	
				return false;
	}
	
	return false;
	
}





//validComposeTxtIM

function validComposeTxtIM()
{
	
	var sendto=$('#sendto2IM').val();

	var message=$('#messagesdtxtIM').val();
	var sendfor=$('#sentfor2IM').val();
	var messageRt='';
	var flag=0;
	if(trimString(sendto)=='')
	{
		messageRt +="Please Select User \n";
		flag=1;
	}
	
	if(trimString(message)=='')
	{
		messageRt +="Please Enter Message \n";
		flag=1;
	}
	if(flag>0)
	{
		alert(messageRt);
		return false;
	}
	else
	{
		 var website_url ='<?php echo $config['url']?>home/messageclient';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "sentfor="+sendfor+"&sendto="+sendto+"&subject="+message+"&mestype=T&message="+message,
				success: function(response)
					{
						if(trimString(response)==trimString('200'))
						{
							alert('Mail/SMS has been sent successfully');
							window.location.href=window.location.href;
							popupClose('popCm');
							$('#csubject').val('');
							$('#messagesd').val('');
						}
						else
						{
							alert('Sorry, mail not sent. Some issue occur. Please try again');
						}
						
						
					}
				});	
				return false;
	}
	
	return false;
	
}

function showmess(str1,str2,str3)
{
	//'Club','outboxclub','inboxclub'
	if(str1=='Club')
	{
		if(str2=='outboxclub')
		{
			$('#inboxclub').css('display','none');
			$('#outboxclub').css('display','block');
		}
		if(str2=='inboxclub')
		{
			$('#outboxclub').css('display','none');
			$('#inboxclub').css('display','block');
		}
	}
	if(str1=='Client')
	{
		if(str2=='outboxclient')
		{
			$('#inboxclient').css('display','none');
			$('#outboxclient').css('display','block');
		}
		if(str2=='inboxclient')
		{
			$('#outboxclient').css('display','none');
			$('#inboxclient').css('display','block');
		}
	}
}

function showmessTxt(str1,str2,str3)
{
	//'Club','outboxclub','inboxclub'
	if(str1=='Club')
	{
		if(str2=='outboxclubTxt')
		{
			$('#inboxclubTxt').css('display','none');
			$('#outboxclubTxt').css('display','block');
		}
		if(str2=='inboxclubTxt')
		{
			$('#outboxclubTxt').css('display','none');
			$('#inboxclubTxt').css('display','block');
		}
	}
	if(str1=='Client')
	{
		if(str2=='outboxclientTxt')
		{
			$('#inboxclientTxt').css('display','none');
			$('#outboxclientTxt').css('display','block');
		}
		if(str2=='inboxclient')
		{
			$('#outboxclientTxt').css('display','none');
			$('#inboxclientTxt').css('display','block');
		}
	}
}

function viewMessage(str)
{
	if(str!='')
	{
		
		 var website_url ='<?php echo $config['url']?>home/viewmessage';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "messageid="+str,
				success: function(response)
					{
						if(response!='0')
						{
							
							popupOpen('popVm');
							$('#vm').html(response);
						
						}
						else
						{
							alert('Sorry, mail data no loger exist.');
						}
						
						
					}
				});	
				
	}
	
}
function deletemess(str, str2)
{
	if(str!='')
	{
		
		 var website_url ='<?php echo $config['url']?>home/deletemessage';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "messageid="+str,
				success: function(response)
					{
						
							
							$('#li_'+str2).css('display','none');
						
						
					}
				});	
	}
}
function chatmax()
{
	 $('#chatmdcnt').css('height','94%');
}
function chatmin()
{
	 $('#chatmdcnt').css('height','0');
}
function closechat()
{
	 $('#chatmdcnt').css('height','0');
}
function replymesim(str,str1,str2)
{
	if(str!='' && str1!='' && str2!='')
	{
		popupOpen('popCmTxtIMRP');
		$('#rpmessage_id').val(str);
		$('#rptrainer_id').val(str1);
		$('#rpclient_id').val(str2);
		
	}
	
}
function replymesimcl(str,str1,str2,str3)
{
	if(str!='' && str1!='' && str2!='' && str3!='')
	{
		popupOpen('popCmTxtIMRP');
		$('#rpmessage_id').val(str);
		$('#rptrainer_id').val(str1);
		$('#rpclient_id').val(str2);
		$('#rptype').val(str3);
		
	}
	
}
function validComposeTxtIMRP()
{
	
	

	var message=$('#messagesdtxtIMRP').val();
	var rptrainer_id=$('#rptrainer_id').val();
	var rpclient_id=$('#rpclient_id').val();
	var rpmessage_id=$('#rpmessage_id').val();
	var rptype=$('#rptype').val();
	var messageRt='';
	var flag=0;
	
	if(trimString(message)=='')
	{
		messageRt +="Please Enter Message \n";
		flag=1;
	}
	if(flag>0)
	{
		alert(messageRt);
		return false;
	}
	else
	{
		if(trimString(rptype)!=''){
			 var website_url ='<?php echo $config['url']?>home/messageclubrp';
		}
		else{
		 var website_url ='<?php echo $config['url']?>home/messageclientrp';
		}
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "trainerid="+rptrainer_id+"&clientid="+rpclient_id+"&pmessageid="+rpmessage_id+"&mestype=T&message="+message+"&rptype="+rptype,
				success: function(response)
					{
						if(trimString(response)=='200')
						{
							alert('Message has been sent successfully');
							window.location.href=window.location.href;
							/*popupClose('popCm');
							$('#csubject').val('');
							$('#messagesd').val('');*/
						}
						else
						{
							alert('Sorry, message not sent. Some issue occur. Please try again');
						}
						
						
					}
				});	
				return false;
	}
	
	return false;
	
}



 
</script>
<link rel="stylesheet" type="text/css" href="/css/css_chat/chat.css" />
<link rel="stylesheet" type="text/css" href="/css/css_chat/screen.css" />

<style>
.list-scroll-wrap{height: 358px;margin: 0;overflow: scroll;}
.profile-tabs-list li a:hover{background:none; border:none;}
.form-select select{opacity:1;border: 1px solid hsl(0, 0%, 90%);border-radius: 4px;height: 80px;
 padding: 10px;}
.form-select{height:85px;}

<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
#calendar table{border:none;}
.vmcls{border: 0 none;
    color: #262930;
    font-family: arial;
    font-size: 12px;
    font-weight: normal;
    padding: 0;}

.imserow{
 background: none repeat scroll 0 0 #fafafa;
    float: left;
    width: 100%;
    padding-bottom:10px;
}
.imserow:nth-child(odd) {
 background: none repeat scroll 0 0 #eaeaea;
    float: left;
    width: 100%;
}
.imgspan{width: 20%; float: left;}
.imserow span img{border: 2px solid #ccc;
    padding: 1px;}
.imgspanmain{padding-top: 5px; float: left; font-family: arial; font-size: 13px;width:80%}
.chidlsp{ background: none repeat scroll 0 0 #ffd3d3;
    border-radius: 10px;
    margin-top: 15px;
    padding: 11px;}
	
	.agreelink{	float: right;
font-weight: bold;
background: #000;
padding: 10px 18px;
color: #fff;
border-radius: 10px;}
</style>
<?php
if ( $setSpecalistArr['Trainer']['first_time_login'] == 0 && $setSpecalistArr['Trainer']['trainer_type'] == C)
{
		echo "<script type='text/javascript'>
		function codeAddress() {
            popupOpen('popterms');
        }
		window.onload = codeAddress;
		</script>";
		
}
//print_r($setSpecalistArr);
//print_r($setSpecalistArrPayment);

/**** FOR 0-5 days left pop up in trial period****/

 $today_date=date_create(date("Y/m/d"));
 $user_added=date_create($setSpecalistArr['Trainer']['added_date']);
 $diff=date_diff($today_date,$user_added);
 $date_diff = $diff->format("%R%a");
 $actual_diff = 30 + $date_diff;

if ($actual_diff <= 5 && $actual_diff >= 0 && $setSpecalistArr['Trainer']['trainer_type'] == I && ($setSpecalistArr['Trainer']['subscriptionplan'] == "" || $setSpecalistArr['Trainer']['subscriptionplan'] == NULL))
{
	echo "<script type='text/javascript'>
		function codeAddress() {
            popupOpen('poppaymentbuttons');
        }
		window.onload = codeAddress;
		</script>";
}
/**** FOR 0-5 days left pop up in trial period****/



/**** After 0-5 days left period expire pop up in trial period****/
if ($actual_diff >= -15 && $actual_diff <= -1 && $setSpecalistArr['Trainer']['trainer_type'] == I && ($setSpecalistArr['Trainer']['subscriptionplan'] == "" || $setSpecalistArr['Trainer']['subscriptionplan'] == NULL))
{
	echo "<script type='text/javascript'>
		function codeAddress() {
            popupOpen('poppaymentbuttonpurchasenow');
        }
		window.onload = codeAddress;
		</script>";
}
/**** After 0-5 days left period expire pop up in trial period****/




/**** FOR 0-5 days left pop up in subscription period****/
/*echo '<pre>';
//print_r($setSpecalistArr);
print_r($setSpecalistArrPayment);
//print_r($certifications);
echo '</pre>';
die();*/
$payment_date=date_create($setSpecalistArrPayment['Payment']['paymentdate']);
$next_payment_date=date_create($setSpecalistArrPayment['Payment']['nextbillingdate']);
$diff=date_diff($today_date,$next_payment_date);
$date_diff = $diff->format("%R%a");
$date_diff_2 = $diff->format("%a");

if ($date_diff <= 5 && $date_diff >= 0 && ($setSpecalistArrPayment['Payment']['subscriptionplan'] != "" || $setSpecalistArrPayment['Payment']['subscriptionplan'] != NULL))
{
	echo "<script type='text/javascript'>
		function codeAddress() {
            popupOpen('poppaymentbuttonssubsc');
        }
		window.onload = codeAddress;
		</script>";
}
/**** FOR 0-5 days left pop up in subscription period****/


$trainer_unassign=date_create($setSpecalistArr['Trainer']['club_cancel_date']);
$unassigndiff=date_diff($trainer_unassign,$today_date);
$unassign_date_diff = $unassigndiff->format("%R%a");



/*** POP UP FOR CLUB CANCELLATION ***/
if ($unassign_date_diff == 0 && $setSpecalistArr['Trainer']['trainer_type'] == I && $setSpecalistArr['Trainer']['club_cancel_status'] == 1 && ($setSpecalistArr['Trainer']['subscriptionplan'] == "" || $setSpecalistArr['Trainer']['subscriptionplan'] == NULL))
{
	echo "<script type='text/javascript'>
		function codeAddress() {
            popupOpen('clubcancelintialpop');
        }
		window.onload = codeAddress;
		</script>";
}
/*** POP UP FOR CLUB CANCELLATION ***/

/*** POP UP FOR CLUB CANCELLATION II ***/
if ($unassign_date_diff > 0 && $unassign_date_diff <= 15 && $setSpecalistArr['Trainer']['trainer_type'] == I && $setSpecalistArr['Trainer']['club_cancel_status'] == 1 && ($setSpecalistArr['Trainer']['subscriptionplan'] == "" || $setSpecalistArr['Trainer']['subscriptionplan'] == NULL))
{
	echo "<script type='text/javascript'>
		function codeAddress() {
            popupOpen('clubcancelsecondpop');
        }
		window.onload = codeAddress;
		</script>";
}
/*** POP UP FOR CLUB CANCELLATION II ***/

?>


<section class="contentContainer clearfix">
    <div class="inside-banner changecover-pic">
    <!--<div class="change-coverpic" onclick="popupOpen('pop5');"><img src="<?php echo $config['url'];?>images/pencial_icon.png" /> Change Cover </div>-->
      <div class="row">
        <div class="eight inside-head offset-by-four columns">
          <h2 class="client-name"><?php echo $uname;?></h2>
          <h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['city'].', '.$setSpecalistArr[$utype]['state'];?></h3>
       <!--   <p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ if($this->Session->read('USER_ID') && ($this->Session->read('USER_ID')==$setSpecalistArr[$utype]['id'])){ echo '<a href="javascript:void(0);" onclick="editstatus('.$setSpecalistArr[$utype]['id'].');" style="color:#fff;">'.$setSpecalistArr[$utype]['userfb_status'].'</a>';} else {echo $setSpecalistArr[$utype]['userfb_status'];}} elseif($this->Session->read('USER_ID') && ($this->Session->read('USER_ID')==$setSpecalistArr[$utype]['id'])){ echo '<a href="javascript:void(0);" onclick="editstatus('.$setSpecalistArr[$utype]['id'].');" style="color:#fff;">Set your current status, click here!!!</a>';}?></p> -->
          
            <p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ if($this->Session->read('USER_ID') && ($this->Session->read('USER_ID')==$setSpecalistArr[$utype]['id'])){ echo $setSpecalistArr[$utype]['userfb_status'];} else {echo $setSpecalistArr[$utype]['userfb_status'];}} ?></p>
          
        </div>
      </div>
    </div>
    <div class="row">
     <?php echo $this->element('lefttrainer');?>
      <div class="eight inside-head columns" >
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/commication_ico.png"></span>Communication Center</a></li>
        
        </ul>    
        
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
          <div class="twelve columns profile-change-pictext">
           <div class="clear">&nbsp;</div>
           <div class="clear"></div>
           <div >
           <?php if($setSpecalistArr[$utype]['trainer_type']=='C'){?>
            <ul>
             <li><input type="button" name="EmailSession" value="Email" onclick="emailsession();" class="change-pic-nav" style="width:145px;"></li>
             <li><input type="button" name="TextSession" value="Text" onclick="textsession();" class="change-pic-nav" style="width:145px;"></li>
             <li><input type="button" name="Chat" value="Chat" onclick="chatSession();" class="change-pic-nav" style="width:145px;"></li>
           
           </ul>
           <?php } else{?>
             <ul>
             <li><input type="button" style="width:145px;background:#4e4d3d;" class="change-pic-nav" onclick="emailses('client');" value="Email - Client" name="EmailSession"></li>
             <li><input type="button" style="width:145px;background:#4e4d3d;" class="change-pic-nav" onclick="textses('client');" value="Text - Client" name="TextSession"></li>
             <li><input type="button" style="width:145px;background:#4e4d3d;" class="change-pic-nav" onclick="chatsess('client');" value="IM - Client" name="Chat"></li>
           
           </ul>
           <?php }?>
           	
           <hr/>
           
               <div id="esession" style="display:none;">
               <ul>
	             <li><input type="button" name="EmailSession" value="Email Session - Client" onclick="emailses('client');" class="change-pic-nav" style="width:145px;background:#4e4d3d;"></li>
	             <!--<li><input type="button" name="EmailSession1" value="Email Session - Club" onclick="emailses('club');" class="change-pic-nav" style="width:145px;background:#4e4d3d;"></li>    -->
             </ul>
               </div>
               
                <div id="tsession" style="display:none;">
               <ul>
	             <li><input type="button" name="TextSession" value="Text Session - Client" onclick="textses('client');" class="change-pic-nav" style="width:145px;background:#4e4d3d;"></li>
	             <!--<li><input type="button" name="TextSession1" value="Text Session - Club" onclick="textses('club');" class="change-pic-nav" style="width:145px;background:#4e4d3d;"></li>    -->
             </ul>
               </div>
               
               <div id="csession" style="display:none;">
               <ul>
	             <li><input type="button" name="Chat" value="IM Session - Client" onclick="chatsess('client');" class="change-pic-nav" style="width:145px;background:#4e4d3d;"></li>
	             <li><input type="button" name="Chat1" value="IM Session - Club" onclick="chatsess('club');" class="change-pic-nav" style="width:145px;background:#4e4d3d;"></li>    
             </ul>
               </div>
               <div class="clear"></div>
               <div id="pcontentclient" style="display:none;">
               <div class="clear"><h2>Email Session - Client</h2>
               <input type="button" name="Inbox" value="Inbox" class="change-pic-nav" style="width:70px;background:#4e4d3d;margin-top:15px;margin-bottom:0px;"  onclick="showmess('Client','inboxclient','outboxclient');" > <input type="button" style="width:80px;margin-top:15px;margin-left:5px;" class="change-pic-nav" onclick="popupOpenMail('Client','popCm');" value="Compose" name="Compose">
               <input type="button" style="width:80px;margin-top:15px;margin-left:5px;background:#4e4d3d;" class="change-pic-nav" onclick="showmess('Client','outboxclient','inboxclient');" value="Sent" name="Sent">
               
               <?php
               
             /*  echo '<pre>';
               print_r($clientDataArr);
               print_r($emessageclientArr);
               echo '</pre>';*/
             //emessageclientsentArr
               if(!empty($emessageclientArr)){               	
               ?>
               
                  <div class="main-responsive-box" id="inboxclient"><ul class="listing-box ">
          <li class="listing-heading">
            <!--<div class="list-colum first-tabs" style="min-width:50px;">S.No.</div>-->
            <div class="list-colum second-tabs">Sender Name</div>
            <div class="list-colum third-tabs">Subject</div>
            <div class="list-colum four-tabs" style="min-width:180px;">Date</div>
            <div class="list-colum fifth-tabs">Action</div>
          </li>
        </ul>
       
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
           <?php 
			$i=1;
           foreach($emessageclientArr as $key=>$val){
        	$clientvid=$val['Emessage']['sender_id'];
        	$client_name='';
        	
        	foreach($clientDataArr as $key2=>$val2){
        		if($key2==$clientvid)
        		{
        			$client_name=$val2;
        		}
        	}
        	?>
            <li id="li_<?php echo ($val['Emessage']['id']);?>">
             <!-- <div class="list-colum first-tabs" style="min-width:50px;"><?php // echo $i;?></div> -->
              <div class="list-colum second-tabs"><?php echo $client_name;?></div>
              <div class="list-colum third-tabs"><a href="javascript:void(0);" style="border: 0 none;  color: #262930;  font-family: arial;  font-size: 12px;  font-weight: normal;   padding: 0;" onclick="viewMessage('<?php echo base64_encode($val['Emessage']['id']);?>');"><?php echo $val['Emessage']['subject'];?></a></div>
              <div class="list-colum four-tabs"> <?php echo date('l jS  F Y h:i:s A',strtotime($val['Emessage']['sent_date']));?> </div>
              
           
							
							
              <div class="list-colum fifth-tabs"><a onclick="deletemess('<?php echo base64_encode($val['Emessage']['id']);?>',<?php echo ($val['Emessage']['id']);?>);" href="javascript:void(0);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a></div>
            </li>
         <?php $i++;}?>  
            
          </div>
        </ul>
             
               </div>
                 <?php }?>  
                  <?php
               
             /*  echo '<pre>';
               print_r($clientDataArr);
               print_r($emessageclientArr);
               echo '</pre>';*/
             //emessageclientsentArr
               if(!empty($emessageclientsentArr)){               	
               ?>
               
                  <div class="main-responsive-box" id="outboxclient" style="display:none;"><ul class="listing-box ">
          <li class="listing-heading">
            <!--<div class="list-colum first-tabs" style="min-width:50px;">S.No.</div>-->
            <div class="list-colum second-tabs">Receiver Name</div>
            <div class="list-colum third-tabs">Subject</div>
            <div class="list-colum four-tabs" style="min-width:180px;">Date</div>
            <div class="list-colum fifth-tabs">Action</div>
          </li>
        </ul>
       
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
           <?php 
			$i=1;
           foreach($emessageclientsentArr as $key=>$val){
        	$clientvid=$val['Emessage']['receiver_id'];
        	$client_name='';
        	
        	foreach($clientDataArr as $key2=>$val2){
        		if($key2==$clientvid)
        		{
        			$client_name=$val2;
        		}
        	}
        	?>
            <li id="li_<?php echo ($val['Emessage']['id']);?>">
             <!-- <div class="list-colum first-tabs" style="min-width:50px;"><?php // echo $i;?></div>-->
              <div class="list-colum second-tabs"><?php echo $client_name;?></div>
              <div class="list-colum third-tabs"><a href="javascript:void(0);" style="border: 0 none;  color: #262930;  font-family: arial;  font-size: 12px;  font-weight: normal;   padding: 0; " class="subhver" onclick="viewMessage('<?php echo base64_encode($val['Emessage']['id']);?>');"><?php echo $val['Emessage']['subject'];?></a></div>
              <div class="list-colum four-tabs"> <?php echo date('l jS  F Y h:i:s A',strtotime($val['Emessage']['sent_date']));?> </div>
              
           
							
							
              <div class="list-colum fifth-tabs"><a onclick="deletemess('<?php echo base64_encode($val['Emessage']['id']);?>',<?php echo ($val['Emessage']['id']);?>);" href="javascript:void(0);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a></div>
            </li>
         <?php $i++; }?>  
            
          </div>
        </ul>
             
               </div>
                 <?php }?> 
               </div>
           </div>  
         
               <div id="pcontentclub" style="display:none;">
               <div class="clear"><h2>Email Session - Club</h2>
               <input type="button" name="Inbox" value="Inbox"  class="change-pic-nav" style="width:70px;background:#4e4d3d;margin-top:15px;margin-bottom:0px;" onclick="showmess('Club','inboxclub','outboxclub');"> <input type="button" style="width:80px;margin-top:15px;margin-left:5px;" class="change-pic-nav" onclick="popupOpenMail('Club','popCm');" value="Compose" name="Compose">
               <input type="button" style="width:80px;margin-top:15px;margin-left:5px;background:#4e4d3d;" class="change-pic-nav" onclick="showmess('Club','outboxclub','inboxclub');" value="Sent" name="Sent">
               <?php
                if(!empty($emessageclubArr)){ 
               ?>
               
                  <div class="main-responsive-box" id="inboxclub"><ul class="listing-box ">
          <li class="listing-heading">
           <!-- <div class="list-colum first-tabs" style="min-width:50px;">S.No.</div> -->
            <div class="list-colum second-tabs">Sender Name</div>
            <div class="list-colum third-tabs">Subject</div>
            <div class="list-colum four-tabs" style="min-width:180px;">Date</div>
            <div class="list-colum fifth-tabs">Action</div>
          </li>
        </ul>
        
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
           <?php 	$i=1;
           foreach($emessageclubArr as $key=>$val){
        	$clubvid=$val['Emessage']['sender_id'];
        	$club_namev=$clubDataArr['Club']['club_name'];
        	
        	?>
            <li id="li_<?php echo ($val['Emessage']['id']);?>">
             <!-- <div class="list-colum first-tabs" style="min-width:50px;"><?php // echo $i;?></div> -->
              <div class="list-colum second-tabs"><?php echo $club_namev;?></div>
              <div class="list-colum third-tabs"><a href="javascript:void(0);" class="subhver" style="border: 0 none;  color: #262930;  font-family: arial;  font-size: 12px;  font-weight: normal;   padding: 0;" onclick="viewMessage('<?php echo base64_encode($val['Emessage']['id']);?>');"><?php echo $val['Emessage']['subject'];?></a></div>
              <div class="list-colum four-tabs"> <?php echo date('l jS  F Y h:i:s A',strtotime($val['Emessage']['sent_date']));?> </div>
              
           
							
							
              <div class="list-colum fifth-tabs"><a onclick="deletemess('<?php echo base64_encode($val['Emessage']['id']);?>',<?php echo ($val['Emessage']['id']);?>);" href="javascript:void(0);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a></div>
            </li>
         <?php $i++; }?>  
            
          </div>
        </ul>
             
               
               </div>
               <?php }?>

              <?php
                if(!empty($emessageclubsentArr)){ 
               ?>
               
                  <div class="main-responsive-box" id="outboxclub" style="display:none;"><ul class="listing-box ">
          <li class="listing-heading">
           <!-- <div class="list-colum first-tabs" style="min-width:50px;">S.No.</div>-->
            <div class="list-colum second-tabs">Sent To</div>
            <div class="list-colum third-tabs">Subject</div>
            <div class="list-colum four-tabs" style="min-width:180px;">Date</div>
            <div class="list-colum fifth-tabs">Action</div>
          </li>
        </ul>
       
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
            <?php 
 			$i=1;
            foreach($emessageclubsentArr as $key=>$val){
        	$clubvid=$val['Emessage']['receiver_id'];
        	$club_namev=$clubDataArr['Club']['club_name'];
        	
        	?>
            <li id="li_<?php echo ($val['Emessage']['id']);?>">
             <!-- <div class="list-colum first-tabs" style="min-width:50px;"><?php // echo $i;?></div> -->
              <div class="list-colum second-tabs"><?php echo $club_namev;?></div>
              <div class="list-colum third-tabs"><a href="javascript:void(0);" class="subhver" style="border: 0 none;  color: #262930;  font-family: arial;  font-size: 12px;  font-weight: normal;   padding: 0;" onclick="viewMessage('<?php echo base64_encode($val['Emessage']['id']);?>');"><?php echo $val['Emessage']['subject'];?></a></div>
              <div class="list-colum four-tabs"> <?php echo date('l jS  F Y h:i:s A',strtotime($val['Emessage']['sent_date']));?> </div>
              
           
							
							
              <div class="list-colum fifth-tabs"><a onclick="deletemess('<?php echo base64_encode($val['Emessage']['id']);?>',<?php echo ($val['Emessage']['id']);?>);" href="javascript:void(0);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a></div>
            </li>
          <?php $i++; }?>  
            
          </div>
        </ul>
            
               
               </div>
               <?php }?>
              </div>
              </div>
               <!-- Text Session Start -->
                 <div id="pcontentclientTxt" style="display:none;">
               <div class="clear"><h2>Text Session - Client</h2>
               <input type="button" name="Inbox" value="Inbox" class="change-pic-nav" style="width:70px;background:#4e4d3d;margin-top:15px;margin-bottom:0px;"  onclick="showmessTxt('Client','inboxclient','outboxclient');" > <input type="button" style="width:80px;margin-top:15px;margin-left:5px;" class="change-pic-nav" onclick="popupOpenTxt('Client','popCmTxt');" value="Compose" name="Compose">
               <input type="button" style="width:80px;margin-top:15px;margin-left:5px;background:#4e4d3d;" class="change-pic-nav" onclick="showmessTxt('Client','outboxclientTxt','inboxclientTxt');" value="Sent" name="Sent">
                 <?php
               
            
               if(!empty($emessageclientArrTxt)){               	
               ?>
               
                  <div class="main-responsive-box" id="inboxclientTxt"><ul class="listing-box ">
          <li class="listing-heading">
          <!--  <div class="list-colum first-tabs" style="min-width:50px;">S.No.</div> -->
            <div class="list-colum second-tabs">Sender Name</div>
            <div class="list-colum third-tabs">Subject</div>
            <div class="list-colum four-tabs" style="min-width:180px;">Date</div>
            <div class="list-colum fifth-tabs">Action</div>
          </li>
        </ul>
       
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
           <?php 
			$i=1;
           foreach($emessageclientArrTxt as $key=>$val){
        	$clientvid=$val['Emessage']['sender_id'];
        	$client_name='';
        	
        	foreach($clientDataArr as $key2=>$val2){
        		if($key2==$clientvid)
        		{
        			$client_name=$val2;
        		}
        	}
        	?>
            <li id="li_<?php echo ($val['Emessage']['id']);?>">
             <!-- <div class="list-colum first-tabs" style="min-width:50px;"><?php // echo $i;?></div> -->
              <div class="list-colum second-tabs"><?php echo $client_name;?></div>
              <div class="list-colum third-tabs"><a href="javascript:void(0);" class="subhver" style="border: 0 none;  color: #262930;  font-family: arial;  font-size: 12px;  font-weight: normal;   padding: 0;" onclick="viewMessage('<?php echo base64_encode($val['Emessage']['id']);?>');"><?php echo $val['Emessage']['subject'];?></a></div>
              <div class="list-colum four-tabs"> <?php echo date('l jS  F Y h:i:s A',strtotime($val['Emessage']['sent_date']));?> </div>
              
           
							
							
              <div class="list-colum fifth-tabs"><a onclick="deletemess('<?php echo base64_encode($val['Emessage']['id']);?>',<?php echo ($val['Emessage']['id']);?>);" href="javascript:void(0);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a></div>
            </li>
         <?php $i++;}?>  
            
          </div>
        </ul>
             
               </div>
                 <?php }?>  
                  <?php
               
             /*  echo '<pre>';
               print_r($clientDataArr);
               print_r($emessageclientArr);
               echo '</pre>';*/
             //emessageclientsentArr
               if(!empty($emessageclientsentArrTxt)){               	
               ?>
               
                  <div class="main-responsive-box" id="outboxclientTxt" style="display:none;"><ul class="listing-box ">
          <li class="listing-heading">
            
            <div class="list-colum second-tabs">Receiver Name</div>
            <div class="list-colum third-tabs">Subject</div>
            <div class="list-colum four-tabs" style="min-width:180px;">Date</div>
            <div class="list-colum fifth-tabs">Action</div>
          </li>
        </ul>
       
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
           <?php 
			$i=1;
           foreach($emessageclientsentArrTxt as $key=>$val){
        	$clientvid=$val['Emessage']['receiver_id'];
        	$client_name='';
        	//print_r($clientDataArr);
			
        	foreach($clientDataArr as $key2=>$val2){
        		if($key2==$clientvid)
        		{
        			$client_name=$val2;
        		}
        	}
        	?>
            <li id="li_<?php echo ($val['Emessage']['id']);?>">
              
              <div class="list-colum second-tabs"><?php echo $client_name;?></div>
              <div class="list-colum third-tabs"><a href="javascript:void(0);" class="subhver" style="border: 0 none;  color: #262930;  font-family: arial;  font-size: 12px;  font-weight: normal;   padding: 0;" onclick="viewMessage('<?php echo base64_encode($val['Emessage']['id']);?>');"><?php echo $val['Emessage']['subject'];?></a></div>
              <div class="list-colum four-tabs"> <?php echo date('l jS  F Y h:i:s A',strtotime($val['Emessage']['sent_date']));?> </div>
              
           
							
							
              <div class="list-colum fifth-tabs"><a onclick="deletemess('<?php echo base64_encode($val['Emessage']['id']);?>',<?php echo ($val['Emessage']['id']);?>);" href="javascript:void(0);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a></div>
            </li>
         <?php $i++; }?>  
            
          </div>
        </ul>
             
               </div>
                 <?php }?> 
               </div>
           </div>  
         
               <div id="pcontentclubTxt" style="display:none;">
               <div class="clear"><h2>Text Session - Club</h2>
               <input type="button" name="Inbox" value="Inbox"  class="change-pic-nav" style="width:70px;background:#4e4d3d;margin-top:15px;margin-bottom:0px;" onclick="showmessTxt('Club','inboxclubTxt','outboxclubTxt');"> <input type="button" style="width:80px;margin-top:15px;margin-left:5px;" class="change-pic-nav" onclick="popupOpenTxt('Club','popCmTxt');" value="Compose" name="Compose">
               <input type="button" style="width:80px;margin-top:15px;margin-left:5px;background:#4e4d3d;" class="change-pic-nav" onclick="showmessTxt('Club','outboxclubTxt','inboxclubTxt');" value="Sent" name="Sent">
               <?php
                if(!empty($emessageclubArrTxt)){ 
               ?>
               
                  <div class="main-responsive-box" id="inboxclub"><ul class="listing-box ">
          <li class="listing-heading">
         <!--   <div class="list-colum first-tabs" style="min-width:50px;">S.No.</div> -->
            <div class="list-colum second-tabs">Sender Name</div>
            <div class="list-colum third-tabs">Subject</div>
            <div class="list-colum four-tabs" style="min-width:180px;">Date</div>
            <div class="list-colum fifth-tabs">Action</div>
          </li>
        </ul>
        
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
           <?php 	$i=1;
           foreach($emessageclubArrTxt as $key=>$val){
        	$clubvid=$val['Emessage']['sender_id'];
        	$club_namev=$clubDataArr['Club']['club_name'];
        	
        	?>
            <li id="li_<?php echo ($val['Emessage']['id']);?>">
             <!-- <div class="list-colum first-tabs" style="min-width:50px;"><?php // echo $i;?></div> -->
              <div class="list-colum second-tabs"><?php echo $club_namev;?></div>
              <div class="list-colum third-tabs"><a href="javascript:void(0);" class="subhver" style="border: 0 none;  color: #262930;  font-family: arial;  font-size: 12px;  font-weight: normal;   padding: 0;" onclick="viewMessage('<?php echo base64_encode($val['Emessage']['id']);?>');"><?php echo $val['Emessage']['subject'];?></a></div>
              <div class="list-colum four-tabs"> <?php echo date('l jS  F Y h:i:s A',strtotime($val['Emessage']['sent_date']));?> </div>
              
           
							
							
              <div class="list-colum fifth-tabs"><a onclick="deletemess('<?php echo base64_encode($val['Emessage']['id']);?>',<?php echo ($val['Emessage']['id']);?>);" href="javascript:void(0);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a></div>
            </li>
         <?php $i++; }?>  
            
          </div>
        </ul>
             
               
               </div>
               <?php }?>

              <?php
                if(!empty($emessageclubsentArrTxt)){ 
               ?>
               
                  <div class="main-responsive-box" id="outboxclubTxt" style="display:none;"><ul class="listing-box ">
          <li class="listing-heading">
           <!-- <div class="list-colum first-tabs" style="min-width:50px;">S.No.</div> -->
            <div class="list-colum second-tabs">Sent To</div>
            <div class="list-colum third-tabs">Subject</div>
            <div class="list-colum four-tabs" style="min-width:180px;">Date</div>
            <div class="list-colum fifth-tabs">Action</div>
          </li>
        </ul>
       
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
            <?php 
 			$i=1;
            foreach($emessageclubsentArrTxt as $key=>$val){
        	$clubvid=$val['Emessage']['receiver_id'];
        	$club_namev=$clubDataArr['Club']['club_name'];
        	
        	?>
            <li id="li_<?php echo ($val['Emessage']['id']);?>">
             <!-- <div class="list-colum first-tabs" style="min-width:50px;"><?php // echo $i;?></div> -->
              <div class="list-colum second-tabs"><?php echo $club_namev;?></div>
              <div class="list-colum third-tabs"><a href="javascript:void(0);" class="subhver" style="border: 0 none;  color: #262930;  font-family: arial;  font-size: 12px;  font-weight: normal;   padding: 0;" onclick="viewMessage('<?php echo base64_encode($val['Emessage']['id']);?>');"><?php echo $val['Emessage']['subject'];?></a></div>
              <div class="list-colum four-tabs"> <?php echo date('l jS  F Y h:i:s A',strtotime($val['Emessage']['sent_date']));?> </div>
              
           
							
							
              <div class="list-colum fifth-tabs"><a onclick="deletemess('<?php echo base64_encode($val['Emessage']['id']);?>',<?php echo ($val['Emessage']['id']);?>);" href="javascript:void(0);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a></div>
            </li>
          <?php $i++; }?>  
            
          </div>
        </ul>
            
               
               </div>
               <?php }?>
 
               <!-- Text Session End -->
               
           
           </div>
                      
          </div>
       
          
        </ul>  
        <div id="clientch" style="display: none;">
         <div style="display: block;" id="pcontentclientIMTxt">
               <div class="clear"><h2>IM Session - Client</h2>
                <input type="button" name="Compose" value="Compose" onclick="popupOpenTxtIM('Client','popCmTxt');" class="change-pic-nav" style="width:80px;margin-top:15px;margin-left:5px;">
                  
       		  <div style="display: block;" id="outboxclientTxt" class="main-responsive-box">
                    <?php /*echo '<pre>';
                             print_r($emessageArrIMSesTxt2);
                         echo '</pre>';*/
                         ?>
                      <div style="clear:both;">
                      
                    <div class="main-responsive-box" id="ImboardTxt" style="height:358px; overflow-y:scroll;" >
                       
                          <?php if(!empty($emessageArrIMSesTxt)){
                          	     foreach ($emessageArrIMSesTxt as $imms) {
                          	     	$trname=$imms['Trainer']['full_name'];
                          	     	$trpic=$config['url'].'images/avtar.png';
                          	     	if($imms['Trainer']['logo']!=''){
                          	     		$trpic=$config['url'].'uploads/'.$imms['Trainer']['logo'];
                          	     	}
                          	     	$clname=$imms['Trainee']['full_name'];
                          	     	$clpic=$config['url'].'images/avtar.png';
                          	     	if($imms['Trainee']['photo']!='')
                          	     	{
                          	     		$clpic=$config['url'].'uploads/'.$imms['Trainee']['photo'];
                          	     	}
                          	     	$msgva=$imms['MessageBoard']['message'];
                          	     	$msgvadt=$imms['MessageBoard']['added_date'];
                          	     	$msgvaid=$imms['MessageBoard']['id'];
                          	     	if($imms['MessageBoard']['parent_message']==0){
                          	     	?>
                       <div class="imserow">
                         
                         <span class="imgspan"><img width="105" height="76" alt="" src="<?php if($imms['MessageBoard']['posted_by']=='T'){ echo $trpic;}else{echo $clpic;}?>">
                         <br/><i>Posted By - <?php if($imms['MessageBoard']['posted_by']=='T'){ echo $trname;}else{echo $clname;}?></i><br/><i style="font-size: 11px;"><?php echo date('m-d-Y',strtotime($msgvadt));?></i></span>
                         <span class="imgspanmain"> To : <?php if($imms['MessageBoard']['posted_by']=='T'){ echo $clname;}else{echo $trname;}?><br/><?php echo $msgva;?>
                                            <b><span style="float:right;"><img src="<?php echo $config['url'];?>images/deleteic.png" style="border:none;padding-top:15px;float:right;clear:both;cursor:pointer;"onclick="deletethrd(<?php echo $imms['MessageBoard']['id'];?>);"/><img src="<?php echo $config['url'];?>images/reply-all.png" style="border:none;padding-top:15px;clear:both;cursor:pointer;"onclick="replymesim(<?php echo $msgvaid;?>,<?php echo $imms['MessageBoard']['trainer_id'];?>,<?php echo $imms['MessageBoard']['client_id'];?>);"/></span></b>
                                          <?php if(!empty($emessageArrIMSesTxt2)){   foreach ($emessageArrIMSesTxt2 as $imms2) {
                          	     	$trname2=$imms2['Trainer']['full_name'];
                          	     	$trpic2=$config['url'].'images/avtar.png';
                          	     	if($imms2['Trainer']['logo']!=''){
                          	     		$trpic2=$config['url'].'uploads/'.$imms2['Trainer']['logo'];
                          	     	}
                          	     	$clname2=$imms2['Trainee']['full_name'];
                          	     	$clpic2=$config['url'].'images/avtar.png';
                          	     	if($imms2['Trainee']['photo']!='')
                          	     	{
                          	     		$clpic2=$config['url'].'uploads/'.$imms2['Trainee']['photo'];
                          	     	}
                          	     	$msgva2=$imms2['MessageBoard']['message'];
                          	     	$msgvadt2=$imms2['MessageBoard']['added_date'];
                          	     	$msgvaid2=$imms2['MessageBoard']['id'];
                          	     	if($imms2['MessageBoard']['parent_message']==$msgvaid){
                          	     	?> <div class="imserow chidlsp" style="<?php if($imms2['MessageBoard']['posted_by']=='T'){ echo 'background:#f3f3f3;';}else{echo 'background:#ffd3d3;';}?>">
                         
                         <span class="imgspan"><img width="105" height="76" alt="" src="<?php if($imms2['MessageBoard']['posted_by']=='T'){ echo $trpic2;}else{echo $clpic2;}?>">
                         <br/><i>Posted By - <?php if($imms2['MessageBoard']['posted_by']=='T'){ echo $trname2;}else{echo $clname2;}?></i><br/><i style="font-size: 11px;"><?php echo date('m-d-Y',strtotime($msgvadt2));?></i></span>
                         <span class="imgspanmain" style="padding-left:13px;">  To : <?php if($imms2['MessageBoard']['posted_by']=='T'){ echo $clname2;}else{echo $trname2;}?><br/> <?php echo $msgva2;?><span> <b><span style="float:right;"><img src="<?php echo $config['url'];?>images/deleteic.png" style="border:none;padding-top:15px;float:right;clear:both;cursor:pointer;"onclick="deletethrd(<?php echo $imms2['MessageBoard']['id'];?>);"/><img src="<?php echo $config['url'];?>images/reply-all.png" style="border:none;padding-top:15px;clear:both;cursor:pointer;"onclick="replymesim(<?php echo $msgvaid;?>,<?php echo $imms['MessageBoard']['trainer_id'];?>,<?php echo $imms['MessageBoard']['client_id'];?>);"/></span></b></div>
                         <div style="clear:both;"></div>
                         <?php  }?>
                                          
                                          <?php }
                                          }?>
                         </span>
                         </div>
                         <?php } else 
		                         {?>
		                         	 <div class="imserow" style="background:#ffd3d3">
                         
                         <span class="imgspan"><img width="105" height="76" alt="" src="<?php if($imms['MessageBoard']['posted_by']=='T'){ echo $trpic;}else{echo $clpic;}?>">
                         <br/><i>Posted By - <?php if($imms['MessageBoard']['posted_by']=='T'){ echo $trname;}else{echo $clname;}?></i><br/><i style="font-size: 11px;"><?php echo date('m-d-Y',strtotime($msgvadt));?></i></span>
                         <span class="imgspanmain"> <?php echo $msgva;?> <b><span style="float:right;"><img src="<?php echo $config['url'];?>images/deleteic.png" style="border:none;padding-top:15px;float:right;clear:both;cursor:pointer;"onclick="deletethrd(<?php echo $imms2['MessageBoard']['id'];?>);"/><img src="<?php echo $config['url'];?>images/reply-all.png" style="border:none;padding-top:15px;clear:both;cursor:pointer;"onclick="replymesim(<?php echo $msgvaid;?>,<?php echo $imms2['MessageBoard']['trainer_id'];?>,<?php echo $imms2['MessageBoard']['client_id'];?>);"/></span></b></span>
                         </div>
		                        <?php }
                         
                          	     }
                          }?>
                         
                   </div>
                     </div>
               </div>
                  
               </div>
           </div>
       
       
      
      
        
        <div style="display: none;" id="pcontentclubIMTxt">
               <div class="clear"><h2>IM Session - Club</h2>
			   
                <input type="button" name="Compose" value="Compose" onclick="popupOpenTxtIM('Club','popCmTxt');" class="change-pic-nav" style="width:80px;margin-top:15px;margin-left:5px;">
                  
       		  <div style="display: block;" id="outboxclientTxt" class="main-responsive-box">
                   
                      <div style="clear:both;">
                      
                    <div class="main-responsive-box" id="ImboardTxt" style="height:358px; overflow-y:scroll;" >
                       
                          <?php if(!empty($emessageArrIMSesTCTxt)){
                          	     foreach ($emessageArrIMSesTCTxt as $imms) {
                          	     	$trname=$imms['Trainer']['full_name'];
                          	     	$trpic=$config['url'].'images/avtar.png';
                          	     	if($imms['Trainer']['logo']!=''){
                          	     		$trpic=$config['url'].'uploads/'.$imms['Trainer']['logo'];
                          	     	}
                          	     	$clpic=$config['url'].'images/avtar.png';
                          	     	$clname=='';
                          	     	if($imms['MessageBoard']['clubbranch_id']!='' && $imms['MessageBoard']['clubbranch_id']!=0){
                          	     		foreach ($clubBrDataArr as $key=>$bnval)
                          	     		{
                          	     			if($bnval['ClubBranch']['id']==$imms['MessageBoard']['clubbranch_id'])
                          	     			{
                          	     					$clname=$bnval['ClubBranch']['full_name'];
                          	     					if($bnval['ClubBranch']['logo']!='')
					                          	     	{
					                          	     		 $clpic=$config['url'].'uploads/'.$bnval['ClubBranch']['logo'];
					                          	     	}	
                          	     						
                          	     			}
                          	     		}
                          	     	} else {
                          	     		$clname=$imms['Club']['full_name'];
                          	     		/*echo '<pre>';
                          	     		print_r($imms['Club']);*/
                          	     		if($imms['Club']['logo']!='')
		                          	     	{
		                          	     		$clpic=$config['url'].'uploads/'.$imms['Club']['logo'];
		                          	     	}
                          	     	}
                          	     	
                          	     	
                          	     	
                          	     	$msgva=$imms['MessageBoard']['message'];
                          	     	$msgvadt=$imms['MessageBoard']['added_date'];
                          	     	$msgvaid=$imms['MessageBoard']['id'];
                          	     	if($imms['MessageBoard']['parent_message']==0){
                          	     	?>
                       <div class="imserow">
                         
                         <span class="imgspan"><img width="105" height="76" alt="" src="<?php if($imms['MessageBoard']['posted_by']=='T'){ echo $trpic;}else{echo $clpic;}?>">
                         <br/><i>Posted By - <?php if($imms['MessageBoard']['posted_by']=='T'){ echo $trname;}else{echo $clname;}?></i><br/><i style="font-size: 11px;"><?php echo date('m-d-Y',strtotime($msgvadt));?></i></span>
                         <span class="imgspanmain"> To : <?php if($imms['MessageBoard']['posted_by']=='T'){ echo $clname;}else{echo $trname;}?><br/><?php echo $msgva;?>
                                            <b><img src="<?php echo $config['url'];?>images/deleteic.png" style="border:none;padding-top:15px;float:right;clear:both;cursor:pointer;"onclick="deletethrd(<?php echo $imms['MessageBoard']['id'];?>);"/><img src="<?php echo $config['url'];?>images/reply-all.png" style="border:none;padding-top:15px;clear:both;float:right;cursor:pointer;"onclick="replymesimcl(<?php echo $msgvaid;?>,<?php echo $imms['MessageBoard']['trainer_id'];?>,<?php if($imms['MessageBoard']['clubbranch_id']!='' && $imms['MessageBoard']['clubbranch_id']!=0) {echo $imms['MessageBoard']['clubbranch_id'];} else{ echo $imms['Club']['id'];}   ?>,<?php if($imms['MessageBoard']['clubbranch_id']!='' && $imms['MessageBoard']['clubbranch_id']!=0) {echo '\'ClubBranch\'';} else{ echo '\'Club\'';}   ?>);"/></b>
                                          <?php if(!empty($emessageArrIMSesTCTxt2)){   foreach ($emessageArrIMSesTCTxt2 as $imms2) {
                          	     	$trname2=$imms2['Trainer']['full_name'];
                          	     	$trpic2=$config['url'].'images/avtar.png';
                          	     	$clpic2=$config['url'].'images/avtar.png';
                          	     	$clname2=='';
                          	     	if($imms2['Trainer']['logo']!=''){
                          	     		$trpic2=$config['url'].'uploads/'.$imms2['Trainer']['logo'];
                          	     	}
                          	     	if($imms2['MessageBoard']['clubbranch_id']!=0 && $imms2['MessageBoard']['clubbranch_id']!=''){
                          	     		foreach ($clubBrDataArr as $key=>$bnval)
                          	     		{
                          	     			if($bnval['ClubBranch']['id']==$imms2['MessageBoard']['clubbranch_id'])
                          	     			{
                          	     					$clname2=$bnval['ClubBranch']['full_name'];
                          	     					if($bnval['ClubBranch']['logo']!='')
					                          	     	{
					                          	     		 $clpic2=$config['url'].'uploads/'.$bnval['ClubBranch']['logo'];
					                          	     	}	
                          	     						
                          	     			}
                          	     		}
                          	     	} else{
                          	     		$clname2=$imms2['Club']['full_name'];
                          	     	
		                          	     	if($imms2['Club']['logo']!='')
		                          	     	{
		                          	     		$clpic2=$config['url'].'uploads/'.$imms2['Club']['logo'];
		                          	     	}
                          	     		
                          	     	}
                          	     	
                          	     	
                          	     	$msgva2=$imms2['MessageBoard']['message'];
                          	     	$msgvadt2=$imms2['MessageBoard']['added_date'];
                          	     	$msgvaid2=$imms2['MessageBoard']['id'];
                          	     	if($imms2['MessageBoard']['parent_message']==$msgvaid){
                          	     	?> <div class="imserow chidlsp" style="<?php if($imms2['MessageBoard']['posted_by']=='T'){ echo 'background:#f3f3f3;';}else{echo 'background:#ffd3d3;';}?>">
                         
                         <span class="imgspan"><img width="105" height="76" alt="" src="<?php if($imms2['MessageBoard']['posted_by']=='T'){ echo $trpic2;}else{echo $clpic2;}?>">
                         <br/><i>Posted By - <?php if($imms2['MessageBoard']['posted_by']=='T'){ echo $trname2;}else{echo $clname2;}?></i><br/><i style="font-size: 11px;"><?php echo date('m-d-Y',strtotime($msgvadt2));?></i></span>
                         <span class="imgspanmain" style="padding-left:13px;">  To : <?php if($imms2['MessageBoard']['posted_by']=='T'){ echo $clname2;}else{echo $trname2;}?><br/> <?php echo $msgva2;?>
						 <!-- ADDED FOR REPLY AND DELETE BUTTON-->
						 <b><?php //echo "<pre>"; print_r($emessageArrIMSesTCTxt); echo "</pre>";  ?>
						 <img src="<?php echo $config['url'];?>images/deleteic.png" style="border:none;padding-top:15px;float:right;clear:both;cursor:pointer;"onclick="deletethrd(<?php echo $imms2['MessageBoard']['id'];?>);"/><img src="<?php echo $config['url'];?>images/reply-all.png" style="border:none;padding-top:15px;clear:both;float:right;cursor:pointer;"onclick="replymesimcl(<?php echo $msgvaid;?>,<?php echo $imms['MessageBoard']['trainer_id'];?>,<?php if($imms['MessageBoard']['clubbranch_id']!='' && $imms['MessageBoard']['clubbranch_id']!=0) {echo $imms['MessageBoard']['clubbranch_id'];} else{ echo $imms['Club']['id'];}   ?>,<?php if($imms['MessageBoard']['clubbranch_id']!='' && $imms['MessageBoard']['clubbranch_id']!=0) {echo '\'ClubBranch\'';} else{ echo '\'Club\'';}   ?>);"/></b>
						 <!-- ADDED FOR REPLY AND DELETE BUTTON-->
						 <span> </div>
                         <div style="clear:both;"></div>
                         <?php  }?>
                                          
                                          <?php }
                                          }?>
                         </span>
                         </div>
                         <?php } else 
		                         {?>
		                         	 <div class="imserow" style="background:#ffd3d3">
                         
                         <span class="imgspan"><img width="105" height="76" alt="" src="<?php if($imms['MessageBoard']['posted_by']=='T'){ echo $trpic;}else{echo $clpic;}?>">
                         <br/><i>Posted By - <?php if($imms['MessageBoard']['posted_by']=='T'){ echo $trname;}else{echo $clname;}?></i><br/><i style="font-size: 11px;"><?php echo date('m-d-Y',strtotime($msgvadt));?></i></span>
                         <span class="imgspanmain"> <?php echo $msgva;?></span>
                         </div>
		                        <?php }
                         
                          	     }
                          }?>
                         
                   </div>
                     </div>
               </div>
                  
               </div>
           </div>
       
       
      
        </div>

</div>    
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
                
                  <!-- Compose Message -->
                <div id="popCm" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popCm');" id="popCm1" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="" controller="home"  class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validCompose();">
                          <h2>Compose Mail</h2>
                           <div class="row">
              <div class="twelve form-select columns">
              
            <!--<select name="sendto" id="sendto" onchange="document.getElementById('customSelectidUsr').value= this.options[this.selectedIndex].text;" class="sltbx">
                   <option value=""> --Select-- </option>
            </select>  
                
                <input type="text" id="customSelectidUsr" value=" --Select-- "/>-->
                
				<?php echo $this->Form->select("sendto",'',array('empty'=>'Select Client','class'=>'sltbx','style'=>'','value'=>'','multiple' => 'multiple', 'onChange'=> "document.getElementById('customSelectidUsr').value= this.options[this.selectedIndex].text;"));?>
 <div style="display:none;float: left; width: 65px;" id="shoCur1"><input type="text" id="customSelectidUsr" class="" name="" style="float: left; width: 60px;"></div>
				
				
				
              </div>
              
              
              
            </div>
			<p style="margin:3px 0 3px 0">Hold Down Ctrl Key to select multiple Clients.</p>	
                          <input type="text" name="csubject" id="csubject" value="" placeholder="Subject" />
                           <input type="hidden" name="sentfor" id="sentfor" value="" />
						   
                 <textarea name="messagesd"  id="messagesd" placeholder="Message"></textarea>       
                          
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
                <!-- Compose End -->   
                
                 
                  <!-- View Message -->
                <div id="popVm" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popVm');" id="popVm1" href="javascript:void(0);"></a>
                    <div class="row register-popup-form" id="vm" style="padding:15px;">
                      
                     
                    </div>
                  </div>
                </div>
                <!-- View Message End -->    
                
                  <!-- Compose Text Start -->
                <div id="popCmTxt" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popCmTxt');" id="popCm3" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="" controller="home"  class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validComposeTxt();">
                          <h2>Compose Text Message</h2>
                           <div class="row">
              <div class="twelve form-select columns">
              
            <!--<select name="sendto2" id="sendto2" onchange="document.getElementById('customSelectidUsr2').value= this.options[this.selectedIndex].text;" class="sltbx">
                   <option value=""> --Select-- </option>
            </select>
			                
                <input type="text" id="customSelectidUsr2" value=" --Select-- "/>-->
			
<?php echo $this->Form->select("sendto2",'',array('empty'=>'Select Client','class'=>'sltbx','style'=>'','value'=>'','multiple' => 'multiple', 'onChange'=> "document.getElementById('customSelectidUsr2').value= this.options[this.selectedIndex].text;"));?>
 <div style="display:none;float: left; width: 65px;" id="shoCur"><input type="text" id="customSelectidUsr2" class="" name="" style="float: left; width: 60px;"></div>
              </div>
              
              
              
            </div>
                       
                           <input type="hidden" name="sentfor2" id="sentfor2" value="" />
				<p style="margin:3px 0 3px 0">Hold Down Ctrl Key to select multiple Clients.</p>		   
                 <textarea name="messagesdtxt"  id="messagesdtxt" placeholder="Message"></textarea>       
                          
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
                <!-- Compose End -->     
                
                
                
                
                

                
                
                
                
                
                
                
                
                
         <!-- Compose Text Start -->
                <div id="popCmTxtIM" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popCmTxtIM');" id="popCm3" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="" controller="home"  class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validComposeTxtIM();">
                          <h2>Send An IM Thread</h2>
                           <div class="row">
              <div class="twelve form-select columns">
              
            <select name="sendto2IM" id="sendto2IM" onchange="document.getElementById('customSelectidUsr3').value= this.options[this.selectedIndex].text;" class="sltbx">
                   <option value=""> --Select-- </option>
            </select>  
                
                <input type="text" id="customSelectidUsr3" value=" --Select-- "/>
                
              </div>
              
              
              
            </div>
                       
                           <input type="hidden" name="sentfor2IM" id="sentfor2IM" value="" />
                 <textarea name="messagesdtxtIM"  id="messagesdtxtIM" placeholder="Message"></textarea>       
                          
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
                <!-- Compose End -->           
                
                
                 <!-- Compose Text Start Reply -->
                <div id="popCmTxtIMRP" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popCmTxtIMRP');" id="popCm3" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="" controller="home"  class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validComposeTxtIMRP();">
                          <h2>Reply Message</h2>
                         
                       
                           <input type="hidden" name="rptrainer_id" id="rptrainer_id" value="" />
                           <input type="hidden" name="rpclient_id" id="rpclient_id" value="" />
                           <input type="hidden" name="rpmessage_id" id="rpmessage_id" value="" />
                           <input type="hidden" name="rptype" id="rptype" value="" />
                 <textarea name="messagesdtxtIMRP"  id="messagesdtxtIMRP" placeholder="Message"></textarea>       
                          
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
                <!-- Compose End --> 


<!--TERMS AND CONDITION-->
				<div id="popterms" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> 
				  <a class="close-nav" onclick="popupClose('popterms');" id="popterms" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        I agree to the Personal Training Partners <a target="_blank" href="http://www.ptpfitpro.com/terms-of-service">Terms of Use and Privacy Policy</a>
						<br />
						<a href="http://www.ptpfitpro.com/home/firstlogin/g" class="agreelink">I Accept</a>
					</div>
                    </div>
                  </div>
                </div>
				<!--TERMS AND CONDITION-->
				<!--Payment Button Pop Up-->
				<div id="poppaymentbuttons" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> 
				  <a class="close-nav" onclick="popupClose('poppaymentbuttons');" id="poppaymentbuttons" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
						<p style="font-size:18px; color: #ff0000; margin: 0; padding: 0;
    text-align: center;">There are only <?php echo $actual_diff; ?> Days left in your trial.</p>
						<br />
                        <a href="http://www.ptpfitpro.com/home/index?billpop=1" class="agreelink" style="float:left; margin:18px 0">Purchase Now</a>
						<br />
						<a onclick="popupClose('poppaymentbuttons');" id="poppaymentbuttons" href="javascript:void(0);" class="agreelink" style="float:right;">Purchase Later</a>
					</div>
                    </div>
                  </div>
                </div>
				<!--Payment Button Pop Up-->
				
				<!--Payment Button only purchase now Pop Up-->
				<div id="poppaymentbuttonpurchasenow" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> 
				    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
						<p style="font-size:18px; color: #ff0000; margin: 0; padding: 0;
    text-align: center;">Your 30 day trial has ended but it's still not to late to activate your account.  Thanks for giving us a try! <?php //$expired_left = 15 + $actual_diff; echo $expired_left; ?>.</p>	
						<br />
                        <a href="http://www.ptpfitpro.com/home/index?billpop=1" class="agreelink" style="float:left; margin:18px 0">Purchase Now</a>
						<br />
						
					</div>
                    </div>
                  </div>
                </div>
				<!--Payment Button only purchase now Pop Up-->
				
				
				
				
				<!--Payment Button Pop Up-->
				<div id="poppaymentbuttonssubsc" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> 
				  <a class="close-nav" onclick="popupClose('poppaymentbuttonssubsc');" id="poppaymentbuttonssubsc" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
						<p style="font-size:18px; color: #ff0000; margin: 0; padding: 0;
    text-align: center;"><?php echo $date_diff_2; ?> Days left in your subscription renew.</p>
						<br />
                        <a href="http://www.ptpfitpro.com/home/index?billpop=1" class="agreelink" style="float:left; margin:18px 0">Purchase Now</a>
						<br />
						<a onclick="popupClose('poppaymentbuttonssubsc');" id="poppaymentbuttonssubsc" href="javascript:void(0);" class="agreelink" style="float:right;">Purchase Later</a>
					</div>
                    </div>
                  </div>
                </div>
				<!--Payment Button Pop Up-->
				
				
				<!--Club Cancel Initial Pop up-->
				<div id="clubcancelintialpop" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> 
				  <a class="close-nav" onclick="popupClose('clubcancelintialpop');" id="clubcancelintialpop" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
						<p style="font-size:18px; color: #ff0000; margin: 0; padding: 0;
    text-align: center;">Your Club has cancelled their subscription but you can access your account for next 15 days at no cost. After free trial, Click on Purchase now to continue with us.</p>
						<br />
                        <a href="http://www.ptpfitpro.com/home/index?billpop=1" class="agreelink" style="float:left; margin:18px 0">Purchase Now</a>
						<br />						
					</div>
                    </div>
                  </div>
                </div>
				<!--Club Cancel Initial Pop up-->
				
				<!--Club Cancel Second Pop up-->
				<div id="clubcancelsecondpop" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> 
				  <a class="close-nav" onclick="popupClose('clubcancelsecondpop');" id="clubcancelsecondpop" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
						<p style="font-size:18px; color: #ff0000; margin: 0; padding: 0;
    text-align: center;"><?php echo 15 - $unassign_date_diff; ?> Days left in your Account Expiration.</p>
						<br />
                        <a href="http://www.ptpfitpro.com/home/index?billpop=1" class="agreelink" style="float:left; margin:18px 0">Purchase Now</a>
						<br />						
					</div>
                    </div>
                  </div>
                </div>
				<!--Club Cancel Second Pop up-->
				                
                
                
                
                
                
                
                
                
                 
                
                
                
                
                
                
                
                
                <?php
                $unms='';
                if($this->Session->read('USER_ID')){
		
		$unms=$this->Session->read('USER_NAME').'_Trainer';
		
		}
		   ?>   
 <script>
$( document ).ready(function() {
chatsess('client');
});
 </script>
 
 
  <!-- <script type="text/javascript" src="/js/chat_js/chatjs.php?uname=<?php //echo $unms;?>"></script>   -->          
           