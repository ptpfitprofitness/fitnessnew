<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		20/06/2014
##  Description :		deletecertifytrainer.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/deletecertifytrainer
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