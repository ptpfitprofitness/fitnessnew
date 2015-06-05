<?php
/*echo '<pre>';
//print_r($setSpecalistArr);
print_r($certifications);
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
  	$uname=$setSpecalistArr[$utype]['company_name'];
  }	
	
}

?>

<?php 
    echo $this->Html->css('front/nutrion');
    
    ?>
    
<?php

   echo $this->Html->script('jquery-1.3.1.min.js');
	echo $this->Html->script('jquery-ui-1.7.1.custom.min.js');
	//echo $this->Html->script('front/js/date.js');
	//echo $this->Html->script('front/js/jquery.datePicker.js');
	//echo $this->Html->script('daterangepicker.jQuery.js');

    //echo $this->Html->css('ui.daterangepicker.css');	
    echo $this->Html->css('redmond/jquery-ui-1.7.1.custom.css');
    //echo $this->Html->css('front/datePicker.css');
?>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<!--<script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>-->
<script>
 var bk=$.noConflict();
/*			bk(function(){
				  bk('#rangeA').daterangepicker({arrows:true}); 
			 });*/
 bk(function(){
	 bk('.already-sign').click(function(){
		 bk(this).children('.profile-list').slideToggle();
		 bk(this).toggleClass('active'); 
	 });
  });
  
/*  bk(function()
{
	bk('.date-pick').datePicker();
});*/
   bk(function() {
//bk( "#date1" ).datepicker();
bk( ".datvs" ).datepicker({ minDate: 0, maxDate: "+1M +10D" })
});
  


  
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



</script>

<script type="text/javascript">



 
function chngurl(str)
{
	if(str!='')
	{
		document.location.href='<?php echo $config['url'];?>home/exercise_history/'+str;
	}
}

 function popupOpenFd(str,str2){
		//var popupText = $(this).attr('title');
//		$('.buttons').children('span').text(popupText);
		$('#'+str).css('display','block');
		$('#'+str).animate({"opacity":"1"}, 300);
		$('#'+str).css('z-index','9999999999');	
		$('#fdtype').val(str2);	
		var tran = $("#TraineeId").val();
		$("#trainee_id").val(tran);		
	} 
	
	function validatefrmsfd()
    {
	 $('.loaderResultFd').show();
	 
	 //var range=$('#rangeA').val();
	 
	 
	  var trainer_id  = $('#trainer_id').val();
	  var trainee_id  = $('#trainee_id').val();
	  var added_date  = $('#exdate').val();
	  var sessType  = $('#CustomSessiontype').val();
	  var sessTime = $('#customSelectTime').val();
	 
	  
	
	
		if(trainer_id!='' && trainee_id!='' && added_date!=''){
					
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		 var website_url ='<?php echo $config['url']?>home/add_exercise_history';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: $('#addexercise').serialize(),
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
			alert('Please Fill all Fields.');
		}
	return false;
}

