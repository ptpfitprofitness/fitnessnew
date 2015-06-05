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

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>-->

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
bk( ".datvs" ).datepicker({ minDate: 0, maxDate: "+1M +10D" });
bk( "#rangeA" ).datepicker({ minDate: "-3M +10D", maxDate: "+1M +10D" });
bk( "#rangeB" ).datepicker({ minDate: "-3M +10D", maxDate: "+1M +10D" });
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

function deletewrkt(str,str1)
{
  if(str!='' && str1!='')
    {
    if(confirm("Are you sure, you want to delete this workout?")){

           var website_url ='<?php echo $config['url']?>home/deletewrkt/'+str+'/'+str1;
				$.ajax({
		   		type: "GET",
		   		url: website_url,								
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




     
     }
    }
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
	 
	  
	  var Stype = $("input:radio[name=Stype]:checked").val();
	 /* alert(Stype); 
	  return false;*/
	  if(Stype=='c')	
	  {
		if(trainer_id!='' && trainee_id!='' && sessType!='-- Session Availability --'){
					
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
						alert("Thanks, you have added Exercise History successfully.");
						var pdts=response.errorMsg;
						//document.location.href=document.location.href;
						document.location.href='<?php echo $config['url'].'home/scheduling_calendar';?>/'+pdts;
						
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
	  if(Stype=='w')
	  {
	  	
	  	 var workoutname  = $('#workoutname').val();
	     var workoutcategory  = $('#workoutcategory').val();
	  	
	     if(workoutname!='' && workoutcategory!='')
	     {
	  	
	  	var website_url ='<?php echo $config['url']?>home/add_exercise_history_temp';
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
	     } else
	     {
	     	alert('Please fill the name and select category.');
	     }
		return false;
	  }	
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
 
 
 
 
 
 
 var gFilesa = 0;
 function addNPlaya(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay-' + gFilesa); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplayexercise[]" id="exercise'+gFilesa+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplayset[]" id="set'+gFilesa+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" placeholder="Duration" style="  " value="" name="nplayduration[]" id="duration'+gFilesa+'">'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplaycoaching_tip[]" id="coaching_tip'+gFilesa+'">'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = ' <a href="javascript:void(0);" onclick="removeFilea(\'nplay-' + gFilesa + '\')">Remove</a>'; 
 	tr.appendChild(td5);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFilesa++; 
 } 
 
 function removeFilea(aId) 
 {
 	//alert('1');
 	var obj = document.getElementById(aId); 
 	obj.parentNode.removeChild(obj); 
 } 
 
 var gFiles1a = 0;
 function addNPlay1a(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay1-' + gFiles1a); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplay1exercise[]" id="exercise'+gFiles1a+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplay1set[]" id="set'+gFiles1a+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" name="nplay1rep[]" id="rep'+gFiles1a+'" value="" placeholder="Reps" />'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" name="nplay1temp[]" id="temp'+gFiles1a+'" value="" placeholder="Weight" />'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = '<input type="text" name="nplay1rest[]" id="rest'+gFiles1a+'" value="" placeholder="Rest" />'; 
 	tr.appendChild(td5);
 	
 	var td6 = document.createElement('td'); 
 	td6.setAttribute('style', 'padding: 9px 10px;');
 	td6.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplay1coaching_tip[]" id="coaching_tip'+gFiles1a+'">'; 
 	tr.appendChild(td6);
 	
 	var td7 = document.createElement('td'); 
 	td7.setAttribute('style', 'padding: 9px 10px;');
 	td7.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile1a(\'nplay1-' + gFiles1a + '\')">Remove</a>'; 
 	tr.appendChild(td7);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles1a++; 
 } 
 
  function removeFile1a(aId) 
 {
 	//alert('2');
 	var obj = document.getElementById(aId); 
 	obj.parentNode.removeChild(obj); 
 } 
 
 var gFiles2a = 0;
 function addNPlay2a(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay2-' + gFiles2a); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplay2exercise[]" id="exercise'+gFiles2a+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplay2set[]" id="set'+gFiles2a+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" name="nplay2rep[]" id="rep'+gFiles2a+'" value="" placeholder="Reps" />'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" name="nplay2temp[]" id="temp'+gFiles2a+'" value="" placeholder="Weight" />'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = '<input type="text" name="nplay2rest[]" id="rest'+gFiles2a+'" value="" placeholder="Rest" />'; 
 	tr.appendChild(td5);
 	
 	var td6 = document.createElement('td'); 
 	td6.setAttribute('style', 'padding: 9px 10px;');
 	td6.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplay2coaching_tip[]" id="coaching_tip'+gFiles2a+'">'; 
 	tr.appendChild(td6);
 	
 	var td7 = document.createElement('td'); 
 	td7.setAttribute('style', 'padding: 9px 10px;');
 	td7.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile2a(\'nplay2-' + gFiles2a + '\')">Remove</a>'; 
 	tr.appendChild(td7);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles2a++; 
 } 
 
  function removeFile2a(aId) 
 {
 	//alert('3');
 	var obj = document.getElementById(aId);
 	obj.parentNode.removeChild(obj); 
 }
 
 var gFiles3a = 0;
 function addNPlay3a(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay3-' + gFiles3a); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplay3exercise[]" id="exercise'+gFiles3a+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplay3set[]" id="set'+gFiles3a+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" name="nplay3rep[]" id="rep'+gFiles3a+'" value="" placeholder="Reps" />'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" name="nplay3temp[]" id="temp'+gFiles3a+'" value="" placeholder="Weight" />'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = '<input type="text" name="nplay3rest[]" id="rest'+gFiles3a+'" value="" placeholder="Rest" />'; 
 	tr.appendChild(td5);
 	
 	var td6 = document.createElement('td'); 
 	td6.setAttribute('style', 'padding: 9px 10px;');
 	td6.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplay3coaching_tip[]" id="coaching_tip'+gFiles3a+'">'; 
 	tr.appendChild(td6);
 	
 	var td7 = document.createElement('td'); 
 	td7.setAttribute('style', 'padding: 9px 10px;');
 	td7.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile3a(\'nplay3-' + gFiles3a + '\')">Remove</a>'; 
 	tr.appendChild(td7);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles3a++; 
 } 
 
  function removeFile3a(aId) 
 {
 	//alert('4');
 	var obj = document.getElementById(aId); 
 	obj.parentNode.removeChild(obj); 
 }
 
 var gFiles4a = 0;
 function addNPlay4a(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay4-' + gFiles4a); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplay4exercise[]" id="exercise'+gFiles4a+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplay4set[]" id="set'+gFiles4a+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" placeholder="Duration" style="  " value="" name="nplay4duration[]" id="duration'+gFiles4a+'">'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplay4coaching_tip[]" id="coaching_tip'+gFiles4a+'">'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile4a(\'nplay4-' + gFiles4a + '\')">Remove</a>'; 
 	tr.appendChild(td5);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles4a++; 
 } 
 
 function removeFile4a(aId) 
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
 
 function popupOpen3n(str)
 {
 	if(str!='')
 	{
 	  popupOpen('popFdn');
 	  var dtsv=$('#rangeA').val();
 	  var clname=$('#customSelectid').val();
 	  $('#exdate').val(dtsv);
 	  $('#clnamewt').html(clname);
 	  //alert(clname);
 	  	
 	}
 }
 
 function creatework(str)
 {
 	if(str=='c') 
 	{
 	  if($("#TraineeId").val()!='')	
 	  {
 	  	popupClose('popFdn');
 	  	popupOpen('popFd');
 	  	$('#a').show();
 		$('#b').show();
 		$('#c').show();
 		$('#d').show();
 		$('#k').hide();	
 	  }
 	  else
 	  {
 	  	alert("Please select client.");
 	  	popupClose('popFdn');
 	  }
 	}
 	if(str=='w')
 	{
 		popupClose('popFdn');
 		popupOpen('popFd');
 		
 		$('#a').hide();
 		$('#b').hide();
 		$('#c').hide();
 		$('#d').hide();	
 		$('#k').show();	
 		
 		$('#svca').val('Save');
 		
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

function viewsavedworkout()
{
	var clientid=$('#TraineeId').val();
	 window.location.href="<?php echo $config['url']?>home/exercise_viewsaveworkout/";
}

function myhome()
{
	
	window.location.href="<?php echo $config['url']?>home/";
}

function popupOpenSW(str)
{
	if(str!='')
	{
		//alert('okay');
  popupOpen('popSW');
  $('#goalid_sw').val(str);	
	}
}

function popupOpenRW(str)
{
	if(str!='')
	{
		var website_url ='<?php echo $config['url']?>home/getSavedWorkoutList';
		
		var traineeId = $('#TraineeId').val();
		
		var opt = '';
		
		$.ajax({
   		type: "POST",
   		url: website_url,
   		data: "q="+str+"&traineeId="+traineeId,
		beforeSend: function(){$('.loaderResultFd').show()},
		success: function(e)
			{
				popupOpen('popRW');	
				$('#goalid_RW').val(str);			
				$("#RepeatWorkOutTimeslot").html(e);
			}
		});	
		
		return false;  
	}
}

function popupOpenEW(id)
{
	if(id!='')
	{
		var website_url ='<?php echo $config['url']?>home/getEditWorkoutList';
		
		var traineeId = $('#TraineeId').val();		
		var opt = '';		
		$.ajax({
   		type: "POST",
   		url: website_url,
   		data: "id="+id+"&traineeId="+traineeId,
		//beforeSend: function(){$('.loaderResultFd').show()},
		success: function(e)
			{
				popupOpen('popEW');	
				
				//$( "#popEW" ).draggable();
				
				$("#abc").html(e);
				//$('#goalid_RW').val(str);			
				//$("#RepeatWorkOutTimeslot").html(e);
			}
		});	
		
		return false;	
	}	
}

function searchworkout()
{
	 var rangeA = $("#rangeA").val();
	 var rangeB = $("#rangeB").val();
	 
	 if(rangeA!='' && rangeB!='')
	 {	
		var dt1 = rangeA.split('/');
		var dt2 = rangeB.split('/');		
	 	
		var date1 = dt1[2]+"-"+dt1[0]+"-"+dt1[1];
		var date2 = dt2[2]+"-"+dt2[0]+"-"+dt2[1];
		
	 	var seldate1=new Date();
			 seldate1.setFullYear(dt1[2],dt1[0],dt1[1]);
	
		var seldate2=new Date();
			 seldate2.setFullYear(dt2[2],dt2[0],dt2[1]);
	
	 	var ONE_DAY = 1000 * 60 * 60 * 24
	
		var date1_ms = seldate1.getTime();
		var date2_ms = seldate2.getTime();
		
		if(date2_ms > date1_ms)
		{
			var clientIDa = $("#TraineeId").val();
			var website_url ='<?php echo $config['url']?>home/exercise_history/'+clientIDa+"/"+date1+"/"+date2;			
			
			document.location.href=website_url;
		}
		else
		{
			alert("Please select valid date.");	
		}
		
	 }
	 else
	 {
	 	alert("Please select valid dates.");	
	 }
	 return false;
}


function validatefrmssvwr()
{
	
	 var workoutname1  = $('#workoutname1').val();
	     var workoutcategory1  = $('#workoutcategory1').val();
	  	
	     if(workoutname1!='' && workoutcategory1!='')
	     {
	  	
	  	var website_url ='<?php echo $config['url']?>home/saveworkoutdata';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: $('#svworkt').serialize(),
				beforeSend: function(){$('.loaderResultFd').show()},
				
		   		success: function(e)
					{
						var response = eval(' ( '+e+' ) ');
						$('.loaderResultFd').hide();
						
						if( response.responseclassName == "nSuccess" ) {
						alert(response.errorMsg);
						
						popupClose('popSW');
						//document.location.href=document.location.href;
						
					    }
							else
							{
									alert(response.errorMsg);
								
							}
						
						
					}
				});	
				return false;
	     } else
	     {
	     	alert('Please fill the name and select category.');
	     }
		return false;
}



function validatefrmRW()
{
	
	 var workoutname1  = $("#RepeatWorkOutTimeslot").val();
	 	  	var goalid=$('#goalid_RW').val();
	 if(workoutname1!='' )
	 {
	  	
	  	var website_url ='<?php echo $config['url']?>home/repeatWorkoutData';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: $('#svRW').serialize(),
				beforeSend: function(){$('.loaderResultsw').show()},
				
		   		success: function(e)
					{
						var response = eval(' ( '+e+' ) ');
						$('.loaderResultsw').hide();
						
						if( response.responseclassName == "nSuccess" ) {
						alert(response.errorMsg);
						popupClose('popRW');
						//document.location.href=document.location.href;
						
					    }
							else
							{
									alert(response.errorMsg);
								
							}
						
						
					}
				});	
				return false;
	     } else
	     {
	     	alert('Please select session in which you want to repeat workout.');
	     }
		return false;
}

function validatefrmEW()
{
	var website_url ='<?php echo $config['url']?>home/editWorkoutData';
	$.ajax({
		type: "POST",
		url: website_url,
		data: $('#editRWa').serialize(),
		beforeSend: function(){$('.loaderResultEdw').show()},	
		success: function(e)
		{
			var response = eval(' ( '+e+' ) ');
			if( response.responseclassName == "nSuccess" ) {
				alert(response.errorMsg);
				document.location.href=document.location.href;		
			}
			//alert(e);
			/*var response = eval(' ( '+e+' ) ');
			$('.loaderResultEdw').hide();			
			if( response.responseclassName == "nSuccess" ) {
			alert(response.errorMsg);
			document.location.href=document.location.href;			
		    }
			else
			{
				alert(response.errorMsg);
			}*/
		}
	});	
	
	return false;	
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

.newst{width:112%;}
.newst tr {border:1px solid #000;}
.newst tr th{border:1px solid #000;}
.newst tr td{border:1px solid #000;}

#addexercise{font-size:14px;font-family: 'HelveticaLTCondensedRegular';}

#rangeA{background: url(<?php echo $config['url'];?>images/calender_ico.png) no-repeat scroll 7px 7px #FFF;
padding-left:30px;}
#rangeB{background: url(<?php echo $config['url'];?>images/calender_ico.png) no-repeat scroll 7px 7px #FFF;
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
@media only screen and (max-width: 360px) and (min-width: 320px) {
 
 form{clear:both;}
 
 }

</style>

<section class="contentContainer clearfix">
    <div class="inside-banner changecover-pic">
    <!--<div class="change-coverpic" onclick="popupOpen('pop5');"><img src="<?php echo $config['url'];?>images/pencial_icon.png" /> Change Cover </div>-->
      <div class="row">
        <div class="eight inside-head offset-by-four columns">
          <h2 class="client-name"><?php echo $uname;?></h2>
          <h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['city'].', '.$setSpecalistArr[$utype]['state'];?></h3>
          <p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ if($this->Session->read('USER_ID') && ($this->Session->read('USER_ID')==$setSpecalistArr[$utype]['id'])){ echo $setSpecalistArr[$utype]['userfb_status'];} else {echo $setSpecalistArr[$utype]['userfb_status'];}} ?></p>
        </div>
      </div>
    </div>
    <div class="row">
     <?php //echo $this->element('lefttrainer');?>
      <div class="eight inside-head columns">
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/dumbbell.png"></span>Manage Exercise</a></li>
       
        </ul>    
       
        <ul class="profile-tabs-list mobile-tab clearfix">
         
           <div class="clear">&nbsp;</div>
           
           <?php /*if($showoff==1){*/?>
           <input type="button" name="submit" value="Build a Workout" class="change-pic-nav" onclick="popupOpen3n('popFd');" style="  float: left; height: 36px; margin: 0 0 10px 10px; width: 140px;"/>
           <!-- <input type="button" name="submit" value="Exercise History" class="change-pic-nav" onclick="checkhistory();" style="  float: left; height: 36px; margin: 0 0 10px 10px; width: 140px;"/> -->
            <input type="button" name="submit" value="Saved Workouts" class="change-pic-nav" onclick="viewsavedworkout();" style="  float: left; height: 36px; margin: 0 0 10px 10px; width: 140px;"/>
              <input type="button" name="submit" value="Back to Home" class="change-pic-nav" onclick="myhome();" style="  float: left; height: 36px; margin: 0 0 10px 10px; width: 140px;"/>
		 <?php /*}*/?>
         
 <form accept-charset="utf-8" method="post" id="validcertificationtrainers" class="resform-wrap" enctype="multipart/form-data" controller="home" action="/home/addcertification_trainer/">
		<?php 
		
		?>
		
		
		
		<input type="hidden"  name="data[CertificationTrainers][trainer_id]" id="CertificationTrainers_trainer_id" value="<?php echo $setSpecalistArr[$utype]['id'];?>"/>
		
            <div class="row">
              <div class="four form-select columns">
              
            
              <?php
                         
              echo $this->Form->select('Trainee.id',$tranee,array('empty'=>'-- Select Client --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectid\').value= this.options[this.selectedIndex].text; chngurl(this.value);')); ?>          
                
                <input type="text" id="customSelectid" value="<?php if(isset($clientid) && $clientid!=''){
                foreach($tranee as $key=>$val)
                {
                  if($key==$clientid)
                  {
                  	 echo $val;
                  	 
                  }	
                	
                }
                }else{echo '-- Select Client--';}?>"/>
                
              </div>
              
              <script>
              document.getElementById('TraineeId').value='<?php echo $clientid;?>';
              </script>
              <?php if(isset($clientid) && $clientid!=''){?> 
              <div style="float: right; width: 64%;">
              	<div class="dpckr" style="float: left; width: 41%;">
              		<span style="float:left;padding-right: 5px;padding-top: 9px;"> From :</span>				
					<span style="float:left;"><input type="text" value="<?php echo $rangeA;?>" id="rangeA" readonly="readonly" style="width: 117px;">	</span>
					<div style="clear:both;"></div>
			    </div>
				
			    <div class="dpckr2" style="float: left; width: 34%;">
				
					<span style="float:left;padding-right: 5px;padding-top: 9px;">To :</span>
					<span style="float:left;"><input type="text" style="float: left; width: 117px;" readonly="readonly" id="rangeB" value="<?php echo $rangeB;?>"></span>	
					<div style="clear:both;"></div>
				</div>
				<div style="float: left;"><input type="button" name="submit" value="Search" class="change-pic-nav" onclick="searchworkout();" style="float: left; height: 36px; width: 60px; margin: 0px 0px 10px 10px;"></div>
              
              </div>
              <?php } ?>
            </div>
          <?php if(isset($clientid) && $clientid!=''){?>
           <!--  <div class="dpckr" style="float: left;width: 55%;">

		<input  value="<?php //echo $datva;?>" id="rangeA" type="text" readonly="readonly">	
		</div>-->
		
				
              
            <?php 
if ($this->Paginator->hasPage(2)) {
echo ("<hr>"); 
echo $this->Paginator->prev();
echo (" | ");
} ?> 
<?php //echo $this->Paginator->numbers(); ?> 
<?php 
if ($this->Paginator->hasPage(2)) { 
echo (" | ");
echo $this->Paginator->next();
} ?> 
            
				
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
         
         <table border='1' width='100%' id="a">
				
				<tr class='slectedmn'>
				<td width="100%" colspan='4' class="th2"><h3 style='text-align:left;float:left;'>Client Name:   </h3> <span id="clnamewt" style="float: left; line-height: 32px;  padding: 10px 5px 5px;"></span>
				</td>
					
				
				
				</tr>
				
				
				
				
				
				<tr class='slectedmn'>
			
				<td width="100%" colspan="4"> <span style="line-height:34px;float:left;">Session Availability:</span>
				 <div class="twelve  form-select columns">
             
				
   <?php
               //$sestypeArr=array('I'=>'Individual','C'=>'Associated with Club');
               
               //$sestimeArr=array('15'=>'Basic','30'=>'Group 30','45'=>'Group 45','60'=>'Group 60');
               ?>  
               <?php 
               $dftime='-- Session Availability --';
               
               ?>
               <select id="ScheduleCalendarTimeslot" onchange="document.getElementById('CustomSessiontype').value= this.options[this.selectedIndex].text" class="sltbx" name="sessType">
<option value="">-- Session Availability --</option>
<?php

if(!empty($scheduleCalendars)){
		$vdval='';
		
foreach($scheduleCalendars as $scheduleCalendar)
		{
		
             if(isset($selectedslt) && $selectedslt==$scheduleCalendar['ScheduleCalendar']['id'])
             {
             	$vdval='selected="selected"';
             	$dftime=date('m/d/Y h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['start'])).' - '.date('h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['end']));
             } else {
             	$vdval='';
             }
				echo '<option value="'.$scheduleCalendar['ScheduleCalendar']['id'].'" '.$vdval.'>'.date('m/d/Y h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['start'])).' - '.date('h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['end'])).'</option>';
     
		}     
}
?>
</select>
                    
				<?php  //echo $this->Form->select('ScheduleCalendar.timeslot',$workoutname,array('empty'=>'-- Select Workout --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectClubid1\').value= this.options[this.selectedIndex].text')); ?>
				
				      
			
                <input type="text" id="CustomSessiontype" name="sessTypet" value="<?php echo $dftime;?>"/>
				
                
               
              </div>
				</td>	
				</tr>
				
			</table>
				

			<table border='1' width='100%' id="b">
			<tr class='slectedmn'>
				<td colspan='3' class="th2"><span style="float: left; line-height: 36px;">Goal:</span> <input name="goal" id="goal" value="<?php if(!empty($clientGoal)){ echo $clientGoal['Goal']['goal'];}?>" type="text"   style="width:220px;"/></td><td > <span style="float: left; line-height: 36px;">Phase:</span> <input name="phase" id="phase" value="<?php if(!empty($clientGoal)){ echo $clientGoal['Goal']['phase'];}?>" type="text"   style="width:100px;"/></td>
				
				
				</tr>
			</table>	
			
			<table border='1' width='100%' id="c">
			<tr class='slectedmn'>
				<td  class="th2"><span style="float: left; line-height: 36px;">Note:</span><textarea id="note" name="note" style="width: 94%;"><?php if(!empty($clientGoal)){ echo $clientGoal['Goal']['note'];}?></textarea></td>
				
				
				</tr>
			</table>
			
			<table border='1' width='100%' id="d">
			<tr class='slectedmn'>
				<td  class="th2"><span style="float: left; line-height: 36px;">Alert:</span><textarea id="alert" name="alert" style="width: 94%;" readonly><?php if(!empty($setClientArr)){ echo $setClientArr['Trainee']['alerts'];}?></textarea></td>
				
				
				</tr>
			</table>	
			
			<table border='1' width='100%' id="k">
			<tr class='slectedmn'>
				<td width="60%"><span style="float: left; line-height: 36px;">Name:</span> <input name="workoutname" id="workoutname" value="" type="text"   style="width:220px;"/></td><td > <span style="float: left; line-height: 36px;">Category:</span>  <div class="nine  form-select columns">
             
				
   <?php
               //$sestypeArr=array('I'=>'Individual','C'=>'Associated with Club');
               
               //$sestimeArr=array('15'=>'Basic','30'=>'Group 30','45'=>'Group 45','60'=>'Group 60');
               ?>  
               <?php 
               $dftime2='-- Select Category --';
               
               ?>
               <select id="workoutcategory" onchange="document.getElementById('workoutcategory2').value= this.options[this.selectedIndex].text" class="sltbx" name="workoutcategory">
<option value="">-- Select Category --</option>
<?php

if(!empty($workoutcategory)){
foreach($workoutcategory as $workoutcate)
		{
             
				echo '<option value="'.$workoutcate['WorkoutCategory']['id'].'">'.$workoutcate['WorkoutCategory']['name'].'</option>';
     
		}     
}
?>
</select>
                    
				<?php  //echo $this->Form->select('ScheduleCalendar.timeslot',$workoutname,array('empty'=>'-- Select Workout --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectClubid1\').value= this.options[this.selectedIndex].text')); ?>
				
				      
			
                <input type="text" id="workoutcategory2" name="workoutcategory2" value="<?php echo $dftime2;?>"/>
				
                
               
              </div></td>
				
				
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
                          <input type="submit" value="Send To Calendar" id="svca" name="" class="submit-nav" >
                       </div>
            </div>
      
    </form>
                        
                        
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Exercise History  End -->    
                

                
                

                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
<!-- Exercise History Popup  -->
                <div id="popFdn" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent" style="width:684px;margin-left:-305px;"> <a class="close-nav" onclick="popupClose('popFdn');" id="pop4n" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns"> 
                      
                       <h2>Build a Workout</h2>
                                           
						<table width="100%" border="1">
							<tr class="slectedmn">
								<td class="th2" colspan="3"><span style="float: left; line-height: 36px;"><input type="radio" name="Stype" id="Stype" value="c" onclick="creatework(this.value);"> : Continue With The Selected Client</span> </td><td><span style="float: left; line-height: 36px;"><input type="radio" name="Stype" id="Stype" value="w" onclick="creatework(this.value);"> : Continue Without Selected Client</span></td>			
							</tr>
						</table>                       
                      </div>                    
                    </div>
                  </div>
                </div>
                <!-- Exercise History  End -->   
                
                 <!-- Save Workout Popup Start  -->
                <div id="popSW" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent" style="width:684px;margin-left:-305px;"> <a class="close-nav" onclick="popupClose('popSW');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                       
                        
                        
                        <form id="svworkt" action="" method="POST" onsubmit="return validatefrmssvwr();">
      
        <h2>Save a Workout</h2>
         <div class="loaderResultsw" style="display: none;"><img src="<?php echo $config['url'];?>images/ajax-loader.gif"></div> <div style="color:#ff0000; padding:4px 0 4px 0;" id="notificatin_messw"></div>
        
         <input type="hidden" name="trainee_idsw" id="trainee_idsw" value="<?php if(isset($clientid) && $clientid!=''){ echo $clientid;}?>"/>
         <input type="hidden" name="goalid_sw" id="goalid_sw" value=""/>
         
         
       
            
         
         
      
				

			
			
			<table border='1' width='100%' id="k1">
			<tr class='slectedmn'>
				<td width="60%"><span style="float: left; line-height: 36px;">Name:</span> <input name="workoutname1" id="workoutname1" value="" type="text"   style="width:220px;"/></td><td > <span style="float: left; line-height: 36px;">Category:</span>  <div class="nine  form-select columns">
             
				
   <?php
               //$sestypeArr=array('I'=>'Individual','C'=>'Associated with Club');
               
               //$sestimeArr=array('15'=>'Basic','30'=>'Group 30','45'=>'Group 45','60'=>'Group 60');
               ?>  
               <?php 
               $dftime3='-- Select Category --';
               
               ?>
               <select id="workoutcategory1" onchange="document.getElementById('workoutcategory3').value= this.options[this.selectedIndex].text" class="sltbx" name="workoutcategory1">
<option value="">-- Select Category --</option>
<?php

if(!empty($workoutcategory)){
foreach($workoutcategory as $workoutcate)
		{
             
				echo '<option value="'.$workoutcate['WorkoutCategory']['id'].'">'.$workoutcate['WorkoutCategory']['name'].'</option>';
     
		}     
}
?>
</select>
                    
				<?php  //echo $this->Form->select('ScheduleCalendar.timeslot',$workoutname,array('empty'=>'-- Select Workout --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectClubid1\').value= this.options[this.selectedIndex].text')); ?>
				
				      
			
                <input type="text" id="workoutcategory3" name="workoutcategory3" value="<?php echo $dftime3;?>"/>
				
                
               
              </div></td>
				
				
				</tr>
			</table>	
			
			 
      
    
     
     <div class="twelve already-member columns">
                          <input type="submit" value="Save" id="svcawrt" name="" class="submit-nav" >
                       </div>
            </div>
      
    </form>
                        
                        
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Save Workout Popup  End -->      
                
                
                
                
                
                
                
                
                 <!-- Save Workout Popup Start  -->
                <div id="popRW" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent" style="width:684px;margin-left:-305px;"> <a class="close-nav" onclick="popupClose('popRW');" id="pop5" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                       
                        
                        
     <form id="svRW" action="" method="POST" onsubmit="return validatefrmRW();">      
        <h2>Repeat Workout</h2>
         <div class="loaderResultsw" style="display: none;"><img src="<?php echo $config['url'];?>images/ajax-loader.gif"></div> <div style="color:#ff0000; padding:4px 0 4px 0;" id="notificatin_messRW"></div>
        
         <input type="hidden" name="trainee_idRW" id="trainee_idRW" value="<?php if(isset($clientid) && $clientid!=''){ echo $clientid;}?>"/>
         <input type="hidden" name="goalid_RW" id="goalid_RW" value=""/>
			
			
			<table border='1' width='100%' id="RWid">
			<tr class='slectedmn'>			
				<td width="100%" colspan="4"> <span style="line-height:34px;float:left;">Session Availability:</span>
				 <div class="twelve  form-select columns">
               <?php 
               $dftime88='-- Session Availability --';
               
               ?>
               <select id="RepeatWorkOutTimeslot" onchange="document.getElementById('RepeatWorkOutSessiontype').value= this.options[this.selectedIndex].text" class="sltbx" name="sessTypeRW1">
<option value="">-- Session Availability --</option>
</select>     
			
                <input type="text" id="RepeatWorkOutSessiontype" name="sessTypeRW" value="<?php echo $dftime88;?>"/>
              	 </div>
				</td>	
			</tr>
			</table>	
			
			 
      
    
     
     <div class="twelve already-member columns">
                          <input type="submit" value="Save" id="RepeatWorkoutSave" name="" class="submit-nav" >
                       </div>
            </div>
      
    </form>
                        
                        
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Save Workout Popup  End --> 
                
                
                
                
                
                
                
                
                
                
                
                
<!-- Save Workout Popup Start  -->
                <div id="popEW" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent" style="width:684px;margin-left:-305px;"> <a class="close-nav" onclick="popupClose('popEW');" id="pop6" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                       
                        
                        
     <form id="editRWa" action="" method="POST" onsubmit="return validatefrmEW();">      
        <h2>Edit Workout</h2>
         <div class="loaderResultEdw" style="display: none;"><img src="<?php echo $config['url'];?>images/ajax-loader.gif"></div> <div style="color:#ff0000; padding:4px 0 4px 0;" id="notificatin_messEW"></div>
        
         <input type="hidden" name="trainee_idEW" id="trainee_idEW" value="<?php if(isset($clientid) && $clientid!=''){ echo $clientid;}?>"/>
         <input type="hidden" name="goalid_EW" id="goalid_EW" value=""/>
			
			
			<table border='1' width='100%' id="abc" style="border: medium none;">
				<tr><td id="asbc"></td></tr>
			
			</table>	
			
			 
      
    
     
     <div class="twelve already-member columns">
                          <input type="submit" value="Save" id="EditWorkoutSave" name="" class="submit-nav" >
                       </div>
            </div>
      
    </form>
                        
                        
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Save Workout Popup  End -->                               
                
                
                
                
                
                