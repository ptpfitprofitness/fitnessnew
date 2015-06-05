<?php
/*echo '<pre>';
print_r($calendarData);
echo '</pre>';*/
?>
<style>
.inside-header{position:static;}
.tds th{font-family:'HelveticaLTCondensedRegular';}
.tdborder td,th{border:1px solid;}
</style>

 <div class="twelve already-member columns" > 
 <input type="button" value="Print" name="" class="submit-nav" style="float: right; clear: both; width: 120px; margin-top: -25px; margin-bottom: 5px;" onclick="window.print();">
<table broder=0 width="100%">

<tr>
  <td><b>Client Name:</b> <?php echo $schcaldt['ScheduleCalendar']['title'];?></td>
  <td><b>Date/ Session Time:</b><?php echo date('m/d/Y h:i A',strtotime($schcaldt['ScheduleCalendar']['start'])).' - '.date('h:i A',strtotime($schcaldt['ScheduleCalendar']['end']));?></td>
  <td><b>No. of Sessions / Charged Sessions:</b> <?php echo $clientDatas['Trainee']['no_ses_purchased'];?>/<?php echo $clientDatas['Trainee']['booked_ses'];?></td>
</tr>
<tr>
<td colspan="3"><b>Alerts:</b> <?php if(!empty($clientGoal)){ echo $clientGoal['Goal']['alert'];}?></td>
</tr>
<tr>
<td colspan="3"><b>Notes:</b> <?php if(!empty($clientGoal)){ echo $clientGoal['Goal']['note'];}?></td>
</tr>
<tr>
<td colspan="3"><b>Goal:</b> <?php if(!empty($clientGoal)){ echo $clientGoal['Goal']['goal'];}?></td>
</tr>
</table>

<table border="1" width="100%">
<tr>
  <td>
    <table width="100%" border="1" class="tdborder"><tr>
              <th>Exercise</th>
              <th>Sets</th>
              <th>Reps</th>
              <th>Weight</th>
              <th>Rest</th>
              <th>Coaching Tip/Notes</th>              
           </tr>
           <?php if(count($setCoreBalancePlyometricArr)>0){
					foreach($setCoreBalancePlyometricArr as $corKey=>$corVal){
					?>
					 <tr>
			             <td><?php echo $corVal['CoreBalancePlyometric']['exercise']?></td>
			             <td><?php echo $corVal['CoreBalancePlyometric']['set']?></td>
			             <td><?php echo $corVal['CoreBalancePlyometric']['rep']?></td>
			             <td><?php echo $corVal['CoreBalancePlyometric']['temp']?></td>
			             <td><?php echo $corVal['CoreBalancePlyometric']['rest']?></td>
			             <td><?php echo $corVal['CoreBalancePlyometric']['coaching_tip']?></td>
			         </tr>
				
	        <?php }
           } 
             if(count($setSpeedAgilityQuicknessArr)>0){
					foreach($setSpeedAgilityQuicknessArr as $speedKey=>$speedVal){
					?>
				
					 <tr>
			             <td><?php echo $corVal['SpeedAgilityQuickness']['exercise']?></td>
			             <td><?php echo $corVal['SpeedAgilityQuickness']['set']?></td>
			             <td><?php echo $corVal['SpeedAgilityQuickness']['rep']?></td>
			             <td><?php echo $corVal['SpeedAgilityQuickness']['temp']?></td>
			             <td><?php echo $corVal['SpeedAgilityQuickness']['rest']?></td>
			             <td><?php echo $corVal['SpeedAgilityQuickness']['coaching_tip']?></td>
			         </tr>
				
	        <?php }
           } 
           if(count($setSpeedAgilityQuicknessArr)>0){
					foreach($setSpeedAgilityQuicknessArr as $speedKey=>$speedVal){
					?>
				
					 <tr>
			             <td><?php echo $speedVal['SpeedAgilityQuickness']['exercise']?></td>
			             <td><?php echo $speedVal['SpeedAgilityQuickness']['set']?></td>
			             <td><?php echo $speedVal['SpeedAgilityQuickness']['rep']?></td>
			             <td><?php echo $speedVal['SpeedAgilityQuickness']['temp']?></td>
			             <td><?php echo $speedVal['SpeedAgilityQuickness']['rest']?></td>
			             <td><?php echo $speedVal['SpeedAgilityQuickness']['coaching_tip']?></td>
			         </tr>
				
	        <?php }
           } 
           if(count($setResistenceArr)>0){
					foreach($setResistenceArr as $resisKey=>$resisVal){
           ?>
           <tr>
			             <td><?php echo $resisVal['Resistence']['exercise']?></td>
			             <td><?php echo $resisVal['Resistence']['set']?></td>
			             <td><?php echo $resisVal['Resistence']['rep']?></td>
			             <td><?php echo $resisVal['Resistence']['temp']?></td>
			             <td><?php echo $resisVal['Resistence']['rest']?></td>
			             <td><?php echo $resisVal['Resistence']['coaching_tip']?></td>
			         </tr>
			 <?php 
					}
           }?>        
    </table>
  </td>
    <td>
    <table width="100%" border="1" class="tdborder"><tr>
              <th>Warm UP/Cool Exercise</th>
              <th>Sets</th>
              <th>Duration</th>            
              <th>Coaching Tip/Notes</th>              
           </tr>
           <?php if(count($setWarmupArr)>0){
					foreach($setWarmupArr as $setKey=>$setVal){
					?>
           <tr>
             <td><?php echo $setVal['WarmUps']['exercise']?></td>
             <td><?php echo $setVal['WarmUps']['set']?></td>             
             <td><?php echo $setVal['WarmUps']['duration']?></td>
             <td><?php echo $setVal['WarmUps']['coaching_tip']?></td>
           </tr>
           <?php }
           }
           if(count($setCoolDownArr)>0){
					foreach($setCoolDownArr as $coolKey=>$coolVal){
					?>
           <tr>
             <td><?php echo $coolVal['CoolDown']['exercise'];?></td>
             <td><?php echo $coolVal['CoolDown']['set'];?></td>             
             <td><?php echo $coolVal['CoolDown']['duration'];?></td>
             <td><?php echo $coolVal['CoolDown']['coaching_tip'];?></td>
           </tr>
           <?php }
           }
           ?>
          
           
    </table>
  </td>
</tr>
</table>


</div>