var gFiles = 0;
 function addNPlay(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay-' + gFiles); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplayexercise[]" id="exercise'+gFiles+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplayset[]" id="set'+gFiles+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" placeholder="Duration" style="  " value="" name="nplayduration[]" id="duration'+gFiles+'">'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplaycoaching_tip[]" id="coaching_tip'+gFiles+'">'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile(\'nplay-' + gFiles + '\')">Remove</a>'; 
 	tr.appendChild(td5);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles++; 
 } 
 
 function removeFile(aId) 
 {
 	//alert('1');
 	var obj = document.getElementById(aId); 
 	obj.parentNode.removeChild(obj); 
 } 
 
 var gFiles1 = 0;
 function addNPlay1(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay1-' + gFiles1); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplay1exercise[]" id="exercise'+gFiles1+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplay1set[]" id="set'+gFiles1+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" name="nplay1rep[]" id="rep'+gFiles1+'" value="" placeholder="Reps" />'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" name="nplay1temp[]" id="temp'+gFiles1+'" value="" placeholder="Weight" />'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = '<input type="text" name="nplay1rest[]" id="rest'+gFiles1+'" value="" placeholder="Rest" />'; 
 	tr.appendChild(td5);
 	
 	var td6 = document.createElement('td'); 
 	td6.setAttribute('style', 'padding: 9px 10px;');
 	td6.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplay1coaching_tip[]" id="coaching_tip'+gFiles1+'">'; 
 	tr.appendChild(td6);
 	
 	var td7 = document.createElement('td'); 
 	td7.setAttribute('style', 'padding: 9px 10px;');
 	td7.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile1(\'nplay1-' + gFiles1 + '\')">Remove</a>'; 
 	tr.appendChild(td7);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles1++; 
 } 
 
  function removeFile1(aId) 
 {
 	//alert('2');
 	var obj = document.getElementById(aId); 
 	obj.parentNode.removeChild(obj); 
 } 
 
 var gFiles2 = 0;
 function addNPlay2(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay2-' + gFiles2); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplay2exercise[]" id="exercise'+gFiles2+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplay2set[]" id="set'+gFiles2+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" name="nplay2rep[]" id="rep'+gFiles2+'" value="" placeholder="Reps" />'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" name="nplay2temp[]" id="temp'+gFiles2+'" value="" placeholder="Weight" />'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = '<input type="text" name="nplay2rest[]" id="rest'+gFiles2+'" value="" placeholder="Rest" />'; 
 	tr.appendChild(td5);
 	
 	var td6 = document.createElement('td'); 
 	td6.setAttribute('style', 'padding: 9px 10px;');
 	td6.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplay2coaching_tip[]" id="coaching_tip'+gFiles2+'">'; 
 	tr.appendChild(td6);
 	
 	var td7 = document.createElement('td'); 
 	td7.setAttribute('style', 'padding: 9px 10px;');
 	td7.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile2(\'nplay2-' + gFiles2 + '\')">Remove</a>'; 
 	tr.appendChild(td7);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles2++; 
 } 
 
  function removeFile2(aId) 
 {
 	//alert('3');
 	var obj = document.getElementById(aId);
 	obj.parentNode.removeChild(obj); 
 }
 
 var gFiles3 = 0;
 function addNPlay3(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay3-' + gFiles3); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplay3exercise[]" id="exercise'+gFiles3+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplay3set[]" id="set'+gFiles3+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" name="nplay3rep[]" id="rep'+gFiles3+'" value="" placeholder="Reps" />'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" name="nplay3temp[]" id="temp'+gFiles3+'" value="" placeholder="Weight" />'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = '<input type="text" name="nplay3rest[]" id="rest'+gFiles3+'" value="" placeholder="Rest" />'; 
 	tr.appendChild(td5);
 	
 	var td6 = document.createElement('td'); 
 	td6.setAttribute('style', 'padding: 9px 10px;');
 	td6.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplay3coaching_tip[]" id="coaching_tip'+gFiles3+'">'; 
 	tr.appendChild(td6);
 	
 	var td7 = document.createElement('td'); 
 	td7.setAttribute('style', 'padding: 9px 10px;');
 	td7.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile3(\'nplay3-' + gFiles3 + '\')">Remove</a>'; 
 	tr.appendChild(td7);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles3++; 
 } 
 
  function removeFile3(aId) 
 {
 	//alert('4');
 	var obj = document.getElementById(aId); 
 	obj.parentNode.removeChild(obj); 
 }
 
 var gFiles4 = 0;
 function addNPlay4(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay4-' + gFiles4); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplay4exercise[]" id="exercise'+gFiles4+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplay4set[]" id="set'+gFiles4+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" placeholder="Duration" style="  " value="" name="nplay4duration[]" id="duration'+gFiles4+'">'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplay4coaching_tip[]" id="coaching_tip'+gFiles4+'">'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile4(\'nplay4-' + gFiles4 + '\')">Remove</a>'; 
 	tr.appendChild(td5);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles4++; 
 } 
 
 function removeFile4(aId) 
 {
 	//alert('5');
 	var obj = document.getElementById(aId); 
 	obj.parentNode.removeChild(obj); 
 }
 function popupOpen3(str)
 {
 	if(str!='')
 	{
 	  popupOpen('popFd');
 	  var dtsv=$('#rangeA').val();
 	  var clname=$('#customSelectid').val();
 	  $('#exdate').val(dtsv);
 	  $('#clnamewt').html(clname);
 	  //alert(clname);
 	  	
 	}
 }
 function chngdts(str)
{
	
    var res = str.split("/");
   
   var surl=res[0]+'-'+res[1]+'-'+res[2];
  
   window.location.href="<?php echo $surl;?>"+"/"+surl;
}

function checkhistory()
{
	var clientid=$('#TraineeId').val();
	if(clientid!='')
	{
		 window.location.href="<?php echo $config['url']?>home/exercise_viewhistory/"+clientid;
	}else
	{
	  alert('Please select the client first.');	
	}
}
function backworkout()
{
	window.location.href="<?php echo $config['url']?>home/exercise_history/";
}

</script>

 
<style>
<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
#calendar table{border:none;}
#dp-popup{z-index:9999999999999999999999999999;}
.th2 h3 {
    color: #424242;
   font-family: 'HelveticaLTCondensedRegular';
    font-size: 16px;
    font-style: normal;
    margin-bottom: 7px;
}   
.throw  {
    color: #424242;
    font-family: 'HelveticaLTCondensedRegular';
   font-size: 14px;
    font-style: normal;
    margin-bottom: 7px;
    padding-left:12px;
    }
.new {
color: #424242;
    font-family: 'HelveticaLTCondensedRegular';
   font-size: 14px;
    font-style: normal;
    margin-bottom: 7px;
    margin-left:360px;
    
}
}
table tr td {
    border: medium none;
    color: #333333;
    padding: 9px 10px;
    vertical-align: top;
}

#addexercise{font-size:14px;font-family: 'HelveticaLTCondensedRegular';}

#rangeA{background: url(<?php echo $config['url'];?>images/calender_ico.png) no-repeat scroll 7px 7px #FFF;
padding-left:30px;}

/* located in demo.css and creates a little calendar icon
 * instead of a text link for "Choose date"
 */
a.dp-choose-date {
	float: left;
	width: 16px;
	height: 16px;
	padding: 0;
	margin: 5px 3px 0;
	display: block;
	text-indent: -2000px;
	overflow: hidden;
	background: url(../../images/calendar.png) no-repeat; 
}
a.dp-choose-date.dp-disabled {
	background-position: 0 -20px;
	cursor: default;
}
/* makes the input field shorter once the date picker code
 * has run (to allow space for the calendar icon
 */
input.dp-applied {
	width: 140px;
	float: left;
}


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
          <li><a href="#Profile" class="active"><span class="profile-ico"></span>Manage Exercise</a></li>
       
        </ul>    
       
        <ul class="profile-tabs-list mobile-tab clearfix">
         
           <div class="clear">&nbsp;</div>
           
           <?php /*if($showoff==1){*/?>
         
            <input type="button" name="submit" value="Exercise History" class="change-pic-nav" style="  float: left; height: 36px; margin: 0 0 10px 10px; width: 140px;"/>
            <input type="button" name="submit" value="Back" class="change-pic-nav" onclick="backworkout();" style="  float: left; height: 36px; margin: 0 0 10px 10px; width: 100px;"/>
           
		 <?php /*}*/?>
         
 <form accept-charset="utf-8" method="post" id="validcertificationtrainers" class="resform-wrap" enctype="multipart/form-data" controller="home" action="/home/addcertification_trainer/">
		<?php 
		
		?>
		
		
		
		<input type="hidden"  name="data[CertificationTrainers][trainer_id]" id="CertificationTrainers_trainer_id" value="<?php echo $setSpecalistArr[$utype]['id'];?>"/>
		
           
          <?php if(isset($clientid) && $clientid!=''){?>
           <!--  <div class="dpckr" style="float: left;width: 55%;">

		<input  value="<?php //echo $datva;?>" id="rangeA" type="text" readonly="readonly">	
		</div>-->
		
				
              <br/>
            
            
				
			  <?php
            if(isset( $rst))
            {
            	echo  $rst;
            	
            }?>

           
            <?php }?>
            
           
           
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
   
                <!-- Exercise History Popup  -->
                <div id="popFd" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent" style="width:684px;margin-left:-305px;"> <a class="close-nav" onclick="popupClose('popFd');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                       
                        
                        
                        <form id="addexercise" action="" method="POST" onsubmit="return validatefrmsfd();">
      
        <h2>Build a Workout</h2>
         <div class="loaderResultFd" style="display: none;"><img src="<?php echo $config['url'];?>images/ajax-loader.gif"></div> <div style="color:#ff0000; padding:4px 0 4px 0;" id="notificatin_mesFd"></div>
         <input type="hidden" name="trainer_id" id="trainer_id" value="<?php echo $setSpecalistArr[$utype]['id'];?>"/>
         <input type="hidden" name="trainee_id" id="trainee_id" value="<?php if(isset($clientid) && $clientid!=''){ echo $clientid;}?>"/>
         <input type="hidden" name="added_date" id="added_date" value="<?php echo $datva2;?>"/>
         
       
            
         <!--table border='1' width='100%'>
				
				<tr class='slectedmn'>
				<td colspan='4' class="th2"><h3 style='text-align:left;float:left;'>PROFESSIONAL'S NAME: </h3> <span id="trsname" style="float: left; line-height: 32px;  padding: 10px 5px 5px;"><?php echo $setSpecalistArr[$utype]['full_name'];?></span>
				
				</td>
				
				</tr>
			</table-->
         
         <table border='1' width='100%'>
				
				<tr class='slectedmn'>
				<td width="100%" colspan='4' class="th2"><h3 style='text-align:left;float:left;'>Client Name:   </h3> <span id="clnamewt" style="float: left; line-height: 32px;  padding: 10px 5px 5px;"></span>
				</td>
					
				
				
				</tr>
				
				
				
				
				
				<tr class='slectedmn'>
			
				<td width="30%" colspan="2"> <span style="line-height:34px;float:left;">Session Type:</span>
				 <div class="twelve  form-select columns">
             
				
   <?php
               //$sestypeArr=array('I'=>'Individual','C'=>'Associated with Club');
               
               //$sestimeArr=array('15'=>'Basic','30'=>'Group 30','45'=>'Group 45','60'=>'Group 60');
               ?>  
               <?php 
               $dftime='-- Session Type --';
               ?>
               <select id="ScheduleCalendarTimeslot" onchange="document.getElementById('CustomSessiontype').value= this.options[this.selectedIndex].text" class="sltbx" name="sessType">
<option value="">-- Session Type --</option>
<?php 
if(!empty($workoutname)){
for($i=0;$i<count($workoutname);$i++)
{
	
	?>

<option <?php if(isset($setslot)&&($setslot==$workoutname[$i]['WorkOuts']['workout_time'])) { echo "'selected'='selected'";} ?>  value="<?php echo $workoutname[$i]['WorkOuts']['workout_time'];?>"><?php echo $workoutname[$i]['WorkOuts']['workout_name'];?></option>
<?php }
}?>
</select>
                    
				<?php  //echo $this->Form->select('ScheduleCalendar.timeslot',$workoutname,array('empty'=>'-- Select Workout --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectClubid1\').value= this.options[this.selectedIndex].text')); ?>
				<?php
				for($i=0;$i<count($workoutname);$i++)
					{
				if(isset($setslot)&&($setslot==$workoutname[$i]['WorkOuts']['workout_time']))
				{
					
					$dftime=	$workoutname[$i]['WorkOuts']['workout_name'];
					
				}
					}
					
				 ?>
				      
			
                <input type="text" id="CustomSessiontype" name="sessTypet" value="<?php echo $dftime;?>"/>
				
                
               
              </div>
				</td>		
				<td width="20%"> <span style="line-height:34px;float:left;">Date:</span><input name="exdate" id="exdate" value="" type="text" class="datvs"  style="width:100px;"/></td>
		<td width="30%">
		<span style="line-height:34px;">Time:</span>
		<div class="twelve form-select columns">
		
		<select id="sTime" onchange="document.getElementById('customSelectTime').value= this.options[this.selectedIndex].text;" class="sltbx" name="workTime">
		<option value="">-- Select Time --</option>
		<option value="08:00:00">08:00 A.M</option>
		<option value="08:30:00">08:30 A.M</option>
		<option value="09:00:00">09:00 A.M</option>
		<option value="09:30:00">09:30 A.M</option>
		<option value="10:00:00">10:00 A.M</option>
		<option value="10:30:00">10:30 A.M</option>
		<option value="11:00:00">11:00 A.M</option>
		<option value="11:30:00">11:30 A.M</option>
		<option value="12:00:00">12:00 P.M</option>
		<option value="12:30:00">12:30 P.M</option>
		<option value="13:00:00">01:00 P.M</option>
		<option value="13:30:00">01:30 P.M</option>
		<option value="14:00:00">02:00 P.M</option>
		<option value="14:30:00">02:30 P.M</option>
		<option value="15:00:00">03:00 P.M</option>
		<option value="15:30:00">03:30 P.M</option>
		<option value="16:00:00">04:00 P.M</option>
		<option value="16:30:00">04:30 P.M</option>
		<option value="17:00:00">05:00 P.M</option>
		<option value="17:30:00">05:30 P.M</option>
		</select>          
                
                <input type="text" value="-- Select Time --" name="workTimet" id="customSelectTime">
                </div>
		

		</td>		
				
				
				</tr>
				
				
				
				
				
				
				
			</table>
				

			<table border='1' width='100%'>
			<tr class='slectedmn'>
				<td colspan='3' class="th2"><span style="float: left; line-height: 36px;">Goal:</span> <input name="goal" id="goal" value="<?php if(!empty($clientGoal)){ echo $clientGoal['Goal']['goal'];}?>" type="text"   style="width:220px;"/></td><td > <span style="float: left; line-height: 36px;">Phase:</span> <input name="phase" id="phase" value="<?php if(!empty($clientGoal)){ echo $clientGoal['Goal']['phase'];}?>" type="text"   style="width:100px;"/></td>
				
				
				</tr>
			</table>	
			
			<table border='1' width='100%'>
			<tr class='slectedmn'>
				<td  class="th2"><span style="float: left; line-height: 36px;">Note:</span><textarea id="note" name="note" style="width: 94%;"><?php if(!empty($clientGoal)){ echo $clientGoal['Goal']['note'];}?></textarea></td>
				
				
				</tr>
			</table>
			
			<table border='1' width='100%'>
			<tr class='slectedmn'>
				<td  class="th2"><span style="float: left; line-height: 36px;">Alert:</span><textarea id="alert" name="alert" style="width: 94%;"><?php if(!empty($clientGoal)){ echo $clientGoal['Goal']['alert'];}?></textarea></td>
				
				
				</tr>
			</table>	
			
			 <table border='1' width='100%' id="w">
				<tr class='slectedmn'>
				<td colspan='5' class="th2"><h3 style='text-align:left;'>Warm-Up </h3>
				
				</td>
				</tr>
				
				<th  class="throw">Exercise</th>
				<th  class="throw">Sets</th>
				<th  class="throw">Duration</th>
				<th  class="throw">Coaching Tip</th>
				<th  class="throw"></th>
				
				</tr>
				
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplayexercise[]" value="" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplayset[]" id="set" value="" placeholder="Sets" /></td>
		     <td><input type="text" name="nplayduration[]" id="duration" value="" placeholder="Duration" /></td>
		     <td><input type="text" name="nplaycoaching_tip[]" id="coaching_tip" value="" placeholder="Coaching Tip" /></td>
		     <td></td>
		     
		     
		     <!--<td id="responce"></td>-->
		     </tr>
		     

    
	     
	    
	     
     
     </table>   
     <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id='addButton' onclick="addNPlay('w');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 
	      </div>
	      
     <table border='1' width='100%' id="cbp">
     <tr class='slectedmn'>
				<td colspan='7' class="th2"><h3 style='text-align:left;'>CORE/BALANCE/PLYOMETRIC </h3>
				
				</td>
				</tr>
				
				<th  class="throw">Exercise</th>
				<th  class="throw">Sets</th>
				<th  class="throw">Reps</th>
				<th  class="throw">Weight</th>
				<th  class="throw">Rest</th>
				<th  class="throw">Coaching Tip</th>
				<th><th>
				</tr>
				
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplay1exercise[]" value="" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplay1set[]" id="set" value="" placeholder="Sets" /></td>
		     <td><input type="text" name="nplay1rep[]" id="rep" value="" placeholder="Reps" /></td>
		     <td><input type="text" name="nplay1temp[]" id="temp" value="" placeholder="Weight" /></td>
		     <td><input type="text" name="nplay1rest[]" id="rest" value="" placeholder="Rest" /></td>
		     <td><input type="text" name="nplay1coaching_tip[]" id="coaching_tip" value="" placeholder="Coaching Tip" /></td>
             <td></td>		    
		          
	     
	     </tr>
	     
      </table> 
      <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id='addButton1' onclick="addNPlay1('cbp');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 
	      </div>
      
       <table border='1' width='100%' id="saq">
     <tr class='slectedmn'>
				<td colspan='7' class="th2"><h3 style='text-align:left;'>SPEED/AGILITY/QUICKNESS </h3>
				
				</td>
				</tr>
				
				<th  class="throw">Exercise</th>
				<th  class="throw">Sets</th>
				<th class="throw">Reps</th>
				<th class="throw">Weight</th>
				<th class="throw">Rest</th>
				<th class="throw">Coaching Tip</th>
				<th><th>
				</tr>
				
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplay2exercise[]" value="" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplay2set[]" id="set" value="" placeholder="Sets" /></td>
		     <td><input type="text" name="nplay2rep[]" id="rep" value="" placeholder="Reps" /></td>
		     <td><input type="text" name="nplay2temp[]" id="temp" value="" placeholder="Weight" /></td>
		     <td><input type="text" name="nplay2rest[]" id="rest" value="" placeholder="Rest" /></td>
		     <td><input type="text" name="nplay2coaching_tip[]" id="coaching_tip" value="" placeholder="Coaching Tip" /></td>
		     <td></td>
	     
	     </tr>
	    
      </table> 
      <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id='addButton2' onclick="addNPlay2('saq');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 
	      </div>    
      
       <table border='1' width='100%' id="res">
     <tr class='slectedmn'>
				<td colspan='7' class="th2"><h3 style='text-align:left;'>RESISTANCE </h3>
				
				</td>
				</tr>
				
				<th  class="throw">Exercise</th>
				<th  class="throw">Sets</th>
				<th class="throw">Reps</th>
				<th class="throw">Weight</th>
				<th class="throw">Rest</th>
				<th class="throw">Coaching Tip</th>
				<th></th>
				</tr>
				
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplay3exercise[]" value="" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplay3set[]" id="set" value="" placeholder="Sets" /></td>
		     <td><input type="text" name="nplay3rep[]" id="rep" value="" placeholder="Reps" /></td>
		     <td><input type="text" name="nplay3temp[]" id="temp" value="" placeholder="Weight" /></td>
		     <td><input type="text" name="nplay3rest[]" id="rest" value="" placeholder="Rest" /></td>
		     <td><input type="text" name="nplay3coaching_tip[]" id="coaching_tip" value="" placeholder="Coaching Tip" /></td>
		     <td></td>
		          
	     
	     </tr>
	     
      </table> 
       <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id='addButton3' onclick="addNPlay3('res');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 
	      </div>    
      
      <table border='1' width='100%' id="cd">
				<tr class='slectedmn'>
				<td colspan='5' class="th2"><h3 style='text-align:left;'>COOL-DOWN </h3>
				
				</td>
				</tr>
				
				<th  class="throw">Exercise</th>
				<th  class="throw">Sets</th>
				<th  class="throw">Duration</th>
				<th  class="throw">Coaching Tip</th>
				<th></th>
				</tr>
				
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplay4exercise[]" value="" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplay4set[]" id="set" value="" placeholder="Sets" /></td>
		     <td><input type="text" name="nplay4duration[]" id="duration" value="" placeholder="Duration" /></td>
		     <td><input type="text" name="nplay4coaching_tip[]" id="coaching_tip" value="" placeholder="Coaching Tip" /></td>
		     <td></td>
		          
	     
	     </tr>
	   
     
     </table>  
     <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id='addButton4' onclick="addNPlay4('cd');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 
	      </div> 
     
     <div class="twelve already-member columns">
                          <input type="submit" value="Send To Calendar" name="" class="submit-nav" >
                       </div>
            </div>
      
    </form>
                        
                        
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Exercise History  End -->            
                        