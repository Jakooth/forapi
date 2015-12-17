<?php
include ('db.php');

if (getenv('REQUEST_METHOD') == 'GET') {
    $get_tag = isset($_GET['tag']) ? "{$_GET ['tag']}" : "ANY (SELECT tag_id FROM for_tags)";
    $get_object = isset($_GET['object']) ? "'{$_GET ['object']}'" : "ANY (SELECT object FROM for_tags)";
    $get_type = isset($_GET['type']) ? "'{$_GET ['type']}'" : "ANY (SELECT `type` FROM for_tags) OR `type` IS NULL";
    $get_subtype = isset($_GET['subtype']) ? "'{$_GET ['subtype']}'" : "ANY (SELECT subtype FROM for_tags) OR subtype IS NULL";
    $get_order = isset($_GET['object']) ? "tag_id DESC" : "tag ASC";
    
    $get_tag_sql = "SELECT * FROM for_tags 
					WHERE tag_id = {$get_tag}
    				AND (`type` = {$get_type})
    				AND (subtype = {$get_subtype})
    				AND object = {$get_object}
    				ORDER BY {$get_order}
    				LIMIT 100;";
    
    /**
     * For a few objects we store additonal data and the query need to be
     * different.
     * Note we need full information only when searching for a specific object.
     */
    
    if (isset($_GET['tag']) && isset($_GET['object'])) {
        switch ($_GET['object']) {
            case 'game':
                $get_tag_sql = "SELECT for_tags.*, for_games.us_date FROM for_tags
								LEFT JOIN for_games
							   	ON for_tags.tag_id = for_games.tag_id
							   	WHERE for_tags.tag_id = {$get_tag}
							   	GROUP BY tag_id;";
                break;
        }
    }
    
    /**
     * Get single basic tag to open in editor.
     * We select NULL values for clean up puprpose,
     * in case error happens during save.
     */
    
    if (isset($_GET['tag'])) {
        $get_related_sql = "SELECT for_tags.*, for_rel_relative.related_subtype FROM for_tags
							LEFT JOIN for_rel_relative 
							ON for_tags.tag_id = for_rel_relative.related_tag_id
							WHERE for_rel_relative.tag_id = {$get_tag}
							AND (for_rel_relative.related_subtype = 'relation' OR
							     for_rel_relative.related_subtype = 'serie' OR
							     for_rel_relative.related_subtype = 'publisher' OR
							     for_rel_relative.related_subtype = 'developer' OR 
								 for_rel_relative.related_subtype IS NULL)
							GROUP BY tag_id;";
        
        $get_related_stickers_sql = "SELECT for_stickers.*, for_rel_relative.related_subtype FROM for_stickers
        							 LEFT JOIN for_rel_relative
        							 ON for_stickers.sticker_id = for_rel_relative.related_tag_id
        							 WHERE for_rel_relative.tag_id = {$get_tag}
        							 AND for_rel_relative.related_subtype = 'sticker'
        							 GROUP BY sticker_id;";
        
        $get_related_platforms_sql = "SELECT for_platforms.*, for_rel_relative.related_subtype FROM for_platforms
        							  LEFT JOIN for_rel_relative
        							  ON for_platforms.platform_id = for_rel_relative.related_tag_id
        							  WHERE for_rel_relative.tag_id = {$get_tag}
        							  AND for_rel_relative.related_subtype = 'platform'
        							  GROUP BY platform_id;";
        
        $get_related_genres_sql = "SELECT for_genres.*, for_rel_relative.related_subtype FROM for_genres
        						   LEFT JOIN for_rel_relative
        						   ON for_genres.genre_id = for_rel_relative.related_tag_id
        						   WHERE for_rel_relative.tag_id = {$get_tag}
        						   AND for_rel_relative.related_subtype = 'genre'
        						   GROUP BY genre_id;";
        
        $get_related_country_sql = "SELECT for_countries.*, for_rel_relative.related_subtype FROM for_countries
        						    LEFT JOIN for_rel_relative
        						    ON for_countries.country_id = for_rel_relative.related_tag_id
        						    WHERE for_rel_relative.tag_id = {$get_tag}
        						    AND for_rel_relative.related_subtype = 'country'
        						    GROUP BY country_id;";
    }
    
    $get_genres_sql = "SELECT * FROM for_genres 
					   WHERE `type` = {$get_type};";
    
    $get_platforms_sql = "SELECT * FROM for_platforms ORDER BY name";
    $get_stickers_sql = "SELECT * FROM for_stickers ORDER BY tag";
    $get_authors_sql = "SELECT * FROM for_authors ORDER BY en_name";
    $get_issues_sql = "SELECT * FROM for_issues ORDER BY name";
    $get_countries_sql = "SELECT * FROM for_countries ORDER BY name";
    
    $get_tag_result = true;
    $tags = array();
    
    switch ($get_object) {
        case "'author'":
            $get_tag_result = mysqli_query($link, $get_authors_sql);
            
            break;
        case "'sticker'":
            $get_tag_result = mysqli_query($link, $get_stickers_sql);
            
            break;
        case "'genre'":
            $get_tag_result = mysqli_query($link, $get_genres_sql);
            
            break;
        case "'platform'":
            $get_tag_result = mysqli_query($link, $get_platforms_sql);
            
            break;
        case "'country'":
            $get_tag_result = mysqli_query($link, $get_countries_sql);
            
            break;
        case "'issue'":
            $get_tag_result = mysqli_query($link, $get_issues_sql);
            
            break;
        case "'game'":
        case "'movie'":
        case "'company'":
        case "'serie'":
        case "'event'":
            $get_tag_result = mysqli_query($link, $get_tag_sql);
            
            break;
        default:
            $get_tag_result = mysqli_query($link, $get_tag_sql);
    }
    
    if (! $get_tag_result) {
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
        
        goto end;
    } else {
        $events['mysql']['result'] = true;
    }
    
    while ($tag = mysqli_fetch_assoc($get_tag_result)) {
        $tags[] = $tag;
    }
    
    /**
     * Append realted, if there is a request for just a single tag.
     */
    
    if (isset($_GET['tag'])) {
        $get_related_result = mysqli_query($link, $get_related_sql);
        $get_stickers_result = mysqli_query($link, $get_related_stickers_sql);
        $get_platforms_result = mysqli_query($link, $get_related_platforms_sql);
        $get_genres_result = mysqli_query($link, $get_related_genres_sql);
        $get_country_result = mysqli_query($link, $get_related_country_sql);
        
        if (! $get_related_result || ! $get_stickers_result ||
                 ! $get_platforms_result || ! $get_genres_result ||
                 ! $get_country_result) {
            $events['mysql']['result'] = false;
            $events['mysql']['code'] = mysqli_errno($link);
            $events['mysql']['error'] = mysqli_error($link);
            
            goto end;
        } else {
            $events['mysql']['result'] = true;
        }
        
        while ($tag = mysqli_fetch_assoc($get_related_result)) {
            $tags[0]['related'][] = $tag;
        }
        
        while ($tag = mysqli_fetch_assoc($get_stickers_result)) {
            $tags[0]['related'][] = $tag;
        }
        
        while ($tag = mysqli_fetch_assoc($get_platforms_result)) {
            $tags[0]['related'][] = $tag;
        }
        
        while ($tag = mysqli_fetch_assoc($get_genres_result)) {
            $tags[0]['related'][] = $tag;
        }
        
        while ($tag = mysqli_fetch_assoc($get_country_result)) {
            $tags[0]['related'][] = $tag;
        }
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