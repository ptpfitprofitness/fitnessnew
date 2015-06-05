<?php
if(!empty($groupData))
{
		echo '<div style="width:100%;float:left;margin-left:6px;border:1px solid #e5e5e5;">';
		echo '<div style="width:50%;float:left;border:1px solid #e5e5e5;padding:5px; height: 40px;"><b>Client Name</b></div>';
		/*echo '<div style="width:30%;float:left;border:1px solid #e5e5e5;padding:5px; height: 40px;"><b>Session Type</b></div>';*/
		echo '<div style="width:50%;float:left;border:1px solid #e5e5e5;padding:5px; height: 40px;"><b>Sessions Purchased / Sessions Used</b></div>';
		foreach($groupData as $groupdetaildata)
		{
			echo '<div style="width:50%;float:left;border:1px solid #e5e5e5;padding:5px">';
			if($groupdetaildata['GroupMember']['client_name']!='')
			{
				echo '<span>'.$groupdetaildata['GroupMember']['client_name'].'</span><br/><br/>';
			}
			echo '</div>';
			/*echo '<div style="width:30%;float:left;border:1px solid #e5e5e5;padding:5px">';
			echo '<span>'.$groupdetaildata['workout']['workout_name'].'</span><br/><br/>';
			echo '</div>';*/
			if($groupdetaildata['session_purchase']['no_of_booked']=='')
			{
				$groupdetaildata['session_purchase']['no_of_booked'] = 0;
			}
			if($groupdetaildata['session_purchase']['no_of_purchase']=='')
			{
				$groupdetaildata['session_purchase']['no_of_purchase'] = 0;
			}
			echo '<div style="width:50%;float:left;border:1px solid #e5e5e5;padding:5px">';
			echo '</span>'.$groupdetaildata['session_purchase']['no_of_purchase'].' / '.$groupdetaildata['session_purchase']['no_of_booked'].'</span><br/><br/>';	
			echo '</div>';
		}
		echo'  </div>';
	
}
?>

