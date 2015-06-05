<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		12/04/2014
##  Description :		It is use for Club - Edit Client web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/editclient
/* Post fields
id
Subuser
usertype
branch_id
client_id
username
password
email
trainer_id
first_name
last_name
address
city
state
country
zip
phone
mobile
about_us


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