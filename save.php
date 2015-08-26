<?php
include ("db.php");

if (getenv ( 'REQUEST_METHOD' ) == 'POST') {
	
	/**
	 * In verison 5.6 of PHP ajax calls are no longer in POST.
	 * The request is POST but variables are stored in php://input.
	 */
	
	$json_fortag = file_get_contents ( "php://input" );
	$php_fortag = json_decode ( $json_fortag, true );
	
	/**
	 * Makin some of the optional variable null.
	 * Note for date it is required to bein date format or null.
	 */
	
	$php_fortag ['date'] == '' ? $php_fortag ['date'] = "null" : "'{$php_fortag['date']}'";
	$php_fortag ['subtype'] == '' ? $php_fortag ['subtype'] = "null" : "'{$php_fortag['subtype']}'";
	
	/**
	 * First query is to insert the tag.
	 * Note date and type are some private words in SQL.
	 */
	
	$sql = "INSERT INTO for_tags 
				(bg_name, en_name, tag, `date`, `type`, subtype, object)
			VALUES 
				('{$php_fortag['bgName']}', 
				 '{$php_fortag['enName']}', 
				 '{$php_fortag['tag']}', 
				 {$php_fortag['date']}, 
				 '{$php_fortag['type']}', 
				 {$php_fortag['subtype']}, 
				 '{$php_fortag['object']}');";
	
	/**
	 * Second thing we want to log the changes.
	 * This is done so the admin can review recent updates.
	 * TODO: Until we have user authentication 0 will equal admin.
	 */
	
	$log = "INSERT INTO for_log
				(`event`, `table`, tag, object, user, created, acknowledged)
			VALUES
				('insert',
				 'for_tags',
				 '{$php_fortag['tag']}',
				 '{$php_fortag['object']}',
				 0,
				 now(),
				 null);";
	
	/**
	 * Try the query.
	 */
	
	$result = mysqli_query ( $link, $sql );
	
	/**
	 * Error 1062 is for duplicate of a unique key.
	 * In this case it will hapen when you try to add a tag with the same name.
	 */
	
	if (!$result) {
		$events ['mysql'] ['result'] = false;
		$events ['mysql'] ['code'] = mysqli_errno ( $link );
		$events ['mysql'] ['error'] = mysqli_error ( $link );
	
	/**
	 * If the SQL is successfull just log the event and return true.
	 */
	} else {
		$result = mysqli_query ( $link, $log );
		$events ['mysql'] ['result'] = true;
	}
	
	/**
	 * Send the response back to the browser in JSON format.
	 * And finally close the connection.
	 */
	
	echo json_encode ( array (
			'events' => $events 
	) );
	
	mysqli_close ( $link );
}
?>