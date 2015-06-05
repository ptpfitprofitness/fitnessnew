<script type="text/javascript">


function viewclientdetailsonpop(gid,gname,sdate,edate,stype,stypeid,clname,clid,scid,mapwrkt)
{	
			 var website_url ='<?php echo $config['url']?>home/viewclientdetailsonpop';
				$.ajax({
					type: "POST",
					url: website_url,
					data: "groupid="+gid+"&groupname="+gname+"&sdate="+sdate+"&edate="+edate+"&sessiontype="+stype+"&sessiontypeid="+stypeid+"&clientname="+clname+"&clientid="+clid+"&scid="+scid+"&mapwrkt="+mapwrkt,
					beforeSend: function(){$('.loaderResult101').show()},				
					success: function(msg)
						{
							$('.loaderResult101').hide();
							$("#clientdata").html(msg);
							//window.location.href = window.location.href;
							//$("#notificatin_mes3").html(msg['success']);
							//$("#dateA").val(sdate);
							//$("#oncId").attr('onclick', 'markcompleted('+sdate+','+stype+','+sessiontypeid)');
						}
				});	
				popupOpen('viewclientdetailsonpop');
		
	
}


</script>
<style type="text/css">
.change-pic-nav-button-grey{background: none repeat scroll 0 0 hsl(0, 0%, 73%);
    border-radius: 3px;
    color: hsl(0, 0%, 100%);
    font-family: Georgia,"Times New Roman",Times,serif;
    font-size: 12px;
    font-style: italic;
    font-weight: bold;
    margin-top: 9px;
    padding: 7px 0;
    text-align: center;
    width: 100%;}
.change-pic-nav-button-compl{background: #0000FF;
    border-radius: 3px;
    color: hsl(0, 0%, 100%);
    font-family: Georgia,"Times New Roman",Times,serif;
    font-size: 12px;
    font-style: italic;
    font-weight: bold;
    margin-top: 9px;
    padding: 7px 0;
    text-align: center;
    width: 100%;}
.change-pic-nav-button-cancel-charge{background:#ff0000;);
    border-radius: 3px;
    color: hsl(0, 0%, 100%);
    font-family: Georgia,"Times New Roman",Times,serif;
    font-size: 12px;
    font-style: italic;
    font-weight: bold;
    margin-top: 9px;
    padding: 7px 0;
    text-align: center;
    width: 100%;}
.change-pic-nav-button-cancel-nc{background: #ffa500;);
    border-radius: 3px;
    color: hsl(0, 0%, 100%);
    font-family: Georgia,"Times New Roman",Times,serif;
    font-size: 12px;
    font-style: italic;
    font-weight: bold;
    margin-top: 9px;
    padding: 7px 0;
    text-align: center;
    width: 100%;}
</style>
<?php
//echo "<pre>"; print_r($scheduleCalendars); echo "</pre>";

