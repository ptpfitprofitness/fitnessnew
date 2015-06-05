<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		04/06/2014
##  Description :		Search Food.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/search_daily_food
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