<?php
	if (!empty($_FILES)) 
	{
		$position = $_REQUEST['position'];
		$_path_   = "/home/synapsei/public_html/uploads/";
		$_new_file_name = time().str_replace(" ","_",$_FILES['Filedata']['name']);
	
		$fileTypes = array('doc','docx','pdf','txt'); // File extensions
		$fileParts = pathinfo($_FILES['Filedata']['name']);
		
		if (in_array($fileParts['extension'],$fileTypes)) 
		{
			move_uploaded_file($_FILES['Filedata']['tmp_name'], $_path_. $_new_file_name);
			echo $_new_file_name;
		}else {
			echo 'Please upload document file only.';
		}
	} 
?>
