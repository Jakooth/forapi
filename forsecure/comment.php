<?php
include ('../../../forsecret/db.php');

if (getenv('REQUEST_METHOD') == 'GET') {
    $get_comments = isset($_GET['articleId']) ? "'{$_GET ['articleId']}'" : "ANY (SELECT article_id FROM for_comments)";
    
    $comments_sql = "SELECT * FROM for_comments
                     WHERE article_id = $get_comments
                     ORDER BY created ASC;";
    
    $comments_result = mysqli_query($link, $comments_sql);
    
    if (! $comments_result) {
        header('HTTP/1.0 404 Not Found');
        
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
        
        echo json_encode(
                array(
                        'events' => $events
                ));
        
        exit();
    }
    
    $comments = mysqli_fetch_assoc($comments_result);
    
    $events['mysql']['result'] = true;
    
    if (! $comments) {
        $comments = array();
    }
    
    echo json_encode(
            array(
                    'comments' => $comments,
                    'events' => $events
            ));
    
    mysqli_close($link);
}

if (getenv('REQUEST_METHOD') == 'POST') {
    $json = file_get_contents("php://input");
    $post_comment = json_decode($json, true);
    
    $parent_comment_id_sql = isset($post_comment['parent_comment_id']) ? "'{$post_comment ['parent_comment_id']}'" : "null";
    
    if ($post_comment['comment_id']) {
        
        /**
         * TODO: Only admin and the comment owner can update.
         * TODO: If liked, disliked or banned this also need to be updated.
         */
        
        $comment_sql = "UPDATE for_comments
                        SET comment = '{$post_comment['comment']}',
                            updated = now(),
                            flagged = {$post_comment['flagged']},
                            WHERE comment_id = '{$post_comment['comment_id']}';";
        
        $events['mysql']['operation'] = 'update';
    } else {
        
        /**
         * TODO: profile_id is from the post or we take it from here?
         */
        
        $comment_sql = "INSERT INTO for_comments
                            (parent_comment_id, article_id, profile_id, path, comment, created)
                        VALUES
                            ($parent_comment_id_sql,
                            {$post_comment['article_id']},
                           '{$post_comment['path']}',
                            {$post_comment['comment']},
                            now());";
        
        $events['mysql']['operation'] = 'insert';
    }
    
    $comment_result = mysqli_query($link, $comment_sql);
    
    if (! $comment_result) {
        header('HTTP/1.0 404 Not Found');
        
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
        
        echo json_encode(
                array(
                        'events' => $events
                ));
        
        exit();
    }
    
    if ($events['mysql']['operation'] == 'insert') {
        $post_comment['comment_id'] = mysqli_insert_id($link);
    }
    
    /**
     * One last fetch from the data base to get the updated comment.
     * One can update this here in PHP based on the JSON,
     * but I prefer to get the real thing from the data base.
     */
    
    $comment_sql = "SELECT * FROM for_comments
                    WHERE comment_id = {$post_comment['comment_id']}
                    LIMIT 1;";
    
    $comment_result = mysqli_query($link, $comment_sql);
    
    $events['mysql']['result'] = true;
    
    $comment = mysqli_fetch_assoc($comment_result);
    
    echo json_encode(
            array(
                    'comments' => $comment,
                    'events' => $events
            ));
    
    mysqli_close($link);
}

if (getenv('REQUEST_METHOD') == 'DELETE') {
    $json = file_get_contents("php://input");
    $delete_comment = json_decode($json, true);
    
    /**
     * TODO: Only admin and the comment owner can hide a comment.
     */
    
    $comment_sql = "UPDATE for_comments
                    SET updated = now(),
                        banned = {$delete_comment['banned']},
                        WHERE comment_id = '{$delete_comment['comment_id']}';";
    
    $events['mysql']['operation'] = 'update';
    
    $comment_result = mysqli_query($link, $comment_sql);
    
    if (! $comment_result) {
        header('HTTP/1.0 404 Not Found');
        
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
        
        echo json_encode(
                array(
                        'events' => $events
                ));
        
        exit();
    }
    
    $events['mysql']['result'] = true;
    
    $comment = mysqli_fetch_assoc($comment_result);
    
    echo json_encode(
            array(
                    'comments' => $comment,
                    'events' => $events
            ));
    
    mysqli_close($link);
}

?>