<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		22/03/2014
##  Description :		It is use for User remove WebsiteLogo pic web service.
##	Copyright   :       SynapseIndia
## *****************************************************************

//http://www.sampatti.com/fitnessAaland/webservices/removeWebsiteLogoTrainer
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