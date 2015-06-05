<?php
/*echo '<pre>';
//print_r($setSpecalistArr);
print_r($certifications);
echo '</pre>';*/
$logo=$config['url'].'images/avtar.png';
if($this->Session->read('USER_ID'))
{
	
$utype=$this->Session->read('UTYPE');


  if($dbusertype=='Club' || $dbusertype=='Trainer')
  {
  	if($setSpecalistArr[$dbusertype]['logo']!='')
  	{
  		$logo=$config['url'].'uploads/'.$setSpecalistArr[$dbusertype]['logo'];
  	}
  	$uname=$setSpecalistArr[$dbusertype]['full_name'];
  	
  }
  elseif($dbusertype=='Trainee')
  {
  	
  	if($setSpecalistArr[$dbusertype]['photo']!='')
  	{
  		$logo=$config['url'].'uploads/'.$setSpecalistArr[$dbusertype]['photo'];
  	}
  	$uname=$setSpecalistArr[$dbusertype]['full_name'];
  }
  if($dbusertype=='Corporation')
  {
  	$uname=$setSpecalistArr[$dbusertype]['company_name'];
  }	
	//echo $logo;
}
/*
echo"<pre>";
print_r($setSpecalistArr);
echo"</pre>";*/
?>
<style>
.tds th{font-family:'HelveticaLTCondensedRegular';}
</style>
<script type="text/javascript">
function doPrint(tId,sId,pBy)
{
	if(pBy=='Group')
	{
		window.location.href = '<?php echo $config['url']?>home/edit_print_exercise_history_group/'+tId+'/'+sId+'/'+pBy;
	}
	else
	{
		window.location.href = '<?php echo $config['url']?>home/edit_print_exercise_history/'+tId+'/'+sId;
	}
}
</script>
<div style="clear: both; margin-top: 150px; margin-left: 150px; width: 70%;">
<h2>Schedule </h2><br/>
<table class="tds" style="width: 100%;">
  <tr>
     <th>
       Date and Time
     </th>
     <th>
      Title
     </th>
     <th>
       Trainer Name
     </th>
     <th>
       Client Name
     </th>
     <th>
     Status
     </th>
  </tr>
<?php if(!empty($calendarData)){
	foreach($calendarData as $calendarDatas){
	?>

  <tr>
   <td>
       <?php echo date('m/d/Y h:i A',strtotime($calendarDatas['ScheduleCalendar']['start']));?> - <?php echo date('h:i A',strtotime($calendarDatas['ScheduleCalendar']['end']));?>
     </td>
      <td>
     <?php echo $calendarDatas['ScheduleCalendar']['title'];?>
     </td>
      <td>
       <?php echo $calendarDatas['Trainer']['full_name'];?>
     </td>
      <td>
       <?php echo $calendarDatas['Trainee']['full_name'];?>
     </td>
     <td>
     <?php echo $calendarDatas['ScheduleCalendar']['appointment_type'];?>
     </td>
     <td><a style="background: none repeat scroll 0px 0px rgb(90, 153, 124); line-height: 30px; border-radius: 3px; padding: 5px; color: rgb(255, 255, 255); font-size:20px;" href="javascript:void(0);" onclick="doPrint('<?php echo $calendarDatas['ScheduleCalendar']['trainee_id']?>','<?php echo $calendarDatas['ScheduleCalendar']['id']?>','<?php echo $calendarDatas['ScheduleCalendar']['posted_by']?>')">Print</a>
     </td>
  </tr>


<?php 



?>





<?php } ?>

<?php }?></table>

<br/>
<?php 
/*if(isset($setGoalArrs)){

foreach($setGoalArrs as $setGoalArrs)
{
	print_r($setGoalArrs);
}

}*/
?>


</div>