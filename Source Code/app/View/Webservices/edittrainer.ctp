<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		12/04/2014
##  Description :		It is use for Club - Edit Client web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/edittrainer
/* Post fields
id
Subuser
usertype
branch_id
trainer_id
username
password
email
first_name
last_name
address
city
state
country
zip
phone
mobile
certifications
Bio
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