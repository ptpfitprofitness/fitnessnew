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
      
       <ul class="profile-tabs-list desktop-tabs clearfix">
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/formsico.png"></span>Form Listing</a></li>
        
        </ul>    
       
        <div class="main-responsive-box">
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
        	<form accept-charset="utf-8" method="post" id="validforms" class="resform-wrap" enctype="multipart/form-data" controller="home" action="/home/forms/">
		<?php 
		
		?>
		
		
		
		<input type="hidden"  name="data[CertificationTrainers][trainer_id]" id="CertificationTrainers_trainer_id" value="<?php echo $setSpecalistArr[$utype]['id'];?>"/>
		
            <div class="row">
              <div class="twelve form-select columns">            
              <?php
            //  echo $this->Form->select('Trainee.id',$tranee,array('empty'=>'-- Select Client --','class'=>'sltbx','multiple')); 
              
echo $this->Form->input('CertificationTrainers.clients', array('type' => 'select','empty'=>'-- Select Client --','class'=>'sltbx','required'=>'required', 
          'options' => $tranee, 'multiple' => true));
              ?>            </div>              
              </div>
	      <div class="row" style="margin-top: 44px; text-align: left;">[To send to multiple clients, hold down CTRL button and select clients]</div>
              <div style="margin-top: 46px; text-align: left; font-weight: 700;" class="clear">Library Listing</div>

<div class="main-responsive-box" style="margin:15px 0 0 0;"><ul class="listing-box">
          <li class="listing-heading">
            <div class="list-colum first-tabs" style="min-width:50px;">S.No.<?php echo $this->Form->text('CertificationTrainers.all', array('type'=>'checkbox', 'id'=>'data[CertificationTrainers][all]', 'onclick'=>"selectDeselect('data[CertificationTrainers][vidid][]', this.name);"));?>
            </div>
            <div class="list-colum second-tabs">Title</div>
            <div class="list-colum third-tabs">Download</div>
        
          </li>
        </ul>
        <ul class="listing-box">
          <div class="slimScrollDiv" style="overflow-y: scroll; height: 150px; border-bottom: 1px solid #CCCCCC;
    border-left: 1px solid #CCCCCC;"><div class="list-scroll-wrap" id="testDivNested" >
                <?php 
          $cnt=1;
        
      //print_r($forms);
          foreach ($forms as $form)
          {

          ?>
            <li>
              <div class="list-colum first-tabs" style="min-width:50px;"><?php echo $cnt; ?>
      <?php echo $this->Form->text('CertificationTrainers.vidid][', array('type'=>'checkbox', 'value'=>$form['Form']['id'],  'onclick'=>"checkSelection('data[CertificationTrainers][vidid][]', 'data[CertificationTrainers][all]')"));?> 
              </div>
              <div class="list-colum second-tabs"><?php if(!empty($form['Form']['title'])){echo $form['Form']['title']; }; ?></div>
              <div class="list-colum third-tabs"> <a href="<?php echo'/app/webroot/formuploads/'.$form['Form']['document']; ?>" >Download</a></div>
			        
            </li>
         <?php   $cnt++; ?>
            <?php  }?>

            
                       
          </div><div style="background: none repeat scroll 0% 0% rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 358px;" class="slimScrollBar"></div><div style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: none repeat scroll 0% 0% rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;" class="slimScrollRail"></div></div>
        </ul>
        
        
         
      </div>
         <div style="margin-top: 5px; " class="clear">&nbsp;</div>

<textarea placeholder="Message" required="required"  id="message" maxlength="500" name="data[CertificationTrainers][message]" style="width:100%; margin:15px 0 0 0;"></textarea>
            
           
 <input type="submit" class="submit-nav" name="submit" value="Send"/>

</form>
          
 
            
          </div>
        </ul>
        
        
     
     
      </div>
         <div style="margin-top: 5px; " class="clear">&nbsp;</div>


          
         

          </div>
        </div>
          
         
        </div>
        </ul>      
      </div>
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
   
                        
                        <script type="text/javascript" src="/js/front/js/jquery.slimscroll.min.js"> </script> 
<script type="text/javascript">
var j = $.noConflict(); 
j(function(){
j('#testDivNested').slimscroll({ })
});
</script>