<?php
if(isset($response) && $response!='1')
{
	if(!empty($response))
	{
	$rtstring='<option value="">Select Food</option>';
	foreach ($response as $key=>$val)
	{
		$rtstring .='<option value="'.$val['FoodUsda']['name'].'">'.$val['FoodUsda']['name'].'</option>';
	   
	}
	echo $rtstring;
	}else {
		echo '1';	
	}
}
else {
  echo '1';	
}
?>