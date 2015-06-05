<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		04/06/2014
##  Description :		Search Food.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/add_daily_diary
/*
food_id = means 1,2,3,4  breakfast...

food_list menas foodname

fooddate

trainer_id
client_id
food_qty
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