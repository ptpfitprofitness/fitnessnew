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
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <li><a href="#Profile" class="active"><span class="profile-ico"></span>Exercise History</a></li>
       
        </ul>    
       
        <ul class="profile-tabs-list mobile-tab clearfix">
         
           <div class="clear">&nbsp;</div>
           

 <form accept-charset="utf-8" method="post" id="validcertificationtrainers" class="resform-wrap" enctype="multipart/form-data" controller="home" action="/trainees/addcertification_trainer/">
		<?php 
		
		?>
		
		
		
		<input type="hidden"  name="data[CertificationTrainers][trainer_id]" id="CertificationTrainers_trainer_id" value="<?php echo $setSpecalistArr[$utype]['id'];?>"/>
		
            
          <?php if(isset($clientid) && $clientid!=''){?>
             <div class="dpckr" >

		<input  value="<?php echo $datva;?>" id="rangeA" type="text" readonly="readonly">	
		

		<!--<div style="float: left;margin-top: 16px;width: 150%;" ><a href="javascript:void(0);" style=" border-right: none; font-weight:700;" onclick="viewdetail('<?php //echo $clientid;?>' ,'<?php //echo $datva2; ?>');" class="add_food">Print Exercise History</a></div>-->
		
		
		
			  <?php
            if(isset( $rst))
            {
            	
            	echo  $rst;
            	
            }?>

           
            <?php }?>
            
            </div>
           
          </form>
          
         

          </div>
        </div>
          
         
        </div>
        </ul>      
      </div>
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
   
                <!-- Exercise History Popup  -->
                <div id="popFd" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popFd');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                       
                        
                        
                        <form id="addexercise" action="" method="POST" onsubmit="return validatefrmsfd();">
      
        <h2>Add Exercise History</h2>
         <div class="loaderResultFd" style="display: none;"><img src="<?php echo $config['url'];?>images/ajax-loader.gif"></div> <div style="color:#ff0000; padding:4px 0 4px 0;" id="notificatin_mesFd"></div>
         <input type="hidden" name="trainer_id" id="trainer_id" value="<?php echo $setSpecalistArr[$utype]['id'];?>"/>
         <input type="hidden" name="trainee_id" id="trainee_id" value="<?php if(isset($clientid) && $clientid!=''){ echo $clientid;}?>"/>
         <input type="hidden" name="added_date" id="added_date" value="<?php echo $datva2;?>"/>
            
         <div class="row">
              <div class="twelve columns">
                 <input type="text" id="exercise_name" name="exercise_name" value="" placeholder="Exercise Name" />
           
              </div>
            </div>
         <div class="row">
              <div class="twelve columns">
                 <input type="text" id="set" name="set" value="" placeholder="Sets" />
           
              </div>
            </div>
            
           <div class="row">
              <div class="twelve columns">
                <input type="text" name="rep" id="rep" value="" placeholder="Reps" />
              </div>
            </div>  
            
            <div class="row">
              <div class="twelve columns">
                 <input type="text" name="weight" id="weight" value="" placeholder="Weight" />
              </div>
              
              <div class="row">
              <div class="twelve columns">
               <textarea cols="40" rows="5" name="note" id="note" placeholder="Training Cues"></textarea>
              </div>
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
                        