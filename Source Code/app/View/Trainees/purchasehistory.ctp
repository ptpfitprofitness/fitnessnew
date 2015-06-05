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

<?php 
    echo $this->Html->css('front/nutrion');
    
    ?>
    
<?php

   echo $this->Html->script('jquery-1.3.1.min.js');
	echo $this->Html->script('jquery-ui-1.7.1.custom.min.js');
	echo $this->Html->script('daterangepicker.jQuery.js');

    echo $this->Html->css('ui.daterangepicker.css');	
    echo $this->Html->css('redmond/jquery-ui-1.7.1.custom.css');
?>

<script>
 var bk=$.noConflict();
			bk(function(){
				  bk('#rangeA').daterangepicker({arrows:true}); 
			 });
 bk(function(){
	 bk('.already-sign').click(function(){
		 bk(this).children('.profile-list').slideToggle();
		 bk(this).toggleClass('active'); 
	 });
  });
  
  
  function dopre(){
	var prdate=$('#rangeA').val();
	var myDate=new Date(prdate);
var prvdt=myDate.setDate(myDate.getDate()-1);
	var d=new Date(prvdt);
	var surl=(d.getMonth()+1)+ '-' + d.getDate() + '-' + d.getFullYear();
	
	//alert(surl);
	
	window.location.href="<?php echo $surl;?>"+"/"+surl;
	
}

function dopnext(){
var prdate=$('#rangeA').val();
	var myDate=new Date(prdate);
var prvdt=myDate.setDate(myDate.getDate()+1);
var d=new Date(prvdt);
	var surl=(d.getMonth()+1)+ '-' + d.getDate() + '-' + d.getFullYear();
	
//	/alert(surl);
	
	window.location.href="<?php echo $surl;?>"+"/"+surl;
}
  
function vks()
{
	alert( $('#rangeA').val());
	
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



</script>

<script type="text/javascript">



 
function chngurl(str)
{
	if(str!='')
	{
		document.location.href='<?php echo $config['url'];?>trainees/exercise_history/'+str;
		
	}
}

 function popupOpenFd(str,str2){
		//var popupText = $(this).attr('title');
//		$('.buttons').children('span').text(popupText);
		$('#'+str).css('display','block');
		$('#'+str).animate({"opacity":"1"}, 300);
		$('#'+str).css('z-index','9999999999');	
		$('#fdtype').val(str2);	
		var tran = $("#TraineeId").val();
		$("#trainee_id").val(tran);		
	} 
	
	function validatefrmsfd()
    {
	 $('.loaderResultFd').show();
	 
	 //var range=$('#rangeA').val();
	 
	  var exercise_name  = $('#exercise_name').val();
	  var set  = $('#set').val();
	  var rep=$('#rep').val();
	  var weight=$('#weight').val();
	  var trainer_id  = $('#trainer_id').val();
	  var trainee_id  = $('#trainee_id').val();
	  var added_date  = $('#added_date').val();
	  var note  = $('#note').val();
	  
	
	
		if(exercise_name!='' && set!='' && rep!='' && weight!='' && note!=''  && trainer_id!='' && trainee_id!='' && added_date!=''){
		
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		 var website_url ='<?php echo $config['url']?>home/add_exercise_history';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "exercise_name="+exercise_name+"&set="+set+"&rep="+rep+"&weight="+weight+"&note="+note+"&trainer_id="+trainer_id+"&trainee_id="+trainee_id+"&added_date="+added_date,
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
			alert('Please Fill all Fields.');
		}
	return false;
}

function viewdetail(str,str1)
{
	//alert(str+"--"+str1);
	
	var prdate=$('#rangeA').val();
	var myDate=new Date(prdate);
var prvdt=myDate.setDate(myDate.getDate());
var d=new Date(prvdt);
	var surl=(d.getMonth()+1)+ '-' + d.getDate() + '-' + d.getFullYear();
	
//	/alert(surl);
	
	//window.location.href="<?php echo $surl;?>"+"/"+surl;
	
	
	 window.open('<?php echo $config['url'].'trainees/clientdownloadpdf/';?>'+str+'/'+surl, "popupWindow", "width=600,height=600,scrollbars=yes");
	 
	 
}

function chngdts(str)
{
	
    var res = str.split("/");
   
   var surl=res[0]+'-'+res[1]+'-'+res[2];
  
   window.location.href="<?php echo $surl;?>"+"/"+surl;
}
</script>
<style>
<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
#calendar table{border:none;}

.th2 h3 {
    color: #424242;
   font-family: 'HelveticaLTCondensedRegular';
    font-size: 16px;
    font-style: normal;
    margin-bottom: 7px;
}   
.throw  {
    color: #424242;
    font-family: 'HelveticaLTCondensedRegular';
   font-size: 14px;
    font-style: normal;
    margin-bottom: 7px;
    padding-left:12px;
    }
.new {
color: #424242;
    font-family: 'HelveticaLTCondensedRegular';
   font-size: 14px;
    font-style: normal;
    margin-bottom: 7px;
    margin-left:360px;
    
}
}
table tr td {
    border: medium none;
    color: #333333;
    padding: 9px 10px;
    vertical-align: top;
}

