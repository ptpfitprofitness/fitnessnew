<?php
//echo "<pre>";print_r($client_data);echo "</pre>"; die;
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


<script>
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
function addgroupconfirm()
{
	
	var st = document.forms["validaddgroup"]["groupname"].value;
	var cl = document.forms["validaddgroup"]["status"].value;	
    if ((st==null || st=="")) {
        alert("Please fill all the fields");
        return false;
    }
	
	else if(confirm("Are you sure, you want to add this Group?"))
	{
		return true;
	}
	else
	{
		return false;
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
   	document.location.href="<?php echo $config['url'];?>home/editclient/"+str;
   	
   }

}

function newtrainee()
{
	
	document.location.href="<?php echo $config['url'];?>home/addclient/";
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
					
					if( e == "Success" ) {
						alert("Client has been deleted successfully.");
						
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

function back()
{	
	document.location.href="http://www.ptpfitpro.com/home/viewmygroups/";
}


   $(function() {
//bk( "#date1" ).datepicker();

$( "#purchaseddate" ).datepicker({  maxDate: "+1M +10D" })
});
</script>
<style>
#ui-datepicker-div{z-index:99999 !important;}
.second-tabs { min-width:178px; }
.third-tabs {min-width:178px; }
.four-tabs {min-width:178px; }
select{border: 1px solid hsl(0, 0%, 90%);height: 120px; padding: 8px;  width: 100%;}
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
          <h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['state'];?></h3>
        <p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ echo $setSpecalistArr[$utype]['userfb_status'];}?></p>
        </div>
      </div>
    </div>
    <div class="row">
     <?php echo $this->element('lefttrainer');?>
      <div class="eight inside-head columns">
           <div style="float:right">
	        
	        <input type="button" style="width:120px;" class="change-pic-nav" onclick="back();" value="Back" name="submit">
        </div>
       
        <div>
        <h2>Add Clients in Group</h2>
        <form accept-charset="utf-8" method="post" id="validaddgroup" class="resform-wrap" enctype="multipart/form-data" controller="home" action="/home/addclientingroup/">
		   
       
        <input type="hidden" readonly id="GroupMemberTrainerId" value=" <?php echo $setSpecalistArr[$utype]['id'];?>"  name="data[GroupMember][trainer_id]"/>
		
		<input type="hidden" readonly id="GroupMemberGroupId" value=" <?php echo $groupData['Group']['id'];?>"  name="data[GroupMember][id]"/>
		
		<input type="text" readonly id="GroupMemberGroupName" value=" <?php echo $groupData['Group']['group_name'];?>"  name="data[GroupMember][group_name]"/>
		
		<div class="twelve columns" style="border: 1px solid hsl(0, 2%, 84%);   border-radius: 4px;height: 150px;overflow-y: scroll;padding: 10px;">        
		<p style="margin:0 0 5px 0; font-weight:bold; border:1px solid #e5e5e5; padding:2px">Select Clients</p>		         
		<?php //echo $this->Form->input('GroupMember.group_clients', array('type' => 'select','empty'=>'-- Select Client --','class'=>'sltbx','required'=>'required', 'options' => $client_data, 'multiple' => true)); ?>            
		
		<?php 
		foreach ($client_data as $keys2 => $value2) 
		{
			$chkd='';
			if (in_array($keys2, $client_data)){
				$chkd="checked";}
		?>
		<label>
			<?php echo $this->Form->text('GroupMember.group_clients][', array('type'=>'checkbox', 'value'=>$keys2,$chkd=>$chkd));?>
			<?php echo $value2;?>
		</label>
		<?php } ?>
		
		</div>		
			
		<input type="submit" class="submit-nav" name="submit" value="Save"  />
        </form>
        </div>
        
           
      </div>
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
              
                