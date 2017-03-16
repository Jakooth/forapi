<?php
include ('../../../forsecret/db.php');

if (getenv('REQUEST_METHOD') == 'GET') {
    $get_comments = isset($_GET['articleId']) ? "'{$_GET ['articleId']}'" : "ANY (SELECT article_id FROM for_comments)";
    
    $comments_sql = "SELECT for_comments.*, for_profiles.* 
                     FROM for_comments
                     LEFT JOIN for_profiles
                     ON for_comments.profile_id = for_profiles.profile_id
                     WHERE article_id = $get_comments
                     ORDER BY COALESCE(path, parent_comment_id, comment_id), 
                    				   path IS NOT NULL,
                                       parent_comment_id IS NOT NULL, 
                                       comment_id;";
    
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
    
    $events['mysql']['result'] = true;
    
    $comments = array();
    
    if (! $comments) {
        $comments = array();
    }
    
    while ($comment = mysqli_fetch_assoc($comments_result)) {
        $comments[] = $comment;
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
    
    $parent_comment_id_sql = isset($post_comment['parentCommentId']) ? "'{$post_comment ['parentCommentId']}'" : "null";
    $path_sql = isset($post_comment['path']) ? "'{$post_comment ['path']}'" : "null";
    
    /**
     * Get compelte profile information first.
     * This is based on PHP authentication, not on POST data.
     * TODO: Only admin and the comment owner can update.
     * TODO: If liked, disliked or banned this also need to be updated.
     */
    
    $profile_sql = "SELECT * FROM for_profiles
                    WHERE email = '{$user['email']}'
                    LIMIT 1;";
    
    $profile_result = mysqli_query($link, $profile_sql);
    $profile = mysqli_fetch_assoc($profile_result);
    
    if (isset($post_comment['commentId'])) {
        if (isset($post_comment['liked'])) {
            $comment_sql = "INSERT INTO for_likes (comment_id, profile_id, liked) 
                            VALUES ({$post_comment['commentId']}, 
                                    {$profile['profile_id']}, 
                                    {$post_comment['liked']}) 
                            ON DUPLICATE KEY UPDATE liked = NOT liked;";
        } else 
            if (isset($post_comment['disliked'])) {
                $comment_sql = "INSERT INTO for_likes (comment_id, profile_id, disliked)
                                VALUES ({$post_comment['commentId']}, 
                                        {$profile['profile_id']}, 
                                        {$post_comment['disliked']})
                                ON DUPLICATE KEY UPDATE disliked = NOT disliked;";
            } else 
                if (isset($post_comment['flagged'])) {
                    $comment_sql = "INSERT INTO for_likes (comment_id, profile_id, flagged)
                                    VALUES ({$post_comment['commentId']}, 
                                            {$profile['profile_id']}, 
                                            {$post_comment['flagged']})
                                    ON DUPLICATE KEY UPDATE flagged = NOT flagged;";
                } else {
                    $comment_sql = "UPDATE for_comments
                                    SET comment = '{$post_comment['comment']}',
                                        updated = now()
                                        WHERE comment_id = {$post_comment['commentId']};";
                }
        
        $events['mysql']['operation'] = 'update';
    } else {
        $comment_sql = "INSERT INTO for_comments
                            (parent_comment_id, article_id, profile_id, path, comment, created)
                        VALUES
                            ($parent_comment_id_sql,
                            {$post_comment['articleId']},
                            {$profile['profile_id']},
                             $path_sql,
                           '{$post_comment['comment']}',
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
    
    switch ($events['mysql']['operation']) {
        case 'insert':
            $post_comment['commentId'] = mysqli_insert_id($link);
            
            break;
    }
    
    /**
     * One last fetch from the data base to get the updated comment.
     * One can update this here in PHP based on the JSON,
     * but I prefer to get the real thing from the data base.
     */
    
    $comment_sql = "SELECT * FROM for_comments
                    WHERE comment_id = {$post_comment['commentId']}
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
                        deleted = {$delete_comment['deleted']},
                        WHERE comment_id = '{$delete_comment['commentId']}';";
    
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