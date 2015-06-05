<?php
echo "<pre>";print_r($scheduleCalendars1);echo "</pre>";
echo "<pre>";print_r($scheduleCalendars);echo "</pre>";
if(!empty($scheduleCalendars))
{
	
		/*echo '<pre>';
		print_r($scheduleCalendars);
		echo '</pre>';*/
		$logo=$config['url'].'images/avtar.png';
		foreach($scheduleCalendars as $key=>$val)
		{
						
			echo ' <div style="width:20%;float:left"><div class="profile-pic9" style="border:1px solid #ccc;">';
			if($val['trainee_id']!='' && $dbusertype=='Trainer')
			{
				if($trainedt['Trainee']['photo']!='')
				{
				echo '<img width="75" height="75" src="'.$config['url'].'uploads/'.$trainedt['Trainee']['photo'].'" style="border:3px solid #fff;">';
				}
				else 
				{
					echo '<img width="75" height="75" src="'.$logo.'" style="border:3px solid #fff;">';
				}
			}
			else {
				if($dbusertype!='Trainer')
				{
				if($trainerdt['Trainer']['logo']!='')
				{
				echo '<img width="75" height="75" src="'.$config['url'].'uploads/'.$trainerdt['Trainer']['logo'].'" style="border:3px solid #fff;">';
				}
				else 
				{
					echo '<img width="75" height="75" src="'.$logo.'" style="border:3px solid #fff;">';
				}
				}
				else 
				{
					echo '<img width="75" height="75" src="'.$logo.'" style="border:3px solid #fff;">';
				}
				
			}
			echo '</div></div>
                              <div style="width:78%;float:left;margin-left:6px;">
                               
                                ';
			if($val['trainee_id']!='' && $dbusertype=='Trainer')
			{
				$trainedtval=$trainedt['Trainee']['first_name'].' '.$trainedt['Trainee']['last_name'];
				echo ' <b>Client Name : </b> <span>'.$trainedtval.'</span><br/><br/>';
			}
			else {
				if($dbusertype!='Trainer')
				{
				$trainerdtval=$trainerdt['Trainer']['first_name'].' '.$trainedt['Trainer']['last_name'];
				echo ' <b>Trainer Name : </b> <span>'.$trainerdtval.'</span><br/><br/>';
				}
				else {
					echo ' <b>Available Booking Slot  </b> <br/><br/>';
				}
			}
                    
			//echo ' <b>Session Type : </b> <span>'.$val['appointment_type'].'</span><br/><br/>';   
			echo ' <b>Session Type : </b> <span>'.$val['session_type'].'</span><br/><br/>';
			echo ' <b>Completed Session : </b>'; 
			if ($popupschedetail['ScdetailPopup']['completed']==''){echo 0;} else {echo $popupschedetail['ScdetailPopup']['completed'] ;}
			echo '<br />';
			echo ' <b>Complementary Session : </b>';
			if ($popupschedetail['ScdetailPopup']['complimentary']==''){echo 0;} else {echo $popupschedetail['ScdetailPopup']['complimentary'] ;}			
			echo '<br />';
			echo ' <b>Cancel Session : </b>';
			if ($popupschedetail['ScdetailPopup']['cancel']==''){echo 0;} else {echo $popupschedetail['ScdetailPopup']['cancel'] ;}
			echo '<br />';
			echo ' <b>Cancel No Charge Session : </b>';
			if ($popupschedetail['ScdetailPopup']['cancel_no_charge']==''){echo 0;} else {echo $popupschedetail['ScdetailPopup']['cancel_no_charge'] ;}
			echo '<br /><br />';
			
			
			

			echo '<b>Date and time : </b><br/> <span>  '.date('m/d/Y h:i:s A', strtotime($val['start'])).' to '.date('h:i:s A', strtotime($val['end'])).' </span><br/><br/>';
			//echo '<b>No. of session / Charged session : </b>'.$trainedt['Trainee']['no_ses_purchased'].' / '.$trainedt['Trainee']['booked_ses'].'<br/><br/>';
			if($sessionPurchase['SessionPurchase']['no_of_booked']=='')
			{
				$sessionPurchase['SessionPurchase']['no_of_booked'] = 0;
			}
			/*echo $sessionPurchase['SessionPurchase']['no_of_booked'];*/
			echo '<b>Sessions Purchased / Sessions Used : </b>'.$sessionPurchase['SessionPurchase']['no_of_purchase'].' / '.$sessionPurchase['SessionPurchase']['no_of_booked'].'<br/><br/>';
			$cdts=date('Y-m-d H:i:s');
               if($dbusertype!='Trainer' && $val['start']>$cdts)
				{    
					//echo '<input type="button" name="submit" value="Book Appointment" onclick="bookappointment('.$val['id'].');" class="change-pic-nav" style="width:150px;">';
				}
				if($dbusertype=='Trainer')
				{
					if($val['appointment_type']!='Completed' && $val['appointment_type']!='Cancel Charge' && $val['appointment_type']!='Cancel')
					{
						//echo '<input type="button" name="submit" value="Completed" onclick="markcompleted('.$val['id'].');" class="change-pic-nav-button" style="width:121px;">&nbsp;&nbsp;&nbsp;&nbsp;';
						
						echo "<input type=\"button\" name=\"submit\" value=\"Completed\" onclick=\"markcompleted('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."','".$sessionPurchase['SessionPurchase']['id']."');\" class=\"change-pic-nav-button\" style=\"width:121px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
					}
					
					
					echo "<input type=\"button\" name=\"submit\" value=\"Complimentary\" onclick=\"markcomp('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."');\" class=\"change-pic-nav-button\" style=\"width:116px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
					
					echo "<input type=\"button\" name=\"submit\" value=\"Cancel No Charge\" onclick=\"markcancel('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."','".$sessionPurchase['SessionPurchase']['id']."');\" class=\"change-pic-nav-button\" style=\"width:121px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
					if($val['appointment_type']!='Completed' && $val['appointment_type']!='Cancel Charge' && $val['appointment_type']!='Cancel')
					{
						
						echo "<input type=\"button\" name=\"submit\" value=\"Cancel Charged\" onclick=\"markcancel2('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."');\" class=\"change-pic-nav-button\" style=\"width:116px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
					}
//					echo '<input type="button" name="submit" value="Edit Slot" onclick="editslot('.$val['id'].');" class="change-pic-nav" style="width:100px;">&nbsp;&nbsp;&nbsp;&nbsp;';
					//echo '<input type="button" name="submit" value="Deleted" onclick="deleteslot('.$val['id'].','.date('Y-m-d', strtotime($val['start'])).');" class="change-pic-nav-button" style="width:120px;">';
					
					echo "<input type=\"button\" name=\"submit\" value=\"Deleted\" onclick=\"deleteslot('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."');\" class=\"change-pic-nav-button\" style=\"width:120px;\">";
					
					if($val['mapwrkt']==0)
				     {
					    echo "<input type=\"button\" name=\"submit\" value=\"Build a Workout\" onclick=\"buldwrkts('".$scheduleCalendars['ScheduleCalendar']['trainee_id']."','".$scheduleCalendars['ScheduleCalendar']['id']."','".date('Y-m-d',strtotime($scheduleCalendars['ScheduleCalendar']['start']))."');\"   class=\"change-pic-nav-button\" style=\"width:120px;margin-left:10px;\">";
						
						
						
				     }
				     
				     if($val['mapwrkt']==1)
				     {
				     	//echo "<input type=\"button\" name=\"submit\" value=\"View Workout\" onclick=\"viewwrkt('".$trainedt['Trainee']['id']."','".$scheduleCalendars['ScheduleCalendar']['id']."');\" class=\"change-pic-nav-button\" style=\"width:120px;margin-left:10px;\">";
				     	echo "<input type=\"button\" name=\"submit\" value=\"View Workout\" onclick=\"viewwrkt('".$trainedt['Trainee']['id']."','".$scheduleCalendars['ScheduleCalendar']['id']."','".date('Y-m-d', strtotime($val['start']))."');\" class=\"change-pic-nav-button\" style=\"width:120px;margin-left:10px;\">";
				     }
				     		     
					
				}   
                            echo'  </div>';
		}
	
}
else if(!empty($scheduleCalendars1))
{
	
		/*echo '<pre>';
		print_r($scheduleCalendars);
		echo '</pre>';*/
		$logo=$config['url'].'images/avtar.png';
		foreach($scheduleCalendars1 as $key=>$val)
		{
						
			echo ' <div style="width:20%;float:left"><div class="profile-pic9" style="border:1px solid #ccc;">';
			if($val['trainee_id']!='' && $dbusertype=='Trainer')
			{
				if($trainedt1['Trainee']['photo']!='')
				{
				echo '<img width="75" height="75" src="'.$config['url'].'uploads/'.$trainedt1['Trainee']['photo'].'" style="border:3px solid #fff;">';
				}
				else 
				{
					echo '<img width="75" height="75" src="'.$logo.'" style="border:3px solid #fff;">';
				}
			}
			else {
				if($dbusertype!='Trainer')
				{
				if($trainerdt1['Trainer']['logo']!='')
				{
				echo '<img width="75" height="75" src="'.$config['url'].'uploads/'.$trainerdt1['Trainer']['logo'].'" style="border:3px solid #fff;">';
				}
				else 
				{
					echo '<img width="75" height="75" src="'.$logo.'" style="border:3px solid #fff;">';
				}
				}
				else 
				{
					echo '<img width="75" height="75" src="'.$logo.'" style="border:3px solid #fff;">';
				}
				
			}
			echo '</div></div>
                              <div style="width:78%;float:left;margin-left:6px;">
                               
                                ';
			if($val['trainee_id']!='' && $dbusertype=='Trainer')
			{
				$trainedtval=$trainedt['Trainee']['first_name'].' '.$trainedt['Trainee']['last_name'];
				echo ' <b>Client Name : </b> <span>'.$trainedtval.'</span><br/><br/>';
			}
			else {
				if($dbusertype!='Trainer')
				{
				$trainerdtval=$trainerdt['Trainer']['first_name'].' '.$trainedt['Trainer']['last_name'];
				echo ' <b>Trainer Name : </b> <span>'.$trainerdtval.'</span><br/><br/>';
				}
				else {
					echo ' <b>Available Booking Slot  </b> <br/><br/>';
				}
			}
                    
			//echo ' <b>Session Type : </b> <span>'.$val['appointment_type'].'</span><br/><br/>';   
			echo ' <b>Session Type : </b> <span>'.$val['session_type'].'</span><br/><br/>';
			echo ' <b>Completed Session : </b>'; 
			if ($popupschedetail['ScdetailPopup']['completed']==''){echo 0;} else {echo $popupschedetail['ScdetailPopup']['completed'] ;}
			echo '<br />';
			echo ' <b>Complementary Session : </b>';
			if ($popupschedetail['ScdetailPopup']['complimentary']==''){echo 0;} else {echo $popupschedetail['ScdetailPopup']['complimentary'] ;}			
			echo '<br />';
			echo ' <b>Cancel Session : </b>';
			if ($popupschedetail['ScdetailPopup']['cancel']==''){echo 0;} else {echo $popupschedetail['ScdetailPopup']['cancel'] ;}
			echo '<br />';
			echo ' <b>Cancel No Charge Session : </b>';
			if ($popupschedetail['ScdetailPopup']['cancel_no_charge']==''){echo 0;} else {echo $popupschedetail['ScdetailPopup']['cancel_no_charge'] ;}
			echo '<br /><br />';
			
			
			

			echo '<b>Date and time : </b><br/> <span>  '.date('m/d/Y h:i:s A', strtotime($val['start'])).' to '.date('h:i:s A', strtotime($val['end'])).' </span><br/><br/>';
			//echo '<b>No. of session / Charged session : </b>'.$trainedt['Trainee']['no_ses_purchased'].' / '.$trainedt['Trainee']['booked_ses'].'<br/><br/>';
			if($sessionPurchase['SessionPurchase']['no_of_booked']=='')
			{
				$sessionPurchase['SessionPurchase']['no_of_booked'] = 0;
			}
			/*echo $sessionPurchase['SessionPurchase']['no_of_booked'];*/
			echo '<b>Sessions Purchased / Sessions Used : </b>'.$sessionPurchase['SessionPurchase']['no_of_purchase'].' / '.$sessionPurchase['SessionPurchase']['no_of_booked'].'<br/><br/>';
			$cdts=date('Y-m-d H:i:s');
               if($dbusertype!='Trainer' && $val['start']>$cdts)
				{    
					//echo '<input type="button" name="submit" value="Book Appointment" onclick="bookappointment('.$val['id'].');" class="change-pic-nav" style="width:150px;">';
				}
				if($dbusertype=='Trainer')
				{
					if($val['appointment_type']!='Completed' && $val['appointment_type']!='Cancel Charge' && $val['appointment_type']!='Cancel')
					{
						//echo '<input type="button" name="submit" value="Completed" onclick="markcompleted('.$val['id'].');" class="change-pic-nav-button" style="width:121px;">&nbsp;&nbsp;&nbsp;&nbsp;';
						
						echo "<input type=\"button\" name=\"submit\" value=\"Completed\" onclick=\"markcompleted('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."','".$sessionPurchase['SessionPurchase']['id']."');\" class=\"change-pic-nav-button\" style=\"width:121px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
					}
					
					
					echo "<input type=\"button\" name=\"submit\" value=\"Complimentary\" onclick=\"markcomp('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."');\" class=\"change-pic-nav-button\" style=\"width:116px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
					
					echo "<input type=\"button\" name=\"submit\" value=\"Cancel No Charge\" onclick=\"markcancel('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."','".$sessionPurchase['SessionPurchase']['id']."');\" class=\"change-pic-nav-button\" style=\"width:121px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
					if($val['appointment_type']!='Completed' && $val['appointment_type']!='Cancel Charge' && $val['appointment_type']!='Cancel')
					{
						
						echo "<input type=\"button\" name=\"submit\" value=\"Cancel Charged\" onclick=\"markcancel2('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."');\" class=\"change-pic-nav-button\" style=\"width:116px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
					}
//					echo '<input type="button" name="submit" value="Edit Slot" onclick="editslot('.$val['id'].');" class="change-pic-nav" style="width:100px;">&nbsp;&nbsp;&nbsp;&nbsp;';
					//echo '<input type="button" name="submit" value="Deleted" onclick="deleteslot('.$val['id'].','.date('Y-m-d', strtotime($val['start'])).');" class="change-pic-nav-button" style="width:120px;">';
					
					echo "<input type=\"button\" name=\"submit\" value=\"Deleted\" onclick=\"deleteslot('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."');\" class=\"change-pic-nav-button\" style=\"width:120px;\">";
					
					if($val['mapwrkt']==0)
				     {
					    echo "<input type=\"button\" name=\"submit\" value=\"Build a Workout\" onclick=\"buldwrkts('".$scheduleCalendars1['ScheduleCalendar']['trainee_id']."','".$scheduleCalendars1['ScheduleCalendar']['id']."','".date('Y-m-d',strtotime($scheduleCalendars1['ScheduleCalendar']['start']))."');\"   class=\"change-pic-nav-button\" style=\"width:120px;margin-left:10px;\">";
						
						
						
				     }
				     
				     if($val['mapwrkt']==1)
				     {
				     	//echo "<input type=\"button\" name=\"submit\" value=\"View Workout\" onclick=\"viewwrkt('".$trainedt['Trainee']['id']."','".$scheduleCalendars['ScheduleCalendar']['id']."');\" class=\"change-pic-nav-button\" style=\"width:120px;margin-left:10px;\">";
				     	echo "<input type=\"button\" name=\"submit\" value=\"View Workout\" onclick=\"viewwrkt('".$trainedt['Trainee']['id']."','".$scheduleCalendars1['ScheduleCalendar']['id']."','".date('Y-m-d', strtotime($val['start']))."');\" class=\"change-pic-nav-button\" style=\"width:120px;margin-left:10px;\">";
				     }
				     		     
					
				}   
                            echo'  </div>';
		}
	
}
?>

