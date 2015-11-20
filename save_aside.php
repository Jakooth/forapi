<?php
include ('db.php');

if (getenv ( 'REQUEST_METHOD' ) == 'POST') {
	
	/**
	 * In verison 5.6 of PHP ajax calls are no longer in POST.
	 * The request is POST but variables are stored in php://input.
	 */
	
	$json_forarticle = file_get_contents ( "php://input" );
	$php_forarticle = json_decode ( $json_forarticle, true );
	
	/**
	 * Making some of the optional variable null.
	 * Note for date it is required to being date format or null.
	 */
	
	$php_forarticle_subtitle = isset ( $php_forarticle ['subtitle'] ) ? "'{$php_forarticle ['subtitle']}'" : "null";
	$php_forarticle_wideimg = isset ( $php_forarticle ['wide_img'] ) ? "'{$php_forarticle ['wide_img']}'" : "null";
	$php_forarticle_caretimg = isset ( $php_forarticle ['caret_img'] ) ? "'{$php_forarticle ['caret_img']}'" : "null";
	$php_forarticle_priority = isset ( $php_forarticle ['priority'] ) ? "'{$php_forarticle ['priority']}'" : "null";
	$php_forarticle_preview = isset ( $php_forarticle ['preview'] ) ? "'{$php_forarticle ['preview']}'" : "null";
	$php_forarticle_videotech = isset ( $php_forarticle ['video_tech'] ) ? "'{$php_forarticle ['video_tech']}'" : "null";
	$php_forarticle_videourl = isset ( $php_forarticle ['video_url'] ) ? "'{$php_forarticle ['video_url']}'" : "null";
	$php_forarticle_audiotech = isset ( $php_forarticle ['audio_tech'] ) ? "'{$php_forarticle ['audio_tech']}'" : "null";
	$php_forarticle_audiourl = isset ( $php_forarticle ['audio_url'] ) ? "'{$php_forarticle ['audio_url']}'" : "null";
	$php_forarticle_audioframe = isset ( $php_forarticle ['audio_frame'] ) ? "'{$php_forarticle ['audio_frame']}'" : "null";
	$php_forarticle_coverimg = isset ( $php_forarticle ['cover_img'] ) ? "'{$php_forarticle ['cover_img']}'" : "null";
	$php_forarticle_coveralign = isset ( $php_forarticle ['cover_align'] ) ? "'{$php_forarticle ['cover_align']}'" : "null";
	$php_forarticle_covervalign = isset ( $php_forarticle ['cover_valign'] ) ? "'{$php_forarticle ['cover_valign']}'" : "null";
	$php_forarticle_covertheme = isset ( $php_forarticle ['cover_theme'] ) ? "'{$php_forarticle ['cover_theme']}'" : "null";
	$php_forarticle_coversubtheme = isset ( $php_forarticle ['cover_subtheme'] ) ? "'{$php_forarticle ['cover_subtheme']}'" : "null";
	$php_forarticle_hype = isset ( $php_forarticle ['hype'] ) ? "'{$php_forarticle ['hype']}'" : "null";
	$php_forarticle_platform = isset ( $php_forarticle ['platform'] ) ? "'{$php_forarticle ['platform']}'" : "null";
	$php_forarticle_better = isset ( $php_forarticle ['better'] ) ? "'{$php_forarticle ['better']}'" : "null";
	$php_forarticle_worse = isset ( $php_forarticle ['worse'] ) ? "'{$php_forarticle ['worse']}'" : "null";
	$php_forarticle_equal = isset ( $php_forarticle ['equal'] ) ? "'{$php_forarticle ['equal']}'" : "null";
	
	/**
	 * Date is always send from the script, but we need to format it in MySQL pattern.
	 */
	
	$php_forarticle_date = date ( ' Y-m-d H:i:s', strtotime ( $php_forarticle ['date'] ) );
	
	/**
	 * First row of the sql string is for general properties,
	 * Second are main images,
	 * Third is for publish settings and preview,
	 * Fourth are video an audio for news,
	 * Fifth are cover images and settings,
	 * Last if review score and information.
	 * Authors, tags, prime and issue are stored in relational table.
	 * Stickers, if any are later get from the prime by tag and tag_id.
	 */
	
	$article_sql = "INSERT INTO for_articles
						(`type`, subtype, title, subtitle, 
						  shot_img, wide_img, caret_img,
						  site, url, `date`, priority, preview,
						  video_tech, video_url, audio_tech, audio_url, audio_frame,
						  cover_img, cover_align, cover_valign, cover_theme, cover_subtheme,
						  hype, platform, better, worse, equal)
					VALUES
						('{$php_forarticle['type']}',
						 '{$php_forarticle['subtype']}',
						 '{$php_forarticle['title']}',
						 $php_forarticle_subtitle,
						 '{$php_forarticle['shot_img']}',
						 $php_forarticle_wideimg,
						 $php_forarticle_caretimg,
						 '{$php_forarticle['site']}',
						 '{$php_forarticle['url']}',
						 '{$php_forarticle_date}',
						 $php_forarticle_priority,
						 $php_forarticle_preview,
						 $php_forarticle_videotech,
						 $php_forarticle_videourl,
						 $php_forarticle_audiotech,
						 $php_forarticle_audiourl,
						 $php_forarticle_audioframe,
						 $php_forarticle_coverimg,
						 $php_forarticle_coveralign,
						 $php_forarticle_covervalign,
						 $php_forarticle_covertheme,
						 $php_forarticle_coversubtheme,
						 $php_forarticle_hype,
						 $php_forarticle_platform,
						 $php_forarticle_better,
						 $php_forarticle_worse,
						 $php_forarticle_equal);";
	
	$log_sql = "INSERT INTO for_log
					(`event`, `table`, tag, object, user, created, acknowledged)
				VALUES
					('insert',
					 'for_articles',
					 '{$php_forarticle['prime']['tag']}',
					 'aside',
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
	
	$article_result = mysqli_query ( $link, $article_sql );
	$related_result = true;
	$log_result = true;
	
	if (! $article_result) {
		$events ['mysql'] ['result'] = false;
		$events ['mysql'] ['code'] = mysqli_errno ( $link );
		$events ['mysql'] ['error'] = mysqli_error ( $link );
	} else {
		
		/**
		 * Next we query the log, but we do not stop on failure.
		 * Note the chance for error here is almost impossible,
		 * Because we generate the values here and not from user input.
		 */
		
		$article_last = mysqli_insert_id ( $link );
		$log_result = mysqli_query ( $link, $log_sql );
		
		if (! $log_result) {
			$events ['mysql'] ['result'] = false;
			$events ['mysql'] ['code'] = mysqli_errno ( $link );
			$events ['mysql'] ['error'] = mysqli_error ( $link );
		}
		
		if (isset ( $php_forarticle ['author'] )) {
			foreach ( $php_forarticle ['author'] as $value ) {
				$id = isset ( $value ['author_id'] ) ? "'{$value['author_id']}'" : "null";
				
				$related_sql = "INSERT INTO for_rel_authors
									(article_id, author_id)
								VALUES
									($article_last, $id);";
				
				$related_result = mysqli_query ( $link, $related_sql );
				
				if (! $related_result) {
					goto end;
				}
			}
		}
		
		if (isset ( $php_forarticle ['tags'] )) {
			foreach ( $php_forarticle ['tags'] as $value ) {
				$id = isset ( $value ['tag_id'] ) ? "'{$value['tag_id']}'" : "null";
				$prime = 0;
				
				if ($php_forarticle ['prime'] ['tag_id'] == $value ['tag_id']) {
					$prime = 1;
				}
				
				$related_sql = "INSERT INTO for_rel_tags
									(tag_id, article_id, prime)
								VALUES
									($id, $article_last, $prime);";
				
				$related_result = mysqli_query ( $link, $related_sql );
				
				if (! $related_result) {
					goto end;
				}
			}
		}
		
		/**
		 * It is just one issue, but the JSON is still passing it in array.
		 */
		
		if (isset ( $php_forarticle ['issue'] )) {
			foreach ( $php_forarticle ['issue'] as $value ) {
				$id = isset ( $value ['issue_id'] ) ? "'{$value['issue_id']}'" : "null";
				
				$related_sql = "INSERT INTO for_rel_issues
									(article_id, issue_id)
								VALUES
									($article_last, $id);";
				
				$related_result = mysqli_query ( $link, $related_sql );
				
				if (! $related_result) {
					goto end;
				}
			}
		}
		
		end:
		
		if (! $related_result) {
			$events ['mysql'] ['result'] = false;
			$events ['mysql'] ['code'] = mysqli_errno ( $link );
			$events ['mysql'] ['error'] = mysqli_error ( $link );
		}
	}
	
	/**
	 * Only accept the transaction, if all results are successuful.
	 * Note, on rollback auto-increment for successful transfers is not reset.
	 */
	
	if ($article_result && $log_result && $related_result) {
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