<?php
include("db.php");

if(getenv('REQUEST_METHOD') == 'POST') {
	$json_fortag = file_get_contents("php://input");
	
	$php_fortag = json_decode($json_fortag, true);
	
	var_dump($php_fortag);
}
?>