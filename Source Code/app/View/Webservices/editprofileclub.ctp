<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		15/04/2014
##  Description :		It is use for Edit Profile web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/editprofileclub/

/* Post fields
id
Subuser
usertype
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