<?php

if (!empty($_FILES)) {

	echo $_path_ = str_replace("//", "/", $_SERVER['DOCUMENT_ROOT'].'/'.$_REQUEST['folder']);

	echo $_file_ext_ = end(explode(".", $_FILES['Filedata']['name']));
exit;
	$_new_file_name = time().'.'.$_file_ext_;

	echo $_path_ . $_new_file_name;

	move_uploaded_file('../../uploads/'.$_new_file_name, $_FILES['Filedata']['tmp_name']);

	//move_uploaded_file($_path_ . $_new_file_name, $_FILES['Filedata']['tmp_name']);

	echo $_new_file_name;

}

?>