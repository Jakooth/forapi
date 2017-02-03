<?php
include ('../../forsecret/db.php');

if (getenv('REQUEST_METHOD') == 'GET') {
    $get_tag = isset($_GET['tag']) ? "{$_GET ['tag']}" : "ANY (SELECT for_articles.article_id FROM for_articles)";
    $get_url = isset($_GET['url']) ? "'{$_GET ['url']}'" : "ANY (SELECT url FROM for_articles)";
    $get_type = isset($_GET['type']) ? "'{$_GET ['type']}'" : "ANY (SELECT `type` FROM for_articles)";
    $get_subtype = isset($_GET['subtype']) ? "'{$_GET ['subtype']}'" : "ANY (SELECT subtype FROM for_articles)";
    $get_issue = isset($_GET['issue']) ? "'{$_GET ['issue']}'" : false;
    $get_author = isset($_GET['author']) ? "'{$_GET ['author']}'" : false;
    $get_suggest = isset($_GET['suggest']) ? "{$_GET ['suggest']}" : false;
    
    /**
     * This is the pagination to lazy load articles.
     * By default we start from the first result.
     */
    
    $get_offset = isset($_GET['offset']) ? "{$_GET ['offset']}" : 0;
    $get_limit = isset($_GET['limit']) ? "{$_GET ['limit']}" : 50;
    
    /**
     * 1 of 5: Get portal based on type and subtype.
     */
    
    $get_article_sql = "SELECT for_articles.*, 
                               for_issues.`name` AS issue, 
                               for_issues.tag AS issue_tag 
                        FROM for_articles
                        INNER JOIN for_rel_issues ON for_articles.article_id = for_rel_issues.article_id
                        INNER JOIN for_issues ON for_issues.issue_id = for_rel_issues.issue_id 
						WHERE for_articles.article_id = $get_tag
	                    AND (url = $get_url)
    					AND (`type` = $get_type)
    					AND (subtype = $get_subtype)
    					AND for_articles.`date` <= now()
                        ORDER BY date DESC
                        LIMIT $get_limit OFFSET $get_offset;";
    
    /**
     * 2 of 5: Main page load - all articles, excluding some quotes and carets.
     * Also suggested articles by tag when opening another material.
     */
    
    if (count($_GET) <= 0 || $get_issue ||
             (count($_GET) == 1 && isset($_GET['offset']) &&
             ! isset($_GET['tag'])) || (count($_GET) == 1 &&
             isset($_GET['offset']) && ! isset($_GET['tag'])) || (count($_GET) ==
             3 && isset($_GET['suggest']) && isset($_GET['tag']) &&
             isset($_GET['offset']))) {
        
        $sort = array();
        $not = '';
        
        if ($get_suggest) {
            $php_suggest = explode(',', urldecode($get_suggest));
            
            foreach ($php_suggest as $tag) {
                array_push($sort, 
                        "group_concat(for_rel_tags.tag_id SEPARATOR ',') LIKE '%$tag%' DESC");
            }
            
            $sort = join(', ', $sort) . ',  ';
            $not = "AND for_articles.article_id != $get_tag";
        } else {
            $sort = '';
        }
        
        $get_article_sql = "SELECT for_articles.*, 
                                   for_issues.`name` AS issue, 
                                   for_issues.tag AS issue_tag 
                            FROM for_articles
                            INNER JOIN for_rel_issues ON for_articles.article_id = for_rel_issues.article_id
                            INNER JOIN for_issues ON for_issues.issue_id = for_rel_issues.issue_id
                            INNER JOIN for_rel_tags ON for_articles.article_id = for_rel_tags.article_id
                            WHERE (subtype 
                            IN ('news', 'video', 'review', 'feature') 
                            OR (subtype = 'aside' AND priority = 'aside')) 
                            AND for_articles.`date` <= now()
                            $not
                            GROUP BY for_articles.article_id
                            ORDER BY $sort date DESC
                            LIMIT $get_limit OFFSET $get_offset;";
    }
    
    /**
     * TODO: 3 of 5: Get specific issue or the latest one.
     * This is the backup for getting the latest issue:
     * AND for_rel_issues.issue_id = (SELECT max(for_rel_issues.issue_id) FROM
     * for_rel_issues)
     */
    
    /**
     * 4 of 5: Get articles by author.
     */
    
    if ($get_author) {
        $get_article_sql = "SELECT for_articles.*,
                                   for_issues.`name` AS issue,
                                   for_issues.tag AS issue_tag
                            FROM for_articles
                            INNER JOIN for_rel_issues ON for_articles.article_id = for_rel_issues.article_id
                            INNER JOIN for_issues ON for_issues.issue_id = for_rel_issues.issue_id
                            INNER JOIN for_rel_authors ON for_articles.article_id = for_rel_authors.article_id
                            WHERE (subtype
                            IN ('news', 'video', 'review', 'feature')
                            OR (subtype = 'aside' AND priority = 'aside'))
                            AND for_articles.`date` <= now()
                            AND for_rel_authors.author_id = $get_author
                            ORDER BY date DESC
                            LIMIT $get_limit OFFSET $get_offset;";
    }
    
    /**
     * There is duplicate of this query below.
     */
    
    $get_authors_sql = "SELECT for_authors.* FROM for_authors
        			    LEFT JOIN for_rel_authors
        				ON for_authors.author_id = for_rel_authors.author_id
        			    WHERE for_rel_authors.article_id = $get_tag
        			    GROUP BY author_id;";
    
    $get_tags_sql = "SELECT for_tags.*, for_rel_tags.prime FROM for_tags
                     LEFT JOIN for_rel_tags
                     ON for_tags.tag_id = for_rel_tags.tag_id
                     WHERE for_rel_tags.article_id = $get_tag
                     GROUP BY tag_id
                     ORDER BY for_rel_tags.prime DESC;";
    
    $get_layouts_sql = "SELECT for_layouts.*
                        FROM for_layouts
                        WHERE article_id = $get_tag
                        ORDER BY `order`;";
    
    $get_issue_sql = "SELECT for_issues.issue_id,
                             for_issues.name AS en_name,
                             for_issues.tag
                      FROM for_issues
                      LEFT JOIN for_rel_issues
                      ON for_issues.issue_id = for_rel_issues.issue_id
                      WHERE for_rel_issues.article_id = $get_tag
                      GROUP BY issue_id;";
    
    $get_article_result = true;
    $get_authors_result = true;
    $get_layouts_result = true;
    $get_tags_result = true;
    $get_issue_result = true;
    $get_imgs_result = true;
    $articles = array();
    $covers_counter = 0;
    
    /**
     * Article basic information.
     */
    
    $get_article_result = mysqli_query($link, $get_article_sql);
    
    if (! $get_article_result) {
        goto end;
    }
    
    /**
     * 5 of 5: Work in progress articles from the adminstration UI.
     */
    
    if (mysqli_num_rows($get_article_result) <= 0 && ! isset($_GET['offset'])) {
        $get_article_sql = "SELECT for_articles.*
                            FROM for_articles
    						WHERE for_articles.article_id = $get_tag
    	                    AND (url = $get_url)
        					AND (`type` = $get_type)
        					AND (subtype = $get_subtype)
                            ORDER BY date DESC
                            LIMIT $get_limit OFFSET $get_offset;";
        
        $get_article_result = mysqli_query($link, $get_article_sql);
    }
    
    while ($article = mysqli_fetch_assoc($get_article_result)) {
        if ($article['subtype'] == 'review' || $article['subtype'] == 'video') {
            
            $get_better_sql = "SELECT for_tags.*
                               FROM for_tags
                               WHERE tag_id = {$article['better']};";
            
            $get_worse_sql = "SELECT for_tags.*
                              FROM for_tags
                              WHERE tag_id = {$article['worse']};";
            
            $get_equal_sql = "SELECT for_tags.*
                              FROM for_tags
                              WHERE tag_id = {$article['equal']};";
            
            $get_bwe_result = mysqli_query($link, $get_better_sql);
            
            if ($get_bwe_result) {
                while ($bwe = mysqli_fetch_assoc($get_bwe_result)) {
                    $article['better'] = array(
                            $bwe
                    );
                }
            }
            
            $get_bwe_result = mysqli_query($link, $get_worse_sql);
            
            if ($get_bwe_result) {
                while ($bwe = mysqli_fetch_assoc($get_bwe_result)) {
                    $article['worse'] = array(
                            $bwe
                    );
                }
            }
            
            $get_bwe_result = mysqli_query($link, $get_equal_sql);
            
            if ($get_bwe_result) {
                while ($bwe = mysqli_fetch_assoc($get_bwe_result)) {
                    $article['equal'] = array(
                            $bwe
                    );
                }
            }
        }
        
        /**
         * There is duplicate of this query above.
         * Append authors when getting article.
         * There is not other way expect to save a preview string,
         * but it also has to be handled on ui side.
         * The server is always faster, so better do this there.
         */
        
        $get_author_sql = "SELECT for_authors.* FROM for_authors
                           LEFT JOIN for_rel_authors
                           ON for_authors.author_id = for_rel_authors.author_id
                           WHERE for_rel_authors.article_id = {$article['article_id']}
                           GROUP BY author_id;";
        
        $get_author_result = mysqli_query($link, $get_author_sql);
        
        $article['authors'] = array();
        
        if ($get_author_result) {
            while ($author = mysqli_fetch_assoc($get_author_result)) {
                $article['authors'][] = $author;
            }
        }
        
        if ($article['priority'] == 'cover' && $covers_counter < 5) {
            $covers_counter ++;
            
            $get_stickers_sql = "SELECT for_stickers.*
                                 FROM for_stickers
                                 LEFT JOIN for_rel_relative
                                 ON for_stickers.sticker_id = for_rel_relative.related_tag_id
                                 LEFT JOIN for_rel_tags
                                 ON for_rel_tags.tag_id = for_rel_relative.tag_id
                                 LEFT JOIN for_articles
                                 ON for_articles.article_id = for_rel_tags.article_id
                                 WHERE for_articles.article_id = {$article['article_id']}
                                 AND for_rel_relative.related_subtype = 'sticker'
                                 GROUP BY sticker_id;";
            
            $get_stickers_result = mysqli_query($link, $get_stickers_sql);
            
            if ($get_stickers_result) {
                while ($sticker = mysqli_fetch_assoc($get_stickers_result)) {
                    $article['stickers'][] = $sticker;
                }
            }
        }
        
        $articles[] = $article;
    }
    
    if (isset($_GET['tag']) && ! $get_suggest) {
        
        /**
         * Merge version tested.
         * To display the aside info the id of the platform is not enough.
         */
        
        if ($articles[0]['subtype'] == 'review' ||
                 $articles[0]['subtype'] == 'video') {
            
            $get_platform_sql = "SELECT for_platforms.*
                                 FROM for_platforms
                                 WHERE platform_id = {$articles[0]['platform']};";
            
            $get_platform_result = mysqli_query($link, $get_platform_sql);
            
            if ($get_platform_result) {
                $platform = mysqli_fetch_assoc($get_platform_result);
                
                $articles[0]['version_tested'] = $platform;
            }
        }
        
        /**
         * Merge auhors.
         */
        
        $get_authors_result = mysqli_query($link, $get_authors_sql);
        
        if (! $get_authors_result) {
            goto end;
        }
        
        while ($author = mysqli_fetch_assoc($get_author_result)) {
            $articles[0]['authors'][] = $author;
        }
        
        /**
         * Merge tags.
         */
        
        $get_tags_result = mysqli_query($link, $get_tags_sql);
        
        if (! $get_tags_result) {
            goto end;
        }
        
        while ($tag = mysqli_fetch_assoc($get_tags_result)) {
            $articles[0]['tags'][] = $tag;
            
            if ($tag['prime'] == 1) {
                $articles[0]['prime'] = $tag;
            }
        }
        
        /**
         * Merge layouts.
         */
        
        $get_layouts_result = mysqli_query($link, $get_layouts_sql);
        
        if (! $get_layouts_result) {
            goto end;
        }
        
        while ($layout = mysqli_fetch_assoc($get_layouts_result)) {
            $get_imgs_sql = "SELECT for_rel_imgs.*
                             FROM for_rel_imgs
                             WHERE layout_id = {$layout['layout_id']}
                             ORDER BY `order`;";
            
            $get_imgs_result = mysqli_query($link, $get_imgs_sql);
            
            if ($get_imgs_result) {
                while ($img = mysqli_fetch_assoc($get_imgs_result)) {
                    $layout['imgs'][] = $img;
                }
            }
            
            $articles[0]['layouts'][] = $layout;
        }
        
        /**
         * Merge issue.
         */
        
        $get_issue_result = mysqli_query($link, $get_issue_sql);
        
        if (! $get_issue_result) {
            goto end;
        }
        
        while ($issue = mysqli_fetch_assoc($get_issue_result)) {
            
            /**
             * Reset this to array and push all info about the issue.
             */
            
            $articles[0]['issue'] = array();
            $articles[0]['issue'][] = $issue;
        }
    }
    
    end:
    
    if (! $get_article_result || ! $get_authors_result || ! $get_tags_result ||
             ! $get_issue_result || ! $get_layouts_result || ! $get_imgs_result) {
        
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
                    'articles' => $articles,
                    'events' => $events
            ));
    
    mysqli_close($link);
}
?>