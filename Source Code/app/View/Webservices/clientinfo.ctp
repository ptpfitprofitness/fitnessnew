<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		12/04/2014
##  Description :		It is use for Club - Client Info web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/clientinfo
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