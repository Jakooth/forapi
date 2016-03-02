<?php
$php_fortag_worlddate = isset($php_fortag['worldDate']) ? "'{$php_fortag ['worldDate']}'" : "null";
$php_fortag_time = isset($php_fortag['time']) ? "'{$php_fortag ['time']}'" : "null";

if ($php_fortag_isupdate) {
    $object_sql = "UPDATE for_movies
                   SET world_date = $php_fortag_worlddate,
                       time = $php_fortag_time
                   WHERE tag_id ='{$php_fortag ['_saveId']}';";
} else {
    $object_sql = "INSERT INTO for_movies
                        (tag_id, world_date, `time`)
                   VALUES
                        ($tag_last, $php_fortag_worlddate, $php_fortag_time);";
}

$object_result = mysqli_query($link, $object_sql);
?>