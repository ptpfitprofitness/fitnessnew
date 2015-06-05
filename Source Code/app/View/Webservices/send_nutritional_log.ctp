<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		29/05/2014
##  Description :		It is use for sending nutritional log.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/send_nutritional_log
/* Post fields
id
Subuser
usertype

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