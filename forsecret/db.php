<?php
$host = '<--!localhost-->';
$user = '<--!root-->';
$password = '<--!password-->';
$db = '<--!forplay-->';

$link = mysqli_connect($host, $user, $password, $db);

Global $events;

$events = array();

if (mysqli_connect_errno()) {
    $events['mysql'] = array(
            'connection' => false,
            'error' => mysqli_connect_error(),
            'code' => mysqli_connect_errno()
    );
} else {
    $events['mysql'] = array(
            'connection' => true
    );
}

$utf_sql = "SET character_set_results = 'utf8', 
				character_set_client = 'utf8', 
				character_set_connection = 'utf8', 
				character_set_database = 'utf8', 
				character_set_server = 'utf8';";

mysqli_query($link, $utf_sql);

include ('oauth.php');
?>