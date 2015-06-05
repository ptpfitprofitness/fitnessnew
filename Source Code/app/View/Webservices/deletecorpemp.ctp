<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		18/04/2014
##  Description :		It is use for Corporation delete employee web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/deletecorpemp
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