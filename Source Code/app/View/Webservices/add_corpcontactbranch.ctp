<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		02/04/2014
##  Description :		It is use for Corporation Contact My Branch - add corporation contact branch web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/add_corpcontactbranch
/* Post fields
id
Subuser
usertype
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