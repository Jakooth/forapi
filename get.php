<?php
include ('db.php');

if (getenv ( 'REQUEST_METHOD' ) == 'GET') {
	$get_tag = isset ( $_GET ['tag'] ) ? "'{$_GET ['tag']}'" : "ANY (SELECT tag FROM for_tags)";
	$get_object = isset ( $_GET ['object'] ) ? "'{$_GET ['object']}'" : "ANY (SELECT object FROM for_tags)";
	$get_type = isset ( $_GET ['type'] ) ? "'{$_GET ['type']}'" : "ANY (SELECT `type` FROM for_tags) OR `type` IS NULL";
	$get_subtype = isset ( $_GET ['subtype'] ) ? "'{$_GET ['subtype']}'" : "ANY (SELECT subtype FROM for_tags) OR subtype IS NULL";
	$get_order = isset ( $_GET ['object'] ) ? "tag_id DESC" : "tag ASC";
	
	$get_tag_sql = "SELECT * FROM for_tags 
					WHERE tag = {$get_tag}
    				AND (`type` = {$get_type})
    				AND (subtype = {$get_subtype})
    				AND object = {$get_object}
    				ORDER BY {$get_order}
    				LIMIT 100;";
	
	$get_genres_sql = "SELECT * FROM for_genres 
					   WHERE `type` = {$get_type};";
	
	$get_platforms_sql = "SELECT * FROM for_platforms";
	$get_stickers_sql = "SELECT * FROM for_stickers";
	$get_authors_sql = "SELECT * FROM for_authors";
	$get_issues_sql = "SELECT * FROM for_issues";
	
	$get_tag_result = true;
	$tags = array ();
	
	switch ($get_object) {
		case "'author'" :
			$get_tag_result = mysqli_query ( $link, $get_authors_sql );
			
			break;
		case "'sticker'" :
			$get_tag_result = mysqli_query ( $link, $get_stickers_sql );
			
			break;
		case "'genre'" :
			$get_tag_result = mysqli_query ( $link, $get_genres_sql );
			
			break;
		case "'platform'" :
			$get_tag_result = mysqli_query ( $link, $get_platforms_sql );
			
			break;
		case "'issue'" :
			$get_tag_result = mysqli_query ( $link, $get_issues_sql );
			
			break;
		case "'game'" :
		case "'movie'" :
		case "'company'" :
		case "'serie'" :
			$get_tag_result = mysqli_query ( $link, $get_tag_sql );
			
			break;
		default :
			
			/**
			 * TODO: Merge other results like platform and genre here.
			 */
			
			$get_tag_result = mysqli_query ( $link, $get_tag_sql );
	}
	
	if (! $get_tag_result) {
		$events ['mysql'] ['result'] = false;
		$events ['mysql'] ['code'] = mysqli_errno ( $link );
		$events ['mysql'] ['error'] = mysqli_error ( $link );
		
		goto end;
	} else {
		$events ['mysql'] ['result'] = true;
	}
	
	while ( $tag = mysqli_fetch_assoc ( $get_tag_result ) ) {
		$tags [] = $tag;
	}
	
	end:
	
	/**
	 * Send the response back to the browser in JSON format.
	 * And finally close the connection.
	 */
	
	echo json_encode ( array (
			'tags' => $tags,
			'events' => $events 
	) );
	
	mysqli_close ( $link );
}
?>