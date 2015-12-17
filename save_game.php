<?php
$php_fortag_usdate = isset($php_fortag['usDate']) ? "'{$php_fortag ['usDate']}'" : "null";

/**
 * First try to insert game data related to the tag.
 */

if ($php_fortag_isupdate) {
    $related_sql = "UPDATE for_games
	                SET us_date = $php_fortag_usdate
	                WHERE tag_id ='{$php_fortag ['_saveId']}';";
} else {
    $related_sql = "INSERT INTO for_games
					   (tag_id, us_date)
				    VALUES
					   ($tag_last, $php_fortag_usdate);";
}

$related_result = mysqli_query($link, $related_sql);

if (! $related_result) {
    goto end;
}

end:

if (! $related_result) {
    $events['mysql']['result'] = false;
    $events['mysql']['code'] = mysqli_errno($link);
    $events['mysql']['error'] = mysqli_error($link);
}
?>