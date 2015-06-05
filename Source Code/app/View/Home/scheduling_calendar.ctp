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
<?php 
echo $this->Html->css('front/cupertino/jquery-ui.min');	
echo $this->Html->css('front/fullcalendar/fullcalendar');	
echo $this->Html->css('front/fullcalendar/fullcalendar.print');	
echo $this->Html->script('front/lib/jquery-ui.custom.min');
echo $this->Html->script('front/lib/fullcalendar.min');
echo $this->Html->script('front/datetimecal/jquery-calendar');
echo $this->Html->script('date');
?>
<style>
#calendar_div{z-index:9999999;background:#fff;}
#calendar_clear{float:left;}
#calendar_close{float:right;}
#calendar_links{clear:both;}
#calendar_prev{float:left;}
#calendar_current{float:left;margin-left:30px;}
#calendar_next{float:right;}
#calendar_header{clear: both;}
#calendar_time{clear: both; margin-top: 10px;}
#calendar_control{ background: none repeat scroll 0 0 #CCC; border: 1px solid #000000;height: 20px;}
#calendar_links{ background: none repeat scroll 0 0 #333; border: 1px solid #000000;height: 20px;}
#calendar_newMonth{ float: left;    width: 50%;}
#calendar_newYear{ float: left;    width: 50%;}
#calendar_hour{width: 35%; border:1px solid #000;}
#calendar_minute{width: 35%;border:1px solid #000;}
#calendar_ampm{width: 25%;border:1px solid #000;}
.red .fc-event-inner{background:#ff0000;}
.orange .fc-event-inner{background:#f98b13;}
.green .fc-event-inner{background:#00b35e;}
.blue .fc-event-inner{background:#6f8dfd;}
.gray .fc-event-inner{background:#c3c3c3;}
</style>
<script>
	$(document).ready(function() {
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	$("#startD, #endD,#startD1, #endD1").calendar();
	$('#loaderResult9').hide();
	$('#calendar').fullCalendar({
		theme: true,
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultView: 'agendaWeek',			
		allDaySlot: false,
		allDayDefault:false,
		slotMinutes:30,
		/*minTime: 8,
        maxTime:17,*/
		editable: true,
		events: 
		<?php			
			if(!empty($scheduleCalendars))
			{
				$data=array();
				foreach ($scheduleCalendars as $key=>$val)
				{
					$clsname='red';
					$cdts=date('Y-m-d H:i:s');
					if($val['ScheduleCalendar']['appointment_type']!='')
					{
						if($val['ScheduleCalendar']['appointment_type']=='Booked' && $val['ScheduleCalendar']['mapwrkt']==1)
						{
							$clsname='green';
						}
						if($val['ScheduleCalendar']['appointment_type']=='Booked' && $val['ScheduleCalendar']['mapwrkt']==0)
						{
							$clsname='red';
						}
						if($val['ScheduleCalendar']['appointment_type']=='Completed')
						{
							//$clsname='blue';
							$clsname='gray';
						}
						if($val['ScheduleCalendar']['appointment_type']=='Cancel NC' || $val['ScheduleCalendar']['appointment_type']=='Cancel Charge' || $val['ScheduleCalendar']['appointment_type']=='Cancel')
						{
							//$clsname='red';
							$clsname='gray';
						}
						if($val['ScheduleCalendar']['appointment_type']=='Comp')
						{
							//$clsname='orange';
							$clsname='gray';
						}						
					}					
					/*if($val['ScheduleCalendar']['trainee_id']=='' && $val['ScheduleCalendar']['start']>=$cdts)
					{
						$clsname='orange';
					}
					else{
					  if($val['ScheduleCalendar']['start']>=$cdts && $val['ScheduleCalendar']['trainee_id']!='')
						{
							$clsname='green';
						}
						else 
						{
							$clsname='red';
						}
					}*/
					$data[] = array(
					'id'=>$val['ScheduleCalendar']['id'],
					'title'=>$val['ScheduleCalendar']['appointment_type']." / ".$val['ScheduleCalendar']['title'],
					'start'=>$val['ScheduleCalendar']['start'],
					'end'=>$val['ScheduleCalendar']['end'],
					'className'=>$clsname					
					);
				}				
				echo json_encode($data).',';				
			}else { echo '[],';}
			?>
			eventClick: function(calEvent, jsEvent, view) {
				openavdetail(calEvent.id);
				return false;
			},
			eventDrop: function(calEvent, jsEvent, view) {
				dragsession(calEvent.id,calEvent.start,calEvent.end);
		        return false;
			},
			dayClick: function(date, allDay, jsEvent, view) {
				if(!allDay) {
					// strip time information
					//date = new Date(date.getFullYear(), date.getMonth(), date.getDay());
					setavailbilityslot(date);
				  // alert('Clicked on the slot: ' + date);
				}
				else
				{            	
					//alert('2Clicked on the slot: ' + date);
				}    
			}
	});
	<?php if(isset($setdtsval) && $setdtsval!=''){ ?>
		var str1534='<?php echo $setdtsval;?>';
		var v31=str1534.split("-");
		var v32=parseInt(v31[0]);
		var v33=parseInt(v31[1])-1;
		var v34=parseInt(v31[2]);
		$('#calendar').fullCalendar( 'gotoDate', v32,v33,v34 );
		<?php }?>
	});
	function reDisplayCalender(vcaldata){
		$('#calendar2').html('');
		$('#calendar2').fullCalendar({
			theme: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultView: 'agendaWeek',			
			allDaySlot: true,
			allDayDefault:false,
			slotMinutes:30,
			editable: true,
			events: vcaldata,
			eventClick: function(calEvent, jsEvent, view) {
				openavdetail(calEvent.id);
				return false;
			},
			eventDrop: function(calEvent, jsEvent, view) {
				dragsession(calEvent.id,calEvent.start,calEvent.end);
				return false;
			},
			dayClick: function(date, allDay, jsEvent, view) {
				if(!allDay) {
					// strip time information
					//date = new Date(date.getFullYear(), date.getMonth(), date.getDay());
					setavailbilityslot(date);
				    //alert('Clicked on the slot: ' + date);
				}
				else
				{
					//alert('2Clicked on the slot: ' + date);
				}
           }
		}, 'refresh');
	}
	function reDisplayCalender2(vcaldata){
		$('#calendar2').html('');
		$('#calendar2').fullCalendar({
			theme: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultView: 'agendaWeek',			
			allDaySlot: true,
			allDayDefault:false,
			slotMinutes:30,
			editable: true,
			events: vcaldata,
			eventClick: function(calEvent, jsEvent, view) {
				openavdetail(calEvent.id);
				return false;		
			},
			eventDrop: function(calEvent, jsEvent, view) {
				dragsession(calEvent.id,calEvent.start,calEvent.end);
				return false;
			},
			dayClick: function(date, allDay, jsEvent, view) {
				if(!allDay) {
					// strip time information
					//date = new Date(date.getFullYear(), date.getMonth(), date.getDay());
					setavailbilityslot(date);
				    //alert('Clicked on the slot: ' + date);
            }
            else
            {
				//alert('2Clicked on the slot: ' + date);
            }
           }
		}, 'refresh');
	}
	
function getSestime(str)
{	
	var website_url ='<?php echo $config['url']?>home/getsestime';
	$.ajax({
		type: "POST",
		url: website_url,
		data: "workout="+str,
		success: function(e)
		{
			var response = eval(' ( '+e+' ) ');
			var rst=1;
			if( response.responseclassName == "nSuccess") {
				rst=response.workout;
				return rst;
			}
		}
	});
}
function clientdata(str) 
{
	var selectBox = document.getElementById("GroupId");
	var selectedValue = selectBox.options[selectBox.selectedIndex].value;	
	var clientallid;	
	var website_url ='<?php echo $config['url']?>home/clientdata';
	$.ajax({
		type: "POST",
		url: website_url,
		data: "gdid="+selectedValue,
		async: false,
		dataType:"json",
		beforeSend: function(){$('.loaderResult101').show()},			
		success: function(msg)
		{	
			clientallid = msg;
		}
	});	
	return clientallid;
}
function getgroupclientsworkout(str,seesiontypeid)
{	
	var selectBox = document.getElementById("GroupId");
	var selectedValue = selectBox.options[selectBox.selectedIndex].value;
	//alert(selectedValue);
	var statusclient;
	var website_url ='<?php echo $config['url']?>home/getgroupclientsworkout';
	$.ajax({
		type: "POST",
		url: website_url,
		data: "gdid="+selectedValue+"&sessiontypeid="+seesiontypeid,
		async:false,
		dataType:"json",
		beforeSend: function(){$('.loaderResult101').show()},
		success: function(msg)
		{
			statusclient = msg;
		}
	});
	return statusclient;
}
function setavailbilityslot(str)
{
	var groupsession='';
	var clientid=$('#TraineeId').val();	
	var groupid=$('#GroupId').val();	
	var group_id = clientdata(groupid);		
	/*$.each(group_id, function( index1, value1 ) {
		console.log(value1.GroupMember.client_id);					
	});*/
	var ScheduleCalendarTimeslot2=$('#ScheduleCalendarTimeslot').val();
	var ScheduleCalendarTimeslot;
	var Styd='';
	var website_url2 ='<?php echo $config['url']?>home/getsestime';
	$.ajax({
	type: "POST",
	url: website_url2,
	data: "workout="+ScheduleCalendarTimeslot2,					
	success: function(e)
		{
			var response = eval(' ( '+e+' ) ');
			var ScheduleCalendarTimeslot=1;
			if( response.responseclassName == "nSuccess" && groupid!='') {
				var SessionTypeVal=response.sessiontype;
				var AppointmentType=$('#ScheduleCalendarAppointmentType').val();
				$.each(group_id, function( index1, value1 ) {
					var clientid = value1.GroupMember.client_id;
					if(str!='' && clientid!='' && AppointmentType!='' && ScheduleCalendarTimeslot2!='')	{				
						var mydate = new Date(str);
						var str9 = mydate.toString("yyyy-MM-dd HH:mm");
						var d2 = new Date(str);
						enddt= (d2.getTime() + parseInt(response.workout)*60000);
						var d3 = new Date(enddt);
						var str10 = d3.toString("yyyy-MM-dd HH:mm");
						var d4= new Date(enddt);
						var str15 = d4.toString("yyyy,MM,dd");
						var v21=str15.split(",");
						var v22=parseInt(v21[0]);
						var v23=parseInt(v21[1])-1;
						var v24=parseInt(v21[2]);
						var statusgroupclient = getgroupclientsworkout(groupid,ScheduleCalendarTimeslot2);
						console.log(statusgroupclient);
						if (statusgroupclient!="fail")
						{
							groupsession=1;
							//alert(groupsession);
						}
						else {
							alert('All the Clients in group have not purchased the selected session. Please purchase session for all clients in group.');
						}						
					}
					else { 
						alert('Please Select All fields');	
					}
				});
				if (groupsession==1)
				{
					var mydate = new Date(str);
					var str9 = mydate.toString("yyyy-MM-dd HH:mm");
					var d2 = new Date(str);
					enddt= (d2.getTime() + parseInt(response.workout)*60000);
					var d3 = new Date(enddt);
					var str10 = d3.toString("yyyy-MM-dd HH:mm");
					var d4= new Date(enddt);
					var str15 = d4.toString("yyyy,MM,dd");
					var v21=str15.split(",");
					var v22=parseInt(v21[0]);
					var v23=parseInt(v21[1])-1;
					var v24=parseInt(v21[2]);
					var website_url ='<?php echo $config['url']?>home/setslotgroup';
							$.ajax({
							type: "POST",
							url: website_url,
							data: "slot="+str9+"&endslot="+str10+"&groupid="+groupid+"&apty="+AppointmentType+"&SessionTypeVal="+SessionTypeVal+"&sessiontypeid="+ScheduleCalendarTimeslot2,
							beforeSend: function(){$('.loaderResult101').show()},
							success: function(e)
							{
								var response = eval(' ( '+e+' ) ');
								if( response.responseclassName == "nSuccess" ) {
									$('#calendar').css('display','none');
									$('#calendar2').html('Please wait...');
									reDisplayCalender(response.caldata);
									$('#calendar2').fullCalendar( 'gotoDate', v22,v23,v24 );									
								}
								else
								{									
									alert(response.errorMsg);
										
								}
							}
							});
				}
				else
				{
					alert('Some error!! We are working on this.');	
				}
			}
			else if( response.responseclassName == "nSuccess" && clientid!='')
			{
				var SessionTypeVal=response.sessiontype;
				var AppointmentType=$('#ScheduleCalendarAppointmentType').val();							
					if(str!='' && clientid!='' && AppointmentType!='' && ScheduleCalendarTimeslot2!='')	{				
						var mydate = new Date(str);
						var str9 = mydate.toString("yyyy-MM-dd HH:mm");
						var d2 = new Date(str);
						enddt= (d2.getTime() + parseInt(response.workout)*60000);
						var d3 = new Date(enddt);
						var str10 = d3.toString("yyyy-MM-dd HH:mm");
						var d4= new Date(enddt);
						var str15 = d4.toString("yyyy,MM,dd");
						var v21=str15.split(",");
						var v22=parseInt(v21[0]);
						var v23=parseInt(v21[1])-1;
						var v24=parseInt(v21[2]);
						var website_url ='<?php echo $config['url']?>home/setslot';
						$.ajax({
						type: "POST",
						url: website_url,
						data: "slot="+str9+"&endslot="+str10+"&clientid="+clientid+"&apty="+AppointmentType+"&SessionTypeVal="+SessionTypeVal+"&sessiontypeid="+ScheduleCalendarTimeslot2,
						beforeSend: function(){$('.loaderResult101').show()},
						success: function(e)
						{
							var response = eval(' ( '+e+' ) ');
							if( response.responseclassName == "nSuccess" ) {
								$('#calendar').css('display','none');
								$('#calendar2').html('Please wait...');
								reDisplayCalender(response.caldata);
								$('#calendar2').fullCalendar( 'gotoDate', v22,v23,v24 );
							}
							else
							{
								alert(response.errorMsg);
									
							}
						}
						});	
					}
					else { 
						alert('Please Select All fields');	
					}							
			}
			else {
				alert('Please Select All fields');	
				}
		}
	});
}
</script>

<script>
function printdt(str1,str2,str3)
{
	if((str1!='' && str2!='' && str3!='') || (str1!='' && str2==0 && str3!=''))
	{
		str2=parseInt(str2+1);
		str3=parseInt(str3-100)+2000;
		var str4=str3+'-'+str2+'-'+str1;
	var urlsv='<?php echo $config['url'];?>home/printscheduled/'+str4;
	window.open(urlsv, '_blank');
	}
	
}
function openavdetail(str)
{
	var website_url ='<?php echo $config['url']?>home/evdetail';
	$.ajax({
		type: "POST",
		url: website_url,
		data: "evid="+str,
		beforeSend: function(){$('.loaderResult101').show()},
		success: function(msg)
		{
			$('.loaderResult101').hide();
			$("#evdata").html(msg);
			//window.location.href = window.location.href;
			//$("#notificatin_mes3").html(msg['success']);
		}
	});	
	popupOpen('evdetail');	
}
function dragsession(str,startf1,endf1)
{
	/*var eventTime = $.fullCalendar.formatDate(startf1, "dd, MMMM yyyy @ h:sstt")+" to "+$.fullCalendar.formatDate(endf1, "dd, MMMM yyyy @ h:sstt");
	alert(eventTime);
	alert(str);
	alert(startf1);
	alert(endf1);*/
	var formatstartdatetime = $.fullCalendar.formatDate(startf1, "yyyy-MM-dd H:mm:ss");
	var formatenddatetime = $.fullCalendar.formatDate(endf1, "yyyy-MM-dd H:mm:ss");
	var website_url ='<?php echo $config['url']?>home/dragsession';
	$.ajax({
		type: "POST",
		url: website_url,
		data: "evid="+str+"&newstartdate="+formatstartdatetime+"&newenddate="+formatenddatetime,
		beforeSend: function(){$('.loaderResult101').show()},
		success: function(msg)
		{
			$('.loaderResult101').hide();
			$("#evdata").html(msg);
			//window.location.href = window.location.href;
			//$("#notificatin_mes3").html(msg['success']);
		}
	});		
}
function viewwrkt(tId,sDt,msdate)
{
	//window.location.href = '<?php echo $config['url']?>home/exercise_viewhistory/'+tId+'/'+sDt;
	window.location.href = '<?php echo $config['url']?>home/edit_exercise_history/'+tId+'/'+sDt+'/'+msdate;
}
function viewwrktgroup(tId,sDt,msdate)
{
	window.location.href = '<?php echo $config['url']?>home/edit_exercise_history_group/'+tId+'/'+sDt+'/'+msdate;
}
function buildwrktgroupclientInd(tId,sDt,msdate,cID)
{
	window.location.href = '<?php echo $config['url']?>home/edit_exercise_history_group_client_ind/'+tId+'/'+sDt+'/'+msdate+'/'+cID;
}
function editwrktgroupclientInd(tId,sDt,msdate,cID)
{
	window.location.href = '<?php echo $config['url']?>home/orig_edit_exercise_history_group_client_ind/'+tId+'/'+sDt+'/'+msdate+'/'+cID;
}
function buldwrkts(tId,trd2,msdate1)
{
	window.location.href = '<?php echo $config['url']?>home/exercise_history/'+tId+'/'+trd2+'/date/'+msdate1;
}
function editclientingroup(str)
{

   if(str!='')
   {
   	document.location.href="<?php echo $config['url'];?>home/editclientingroup/"+str;
   	
   }

}
function buldgroupwrkts(tId,trd2,msdate1)
{
	window.location.href = '<?php echo $config['url']?>home/exercise_history_group/'+tId+'/'+trd2+'/date/'+msdate1;
}
function editslot(str)
{
	popupClose('evdetail');
	var website_url ='<?php echo $config['url']?>home/evdetailedit';
	$.ajax({
		type: "POST",
		url: website_url,
		data: "evid="+str,
		beforeSend: function(){$('.loaderResult102').show()},
		success: function(msg)
		{
			$('.loaderResult102').hide();
			$("#editevdata").html(msg);
			//window.location.href = window.location.href;
			//$("#notificatin_mes3").html(msg['success']);
		}
	});	
	popupOpen('editev');
	$( "#editevdata" ).on( "mouseenter", function() {
		$("#startD1, #endD1").calendar();
	});
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
function editstatus(str)
{
	var editsecHtml='<textarea name="userfb_status" id="userfb_statusid"></textarea><input type="button" name="submit" value="Save" onclick="saveedit('+str+');" class="change-pic-nav" style="width:50px;"/><input type="button" name="cancel" class="change-pic-nav" style="width:58px;margin-left:10px;" onclick="canceledit('+str+');" value="Cancel"/>';
	$('#userfb_status').html(editsecHtml);
}
function saveedit(str2)
{
	var sthtml=$('#userfb_statusid').val();
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
function createavail(str)
{	
	popupOpen('popav1');
}
function validavil()
{
	var title  = $('#title').val();
	var description=$('#description').val();
	var startD=$('#startD').val();
	var endD  = $('#endD').val();
	var trainer_id  = $('#trainer_id').val();
	if(title!='' && description!='' && startD!='' && endD!='' && trainer_id!=''){
		var website_url ='<?php echo $config['url']?>home/createavailability';
			$.ajax({
			type: "POST",
			url: website_url,
			data: "user_id="+trainer_id+"&title="+title+"&description="+description+"&startd="+startD+"&endd="+endD,
			beforeSend: function(){$('.loaderResult2').show()},			
			success: function(msg)
				{					
					$('.loaderResult99').hide();
					$("#title").val('');
					$('#description').val('');
					$('#startD').val('');
					$("#endD").val('');					
					$("#notificatin_mes99").html(msg);					
					$('#notificatin_mes99').fadeIn().delay(10000).fadeOut();
					window.location.href = window.location.href;
					//$("#notificatin_mes3").html(msg['success']);					
				}
			});	
	return false;
	}
	else {
		$("#notificatin_mes99").html('Please fill all fields.');
		$('#notificatin_mes99').fadeIn().delay(10000).fadeOut();
	return false;
	}
	
}
function deleteslot(str,tdback)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to delete this appointment."))
		{
			 var website_url ='<?php echo $config['url']?>home/deleteslot';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "evid="+str,
				beforeSend: function(){$('.loaderResult101').show()},				
		   		success: function(msg)
					{					
						$('.loaderResult101').hide();
						$("#evdata").html('');	
						$("#notificatin_mes101").html(msg);
						$('#notificatin_mes101').fadeIn().delay(10000).fadeOut();
						//window.location.href = window.location.href;
						getdetails();
						window.location.href = '<?php echo $config['url']?>home/scheduling_calendar/'+tdback;
						//$("#notificatin_mes3").html(msg['success']);
					}
				});	
		}
	}
}
function getdetails()
{
  	var website_url ='<?php echo $config['url']?>home/getsetslot';
	$.ajax({
	type: "POST",
	url: website_url,
	data: "slot=getData",
	beforeSend: function(){$('.notificatin_mes101').hide()},	
	success: function(e)
		{
			var response = eval(' ( '+e+' ) ');
			if( response.responseclassName == "nSuccess" ) {
				//alert(response.errorMsg);
				//document.location.href=document.location.href;
				$('#calendar').css('display','none');
				$('#calendar2').html('Please wait...');
				reDisplayCalender2(response.caldata);
			}
			else
			{
				alert(response.errorMsg);
			}
		}
	});	
}

function markcompleted(str,tdback,stypeid)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to Mark Completed this appointment."))
		{
			 var website_url ='<?php echo $config['url']?>home/markcompleted';
				$.ajax({
					type: "POST",
					url: website_url,
					data: "completed="+str+"&sessiontypeid="+stypeid,
					beforeSend: function(){$('.loaderResult101').show()},				
					success: function(e)
						{
							var response = eval(' ( '+e+' ) ');
							if( response.responseclassName == "nSuccess" ) {
								alert(response.errorMsg);
								//document.location.href=document.location.href;
								window.location.href = '<?php echo $config['url']?>home/scheduling_calendar/'+tdback;
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



function getclientsessionstatus(gid,sdate,edate,clid,tid)
{	
	var statusclient;
	var website_url ='<?php echo $config['url']?>home/getclientsessionstatus';
	$.ajax({
		type: "POST",
		url: website_url,
		data: "gid="+gid+"&clid="+clid+"&tid="+tid+"&sdate="+sdate+"&edate="+edate,		
		async:false,
		dataType:"json",
		beforeSend: function(){$('.loaderResult101').show()},
		success: function(msg)
		{
			statusclient = msg;
		}
	});
	return statusclient;
}
function markcompletedgroupclient(gid,clid,tid,sesid,stypeid,sdate,edate,start)
{
	var changeschedulerappttype;
	if(sesid!='')
	{
		if(confirm("Are you sure, you want to Mark Completed this appointment."))
		{
			 var website_url ='<?php echo $config['url']?>home/markcompletedgroupclient';
				$.ajax({
					type: "POST",
					url: website_url,			
					data: "gid="+gid+"&clid="+clid+"&tid="+tid+"&sesid="+sesid+"&stypeid="+stypeid+"&sdate="+sdate+"&edate="+edate,
					beforeSend: function(){$('.loaderResult101').show()},				
					success: function(e)
						{
							var currentclientsessionstatus = getclientsessionstatus(gid,sdate,edate,clid,tid);
							console.log(currentclientsessionstatus);
							if (currentclientsessionstatus!="fail")
							{
								changeschedulerappttype=1;								
							}
							if (changeschedulerappttype==1)
							{		
								var website_url ='<?php echo $config['url']?>home/scheduler_calender_for_completed_session';
										$.ajax({
												type: "POST",
												url: website_url,
												data: "gid="+gid+"&clid="+clid+"&tid="+tid+"&sdate="+sdate+"&edate="+edate,		
												async:false,
												dataType:"json",
												beforeSend: function(){$('.loaderResult101').show()},
												success: function(msg)
												{
													statusclient = msg;
												}
											});											
							}				
							var response = eval(' ( '+e+' ) ');
							if( response.responseclassName == "nSuccess" ) {
								alert(response.errorMsg);
								//document.location.href=document.location.href;
								window.location.href = '<?php echo $config['url']?>home/scheduling_calendar/'+start;
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
function markcomp(str,tdback)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to Mark Comp this appointment."))
		{
			 var website_url ='<?php echo $config['url']?>home/markcomp';
				$.ajax({
					type: "POST",
					url: website_url,
					data: "comp="+str,
					beforeSend: function(){$('.loaderResult101').show()},
					success: function(e)
						{
							var response = eval(' ( '+e+' ) ');
							if( response.responseclassName == "nSuccess" ) {
								alert(response.errorMsg);
								//document.location.href=document.location.href;
								window.location.href = '<?php echo $config['url']?>home/scheduling_calendar/'+tdback;
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
function markcompgroup(gid,clid,tid,sesid,stypeid,sdate,edate,start)
{
	if(clid!='')
	{
		if(confirm("Are you sure, you want to Mark Comp this appointment."))
		{
			 var website_url ='<?php echo $config['url']?>home/markcompgroup';
				$.ajax({
					type: "POST",
					url: website_url,
					data: "gid="+gid+"&clid="+clid+"&tid="+tid+"&sesid="+sesid+"&stypeid="+stypeid+"&sdate="+sdate+"&edate="+edate,					
					beforeSend: function(){$('.loaderResult101').show()},
					success: function(e)
						{
							var response = eval(' ( '+e+' ) ');
							if( response.responseclassName == "nSuccess" ) {
								alert(response.errorMsg);
								//document.location.href=document.location.href;
								window.location.href = '<?php echo $config['url']?>home/scheduling_calendar/'+start;
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
function markcancel(str,tdback)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to Mark Cancel this appointment."))
		{
			 var website_url ='<?php echo $config['url']?>home/markcancel';
				$.ajax({
					type: "POST",
					url: website_url,
					data: "cancel="+str,
					beforeSend: function(){$('.loaderResult101').show()},
					success: function(e)
						{
							var response = eval(' ( '+e+' ) ');
							if( response.responseclassName == "nSuccess" ) {
								alert(response.errorMsg);
								//document.location.href=document.location.href;
								window.location.href = '<?php echo $config['url']?>home/scheduling_calendar/'+tdback;						
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
function markcancelgroup(gid,clid,tid,sesid,stypeid,sdate,edate,start)
{
	if(clid!='')
	{
		if(confirm("Are you sure, you want to Mark Cancel this appointment."))
		{
			 var website_url ='<?php echo $config['url']?>home/markcancelgroup';
				$.ajax({
					type: "POST",
					url: website_url,
					data: "gid="+gid+"&clid="+clid+"&tid="+tid+"&sesid="+sesid+"&stypeid="+stypeid+"&sdate="+sdate+"&edate="+edate,
					beforeSend: function(){$('.loaderResult101').show()},
					success: function(e)
						{
							var response = eval(' ( '+e+' ) ');
							if( response.responseclassName == "nSuccess" ) {
								alert(response.errorMsg);
								//document.location.href=document.location.href;
								window.location.href = '<?php echo $config['url']?>home/scheduling_calendar/'+start;						
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
function markcancel2(str,tdback,stypeid)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to Mark Cancel this appointment."))
		{
			 var website_url ='<?php echo $config['url']?>home/markcancel_charged';
				$.ajax({
					type: "POST",
					url: website_url,
					data: "cancel="+str+"&sessiontypeid="+stypeid,
					beforeSend: function(){$('.loaderResult101').show()},
					success: function(e)
					{
						var response = eval(' ( '+e+' ) ');
						if( response.responseclassName == "nSuccess" ) {
							alert(response.errorMsg);
							//document.location.href=document.location.href;
							window.location.href = '<?php echo $config['url']?>home/scheduling_calendar/'+tdback;
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
function markcancel2group(gid,clid,tid,sesid,stypeid,sdate,edate,start)
{	
	if(clid!='')
	{
		if(confirm("Are you sure, you want to Mark Cancel this appointment."))
		{
			 var website_url ='<?php echo $config['url']?>home/markcancel_charged_group';
				$.ajax({
					type: "POST",
					url: website_url,
					data: "gid="+gid+"&clid="+clid+"&tid="+tid+"&sesid="+sesid+"&stypeid="+stypeid+"&sdate="+sdate+"&edate="+edate,
					beforeSend: function(){$('.loaderResult101').show()},
					success: function(e)
					{
						var response = eval(' ( '+e+' ) ');
						if( response.responseclassName == "nSuccess" ) {
							alert(response.errorMsg);
							//document.location.href=document.location.href;
							window.location.href = '<?php echo $config['url']?>home/scheduling_calendar/'+start;
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
function validschcalsrch()
{
	var Cemail  = $('#Cemail').val();
	if(Cemail!='')
	{
		return true;
	}
	else
	{
		alert('Please enter the Client email id.');
	  return false;	
	}
}
function valideditavail()
{
	 var title  = $('#title1').val();
	 var description=$('#description1').val();
	 var startD=$('#startD1').val();
	 var endD  = $('#endD1').val();
	 var trainer_id  = $('#trainer_id1').val();
	 var evid  = $('#evids').val();
	 if(title!='' && description!='' && startD!='' && endD!='' && trainer_id!=''){
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		var website_url ='<?php echo $config['url']?>home/editavailbility';
		$.ajax({
			type: "POST",
			url: website_url,
			data: "user_id="+trainer_id+"&title="+title+"&description="+description+"&startd="+startD+"&endd="+endD+"&evid="+evid,
			beforeSend: function(){$('.loaderResult102').show()},
			success: function(msg)
			{
				$('.loaderResult102').hide();
				$("#title1").val('');
				$('#description1').val('');
				$('#startD1').val('');
				$("#endD1").val('');
				$("#notificatin_mes102").html(msg);
				$('#notificatin_mes102').fadeIn().delay(10000).fadeOut();
				window.location.href = window.location.href;
				//$("#notificatin_mes3").html(msg['success']);
			}
		});	
		return false;
		}
		else {
		$("#notificatin_mes102").html('Please fill all fields.');
		$('#notificatin_mes102').fadeIn().delay(10000).fadeOut();
		return false;
		}
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
function groupdetail(str,stid) 
{
	var selectBox = document.getElementById("GroupId");
	var selectedValue = selectBox.options[selectBox.selectedIndex].value;
	var selectBoxSessiontype = document.getElementById("ScheduleCalendarTimeslot");
	var selectedValueSessiontype = selectBoxSessiontype.options[selectBoxSessiontype.selectedIndex].value;
	//alert(selectedValue);
	//alert(selectedValueSessiontype);
	var website_url ='<?php echo $config['url']?>home/groupdetail';
	$.ajax({
		type: "POST",
		url: website_url,
		data: "gdid="+selectedValue+"&sessionid="+selectedValueSessiontype,
		beforeSend: function(){$('.loaderResult101').show()},
		success: function(msg)
		{
			$('.loaderResult101').hide();
			$("#gddata").html(msg);		
		}
	});
	popupOpen('groupdetail');
}
</script>

<style>
	header{position:inherit;}
	<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
		.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
	<?php }?>
	#calendar table{border:none;}
</style>

<section class="contentContainer clearfix">
	<div class="inside-banner changecover-pic" style="display:none;">   
		<div class="row">
			<div class="eight inside-head offset-by-four columns">
				<h2 class="client-name"><?php echo $uname;?></h2>
				<h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['city'].', '.$setSpecalistArr[$utype]['state'];?></h3>
				<p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ if($this->Session->read('USER_ID') && ($this->Session->read('USER_ID')==$setSpecalistArr[$utype]['id'])){ echo $setSpecalistArr[$utype]['userfb_status'];} else {echo $setSpecalistArr[$utype]['userfb_status'];}} ?></p>
			</div>
		</div>
	</div>
    <div class="row" style="margin-top:100px;">
		<?php //echo $this->element('lefttrainer');?>
		<div class="twelve inside-head columns">
			<ul class="profile-tabs-list desktop-tabs clearfix">
				<li><a href="#Profile" style="background:none repeat scroll 0 0 hsl(152, 26%, 48%);"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/calender_ico.png"></span>Scheduling Calendar</a></li>
				<li><a href="<?php echo $config['url'];?>home/" style="background:none repeat scroll 0 0 hsl(152, 26%, 48%);">Back to Home</a></li>        
			</ul>            
			<ul class="profile-tabs-list mobile-tab clearfix">
				<li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
				<div class="twelve columns profile-change-pictext">
					<div class="clear">&nbsp;</div>
					<!-- <div class="clear" style="float:right;margin:10px;"><input type="button" style="width:150px;" class="change-pic-nav" onclick="createavail(<?php echo $this->Session->read('USER_ID');?>);" value="Create Availability" name="submit"></div>-->
					<div class="clear" style="  border: 1px solid #CCCCCC; border-radius: 8px; float: left; margin-bottom: 5px; padding: 0px 8px 0px 8px; width: 100%;">
					<h2 style="margin-bottom: 2px;margin-top: 2px;">Search</h2>
					<form style="margin-bottom:2px;margin-top:3px;" action="/home/scheduling_calendar/" controller="home" enctype="multipart/form-data" class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validschcalsrch();">
                 <div class="row">
				 
				 
				 <div class="three  form-select columns">
             
				
   <?php
               //$sestypeArr=array('I'=>'Individual','C'=>'Associated with Club');
               
               //$sestimeArr=array('15'=>'Basic','30'=>'Group 30','45'=>'Group 45','60'=>'Group 60');
               ?>  
               <?php 
               $dftime='-- Select Session Type --';
               ?>
               <select id="ScheduleCalendarTimeslot" onchange="document.getElementById('customSelectClubid1').value= this.options[this.selectedIndex].text" class="sltbx" name="data[ScheduleCalendar][timeslot]">
<option value="">-- Select Session Type --</option>
<?php 
if(!empty($workoutname)){
for($i=0;$i<count($workoutname);$i++)
{
	
	?>

<option <?php if(isset($setslot)&&($setslot==$workoutname[$i]['WorkOuts']['id'])) { echo "'selected'='selected'";} ?>  value="<?php echo $workoutname[$i]['WorkOuts']['id'];?>"><?php echo $workoutname[$i]['WorkOuts']['workout_name'];?></option>
<?php }
}?>
</select>
                    
				<?php  //echo $this->Form->select('ScheduleCalendar.timeslot',$workoutname,array('empty'=>'-- Select Workout --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectClubid1\').value= this.options[this.selectedIndex].text')); ?>
				<?php
				for($i=0;$i<count($workoutname);$i++)
					{
				if(isset($setslot)&&($setslot==$workoutname[$i]['WorkOuts']['id']))
				{
					
					$dftime=	$workoutname[$i]['WorkOuts']['workout_name'];
					
				}
					}
					
				 ?>
				      
			
                <input type="text" id="customSelectClubid1" value="<?php echo $dftime;?>"/>
				
                
               
              </div>
				 
				 
				<div class="three form-select columns">
				<select id="GroupId" style="border: 1px solid hsl(0, 0%, 90%); border-radius: 5px;opacity: 1;padding: 9px;"onchange="groupdetail();">
					<option value="">-- Select Group --</option>
					<?php 
					foreach($groupdata as $key=>$val)
					{
					?>

					<option value="<?php echo $key;?>"><?php echo $val?></option>
					<?php }
					?>
				</select>
				</div>	 
				 
				 
              <div class="three form-select columns">
              
            
              <?php
                     
            
                  
              echo $this->Form->select('Trainee.id',$tranee,array('empty'=>'-- Select Client --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectid\').value= this.options[this.selectedIndex].text; chngtextbox(this.value); chngmeasure(this.value);')); ?>          
                
                <input type="text" id="customSelectid" value="<?php if(isset($clid) && $clid!=''){
                foreach($tranee as $key=>$val)
                {
                  if($key==$clid)
                  {
                  	 echo $val;
                  	 
                  }	
                	
                }
                }else{echo '-- Select Client--';}?>"/>
                
              </div>
              
               <div class="three columns">
                <input type="submit" style="  float: left; height: 36px; margin: 0 0 0 10px; width: 70px;" class="change-pic-nav" value="Search" name="submit">
               </div>
            </div>
            
          </form>
            </div>
           
           <div class="clear">
		   <div style="float:left;">Booked <span style="background:#00b35e;width:30px;height:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<div style="float:left;margin-left:10px;">Completed<span style="background:#c3c3c3;width:30px;height:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<div style="float:left;margin-left:10px;">Cancel<span style="background:#c3c3c3;width:30px;height:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<div style="float:left;margin-left:10px;">Comp<span style="background:#c3c3c3;width:30px;height:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>

</div>



<div class="clear">&nbsp;</div>
           <div id='calendar' ></div>
            <div id='calendar2' ></div>
           
           
           
          </div>
       
          
        </ul>      
      </div>
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
  
<!-- Change Pic popup -->
<div id="pop4" class="main-popup">
	<div class="overlaybox common-overlay"></div>
	<div id="thirtydays"  class="register-form-popup common-overlaycontent"> 
		<a class="close-nav" onclick="popupClose('pop4');" id="pop4" href="javascript:void(0);"></a>
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
	<div id="thirtydays" class="register-form-popup common-overlaycontent"> 
		<a class="close-nav" onclick="popupClose('pop5');" id="pop4" href="javascript:void(0);"></a>
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
<!-- Change Cover popup End -->

<!-- Create availbility start popup -->  
<div id="popav1" class="main-popup">
	<div class="overlaybox common-overlay"></div>
		<div id="calavdays" class="register-form-popup common-overlaycontent"> 
			<a class="close-nav" onclick="popupClose('popav1');" id="pop4" href="javascript:void(0);"></a>
			<div class="row register-popup-form">
				<div class="twelve field-pad columns">
					<form action="" controller="home"  class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validavil();">
						<h2>Create Availability</h2>
						<div class="loaderResult99"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div> <div id="notificatin_mes99" style="color:#ff0000; padding:4px 0 4px 0;"></div>
						<input type="text" name="title" id="title" class="validate[required,maxSize[250]]"  value="" placeholder="Title"/>
						<textarea name="description" id="description" placeholder="Description"  class="validate[required,maxSize[500]]"></textarea>
						<div class="row">						
							<input type="text" name="startD" id="startD" class="validate[required,maxSize[200]]" value="" placeholder="Start DATE"/>
							<span>[Ex: 19/03/2014 11:00AM]</span>
							<input type="text" name="endD" id="endD" class="validate[required,maxSize[200]]" value="" placeholder="End DATE"/>
							<span>[Ex: 19/03/2014 12:00PM]</span>
							<input type="hidden" name="trainer_id" id="trainer_id" value="<?php echo $this->Session->read('USER_ID');?>" />
							<div class="row">
								<div class="twelve already-member columns">
									<input type="submit" value="Submit" name="" class="submit-nav">
								</div>   
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
</div>
<!-- Create availbility end popup-->  
                
<!-- Event detail popup start -->  
<div id="evdetail" class="main-popup">
	<div class="overlaybox common-overlay"></div>
		<div id="calavppdays" style="position:fixed;" class="register-form-popup common-overlaycontent"> 
			<a class="close-nav" onclick="popupClose('evdetail');" id="pop4" href="javascript:void(0);"></a>
			<div class="row register-popup-form">
				<div class="twelve field-pad columns">					
					<div class="loaderResult101"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div>
					<div id="notificatin_mes101" style="color:#ff0000; padding:4px 0 4px 0;"></div>
					<div class="row" id="evdata"></div>               
				</div>
			</div>
		</div>
</div>
<!-- Event detail popup end --> 
   
<!--POP UP FOR GROUP DETAIL-->
<div id="groupdetail" class="main-popup">
	<div class="overlaybox common-overlay"></div>
		<div id="calavppdays" style="position:fixed;" class="register-form-popup common-overlaycontent"> 
			<a class="close-nav" onclick="popupClose('groupdetail');" id="pop4" href="javascript:void(0);"></a>
			<div class="row register-popup-form">
				<div class="twelve field-pad columns">
					<h2>Group Details</h2>
					<div class="loaderResult101"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div>
					<div id="notificatin_mes101" style="color:#ff0000; padding:4px 0 4px 0;"></div>
					<div class="row" id="gddata"></div>               
				</div>
			</div>
		</div>
</div>
<!--POP UP FOR GROUP DETAIL-->

<!-- Edit availbility start popup -->  
<div id="editev" class="main-popup">
	<div class="overlaybox common-overlay"></div>
		<div id="calavdays" class="register-form-popup common-overlaycontent">
			<a class="close-nav" onclick="popupClose('editev');" id="pop4" href="javascript:void(0);"></a>
			<div class="row register-popup-form">
				<div class="twelve field-pad columns">
					<form action="" controller="home"  class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return valideditavail();">
						<h2>Edit Availability</h2>
						<div class="loaderResult102"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div> <div id="notificatin_mes102" style="color:#ff0000; padding:4px 0 4px 0;"></div>
						<div id="editevdata"></div>                 
					</form>
				</div>
			</div>
		</div>
</div>
<!-- Edit availbility end popup-->  
                              