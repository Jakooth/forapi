<?php
$related_arr = array ();
$php_fortag_worlddate = isset ( $php_fortag ['worldDate'] ) ? "'{$php_fortag ['worlddDate']}'" : "null";
$php_fortag_time = isset ( $php_fortag ['time'] ) ? "'{$php_fortag ['time']}'" : "null";

/**
 * First try to insert movie data related to the tag.
 */

$related_sql = "INSERT INTO for_movies
					(tag_id, world_date, `time`)
				VALUES
					($tag_last, $php_fortag_worlddate, $php_fortag_time);";

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
							($tag_last, $id);";
		
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
							($tag_last, $id);";
		
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

if ($php_fortag ['cast']) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['cast'] );
}

if ($php_fortag ['director']) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['director'] );
}

if ($php_fortag ['writer']) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['director'] );
}

if ($php_fortag ['camera']) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['director'] );
}

if ($php_fortag ['music']) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['director'] );
}

if (count ( $related_arr ) > 0) {
	foreach ( $related_arr as $value ) {
		$id = isset ( $value ['id'] ) ? "'{$value['id']}'" : "null";
		
		$related_sql = "INSERT INTO for_rel_relative
							(tag_id, related_tag_id)
						VALUES
							($tag_last, $id);";
		
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