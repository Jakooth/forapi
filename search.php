<?php
include ('db.php');

/**
 * GET will request last 100 results.
 * POST will specify search criteria as JSON.
 */

if (getenv('REQUEST_METHOD') == 'GET' || getenv('REQUEST_METHOD') == 'POST') {
    
    /**
     * In verison 5.6 of PHP ajax calls are no longer in POST.
     * The request is POST but variables are stored in php://input.
     */
    
    $json_forsearch = file_get_contents("php://input");
    $php_forsearch = json_decode($json_forsearch, true);
    
    /**
     * Consider we can also search with GET request.
     */
    
    if (isset($_GET['table'])) {
        $php_forsearch['table'] = $_GET['table'];
    }
    
    $get_tag_where = "";
    $get_article_where = "";
    $get_genre_where = "";
    $get_tag_sql = "";
    $get_article_sql = "";
    
    /**
     * Tag negates all other where clauses.
     * Single item has all search criteria set in the tag object.
     */
    
    if (isset($php_forsearch['type'])) {
        $get_article_where = "WHERE for_articles.type = '{$php_forsearch['type']}'";
        $get_tag_where = "WHERE for_tags.type = '{$php_forsearch['type']}'";
        $get_genre_where = "WHERE for_genres.type = '{$php_forsearch['type']}'";
    }
    
    if (isset($php_forsearch['subtype'])) {
        if (strlen($get_article_where) > 0) {
            $get_article_where .= "AND for_articles.subtype = '{$php_forsearch['subtype']}'";
        } else {
            $get_article_where = "WHERE for_articles.subtype = '{$php_forsearch['subtype']}'";
        }
    }
    
    if (isset($php_forsearch['tag'])) {
        switch ($php_forsearch['tag'][0]['table']) {
            case 'for_articles':
                $get_article_where = "WHERE for_articles.url = '{$php_forsearch['tag'][0]['tag']}'
									  AND for_articles.subtype = '{$php_forsearch['tag'][0]['object']}'";
                
                break;
            case 'for_tags':
                $get_tag_where = "WHERE for_tags.tag = '{$php_forsearch['tag'][0]['tag']}'
								  AND for_tags.object = '{$php_forsearch['tag'][0]['object']}'";
                
                break;
        }
    }
    
    $get_tag_sql = "SELECT for_tags.tag_id,
						   for_tags.en_name,
						   for_tags.tag,
						   for_tags.object,
						   for_log.created,
						   'for_tags' AS `table`
					FROM for_tags
					LEFT JOIN forplay.for_log
					ON for_tags.tag = for_log.tag
					AND for_tags.object = for_log.object
					{$get_tag_where}
					GROUP BY for_tags.tag, for_tags.object";
    
    $get_article_sql = "SELECT for_articles.article_id AS tag_id,
							   for_articles.title AS en_name,
							   for_articles.url  AS tag,
							   for_articles.subtype AS object,
							   for_log.created,
							   'for_articles' AS `table`
						FROM for_articles
						LEFT JOIN for_log
						ON for_articles.url = for_log.tag
						AND for_log.table = 'for_articles'
						{$get_article_where}			
						GROUP BY for_articles.url";
    
    $get_genre_sql = "SELECT for_genres.genre_id AS tag_id,
                             for_genres.name AS en_name,
                             for_genres.tag,
                             'genre' AS object
                      FROM for_genres       
                      {$get_genre_where};";
    
    $get_platform_sql = "SELECT for_platforms.platform_id AS tag_id,
                                for_platforms.name AS en_name,
                                for_platforms.tag,
                                'platform' AS object
                        FROM for_platforms;";
    
    $get_sticker_sql = "SELECT for_stickers.sticker_id AS tag_id,
                               for_stickers.name AS en_name,
                               for_stickers.tag,
                               for_stickers.lib,
                               for_stickers.subtype,
                               'sticker' AS object
                        FROM for_stickers;";
    
    /**
     * TODO: At some point this limit can cause issues.
     */
    
    $get_result_sql = "ORDER BY created DESC 
					   LIMIT 100000;";
    
    if (isset($php_forsearch['tag'])) {
        switch ($php_forsearch['tag'][0]['table']) {
            case 'for_articles':
                $get_search_sql = "{$get_article_sql}
								   {$get_result_sql}";
                
                break;
            case 'for_tags':
                $get_search_sql = "{$get_tag_sql}
								   {$get_result_sql}";
                
                break;
            case 'for_imgs':
                
                /**
                 * TODO: Images tables are not yet ready.
                 */
                
                break;
        }
    } else {
        if (isset($php_forsearch['table'])) {
            switch ($php_forsearch['table']) {
                case 'articles':
                    $get_search_sql = "{$get_article_sql}
									   {$get_result_sql}";
                    
                    break;
                case 'tags':
                    $get_search_sql = "{$get_tag_sql}
									   {$get_result_sql}";
                    
                    break;
                case 'genres':
                    $get_search_sql = "{$get_genre_sql}";
                    
                    break;
                case 'platforms':
                    $get_search_sql = "{$get_platform_sql}";
                    
                    break;
                case 'stickers':
                    $get_search_sql = "{$get_sticker_sql}";
                    
                    break;
                case 'imgs':
                    
                    /**
                     * TODO: Images tables are not yet ready.
                     */
                    
                    break;
            }
        } else {
            $get_search_sql = "{$get_tag_sql} 
						   
						   	   UNION ALL
						   
						   	   {$get_article_sql}
						   	   {$get_result_sql}";
        }
    }
    
    $get_search_result = true;
    $tags = array();
    
    $get_search_result = mysqli_query($link, $get_search_sql);
    
    if (! $get_search_result) {
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
        
        goto end;
    } else {
        $events['mysql']['result'] = true;
    }
    
    while ($tag = mysqli_fetch_assoc($get_search_result)) {
        $tags[] = $tag;
    }
    
    end:
    
    /**
     * Send the response back to the browser in JSON format.
     * And finally close the connection.
     */
    
    echo json_encode(
            array(
                    'tags' => $tags,
                    'events' => $events
            ));
    
    mysqli_close($link);
}
?>