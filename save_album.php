<?php
$related_arr = array ();

if ($php_fortag ['tracks']) {
	foreach ( $php_fortag ['tracks'] as $value ) {
		$id = isset ( $value ['id'] ) ? "'{$value['id']}'" : "null";
		
		$order = isset ( $value ['order'] ) ? "{$value ['order']}" : "null";
		$name = isset ( $value ['name'] ) ? "'{$value ['name']}'" : "null";
		$video = isset ( $value ['video'] ) ? "'{$value ['video']}'" : "null";
		
		$related_sql = "INSERT INTO for_tracks
							(tag_id, order, name, video)
						VALUES
							($tag_last, $order, $name, $video);";
		
		$related_result = mysqli_query ( $link, $related_sql );
		
		if (! $related_result) {
			goto end;
		}
	}
}

if ($php_fortag ['artists']) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['artists'] );
}

if ($php_fortag ['similar']) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['similar'] );
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