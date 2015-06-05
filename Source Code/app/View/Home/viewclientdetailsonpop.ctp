<input type="hidden" id="dateA" value="">
<?php
$logo=$config['url'].'images/avtar.png';
echo '<h2>Detail</h2>';
echo ' <div style="width:20%;float:left"><div class="profile-pic9" style="border:1px solid #ccc;">';			
			
				if($setClientArr['Trainee']['photo']!='')
				{				
				echo '<img width="75" height="75" src="'.$config['url'].'uploads/'.$setClientArr['Trainee']['photo'].'" style="border:3px solid #fff;">';
				}
				else 
				{				
					echo '<img width="75" height="75" src="'.$logo.'" style="border:3px solid #fff;">';
				}
			
echo '</div></div>';
if(!empty($groupmemDataAll))
{
	echo '<div style="width:78%;float:left;margin-left:6px;">';
	echo ' <b>Client Name : </b> <span>'.$groupmemDataAll['GroupMember']['client_name'].'</span><br/><br/>';
	echo ' <b>Session Type : </b> <span>'.$sessiontype.'</span><br/><br/>';	
	if($sessionPurchase['SessionPurchase']['no_of_booked']=='')
	{
		$sessionPurchase['SessionPurchase']['no_of_booked'] = 0;
	}
	
	echo ' <b>Completed Session : </b>'; 
	if ($popupschedetail['ScdetailPopup']['completed']==''){echo 0;} else {echo $popupschedetail['ScdetailPopup']['completed'] ;}
	echo '<br />';
	echo ' <b>Complementary Session : </b>';
	if ($popupschedetail['ScdetailPopup']['complimentary']==''){echo 0;} else {echo $popupschedetail['ScdetailPopup']['complimentary'] ;}			
	echo '<br />';
	echo ' <b>Cancel Session : </b>';
	if ($popupschedetail['ScdetailPopup']['cancel']==''){echo 0;} else {echo $popupschedetail['ScdetailPopup']['cancel'] ;}
	echo '<br />';
	echo ' <b>Cancel No Charge Session : </b>';
	if ($popupschedetail['ScdetailPopup']['cancel_no_charge']==''){echo 0;} else {echo $popupschedetail['ScdetailPopup']['cancel_no_charge'] ;}
	echo '<br /><br />';
	
	echo '<b>Date and time : </b><br/> <span>  '.date('m/d/Y h:i:s A', strtotime($sdate)).' to '.date('h:i:s A', strtotime($edate)).' </span><br/><br/>';
	
	echo '<b>Sessions Purchased / Sessions Used : </b>'.$sessionPurchase['SessionPurchase']['no_of_purchase'].' / '.$sessionPurchase['SessionPurchase']['no_of_booked'].'<br/><br/>';
	
	echo '<br />';
	
	//echo "<pre>"; print_r($setGroupClientStatusArr); echo "</pre>";
	if($setGroupClientStatusArr['GroupClientStat']['session_status']!='Completed')
	{	
	echo "<input id=\"oncId\" type=\"button\" name=\"submit\" value=\"Completed\" onclick=\"markcompletedgroupclient('".$groupmemDataAll['GroupMember']['group_id']."','".$groupmemDataAll['GroupMember']['client_id']."','".$groupmemDataAll['GroupMember']['trainer_id']."','".$sessionPurchase['SessionPurchase']['id']."','".$sessionPurchase['SessionPurchase']['session_id']."','".date('Y-m-d H:i:s', strtotime($sdate))."','".date('Y-m-d H:i:s', strtotime($edate))."', '".date('Y-m-d',strtotime($sdate))."');\" class=\"change-pic-nav-button\" style=\"width:121px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	
	
	echo "<input type=\"button\" name=\"submit\" value=\"Complimentary\" onclick=\"markcompgroup('".$groupmemDataAll['GroupMember']['group_id']."','".$groupmemDataAll['GroupMember']['client_id']."','".$groupmemDataAll['GroupMember']['trainer_id']."','".$sessionPurchase['SessionPurchase']['id']."','".$sessionPurchase['SessionPurchase']['session_id']."','".date('Y-m-d H:i:s', strtotime($sdate))."','".date('Y-m-d H:i:s', strtotime($edate))."','".date('Y-m-d',strtotime($sdate))."');\" class=\"change-pic-nav-button\" style=\"width:116px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
						
	echo "<input type=\"button\" name=\"submit\" value=\"Cancel No Charge\" onclick=\"markcancelgroup('".$groupmemDataAll['GroupMember']['group_id']."','".$groupmemDataAll['GroupMember']['client_id']."','".$groupmemDataAll['GroupMember']['trainer_id']."','".$sessionPurchase['SessionPurchase']['id']."','".$sessionPurchase['SessionPurchase']['session_id']."','".date('Y-m-d H:i:s', strtotime($sdate))."','".date('Y-m-d H:i:s', strtotime($edate))."','".date('Y-m-d',strtotime($sdate))."');\" class=\"change-pic-nav-button\" style=\"width:121px;\">&nbsp;&nbsp;&nbsp;&nbsp;";	
	
	if($setGroupClientStatusArr['GroupClientStat']['session_status']!='Cancel Charge')
	{
	echo "<input type=\"button\" name=\"submit\" value=\"Cancel Charged\" onclick=\"markcancel2group('".$groupmemDataAll['GroupMember']['group_id']."','".$groupmemDataAll['GroupMember']['client_id']."','".$groupmemDataAll['GroupMember']['trainer_id']."','".$sessionPurchase['SessionPurchase']['id']."','".$sessionPurchase['SessionPurchase']['session_id']."','".date('Y-m-d H:i:s', strtotime($sdate))."','".date('Y-m-d H:i:s', strtotime($edate))."','".date('Y-m-d',strtotime($sdate))."');\" class=\"change-pic-nav-button\" style=\"width:116px;\">&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	
	/*echo "<input type=\"button\" name=\"submit\" value=\"Delete\" onclick=\"markcancel2group('".$groupmemDataAll['GroupMember']['group_id']."','".$groupmemDataAll['GroupMember']['client_id']."','".$groupmemDataAll['GroupMember']['trainer_id']."','".$sessionPurchase['SessionPurchase']['id']."','".$sessionPurchase['SessionPurchase']['session_id']."','".date('Y-m-d H:i:s', strtotime($sdate))."','".date('Y-m-d H:i:s', strtotime($edate))."');\" class=\"change-pic-nav-button\" style=\"width:116px;\">&nbsp;&nbsp;&nbsp;&nbsp;";*/
	
	
	if(!empty($setGoalArr) || !empty($setWarmupArr) || !empty($setCoreBalancePlyometricArr) || !empty($setSpeedAgilityQuicknessArr) || !empty($setResistenceArr) || !empty($setCoolDownArr))
	{
		//echo "<input type=\"button\" name=\"submit\" value=\"View Workout\" onclick=\"viewwrkt('".$groupmemDataAll['GroupMember']['client_id']."','".$scid."','".date('Y-m-d', strtotime($sdate))."');\" class=\"change-pic-nav-button\" style=\"width:121px;\">";
		echo "<input type=\"button\" name=\"submit\" value=\"View Workout\" onclick=\"editwrktgroupclientInd('".$groupid."','".$scid."','".date('Y-m-d', strtotime($sdate))."','".$groupmemDataAll['GroupMember']['client_id']."');\" class=\"change-pic-nav-button\" style=\"width:121px;\">";
	}
	else
	{
		echo "<input type=\"button\" name=\"submit\" value=\"View Workout\" onclick=\"buildwrktgroupclientInd('".$groupid."','".$scid."','".date('Y-m-d', strtotime($sdate))."','".$groupmemDataAll['GroupMember']['client_id']."');\" class=\"change-pic-nav-button\" style=\"width:121px;\">";
	}
	echo '</div>';
}

?>