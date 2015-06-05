<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		02/04/2014
##  Description :		It is use for Corporation Contact edit web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/edit_corpcontactbranch
/* Post fields
id
Subuser
usertype
contact_id
title
email
phone
mobile
branch_id

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