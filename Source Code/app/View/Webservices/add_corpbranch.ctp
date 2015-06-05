<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		02/04/2014
##  Description :		It is use for Corporation My Branch - add branch web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/add_corpbranch
/* Post fields
id
Subuser
usertype
branch_name
username
password
first_name
last_name
email
address
city
state
country
zip
phone
no_trainer

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