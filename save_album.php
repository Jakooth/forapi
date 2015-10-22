<?php
if ($php_fortag ['tracks']) {
	foreach ( $php_fortag ['tracks'] as $value ) {
		$id = isset ( $value ['track_id'] ) ? "'{$value['track_id']}'" : "null";
		
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

include ('save_related.php');

end:

if (! $related_result) {
	$events ['mysql'] ['result'] = false;
	$events ['mysql'] ['code'] = mysqli_errno ( $link );
	$events ['mysql'] ['error'] = mysqli_error ( $link );
}
?>