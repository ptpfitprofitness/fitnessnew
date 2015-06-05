<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		20/06/2014
##  Description :		addcertification_trainerAdd.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/addcertification_trainer
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