#addexercise{font-size:14px;font-family: 'HelveticaLTCondensedRegular';}
#rangeA{background: url(<?php echo $config['url'];?>images/calender_ico.png) no-repeat scroll 7px 7px #FFF;
padding-left:30px;}

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
           
	 <div class="row">
	<?php if(!empty($session_purc_data))
		{ ?>	 
			<h2>Sessions History</h2>
			<?php foreach ($session_purc_data as $session_purc)
          {	?>
		<div class="list-colum second-tabs"><b>Session Type-:</b> <?php if(!empty($session_purc['workout']['workout_name'])){echo $session_purc['workout']['workout_name']; };  ?></div>
		<div class="list-colum second-tabs"><b>Sessions Purchased-:</b> <?php if(!empty($session_purc['SessionPurchase']['no_of_purchase'])){echo $session_purc['SessionPurchase']['no_of_purchase']; };  ?></div>
		<div class="list-colum second-tabs"><b>Sessions Used-:</b> <?php if(!empty($session_purc['SessionPurchase']['no_of_booked'])){echo $session_purc['SessionPurchase']['no_of_booked']; } else {echo 0;};  ?></div>
		<br />
		<?php }?>
		<?php } ?>
		

        <?php if(!empty($trainees))
	{ ?>
		<h2>Purchase History</h2>
        <div class="main-responsive-box"><ul class="listing-box all-headtabs">
          <li class="listing-heading">
            
            <div class="list-colum second-tabs">Trainer Name</div>
            <div class="list-colum second-tabs">Session Type</div>
            <div class="list-colum third-tabs">Session Purchased</div>
			
            <div class="list-colum four-tabs" style="">Cost</div>
            <div class="list-colum fifth-tabs" style="">Date</div>
			
          </li>
        </ul>
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
          <?php 
          $cnt=1;
			
          foreach ($trainees as $trainee)
          {
          	
          ?>
            <li>
              
              <div class="list-colum second-tabs"><?php if(!empty($trainee['Trainer']['full_name'])){echo $trainee['Trainer']['full_name']; };  ?></div>
              <div class="list-colum second-tabs"><?php if(!empty($trainee['Workout']['workout_name'])){echo $trainee['Workout']['workout_name']; };  ?></div>
              <div class="list-colum third-tabs"><?php if(!empty($trainee['TraineesessionPurchase']['purchase_session'])){echo  $trainee['TraineesessionPurchase']['purchase_session']; };  ?></div>
			  
              <div class="list-colum four-tabs" style=""><?php if(!empty($trainee['TraineesessionPurchase']['cost'])){echo  '$'.$trainee['TraineesessionPurchase']['cost']; };  ?></div>
              <div class="list-colum fifth-tabs" style=""><?php if(!empty($trainee['TraineesessionPurchase']['purchased_date'])){echo  date('m/d/y',strtotime($trainee['TraineesessionPurchase']['purchased_date'])); };  ?></div>
			  
              
              
              
            </li>
         <?php   $cnt++; ?>
            <?php  }?>
            
          </div>
        </ul>
        
        
              
      </div>
      <?php } else { echo '<div class="row" style=" color: #636363; float: left; font-family: HelveticaLTCondensedRegular; font-size: 15px;
      clear: both; margin-top: 81px;">No records found</div>';}?>
    </div>
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
   
                