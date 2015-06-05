<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		20/03/2014
##  Description :		It is use for nutritional guide web service use with POST Method.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/nutrionalguiderq/

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