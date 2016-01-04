<?php
include ('db.php');

if (getenv('REQUEST_METHOD') == 'GET') {
    $get_tag = isset($_GET['tag']) ? "{$_GET ['tag']}" : "ANY (SELECT tag_id FROM for_tags)";
    $get_genre_tag = isset($_GET['tag']) ? "{$_GET ['tag']}" : "ANY (SELECT genre_id FROM for_genres)";
    $get_platform_tag = isset($_GET['tag']) ? "{$_GET ['tag']}" : "ANY (SELECT platform_id FROM for_platforms)";
    $get_sticker_tag = isset($_GET['tag']) ? "{$_GET ['tag']}" : "ANY (SELECT sticker_id FROM for_stickers)";
    $get_object = isset($_GET['object']) ? "'{$_GET ['object']}'" : "ANY (SELECT object FROM for_tags)";
    $get_type = isset($_GET['type']) ? "'{$_GET ['type']}'" : "ANY (SELECT `type` FROM for_tags) OR `type` IS NULL";
    $get_genre_type = isset($_GET['type']) ? "'{$_GET ['type']}'" : "ANY (SELECT `type` FROM for_genres) OR `type` IS NULL";
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
                $get_tag_sql = "SELECT for_tags.*, 
                                       for_games.us_date FROM for_tags
								LEFT JOIN for_games
							   	ON for_tags.tag_id = for_games.tag_id
							   	WHERE for_tags.tag_id = {$get_tag}
							   	GROUP BY tag_id;";
                
                break;
            case 'movie':
                $get_tag_sql = "SELECT for_tags.*, 
                                       for_movies.world_date, 
                                       for_movies.time FROM for_tags
                                LEFT JOIN for_movies
                                ON for_tags.tag_id = for_movies.tag_id
                                WHERE for_tags.tag_id = {$get_tag}
                                GROUP BY tag_id;";
                
                break;
            case 'event':
                $get_tag_sql = "SELECT for_tags.*,
                                for_events.end_date,
                                for_events.city FROM for_tags
                                LEFT JOIN for_events
                                ON for_tags.tag_id = for_events.tag_id
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
							     for_rel_relative.related_subtype = 'cast' OR
							     for_rel_relative.related_subtype = 'director' OR
							     for_rel_relative.related_subtype = 'writer' OR
							     for_rel_relative.related_subtype = 'camera' OR
							     for_rel_relative.related_subtype = 'music' OR
							     for_rel_relative.related_subtype = 'artist' OR
							     for_rel_relative.related_subtype = 'translator' OR
							     for_rel_relative.related_subtype = 'author' OR
								 for_rel_relative.related_subtype IS NULL)
							GROUP BY tag_id, related_tag_id, related_subtype;";
        
        $get_related_stickers_sql = "SELECT for_stickers.sticker_id,
                                            for_stickers.name AS en_name,
                                            for_stickers.tag,
                                            for_stickers.lib,
                                            for_stickers.subtype,
                                            for_rel_relative.related_subtype 
                                     FROM for_stickers
        							 LEFT JOIN for_rel_relative
        							 ON for_stickers.sticker_id = for_rel_relative.related_tag_id
        							 WHERE for_rel_relative.tag_id = {$get_tag}
        							 AND for_rel_relative.related_subtype = 'sticker'
        							 GROUP BY sticker_id;";
        
        $get_related_platforms_sql = "SELECT for_platforms.*, for_rel_relative.related_subtype 
                                      FROM for_platforms
        							  LEFT JOIN for_rel_relative
        							  ON for_platforms.platform_id = for_rel_relative.related_tag_id
        							  WHERE for_rel_relative.tag_id = {$get_tag}
        							  AND for_rel_relative.related_subtype = 'platform'
        							  GROUP BY platform_id;";
        
        $get_related_genres_sql = "SELECT for_genres.*, for_rel_relative.related_subtype 
                                   FROM for_genres
        						   LEFT JOIN for_rel_relative
        						   ON for_genres.genre_id = for_rel_relative.related_tag_id
        						   WHERE for_rel_relative.tag_id = {$get_tag}
        						   AND for_rel_relative.related_subtype = 'genre'
        						   GROUP BY genre_id;";
        
        $get_related_country_sql = "SELECT for_countries.*, for_rel_relative.related_subtype 
                                    FROM for_countries
        						    LEFT JOIN for_rel_relative
        						    ON for_countries.country_id = for_rel_relative.related_tag_id
        						    WHERE for_rel_relative.tag_id = {$get_tag}
        						    AND for_rel_relative.related_subtype = 'country'
        						    GROUP BY country_id;";
        
        $get_related_tracks_sql = "SELECT * FROM for_tracks
                                   WHERE tag_id = {$get_tag}
                                   ORDER BY `order`;";
    }
    
    $get_genres_sql = "SELECT genre_id AS tag_id,
                              name AS bg_name,
                              tag,
                              type
                       FROM for_genres 
					   WHERE genre_id = {$get_genre_tag} 
                       AND `type` = {$get_genre_type};";
    
    $get_platforms_sql = "SELECT platform_id AS tag_id,
                                 name AS en_name,
                                 tag
                          FROM for_platforms
                          WHERE platform_id = {$get_platform_tag}
                          ORDER BY name;";
    
    $get_stickers_sql = "SELECT sticker_id AS tag_id,
                                name AS en_name,
                                tag,
                                lib,
                                subtype
                         FROM for_stickers
                         WHERE sticker_id = {$get_sticker_tag}
                         ORDER BY tag;";
    
    $get_issues_sql = "SELECT issue_id, 
                              name AS en_name, 
                              tag 
                       FROM for_issues 
                       ORDER BY name;";
    
    $get_authors_sql = "SELECT * FROM for_authors ORDER BY en_name;";
    $get_countries_sql = "SELECT * FROM for_countries ORDER BY name;";
    
    $get_tag_result = true;
    $get_related_result = true;
    $get_stickers_result = true;
    $get_platforms_result = true;
    $get_genres_result = true;
    $get_country_result = true;
    $get_tracks_result = true;
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
        case "'album'":
        case "'band'":
        case "'event'":
        case "'book'":
            $get_tag_result = mysqli_query($link, $get_tag_sql);
            
            break;
        
        /**
         * This is in case we search without object.
         */
        
        default:
            $get_tag_result = mysqli_query($link, $get_tag_sql);
            
            break;
    }
    
    if (! $get_tag_result) {
        goto end;
    }
    
    while ($tag = mysqli_fetch_assoc($get_tag_result)) {
        $tags[] = $tag;
    }
    
    /**
     * Append realted, if there is a request for just a single tag.
     */
    
    if (isset($_GET['tag'])) {
        if (isset($_GET['object'])) {
            if ($_GET['object'] == 'genre' || $_GET['object'] == 'platform' ||
                     $_GET['object'] == 'sticker') {
                goto end;
            }
        }
        
        $get_related_result = mysqli_query($link, $get_related_sql);
        
        if (! $get_related_result) {
            goto end;
        }
        
        $get_stickers_result = mysqli_query($link, $get_related_stickers_sql);
        
        if (! $get_stickers_result) {
            goto end;
        }
        
        $get_platforms_result = mysqli_query($link, $get_related_platforms_sql);
        
        if (! $get_platforms_result) {
            goto end;
        }
        
        $get_genres_result = mysqli_query($link, $get_related_genres_sql);
        
        if (! $get_genres_result) {
            goto end;
        }
        
        $get_country_result = mysqli_query($link, $get_related_country_sql);
        
        if (! $get_country_result) {
            goto end;
        }
        
        $get_tracks_result = mysqli_query($link, $get_related_tracks_sql);
        
        if (! $get_tracks_result) {
            goto end;
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
        
        while ($tag = mysqli_fetch_assoc($get_tracks_result)) {
            $tags[0]['tracks'][] = $tag;
        }
    }
    
    end:
    
    if (! $get_tag_result || ! $get_related_result || ! $get_stickers_result ||
             ! $get_platforms_result || ! $get_genres_result ||
             ! $get_country_result || ! $get_tracks_result) {
        $events['mysql']['result'] = false;
        $events['mysql']['code'] = mysqli_errno($link);
        $events['mysql']['error'] = mysqli_error($link);
    } else {
        $events['mysql']['result'] = true;
    }
    
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