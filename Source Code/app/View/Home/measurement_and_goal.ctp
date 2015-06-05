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

var website_url ='<?php echo $config['url']?>home/listtraineegoal';
	$.ajax({
				type:"POST",
				url: website_url,
				data: "trainee_id="+str,
				dataType: "json",
				success:function(data){						
					$("#target_container").html(data);							
					if(data.goal!=null)
					{
					  $("#resData").html('<div class="six columns"><div id="target_container"><input type="text" name="goal" value="'+data.goal+'" id="goal" placeholder="Goal" class="validate[required] text-input"/></div></div><div class="six columns"><a href="javascript:void(0);" onclick="doedit('+data.id+')" style="height: 35px; margin-top: 0; padding-top: 10px; width: 85px;" class="change-pic-nav">Save Goals</a></div>');
					}
					else
					{
						$("#resData").html('<div class="six columns"><div id="target_container"><input type="text" name="goal" value="'+data.goal+'" id="goal" placeholder="Goal" class="validate[required] text-input"/></div></div><div class="six columns"><a  href="javascript:void(0);" onclick="doadd('+data.trainee_id+')"  style="height: 35px; margin-top: 0; padding-top: 10px; width: 85px;" class="change-pic-nav">Save Goals</a></div>');
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

var website_url ='<?php echo $config['url']?>home/listtraineemeasurement';
	$.ajax({
				type:"POST",
				url: website_url,
				data: "trainee_id="+str,
				//dataType: "json",
				success:function(data){		
				         $("#target_container2").css('display','none');
					$("#target_container2").html(data);							
					if(data!='')
					{
                                           $('#bodyftbtn').css('display','block');
					}
					//alert(data);
					
						
				}
			});

}

function getmeasurement(str)
{
   if(str!='')
   {
          var website_url ='<?php echo $config['url']?>home/getmeasurement';
	$.ajax({
				type:"POST",
				url: website_url,
				data: "trainee_id="+str,
				//dataType: "json",
				success:function(data){	
				      if(data!=0)
				      {
				       $('#vmes').css('display','block');
				       //$("#getlist").css('display','block');
				       $("#getlist").css('height','470px');
                                       $("#getlist").html(data);
				      }
				      else
				      {
                                        $("#getlist").css('height','80px');
                                        $("#getlist").html('No Record Found.');
				      }
					
					//alert(data);

					
					
						
				}
			});
   }

}
function viewmeasurement()
{
  $("#getlist").css('display','block');
  $("#target_container2").css('display','none');
  
}
function viewbodyfat()
{
  $("#getlist").css('display','none');
  $("#target_container2").css('display','block');
  
}
/*function deletemes(str)
{
    if(str!='')
   {
     if(confirm("Are you sure, you want to delete this record?"))
     {
           var website_url ='<?php echo $config['url']?>home/deletemeasurement';
	         $.ajax({
				type:"POST",
				url: website_url,
				data: "trainee_id="+str,
				//dataType: "json",
				success:function(data){	
				      if(data!=0)
				      {
                                       $("#g_"+str).css('display','none');
				      }
				      else
				      {
                                        
				      }
					
					//alert(data);

					
					
						
				}
			});
     }
   }
}*/

function deletemes(str)
{
	var client_id=$('#TraineeId').val();
    if(str!='' && client_id!='')
   {
     if(confirm("Are you sure, you want to delete this record?"))
     {
           var website_url ='<?php echo $config['url']?>home/deleteMeasurementsAndGoals';
	         $.ajax({
				type:"POST",
				url: website_url,
				data: "client_id="+client_id+"&mes_id="+str,
				//dataType: "json",
				success:function(data){	
				      if(data!=0)
				      {
                                       $("#g_"+str).css('display','none');
				      }
				      else
				      {
                                        
				      }
					
					//alert(data);

					
					
						
				}
			});
     }
   }
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
	var rdval=$('input[name=skinfold]:checked').val();
	if(str=='Male')
	{
		if(rdval=='7'){
		$('#forfemale7').css('display','none');
		$('#formale7').css('display','block');
		}
		if(rdval=='3'){
		$('#forfemale3').css('display','none');
		$('#formale3').css('display','block');
		}
		
	}
	else
	{
		
		if(rdval=='7'){
		$('#formale7').css('display','none');
		$('#forfemale7').css('display','block');
		}
		if(rdval=='3'){
		$('#formale3').css('display','none');
		$('#forfemale3').css('display','block');
		}
		
		
	}
	
}

function viewdetail(str,str1)
{
	//alert(str+"--"+str1);
	 window.open('<?php echo $config['url'].'home/clientmesdetail/';?>'+str+'/'+str1, "popupWindow", "scrollbars=yes");
	 
	 
}

function deletetrainer(str,str1)
{
	if(str!='' && str1!='')
	{
		if(confirm("Are you sure, you want to delete this record?"))
		{
	         	$.ajax({
				url:"<?php echo $config['url'];?>home/deletemeasurement/",
				type:"POST",
				data:{id:str,id2:str1},
				success:function(e) {
					alert(e);
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

 function radiochk()
 {
 	var rdval=$('input[name=skinfold]:checked').val();
 	if(rdval=='7'){
 	$('#frmload'+rdval).css('display','block');
 	$('#frmload3').css('display','none');
 	}
 	if(rdval=='3'){
 	$('#frmload'+rdval).css('display','block');
 	$('#frmload7').css('display','none');
 	}
 	$('#sbm').css('display','block');
 	
 	
 }

function vaildateMeasurement()
{
	//alert('ok');
	var rdval=$('input[name=skinfold]:checked').val();
	
	if(rdval=='7')
	{
	
	
	var gender=$('#gender7').val();
	var age=$('#age7').val();
	
	//var weight=$('#weight7').val();
	//var height=$('#height7').val();
	var chestm=$('#chestm7').val();
	var chestf=$('#chestf7').val();
	var abdominalm=$('#abdominalm7').val();
	var abdominalf=$('#abdominalf7').val();
	var thighm=$('#thighm7').val();
	var thighf=$('#thighf7').val();
	var tricepsm=$('#tricepsm7').val();
	var tricepsf=$('#tricepsf7').val();
	var subscapularism=$('#subscapularism7').val();
	var subscapularisf=$('#subscapularisf7').val();
	var illiaccrestm=$('#illiaccrestm7').val();
	var illiaccrestf=$('#illiaccrestf7').val();
	var midaxillarym=$('#midaxillarym7').val();
	var midaxillaryf=$('#midaxillaryf7').val();
	//var suprailiacf=$('#suprailiacf7').val();
	var cuser_id2=$('#cuser_id').val();
	
	
	var skinfold = '7';

	}
	if(rdval=='3')
	{
	
	
	var gender=$('#gender3').val();
	var age=$('#age3').val();
	
	if(gender=='Male'){
	var chestm=$('#chestm3').val();
	
	var abdominalm=$('#abdominalm3').val();
	
	var thighm=$('#thighm3').val();
	
	}
	if(gender=='Female')
	{
		var thighf=$('#thighf3').val();
		var suprailiacf=$('#suprailiacf3').val();
			var tricepsf=$('#tricepsf3').val();
	}
	var cuser_id2=$('#cuser_id').val();
	
	
	var skinfold = '7';

	}


	
	var flag=0;
	
	if(gender=='Male' && rdval=='7')
	{
		if(trimString(age)==''  || trimString(chestm)=='' || trimString(abdominalm)==''  || trimString(thighm)=='' || trimString(tricepsm)=='' || trimString(subscapularism)=='' || trimString(illiaccrestm)=='' || trimString(midaxillarym)=='' || trimString(cuser_id2)=='')
		{
			flag=1;
		}
		
	}
	
	if(gender=='Female' && rdval=='7')
	{
		if(trimString(age)=='' || trimString(chestf)=='' || trimString(abdominalf)==''  || trimString(thighf)=='' || trimString(tricepsf)=='' || trimString(subscapularisf)=='' || trimString(illiaccrestf)=='' || trimString(midaxillaryf)==''  || trimString(cuser_id2)=='')
		{
			flag=1;
		}
		
	}
	
	if(gender=='Male' && rdval=='3')
	{
		if(trimString(age)=='' || trimString(chestm)=='' || trimString(abdominalm)==''  || trimString(thighm)=='' || trimString(cuser_id2)=='')
		{
			flag=1;
		}
		
	}
	
	if(gender=='Female' && rdval=='3')
	{
		if(trimString(age)=='' || trimString(tricepsf)=='' || trimString(suprailiacf)==''  || trimString(thighf)=='' || trimString(cuser_id2)=='')
		{
			flag=1;
		}
		
	}
	 
	  
  if(flag==0)
  {	
  	   if(rdval=='7'){
		var sntdata ="gender="+gender+"&age="+age+"&chestm="+chestm+"&chestf="+chestf+"&abdominalm="+abdominalm+"&abdominalf="+abdominalf+"&thighm="+thighm+"&thighf="+thighf+"&tricepsm="+tricepsm+"&tricepsf="+tricepsf+"&subscapularism="+subscapularism+"&subscapularisf="+subscapularisf+"&illiaccrestm="+illiaccrestm+"&illiaccrestf="+illiaccrestf+"&midaxillarym="+midaxillarym+"&midaxillaryf="+midaxillaryf+"&cuser_id="+cuser_id2+"&skinfold="+rdval;
  	   }
  	   
  	    if(rdval=='3' && gender=='Male'){
		var sntdata ="gender="+gender+"&age="+age+"&chestm="+chestm+"&abdominalm="+abdominalm+"&thighm="+thighm+"&cuser_id="+cuser_id2+"&skinfold="+rdval;
  	   }
  	   
  	    if(rdval=='3' && gender=='Female'){
		var sntdata ="gender="+gender+"&age="+age+"&tricepsf="+tricepsf+"&suprailiacf="+suprailiacf+"&thighf="+thighf+"&cuser_id="+cuser_id2+"&skinfold="+rdval;
  	   }
  	   
  	   
  	   
		 var website_url ='<?php echo $config['url']?>home/clientmeasurement';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: sntdata,
		   		
				beforeSend: function(){$('.loaderResultMesr').show()},
				
		   		success: function(msg)
					{
						
						$('.loaderResultMesr').hide();
						
						
						/*$('#weight').val('');
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
						$('#suprailiacf').val('');*/
						
						$("#notificatin_mesG").html(msg);
						alert(msg);
						//$("#notificatin_mesG").fadeOut( "slow" );
						//$('#notificatin_mesG').fadeIn().delay(10000).fadeOut();
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

function myhome()
{
	
	window.location.href="<?php echo $config['url']?>home/";
}
function addmeasurement()
{
var TraineeIdg=$('#TraineeId').val();
	if(TraineeIdg!='')
	{
             popupOpen('popAdm');
	     $('#mtraineeid').val(TraineeIdg);
	} else
	{
           alert('Please select client!');
	}

}

function validadm()
{
   
   var TraineeIdg=$('#mtraineeid').val();
   var mdate=$('#mdate').val();
   var mage=$('#mage').val();
   var mweight=$('#mweight').val();
   var mheight=$('#mheight').val();
   var mneck=$('#mneck').val();
   var mchest=$('#mchest').val();
   var mwaist=$('#mwaist').val();
   var mhips=$('#mhips').val();
   var mthigh=$('#mthigh').val();
   var mcalf=$('#mcalf').val();
  // var mgender=$('#mgender').val();
   var mbicep=$('#mbicep').val();

  /* if(TraineeIdg!='' && mdate!='' && mage!='' && mweight!='' && mheight!='' && mneck!='' && mchest!='' && mwaist!='' && mhips!='' && mthigh!='' && mcalf!='' && mgender!='' && mbicep!='')
   {*/
         var website_url ='<?php echo $config['url']?>home/addmeasurement';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: $('#addmeasurement').serialize(),
		   		
				beforeSend: function(){$('.loaderResultMesr').show()},
				
		   		success: function(msg)
					{
						
						$('.loaderResultMesr').hide();
						
						
						$('#mdate').val('');
						$('#mage').val('');
						$('#mweight').val('');
						$('#mheight').val('');
						$('#mneck').val('');
						$('#mchest').val('');
						$('#mwaist').val('');
						$('#mhips').val('');
						$('#mthigh').val('');
						$('#mbicep').val('');
						
						
						$("#notificatin_mesG").html(msg);
						alert(msg);
						
						//$('#notificatin_mesG').fadeIn().delay(10000).fadeOut();
						window.location.href = window.location.href;
						
						
					}
				});
 
  /* } else
   {
     alert('Please fill all the fields value.');
   }*/
return false;
}

</script>
<?php

  echo $this->Html->script('jquery-1.3.1.min.js');
	echo $this->Html->script('jquery-ui-1.7.1.custom.min.js');
    echo $this->Html->css('redmond/jquery-ui-1.7.1.custom.css');
   
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


<script>
 var bk=$.noConflict();
bk(function(){
  bk('#mdate').datepicker({ minDate: "-3M +10D", maxDate: "+1M +10D" }); 
 });
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
    <div class="inside-banner changecover-pic">
    
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
      <div class="twelve  inside-head columns">
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/mesurment_ico.png"></span>Measurements and Goals</a></li>   <input type="button" name="submit" value="Back to Home" class="change-pic-nav" onclick="myhome();" style="  float: left; height: 46px; margin: 0 0 10px 10px; width: 140px;"/>
            
        
        </ul>    
        
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
          <div class="twelve columns profile-change-pictext">
           <div class="clear">&nbsp;</div>
           <div class="clear"></div>
           <div > <form id="measurmnt" method="POST" >
      
        <h2>Measurements and Goals</h2>
	 <input type="button" name="submit" value="Add Measurement" class="change-pic-nav" onclick="addmeasurement();" style="  float: left; height: 36px; margin: 0 0 10px 10px; width: 140px;"/>  <input type="button" id="vmes" name="submit" value="View Measurements" class="change-pic-nav" onclick="viewmeasurement();" style="  display:none; float: left; height: 36px; margin: 0 0 10px 10px; width: 140px;"/> 
	   <div style="float:left;display:none;" id="adms">
       
        
        <input type="button" style="height: 37px; margin-left: 5px; margin-top: -1px;width: 150px;" class="change-pic-nav" onclick="addmessrmt();" value="Body Fat Calculator" name="submit">
         
        
        </div>
	<input type="button" id="bodyftbtn" name="submit" value="View Body Fat" class="change-pic-nav" onclick="viewbodyfat();" style="  display:none; float: left; height: 36px; margin: 0 0 10px 10px; width: 140px;"/>
         <div class="loaderResultMesr"><!--<img src="<?php echo $config['url']?>images/ajax-loader3.gif"/>--></div> <div id="notificatin_mesG" style="color:#ff0000; padding:4px 0 4px 0;"></div>
      
         
         <div class="row">
              <div class="twelve form-select columns">
              
            
              <?php
                         
              echo $this->Form->select('Trainee.id',$tranee,array('empty'=>'-- Select Client --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectid\').value= this.options[this.selectedIndex].text; chngtextbox(this.value); chngmeasure(this.value);getmeasurement(this.value);')); ?>          
                
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
              
              
              
            </div>
            
            <div class="row" id="resData">
         
          </div>
        </div>
        <div class="row" style="overflow-y:scroll;display:none;" id="getlist">
         
	</div>
        
      
        
        <div class="clear"></div>
        
        <div style="float:left;" id="target_container2">
        
       
        
        </div>
        
            
        
        
     
            
            <?php
      
  ?>
    </div>
    
     </form>
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
                

   <!-- Add Measurement popup -->
                <div id="popAdm" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popAdm');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="" controller="home" enctype="multipart/form-data" class="resform-wrap" id="addmeasurement" method="post" accept-charset="utf-8" onsubmit="return validadm();">
                          <h2>Add Measurement</h2>
                         
                               <div >
                          <input type="hidden" name="mtraineeid" id="mtraineeid" value=""/>
	        <div class="row">
	          <div class="six columns">
	           <input type="text" name="mdate" value="" id="mdate" placeholder="Date" class="validate[required] text-input" />
	          </div>
	           <div class="six columns">
	           <input type="text" name="mage" value="" id="mage" placeholder="Age" class="validate[required,custom[number]] text-input" />
	          </div>
	        </div>
	        
	         <div class="row">
		   <div class="six columns">
	             <input type="text" name="mweight" value="" id="mweight" placeholder="Weight" class="validate[required,custom[number]] text-input" />
	          </div>
	          <div class="six columns">
	            <input type="text" name="mheight" value="" id="mheight" placeholder="Height" class="validate[required,custom[number]] text-input"/>
	          </div>	         
	        </div>

		 <div class="row">
		   <div class="six columns">
	             <input type="text" name="mneck" value="" id="mneck" placeholder="Neck" class="validate[required,custom[number]] text-input" />
	          </div>
	          <div class="six columns">
	            <input type="text" name="mchest" value="" id="mchest" placeholder="Chest" class="validate[required,custom[number]] text-input"/>
	          </div>	         
	        </div>

		 <div class="row">
		   <div class="six columns">
	             <input type="text" name="mwaist" value="" id="mwaist" placeholder="Waist" class="validate[required,custom[number]] text-input" />
	          </div>
	          <div class="six columns">
	            <input type="text" name="mhips" value="" id="mhips" placeholder="Hips" class="validate[required,custom[number]] text-input"/>
	          </div>	         
	        </div>

		 <div class="row">
		   <div class="six columns">
	             <input type="text" name="mthigh" value="" id="mthigh" placeholder="Thigh" class="validate[required,custom[number]] text-input" />
	          </div>
	          <div class="six columns">
	            <input type="text" name="mcalf" value="" id="mcalf" placeholder="Calf" class="validate[required,custom[number]] text-input"/>
	          </div>	         
	        </div>

		
	        
	         <div class="row">
        <!-- <div class="six columns form-select">
             <select name="mgender" id="mgender" onChange="document.getElementById('customSelectmsval3').value= this.options[this.selectedIndex].text;" class="validate[required]">
                  <option value='Male'>Male</option>
                  <option value='Female'>Female</option>
                </select>
                <input type="text" id="customSelectmsval3" value="Male"/>
          </div>-->
          <div class="six columns ">
            <input type="text" name="mbicep" value="" id="mbicep" placeholder="Bicep" class="validate[required,custom[number]] text-input" />
          </div>
         
        </div>
        
        
                          </div> 
                     
             
                     
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
                <!-- Add Measurement End -->  

   <!-- Change Cover popup -->
                <div id="popAdMes" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popAdMes');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                      <form id="measurmnt" onsubmit="return vaildateMeasurement();" class="resform-wrap" id="valid" method="post" accept-charset="utf-8">
                        <h2>This is a record of the most recent measurements taken of ... </h2>
         <div class="loaderResultMesr" id="bft" style="display:none;"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div> <div id="notificatin_mesG" style="color:#ff0000; padding:4px 0 4px 0;"></div>
      
      
                        <input type="hidden" name="cuser_id" id="cuser_id" value=""/>
                     <div class="row" style="text-align:center;">
                       <input type="radio" name="skinfold" value="7"  onclick="radiochk();"/> Seven site
                        <input type="radio" name="skinfold" value="3" onclick="radiochk();"/> Three site
                       <!-- <input type="radio" name="skinfold" value="4" onclick="radiochk();" /> BMI-->
                        <div class="clear">&nbsp;</div>
                     </div> 
                     
                     <div id="frmload7" style="display:none;">
                        <div class="row">
         <div class="six columns form-select">
             <select name="gender7" id="gender7" onChange="document.getElementById('customSelectGval7').value= this.options[this.selectedIndex].text;chng(this.value);" class="validate[required]">
                  <option value='Male'>Male</option>
                  <option value='Female'>Female</option>
                </select>
                <input type="text" id="customSelectGval7" value="Male"/>
          </div>
          <div class="six columns ">
            <input type="text" name="age7" value="" id="age7" placeholder="Age" class="validate[required] text-input"/>
          </div>
         
        </div>
                  <!--       <div class="row">
          <div class="six columns">
            <input type="text" name="weight7" value="" id="weight7" placeholder="Weight(lbs)" class="validate[required] text-input"/>
          </div>
          <div class="six columns">
            <input type="text" name="height7" value="" id="height7" placeholder="Height(Inch)" class="validate[required] text-input" />
          </div>
        </div>
       -->
        
        <div id="formale7">
        
	        <div class="row">
	          <div class="six columns">
	            <input type="text" name="chestm7" value="" id="chestm7" placeholder="Chest" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="abdominalm7" value="" id="abdominalm7" placeholder="Abdominal" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	         <div class="row">
	          <div class="six columns">
	            <input type="text" name="thighm7" value="" id="thighm7" placeholder="Thigh" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="tricepsm7" value="" id="tricepsm7" placeholder="Triceps" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	        <div class="row">
	          <div class="six columns">
	            <input type="text" name="subscapularism7" value="" id="subscapularism7" placeholder="Subscapularis" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="illiaccrestm7" value="" id="illiaccrestm7" placeholder="Illiac crest" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	         <div class="row">
	          <div class="six columns">
	            <input type="text" name="midaxillarym7" value="" id="midaxillarym7" placeholder="Midaxillary" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            
	          </div>
	        </div>
        
        </div>
       
           <div id="forfemale7" style="display:none;">
        
	        <div class="row">
	          <div class="six columns">
	            <input type="text" name="chestf7" value="" id="chestf7" placeholder="Chest" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="abdominalf7" value="" id="abdominalf7" placeholder="Abdominal" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	         <div class="row">
	          <div class="six columns">
	            <input type="text" name="thighf7" value="" id="thighf7" placeholder="Thigh" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="tricepsf7" value="" id="tricepsf7" placeholder="Triceps" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	        <div class="row">
	          <div class="six columns">
	            <input type="text" name="subscapularisf7" value="" id="subscapularisf7" placeholder="Subscapularis" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="illiaccrestf7" value="" id="illiaccrestf7" placeholder="Illiac crest" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	         <div class="row">
	          <div class="six columns">
	            <input type="text" name="midaxillaryf7" value="" id="midaxillaryf7" placeholder="Midaxillary" class="validate[required] text-input"/>
	          </div>
	        <!--  <div class="six columns">
	            <input type="text" name="suprailiacf7" value="" id="suprailiacf7" placeholder="Suprailiac" class="validate[required] text-input" />
	          </div>-->
	        </div>
        
        </div> 
                     
                     </div>
                     
                      <div id="frmload3" style="display:none;">
                        <div class="row">
         <div class="six columns form-select">
             <select name="gender3" id="gender3" onChange="document.getElementById('customSelectGval3').value= this.options[this.selectedIndex].text;chng(this.value);" class="validate[required]">
                  <option value='Male'>Male</option>
                  <option value='Female'>Female</option>
                </select>
                <input type="text" id="customSelectGval3" value="Male"/>
          </div>
          <div class="six columns ">
            <input type="text" name="age3" value="" id="age3" placeholder="Age" class="validate[required] text-input"/>
          </div>
         
        </div>
                        
        
        <div id="formale3">
        
	        <div class="row">
	          <div class="six columns">
	            <input type="text" name="chestm3" value="" id="chestm3" placeholder="Chest" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="abdominalm3" value="" id="abdominalm3" placeholder="Abdominal" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	         <div class="row">
	          <div class="six columns">
	            <input type="text" name="thighm3" value="" id="thighm3" placeholder="Thigh" class="validate[required] text-input"/>
	          </div>
	         
	        </div>
	        
	     
        
        </div>
       
           <div id="forfemale3" style="display:none;">
        
	        <div class="row">
	          <div class="six columns">
	           <input type="text" name="suprailiacf3" value="" id="suprailiacf3" placeholder="Suprailiac" class="validate[required] text-input" />
	          </div>
	          <div class="six columns">
	             <input type="text" name="tricepsf3" value="" id="tricepsf3" placeholder="Triceps" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	         <div class="row">
	          <div class="six columns">
	            <input type="text" name="thighf3" value="" id="thighf3" placeholder="Thigh" class="validate[required] text-input"/>
	          </div>
	         
	        </div>
	        
	       
        
        </div> 
                     
                     </div>
                     
                      <div id="frmload4" style="display:none;">
                        <div class="row">
         <div class="six columns form-select">
             <select name="gender4" id="gender4" onChange="document.getElementById('customSelectGval4').value= this.options[this.selectedIndex].text;chng(this.value);" class="validate[required]">
                  <option value='Male'>Male</option>
                  <option value='Female'>Female</option>
                </select>
                <input type="text" id="customSelectGval4" value="Male"/>
          </div>
          <div class="six columns ">
            <input type="text" name="age4" value="" id="age4" placeholder="Age" class="validate[required] text-input"/>
          </div>
         
        </div>
                         <div class="row">
          <div class="six columns">
            <input type="text" name="weight4" value="" id="weight4" placeholder="Weight(lbs)" class="validate[required] text-input"/>
          </div>
          <div class="six columns">
            <input type="text" name="height4" value="" id="height4" placeholder="Height(Inch)" class="validate[required] text-input" />
          </div>
        </div>
       
        
        <div id="formale4">
        
	        <div class="row">
	          <div class="six columns">
	            <input type="text" name="chestm4" value="" id="chestm4" placeholder="Chest" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="abdominalm4" value="" id="abdominalm4" placeholder="Abdominal" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	         <div class="row">
	          <div class="six columns">
	            <input type="text" name="thighm4" value="" id="thighm4" placeholder="Thigh" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="tricepsm4" value="" id="tricepsm4" placeholder="Triceps" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	        <div class="row">
	          <div class="six columns">
	            <input type="text" name="subscapularism4" value="" id="subscapularism4" placeholder="Subscapularis" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="illiaccrestm4" value="" id="illiaccrestm4" placeholder="Illiac crest" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	         <div class="row">
	          <div class="six columns">
	            <input type="text" name="midaxillarym4" value="" id="midaxillarym4" placeholder="Midaxillary" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            
	          </div>
	        </div>
        
        </div>
       
           <div id="forfemale4" style="display:none;">
        
	        <div class="row">
	          <div class="six columns">
	            <input type="text" name="chestf4" value="" id="chestf4" placeholder="Chest" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="abdominalf4" value="" id="abdominalf4" placeholder="Abdominal" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	         <div class="row">
	          <div class="six columns">
	            <input type="text" name="thighf4" value="" id="thighf4" placeholder="Thigh" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="tricepsf4" value="" id="tricepsf4" placeholder="Triceps" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	        <div class="row">
	          <div class="six columns">
	            <input type="text" name="subscapularisf4" value="" id="subscapularisf4" placeholder="Subscapularis" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="illiaccrestf4" value="" id="illiaccrestf4" placeholder="Illiac crest" class="validate[required] text-input" />
	          </div>
	        </div>
	        
	         <div class="row">
	          <div class="six columns">
	            <input type="text" name="midaxillaryf4" value="" id="midaxillaryf4" placeholder="Midaxillary" class="validate[required] text-input"/>
	          </div>
	          <div class="six columns">
	            <input type="text" name="suprailiacf4" value="" id="suprailiacf4" placeholder="Suprailiac" class="validate[required] text-input" />
	          </div>
	        </div>
        
        </div> 
                     
                     </div>
                     
                        
        
                               
                            <div class="row" id="sbm" style="display:none;">
                        
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

                
                <!-- Change Cover popup -->
                <div id="popviewMes" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popviewMes');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                      <form id="measurmnt" onsubmit="return vaildateMeasurement();" class="resform-wrap" id="valid" method="post" accept-charset="utf-8">
                        <h2>View Details </h2>
         <div class="loaderResultMesr"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div> <div id="notificatin_mesG" style="color:#ff0000; padding:4px 0 4px 0;"></div>
      
      
                        <input type="hidden" name="cuser_id" id="cuser_id" value=""/>
                         <div class="row">
           <?php
            if(!empty($setSvftArr))
            {?>
            
        <div id="sheetv">
     <table border='1'>
     <tr class="slectedmn">
     <th colspan="10"><h3 style="text-align:center;">Seven Site Body Fat Index</h3></th>
     </tr>
	     <tr>
		     <th>Weight</th>    
		     <th>Age</th>
		     <th>Chest</th>
		     <th>Abdominal</th>
		     <th>Thigh</th>
		     <th>Triceps</th>
		     <th>Subscapularis</th>
		     <th>Illiac Crest</th>
		     <th>Midaxillary</th>
		     <th>Body Fat</th>
	     
	     </tr>
	     <tr>
	    
		     <td><?php echo $setSvftArr['SevensiteBodyfat']['weight'];?>(lbs)</td>
		     <td><?php echo $setSvftArr['SevensiteBodyfat']['age'];?></td>
		     <td><?php echo $setSvftArr['SevensiteBodyfat']['chest'];?></td>
		     <td><?php echo $setSvftArr['SevensiteBodyfat']['abs'];?></td>
		     <td><?php echo $setSvftArr['SevensiteBodyfat']['thigh'];?></td>
		     <td><?php echo $setSvftArr['SevensiteBodyfat']['triceps'];?></td>
		     <td><?php echo $setSvftArr['SevensiteBodyfat']['subscapularis'];?></td>
		     <td><?php echo $setSvftArr['SevensiteBodyfat']['illiaccrest'];?></td>
		     <td><?php echo $setSvftArr['SevensiteBodyfat']['midaxillary'];?></td>
		     <td><?php echo $setSvftArr['SevensiteBodyfat']['body_fat'];?>%</td>	     
	     
	     </tr>
     
     </table>
     
     </div>
     
    <div id="mcharts">
    <?php
    
    $bft=$setSvftArr['SevensiteBodyfat']['body_fat'];
    $leanbweight=100-intval($bft);
    echo $this->GoogleChart->create()
	->setTitle('Seven Site Body Fat', array('size' => 14, 'color' => '000000'))
	->setType('pie', array('3d'))
	->setSize(600, 300)
	->setMargins(10, 10, 10, 10)
	->addData(array($leanbweight, $bft))
	->setPieChartLabels(array('Lean Body Weight', 'Storage Fat'));
	
	
	
    ?>
    </div>
    <?php }
    if(!empty($setThrftArr)){
    ?>
       <div id="sheetv">
     <table border='1'>
     <tr class="slectedmn">
     <th colspan="7"><h3 style="text-align:center;">Three Site Body Fat Index</h3></th>
     </tr>
	     <tr>
		        
		     <th>Age</th>
		     <th>Chest</th>
		     <th>Abdominal</th>
		     <th>Thigh</th>
		     <th>Triceps</th>
		     <th>Suprailiac</th>		   
		     <th>Body Fat</th>
	     
	     </tr>
	     <tr>
	    
		     
		     <td><?php echo $setThrftArr['ThreesiteBodyfat']['age'];?></td>
		     <td><?php echo $setThrftArr['ThreesiteBodyfat']['chest'];?></td>
		     <td><?php echo $setThrftArr['ThreesiteBodyfat']['abdominal'];?></td>
		     <td><?php echo $setThrftArr['ThreesiteBodyfat']['thigh'];?></td>
		     <td><?php echo $setThrftArr['ThreesiteBodyfat']['triceps'];?></td>
		     <td><?php echo $setThrftArr['ThreesiteBodyfat']['suprailiac'];?></td>		  
		     <td><?php echo $setThrftArr['ThreesiteBodyfat']['body_fat'];?>%</td>	     
	     
	     </tr>
     
     </table>
     
     </div>
     <div id="mcharts">
    <?php
    $bft=$setThrftArr['ThreesiteBodyfat']['body_fat'];
    $leanbweight=100-intval($bft);
   echo $this->GoogleChart->create()
	->setTitle('Three Site Body Fat', array('size' => 14, 'color' => '000000'))
	->setType('pie', array('3d'))
	->setSize(600, 300)
	->setMargins(10, 10, 10, 10)
	->addData(array($leanbweight, $bft))
	->setPieChartLabels(array('Lean Body Weight', 'Storage Fat'));
	
	
	
    ?>
    </div>
    <?php }
    if(!empty($setBMIArr)){?>
     <div id="sheetv">
     <table border='1'>
     <tr class="slectedmn">
     <th colspan="4"><h3 style="text-align:center;">Body Mass Index</h3></th>
     </tr>
	     <tr>
		     <th>Weight</th>    
		     <th>Age</th>
		     <th>Height</th>		    		   
		     <th>BMI</th>
	     
	     </tr>
	     <tr>
	    
		     <td><?php echo $setBMIArr['BodymassIndex']['weight'];?>(lbs)</td>
		     <td><?php echo $setThrftArr['ThreesiteBodyfat']['age'];?></td>
		     <td><?php echo $setBMIArr['BodymassIndex']['height'];?>(Inch)</td>
		     		  
		     <td><?php echo round($setBMIArr['BodymassIndex']['body_fat'],2);?></td>	     
	     
	     </tr>
     
     </table>
       <div><img src="<?php echo $config['url'];?>images/bmi_chart.png"/></div>
     </div>
      <div class="clear"></div>
      <?php }?>
    </div>   
                      </div>                    
                        </form>
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Change Cover End -->                                             