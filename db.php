<?php
$host = 'localhost';
$user = 'root';
$password = 'Secret123!';
$db = 'forplay';

$link = mysqli_connect($host, $user, $password, $db);

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
	echo "Connection to MySQL successful";
}
?>