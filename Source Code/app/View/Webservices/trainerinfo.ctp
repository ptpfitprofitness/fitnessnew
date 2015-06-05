<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		14/04/2014
##  Description :		It is use for Club - Trainer Info web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/trainerinfo
/* Post fields
id
Subuser
usertype
client_id



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