<?php
include ('../../../forsecret/db.php');

/**
 * GET will request last 100 results.
 * POST will specify search criteria as JSON.
 */

if (getenv('REQUEST_METHOD') == 'GET' || getenv('REQUEST_METHOD') == 'POST') {
    
    /**
     * In verison 5.6 of PHP ajax calls are no longer in POST.
     * The request is POST but variables are stored in php://input.
     */
    
    $json_forlog = file_get_contents("php://input");
    $php_forlog = json_decode($json_forlog, true);
    
    $get_log_sql = "SELECT * 
                    FROM for_log 
                    ORDER BY isnull(acknowledged) DESC, created DESC;";
    
    $get_log_result = true;
    $update_log_result = true;
    $logs = null;
    
    if (isset($php_forlog['id'])) {
        $php_forlog_acknowledged = $php_forlog['acknowledged'] ? 'now()' : 'NULL';
        
        $update_log_sql = "UPDATE for_log
                           SET acknowledged = $php_forlog_acknowledged
                           WHERE log_id = {$php_forlog['id']};";
        
        $update_log_result = mysqli_query($link, $update_log_sql);
        
        if (! $update_log_result) {
            goto end;
        }
        
        $get_log_sql = "SELECT *
                        FROM for_log
                        WHERE log_id = {$php_forlog['id']};";
    }
    
    $get_log_result = mysqli_query($link, $get_log_sql);
    
    end:
    
    if (! $get_log_result || ! $update_log_result) {
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
    } else {
        $events['mysql']['result'] = true;
        
        while ($log = mysqli_fetch_assoc($get_log_result)) {
            $log['user_name'] = 'Administrator';
            
            $logs[] = $log;
        }
    }
    
    /**
     * Send the response back to the browser in JSON format.
     * And finally close the connection.
     */
    
    echo json_encode(
            array(
                    'logs' => $logs,
                    'events' => $events
            ));
    
    mysqli_close($link);
}
?>