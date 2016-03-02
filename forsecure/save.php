<?php
include ('../../../forsecret/db.php');

if (getenv('REQUEST_METHOD') == 'POST') {
    
    /**
     * In verison 5.6 of PHP ajax calls are no longer in POST.
     * The request is POST but variables are stored in php://input.
     */
    
    $json_fortag = file_get_contents("php://input");
    $php_fortag = json_decode($json_fortag, true);
    
    /**
     * Making some of the optional variable null.
     * Note for date it is required to being date format or null.
     */
    
    $php_fortag_bgname = isset($php_fortag['bgName']) ? "'{$php_fortag ['bgName']}'" : "null";
    $php_fortag_enname = isset($php_fortag['enName']) ? "'{$php_fortag ['enName']}'" : "null";
    $php_fortag_date = isset($php_fortag['date']) ? "'{$php_fortag ['date']}'" : "null";
    $php_fortag_subtype = isset($php_fortag['subtype']) ? "'{$php_fortag ['subtype']}'" : "null";
    $php_fortag_isupdate = isset($php_fortag['_saveId']);
    
    /**
     * We will execute all queries frist and then submit the transaction.
     */
    
    mysqli_autocommit($link, FALSE);
    
    /**
     * Here, if the object is already saved,
     * do an update, otherwise insert.
     * Note this logic will continue below.
     */
    
    if ($php_fortag_isupdate) {
        
        /**
         * One can also use ON DUPLICATE KEY UPDATE
         * with the INSERT statement, but accroding some articles
         * there is a risk doing this with some odler MySQL versions.
         * It does not hurt to add a few extra lines for the save service,
         * just to be sure everything is OK.
         */
        
        $tag_sql = "UPDATE for_tags
					SET bg_name = $php_fortag_bgname,
						en_name = $php_fortag_enname,
						tag		= '{$php_fortag['tag']}',
						`date`	= $php_fortag_date,
						`type`  = '{$php_fortag['type']}',
						subtype = $php_fortag_subtype,
						object  = '{$php_fortag['object']}'
					WHERE tag_id = {$php_fortag ['_saveId']};";
        
        $events['mysql']['operation'] = 'update';
    } else {
        
        /**
         * First query is to insert the tag.
         * Note date and type are private words in SQL.
         */
        
        $tag_sql = "INSERT INTO for_tags
						(bg_name, en_name, tag, `date`, `type`, subtype, object)
					VALUES
						($php_fortag_bgname,
						 $php_fortag_enname,
						 '{$php_fortag['tag']}',
						 $php_fortag_date,
						 '{$php_fortag['type']}',
						 $php_fortag_subtype,
						 '{$php_fortag['object']}');";
        
        $events['mysql']['operation'] = 'insert';
    }
    
    /**
     * Second thing we want to log the changes.
     * This is done so the admin can review recent updates.
     * TODO: Until we have user authentication 0 will equal admin.
     */
    
    $log_sql = "INSERT INTO for_log
					(`event`, `table`, tag, object, user, created, acknowledged)
				VALUES
					('{$events ['mysql'] ['operation']}',
					 'for_tags',
					 '{$php_fortag['tag']}',
					 '{$php_fortag['object']}',
					 0,
					 now(),
					 null);";
    
    /**
     * The most important thing is the tag, so we send it first.
     * On failure, there is no point to continue and we can have id gaps.
     */
    
    $tag_result = mysqli_query($link, $tag_sql);
    $related_result = true;
    $object_result = true;
    $log_result = true;
    
    /**
     * Response values used to update later.
     */
    
    $operation['saveId'] = null;
    $operation['saveRelated'] = array();
    
    if (! $tag_result) {
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
    } else {
        
        /**
         * Next we query the log, but we do not stop on failure.
         * Note the chance for error here is almost impossible,
         * Because we generate the values here and not from user input.
         */
        
        if ($php_fortag_isupdate) {
            $tag_last = $php_fortag['_saveId'];
        } else {
            $tag_last = mysqli_insert_id($link);
        }
        
        $log_result = mysqli_query($link, $log_sql);
        
        if (! $log_result) {
            $events['mysql']['result'] = false;
            $events['mysql']['code'] = mysqli_errno($link);
            $events['mysql']['error'] = mysqli_error($link);
        }
        
        /**
         * Same for related data to objects.
         * We are using mostly ids from the database.
         * The chance for an error iv very slick.
         */
        
        switch ($php_fortag['object']) {
            case 'game':
                include ('save_game.php');
                
                break;
            case 'movie':
                include ('save_movie.php');
                
                break;
            case 'event':
                include ('save_event.php');
                
                break;
            case 'album':
                include ('save_album.php');
                
                break;
        }
    }
    
    if (! $object_result) {
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
    } else {
        
        /**
         * Save all related at once.
         */
        
        include ('save_related.php');
    }
    
    /**
     * Only accept the transaction, if all results are successuful.
     * Note, on rollback auto-increment for successful transfers is not reset.
     */
    
    if ($tag_result && $log_result && $related_result && $object_result) {
        mysqli_commit($link);
        
        $events['mysql']['result'] = true;
        $operation['saveId'] = $tag_last;
    } else {
        mysqli_rollback($link);
    }
    
    /**
     * Send the response back to the browser in JSON format.
     * And finally close the connection.
     */
    
    echo json_encode(
            array(
                    'events' => $events,
                    'operation' => $operation
            ));
    
    mysqli_close($link);
}
?>