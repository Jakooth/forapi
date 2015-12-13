<?php
include ('db.php');

if (getenv ( 'REQUEST_METHOD' ) == 'GET') {
	$get_url = isset ( $_GET ['url'] ) ? "{$_GET ['tag']}" : "ANY (SELECT url FROM for_articles)";
	$get_type = isset ( $_GET ['type'] ) ? "'{$_GET ['type']}'" : "ANY (SELECT `type` FROM for_articles)";
	$get_subtype = isset ( $_GET ['subtype'] ) ? "'{$_GET ['subtype']}'" : "ANY (SELECT subtype FROM for_articles)";
	
	$get_article_sql = "SELECT * FROM for_articles 
						WHERE url = {$get_url}
    					AND (`type` = {$get_type})
    					AND (subtype = {$get_subtype});";
	
	$get_article_result = true;
	$articles = array ();
	
	/**
	 * TODO: Additional logic is needed here.
	 */
	
	switch ($get_subtype) {
		case "'review'" :
		case "'feature'" :
		case "'news'" :
		case "'video'" :
			break;
		default :
			
			/**
			 * TODO: Merge other results like platform and genre here.
			 */
			
			$get_article_result = mysqli_query ( $link, $get_article_sql );
	}
	
	if (! $get_article_result) {
		$events ['mysql'] ['result'] = false;
		$events ['mysql'] ['code'] = mysqli_errno ( $link );
		$events ['mysql'] ['error'] = mysqli_error ( $link );
		
		goto end;
	} else {
		$events ['mysql'] ['result'] = true;
	}
	
	while ( $article = mysqli_fetch_assoc ( $get_article_result ) ) {
		$articles [] = $article;
	}
	
	end:
	
	/**
	 * Send the response back to the browser in JSON format.
	 * And finally close the connection.
	 */
	
	echo json_encode ( array (
			'articles' => $articles,
			'events' => $events 
	) );
	
	mysqli_close ( $link );
}
?>