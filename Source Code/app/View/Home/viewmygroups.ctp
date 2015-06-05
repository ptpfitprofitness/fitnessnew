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
/*echo"<pre>";
print_r($trainees);
echo"</pre>";*/
?>



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

function editgroup(str)
{

   if(str!='')
   {
   	document.location.href="<?php echo $config['url'];?>home/editgroup/"+str;
   	
   }

}

function addclientingroup(str)
{

   if(str!='')
   {
   	document.location.href="<?php echo $config['url'];?>home/addclientingroup/"+str;
   	
   }

}

function editclientingroup(str)
{

   if(str!='')
   {
   	document.location.href="<?php echo $config['url'];?>home/editclientingroup/"+str;
   	
   }

}

function newgroup()
{
	
	document.location.href="<?php echo $config['url'];?>home/newgroup/";
}

function back()
{
	
	document.location.href="<?php echo $config['url'];?>home/manage_clients/";
}


function deletegroup(str)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to delete this Group?"))
		{
	         	$.ajax({
				url:"<?php echo $config['url'];?>home/deletegroup/",
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
	//alert('hello');
	 $('.loaderResultFd').show();
	 
	 //var range=$('#rangeA').val();
	 
		var firstname  = $('#first_name').val();
	   var lastname=$('#last_name').val();
	   var email=$('#email').val();
	  var club_id  = $('#club_id').val();
	  var club_branch_id  = $('#club_branch_id').val();
	
	 
		if( firstname!='' && lastname!='' && email!='' ){
		
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		 var website_url ='<?php echo $config['url']?>home/invite_new_trainee';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "firstname="+firstname+"&lastname="+lastname+"&email="+email+"&club_id="+club_id+"&club_branch_id="+club_branch_id,
		   		
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
			alert('Please fill all fields.');
		}
	return false;
}

function chngurl(str)
{
	if(str!='')
	{
		document.location.href='<?php echo $config['url'];?>home/viewclientsessions/'+str;
	} else
	{
              document.location.href='<?php echo $config['url'];?>home/viewclientsessions/';
	}
}

</script>
<style>
.second-tabs { min-width:120px; }
.third-tabs {min-width:120px; }
.four-tabs {min-width:120px; }
<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
#calendar table{border:none;}
img, object, embed{max-width:none;}
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
        
	 <div class="row">
              
        <div style="float:right">
	        <input type="button" style="width:180px;margin-right:10px;" class="change-pic-nav" onclick="newgroup();" value="Add Group" name="submit">
			<!--<input type="button" style="width:180px;margin-right:10px;" class="change-pic-nav" onclick="newgroup();" value="Clients in Group" name="submit"> -->
	        <input type="button" style="width:120px;" class="change-pic-nav" onclick="back();" value="Back" name="submit">
        </div>
		<div style="clear:both"></div>
		<br />
				
        <?php if(!empty($groupView)) { ?>

		<div class="main-responsive-box">
			<ul class="listing-box all-headtabs">
				<li class="listing-heading">
				<div class="list-colum first-tabs">S.No.</div>
				<div class="list-colum second-tabs">Group Name</div>
				<div class="list-colum second-tabs">Status</div>
				<div class="list-colum third-tabs">Action</div>
				</li>
			</ul>        
			<ul class="listing-box">
				<div id="testDivNested" class="list-scroll-wrap">
					<?php 
						$cnt=1;
						foreach ($groupView as $groupV){
					?>
				<li>
				  <div class="list-colum first-tabs"><?php echo $cnt; ?></div>
				  <div class="list-colum second-tabs"><?php if(!empty($groupV['Group']['group_name'])){echo $groupV['Group']['group_name']; };  ?></div>
				  <div class="list-colum second-tabs"><?php if($groupV['Group']['status']==1){echo "Active";}else{echo "In Active";}  ?></div>
				  <div class="list-colum third-tabs">
				  <a href="javascript:void(0);" onclick="editgroup('<?php echo base64_encode($groupV['Group']['id']);?>');"><img src="<?php echo $config['url'];?>images/editicon.png"></a>				  
				  <a href="javascript:void(0);" onclick="deletegroup(<?php echo $groupV['Group']['id'];?>);"><img src="<?php echo $config['url'];?>images/deleteicon.png"></a>
				  <a href="javascript:void(0);" onclick="addclientingroup('<?php echo base64_encode($groupV['Group']['id']);?>');">Add Clients / </a>
				  <a href="javascript:void(0);" onclick="editclientingroup('<?php echo base64_encode($groupV['Group']['id']);?>');">Edit Clients</a>
				  </div>
				</li>
				<?php $cnt++; ?>
				<?php }?>

				</div>
			</ul>
      </div>
      <?php } else { echo '<div class="row" style=" color: #636363; float: left; font-family: HelveticaLTCondensedRegular; font-size: 15px;
      clear: both; margin-top: 81px;">No records found</div>';}?>
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
   
                
 <?php echo $this->Html->script('front/js/jquery.slimscroll.min');?>                 

<script type="text/javascript">
$(function(){
$('#testDivNested').slimscroll({ })
});
</script>                
                