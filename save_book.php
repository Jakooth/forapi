<?php
$related_arr = array ();

if ($php_fortag ['author']) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['author'] );
}

if ($php_fortag ['translator']) {
	$related_arr = array_merge ( $related_arr, $php_fortag ['translator'] );
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