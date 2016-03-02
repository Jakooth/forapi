<?php
$php_fortag_usdate = isset($php_fortag['usDate']) ? "'{$php_fortag ['usDate']}'" : "null";

if ($php_fortag_isupdate) {
    $object_sql = "UPDATE for_games
	               SET us_date = $php_fortag_usdate
	               WHERE tag_id ='{$php_fortag ['_saveId']}';";
} else {
    $object_sql = "INSERT INTO for_games
				        (tag_id, us_date)
				   VALUES
				        ($tag_last, $php_fortag_usdate);";
}

$object_result = mysqli_query($link, $object_sql);
?>