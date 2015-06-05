<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		11/04/2014
##  Description :		It is use for Club - Add branch web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/editbranch
/* Post fields
id
Subuser
usertype
branch_id
username
password
email
branch_name
first_name
last_name
address
city
state
country
zip
phone
notrainer

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