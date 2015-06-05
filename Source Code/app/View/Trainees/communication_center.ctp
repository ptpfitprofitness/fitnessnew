<?php

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
	var pic=$('#TraineePhoto').val();
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
	$('#pcontentTrainerTxt').css('display','none');
	$('#pcontentclubTxt').css('display','none');
	    $('#pcontentclientTxt').css('display','none');
	if(str=='trainer')
	{
		
	    $('#pcontentclient').css('display','block');
	}
	
}

function textses(str)
{
	$('#pcontentTrainerTxt').css('display','none');
	   $('#pcontentclub').css('display','none');
	    $('#pcontentclient').css('display','none');
	if(str=='trainer')
	{
		
	    $('#pcontentclientTxt').css('display','block');
	}
	
}
function chatsess(str)
{
	 $('#pcontentTrainerTxt').css('display','block');
	 $('#pcontentclientTxt').css('display','none');	
	 $('#pcontentclient').css('display','none');
	
	
}

function popupOpenMail(str,popCm)
{
	
	popupOpen('popCm');
	$('#sentfor').val(str);
	//sendto
}

function popupOpenTxt(str,popCm)
{

	popupOpen('popCmTxt');
	$('#sentfor2').val(str);
	//sendto
}
//window.onload =  

function validCompose()
{
	
	var sendto=$('#sendto').val();
	var subject=$('#csubject').val();
	var message=$('#messagesd').val();
	var sendfor=$('#sentfor').val();
	var messageRt='';
	var flag=0;
	if(trimString(sendto)=='')
	{
		messageRt +="Please Select User \n";
		flag=1;
	}
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
		 var website_url ='<?php echo $config['url']?>trainees/postmessage';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "sentfor="+sendfor+"&sendto="+sendto+"&subject="+subject+"&mestype=E&message="+message,
				success: function(response)
					{
						if(response=='200')
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
		 var website_url ='<?php echo $config['url']?>trainees/postmessage';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "sentfor="+sendfor+"&sendto="+sendto+"&subject="+message+"&mestype=T&message="+message,
				success: function(response)
					{
						if(response=='200')
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
	
	if(str1=='Trainer')
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
	
	if(str1=='Trainer')
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


function popupOpenTxtIM(str,popCm)
{
	popupOpen('popCmTxtIM');
}

function validComposeTxtIM()
{
	
	var sendto=$('#imtrainer_id').val();

	var message=$('#messagesdtxtIM').val();
	
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
		 var website_url ='<?php echo $config['url']?>trainees/messageclient';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "&sendto="+sendto+"&subject="+message+"&mestype=C&message="+message,
				success: function(response)
					{
						if(response=='200')
						{
							alert('Message has been sent successfully');
							window.location.href=window.location.href;
							
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
function validComposeTxtIMRP()
{
	
	

	var message=$('#messagesdtxtIMRP').val();
	var rptrainer_id=$('#rptrainer_id').val();
	var rpclient_id=$('#rpclient_id').val();
	var rpmessage_id=$('#rpmessage_id').val();
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
		 var website_url ='<?php echo $config['url']?>trainees/messageclientrp';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "trainerid="+rptrainer_id+"&clientid="+rpclient_id+"&pmessageid="+rpmessage_id+"&mestype=T&message="+message,
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
</script>
<link rel="stylesheet" type="text/css" href="/css/css_chat/chat.css" />
<link rel="stylesheet" type="text/css" href="/css/css_chat/screen.css" />

<style>
<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
#calendar table{border:none;}
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
if ( $setSpecalistArr[$utype]['first_time_login'] == 0 )
{
		echo "<script type='text/javascript'>
		function codeAddress() {
            popupOpen('popterms');
        }
		window.onload = codeAddress;
		</script>";
		
}


?>
<section class="contentContainer clearfix">
    <!--<div class="inside-banner changecover-pic">-->
    <div class="inside-banner ">
    <!--<div class="change-coverpic" onclick="popupOpen('pop5');"><img src="<?php echo $config['url'];?>images/pencial_icon.png" /> Change Cover </div>-->
      <div class="row">
        <div class="eight inside-head offset-by-four columns">
          <h2 class="client-name"><?php echo $uname;?></h2>
          <h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['city'];?>, <?php echo $setSpecalistArr[$utype]['state'];?></h3>
          <p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ echo $setSpecalistArr[$utype]['userfb_status'];}?></p>
        </div>
      </div>
    </div>
    <div class="row">
      <?php echo $this->element('lefttrainee');?>
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
         
             <ul>
             <li><input type="button" style="width:162px;background:#4e4d3d;" class="change-pic-nav" onclick="emailses('trainer');" value="Email - Trainer" name="EmailSession"></li>
            <!-- <li><input type="button" style="width:150px;background:#4e4d3d;" class="change-pic-nav" onclick="textses('trainer');" value="Text Session - Trainer" name="TextSession"></li>-->
             <li><input type="button" style="width:145px;background:#4e4d3d;" class="change-pic-nav" onclick="chatsess('trainer');" value="IM - Trainer" name="Chat"></li>
           
           </ul>
          
           	
           <hr/>
           
               <div id="esession" style="display:none;">
               
               </div>
               
                <div id="tsession" style="display:none;">
               
               </div>
               
               <div id="csession" style="display:none;">
              
               </div>
               <div class="clear"></div>
               <div id="pcontentclient" style="display:none;">
               <div class="clear"><h2>Email - Trainer</h2>
               <input type="button" name="Inbox" value="Inbox" class="change-pic-nav" style="width:70px;background:#4e4d3d;margin-top:15px;margin-bottom:0px;"  onclick="showmess('Trainer','inboxclient','outboxclient');" > <input type="button" style="width:80px;margin-top:15px;margin-left:5px;" class="change-pic-nav" onclick="popupOpenMail('Trainer','popCm');" value="Compose" name="Compose">
               <input type="button" style="width:80px;margin-top:15px;margin-left:5px;background:#4e4d3d;" class="change-pic-nav" onclick="showmess('Trainer','outboxclient','inboxclient');" value="Sent" name="Sent">
               
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
            <!--  <div class="list-colum first-tabs" style="min-width:50px;"><?php // echo $i;?></div> -->
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
           <!-- <div class="list-colum first-tabs" style="min-width:50px;">S.No.</div>-->
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
             <!-- <div class="list-colum first-tabs" style="min-width:50px;"><?php // echo $i;?></div> -->
              <div class="list-colum second-tabs"><?php echo $client_name;?></div>
              <div class="list-colum third-tabs"><a href="javascript:void(0);" style="border: 0 none;  color: #262930;  font-family: arial;  font-size: 12px;  font-weight: normal;   padding: 0;" onclick="viewMessage('<?php echo base64_encode($val['Emessage']['id']);?>');"><?php echo $val['Emessage']['subject'];?></a></div>
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
               <div class="clear"><h2>Text - Trainer</h2>
               <input type="button" name="Inbox" value="Inbox" class="change-pic-nav" style="width:70px;background:#4e4d3d;margin-top:15px;margin-bottom:0px;"  onclick="showmessTxt('Trainer','inboxclient','outboxclient');" > <input type="button" style="width:80px;margin-top:15px;margin-left:5px;" class="change-pic-nav" onclick="popupOpenTxt('Trainer','popCmTxt');" value="Compose" name="Compose">
               <input type="button" style="width:80px;margin-top:15px;margin-left:5px;background:#4e4d3d;" class="change-pic-nav" onclick="showmessTxt('Trainer','outboxclientTxt','inboxclientTxt');" value="Sent" name="Sent">
                 <?php
              /* echo '<pre>';
               print_r($emessageclientArrTxt);
               echo '</pre>';*/
               
            
               if(!empty($emessageclientArrTxt)){               	
               ?>
               
                  <div class="main-responsive-box" id="inboxclientTxt"><ul class="listing-box ">
          <li class="listing-heading">
          <!--  <div class="list-colum first-tabs" style="min-width:50px;">S.No.</div>-->
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
            <!--  <div class="list-colum first-tabs" style="min-width:50px;"><?php // echo $i;?></div> -->
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
               if(!empty($emessageclientsentArrTxt)){               	
               ?>
               
                  <div class="main-responsive-box" id="outboxclientTxt" style="display:none;"><ul class="listing-box ">
          <li class="listing-heading">
           <!-- <div class="list-colum first-tabs" style="min-width:50px;">S.No.</div>-->
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
        	
        	foreach($clientDataArr as $key2=>$val2){
        		if($key2==$clientvid)
        		{
        			$client_name=$val2;
        		}
        	}
        	?>
            <li id="li_<?php echo ($val['Emessage']['id']);?>">
            <!--  <div class="list-colum first-tabs" style="min-width:50px;"><?php //echo $i;?></div> -->
              <div class="list-colum second-tabs"><?php echo $client_name;?></div>
              <div class="list-colum third-tabs"><a href="javascript:void(0);" style="border: 0 none;  color: #262930;  font-family: arial;  font-size: 12px;  font-weight: normal;   padding: 0;" onclick="viewMessage('<?php echo base64_encode($val['Emessage']['id']);?>');"><?php echo $val['Emessage']['subject'];?></a></div>
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
         
               
           
           </div>
                      
          </div>
         
          <div style="display: none;" id="pcontentTrainerTxt">
               <div class="clear"><h2>IM - Trainer</h2>
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
                                            <b><span style="float:right;"><?php if($imms['MessageBoard']['posted_by']=='C'){?><img src="<?php echo $config['url'];?>images/deleteic.png" style="border:none;padding-top:15px;float:right;clear:both;cursor:pointer;"onclick="deletethrd(<?php echo $imms['MessageBoard']['id'];?>);"/><?php }?><img src="<?php echo $config['url'];?>images/reply-all.png" style="border:none;padding-top:15px;clear:both;cursor:pointer;"onclick="replymesim(<?php echo $msgvaid;?>,<?php echo $imms['MessageBoard']['trainer_id'];?>,<?php echo $imms['MessageBoard']['client_id'];?>);"/></span></b>
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
                         <span class="imgspanmain" style="padding-left:13px;">  To : <?php if($imms2['MessageBoard']['posted_by']=='T'){ echo $clname2;}else{echo $trname2;}?><br/> <?php echo $msgva2;?><span>
                         <b><span style="float:right;"><?php if($imms2['MessageBoard']['posted_by']=='C'){?><img src="<?php echo $config['url'];?>images/deleteic.png" style="border:none;padding-top:15px;float:right;clear:both;cursor:pointer;"onclick="deletethrd(<?php echo $imms2['MessageBoard']['id'];?>);"/><?php }?><img src="<?php echo $config['url'];?>images/reply-all.png" style="border:none;padding-top:15px;clear:both;cursor:pointer;"onclick="replymesim(<?php echo $msgvaid;?>,<?php echo $imms2['MessageBoard']['trainer_id'];?>,<?php echo $imms2['MessageBoard']['client_id'];?>);"/></span></b>
                          </div>
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
                         <span class="imgspanmain"> <?php echo $msgva;?>  <b><span style="float:right;"><?php if($imms['MessageBoard']['posted_by']=='C'){?><img src="<?php echo $config['url'];?>images/deleteic.png" style="border:none;padding-top:15px;float:right;clear:both;cursor:pointer;"onclick="deletethrd(<?php echo $imms['MessageBoard']['id'];?>);"/><?php }?><img src="<?php echo $config['url'];?>images/reply-all.png" style="border:none;padding-top:15px;clear:both;cursor:pointer;"onclick="replymesim(<?php echo $msgvaid;?>,<?php echo $imms['MessageBoard']['trainer_id'];?>,<?php echo $imms['MessageBoard']['client_id'];?>);"/></span></b></span>
                         </div>
		                        <?php }
                         
                          	     }
                          }?>
                         
                   </div>
                     </div>
               </div>
                  
               </div>
           </div>
          
        </ul>  
      

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
                
   <!-- Change Pic popup -->
                <div id="pop4" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('pop4');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="/trainees/uploadpic/" controller="home" enctype="multipart/form-data" class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validuppic();">
                          <h2>Upload Profile Pic</h2>
                           <input type="file" name="data[Trainee][photo]" id="TraineePhoto" />
                           <?php echo $this->Form->hidden('Trainee.id',array('value'=>$this->Session->read('USER_ID')));?>
                           <?php echo $this->Form->hidden('Trainee.old_image',array('value'=>$setSpecalistArr[$utype]['photo']));?>
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
              
            <select name="sendto" id="sendto" onchange="document.getElementById('customSelectidUsr').value= this.options[this.selectedIndex].text;" class="sltbx">
                   <option value=""> --Select-- </option>
                     <?php
							
							foreach($clientDataArr as $key2=>$val2){
			        		
			        			echo ' <option value="'.$key2.'">'.$val2.'</option>';
			        		
			        	   }
							?>
            </select>  
                
                <input type="text" id="customSelectidUsr" value=" --Select-- "/>
                
              </div>
              
              
              
            </div>
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
              
            <select name="sendto2" id="sendto2" onchange="document.getElementById('customSelectidUsr2').value= this.options[this.selectedIndex].text;" class="sltbx">
                   <option value=""> --Select-- </option>
                   <?php
							
							foreach($clientDataArr as $key2=>$val2){
			        		
			        			echo ' <option value="'.$key2.'">'.$val2.'</option>';
			        		
			        	   }
							?>
            </select>  
                
                <input type="text" id="customSelectidUsr2" value=" --Select-- "/>
                
              </div>
              
              
              
            </div>
                       
                           <input type="hidden" name="sentfor2" id="sentfor2" value="" />
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
                          
                       
                           <input type="hidden" name="imtrainer_id" id="imtrainer_id" value="<?php echo $setSpecalistArr[$utype]['trainer_id'];?>" />
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
                         
                       
                           <input type="hidden" name="rptrainer_id" id="rptrainer_id" value="<?php echo $setSpecalistArr[$utype]['trainer_id'];?>" />
                           <input type="hidden" name="rpclient_id" id="rpclient_id" value="<?php echo $setSpecalistArr[$utype]['id'];?>" />
                           <input type="hidden" name="rpmessage_id" id="rpmessage_id" value="" />
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
						<a href="http://www.ptpfitpro.com/trainees/firstlogin/g" class="agreelink">I Accept</a>
					</div>
                    </div>
                  </div>
                </div>
				<!--TERMS AND CONDITION-->
                
                
                
                 
                <?php
                $unms='';
                if($this->Session->read('USER_ID')){
		
		$unms=$this->Session->read('USER_NAME').'_Client';
		
		}
		   ?>   
        <script>
        chatsess('trainer');
        </script>    
<!--   <script type="text/javascript" src="/js/chat_js/chatjs.php?uname=<?php //echo $unms;?>"></script>  -->           
           