<?php
$php_fortag_enddate = isset ( $php_fortag ['endDate'] ) ? "'{$php_fortag ['endDate']}'" : "null";
$php_fortag_city = isset ( $php_fortag ['city'] ) ? "'{$php_fortag ['city']}'" : "null";

/**
 * First try to insert event data related to the tag.
 */

$related_sql = "INSERT INTO for_events
					(tag_id, end_date, city)
				VALUES
					($tag_last, $php_fortag_enddate, $php_fortag_city);";

$related_result = mysqli_query ( $link, $related_sql );

if (! $related_result) {
	goto end;
}

include ('save_related.php');

end:

if (! $related_result) {
	$events ['mysql'] ['result'] = false;
	$events ['mysql'] ['code'] = mysqli_errno ( $link );
	$events ['mysql'] ['error'] = mysqli_error ( $link );
}
?>