<?php
/*echo '<pre>';
//print_r($setSpecalistArr);
print_r($trainers);
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



<script>

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
   	document.location.href="<?php echo $config['url'];?>home/editworkout/"+str;
   	
   }

}

function newtrainee()
{
	
	document.location.href="<?php echo $config['url'];?>home/addworkout/";
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
	 $('.loaderResultFd').show();
	 
	 //var range=$('#rangeA').val();
	 
	 
	  var trainer_id  = $('#trainer_id').val();
	  var trainee_id  = $('#trainee_id').val();
	
	  var sessType  = $('#CustomSessiontype').val();	  
	 
	  
	 
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

function validatefrmsfdgroup()
    {
	 $('.loaderResultFd').show();
	 
	 //var range=$('#rangeA').val();
	 
	 
	  var trainer_id  = $('#trainer_id').val();
	  var group_id  = $('#group_id').val();
		
	  var sessType  = $('#CustomSessiontype').val();	  
	 
	 
	 
		if(trainer_id!='' && group_id!='' && sessType!='-- Session Availability --'){
					
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		 var website_url ='<?php echo $config['url']?>home/add_exercise_history_group_from_wrkout';
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

function validatefrmsfdsav()
{
	var website_url ='<?php echo $config['url']?>home/edit_exercise_history_temp';
	$.ajax({
		type: "POST",
		url: website_url,
		data: $('#addexercisesav').serialize(),
		beforeSend: function(){$('.loaderResultFdsav').show()},
	
		success: function(e)
		{
			var response = eval(' ( '+e+' ) ');
			$('.loaderResultFdsav').hide();
			
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

function deleteworkouts(str)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to delete this Session Type ?"))
		{
	         	$.ajax({
				url:"<?php echo $config['url'];?>home/deletworkout/",
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
function backhistory()
{
	document.location.href='<?php echo $config['url'];?>home/exercise_history';
}
function assignwrkt(str)
{	
	popupOpen('popFdns');
	$('#groupidss').val(str);
}
function assignwrktgroup(str)
{
	popupOpen('popFdnsgroup');
	$('#groupidss').val(str);
}
function validaswrkt()
{
	var TraineeId=$('#TraineessId').val();
	var groupId=$('#groupidss').val();
	if(TraineeId!='' && groupId!='' )
	{
		popupClose('popFdns');
		popupOpen('popFdnAs');
			$.ajax({
				url:"<?php echo $config['url'];?>home/savedwrktshow/",
				type:"POST",
				data:{groupid:groupId,clientid:TraineeId},
				success:function(e) {
					var response = e;
					if( response!= "" ) {
						$('#showdata').html(response);
						
					}
					else
					{
							alert(response);
						
					}
				}
		      });
	} else
	{
	 alert('Please select Client');	
	}
}
function validaswrktgroup()
{
	var GroupclientID=$('#GroupId').val();
	var groupId=$('#groupidss').val();	
	if(GroupclientID!='' && groupId!='' )
	{
		popupClose('popFdnsgroup');
		popupOpen('popFdnAs');
			$.ajax({
				url:"<?php echo $config['url'];?>home/savedwrktshowgroup/",
				type:"POST",
				data:{groupid:groupId,groupidwithclient:GroupclientID},
				success:function(e) {
					var response = e;
					if( response!= "" ) {
						$('#showdata').html(response);
						
					}
					else
					{
							alert(response);
						
					}
				}
		      });
	} else
	{
	 alert('Please select Group');	
	}
}

function vwwrkt(str)
{
	
	var groupId=str;
	if(groupId!='' )
	{
		
		popupOpen('popFdnAsVw');
			$.ajax({
				url:"<?php echo $config['url'];?>home/savedwrktview/",
				type:"POST",
				data:{groupid:groupId},
				success:function(e) {
					var response = e;
					if( response!= "" ) {
						$('#showdatav').html(response);
						
					}
					else
					{
							alert(response);
						
					}
				}
		      });
	} else
	{
	 alert('Please select Client');	
	}
}

function deletesvwrkt(str)
{
	var groupId=str;
	if(groupId!='' )
	{
		if(confirm("Are you sure, you want to delete this workout?")) {
		popupOpen('popFdnAsVw');
			$.ajax({
				url:"<?php echo $config['url'];?>home/deletewrktview/",
				type:"POST",
				data:{groupid:groupId},
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
	} else
	{
	 alert('Please select Client');	
	}
}

function chngurl3(id)
{
	window.location.href="<?php echo $config['url']?>home/exercise_viewsaveworkout/"+id;
}

function WC()
{
	window.location.href="<?php echo $config['url']?>home/workout_cate";	
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
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/dumbbell.png"></span>Manage Exercise</a></li>
        
        </ul>    
         <div style="float:right">
                
       
              <input type="button" name="submit" value="Manage Workout Category" class="change-pic-nav" onclick="WC();" style="margin: 10px;  width: 188px;"/>
              
                
       
              
              <input type="button" style="width:145px;" class="change-pic-nav" onclick="backhistory();" value="Back" name="submit">
        </div>
        <div class="twelve form-select columns">
        	<?php
								         
					echo $this->Form->select('Trainee.id',$WorkoutCatenew,array('empty'=>'-- Select Category --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectid\').value= this.options[this.selectedIndex].text; chngurl3(this.value);')); ?>          
								
								<input type="text" id="customSelectid" value="<?php if(isset($wrkid) && $wrkid!=''){
                foreach($WorkoutCatenew as $key=>$val)
                {
                  if($key==$wrkid)
                  {
                  	 echo $val;
                  	 
                  }	
                	
                }
                }else{echo '-- Select Category--';}?>"/>
        </div>
         <script>
              document.getElementById('TraineeId').value='<?php echo $wrkid;?>';
         </script>
        <div class="main-responsive-box"><ul class="listing-box all-headtabs">
          <li class="listing-heading">
            <!--<div class="list-colum first-tabs" style="min-width:50px;">S.No.</div>-->
            <div class="list-colum second-tabs">Workout Name</div>         
            <div class="list-colum third-tabs">Workout Category</div>         
            <div class="list-colum fifth-tabs">Action</div>
          </li>
        </ul>
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
          <?php 
          $cnt=1;
         /* echo '<pre>';
         	print_r($tempwrkt);
         	 echo '</pre>';
          	die();*/
         if(isset($tempwrkt)){
          foreach ($tempwrkt as $tempwrkts)
          {
          
          	
          ?>
            <li>
              <!--<div class="list-colum first-tabs" style="min-width:50px;"><?php //echo $cnt; ?></div>-->
              <div class="list-colum second-tabs"><?php if(!empty($tempwrkts['TempWorkout']['name'])){echo $tempwrkts['TempWorkout']['name']; };  ?></div>	
              						
                <div class="list-colum third-tabs"><?php 
                
                foreach($WorkoutCate as $workoutCates)
                {
                	if($workoutCates['WorkoutCategory']['id']==$tempwrkts['TempWorkout']['category_id'])
                	{
                	   echo $workoutCates['WorkoutCategory']['name'];
                	}
                }
                
                 ?></div>	
                
              <div class="list-colum fifth-tabs"><a href="javascript:void(0);" onclick="assignwrkt('<?php echo $tempwrkts['TempWorkout']['group_id'];?>');">Assign to Client</a> | <a href="javascript:void(0);" onclick="assignwrktgroup('<?php echo $tempwrkts['TempWorkout']['group_id'];?>');">Assign to Group</a> | <a href="javascript:void(0);" onclick="vwwrkt('<?php echo $tempwrkts['TempWorkout']['group_id'];?>');">View Workout</a> | <a href="javascript:void(0);" onclick="deletesvwrkt('<?php echo $tempwrkts['TempWorkout']['group_id'];?>');">Delete Workout</a> <!--| <a href="javascript:void(0);" onclick="viewsvwrkt('<?php echo $tempwrkts['TempWorkout']['group_id'];?>');"><img src="<?php echo $config['url'];?>images/view_list.png"></a>  <a href="javascript:void(0);" onclick="deletesvwrkt(<?php echo $tempwrkts['TempWorkout']['group_id'];?>);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a>--></div>
            </li>
         <?php   $cnt++; ?>
            <?php  }
         }?>
            
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
                 <input type="text" id="username" name="username" value="" placeholder="Username" />
           
              </div>
            </div>
            
           <div class="row">
              <div class="twelve columns">
                <input type="password" name="password" id="password" value="" placeholder="Password" />
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
                <!-- Exercise History Popup  -->
                <div id="popFdns" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent" style="width:684px;margin-left:-305px;"> <a class="close-nav" onclick="popupClose('popFdns');" id="pop4n" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns"> 
                      
                       <h2>Select Client</h2>
                              <div class="row">
								<div class="twelve form-select columns">
								
								
								<?php
								         
								echo $this->Form->select('Traineess.id',$trainee,array('empty'=>'-- Select Client --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectida\').value= this.options[this.selectedIndex].text; chngurl(this.value);')); ?>          
								
								<input type="text" id="customSelectida" value="<?php echo '-- Select Client--';?>"/>
								
								</div>         
						          <div class="row">
					              <div class="twelve columns">
					                 <input type="hidden" name="groupidss" id="groupidss" value=""  />
					              </div>
					               <div class="twelve already-member columns">
					                          <input type="button" value="Submit" name="" class="submit-nav" onclick="validaswrkt();" >
					                       </div>
					            </div>              
                      </div>                    
                    </div>
                  </div>
                </div>
                </div>
                <!-- Exercise History  End -->  

 <!-- Exercise History Popup Group -->
                <div id="popFdnsgroup" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent" style="width:684px;margin-left:-305px;"> <a class="close-nav" onclick="popupClose('popFdnsgroup');" id="pop4n" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns"> 
                      
                       <h2>Select Group</h2>
                              <div class="row">
								<div class="twelve form-select columns">
								
								
								<?php
								         
								echo $this->Form->select('Group.id',$groupclient,array('empty'=>'-- Select Group --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectidagroup\').value= this.options[this.selectedIndex].text; chngurl(this.value);')); ?>          
								
								<input type="text" id="customSelectidagroup" value="<?php echo '-- Select Group--';?>"/>
								
								</div>         
						          <div class="row">
					              <div class="twelve columns">
					                 <input type="hidden" name="groupidss" id="groupidss" value=""  />
					              </div>
					               <div class="twelve already-member columns">
					                          <input type="button" value="Submit" name="" class="submit-nav" onclick="validaswrktgroup();" >
					                       </div>
					            </div>              
                      </div>                    
                    </div>
                  </div>
                </div>
                </div>
                <!-- Exercise History  End --> 

				
                 <!-- Exercise History Popup  -->
                <div id="popFdnAs" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent" style="width:684px;margin-left:-305px;"> <a class="close-nav" onclick="popupClose('popFdnAs');" id="pop4n" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns"> 
                      
                       <h2>Assign Workout</h2>
                       <div id="showdata">
                              
					   </div>             
                      </div>                    
                    </div>
                  </div>
                </div>
                <!-- Exercise History  End -->   
                    <!-- Exercise History Popup  -->
                <div id="popFdnAsVw" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent" style="width:684px;margin-left:-305px;"> <a class="close-nav" onclick="popupClose('popFdnAsVw');" id="pop4n" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns"> 
                      
                       <h2>View Workout</h2>
                       <div id="showdatav">
                              
					   </div>             
                      </div>                    
                    </div>
                  </div>
                </div>
                <!-- Exercise History  End -->            
 <?php echo $this->Html->script('front/js/jquery.slimscroll.min');?>                 

<script type="text/javascript">
$(function(){
$('#testDivNested').slimscroll({ })
});
</script>                
                