<?php
$php_fortag_enddate = isset($php_fortag['endDate']) ? "'{$php_fortag ['endDate']}'" : "null";
$php_fortag_seasons = isset($php_fortag['seasons']) ? "'{$php_fortag ['seasons']}'" : "null";
$php_fortag_awards = isset($php_fortag['awards']) ? "'{$php_fortag ['awards']}'" : "null";

/**
 * Do a check if exists.
 * This only for TV, because the object was created after.
 */

if ($php_fortag_isupdate) {
    $object_sql = "SELECT * FROM for_tv 
                   WHERE tag_id ='{$php_fortag ['_saveId']}';";
    
    $object_result = mysqli_query($link, $object_sql);
}

/**
 * Now only update, if there is a row to update.
 */

if ($php_fortag_isupdate && mysqli_num_rows($object_result) == 1) {
    $object_sql = "UPDATE for_tv
                   SET end_date = $php_fortag_enddate,
                       seasons = $php_fortag_seasons,
                       awards = $php_fortag_awards
                   WHERE tag_id ='{$php_fortag ['_saveId']}';";
} else {
    $object_sql = "INSERT INTO for_tv
                        (tag_id, end_date, seasons, awards)
                   VALUES
                        ($tag_last, $php_fortag_enddate, $php_fortag_seasons, $php_fortag_awards);";
}

$object_result = mysqli_query($link, $object_sql);
?>