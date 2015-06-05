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
    <!-- <script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
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
				 // bk('#pp').daterangepicker({arrows:false}); 
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
		$('#srchfd').css('display','block');
		$('#serving').css('display','none');
		$('#search_food').val('');
	} 
	
function foodlist(str)
{
//food_list
	
 if(str!='')
 {
 	   	$.ajax({
				url:"<?php echo $config['url'];?>trainees/foodlist/",
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

function validateserachfood()
{
	 $('.loaderResultFd').show();
	 
	 //var range=$('#rangeA').val();
	 
		var search_food  = $('#search_food').val();
		
	  if(search_food!='' ){
		
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		 var website_url ='<?php echo $config['url']?>trainees/search_daily_food';
				$.ajax({
				type:"POST",
				url: website_url,
				data: "search_food="+search_food,
				//dataType: "json",
				beforeSend: function(){$('.loaderResultFd').show()},
				
		   		success: function(e)
					{
						
						
						if(e!='1')
						{
							$('#food_list').html(e);
							
						}
						
						$('.loaderResultFd').hide();			
						
					}
				});	
		return false;
		}
	return false;
}

function searchfood()
{
	 	var search_food_new=$( "#search_food" ).val();
		 var website_url ='<?php echo $config['url']?>trainees/search_food';
				$.ajax({
				type:"POST",
				url: website_url,
				data: "search_food_new="+search_food_new,
				dataType: "json",
				//beforeSend: function(){$('.loaderResultFd').show()},
				
		   		success: function(data)
					{
						
						 response($.map(data, function(item) {
                    return { 
                        label: item.name,
                        value: item.name
                        };
                    }));
								
					}	
					
				});	
		
	
}

 $(function() {
var availableTags = [


];
/*$( "#search_food" ).autocomplete({
source: searchfood()
});*/

$("#search_food").autocomplete({
     minLength: 3 ,
     source: function(request, response, url){
                var searchParam  = request.term;

    $.ajax({
              url: '<?php echo $config['url']?>trainees/search_food/?searchParam='+searchParam,
             data : searchParam,
             dataType: "json",
            type: "GET",
            success: function (data) {
                    response($.map(data, function(item) {
                return { label: item, value: item, id: item };
                        }));
                    }
            });//ajax ends 
            },
    select: function( event, ui ) {
    	servingfn(ui.item.label);
    	

           
        }        
 }); //autocomplete ends



});

function servingfn(str)
{
	if(str!='')
	{
		
		$('#foodhd').html(str);
		$('#food_list').val(str);
		$('#srchfd').css('display','none');
		$('#serving').css('display','block');
		
		$.ajax({
              url: '<?php echo $config['url']?>trainees/food_serv',
             data : 'searchParam='+str,
             dataType: "json",
            type: "POST",
            success: function (e) {
            	if(e.length!=0)
            	{
					var valsz=e.FoodUsda.gmwtdesc1;
					$('#food_gmwt').html('');
					$('#food_gmwt').html('<option value="'+valsz+'">'+valsz+'</option>');
					$('#customSelectFDListQtGm').val(valsz);
            	}
					/*var response = eval(' ( '+e+' ) ');
					alert(response);*/
					
					
				}
            });//ajax ends 
		
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
	  var food_gmwt  = $('#food_gmwt').val();
	
	
		if(range!='' && food_type!='' && food_list!='' && food_qty!='' && client_id!='' && food_gmwt!=''){
		
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		 var website_url ='<?php echo $config['url']?>home/add_daily_diary';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "food_type="+food_type+"&food_list="+food_list+"&food_qty="+food_qty+"&client_id="+client_id+"&fooddate="+range+"&food_gmwt="+food_gmwt,
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

function setvl(str)
{
	$('#search_food').val(str);
	$('#customSelectFDList').val(str);
	
	var opval='<option value="'+str+'">'+str+'</option>';
	$('#food_list').html(opval);
	$('#target_container2').css('display','none');
	//$('#search_food').val(str);
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
input {width: 196px; height: 1.1em; display:block;}
#calendar table{border:none;}
input #rangeA {width: 196px; height: 2.6em; display:block; border:none;}
.dpckr{margin-top:25px;}
/*.ui-widget-content{display:none;}*/
.diary{height:auto !important;}
.submit-nav{height:auto !important;}
#ui-id-1{display:block;  width: 231px;
    z-index: 2147483647;
 height: 250px;
    left: 384px;
    overflow-x: hidden;
    overflow-y: scroll;  
    text-align: left;
    font-size:12px;

}
#ui-id-1 li:nth-child(odd)
{
background:none repeat scroll 0 0 #F1F6FB;
}
#ui-id-1 li:nth-child(even)
{
background:none repeat scroll 0 0 #DDE6F4;
}
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
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/plate-cutlery.png"></span>Manage Nutrition Log</a></li>
        
        </ul>    
        
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
          <div class="twelve columns profile-change-pictext">
           <div class="clear">&nbsp;</div>
           <div class="clear"><h2>Coming Soon.</h2></div>
           <div id="mfood" class="clearfix" style="display:none;">
           <div id="food-diary" ><div class="diary">
    <h1>Your Food Diary For:</h1>
    
    <div class="dpckr">

		<input  value="<?php echo $datva;?>" id="rangeA" type="text" readonly="readonly">	
		
		</div>
	<!--	<a onclick="rpPickers.show();" href="javascript:void(0);" id="pp">Specific Date</a>-->
		
		
		
		
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
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729276" data-locale="" href="#"><?php echo $logdatas['AdddailyNutritionDiary']['food_name'].'('.$logdatas['AdddailyNutritionDiary']['quantity'].'-'.$logdatas['AdddailyNutritionDiary']['food_gmwt'].')';?></a></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['calorie'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['carb'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['fat'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['protein'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['mineral'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['vitamin'];?></td>
          <td class="delete"><a href="javascript:void(0);" onclick="deletefood(<?php echo $logdatas['AdddailyNutritionDiary']['id'];?>);"><i class="icon-minus-sign"></i></a></td>
        </tr>
        <?php }
        }?>
        <tr class="bottom">
          <td colspan="6" class="first alt" style="z-index: 10"><a href="javascript:void(0);" onclick="popupOpenFd('popFd',1);" class="add_food">Add Food</a>
            </td>
        
          
        </tr>
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
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729276" data-locale="" href="#"><?php echo $logdatas['AdddailyNutritionDiary']['food_name'].'('.$logdatas['AdddailyNutritionDiary']['quantity'].'-'.$logdatas['AdddailyNutritionDiary']['food_gmwt'].')';?></a></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['calorie'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['carb'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['fat'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['protein'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['mineral'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['vitamin'];?></td>
          <td class="delete"><a href="javascript:void(0);" onclick="deletefood(<?php echo $logdatas['AdddailyNutritionDiary']['id'];?>);"><i class="icon-minus-sign"></i></a></td>
        </tr>
        <?php }
        }?>
        <tr class="bottom">
          <td colspan="6" class="first alt" style="z-index: 9"><a href="javascript:void(0);" onclick="popupOpenFd('popFd',2);" class="add_food">Add Food</a>
            
          </td>
          </tr>
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
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729276" data-locale="" href="#"><?php echo $logdatas['AdddailyNutritionDiary']['food_name'].'('.$logdatas['AdddailyNutritionDiary']['quantity'].'-'.$logdatas['AdddailyNutritionDiary']['food_gmwt'].')';?></a></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['calorie'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['carb'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['fat'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['protein'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['mineral'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['vitamin'];?></td>
           <td class="delete"><a href="javascript:void(0);" onclick="deletefood(<?php echo $logdatas['AdddailyNutritionDiary']['id'];?>);"><i class="icon-minus-sign"></i></a></td>
        </tr>
        <?php }
        }?>
        <tr class="bottom">
          <td class="first alt" style="z-index: 8"><a href="javascript:void(0);" onclick="popupOpenFd('popFd',3);" class="add_food">Add Food</a>
            </td>
            </tr>
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
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729276" data-locale="" href="#"><?php echo $logdatas['AdddailyNutritionDiary']['food_name'].'('.$logdatas['AdddailyNutritionDiary']['quantity'].'-'.$logdatas['AdddailyNutritionDiary']['food_gmwt'].')';?></a></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['calorie'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['carb'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['fat'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['protein'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['mineral'];?></td>
          <td><?php echo $logdatas['AdddailyNutritionDiary']['quantity']*$logdatas['AdddailyNutritionDiary']['vitamin'];?></td>
           <td class="delete"><a href="javascript:void(0);" onclick="deletefood(<?php echo $logdatas['AdddailyNutritionDiary']['id'];?>);"><i class="icon-minus-sign"></i></a></td>
        </tr>
        <?php }
        }?>
         <tr class="bottom">
          <td colspan="6" class="first alt" style="z-index: 7"><a href="javascript:void(0);" onclick="popupOpenFd('popFd',4);" class="add_food">Add Food</a>
            </td>
            </tr>
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
     <!--   <tr class="total alt">
          <td class="first">Your Daily Goal </td>
          <td> 1,270</td>
          <td> 159</td>
          <td> 42</td>
          <td> 64</td>
          <td> 2,300</td>
          <td> 48</td>
          <td class="empty"></td>
        </tr>
        <tr class="total remaining">
          <td class="first">Remaining</td>
          <td class="positive"> 982 </td>
          <td class="positive"> 116 </td>
          <td class="positive"> 34 </td>
          <td class="positive"> 54 </td>
          <td class="positive"> 2,150 </td>
          <td class="positive"> 24 </td>
          <td class="empty"></td>
        </tr>-->
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
  
  <div id="complete_day"> <span class="day_incomplete_message"> <!--When you're finished logging all foods and exercise for this day, click here: --><br>
    <br>
   <!-- <a href="/food/day_complete?date=2014-04-03" class="button complete-this-day-button">Complete This Entry</a>--> </span> </div>
  
  
 </div>
           
           
          </div> 
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
                
                   <!-- Food Popup  -->
                <div id="popFd" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('popFd');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                  <h2>Add Food</h2>     
          <div id="srchfd">
               <form id="searchfood" action="" method="POST" onsubmit="return validateserachfood();">       
                                
          <div class="row" style="width:66%;">
              <div class="twelve columns">
                 <input type="text" id="search_food" name="search_food" value=""  placeholder="Search Food" />
                 <div style="float:left;height:200px;z-index:9999;overflow-y:scroll;display:none;" id="target_container2">
        
                  </div>
           
              </div>
              <!-- <div class="twelve columns">
              <input type="submit" value="Search" name="" class="submit-nav" style="width:120px;margin-right:10px;background: none repeat scroll 0 0 #5A997C;border-radius: 3px;font-weight:bold">
              </div>-->
            </div> 
            
            
            
                    
            <!-- <div class="twelve already-member columns">
                          <input type="submit" value="Search" name="" class="submit-nav" style="width:120px;margin-right:10px;">
                       </div>   -->  
                       
             </form>  
             </div>        
                  <br/>
                        <form id="addffod" action="" method="POST" onsubmit="return validatefrmsfd();">
      <div id="serving" style="display:none;">
        
         <div class="loaderResultFd" style="display: none;"><img src="<?php echo $config['url'];?>images/ajax-loader.gif"></div> <div style="color:#ff0000; padding:4px 0 4px 0;" id="notificatin_mesFd"></div>
         <input type="hidden" name="client_id" id="client_id" value="<?php echo $this->Session->read('USER_ID');?>"/>
         <input type="hidden" name="fdtype" id="fdtype" value=""/>
         <input type="hidden" name="trainer_id" id="trainer_id" value="<?php echo $trainer_id;?>"/>
         <input type="hidden" name="food_list" id="food_list" value=""/>
           
         
         <div id="foodhd" style="text-align:center;color:#ff0000;font-size:14px;widht:100%">
         
         </div>
         <div class="clear">&nbsp;</div>
        <div  style="text-align:center;color:#0a5282;font-size:13px;">
         How much?
         </div>
           <div class="clear">&nbsp;</div> 
            <div class="row">
            
             <input type="text" name="food_qty" id="food_qty" value="1.0" style="width:100px;float:left;"/> <span style="float:left;padding:10px;">  servings of </span>
            
              <!--<div class="five form-select columns">
                <select class="validate[required]" onchange="document.getElementById('customSelectFDListQt').value= this.options[this.selectedIndex].text; " id="food_qty" name="food_qty">
                 
                 <?php for($i=1;$i<=15;$i++){?>
                  <option value="<?php echo $i;?>"><?php echo $i;?></option>
                  <?php }?>
                </select>
                <input type="text" value="1" id="customSelectFDListQt">
              </div>-->
             
                 <div class="five form-select columns">
                <select class="validate[required]" onchange="document.getElementById('customSelectFDListQtGm').value= this.options[this.selectedIndex].text; " id="food_gmwt" name="food_gmwt">
                  <option value="" >Select</option>
                
                </select>
                <input type="text" value="Select" id="customSelectFDListQtGm">
              </div>
              </div>
              <div class="clear">&nbsp;</div>
               <div  style="text-align:center;color:#0a5282;font-size:13px;">
		        To which meal?
		         </div>
		          <div class="row" style="margin-left: 111px;">
              <div class="six form-select columns">
                <select class="validate[required]" onchange="document.getElementById('customSelectFDListQtTy').value= this.options[this.selectedIndex].text; " id="food_type" name="food_type">
                  <option value="1" selected="selected" >Breakfast</option>
                  <option value="2">Lunch</option>
                  <option value="3">Dinner</option>
                  <option value="4">Snacks</option>
                
                </select>
                <input type="text" value="Breakfast" id="customSelectFDListQtTy">
              </div>
               <div class="twelve already-member columns">
                          <input type="submit" value="Submit" name="" class="submit-nav" style="width:50%;" >
                       </div>
            </div>   
         
       
     </div>
      
    </form>
                        
                        
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Food Popup  End -->     