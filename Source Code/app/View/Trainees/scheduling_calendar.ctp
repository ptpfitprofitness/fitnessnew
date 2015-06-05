<?php
//echo '<pre>';
//print_r($setSpecalistArr);
//print_r($scheduleCalendars);
//echo '</pre>';
//die();

//echo"<pre>";print_r($mainData);echo"</pre>";

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
	//echo $this->Html->css('front/datetimecal/jquery-calendar');	
		
	//echo $this->Html->script('front/lib/jquery.min');
	echo $this->Html->script('front/lib/jquery-ui.custom.min');
	echo $this->Html->script('front/lib/fullcalendarcl.min');
	echo $this->Html->script('front/datetimecal/jquery-calendar');
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
			editable: false,
			events: 
			 <?php
			
			if(!empty($mainData))
			{
				$data=array();
				foreach ($mainData as $key=>$val)
				{
					$clsname='red';
					$cdts=date('Y-m-d H:i:s');
					
					if($val['ScheduleCalendar']['appointment_type']!='')
					{
						if($val['ScheduleCalendar']['appointment_type']=='Booked')
						{
							$clsname='green';
						}
						if($val['ScheduleCalendar']['appointment_type']=='Completed')
						{
							//$clsname='blue';
							$clsname='gray';
						}
						if($val['ScheduleCalendar']['appointment_type']=='Cancel')
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
					$data[] = array(
					'id'=>$val['ScheduleCalendar']['id'],
					'title'=>$val['ScheduleCalendar']['title'],
					'start'=>$val['ScheduleCalendar']['start'],
					'end'=>$val['ScheduleCalendar']['end'],
					'postedby'=>$val['ScheduleCalendar']['posted_by'],			
					'className'=>$clsname	
					
					);
					
				}
				
				echo json_encode($data);
				
			}else { echo '[]';} 
			
			?>
			,
			eventClick: function(calEvent, jsEvent, view) {
            openavdetail(calEvent.id,calEvent.postedby);

            return false;
        }
		});
		
	});

</script>


<script>
function printdt(str1,str2,str3)
{
	if(str1!='' && str2!='' && str3!='')
	{
		str2=parseInt(str2+1);
		str3=parseInt(str3-100)+2000;
		var str4=str3+'-'+str2+'-'+str1;
	var urlsv='<?php echo $config['url'];?>home/printscheduled/'+str4;
	window.open(urlsv, '_blank');
	}
	
}
function openavdetail(str,postedby)
{
console.log(postedby);
	 var website_url ='<?php echo $config['url']?>home/evdetail';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "evid="+str+"&postedby="+postedby,
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
		
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
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
</script>
<style>
<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
#calendar table{border:none;}
</style>
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
      <div class="eight inside-head columns">
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/calender_ico.png"></span>Scheduling Calendar</a></li>
        
        </ul>    
        
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
          <div class="twelve columns profile-change-pictext">
           <div class="clear">&nbsp;</div>
           <div class="clear" style="float:right;margin:10px;"></div>
           
           
           
           <div class="clear"><div style="float:left;">Booked <span style="background:#00b35e;width:30px;height:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<div style="float:left;margin-left:10px;">Completed<span style="background:#c3c3c3;width:30px;height:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<div style="float:left;margin-left:10px;">Cancel<span style="background:#c3c3c3;width:30px;height:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<div style="float:left;margin-left:10px;">Comp<span style="background:#c3c3c3;width:30px;height:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
</div>

<div class="clear">&nbsp;</div>
           <div id='calendar' ></div>
           
           
           
          </div>
       
          
        </ul>      
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
                <!-- Create availbility start popup -->  
              
                <div id="popav1" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="calavdays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popav1');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="" controller="home"  class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return validavil();">
                          <h2>Create Availability</h2>
                            <div class="loaderResult99"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div> <div id="notificatin_mes99" style="color:#ff0000; padding:4px 0 4px 0;"></div>
                          <input type="text" name="title" id="title" class="validate[required,maxSize[250]]"  value="" placeholder="Title"/>
                          <textarea name="description" id="description" placeholder="Description"  class="validate[required,maxSize[500]]"></textarea>
                          <div class="row">
                         <!-- <div class="six columns">
					          <input type="text" name="startD" id="startD" value="" placeholder="Start DATE"/>
                          <input type="text" name="endD" id="endD" value="" placeholder="End DATE"/>
					          </div>
       </div>-->
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
                        </form>
                      </div>
                     
                    </div>
                  </div>
                </div>
                </div>
                <!-- Create availbility end popup-->  
                
                    <!-- Event detail popup start -->  
              
                <div id="evdetail" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="calavppdays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('evdetail');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                       
                          <!--<h2>Detail</h2>-->
                           <div class="loaderResult101"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div>
                           <div id="notificatin_mes101" style="color:#ff0000; padding:4px 0 4px 0;"></div>
                          <div class="row" id="evdata">
                              
                         
                           </div>               
                      
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Event detail popup end -->    
                
                 <!-- Edit availbility start popup -->  
              
                <div id="editev" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="calavdays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('editev');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="" controller="home"  class="resform-wrap" id="valid" method="post" accept-charset="utf-8" onsubmit="return valideditavail();">
                          <h2>Edit Availability</h2>
                            <div class="loaderResult102"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div> <div id="notificatin_mes102" style="color:#ff0000; padding:4px 0 4px 0;"></div>
                            <div id="editevdata">
                         
                         </div>                 
                        </form>
                      </div>
                     
                    </div>
                  </div>
                </div>
                </div>
                <!-- Edit availbility end popup-->  
                              