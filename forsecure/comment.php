<?php
include ('../../../forsecret/db.php');

/**
 * Get compelte profile information first.
 * This is based on PHP authentication, not on POST data.
 * This is valid for all methods.
 */

$user_email_sql = isset($user['email']) ? "'{$user['email']}'" : "null";
$profile_sql = "SELECT * FROM for_profiles
                WHERE email = $user_email_sql
                LIMIT 1;";

$profile_result = mysqli_query($link, $profile_sql);
$profile = mysqli_fetch_assoc($profile_result);

/**
 * Get notifications for new comments.
 */

if (getenv('REQUEST_METHOD') == 'GET' && isset($_GET['profileId'])) {
    $notifications = array();
    
    if (! $profile) {
        header('HTTP/1.0 401 Unauthorized');
        
        $events['comments']['message'] = 'Not authenticated.';
        
        echo json_encode(
                array(
                        'events' => $events
                ));
        
        exit();
    }
    
    $comments_sql = "SELECT for_rel_comments.*,
                            for_articles.article_id,
                            for_articles.type,
                            for_articles.subtype,
                            for_articles.title,
                            for_articles.url,
                            for_articles.caret_img
                     FROM for_rel_comments
                     LEFT JOIN for_articles
                     ON for_rel_comments.article_id = for_articles.article_id
                     WHERE for_rel_comments.profile_id = {$profile['profile_id']}
                     AND for_rel_comments.read > (now() - INTERVAL 1 MONTH)
                     ORDER BY for_rel_comments.read;";
    
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
    
    /**
     * Count the number of new comments for each item.
     */
    
    while ($comment = mysqli_fetch_assoc($comments_result)) {
        $unread_sql = "SELECT for_comments.*
                       FROM for_comments
                       WHERE article_id = {$comment['article_id']}
                       AND created > '{$comment['read']}'
                       ORDER BY created DESC;";
        
        $unread_result = mysqli_query($link, $unread_sql);
        
        if (! $unread_result) {
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
        
        $latest = mysqli_fetch_assoc($unread_result);
        
        mysqli_data_seek($unread_result, 0);
        
        $comment['latest'] = $latest['comment_id'];
        $comment['unread'] = mysqli_num_rows($unread_result);
        
        if ($comment['unread'] > 0)
            $notifications[] = $comment;
    }
    
    /**
     * At the end consider that the new comments are viewed.
     * Do not display them again.
     */
    
    $comment_sql = "UPDATE for_rel_comments
                    SET read = now()
                    WHERE profile_id = {$profile['profile_id']};";
    
    /**
     * TODO: Commit this thing above to MySQL.
     */
    
    echo json_encode(
            array(
                    'notifications' => $notifications,
                    'events' => $events
            ));
    
    mysqli_close($link);
}

/**
 * Get comments by article.
 */

if (getenv('REQUEST_METHOD') == 'GET' && ! isset($_GET['profileId'])) {
    $get_comments_sql = isset($_GET['articleId']) ? "'{$_GET ['articleId']}'" : "ANY (SELECT article_id FROM for_comments)";
    $profile_id_sql = isset($profile) ? "{$profile['profile_id']}" : "null";
    
    $comments_sql = "SELECT for_comments.*, 
                            for_profiles.email, 
                            for_profiles.nickname, 
                            for_profiles.given_name, 
                            for_profiles.family_name, 
                            for_profiles.avatar,
                            for_likes.liked,
                            for_likes.disliked,
                            for_likes.flagged,
                            for_articles.type,
                            for_articles.subtype,
                            for_articles.title,
                            for_articles.url,
                            for_articles.caret_img
                     FROM for_comments
                     LEFT JOIN for_articles
                     ON for_comments.article_id = for_articles.article_id
                     LEFT JOIN for_profiles
                     ON for_comments.profile_id = for_profiles.profile_id
                     LEFT JOIN for_likes
                     ON for_comments.comment_id = for_likes.comment_id 
                     AND for_likes.profile_id = $profile_id_sql
                     WHERE for_comments.article_id = $get_comments_sql
                     ORDER BY path;";
    
    $comments_result = mysqli_query($link, $comments_sql);
    
    if (! $comments_result) {
        header('HTTP/1.0 404 Not Found');
        
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
        $events['comments']['message'] = 'Unacceptable article identifier was sent. Are you sure you accessing this page from forplay.bg';
        
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
    $path_sql = "''";
    
    $comment_sql = false;
    $like_sql = false;
    
    if (isset($post_comment['parentCommentId'])) {
        $get_parent_comment_sql = "SELECT * FROM for_comments
                                   WHERE comment_id = {$post_comment['parentCommentId']}
                                   LIMIT 1;";
        
        $comment_result = mysqli_query($link, $get_parent_comment_sql);
        
        if (! $comment_result) {
            header('HTTP/1.0 404 Not Found');
            
            $events['mysql']['result'] = false;
            $events['mysql']['code'] = mysqli_errno($link);
            $events['mysql']['error'] = mysqli_error($link);
            $events['comments']['message'] = 'The comment you are trying to reply probably no longer exists. Please refersh the page and try again.';
            
            echo json_encode(
                    array(
                            'events' => $events
                    ));
            
            exit();
        }
        
        $parent_comment = mysqli_fetch_assoc($comment_result);
        
        if (! sizeof($parent_comment['path']) == 42) {
            header('HTTP/1.0 401 Unauthorized');
            
            $events['comments']['message'] = 'Too many replies. Our data base is about to expode. Please chat with your mate in another manner.';
            
            echo json_encode(
                    array(
                            'events' => $events
                    ));
            
            exit();
        }
    }
    
    if (isset($post_comment['commentId'])) {
        $profile_id_sql = isset($profile) ? "{$profile['profile_id']}" : "null";
        $get_comment_sql = "SELECT for_comments.profile_id,
                                   for_comments.article_id,
                                   for_likes.liked,
                                   for_likes.disliked,
                                   for_likes.flagged
                            FROM for_comments
                            LEFT JOIN for_likes
                            ON for_comments.comment_id = for_likes.comment_id
                            AND for_likes.profile_id = $profile_id_sql
                            WHERE for_comments.comment_id = {$post_comment['commentId']}
                            LIMIT 1;";
        
        /**
         * Prevent someone editing other comments.
         * This is impossible from the UI,
         * but just in case a protection on API side.
         */
        
        $is_comment_invalid = false;
        
        $comment_result = mysqli_query($link, $get_comment_sql);
        
        if (! $comment_result) {
            header('HTTP/1.0 404 Not Found');
            
            $events['mysql']['result'] = false;
            $events['mysql']['code'] = mysqli_errno($link);
            $events['mysql']['error'] = mysqli_error($link);
            $events['comments']['message'] = 'The comment you are trying to update probably no longer exists. Please refersh the page and try again.';
            
            echo json_encode(
                    array(
                            'events' => $events
                    ));
            
            exit();
        }
        
        $comment = mysqli_fetch_assoc($comment_result);
        
        if (isset($post_comment['liked'])) {
            $like_sql = "INSERT INTO for_likes (comment_id, profile_id, liked) 
                         VALUES ({$post_comment['commentId']}, 
                                 {$profile['profile_id']}, 
                                 {$post_comment['liked']}) 
                         ON DUPLICATE KEY UPDATE liked = NOT liked;";
            
            $likes_sql = $post_comment['liked'] == 0 ? "-" : "+";
            $comment_sql = "UPDATE for_comments
                            SET likes = likes {$likes_sql} 1
                            WHERE comment_id = {$post_comment['commentId']};";
            
            if ($comment['profile_id'] == $profile['profile_id'])
                $is_comment_invalid = true;
            if ($comment['liked'] == $post_comment['liked'])
                $is_comment_invalid = true;
        } else 
            if (isset($post_comment['disliked'])) {
                $like_sql = "INSERT INTO for_likes (comment_id, profile_id, disliked)
                             VALUES ({$post_comment['commentId']}, 
                                     {$profile['profile_id']}, 
                                     {$post_comment['disliked']})
                             ON DUPLICATE KEY UPDATE disliked = NOT disliked;";
                
                $likes_sql = $post_comment['disliked'] == 0 ? "-" : "+";
                $comment_sql = "UPDATE for_comments
                                SET dislikes = dislikes {$likes_sql} 1
                                WHERE comment_id = {$post_comment['commentId']};";
                
                if ($comment['profile_id'] == $profile['profile_id'])
                    $is_comment_invalid = true;
                if ($comment['disliked'] == $post_comment['disliked'])
                    $is_comment_invalid = true;
            } else 
                if (isset($post_comment['flagged'])) {
                    $like_sql = "INSERT INTO for_likes (comment_id, profile_id, flagged)
                                 VALUES ({$post_comment['commentId']}, 
                                         {$profile['profile_id']}, 
                                         {$post_comment['flagged']})
                                 ON DUPLICATE KEY UPDATE flagged = NOT flagged;";
                    
                    $likes_sql = $post_comment['flagged'] == 0 ? "-" : "+";
                    $comment_sql = "UPDATE for_comments
                                    SET flags = flags {$likes_sql} 1
                                    WHERE comment_id = {$post_comment['commentId']};";
                    
                    if ($comment['profile_id'] == $profile['profile_id'])
                        $is_comment_invalid = true;
                    if ($comment['flagged'] == $post_comment['flagged'])
                        $is_comment_invalid = true;
                } else 
                    if (isset($post_comment['banned'])) {
                        $comment_sql = "UPDATE for_comments
                                        SET banned = NOT banned,
                                            updated = now()
                                        WHERE comment_id = {$post_comment['commentId']};";
                        
                        if ($user['app_metadata']['roles'][0] != 'admin' && $user['app_metadata']['roles'][0] !=
                                 'superadmin')
                            $is_comment_invalid = true;
                    } else {
                        $comment_sql = "UPDATE for_comments
                                        SET comment = '{$post_comment['comment']}',
                                            updated = now()
                                        WHERE comment_id = {$post_comment['commentId']};";
                        
                        if ($comment['profile_id'] != $profile['profile_id'])
                            $is_comment_invalid = true;
                    }
        
        if ($is_comment_invalid) {
            header('HTTP/1.0 401 Unauthorized');
            
            $events['comments']['message'] = 'You do not have persmissions to do this.';
            
            echo json_encode(
                    array(
                            'events' => $events
                    ));
            
            exit();
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
    
    if ($like_sql) {
        $like_result = mysqli_query($link, $like_sql);
    }
    
    if (! $comment_result && ! ($like_sql && ! $like_result)) {
        header('HTTP/1.0 404 Not Found');
        
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
        $events['comments']['message'] = 'Failed to insert or update comment. Refer to the mysql error message.';
        
        echo json_encode(
                array(
                        'events' => $events
                ));
        
        exit();
    }
    
    switch ($events['mysql']['operation']) {
        case 'insert':
            $post_comment['commentId'] = mysqli_insert_id($link);
            
            /**
             * No need for divider like ".", "/" or "_".
             * The number is 255 character HEX on 6 digits chunks.
             */
            
            $path_hex = sprintf("%06X", $post_comment['commentId']);
            $path_sql = isset($parent_comment['path']) ? "'{$parent_comment ['path']}$path_hex'" : "'$path_hex'";
            
            /**
             * Always generate a path for proper sorting.
             * Do this only, if this is root level comment.
             */
            
            $comment_sql = "UPDATE for_comments
                            SET path = $path_sql
                            WHERE comment_id = {$post_comment['commentId']};";
            
            $comment_result = mysqli_query($link, $comment_sql);
            
            break;
    }
    
    /**
     * Subscribe to update notifications.
     */
    
    $article_sql = isset($post_comment['articleId']) ? $post_comment['articleId'] : $comment['article_id'];
    $comment_rel_sql = "INSERT INTO for_rel_comments 
                               (profile_id, article_id, `read`)
                        VALUES ({$profile['profile_id']}, 
                                 $article_sql, 
                                 now())
                        ON DUPLICATE KEY UPDATE `read` = now();";
    
    $comment_result = mysqli_query($link, $comment_rel_sql);
    
    /**
     * One last fetch from the data base to get the updated comment.
     * One can update this here in PHP based on the JSON,
     * but I prefer to get the real thing from the data base.
     */
    
    $comment_sql = "SELECT * FROM for_comments
                    WHERE comment_id = {$post_comment['commentId']}
                    LIMIT 1;";
    
    $comment_result = mysqli_query($link, $comment_sql);
    $comment = mysqli_fetch_assoc($comment_result);
    
    $events['mysql']['result'] = true;
    
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
    
    $get_comment_sql = "SELECT for_comments.profile_id
                        FROM for_comments
                        WHERE comment_id = {$delete_comment['commentId']}
                        LIMIT 1;";
    
    /**
     * Prevent someone deleting other comments.
     * This is impossible from the UI,
     * but just in case a protection on API side.
     */
    
    $is_comment_invalid = false;
    
    $comment_result = mysqli_query($link, $get_comment_sql);
    
    if (! $comment_result) {
        header('HTTP/1.0 404 Not Found');
        
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
        $events['comments']['message'] = 'The comment you are trying to delete probably no longer exists. Please refersh the page and try again.';
        
        echo json_encode(
                array(
                        'events' => $events
                ));
        
        exit();
    }
    
    $comment = mysqli_fetch_assoc($comment_result);
    
    if ($comment['profile_id'] != $profile['profile_id'])
        $is_comment_invalid = true;
    
    if ($is_comment_invalid) {
        header('HTTP/1.0 401 Unauthorized');
        
        $events['comments']['message'] = 'You do not have persmissions to do this.';
        
        echo json_encode(
                array(
                        'events' => $events
                ));
        
        exit();
    }
    
    $get_comment_sql = "UPDATE for_comments
                        SET deleted = {$delete_comment['deleted']}
                        WHERE comment_id = {$delete_comment['commentId']};";
    
    $events['mysql']['operation'] = 'update';
    
    $comment_result = mysqli_query($link, $get_comment_sql);
    
    if (! $comment_result) {
        header('HTTP/1.0 404 Not Found');
        
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
        $events['comments']['message'] = 'Failed to delete the comment. Refer to the mysql error message.';
        
        echo json_encode(
                array(
                        'events' => $events
                ));
        
        exit();
    }
    
    /**
     * One last fetch from the data base to get the updated comment.
     * One can update this here in PHP based on the JSON,
     * but I prefer to get the real thing from the data base.
     */
    
    $comment_sql = "SELECT * FROM for_comments
                    WHERE comment_id = {$delete_comment['commentId']}
                    LIMIT 1;";
    
    $comment_result = mysqli_query($link, $comment_sql);
    $comment = mysqli_fetch_assoc($comment_result);
    
    $events['mysql']['result'] = true;
    
    echo json_encode(
            array(
                    'comments' => $comment,
                    'events' => $events
            ));
    
    mysqli_close($link);
}

?>