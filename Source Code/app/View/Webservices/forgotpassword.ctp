<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		11/03/2014
##  Description :		It is use for forgot password web service use with POST Method.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/forgotpassword/armanish3@sampatti.com/Trainer
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