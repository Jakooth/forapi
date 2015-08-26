<?php
$host = 'localhost';
$user = 'root';
$password = 'Secret123!';
$db = 'forplay';

$link = mysqli_connect ( $host, $user, $password, $db );
$events = array ();

if (mysqli_connect_errno ()) {
	$events ['mysql'] = array (
			'connection' => false,
			'error' => mysqli_connect_error (),
			'code' => mysqli_connect_errno () 
	);
} else {
	$events ['mysql'] = array (
			'connection' => true 
	);
}
?>