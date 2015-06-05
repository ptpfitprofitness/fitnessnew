<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		12/04/2014
##  Description :		It is use for Club - Edit Client web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/view_trainer_client
/* Post fields
id


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