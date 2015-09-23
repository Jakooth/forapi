<?php
include ('db.php');

if (getenv ( 'REQUEST_METHOD' ) == 'GET') {
	$get_tag = isset ( $_GET ['tag'] ) ? "'{$_GET ['tag']}'" : "null";
	$get_tag = isset ( $_GET ['object'] ) ? "'{$_GET ['object']}'" : "null";
	$get_tag = isset ( $_GET ['type'] ) ? "'{$_GET ['type']}'" : "null";
	$get_tag = isset ( $_GET ['subtype'] ) ? "'{$_GET ['subtype']}'" : "null";
}
?>