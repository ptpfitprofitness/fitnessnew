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



<script>
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


function doadd(str)
{
	 var goalv=$('#goal').val();
	if(str!='' && goalv!='')
	{
	 $.post("<?php echo $config['url'];?>home/addgoal", {trainee_id: str,goal:goalv}, function(data)
	 {
	 	
	 	var response = eval(' ( '+data+' ) ');
					
						
						if( response.responseclassName == "nSuccess" ) {
						alert('Goal has been set for selected user.');
						
					    }
							else
							{
									alert('Sorry, please try again some issue occur!!');
								
							}
	 
	 });
	}
	else
	{
	  alert('Please set Goal.');	
	}
}

function doedit(str)
{
	 var goalv=$('#goal').val();
	if(str!='' && goalv!='')
	{
	 $.post("<?php echo $config['url'];?>home/editgoal", {id: str,goal:goalv}, function(data)
	 {
	 	
	 	var response = eval(' ( '+data+' ) ');
					
						
						if( response.responseclassName == "nSuccess" ) {
						alert('Goal has been set for selected user.');
						
					    }
							else
							{
									alert('Sorry, please try again some issue occur!!');
								
							}
	 
	 });
	}
	else
	{
	  alert('Please set Goal.');	
	}
}




function chngtextbox(str)
{
	
	
//alert(str);
$('.loaderResultFd').show();

var website_url ='<?php echo $config['url']?>trainees/listtraineegoal';
	$.ajax({
				type:"POST",
				url: website_url,
				data: "trainee_id="+str,
				dataType: "json",
				success:function(data){						
					$("#target_container").html(data);							
					if(data.goal!=null)
					{
					  $("#resData").html('<div class="six columns"><div id="target_container"><input type="text" name="goal" value="'+data.goal+'" id="goal" placeholder="Goal" class="validate[required] text-input"/></div></div><div class="six columns"><a href="javascript:void(0);" onclick="doedit('+data.id+')" style="height: 35px; margin-top: 0; padding-top: 10px; width: 85px;" class="change-pic-nav">Edit</a></div>');
					}
					else
					{
						$("#resData").html('<div class="six columns"><div id="target_container"><input type="text" name="goal" value="" id="goal" placeholder="Goal" class="validate[required] text-input"/></div></div><div class="six columns"><a  href="javascript:void(0);" onclick="doadd('+data.trainee_id+')"  style="height: 35px; margin-top: 0; padding-top: 10px; width: 85px;" class="change-pic-nav">Add</a></div>');
					}	
					
						
				}
			});


if(str!='')
{
	 


$("#adms").css('display','block');
$("#adms1").css('display','block');
}
else{

	
	$("#adms").css('display','none');
	$("#adms1").css('display','none');

}
}

function chngmeasure(str)
{
	
	
//alert(str);
$('.loaderResultFd').show();

var website_url ='<?php echo $config['url']?>trainees/listtraineemeasurement';
	$.ajax({
				type:"POST",
				url: website_url,
				data: "trainee_id="+str,
				//dataType: "json",
				success:function(data){						
					$("#target_container2").html(data);							
					
					//alert(data);
					
						
				}
			});

}

function addmessrmt()
{
	popupOpen('popAdMes');
	var clientid=$('#TraineeId').val();
	//alert(clientid);
	$('#cuser_id').val(clientid);
	
}

function viewmessrmt()
{
	popupOpen('popviewMes');
	var clientid=$('#TraineeId').val();
	//alert(clientid);
	$('#cuser_id').val(clientid);
	
}

function chng(str)
{
	if(str=='Male')
	{
		$('#forfemale').css('display','none');
		$('#formale').css('display','block');
	}
	else
	{
		$('#formale').css('display','none');
		$('#forfemale').css('display','block');
	}
	
}

function viewdetail(str,str1)
{
	//alert(str+"--"+str1);
	 window.open('<?php echo $config['url'].'trainees/clientmesdetail/';?>'+str+'/'+str1, "popupWindow", "scrollbars=yes");
	 
	 
}

