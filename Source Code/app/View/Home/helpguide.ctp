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
<?php echo $this->Html->script('selectunselect'); ?> 
<!--<script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>-->
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
	
	window.location.href="<?php echo $surl;?>"+"/"+surl;
	
}



function dopnext(){
var prdate=$('#rangeA').val();
	var myDate=new Date(prdate);
var prvdt=myDate.setDate(myDate.getDate()+1);
var d=new Date(prvdt);
	var surl=(d.getMonth()+1)+ '-' + d.getDate() + '-' + d.getFullYear();
	
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

function viewvideo(str)
{
	if(str!='')
	{
		window.open('<?php echo $config["url"]?>helpguides/viewvideo/'+str,'videoPlayer','left=20,top=20,width=640,height=450,toolbar=0,resizable=0,menubar=0,scrollbars=0'); 
		
	}
	
}

</script>

<script type="text/javascript">



 
function chngurl(str)
{
	if(str!='')
	{
		//document.location.href='<?php echo $config['url'];?>home/exercise_history/'+str;
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
	 
	 
	  var trainer_id  = $('#trainer_id').val();
	  var trainee_id  = $('#trainee_id').val();
	  var added_date  = $('#exdate').val();
	 
	  
	
	
		if(trainer_id!='' && trainee_id!='' && added_date!=''){
					
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		 var website_url ='<?php echo $config['url']?>home/add_exercise_history';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: $('#addexercise').serialize(),
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

var gFiles = 0;
 function addNPlay(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay-' + gFiles); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplayexercise[]" id="exercise'+gFiles+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplayset[]" id="set'+gFiles+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" placeholder="Duration" style="  " value="" name="nplayduration[]" id="duration'+gFiles+'">'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplaycoaching_tip[]" id="coaching_tip'+gFiles+'">'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile(\'nplay-' + gFiles + '\')">Remove</a>'; 
 	tr.appendChild(td5);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles++; 
 } 
 
 function removeFile(aId) 
 {
 	//alert('1');
 	var obj = document.getElementById(aId); 
 	obj.parentNode.removeChild(obj); 
 } 
 
 var gFiles1 = 0;
 function addNPlay1(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay1-' + gFiles1); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplay1exercise[]" id="exercise'+gFiles1+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplay1set[]" id="set'+gFiles1+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" name="nplay1rep[]" id="rep'+gFiles1+'" value="" placeholder="Reps" />'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" name="nplay1temp[]" id="temp'+gFiles1+'" value="" placeholder="Weight" />'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = '<input type="text" name="nplay1rest[]" id="rest'+gFiles1+'" value="" placeholder="Rest" />'; 
 	tr.appendChild(td5);
 	
 	var td6 = document.createElement('td'); 
 	td6.setAttribute('style', 'padding: 9px 10px;');
 	td6.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplay1coaching_tip[]" id="coaching_tip'+gFiles1+'">'; 
 	tr.appendChild(td6);
 	
 	var td7 = document.createElement('td'); 
 	td7.setAttribute('style', 'padding: 9px 10px;');
 	td7.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile1(\'nplay1-' + gFiles1 + '\')">Remove</a>'; 
 	tr.appendChild(td7);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles1++; 
 } 
 
  function removeFile1(aId) 
 {
 	//alert('2');
 	var obj = document.getElementById(aId); 
 	obj.parentNode.removeChild(obj); 
 } 
 
 var gFiles2 = 0;
 function addNPlay2(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay2-' + gFiles2); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplay2exercise[]" id="exercise'+gFiles2+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplay2set[]" id="set'+gFiles2+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" name="nplay2rep[]" id="rep'+gFiles2+'" value="" placeholder="Reps" />'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" name="nplay2temp[]" id="temp'+gFiles2+'" value="" placeholder="Weight" />'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = '<input type="text" name="nplay2rest[]" id="rest'+gFiles2+'" value="" placeholder="Rest" />'; 
 	tr.appendChild(td5);
 	
 	var td6 = document.createElement('td'); 
 	td6.setAttribute('style', 'padding: 9px 10px;');
 	td6.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplay2coaching_tip[]" id="coaching_tip'+gFiles2+'">'; 
 	tr.appendChild(td6);
 	
 	var td7 = document.createElement('td'); 
 	td7.setAttribute('style', 'padding: 9px 10px;');
 	td7.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile2(\'nplay2-' + gFiles2 + '\')">Remove</a>'; 
 	tr.appendChild(td7);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles2++; 
 } 
 
  function removeFile2(aId) 
 {
 	//alert('3');
 	var obj = document.getElementById(aId);
 	obj.parentNode.removeChild(obj); 
 }
 
 var gFiles3 = 0;
 function addNPlay3(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay3-' + gFiles3); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplay3exercise[]" id="exercise'+gFiles3+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplay3set[]" id="set'+gFiles3+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" name="nplay3rep[]" id="rep'+gFiles3+'" value="" placeholder="Reps" />'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" name="nplay3temp[]" id="temp'+gFiles3+'" value="" placeholder="Weight" />'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = '<input type="text" name="nplay3rest[]" id="rest'+gFiles3+'" value="" placeholder="Rest" />'; 
 	tr.appendChild(td5);
 	
 	var td6 = document.createElement('td'); 
 	td6.setAttribute('style', 'padding: 9px 10px;');
 	td6.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplay3coaching_tip[]" id="coaching_tip'+gFiles3+'">'; 
 	tr.appendChild(td6);
 	
 	var td7 = document.createElement('td'); 
 	td7.setAttribute('style', 'padding: 9px 10px;');
 	td7.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile3(\'nplay3-' + gFiles3 + '\')">Remove</a>'; 
 	tr.appendChild(td7);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles3++; 
 } 
 
  function removeFile3(aId) 
 {
 	//alert('4');
 	var obj = document.getElementById(aId); 
 	obj.parentNode.removeChild(obj); 
 }
 
 var gFiles4 = 0;
 function addNPlay4(teamId) 
 { 
 	var tr = document.createElement('tr'); 
 	tr.setAttribute('id', 'nplay4-' + gFiles4); 
 	//tr.setAttribute('bgcolor', '#bdcae1');
 	//tr.setAttribute('style', 'line-height:30px;');
 	var td = document.createElement('td'); 
 	
 	td.setAttribute('style', 'padding: 9px 10px;');
 
 	 	td.innerHTML = '<input type="text" placeholder="Exercise" style="  " value="" name="nplay4exercise[]" id="exercise'+gFiles4+'">'; 
 	tr.appendChild(td); 
 	
 	var td2 = document.createElement('td'); 
 	td2.setAttribute('style', 'padding: 9px 10px;');
 	td2.innerHTML = '<input type="text" placeholder="Sets" style="  " value="" name="nplay4set[]" id="set'+gFiles4+'">'; 
 	tr.appendChild(td2); 
 	
 	var td3 = document.createElement('td'); 
 	td3.setAttribute('style', 'padding: 9px 10px;');
 	td3.innerHTML = '<input type="text" placeholder="Duration" style="  " value="" name="nplay4duration[]" id="duration'+gFiles4+'">'; 
 	tr.appendChild(td3);
 	
 	var td4 = document.createElement('td'); 
 	td4.setAttribute('style', 'padding: 9px 10px;');
 	td4.innerHTML = '<input type="text" placeholder="Coaching Tip" style=" " value="" name="nplay4coaching_tip[]" id="coaching_tip'+gFiles4+'">'; 
 	tr.appendChild(td4);
 	
 	var td5 = document.createElement('td'); 
 	td5.setAttribute('style', 'padding: 9px 10px;');
 	td5.innerHTML = ' <a href="javascript:void(0);" onclick="removeFile4(\'nplay4-' + gFiles4 + '\')">Remove</a>'; 
 	tr.appendChild(td5);
 	
 	document.getElementById(teamId).appendChild(tr);  	
 	gFiles4++; 
 } 
 
 function removeFile4(aId) 
 {
 	//alert('5');
 	var obj = document.getElementById(aId); 
 	obj.parentNode.removeChild(obj); 
 }
 function popupOpen3(str)
 {
 	if(str!='')
 	{
 	  popupOpen('popFd');
 	  var dtsv=$('#rangeA').val();
 	  var clname=$('#customSelectid').val();
 	  $('#exdate').val(dtsv);
 	  $('#clname').html(clname);
 	  	
 	}
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
.form-select select{border: 1px solid #CCCCCC;
    border-radius: 4px;
    height: 80px;
    opacity: 1;}
.form-select select option {
  
    margin-bottom: 1px;
    padding: 5px;
}

.form-select select option:nth-child(odd) {  background: none repeat scroll 0 0 #e6e6e6; }

.form-select select option:nth-child(even) {  background: none repeat scroll 0 0 #DDDDDD; }
.main-responsive-box .listing-box li .first-tabs {width:8%;}
a:hover{  background: none;
  border-radius: none;

  font-size: 16px;}
  .profile-tabs-list li a{color:#000;}
  .profile-tabs-list li a:hover, .profile-tabs-list li a.active{  background: none; border:none;   border-radius: 0px 0px 0 0;   font-size: 15px; padding: 13px 6px;}
  .listing-box li .second-tabs {  width: 253px;}
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
     <?php echo $this->element('lefttrainer');?>
      <div class="eight inside-head columns">
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <!--<li><a href="#Profile" class="active"><span class="profile-ico"></span>Exercise Library</a></li>-->
       
        </ul>    
       
        <ul class="profile-tabs-list mobile-tab clearfix">
 
           <div class="clear">&nbsp;</div>
                  <?php 
if (($this->Session->check('Message.flash'))) {
	echo $this->Session->flash('flash', array('element' => 'flash'));
}
?> 

		<?php 
		
		?>
		
		
		
		
		
           
	      <div class="row" style="margin-top: 44px; text-align: left;"></div>
              <div style="margin-top: 46px; text-align: left; font-weight: 700;" class="clear">Video Listing</div>
			  
<div class="main-responsive-box" style="margin:15px 0 0 0;"><ul class="listing-box">
          <li class="listing-heading">
            
            <div class="list-colum second-tabs">Name</div>
            <div class="list-colum third-tabs">Description</div>
			<div class="list-colum third-tabs">Action</div>
        
          </li>
        </ul>
        <ul class="listing-box">
          
                <?php 
          $cnt=1;
        
				
          foreach ($videos as $video)
          {
          ?>
            <li>
              
              <div class="list-colum second-tabs"><?php if(!empty($video['HelpGuide']['doc_name'])){echo $video['HelpGuide']['doc_name']; }; ?></div>
              <div class="list-colum third-tabs"><?php if(!empty($video['HelpGuide']['description'])){echo  $video['HelpGuide']['description']; };  ?></div>
			  <div class="list-colum third-tabs"><a href="javascript:void(0);" onclick="viewvideo('<?php echo base64_encode($video['HelpGuide']['id']); ?>')">View Video</a></div>
			  
         
            </li>
         <?php   $cnt++; ?>
            <?php  } ?>

            
                       
          </div><div style="background: none repeat scroll 0% 0% rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 358px;" class="slimScrollBar"></div><div style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: none repeat scroll 0% 0% rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;" class="slimScrollRail"></div></div>
        </ul>
        
        
         
      </div>
	  
	  
         <div style="margin-top: 5px; " class="clear">&nbsp;</div>



        
          
         

          </div>
        </div>
          
         
        </div>
        </ul>      
      
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
   
                <!-- Exercise History Popup  -->
                <div id="popFd" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent" style="width:684px;margin-left:-305px;"> <a class="close-nav" onclick="popupClose('popFd');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                       
                        
                        
                        <form id="addexercise" action="" method="POST" onsubmit="return validatefrmsfd();">
      
        <h2>Add Exercise History</h2>
         <div class="loaderResultFd" style="display: none;"><img src="<?php echo $config['url'];?>images/ajax-loader.gif"></div> <div style="color:#ff0000; padding:4px 0 4px 0;" id="notificatin_mesFd"></div>
         <input type="hidden" name="trainer_id" id="trainer_id" value="<?php echo $setSpecalistArr[$utype]['id'];?>"/>
         <input type="hidden" name="trainee_id" id="trainee_id" value="<?php if(isset($clientid) && $clientid!=''){ echo $clientid;}?>"/>
         <input type="hidden" name="added_date" id="added_date" value="<?php echo $datva2;?>"/>
         
       
            
         <table border='1' width='100%'>
				
				<tr class='slectedmn'>
				<td colspan='4' class="th2"><h3 style='text-align:left;float:left;'>PROFESSIONAL'S NAME: </h3> <span id="trsname" style="float: left; line-height: 32px;  padding: 10px 5px 5px;"><?php echo $setSpecalistArr[$utype]['full_name'];?></span>
				
				</td>
				
				</tr>
			</table>
         
         <table border='1' width='100%'>
				
				<tr class='slectedmn'>
				<td colspan='3' class="th2"><h3 style='text-align:left;float:left;'>Client Name:   </h3> <span id="clname" style="float: left; line-height: 32px;  padding: 10px 5px 5px;"></span>
				</td>
				<td  style="padding-left:220px;"> <span style="line-height:34px;float:left;">Date:</span><input name="exdate" id="exdate" value="" type="text" style="width:100px;"/></td>
				
				
				
				</tr>
			</table>
				

			<table border='1' width='100%'>
			<tr class='slectedmn'>
				<td colspan='3' class="th2"><h3 style='text-align:left;'>Goal:  </h3></td><td  style="padding-left:300px;"> Phase:</td>
				
				
				</tr>
			</table>	
			
			 <table border='1' width='100%' id="w">
				<tr class='slectedmn'>
				<td colspan='5' class="th2"><h3 style='text-align:left;'>Warm-Up </h3>
				
				</td>
				</tr>
				
				<th  class="throw">Exercise</th>
				<th  class="throw">Sets</th>
				<th  class="throw">Duration</th>
				<th  class="throw">Coaching Tip</th>
				<th  class="throw"></th>
				
				</tr>
				
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplayexercise[]" value="" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplayset[]" id="set" value="" placeholder="Sets" /></td>
		     <td><input type="text" name="nplayduration[]" id="duration" value="" placeholder="Duration" /></td>
		     <td><input type="text" name="nplaycoaching_tip[]" id="coaching_tip" value="" placeholder="Coaching Tip" /></td>
		     <td></td>
		     
		     
		     <!--<td id="responce"></td>-->
		     </tr>
		     

    
	     
	    
	     
     
     </table>   
     <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id='addButton' onclick="addNPlay('w');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 
	      </div>
	      
     <table border='1' width='100%' id="cbp">
     <tr class='slectedmn'>
				<td colspan='7' class="th2"><h3 style='text-align:left;'>CORE/BALANCE/PLYOMETRIC </h3>
				
				</td>
				</tr>
				
				<th  class="throw">Exercise</th>
				<th  class="throw">Sets</th>
				<th  class="throw">Reps</th>
				<th  class="throw">Weight</th>
				<th  class="throw">Rest</th>
				<th  class="throw">Coaching Tip</th>
				<th><th>
				</tr>
				
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplay1exercise[]" value="" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplay1set[]" id="set" value="" placeholder="Sets" /></td>
		     <td><input type="text" name="nplay1rep[]" id="rep" value="" placeholder="Reps" /></td>
		     <td><input type="text" name="nplay1temp[]" id="temp" value="" placeholder="Weight" /></td>
		     <td><input type="text" name="nplay1rest[]" id="rest" value="" placeholder="Rest" /></td>
		     <td><input type="text" name="nplay1coaching_tip[]" id="coaching_tip" value="" placeholder="Coaching Tip" /></td>
             <td></td>		    
		          
	     
	     </tr>
	     
      </table> 
      <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id='addButton1' onclick="addNPlay1('cbp');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 
	      </div>
      
       <table border='1' width='100%' id="saq">
     <tr class='slectedmn'>
				<td colspan='7' class="th2"><h3 style='text-align:left;'>SPEED/AGILITY/QUICKNESS </h3>
				
				</td>
				</tr>
				
				<th  class="throw">Exercise</th>
				<th  class="throw">Sets</th>
				<th class="throw">Reps</th>
				<th class="throw">Weight</th>
				<th class="throw">Rest</th>
				<th class="throw">Coaching Tip</th>
				<th><th>
				</tr>
				
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplay2exercise[]" value="" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplay2set[]" id="set" value="" placeholder="Sets" /></td>
		     <td><input type="text" name="nplay2rep[]" id="rep" value="" placeholder="Reps" /></td>
		     <td><input type="text" name="nplay2temp[]" id="temp" value="" placeholder="Weight" /></td>
		     <td><input type="text" name="nplay2rest[]" id="rest" value="" placeholder="Rest" /></td>
		     <td><input type="text" name="nplay2coaching_tip[]" id="coaching_tip" value="" placeholder="Coaching Tip" /></td>
		     <td></td>
	     
	     </tr>
	    
      </table> 
      <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id='addButton2' onclick="addNPlay2('saq');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 
	      </div>    
      
       <table border='1' width='100%' id="res">
     <tr class='slectedmn'>
				<td colspan='7' class="th2"><h3 style='text-align:left;'>RESISTANCE </h3>
				
				</td>
				</tr>
				
				<th  class="throw">Exercise</th>
				<th  class="throw">Sets</th>
				<th class="throw">Reps</th>
				<th class="throw">Weight</th>
				<th class="throw">Rest</th>
				<th class="throw">Coaching Tip</th>
				<th></th>
				</tr>
				
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplay3exercise[]" value="" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplay3set[]" id="set" value="" placeholder="Sets" /></td>
		     <td><input type="text" name="nplay3rep[]" id="rep" value="" placeholder="Reps" /></td>
		     <td><input type="text" name="nplay3temp[]" id="temp" value="" placeholder="Weight" /></td>
		     <td><input type="text" name="nplay3rest[]" id="rest" value="" placeholder="Rest" /></td>
		     <td><input type="text" name="nplay3coaching_tip[]" id="coaching_tip" value="" placeholder="Coaching Tip" /></td>
		     <td></td>
		          
	     
	     </tr>
	     
      </table> 
       <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id='addButton3' onclick="addNPlay3('res');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 
	      </div>    
      
      <table border='1' width='100%' id="cd">
				<tr class='slectedmn'>
				<td colspan='5' class="th2"><h3 style='text-align:left;'>COOL-DOWN </h3>
				
				</td>
				</tr>
				
				<th  class="throw">Exercise</th>
				<th  class="throw">Sets</th>
				<th  class="throw">Duration</th>
				<th  class="throw">Coaching Tip</th>
				<th></th>
				</tr>
				
				<tr>
	    
		     <td><input type="text" id="exercise" name="nplay4exercise[]" value="" placeholder="Exercise" /></td>
		     <td><input type="text" name="nplay4set[]" id="set" value="" placeholder="Sets" /></td>
		     <td><input type="text" name="nplay4duration[]" id="duration" value="" placeholder="Duration" /></td>
		     <td><input type="text" name="nplay4coaching_tip[]" id="coaching_tip" value="" placeholder="Coaching Tip" /></td>
		     <td></td>
		          
	     
	     </tr>
	   
     
     </table>  
     <div style="float:right;margin-bottom:15px;"><a href="javascript:void(0);" id='addButton4' onclick="addNPlay4('cd');" style=" background: none repeat scroll 0 0 #CCCCCC;   border-radius: 4px;  padding: 5px">Add More</a> 
	      </div> 
     
     <div class="twelve already-member columns">
                          <input type="submit" value="Submit" name="" class="submit-nav" >
                       </div>
            </div>
      
    </form>
                        
                        
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Exercise History  End -->            
                        <script type="text/javascript" src="/js/front/js/jquery.slimscroll.min.js"> </script> 
<script type="text/javascript">
var j = $.noConflict(); 
j(function(){
j('#testDivNested').slimscroll({ })
});
</script>