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
	$php_forarticle_wide = isset ( $php_forarticle ['wide'] ) ? "'{$php_forarticle ['wide']}'" : "null";
	$php_forarticle_caret = isset ( $php_forarticle ['caret'] ) ? "'{$php_forarticle ['caret']}'" : "null";
	$php_forarticle_priority = isset ( $php_forarticle ['priority'] ) ? "'{$php_forarticle ['priority']}'" : "null";
	$php_forarticle_preview = isset ( $php_forarticle ['preview'] ) ? "'{$php_forarticle ['preview']}'" : "null";
	$php_forarticle_videotech = isset ( $php_forarticle ['videoTech'] ) ? "'{$php_forarticle ['videoTech']}'" : "null";
	$php_forarticle_videourl = isset ( $php_forarticle ['videoUrl'] ) ? "'{$php_forarticle ['videoUrl']}'" : "null";
	$php_forarticle_audiotech = isset ( $php_forarticle ['audioTech'] ) ? "'{$php_forarticle ['audioTech']}'" : "null";
	$php_forarticle_audiourl = isset ( $php_forarticle ['audioUrl'] ) ? "'{$php_forarticle ['audioUrl']}'" : "null";
	$php_forarticle_audioframe = isset ( $php_forarticle ['audioFrame'] ) ? "'{$php_forarticle ['audioFrame']}'" : "null";
	$php_forarticle_cover = isset ( $php_forarticle ['cover'] ) ? "'{$php_forarticle ['cover']}'" : "null";
	$php_forarticle_coveralign = isset ( $php_forarticle ['coverAlign'] ) ? "'{$php_forarticle ['coverAlign']}'" : "null";
	$php_forarticle_covervalign = isset ( $php_forarticle ['coverValign'] ) ? "'{$php_forarticle ['coverValign']}'" : "null";
	$php_forarticle_theme = isset ( $php_forarticle ['theme'] ) ? "'{$php_forarticle ['theme']}'" : "null";
	$php_forarticle_subtheme = isset ( $php_forarticle ['subtheme'] ) ? "'{$php_forarticle ['subtheme']}'" : "null";
	$php_forarticle_hype = isset ( $php_forarticle ['hype'] ) ? "'{$php_forarticle ['hype']}'" : "null";
	$php_forarticle_platform = isset ( $php_forarticle ['platform'] ) ? "'{$php_forarticle ['platform']}'" : "null";
	$php_forarticle_better = isset ( $php_forarticle ['better'] ) ? "'{$php_forarticle ['better']['tag']}'" : "null";
	$php_forarticle_worse = isset ( $php_forarticle ['worse'] ) ? "'{$php_forarticle ['worse']['tag']}'" : "null";
	$php_forarticle_equal = isset ( $php_forarticle ['equal'] ) ? "'{$php_forarticle ['equal']['tag']}'" : "null";
	$php_forarticle_bettertext = isset ( $php_forarticle ['betterText'] ) ? "'{$php_forarticle ['betterText']}'" : "null";
	$php_forarticle_worsetext = isset ( $php_forarticle ['worseText'] ) ? "'{$php_forarticle ['worseText']}'" : "null";
	$php_forarticle_equaltext = isset ( $php_forarticle ['equalText'] ) ? "'{$php_forarticle ['equalText']}'" : "null";
	
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
						  cover_img, cover_align, cover_valign, theme, subtheme,
						  hype, platform, better, worse, equal, better_text, worse_text, equal_text)
					VALUES
						('{$php_forarticle['type']}',
						 '{$php_forarticle['subtype']}',
						 '{$php_forarticle['title']}',
						 $php_forarticle_subtitle,
						 '{$php_forarticle['shot']}',
						 $php_forarticle_wide,
						 $php_forarticle_caret,
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
						 $php_forarticle_cover,
						 $php_forarticle_coveralign,
						 $php_forarticle_covervalign,
						 $php_forarticle_theme,
						 $php_forarticle_subtheme,
						 $php_forarticle_hype,
						 $php_forarticle_platform,
						 $php_forarticle_better,
						 $php_forarticle_worse,
						 $php_forarticle_equal,
						 $php_forarticle_bettertext,
						 $php_forarticle_worsetext,
						 $php_forarticle_equaltext);";
	
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
		
		if (isset ( $php_forarticle ['layouts'] )) {
			foreach ( $php_forarticle ['layouts'] as $key => $layout ) {
				$layout_subtype = isset ( $layout ['subtype'] ) ? "'{$layout['subtype']}'" : "null";
				$layout_center = isset ( $layout ['center'] ) ? "'{$layout['center']}'" : "null";
				$layout_left = isset ( $layout ['left'] ) ? "'{$layout['left']['url']}'" : "null";
				$layout_left_valign = isset ( $layout ['left'] ) ? "'{$layout['left']['valign']}'" : "null";
				$layout_left_object = isset ( $layout ['left'] ) ? "'{$layout['left']['object']}'" : "null";
				$layout_right = isset ( $layout ['right'] ) ? "'{$layout['right']['url']}'" : "null";
				$layout_right_valign = isset ( $layout ['right'] ) ? "'{$layout['right']['valign']}'" : "null";
				$layout_right_object = isset ( $layout ['right'] ) ? "'{$layout['right']['object']}'" : "null";
				
				$related_sql = "INSERT INTO for_layouts
									(article_id, 
									 `type`, subtype, 
									 center, 
									 `left`, left_valign, left_object, 
									 `right`, right_valign, right_object,
									 ratio, `order`)
								VALUES
									($article_last, 
									 '{$layout['type']}', $layout_subtype,
									 $layout_center,
									 $layout_left, $layout_left_valign, $layout_left_object,
									 $layout_right, $layout_right_valign, $layout_right_object,
									 '{$layout['ratio']}', $key);";
				
				$related_result = mysqli_query ( $link, $related_sql );
				
				if (! $related_result) {
					goto end;
				}
				
				$layout_last = mysqli_insert_id ( $link );
				
				if (isset ( $layout ['imgs'] )) {
					foreach ( $layout ['imgs'] as $img ) {
						$img_tag = isset ( $img ['tag'] ) ? "'{$img['tag']}'" : "null";
						$img_index = isset ( $img ['index'] ) ? "'{$img['index']}'" : "null";
						$img_center = isset ( $img ['center'] ) ? "'{$img['center']}'" : "null";
						$img_author = isset ( $img ['author'] ) ? "'{$img['author']}'" : "null";
						
						/**
						 * Tracklist is the prime tag.
						 *
						 * From the tag we can get the full list of songs.
						 */
						
						$img_tracklist = isset ( $img ['tracklist'] ) ? "'$php_forarticle ['prime'] ['tag_id']'" : "null";
						$img_align = isset ( $img ['align'] ) ? "'{$img ['align']}'" : "null";
						$img_valign = isset ( $img ['valign'] ) ? "'{$img ['align']}'" : "null";
						$img_video = isset ( $img ['video'] ) ? "'{$img ['video']}'" : "null";
						
						$related_sql = "INSERT INTO for_rel_imgs
											(layout_id,
											 alt, pointer,
											 tag, `index`,
											 center, author,
											 tracklist, align, valign,
											 video,
											 ratio)
										VALUES
											($layout_last,
											 '{$img['alt']}', 
											 '{$img['pointer']}', 
											 $img_tag, $img_index,
											 $img_center, $img_author,
											 $img_tracklist, $img_align, $img_valign,
											 $img_video,
											 '{$img['ratio']}');";
						
						$related_result = mysqli_query ( $link, $related_sql );
						
						if (! $related_result) {
							goto end;
						}
					}
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