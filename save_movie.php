<?php
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

end:

if (! $related_result) {
	$events ['mysql'] ['result'] = false;
	$events ['mysql'] ['code'] = mysqli_errno ( $link );
	$events ['mysql'] ['error'] = mysqli_error ( $link );
}
?>