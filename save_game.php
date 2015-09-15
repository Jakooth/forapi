<?php
$related_arr = array ();
$php_fortag_usdate = $php_fortag ['usDate'] == '' ? "null" : "'" . $php_fortag ['usDate'] . "'";

/**
 * First try to insert game data related to the tag.
 */

$related_sql = "INSERT INTO for_games
					(tag_id, us_date)
				VALUES
					('{$tag_last}', $php_fortag_usdate);";

$related_result = mysqli_query ( $link, $related_sql );

if (! $related_result) {
	goto end;
}

if ($php_fortag ['stickers']) {
	foreach ( $php_fortag ['stickers'] as $value ) {
		$id = isset ( $value ['id'] ) ? "'{$value['id']}'" : "null";
		
		$related_sql = "INSERT INTO for_rel_stickers
							(tag_id, sticker_id)
						VALUES
							('{$tag_last}', '{$id}');";
		
		$related_result = mysqli_query ( $link, $related_sql );
		
		if (! $related_result) {
			goto end;
		}
	}
}

if ($php_fortag ['genres']) {
	foreach ( $php_fortag ['genres'] as $value ) {
		$id = isset ( $value ['id'] ) ? "'{$value['id']}'" : "null";
		
		$related_sql = "INSERT INTO for_rel_genres
							(tag_id, genre_id)
						VALUES
							('{$tag_last}', '{$id}');";
		
		$related_result = mysqli_query ( $link, $related_sql );
		
		if (! $related_result) {
			goto end;
		}
	}
}

if ($php_fortag ['country']) {
	$id = isset ( $php_fortag ['serie'] ['id'] ) ? "'{$value['id']}'" : "null";
	
	$related_sql = "INSERT INTO for_rel_countries
						(tag_id, related_tag_id)
					VALUES
						('{$tag_last}', '{$id}');";
	
	$related_result = mysqli_query ( $link, $related_sql );
}

if ($php_fortag ['platforms']) {
	foreach ( $php_fortag ['platforms'] as $value ) {
		$id = isset ( $value ['id'] ) ? "'{$value['id']}'" : "null";
		
		$related_sql = "INSERT INTO for_rel_platforms
							(tag_id, platform_id)
						VALUES
							('{$tag_last}', '{$id}');";
		
		$related_result = mysqli_query ( $link, $related_sql );
		
		if (! $related_result) {
			goto end;
		}
	}
}

if ($php_fortag ['serie']) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['serie'] );
}

if ($php_fortag ['similar']) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['similar'] );
}

if ($php_fortag ['publisher']) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['publisher'] );
}

if ($php_fortag ['developer']) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['developer'] );
}

if (count ( $related_arr ) > 0) {
	foreach ( $related_arr as $value ) {
		$id = isset ( $value ['id'] ) ? "'{$value['id']}'" : "null";
		
		$related_sql = "INSERT INTO for_rel_relative
							(tag_id, related_tag_id)
						VALUES
							('{$tag_last}', '{$id}');";
		
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
?>