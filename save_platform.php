<?php
include ('../../forsecret/db.php');

if (getenv('REQUEST_METHOD') == 'POST') {
    
    /**
     * In verison 5.6 of PHP ajax calls are no longer in POST.
     * The request is POST but variables are stored in php://input.
     */
    
    $json_fortag = file_get_contents("php://input");
    $php_fortag = json_decode($json_fortag, true);
    
    $php_fortag_isupdate = isset($php_fortag['_saveId']);
    
    /**
     * First query is to insert or update the tag.
     * Note name is a private word in SQL.
     */
    
    if ($php_fortag_isupdate) {
        $tag_sql = "UPDATE for_platforms
	                SET `name` = '{$php_fortag['enName']}',
	                    tag = '{$php_fortag['tag']}'
	                WHERE platform_id = {$php_fortag ['_saveId']};";
        
        $events['mysql']['operation'] = 'update';
    } else {
        $tag_sql = "INSERT INTO for_platforms
	                   (`name`, tag)
	                VALUES
	                   ('{$php_fortag['enName']}',
	                    '{$php_fortag['tag']}');";
        
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
				 	 'for_platforms',
				 	 '{$php_fortag['tag']}',
				 	 '{$php_fortag['object']}',
				 	 0,
				 	 now(),
				 	 null);";
    
    /**
     * We will execute all queries frist and then submit the transaction.
     */
    
    mysqli_autocommit($link, FALSE);
    
    /**
     * The most important thing is the tag, so we send it first.
     * On failure, there is no point to continue and we can have id gaps.
     */
    
    $tag_result = mysqli_query($link, $tag_sql);
    $log_result = true;
    
    /**
     * Response values used to update later.
     */
    
    $operation['saveId'] = null;
    
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
    }
    
    /**
     * Only accept the transaction, if all results are successuful.
     * Note, on rollback auto-increment for successful transfers is not reset.
     */
    
    if ($tag_result && $log_result) {
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