function deletetrainer(str,str1,str2)
{
	if(str!='' && str1!='' && str2!='')
	{
		if(confirm("Are you sure, you want to delete this Client?"))
		{
	         	$.ajax({
				url:"<?php echo $config['url'];?>trainees/deletemeasurement/",
				type:"POST",
				data:{id:str,id2:str1,id3:str2},
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

 

function vaildateMeasurement()
{
	//alert('ok');
	
	var gender=$('#gender').val();
	var age=$('#age').val();
	
	var weight=$('#weight').val();
	var height=$('#height').val();
	var chestm=$('#chestm').val();
	var chestf=$('#chestf').val();
	var abdominalm=$('#abdominalm').val();
	var abdominalf=$('#abdominalf').val();
	var thighm=$('#thighm').val();
	var thighf=$('#thighf').val();
	var tricepsm=$('#tricepsm').val();
	var tricepsf=$('#tricepsf').val();
	var subscapularism=$('#subscapularism').val();
	var subscapularisf=$('#subscapularisf').val();
	var illiaccrestm=$('#illiaccrestm').val();
	var illiaccrestf=$('#illiaccrestf').val();
	var midaxillarym=$('#midaxillarym').val();
	var midaxillaryf=$('#midaxillaryf').val();
	var suprailiacf=$('#suprailiacf').val();
	var cuser_id2=$('#cuser_id').val();
	
	var flag=0;
	
	if(gender=='Male')
	{
		if(trimString(age)=='' || trimString(weight)=='' || trimString(height)=='' || trimString(chestm)=='' || trimString(abdominalm)==''  || trimString(thighm)=='' || trimString(tricepsm)=='' || trimString(subscapularism)=='' || trimString(illiaccrestm)=='' || trimString(midaxillarym)=='' || trimString(cuser_id2)=='')
		{
			flag=1;
		}
		
	}
	
	if(gender=='Female')
	{
		if(trimString(age)=='' || trimString(weight)=='' || trimString(height)=='' || trimString(chestf)=='' || trimString(abdominalf)==''  || trimString(thighf)=='' || trimString(tricepsf)=='' || trimString(subscapularisf)=='' || trimString(illiaccrestf)=='' || trimString(midaxillaryf)==''  || trimString(suprailiacf)=='' || trimString(cuser_id2)=='')
		{
			flag=1;
		}
		
	}
	 
	  
  if(flag==0)
  {	
		
			
		 var website_url ='<?php echo $config['url']?>home/clientmeasurement';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "gender="+gender+"&age="+age+"&weight="+weight+"&height="+height+"&chestm="+chestm+"&chestf="+chestf+"&abdominalm="+abdominalm+"&abdominalf="+abdominalf+"&thighm="+thighm+"&thighf="+thighf+"&tricepsm="+tricepsm+"&tricepsf="+tricepsf+"&subscapularism="+subscapularism+"&subscapularisf="+subscapularisf+"&illiaccrestm="+illiaccrestm+"&illiaccrestf="+illiaccrestf+"&midaxillarym="+midaxillarym+"&midaxillaryf="+midaxillaryf+"&suprailiacf="+suprailiacf+"&cuser_id="+cuser_id2,
		   		
				beforeSend: function(){$('.loaderResultMesr').show()},
				
		   		success: function(msg)
					{
						
						$('.loaderResultMesr').hide();
						
						
						$('#weight').val('');
						$('#height').val('');
						$('#age').val('');
						$('#chestm').val('');
						$('#chestf').val('');
						$('#abdominalm').val('');
						$('#abdominalf').val('');
						$('#thighm').val('');
						$('#thighf').val('');
						$('#tricepsm').val('');
						$('#tricepsf').val('');
						$('#subscapularism').val('');
						$('#subscapularisf').val('');
						$('#illiaccrestm').val('');
						$('#illiaccrestf').val('');
						$('#midaxillarym').val('');
						$('#midaxillaryf').val('');
						$('#suprailiacf').val('');
						
						$("#notificatin_mesG").html(msg);
						alert(msg);
						//$("#notificatin_mesG").fadeOut( "slow" );
						$('#notificatin_mesG').fadeIn().delay(10000).fadeOut();
						window.location.href = window.location.href;
						//$("#notificatin_mes3").html(msg['success']);
						
					}
				});	
		return false;
  }
  else
  {
  	alert('Please fill all fields value.');
  	return false;
  }
		
}


</script>
<style>
<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
#calendar table{border:none;}
#Profile{height:auto;width:100%;}
#Subscriptions{height:auto;width:100%;}
#sheetv{   clear: both; margin-top: 10px;}
table{width:100%;}
table th{ font-family: 'HelveticaLTCondensedRegular';    padding: 8px;}
table tbody tr td {text-align:center;}
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
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/exercise_libraryico.png"></span>Measurement and Goal</a></li>
        
        </ul>    
        
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
          <div class="twelve columns profile-change-pictext">
           <div class="clear">&nbsp;</div>
           <div class="clear"></div>
           <div ><p>Goal : <strong><?php echo $response['Goal']['goal']; ?></strong></p></div>
           
           <?php echo $listingmes;?>
           
           
           
          </div>
       <div style="float:left;" >
        
        <?php
        if(!empty($response19))
				{
					$cnt=1;
		?>			
        <table border='1' width='100%'>
				
				<tr class='slectedmn'>
				<th colspan='6'><h3 style='text-align:center;'>Measurement Goal</h3></th>
				</tr>
				<tr>
				<th>S.No.</th>
				<th>Date</th>
				<th>Seven Site Body Fat</th>
				<th>Three Site Body Fat</th>
				<th>Body Mass Index</th>
				<th>Action</th>
				
				</tr>
			
       <?php for($i=0;$i<count($response19);$i++)
				{
					
					echo "<tr><td>$cnt</td>";
					echo "<td>".date('M, j Y',strtotime($response19[$i]['SevensiteBodyfat']['created_date']))."</td>"; 
					echo "<td>";
					if($response19[$i]['SevensiteBodyfat']['status']==1)
					   {echo $response19[$i]['SevensiteBodyfat']['body_fat'];}
					    else{echo '--';}"</td>";
					echo "<td>";
					
					if($response20[$i]['ThreesiteBodyfat']['status']==1)
					   {echo $response20[$i]['ThreesiteBodyfat']['body_fat'];}
					    else{echo '--';}
					    "</td>";
					echo "<td>";
					if($response21[$i]['BodymassIndex']['status']==1)
					   {echo $response21[$i]['BodymassIndex']['body_fat'];}
					    else{echo '--';}"</td>";
					echo "<td>".'<a href="javascript:void(0);" onclick="viewdetail('.$uid.',\''.date('Y-m-d',strtotime($response19[$i]['SevensiteBodyfat']['created_date'])).'\');">View</a>'."</td>";
					
				 echo "</tr>";
				 $cnt++;
				}; } ?>
       
           </table>
        
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
   <!-- Change Cover popup -->
                <div id="pop5" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('pop5');" id="pop4" href="javascript:void(0);"></a>
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