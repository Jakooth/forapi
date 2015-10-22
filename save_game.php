<?php
$php_fortag_usdate = isset ( $php_fortag ['usDate'] ) ? "'{$php_fortag ['usDate']}'" : "null";

/**
 * First try to insert game data related to the tag.
 */

$related_sql = "INSERT INTO for_games
					(tag_id, us_date)
				VALUES
					($tag_last, $php_fortag_usdate);";

$related_result = mysqli_query ( $link, $related_sql );

if (! $related_result) {
	goto end;
}

if (isset ( $php_fortag ['platforms'] )) {
	foreach ( $php_fortag ['platforms'] as $value ) {
		$id = isset ( $value ['platform_id'] ) ? "'{$value['platform_id']}'" : "null";
		
		$related_sql = "INSERT INTO for_rel_platforms
							(tag_id, platform_id)
						VALUES
							($tag_last, $id);";
		
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