<?php
$php_fortag_enddate = isset($php_fortag['endDate']) ? "'{$php_fortag ['endDate']}'" : "null";
$php_fortag_city = isset($php_fortag['city']) ? "'{$php_fortag ['city']}'" : "null";

if ($php_fortag_isupdate) {
    $object_sql = "UPDATE for_events
                   SET end_date = $php_fortag_enddate, 
                       city = $php_fortag_city
                   WHERE tag_id ='{$php_fortag ['_saveId']}';";
} else {
    $object_sql = "INSERT INTO for_events
                        (tag_id, end_date, city)
                   VALUES
                        ($tag_last, $php_fortag_enddate, $php_fortag_city);";
}

$object_result = mysqli_query($link, $object_sql);
?>