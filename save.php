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
	$php_fortag_isupdate = isset ( $php_fortag ['_saveId'] );
	
	/**
	 * We will execute all queries frist and then submit the transaction.
	 */
	
	mysqli_autocommit ( $link, FALSE );
	
	/**
	 * Here, if the object is already saved,
	 * do an update, otherwise insert.
	 * Note this logic will continue below.
	 */
	
	if ($php_fortag_isupdate) {
		
		/**
		 * One can also use ON DUPLICATE KEY UPDATE
		 * with the INSERT statement, but accroding some articles
		 * there is a risk doing this with some odler MySQL versions.
		 * It does not hurt to add a few extra lines for the save service,
		 * just to be sure everything is OK.
		 */
		
		$tag_sql = "UPDATE for_tags
					SET bg_name = $php_fortag_bgname,
						en_name = $php_fortag_enname,
						tag		= '{$php_fortag['tag']}',
						`date`	= $php_fortag_date,
						`type`  = '{$php_fortag['type']}',
						subtype = $php_fortag_subtype,
						object  = '{$php_fortag['object']}'
					WHERE tag_id ='{$php_fortag ['_saveId']}';";
		
		$events ['mysql'] ['operation'] = 'update';
	} else {
		
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
		
		$events ['mysql'] ['operation'] = 'insert';
	}
	
	/**
	 * Second thing we want to log the changes.
	 * This is done so the admin can review recent updates.
	 * TODO: Until we have user authentication 0 will equal admin.
	 */
	
	$log_sql = "INSERT INTO for_log
					(`event`, `table`, tag, object, user, created, acknowledged)
				VALUES
					('{$events ['mysql'] ['operation']}',
					 'for_tags',
					 '{$php_fortag['tag']}',
					 '{$php_fortag['object']}',
					 0,
					 now(),
					 null);";
	
	/**
	 * The most important thing is the tag, so we send it first.
	 * On failure, there is no point to continue and we can have id gaps.
	 */
	
	$tag_result = mysqli_query ( $link, $tag_sql );
	$related_result = true;
	$log_result = true;
	
	/**
	 * Response values used to update later.
	 */
	
	$operation ['saveId'] = null;
	$operation ['saveRelated'] = array ();
	
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
		
		if ($php_fortag_isupdate) {
			$tag_last = $php_fortag ['_saveId'];
		} else {
			$tag_last = mysqli_insert_id ( $link );
		}
		
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
		}
	}
	
	/**
	 * When we update the first task is to delete as many existing entries,
	 * as is the difference between the old save count and the new one.
	 * This order is very important, because otherwise you can delete something,
	 * after it is already updated.
	 */
	
	if (isset ( $php_fortag ['_saveRelated'] )) {
		$saveRelatedCount = count ( $php_fortag ['_saveRelated'] );
		$relatedCount = isset ( $php_fortag ['related'] ) ? count ( $php_fortag ['related'] ) : 0;
		
		if ($saveRelatedCount > $relatedCount) {
			for($i = $relatedCount; $i < $saveRelatedCount; $i ++) {
				$related_delete_sql = "DELETE FROM for_rel_relative
									   WHERE tag_id = {$php_fortag ['_saveId']}
									   AND related_tag_id = {$php_fortag ['_saveRelated'] [$i]};";
				
				$related_result = mysqli_query ( $link, $related_delete_sql );
				
				if (! $related_result) {
					$events ['mysql'] ['result'] = false;
					$events ['mysql'] ['code'] = mysqli_errno ( $link );
					$events ['mysql'] ['error'] = mysqli_error ( $link );
					
					break;
				}
			}
		}
	}
	
	/**
	 * Insert every related tag id, but only if there are any.
	 * Also check if the operation is update and not insert.
	 * The goal is to update existing entries as much as possible
	 * and to prevent generting bigger primary key.
	 */
	
	if (isset ( $php_fortag ['related'] )) {
		foreach ( $php_fortag ['related'] as $key => $value ) {
			
			/**
			 * Null is not accepted in the DB, but we use it to generate error
			 * and validate empty strings.
			 * Note tags are passed to the user interface from the DB,
			 * so the chance to have a tag withou id near impossible.
			 */
			
			$id = isset ( $value ['tag_id'] ) ? "{$value['tag_id']}" : "null";
			$subtype = isset ( $value ['subtype'] ) ? "'{$value['subtype']}'" : "null";
			
			/**
			 * Note when updating there is a minimal chance to genrate error,
			 * if you swap two existing values.
			 * The problem is that cobmination of tag and related tag is defined
			 * as unique to avoid duplicates.
			 * If you swap two tags it will update them in order, thus
			 * when you change the first one for a moment it will be the same
			 * as the second, because the database does not know yet about
			 * the next update.
			 * TODO: This can solve the problem:
			 * http://stackoverflow.com/questions/11207574/how-to-swap-values-of-two-rows-in-mysql-without-violating-unique-constraint
			 */
			
			if (isset ( $php_fortag ['_saveRelated'] )) {
				if ($key < count ( $php_fortag ['_saveRelated'] )) {
					$related_sql = "UPDATE for_rel_relative
									SET related_tag_id = {$id}, related_subtype = {$subtype}
									WHERE tag_id = {$php_fortag ['_saveId']}
									AND related_tag_id = {$php_fortag ['_saveRelated'] [$key]};";
					
					goto related_update;
				} else {
					goto related_insert;
				}
			} else {
				goto related_insert;
			}
			
			/**
			 * If _saveRelated is grater than new related items
			 * we need to do a REMOVE after the cycle,
			 * starting with _saveRealted minus new related
			 * and ending with _saveRelated length.
			 */
			
			related_insert:
			
			$related_sql = "INSERT INTO for_rel_relative
										(tag_id, related_tag_id, related_subtype)
							VALUES
										({$tag_last}, {$id}, {$subtype});";
			
			related_update:
			
			$related_result = mysqli_query ( $link, $related_sql );
			
			array_push ( $operation ['saveRelated'], $id );
			
			/**
			 * We end up on the first sign of error.
			 */
			
			if (! $related_result) {
				$events ['mysql'] ['result'] = false;
				$events ['mysql'] ['code'] = mysqli_errno ( $link );
				$events ['mysql'] ['error'] = mysqli_error ( $link );
				
				break;
			}
		}
	}
	
	/**
	 * Only accept the transaction, if all results are successuful.
	 * Note, on rollback auto-increment for successful transfers is not reset.
	 */
	
	if ($tag_result && $log_result && $related_result) {
		mysqli_commit ( $link );
		
		$events ['mysql'] ['result'] = true;
		$operation ['saveId'] = $tag_last;
	} else {
		mysqli_rollback ( $link );
	}
	
	/**
	 * Send the response back to the browser in JSON format.
	 * And finally close the connection.
	 */
	
	echo json_encode ( array (
			'events' => $events,
			'operation' => $operation 
	) );
	
	mysqli_close ( $link );
}
?>