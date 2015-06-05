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


function deletefood(str)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to delete this Food?"))
		{
	         	$.ajax({
				url:"<?php echo $config['url'];?>home/deletefood/",
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


/* bk('.ui-icon-circle-triangle-e').live("click", function() {
  alert(1);
});	 


$(".ui-icon-circle-triangle-e" ).on( "click", function() {
alert(123);
});*/

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


//$(".ui-daterangepicker-next").click(){alert(123);}

 function popupOpenFd(str,str2){
		//var popupText = $(this).attr('title');
//		$('.buttons').children('span').text(popupText);
		$('#'+str).css('display','block');
		$('#'+str).animate({"opacity":"1"}, 300);
		$('#'+str).css('z-index','9999999999');	
		$('#fdtype').val(str2);			
	} 
	
function foodlist(str)
{
//food_list
	
 if(str!='')
 {
 	   	$.ajax({
				url:"<?php echo $config['url'];?>home/foodlist/",
				type:"POST",
				data:{typefd:str},
				success:function(e) {
					
					var response = eval(' ( '+e+' ) ');
					var option ='';
					$("#food_list").empty()
					 $.each( response, function( i, item ) {
					 	//alert(i)
					 	
					 	var option = $('<option></option>').attr("value", item).text(item);

					 	$("#food_list").append(option);
					 });
					
					
				}
		      });
 }

}

function validatefrmsfd()
{
	 $('.loaderResultFd').show();
	 
	 var range=$('#rangeA').val();
	 
		var food_type  = $('#food_type').val();
	   var food_list=$('#food_list').val();
	   var food_qty=$('#food_qty').val();
	  var client_id  = $('#client_id').val();
	
	
		if(range!='' && food_type!='' && food_list!='' && food_qty!='' && client_id!=''){
		
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		 var website_url ='<?php echo $config['url']?>home/add_daily_diary';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "food_type="+food_type+"&food_list="+food_list+"&food_qty="+food_qty+"&client_id="+client_id+"&fooddate="+range,
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
	return false;
}

function chngurl(str)
{
	if(str!='')
	{
		
		
		var prdate=$('#rangeA').val();
	var myDate=new Date(prdate);
var prvdt=myDate.setDate(myDate.getDate());
var d=new Date(prvdt);
	var tdate=(d.getMonth()+1)+ '-' + d.getDate() + '-' + d.getFullYear();
		
		
		document.location.href='<?php echo $config["url"];?>home/add_daily_nutrition_diary/'+str+'/'+tdate;
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
input {width: 196px; height: 1.1em; display:block;}
#calendar table{border:none;}
input #rangeA {width: 196px; height: 2.6em; display:block; border:none;}
.dpckr{margin-top:25px;}
/*.ui-widget-content{display:none;}*/
.diary{height:auto !important;}
.submit-nav{height:auto !important;}
#rangeA{background: url(<?php echo $config['url'];?>images/calender_ico.png) no-repeat scroll 7px 7px #FFF;
padding-left:30px;}
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
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/plate-cutlery.png"></span>Daily Nutrition Diary</a></li>
        
        </ul>    
        
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Daily Nutrition Diary</a></li>
          <div class="twelve columns profile-change-pictext">
           <div class="clear">&nbsp;</div>
           <div class="clear"></div>
           <div id="mfood" class="clearfix">
           <?php
           echo '<h2>coming soon</h2>';
          // exit;
           ?>
           
           <!-- we have added style display none for client request -->
           <div id="food-diary" style="display:none;"><div class="diary">
    <h1>Your Food Diary For:</h1>
    <div class="row" style="margin-left:150px;margin-top:-20px;">
              <div class="twelve form-select columns" style="width:50%;">
              
            <select id="TraineeId" onchange="document.getElementById('customSelectid').value= this.options[this.selectedIndex].text; chngurl(this.value);" class="sltbx" name="data[Trainee][id]">
<option value="">-- Select Client --</option>
<?php foreach ($tranee as $key=>$val){?>
<option value="<?php echo base64_encode($key);?>" <?php if(isset($client_id) && $client_id!='' && $key==$client_id){?>selected="selected"<?php }?>><?php echo $val;?></option>
<?php }?>
</select>
              <?php
              /*           
              echo $this->Form->select('Trainee.id',$tranee,array('empty'=>'-- Select Client --','class'=>'sltbx','onchange'=>'document.getElementById(\'customSelectid\').value= this.options[this.selectedIndex].text; chngurl(this.value);'));
              */
               ?>          
                
                <input type="text" id="customSelectid" value="<?php if(isset($client_id) && $client_id!=''){
                foreach($tranee as $key=>$val)
                {
                  if($key==$client_id)
                  {
                  	 echo $val;
                  	 
                  }	
                	
                }
                }else{echo '-- Select Client--';}?>"/>
                
              </div>
              
              
              
            </div>
    
  

	     <div class="dpckr">

		<input  value="<?php echo $datva;?>" id="rangeA" type="text" readonly="readonly">	
		</div>
        


  
  
  <div class="food_container">
    <table class="table0">
      <colgroup>
      <col class="col-1" />
      <col class="col-2" />
      <col class="col-2" />
      <col class="col-2" />
      <col class="col-2" />
      <col class="col-2" />
      <col class="col-2" />
      <col class="col-8" />
      </colgroup>
      <tbody>
        <tr class="meal_header">
          <td class="first alt">Breakfast</td>
          <td class="alt">Calories</td>
          <td class="alt">Carbs</td>
          <td class="alt">Fat</td>
          <td class="alt">Protein</td>
          <td class="alt">Mineral</td>
          <td class="alt">Vitamin</td>
        </tr>
        <?php 
        $breakfst_svn=array();
          $lunch_svn=array();
          $dinner_svn=array();
          $snacks_svn=array();
          $total_svn=array();
        foreach($logdata as $logdatas)
        {
           
           if($logdatas['AdddailyNutritionDiary']['food_type']=='Breakfast')
           {
            	$breakfst_svn['calorie']=$breakfst_svn['calorie']+(($logdatas['AdddailyNutritionDiary']['calorie'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$breakfst_svn['carb']=$breakfst_svn['carb']+(($logdatas['AdddailyNutritionDiary']['carb'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$breakfst_svn['fat']=$breakfst_svn['fat']+(($logdatas['AdddailyNutritionDiary']['fat'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$breakfst_svn['protein']=$breakfst_svn['protein']+(($logdatas['AdddailyNutritionDiary']['protein'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$breakfst_svn['mineral']=$breakfst_svn['mineral']+(($logdatas['AdddailyNutritionDiary']['mineral'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$breakfst_svn['vitamin']=$breakfst_svn['vitamin']+(($logdatas['AdddailyNutritionDiary']['vitamin'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	
            	$total_svn['calorie']=$total_svn['calorie']+(($logdatas['AdddailyNutritionDiary']['calorie'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['carb']=$total_svn['carb']+(($logdatas['AdddailyNutritionDiary']['carb'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['fat']=$total_svn['fat']+(($logdatas['AdddailyNutritionDiary']['fat'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['protein']=$total_svn['protein']+(($logdatas['AdddailyNutritionDiary']['protein'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['mineral']=$total_svn['mineral']+(($logdatas['AdddailyNutritionDiary']['mineral'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['vitamin']=$total_svn['vitamin']+(($logdatas['AdddailyNutritionDiary']['vitamin'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	
        ?>
        <tr>
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729276" data-locale="" href="#"><?php echo $logdatas['AdddailyNutritionDiary']['food_name'].'('.$logdatas['AdddailyNutritionDiary']['quantity'].')';?></a></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['calorie'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['carb'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['fat'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['protein'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['mineral'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['vitamin'];?></td>
        <!--  <td class="delete"><a href="javascript:void(0);" onclick="deletefood(<?php //echo $logdatas['AdddailyNutritionDiary']['id'];?>);"><i class="icon-minus-sign"></i></a></td>-->
        </tr>
        <?php }
        }?>
   
        <!--<tr class="bottom">
          <td class="first alt" style="z-index: 10"><a href="javascript:void(0);" onclick="popupOpenFd('popFd',1);" class="add_food">Add Food</a>
            </td>
            
          <td><?php echo $breakfst_svn['calorie'];?></td>
          <td><?php echo $breakfst_svn['carb'];?></td>
          <td><?php echo $breakfst_svn['fat'];?></td>
          <td><?php echo $breakfst_svn['protein'];?></td>
          <td><?php echo $breakfst_svn['mineral'];?></td>
          <td><?php echo $breakfst_svn['vitamin'];?></td>
          <td></td>
        </tr>-->
        <tr class="meal_header">
          <td class="first alt">Lunch</td>
        </tr>
        
          <?php 
          
          foreach($logdata as $logdatas)
        {
           
           if($logdatas['AdddailyNutritionDiary']['food_type']=='Lunch')
           {
           	
           	    $lunch_svn['calorie']=$lunch_svn['calorie']+(($logdatas['AdddailyNutritionDiary']['calorie'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$lunch_svn['carb']=$lunch_svn['carb']+(($logdatas['AdddailyNutritionDiary']['carb'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$lunch_svn['fat']=$lunch_svn['fat']+(($logdatas['AdddailyNutritionDiary']['fat'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$lunch_svn['protein']=$lunch_svn['protein']+(($logdatas['AdddailyNutritionDiary']['protein'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$lunch_svn['mineral']=$lunch_svn['mineral']+(($logdatas['AdddailyNutritionDiary']['mineral'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$lunch_svn['vitamin']=$lunch_svn['vitamin']+(($logdatas['AdddailyNutritionDiary']['vitamin'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	
            	$total_svn['calorie']=$total_svn['calorie']+(($logdatas['AdddailyNutritionDiary']['calorie'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['carb']=$total_svn['carb']+(($logdatas['AdddailyNutritionDiary']['carb'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['fat']=$total_svn['fat']+(($logdatas['AdddailyNutritionDiary']['fat'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['protein']=$total_svn['protein']+(($logdatas['AdddailyNutritionDiary']['protein'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['mineral']=$total_svn['mineral']+(($logdatas['AdddailyNutritionDiary']['mineral'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['vitamin']=$total_svn['vitamin']+(($logdatas['AdddailyNutritionDiary']['vitamin'])*($logdatas['AdddailyNutritionDiary']['quantity']));
        ?>
        <tr>
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729276" data-locale="" href="#"><?php echo $logdatas['AdddailyNutritionDiary']['food_name'].'('.$logdatas['AdddailyNutritionDiary']['quantity'].')';?></a></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['calorie'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['carb'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['fat'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['protein'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['mineral'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['vitamin'];?></td>
          <!--<td class="delete"><a href="javascript:void(0);" onclick="deletefood(<?php //echo $logdatas['AdddailyNutritionDiary']['id'];?>);"><i class="icon-minus-sign"></i></a></td>-->
        </tr>
        <?php }
        }?>
        
        <!--<tr class="bottom">
          <td class="first alt" style="z-index: 9"><a href="javascript:void(0);" onclick="popupOpenFd('popFd',2);" class="add_food">Add Food</a>
            
          </td>
         <td><?php echo $lunch_svn['calorie'];?></td>
          <td><?php echo $lunch_svn['carb'];?></td>
          <td><?php echo $lunch_svn['fat'];?></td>
          <td><?php echo $lunch_svn['protein'];?></td>
          <td><?php echo $lunch_svn['mineral'];?></td>
          <td><?php echo $lunch_svn['vitamin'];?></td>
          <td></td>
        </tr>-->
        <tr class="meal_header">
          <td class="first alt">Dinner</td>
        </tr>
           <?php foreach($logdata as $logdatas)
        {
           
           if($logdatas['AdddailyNutritionDiary']['food_type']=='Dinner')
           {
           	 $dinner_svn['calorie']=$dinner_svn['calorie']+(($logdatas['AdddailyNutritionDiary']['calorie'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$dinner_svn['carb']=$dinner_svn['carb']+(($logdatas['AdddailyNutritionDiary']['carb'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$dinner_svn['fat']=$dinner_svn['fat']+(($logdatas['AdddailyNutritionDiary']['fat'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$dinner_svn['protein']=$dinner_svn['protein']+(($logdatas['AdddailyNutritionDiary']['protein'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$dinner_svn['mineral']=$dinner_svn['mineral']+(($logdatas['AdddailyNutritionDiary']['mineral'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$dinner_svn['vitamin']=$dinner_svn['vitamin']+(($logdatas['AdddailyNutritionDiary']['vitamin'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	
            	$total_svn['calorie']=$total_svn['calorie']+(($logdatas['AdddailyNutritionDiary']['calorie'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['carb']=$total_svn['carb']+(($logdatas['AdddailyNutritionDiary']['carb'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['fat']=$total_svn['fat']+(($logdatas['AdddailyNutritionDiary']['fat'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['protein']=$total_svn['protein']+(($logdatas['AdddailyNutritionDiary']['protein'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['mineral']=$total_svn['mineral']+(($logdatas['AdddailyNutritionDiary']['mineral'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['vitamin']=$total_svn['vitamin']+(($logdatas['AdddailyNutritionDiary']['vitamin'])*($logdatas['AdddailyNutritionDiary']['quantity']));
        ?>
        <tr>
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729276" data-locale="" href="#"><?php echo $logdatas['AdddailyNutritionDiary']['food_name'].'('.$logdatas['AdddailyNutritionDiary']['quantity'].')';?></a></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['calorie'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['carb'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['fat'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['protein'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['mineral'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['vitamin'];?></td>
         <!-- <td class="delete"><a href="javascript:void(0);" onclick="deletefood(<?php //echo $logdatas['AdddailyNutritionDiary']['id'];?>);"><i class="icon-minus-sign"></i></a></td>-->
        </tr>
        <?php }
        }?>
        <!--<tr class="bottom">
          <td class="first alt" style="z-index: 8"><a href="javascript:void(0);" onclick="popupOpenFd('popFd',3);" class="add_food">Add Food</a>
            </td>
       <td><?php echo $dinner_svn['calorie'];?></td>
          <td><?php echo $dinner_svn['carb'];?></td>
          <td><?php echo $dinner_svn['fat'];?></td>
          <td><?php echo $dinner_svn['protein'];?></td>
          <td><?php echo $dinner_svn['mineral'];?></td>
          <td><?php echo $dinner_svn['vitamin'];?></td>
          <td></td>
        </tr>-->
        <tr class="meal_header">
          <td class="first alt">Snacks</td>
        </tr>
          <?php foreach($logdata as $logdatas)
        {
           
           if($logdatas['AdddailyNutritionDiary']['food_type']=='Snacks')
           {
           	
           		 $snacks_svn['calorie']=$snacks_svn['calorie']+(($logdatas['AdddailyNutritionDiary']['calorie'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$snacks_svn['carb']=$snacks_svn['carb']+(($logdatas['AdddailyNutritionDiary']['carb'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$snacks_svn['fat']=$snacks_svn['fat']+(($logdatas['AdddailyNutritionDiary']['fat'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$snacks_svn['protein']=$snacks_svn['protein']+(($logdatas['AdddailyNutritionDiary']['protein'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$snacks_svn['mineral']=$snacks_svn['mineral']+(($logdatas['AdddailyNutritionDiary']['mineral'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$snacks_svn['vitamin']=$snacks_svn['vitamin']+(($logdatas['AdddailyNutritionDiary']['vitamin'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	
            	$total_svn['calorie']=$total_svn['calorie']+(($logdatas['AdddailyNutritionDiary']['calorie'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['carb']=$total_svn['carb']+(($logdatas['AdddailyNutritionDiary']['carb'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['fat']=$total_svn['fat']+(($logdatas['AdddailyNutritionDiary']['fat'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['protein']=$total_svn['protein']+(($logdatas['AdddailyNutritionDiary']['protein'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['mineral']=$total_svn['mineral']+(($logdatas['AdddailyNutritionDiary']['mineral'])*($logdatas['AdddailyNutritionDiary']['quantity']));
            	$total_svn['vitamin']=$total_svn['vitamin']+(($logdatas['AdddailyNutritionDiary']['vitamin'])*($logdatas['AdddailyNutritionDiary']['quantity']));
        ?>
        <tr>
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729276" data-locale="" href="#"><?php echo $logdatas['AdddailyNutritionDiary']['food_name'].'('.$logdatas['AdddailyNutritionDiary']['quantity'].')';?></a></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['calorie'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['carb'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['fat'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['protein'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['mineral'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['vitamin'];?></td>
         <!-- <td class="delete"><a href="javascript:void(0);" onclick="deletefood(<?php //echo $logdatas['AdddailyNutritionDiary']['id'];?>);"><i class="icon-minus-sign"></i></a></td>-->
        </tr>
        <?php }
        }?>
        <!--<tr class="bottom">
          <td class="first alt" style="z-index: 7"><a href="javascript:void(0);" onclick="popupOpenFd('popFd',4);" class="add_food">Add Food</a>
            </td>
          <td><?php echo $snacks_svn['calorie'];?></td>
          <td><?php echo $snacks_svn['carb'];?></td>
          <td><?php echo $snacks_svn['fat'];?></td>
          <td><?php echo $snacks_svn['protein'];?></td>
          <td><?php echo $snacks_svn['mineral'];?></td>
          <td><?php echo $snacks_svn['vitamin'];?></td>
          <td></td>
        </tr>-->
        <tr class="spacer">
          <td class="first" colspan="6">&nbsp;</td>
          <td class="empty">&nbsp;</td>
        </tr>
       
        <tr class="total">
          <td class="first">Totals</td>
          <td><?php echo $total_svn['calorie'];?></td>
          <td><?php echo $total_svn['carb'];?></td>
          <td><?php echo $total_svn['fat'];?></td>
          <td><?php echo $total_svn['protein'];?></td>
          <td><?php echo $total_svn['mineral'];?></td>
          <td><?php echo $total_svn['vitamin'];?></td>
          <td class="empty"></td>
        </tr>
     
     
      </tbody>
      <tfoot>
        <tr>
          <td class="first"></td>
          <td class="alt">Calories</td>
          <td class="alt">Carbs</td>
          <td class="alt">Fat</td>
          <td class="alt">Protein</td>
          <td class="alt">Mineral</td>
          <td class="alt">Vitamin</td>
          <td class="empty"></td>
        </tr>
      </tfoot>
    </table>
  </div>
  <!-- / .table-container -->
  
  <div id="complete_day"> <span class="day_incomplete_message"><!-- When you're finished logging all foods and exercise for this day, click here: <br>-->
    <br>
    <!--<a href="/food/day_complete?date=2014-04-03" class="button complete-this-day-button">Complete This Entry</a>--> </span> </div>
  
  

</div>
           
           
          </div> 
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
                
    <!-- Food Popup  -->
                <div id="popFd" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popFd');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                       
                        
                        
                        <form id="addffod" action="" method="POST" onsubmit="return validatefrmsfd();">
      
        <h2>Add Food</h2>
         <div class="loaderResultFd" style="display: none;"><img src="<?php echo $config['url'];?>images/ajax-loader.gif"></div> <div style="color:#ff0000; padding:4px 0 4px 0;" id="notificatin_mesFd"></div>
         <input type="hidden" name="client_id" id="client_id" value="<?php echo $clientid;?>"/>
            <div class="row">
              <div class="twelve form-select columns">
                <select class="validate[required]" onchange="document.getElementById('customSelectFD').value= this.options[this.selectedIndex].text; foodlist(this.value);" id="food_type" name="food_type">
                  <option value="" >Select Food Type</option>
                  <option value="Breakfast" selected="selected">Breakfast</option>
                  <option value="Lunch">Lunch</option>
                  <option value="Snacks">Snacks</option>
                  <option value="Dinner">Dinner</option>
                </select>
                <input type="text" value="Breakfast" id="customSelectFD">
              </div>
            </div>
            
           <div class="row">
              <div class="twelve form-select columns">
                <select class="validate[required]" onchange="document.getElementById('customSelectFDList').value= this.options[this.selectedIndex].text; " id="food_list" name="food_list">
                  <option value="" >Select Food</option>
                  <?php foreach($breakfasts as $breakfast){?>
                  <option value="<?php echo $breakfast['FoodNutritionLog']['name'];?>" ><?php echo $breakfast['FoodNutritionLog']['name'];?></option>
                  <?php }?>
                 
                </select>
                <input type="text" value="Select Food" id="customSelectFDList">
              </div>
            </div>  
            
            <div class="row">
              <div class="twelve form-select columns">
                <select class="validate[required]" onchange="document.getElementById('customSelectFDListQt').value= this.options[this.selectedIndex].text; " id="food_qty" name="food_qty">
                  <option value="" >Select Quantity</option>
                 <?php for($i=1;$i<=5;$i++){?>
                  <option value="<?php echo $i;?>"><?php echo $i;?></option>
                  <?php }?>
                </select>
                <input type="text" value="Select Quantity" id="customSelectFDListQt">
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
                <!-- Food Popup  End -->                            
