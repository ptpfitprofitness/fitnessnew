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
<style>
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
     <?php echo $this->element('lefttrainee');?>
      <div class="eight inside-head columns">
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/plate-cutlery.png"></span>Nutrition Log</a></li>
        
        </ul>    
        
        <ul class="profile-tabs-list mobile-tab clearfix">
          <li class="mobile-tab-list"><a href="#Profile" class="active"><span class="profile-ico"></span>Profile</a></li>
          <div class="twelve columns profile-change-pictext">
           <div class="clear">&nbsp;</div>
           <div class="clear"></div>
           <div id="mfood" class="clearfix">
           <div id="food-diary" ><div class="diary">
    <h1>Your Food Diary For:</h1>
    <div id="date_controls">
      <form accept-charset="UTF-8" action="/food/diary/ydixit" class="date-controls-form" method="post">
        <div style="margin:0;padding:0;display:inline">
          <input name="utf8" type="hidden" value="&#x2713;" />
          <input name="authenticity_token" type="hidden" value="FG97pcCDXOgMfYKQNJIuHA2CkmmGmynuwiyWbvVfptU=" />
        </div>
        <span class="date"> <a href="javascript:void(0);" class="prev"> <i class="icon-caret-left"></i> </a> Thursday, April 3, 2014 <a href="javascript:void(0);" class="next"> <i class="icon-caret-right"></i> </a></span>
        <input type="hidden" value="2014-04-03" name="hidden_date_selector"  id="date_selector" />
        <i class="icon-calendar" id="datepicker-trigger"></i>
      </form>
    </div>
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
          <td class="alt">Sodium</td>
          <td class="alt">Sugar</td>
        </tr>
        <tr>
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729276" data-locale="" href="#">Milk - Chocolate, 1 cup</a></td>
          <td>208</td>
          <td>26</td>
          <td>8</td>
          <td>8</td>
          <td>150</td>
          <td>24</td>
          <td class="delete9"></td>
        </tr>
        <tr>
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729277" data-locale="" href="#">Dosa - Dosa, 1 pieces</a></td>
          <td>80</td>
          <td>17</td>
          <td>0</td>
          <td>2</td>
          <td>0</td>
          <td>0</td>
          <td class="delete9"></td>
        </tr>
        <tr class="bottom">
          <td class="first alt" style="z-index: 10"></td>
          <td>288</td>
          <td>43</td>
          <td>8</td>
          <td>10</td>
          <td>150</td>
          <td>24</td>
          <td></td>
        </tr>
        <tr class="meal_header">
          <td class="first alt">Lunch</td>
        </tr>
         <tr>
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729276" data-locale="" href="#">Milk - Chocolate, 1 cup</a></td>
          <td>208</td>
          <td>26</td>
          <td>8</td>
          <td>8</td>
          <td>150</td>
          <td>24</td>
         <td class="delete9"></td>
        </tr>
        <tr>
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729277" data-locale="" href="#">Dosa - Dosa, 1 pieces</a></td>
          <td>80</td>
          <td>17</td>
          <td>0</td>
          <td>2</td>
          <td>0</td>
          <td>0</td>
         <td class="delete9"></td>
        </tr>
        <tr class="bottom">
          <td class="first alt" style="z-index: 10"></td>
          <td>288</td>
          <td>43</td>
          <td>8</td>
          <td>10</td>
          <td>150</td>
          <td>24</td>
          <td></td>
        </tr>
        <tr class="bottom">
          <td class="first alt" style="z-index: 9"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td></td>
        </tr>
        <tr class="meal_header">
          <td class="first alt">Dinner</td>
        </tr>
         <tr>
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729276" data-locale="" href="#">Milk - Chocolate, 1 cup</a></td>
          <td>208</td>
          <td>26</td>
          <td>8</td>
          <td>8</td>
          <td>150</td>
          <td>24</td>
          <td class="delete9"></td>
        </tr>
        <tr>
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729277" data-locale="" href="#">Dosa - Dosa, 1 pieces</a></td>
          <td>80</td>
          <td>17</td>
          <td>0</td>
          <td>2</td>
          <td>0</td>
          <td>0</td>
          <td class="delete9"></td>
        </tr>
        <tr class="bottom">
          <td class="first alt" style="z-index: 10"></td>
          <td>288</td>
          <td>43</td>
          <td>8</td>
          <td>10</td>
          <td>150</td>
          <td>24</td>
          <td></td>
        </tr>
        <tr class="bottom">
          <td class="first alt" style="z-index: 8"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td></td>
        </tr>
        <tr class="meal_header">
          <td class="first alt">Snacks</td>
        </tr>
         <tr>
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729276" data-locale="" href="#">Milk - Chocolate, 1 cup</a></td>
          <td>208</td>
          <td>26</td>
          <td>8</td>
          <td>8</td>
          <td>150</td>
          <td>24</td>
         <td class="delete9"></td>
        </tr>
        <tr>
          <td class="first alt"><a class="js-show-edit-food" data-food-entry-id="4337729277" data-locale="" href="#">Dosa - Dosa, 1 pieces</a></td>
          <td>80</td>
          <td>17</td>
          <td>0</td>
          <td>2</td>
          <td>0</td>
          <td>0</td>
          <td class="delete9"></td>
        </tr>
        <tr class="bottom">
          <td class="first alt" style="z-index: 10"></td>
          <td>288</td>
          <td>43</td>
          <td>8</td>
          <td>10</td>
          <td>150</td>
          <td>24</td>
          <td></td>
        </tr>
        <tr class="bottom">
          <td class="first alt" style="z-index: 7"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td></td>
        </tr>
        <tr class="spacer">
          <td class="first" colspan="6">&nbsp;</td>
          <td class="empty">&nbsp;</td>
        </tr>
        <tr class="total">
          <td class="first">Totals</td>
          <td>288</td>
          <td>43</td>
          <td>8</td>
          <td>10</td>
          <td>150</td>
          <td>24</td>
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
          <td class="alt">Sodium</td>
          <td class="alt">Sugar</td>
          <td class="empty"></td>
        </tr>
      </tfoot>
    </table>
  </div>
  <!-- / .table-container -->
  
  <div id="complete_day"> <span class="day_incomplete_message"> When you're finished logging all foods and exercise for this day, click here: <br>
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