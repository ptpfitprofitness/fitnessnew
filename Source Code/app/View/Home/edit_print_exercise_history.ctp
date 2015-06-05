<?php
/*echo '<pre>';
print_r($calendarData);
echo '</pre>';*/
?>
<style>
.tds th{font-family:'HelveticaLTCondensedRegular';}
</style>
<script type="text/javascript">
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
 
function validatefrmEW()
{
	var website_url ='<?php echo $config['url']?>home/printAndSave/';
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
				$('.loaderResultEdw').hide();
				document.location.href='<?php echo $config['url']?>home/print_exercise_history/<?php echo $clid;?>/<?php echo $schid;?>';	
				
				// window.print();	
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
} // onsubmit="return validatefrmEW();" <?php // echo $config['url']?>home/printAndSave/
</script>
<div style="clear: both; margin-top: 150px; margin-left: 150px; width: 70%;">
<form id="editRWa" action="" method="POST" onsubmit="return validatefrmEW();">
      
        <div class="twelve already-member columns"> <h2>Print Workout</h2> 
       
           <input type="submit" value="Print & Save" name="" class="submit-nav" style="float: right; clear: both; width: 120px; margin-top: -25px; margin-bottom: 5px;">
        </div>
        
         <div class="loaderResultEdw" style="display: none;"><img src="<?php echo $config['url'];?>images/ajax-loader.gif"></div> <div style="color:#ff0000; padding:4px 0 4px 0;" id="notificatin_mesFd"></div>
         <input type="hidden" name="trainer_id" id="trainer_id" value="<?php echo $setSpecalistArr[$utype]['id'];?>"/>
         <input type="hidden" name="trainee_idEW" id="trainee_id" value="<?php if(isset($clientid) && $clientid!=''){ echo $clientid;}?>"/>
         <input type="hidden" name="GoalId" id="GoalId" value="<?php if(isset($clientid) && $clientid!=''){ echo $clientGoal['Goal']['id'];}?>"/>
         <input type="hidden" name="added_date" id="added_date" value="<?php echo $datva2;?>"/>
         <input type="hidden" name="changeTime" id="changeTime" value="yes"/>
         <input type="hidden" name="oldTime" id="oldTime" value="<?php echo $schcaldt['ScheduleCalendar']['id'];?>"/>
         
       
            
         <!--table border='1' width='100%'>
				
				<tr class='slectedmn'>
				<td colspan='4' class="th2"><h3 style='text-align:left;float:left;'>PROFESSIONAL'S NAME: </h3> <span id="trsname" style="float: left; line-height: 32px;  padding: 10px 5px 5px;"><?php echo $setSpecalistArr[$utype]['full_name'];?></span>
				
				</td>
				
				</tr>
			</table-->
         
         <table border='1' width='100%'>
				
				<tr class='slectedmn'>
				<td width="100%" colspan='4' class="th2"><h3 style='text-align:left;float:left;'>Client Name:   </h3> <span id="clnamewt" style="float: left; line-height: 32px;  padding: 10px 5px 5px;"><?php echo $schcaldt['ScheduleCalendar']['title'];?></span>
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
               <select id="ScheduleCalendarTimeslot" onchange="document.getElementById('CustomSessiontype').value= this.options[this.selectedIndex].text" class="sltbx" name="sessType" disabled>
<option value="">-- Session Availability --</option>
<option value="<?php echo $schcaldt['ScheduleCalendar']['id'];?>" selected><?php echo $schcaldt['ScheduleCalendar']['start'];?> - <?php echo $schcaldt['ScheduleCalendar']['end'];?></option>
<?php

