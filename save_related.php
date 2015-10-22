<?php
$related_arr = array ();

if (isset ( $php_fortag ['stickers'] )) {
	foreach ( $php_fortag ['stickers'] as $value ) {
		$id = isset ( $value ['sticker_id'] ) ? "'{$value['sticker_id']}'" : "null";
		
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

if (isset ( $php_fortag ['genres'] )) {
	foreach ( $php_fortag ['genres'] as $value ) {
		$id = isset ( $value ['genre_id'] ) ? "'{$value['genre_id']}'" : "null";
		
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

if (isset ( $php_fortag ['serie'] )) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['serie'] );
}

if (isset ( $php_fortag ['similar'] )) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['similar'] );
}

/**
 * GAME
 */

if (isset ( $php_fortag ['publisher'] )) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['publisher'] );
}

if (isset ( $php_fortag ['developer'] )) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['developer'] );
}

/**
 * MOVIE
 */

if (isset ( $php_fortag ['cast'] )) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['cast'] );
}

if (isset ( $php_fortag ['director'] )) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['director'] );
}

if (isset ( $php_fortag ['writer'] )) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['director'] );
}

if (isset ( $php_fortag ['camera'] )) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['director'] );
}

if (isset ( $php_fortag ['music'] )) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['director'] );
}

/**
 * ALBUM
 */

if (isset ( $php_fortag ['artists'] )) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['artists'] );
}

/**
 * BOOK
 */

if (isset ( $php_fortag ['author'] )) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['author'] );
}

if (isset ( $php_fortag ['translator'] )) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['translator'] );
}

/**
 * Save all related at once.
 */

if (count ( $related_arr ) > 0) {
	foreach ( $related_arr as $value ) {
		$id = isset ( $value ['tag_id'] ) ? "'{$value['tag_id']}'" : "null";
		
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
?>