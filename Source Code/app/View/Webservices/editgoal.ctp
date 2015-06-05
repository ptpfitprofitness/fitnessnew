<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		03/06/2014
##  Description :		Edit Goal.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/editgoal
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