if(!empty($scheduleCalendars))
{
		
		/*echo '<pre>';
		print_r($scheduleCalendars);
		echo '</pre>';*/
		$logo=$config['url'].'images/avtar.png';
		foreach($scheduleCalendars as $key=>$val)
		{	
			if($val['posted_by'] =='Group')
			{
				echo '<h2>Detail for '.$groupmemData['GroupMember']['group_name'].'</h2>';
			}
			else
			{
				echo '<h2>Detail</h2>';
			}
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
			if($val['posted_by'] =='Group')
			{
				echo ' <b>Group Id : </b> <span>'.$scheduleCalendars['ScheduleCalendar']['trainee_id'].'</span><br/><br/>';
				
				echo ' <b>Group Name : </b> <span>'.$groupmemData['GroupMember']['group_name'].'</span><br/><br/>';
								
			}
			echo ' <b>Session Type : </b> <span>'.$val['session_type'].'</span><br/><br/>';			
			if($val['trainee_id']!='' && $dbusertype=='Trainer' && $val['posted_by'] !='Group')
			{
				$trainedtval=$trainedt['Trainee']['first_name'].' '.$trainedt['Trainee']['last_name'];
				echo ' <b>Client Name : </b> <span>'.$trainedtval.'</span><br/><br/>';
			}
			/*else if($val['trainee_id']!='' && $dbusertype=='Trainer' && $val['posted_by'] =='Group')
			{
				echo '<b>Clients in Group : </b><br />';
				$i = 1;
					
				foreach ($groupmemDataAll as $keys2 => $value2) 
				{
					$chkd='';
					if (in_array($keys2, $groupmemDataAll)){
						$chkd="checked";}
			
				echo '<label>';				
					
				echo $this->Form->text('GroupMember.group_clients][', array('type'=>'checkbox','value'=>$value2['GroupMember']['client_id']));
				echo ' <b>Client '.$i.' : </b>';
				echo $value2['GroupMember']['client_name'];
				echo '</label>';
				$i++;
				}
				echo '<br />';
			}*/
			else if($val['trainee_id']!='' && $dbusertype=='Trainer' && $val['posted_by'] =='Group')
			{
				echo '<b>Clients in Group : </b><br />';
				$i = 1;
				
				/*echo '<pre>';
				print_r($GroupclientstatArr);
				echo '</pre>';
				*/
				$vrs=array();
				$vrs_cancel_charge=array();
				if(!empty($GroupclientstatArr))
				{
				    foreach($GroupclientstatArr as $keyd=>$vdval)
					{					
					  if($vdval['GroupClientStat']['session_status']=='Completed')
					  {
					     $vrs[]=$vdval['GroupClientStat']['client_id'];
					  }
					  else if($vdval['GroupClientStat']['session_status']=='Cancel Charge')
					  {
					     $vrs_cancel_charge[]=$vdval['GroupClientStat']['client_id'];
					  }
					  else if($vdval['GroupClientStat']['session_status']=='Cancel NC')
					  {
					     $vrs_cancel_nc[]=$vdval['GroupClientStat']['client_id'];
					  }
					  else if($vdval['GroupClientStat']['session_status']=='Comp')
					  {
					     $vrs_compl[]=$vdval['GroupClientStat']['client_id'];
					  }
					  
					}
				}
				
				foreach($groupmemDataAll as $gmdAll)
				{	
				$a = 1;

					if($a==1)
						{
						  if(in_array($gmdAll['GroupMember']['client_id'],$vrs))
						  {
						    	echo "<input type=\"button\" name=\"submit\" onclick=\"viewclientdetailsonpop('".$scheduleCalendars['ScheduleCalendar']['trainee_id']."','".$groupmemData['GroupMember']['group_name']."','".date('m/d/Y h:i:s A', strtotime($val['start']))."','".date('m/d/Y h:i:s A', strtotime($val['end']))."','".$val['session_type']."','".$val['session_typeid']."','".$gmdAll['GroupMember']['client_name']."','".$gmdAll['GroupMember']['client_id']."','".$scheduleCalendars['ScheduleCalendar']['id']."','".$val['mapwrkt']."');\" class=\"change-pic-nav-button-grey\"  style=\"width:100px; margin:5px 0 0 5px;\" value='".$gmdAll['GroupMember']['client_name']."'>";
						  }
						else if(in_array($gmdAll['GroupMember']['client_id'],$vrs_cancel_charge))
						  {
						    	echo "<input type=\"button\" name=\"submit\" onclick=\"viewclientdetailsonpop('".$scheduleCalendars['ScheduleCalendar']['trainee_id']."','".$groupmemData['GroupMember']['group_name']."','".date('m/d/Y h:i:s A', strtotime($val['start']))."','".date('m/d/Y h:i:s A', strtotime($val['end']))."','".$val['session_type']."','".$val['session_typeid']."','".$gmdAll['GroupMember']['client_name']."','".$gmdAll['GroupMember']['client_id']."','".$scheduleCalendars['ScheduleCalendar']['id']."','".$val['mapwrkt']."');\" class=\"change-pic-nav-button-cancel-charge\"  style=\"width:100px; margin:5px 0 0 5px;\" value='".$gmdAll['GroupMember']['client_name']."'>";
						  }
						  else if(in_array($gmdAll['GroupMember']['client_id'],$vrs_cancel_nc))
						  {
						    	echo "<input type=\"button\" name=\"submit\" onclick=\"viewclientdetailsonpop('".$scheduleCalendars['ScheduleCalendar']['trainee_id']."','".$groupmemData['GroupMember']['group_name']."','".date('m/d/Y h:i:s A', strtotime($val['start']))."','".date('m/d/Y h:i:s A', strtotime($val['end']))."','".$val['session_type']."','".$val['session_typeid']."','".$gmdAll['GroupMember']['client_name']."','".$gmdAll['GroupMember']['client_id']."','".$scheduleCalendars['ScheduleCalendar']['id']."','".$val['mapwrkt']."');\" class=\"change-pic-nav-button-cancel-nc\"  style=\"width:100px; margin:5px 0 0 5px;\" value='".$gmdAll['GroupMember']['client_name']."'>";
						  }
						  else if(in_array($gmdAll['GroupMember']['client_id'],$vrs_compl))
						  {
						    	echo "<input type=\"button\" name=\"submit\" onclick=\"viewclientdetailsonpop('".$scheduleCalendars['ScheduleCalendar']['trainee_id']."','".$groupmemData['GroupMember']['group_name']."','".date('m/d/Y h:i:s A', strtotime($val['start']))."','".date('m/d/Y h:i:s A', strtotime($val['end']))."','".$val['session_type']."','".$val['session_typeid']."','".$gmdAll['GroupMember']['client_name']."','".$gmdAll['GroupMember']['client_id']."','".$scheduleCalendars['ScheduleCalendar']['id']."','".$val['mapwrkt']."');\" class=\"change-pic-nav-button-compl\"  style=\"width:100px; margin:5px 0 0 5px;\" value='".$gmdAll['GroupMember']['client_name']."'>";
						  }
						  
						  else
						  {
						    	echo "<input type=\"button\" name=\"submit\" onclick=\"viewclientdetailsonpop('".$scheduleCalendars['ScheduleCalendar']['trainee_id']."','".$groupmemData['GroupMember']['group_name']."','".date('m/d/Y h:i:s A', strtotime($val['start']))."','".date('m/d/Y h:i:s A', strtotime($val['end']))."','".$val['session_type']."','".$val['session_typeid']."','".$gmdAll['GroupMember']['client_name']."','".$gmdAll['GroupMember']['client_id']."','".$scheduleCalendars['ScheduleCalendar']['id']."','".$val['mapwrkt']."');\" class=\"change-pic-nav-button\"  style=\"width:100px; margin:5px 0 0 5px;\" value='".$gmdAll['GroupMember']['client_name']."'>";
						  }
						  
						} 
						else{
					
					echo "<input type=\"button\" name=\"submit\" onclick=\"viewclientdetailsonpop('".$scheduleCalendars['ScheduleCalendar']['trainee_id']."','".$groupmemData['GroupMember']['group_name']."','".date('m/d/Y h:i:s A', strtotime($val['start']))."','".date('m/d/Y h:i:s A', strtotime($val['end']))."','".$val['session_type']."','".$val['session_typeid']."','".$gmdAll['GroupMember']['client_name']."','".$gmdAll['GroupMember']['client_id']."','".$scheduleCalendars['ScheduleCalendar']['id']."','".$val['mapwrkt']."');\" class=\"change-pic-nav-button\"  style=\"width:100px; margin:5px 0 0 5px;\" value='".$gmdAll['GroupMember']['client_name']."'>";
					}
					$i++;
				}
				echo '<br />';
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
			
			
			if($val['posted_by'] !='Group')
			{
			//echo ' <b>Session Type : </b> <span>'.$val['appointment_type'].'</span><br/><br/>';			
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
			}
			echo '<br />';
			

			echo '<b>Date and time : </b><br/> <span>  '.date('m/d/Y h:i:s A', strtotime($val['start'])).' to '.date('h:i:s A', strtotime($val['end'])).' </span><br/><br/>';
			
			
			if($dbusertype=='Trainer' && $val['posted_by'] =='Group')
			{
			$gidf = base64_encode($scheduleCalendars['ScheduleCalendar']['trainee_id']);
			
			echo "<input type=\"button\" name=\"submit\" value=\"Add a Client to this Group\" onclick=\"editclientingroup('$gidf');\" class=\"change-pic-nav-button\" style=\"width:185px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			
			
			//echo '<b>No. of session / Charged session : </b>'.$trainedt['Trainee']['no_ses_purchased'].' / '.$trainedt['Trainee']['booked_ses'].'<br/><br/>';
			if($sessionPurchase['SessionPurchase']['no_of_booked']=='')
			{
				$sessionPurchase['SessionPurchase']['no_of_booked'] = 0;
			}
			/*echo $sessionPurchase['SessionPurchase']['no_of_booked'];*/
			if($val['posted_by'] !='Group')
			{
			echo '<b>Sessions Purchased / Sessions Used : </b>'.$sessionPurchase['SessionPurchase']['no_of_purchase'].' / '.$sessionPurchase['SessionPurchase']['no_of_booked'].'<br/><br/>';
			}
			$cdts=date('Y-m-d H:i:s');
               if($dbusertype!='Trainer' && $val['start']>$cdts)
				{    
					//echo '<input type="button" name="submit" value="Book Appointment" onclick="bookappointment('.$val['id'].');" class="change-pic-nav" style="width:150px;">';
				}
				if($dbusertype=='Trainer')
				{
					if($val['posted_by'] !='Group')
					{
					
						if($val['appointment_type']!='Completed' && $val['appointment_type']!='Cancel Charge' && $val['appointment_type']!='Cancel')
						{									
							echo "<input type=\"button\" name=\"submit\" value=\"Completed\" onclick=\"markcompleted('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."','".$sessionPurchase['SessionPurchase']['id']."');\" class=\"change-pic-nav-button\" style=\"width:121px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
						}
										
						echo "<input type=\"button\" name=\"submit\" value=\"Complimentary\" onclick=\"markcomp('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."');\" class=\"change-pic-nav-button\" style=\"width:116px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
						
						echo "<input type=\"button\" name=\"submit\" value=\"Cancel No Charge\" onclick=\"markcancel('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."','".$sessionPurchase['SessionPurchase']['id']."');\" class=\"change-pic-nav-button\" style=\"width:121px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
						if($val['appointment_type']!='Completed' && $val['appointment_type']!='Cancel Charge' && $val['appointment_type']!='Cancel')
						{
							
							echo "<input type=\"button\" name=\"submit\" value=\"Cancel Charged\" onclick=\"markcancel2('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."');\" class=\"change-pic-nav-button\" style=\"width:116px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
						}
					}
						echo "<input type=\"button\" name=\"submit\" value=\"Deleted\" onclick=\"deleteslot('".$val['id']."','".date('Y-m-d', strtotime($val['start']))."');\" class=\"change-pic-nav-button\" style=\"width:120px;\">";
						
						if($val['mapwrkt']==0 && $val['posted_by'] !='Group')
					     {
						    echo "<input type=\"button\" name=\"submit\" value=\"Build a Workout\" onclick=\"buldwrkts('".$scheduleCalendars['ScheduleCalendar']['trainee_id']."','".$scheduleCalendars['ScheduleCalendar']['id']."','".date('Y-m-d',strtotime($scheduleCalendars['ScheduleCalendar']['start']))."');\"   class=\"change-pic-nav-button\" style=\"width:120px;margin-left:10px;\">";
					     }
						 
						 if($val['mapwrkt']==0 && $val['posted_by'] =='Group')
					     {
						    echo "<input type=\"button\" name=\"submit\" value=\"Build a Group Workout\" onclick=\"buldgroupwrkts('".$scheduleCalendars['ScheduleCalendar']['trainee_id']."','".$scheduleCalendars['ScheduleCalendar']['id']."','".date('Y-m-d',strtotime($scheduleCalendars['ScheduleCalendar']['start']))."');\"   class=\"change-pic-nav-button\" style=\"width:156px;margin-left:8px;\">";
							
							
							
					     }
					     
					     if($val['mapwrkt']==1 && $val['posted_by'] !='Group')
					     {
					     	//echo "<input type=\"button\" name=\"submit\" value=\"View Workout\" onclick=\"viewwrkt('".$trainedt['Trainee']['id']."','".$scheduleCalendars['ScheduleCalendar']['id']."');\" class=\"change-pic-nav-button\" style=\"width:120px;margin-left:10px;\">";
					     	echo "<input type=\"button\" name=\"submit\" value=\"View Workout\" onclick=\"viewwrkt('".$trainedt['Trainee']['id']."','".$scheduleCalendars['ScheduleCalendar']['id']."','".date('Y-m-d', strtotime($val['start']))."');\" class=\"change-pic-nav-button\" style=\"width:120px;margin-left:10px;\">";
					     }
						 if($val['mapwrkt']==1 && $val['posted_by'] =='Group')
					     {					  
					     	echo "<input type=\"button\" name=\"submit\" value=\"View Group Workout\" onclick=\"viewwrktgroup('".$scheduleCalendars['ScheduleCalendar']['trainee_id']."','".$scheduleCalendars['ScheduleCalendar']['id']."','".date('Y-m-d', strtotime($val['start']))."');\" class=\"change-pic-nav-button\" style=\"width:150px;margin-left:10px;\">";
					     }
				     		     
					
				
			} 
                            echo'  </div>';
		}
	
}
?>
<!-- Event detail popup start -->  
<div id="viewclientdetailsonpop" class="main-popup">
	<div class="overlaybox common-overlay"></div>
		<div id="calavppdays" style="position:fixed;" class="register-form-popup common-overlaycontent"> 
			<a class="close-nav" onclick="popupClose('viewclientdetailsonpop');" id="pop4" href="javascript:void(0);"></a>
			<div class="row register-popup-form">
				<div class="twelve field-pad columns">					
					<div class="loaderResult101"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div>
					<div id="notificatin_mes101" style="color:#ff0000; padding:4px 0 4px 0;"></div>
					<div class="row" id="clientdata"></div>               
				</div>
			</div>
		</div>
</div>
<!-- Event detail popup end --> 

