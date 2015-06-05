<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		11/04/2014
##  Description :		It is use for Club/club branch trainer fetch web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/manage_trainer
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