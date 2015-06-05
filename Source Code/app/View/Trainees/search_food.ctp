<?php
if(isset($response) && $response!='1')
{
	if(!empty($response))
	{
	$rtstring=array();
	$i=0;
	foreach ($response as $key=>$val)
	{
		
		$rtstring[]=str_replace("'","",$val['FoodUsda']['name']);
	   $i++;
	}
	
	echo json_encode($rtstring);
	}else {
		echo '1';	
	}
}
else {
  echo '1';	
}
?>