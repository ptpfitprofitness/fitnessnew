<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		25/08/2014
##  Description :		It is use for savetestimonial web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/savetestimonial
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