if(!empty($scheduleCalendars)){
foreach($scheduleCalendars as $scheduleCalendar)
		{
             
				echo '<option value="'.$scheduleCalendar['ScheduleCalendar']['id'].'">'.date('m/d/Y h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['start'])).' - '.date('h:i A',strtotime($scheduleCalendar['ScheduleCalendar']['end'])).'</option>';
     
		}     
}
?>
</select>
                    
				<?php  //echo $this->Form->select('ScheduleCalendar.timeslot',$workoutname,array('empty'=>'-- Select Workout --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectClubid1\').value= this.options[this.selectedIndex].text')); ?>
				
				      
			
                <input type="text" id="CustomSessiontype" name="sessTypet" value="<?php echo date('m/d/Y h:i A',strtotime($schcaldt['ScheduleCalendar']['start'])).' - '.date('h:i A',strtotime($schcaldt['ScheduleCalendar']['end']));?>"/>
                <!--<input type="text" id="CustomSessiontype" name="sessTypet" value="<?php //echo $schcaldt['ScheduleCalendar']['start'];?> - <?php //echo $schcaldt['ScheduleCalendar']['end'];?>"/>-->
				
                
               
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
				<td  class="th2"><span style="float: left; line-height: 36px;">Alert:</span><textarea id="alert" name="alert" style="width: 94%;" readonly><?php if(!empty($clientGoal)){ echo $clientGoal['Goal']['alert'];}?></textarea></td>
				
				
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
				<?php if(count($setWarmupArr)>0){
					foreach($setWarmupArr as $setKey=>$setVal){
					?>
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplayexercise[]" value="<?php echo $setVal['WarmUps']['exercise']?>" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplayset[]" id="set" value="<?php echo $setVal['WarmUps']['set']?>" placeholder="Sets" /></td>
		     <td><input type="text" name="nplayduration[]" id="duration" value="<?php echo $setVal['WarmUps']['duration']?>" placeholder="Duration" /></td>
		     <td><input type="text" name="nplaycoaching_tip[]" id="coaching_tip" value="<?php echo $setVal['WarmUps']['coaching_tip']?>" placeholder="Coaching Tip" /></td>
		     <td></td>
		     
		     
		     <!--<td id="responce"></td>-->
		     </tr>
		     <?php } }?>

    
	     
	    
	     
     
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
				<?php if(count($setCoreBalancePlyometricArr)>0){
					foreach($setCoreBalancePlyometricArr as $corKey=>$corVal){
					?>
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplay1exercise[]" value="<?php echo $corVal['CoreBalancePlyometric']['exercise']?>" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplay1set[]" id="set" value="<?php echo $corVal['CoreBalancePlyometric']['set']?>" placeholder="Sets" /></td>
		     <td><input type="text" name="nplay1rep[]" id="rep" value="<?php echo $corVal['CoreBalancePlyometric']['rep']?>" placeholder="Reps" /></td>
		     <td><input type="text" name="nplay1temp[]" id="temp" value="<?php echo $corVal['CoreBalancePlyometric']['temp']?>" placeholder="Weight" /></td>
		     <td><input type="text" name="nplay1rest[]" id="rest" value="<?php echo $corVal['CoreBalancePlyometric']['rest']?>" placeholder="Rest" /></td>
		     <td><input type="text" name="nplay1coaching_tip[]" id="coaching_tip" value="<?php echo $corVal['CoreBalancePlyometric']['coaching_tip']?>" placeholder="Coaching Tip" /></td>
             <td></td>		    
		          
	     
	     </tr>
	     <?php }} ?>
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
				<?php if(count($setSpeedAgilityQuicknessArr)>0){
					foreach($setSpeedAgilityQuicknessArr as $speedKey=>$speedVal){
					?>
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplay2exercise[]" value="<?php echo $speedVal['SpeedAgilityQuickness']['exercise']?>" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplay2set[]" id="set" value="<?php echo $speedVal['SpeedAgilityQuickness']['set']?>" placeholder="Sets" /></td>
		     <td><input type="text" name="nplay2rep[]" id="rep" value="<?php echo $speedVal['SpeedAgilityQuickness']['rep']?>" placeholder="Reps" /></td>
		     <td><input type="text" name="nplay2temp[]" id="temp" value="<?php echo $speedVal['SpeedAgilityQuickness']['temp']?>" placeholder="Weight" /></td>
		     <td><input type="text" name="nplay2rest[]" id="rest" value="<?php echo $speedVal['SpeedAgilityQuickness']['rest']?>" placeholder="Rest" /></td>
		     <td><input type="text" name="nplay2coaching_tip[]" id="coaching_tip" value="<?php echo $speedVal['SpeedAgilityQuickness']['coaching_tip']?>" placeholder="Coaching Tip" /></td>
		     <td></td>
	     
	     </tr><?php }}?>
	    
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
				<?php if(count($setResistenceArr)>0){
					foreach($setResistenceArr as $resisKey=>$resisVal){
					?>
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplay3exercise[]" value="<?php echo $resisVal['Resistence']['exercise'];?>" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplay3set[]" id="set" value="<?php echo $resisVal['Resistence']['set'];?>" placeholder="Sets" /></td>
		     <td><input type="text" name="nplay3rep[]" id="rep" value="<?php echo $resisVal['Resistence']['rep'];?>" placeholder="Reps" /></td>
		     <td><input type="text" name="nplay3temp[]" id="temp" value="<?php echo $resisVal['Resistence']['temp'];?>" placeholder="Weight" /></td>
		     <td><input type="text" name="nplay3rest[]" id="rest" value="<?php echo $resisVal['Resistence']['rest'];?>" placeholder="Rest" /></td>
		     <td><input type="text" name="nplay3coaching_tip[]" id="coaching_tip" value="<?php echo $resisVal['Resistence']['coaching_tip'];?>" placeholder="Coaching Tip" /></td>
		     <td></td>
		          
	     
	     </tr><?php }}?>
	     
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
				<?php if(count($setCoolDownArr)>0){
					foreach($setCoolDownArr as $coolKey=>$coolVal){
					?>
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplay4exercise[]" value="<?php echo $coolVal['CoolDown']['exercise'];?>" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplay4set[]" id="set" value="<?php echo $coolVal['CoolDown']['set'];?>" placeholder="Sets" /></td>
		     <td><input type="text" name="nplay4duration[]" id="duration" value="<?php echo $coolVal['CoolDown']['duration'];?>" placeholder="Duration" /></td>
		     <td><input type="text" name="nplay4coaching_tip[]" id="coaching_tip" value="<?php echo $coolVal['CoolDown']['coaching_tip'];?>" placeholder="Coaching Tip" /></td>
		     <td></td>
		          
	     
	     </tr><?php }}?>
	   
     
     </table>  
     <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id='addButton4' onclick="addNPlay4('cd');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 
	      </div> 
     
     
            </div>
      
    </form></div>