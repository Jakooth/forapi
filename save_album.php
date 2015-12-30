<?php
$operation['saveTracks'] = array();
$tracks_arr = array();

if (isset($php_fortag['tracks'])) {
    $tracks_arr = $php_fortag['tracks'];
}

/**
 * First delete.
 */

if (isset($php_fortag['_saveTracks'])) {
    $saveTracksCount = count($php_fortag['_saveTracks']);
    $tracksCount = count($tracks_arr);
    
    if ($saveTracksCount > $tracksCount) {
        for ($i = $tracksCount; $i < $saveTracksCount; $i ++) {
            $tracks_delete_sql = "DELETE FROM for_tracks
                                  WHERE tag_id = {$php_fortag ['_saveId']}
                                  AND track_id = {$php_fortag ['_saveTracks'] [$i]}
                                  LIMIT 1;";
            
            $object_result = mysqli_query($link, $tracks_delete_sql);
            
            if (! $object_result) {
                goto end;
            }
        }
    }
}

/**
 * Next update or insert.
 */

if (count($tracks_arr) > 0) {
    foreach ($tracks_arr as $key => $value) {
        $order = isset($value['order']) ? "{$value['order']}" : "null";
        $name = isset($value['name']) ? "'{$value['name']}'" : "null";
        $video = isset($value['video']) ? "'{$value['video']}'" : "null";
        
        if (isset($php_fortag['_saveTracks'])) {
            if ($key < count($php_fortag['_saveTracks'])) {
                $object_sql = "UPDATE for_tracks
                               SET `order` = {$order}, 
                                   `name` = {$name}, 
                                   video = {$video}
                               WHERE tag_id = {$php_fortag ['_saveId']}
                               AND track_id = {$php_fortag ['_saveTracks'] [$key]}
                               LIMIT 1;";
                
                goto object_update;
            } else {
                goto object_insert;
            }
        } else {
            goto object_insert;
        }
        
        /**
         * Do insert.
         */
        
        object_insert:
        
        $object_sql = "INSERT INTO for_tracks
					       (tag_id, `order`, `name`, video)
					   VALUES
					       ($tag_last, $order, $name, $video);";
        
        /**
         * Do update.
         */
        
        object_update:
        
        $object_result = mysqli_query($link, $object_sql);
        
        /**
         * We end up on the first sign of error.
         * Errors are handled in save.php.
         */
        
        if (! $object_result) {
            goto end;
        }
        
        if (isset($php_fortag['_saveTracks'])) {
            if ($key < count($php_fortag['_saveTracks'])) {
                $track_last = $php_fortag['_saveTracks'][$key];
            } else {
                $track_last = mysqli_insert_id($link);
            }
        } else {
            $track_last = mysqli_insert_id($link);
        }
        
        array_push($operation['saveTracks'], $track_last);
    }
}

end:
?>