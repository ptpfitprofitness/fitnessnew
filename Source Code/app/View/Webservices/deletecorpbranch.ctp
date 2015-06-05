<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		11/04/2014
##  Description :		It is use for Club Client List fetch web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/deletecorpbranch
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