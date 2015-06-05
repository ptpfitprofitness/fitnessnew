<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		10/05/2014
##  Description :		It is use for Trainer Workout - add workout web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/add_workout
/* Post fields
id
workout_name
workout_time

*/

if(isset($flagv))
{
	$output['result']="$flagv";
	
}
else {
	$output['result']="EMPTY FIELD";
}
//echo json_encode($output);
echo $flagv;
?>