<?php
include ('db.php');

if (getenv ( 'REQUEST_METHOD' ) == 'POST') {
	
	/**
	 * In verison 5.6 of PHP ajax calls are no longer in POST.
	 * The request is POST but variables are stored in php://input.
	 */
	
	$json_fortag = file_get_contents ( "php://input" );
	$php_fortag = json_decode ( $json_fortag, true );
	
	/**
	 * Making some of the optional variable null.
	 * Note for date it is required to being date format or null.
	 */
	
	$php_fortag_bgname = isset ( $php_fortag ['bgName'] ) ? "'{$php_fortag ['bgName']}'" : "null";
	$php_fortag_enname = isset ( $php_fortag ['enName'] ) ? "'{$php_fortag ['enName']}'" : "null";
	$php_fortag_date = isset ( $php_fortag ['date'] ) ? "'{$php_fortag ['date']}'" : "null";
	$php_fortag_subtype = isset ( $php_fortag ['subtype'] ) ? "'{$php_fortag ['subtype']}'" : "null";
	
	/**
	 * First query is to insert the tag.
	 * Note date and type are private words in SQL.
	 */
	
	$tag_sql = "INSERT INTO for_tags 
					(bg_name, en_name, tag, `date`, `type`, subtype, object)
				VALUES 
					($php_fortag_bgname, 
				 	 $php_fortag_enname, 
				 	 '{$php_fortag['tag']}', 
				 	 $php_fortag_date, 
				 	 '{$php_fortag['type']}', 
				 	 $php_fortag_subtype, 
				 	 '{$php_fortag['object']}');";
	
	/**
	 * Second thing we want to log the changes.
	 * This is done so the admin can review recent updates.
	 * TODO: Until we have user authentication 0 will equal admin.
	 */
	
	$log_sql = "INSERT INTO for_log
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
	 * We will execute all queries frist and then submit the transaction.
	 */
	
	mysqli_autocommit ( $link, FALSE );
	
	/**
	 * The most important thing is the tag, so we send it first.
	 * On failure, there is no point to continue and we can have id gaps.
	 */
	
	$tag_result = mysqli_query ( $link, $tag_sql );
	$related_result = true;
	$log_result = true;
	
	if (! $tag_result) {
		$events ['mysql'] ['result'] = false;
		$events ['mysql'] ['code'] = mysqli_errno ( $link );
		$events ['mysql'] ['error'] = mysqli_error ( $link );
	} else {
		
		/**
		 * Next we query the log, but we do not stop on failure.
		 * Note the chance for error here is almost impossible,
		 * Because we generate the values here and not from user input.
		 */
		
		$tag_last = mysqli_insert_id ( $link );
		$log_result = mysqli_query ( $link, $log_sql );
		
		if (! $log_result) {
			$events ['mysql'] ['result'] = false;
			$events ['mysql'] ['code'] = mysqli_errno ( $link );
			$events ['mysql'] ['error'] = mysqli_error ( $link );
		}
		
		/**
		 * Same for related data to objects.
		 * We are using mostly ids from the database.
		 * The chance for an error iv very slick.
		 */
		
		switch ($php_fortag ['object']) {
			case 'game' :
				include ('save_game.php');
				
				break;
			case 'movie' :
				include ('save_movie.php');
				
				break;
			case 'event' :
				include ('save_event.php');
				
				break;
			case 'book' :
				include ('save_book.php');
				
				break;
			case 'person' :
			case 'character' :
			case 'dlc' :
			case 'band' :
				
				/**
				 * Insert every related tag id, but only if there are any.
				 */
				
				if (isset ( $php_fortag ['related'] )) {
					foreach ( $php_fortag ['related'] as $value ) {
						
						/**
						 * Null is not accepted in the DB, but we use it to generate error
						 * and validate empty strings.
						 * Note tags are passed to the user interface from the DB,
						 * so the chance to have a tag withou id near impossible.
						 */
						
						$id = isset ( $value ['tag_id'] ) ? "'{$value['tag_id']}'" : "null";
						
						$related_sql = "INSERT INTO for_rel_relative
											(tag_id, related_tag_id)
										VALUES
											({$tag_last}, {$id});";
						
						$related_result = mysqli_query ( $link, $related_sql );
						
						/**
						 * We end with with the first sign of error.
						 */
						
						if (! $related_result) {
							$events ['mysql'] ['result'] = false;
							$events ['mysql'] ['code'] = mysqli_errno ( $link );
							$events ['mysql'] ['error'] = mysqli_error ( $link );
							
							break;
						}
					}
				}
				
				break;
		}
	}
	
	/**
	 * Only accept the transaction, if all results are successuful.
	 * Note, on rollback auto-increment for successful transfers is not reset.
	 */
	
	if ($tag_result && $log_result && $related_result) {
		$events ['mysql'] ['result'] = true;
		
		mysqli_commit ( $link );
	} else {
		mysqli_rollback ( $link );
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