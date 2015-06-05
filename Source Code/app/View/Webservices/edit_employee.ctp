<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		02/04/2014
##  Description :		It is use for Corporation My Employee- edit_employee gui fetch web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/edit_employee
/* Post fields
id
Subuser
usertype
employee_id
branch_id
designation
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
mobile

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