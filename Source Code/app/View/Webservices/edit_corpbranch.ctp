<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		02/04/2014
##  Description :		It is use for Corporation My Branch - edit Branch gui fetch web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/edit_corpbranch
/* Post fields
id
Subuser
usertype
branch_name
branch_id
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