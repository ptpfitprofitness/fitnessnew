<?php
$database_host='localhost';
$database_name='db_fitness5787';
$database_user='root';
$database_password='YFqbOggr7ca';

// Create connection
$conn = mysql_connect($database_host, $database_user, $database_password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysql_connect_error());
}
	$sdb=mysql_select_db($database_name,$conn);
	
	



?>