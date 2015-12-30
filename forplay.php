<?php
include ('db.php');

if (getenv('REQUEST_METHOD') == 'GET') {
    $get_tag = isset($_GET['tag']) ? "{$_GET ['tag']}" : "ANY (SELECT article_id FROM for_articles)";
    $get_url = isset($_GET['url']) ? "{$_GET ['url']}" : "ANY (SELECT url FROM for_articles)";
    $get_type = isset($_GET['type']) ? "'{$_GET ['type']}'" : "ANY (SELECT `type` FROM for_articles)";
    $get_subtype = isset($_GET['subtype']) ? "'{$_GET ['subtype']}'" : "ANY (SELECT subtype FROM for_articles)";
    
    $get_article_sql = "SELECT * FROM for_articles 
						WHERE article_id = {$get_tag}
	                    AND (url = {$get_url})
    					AND (`type` = {$get_type})
    					AND (subtype = {$get_subtype});";
    
    $get_authors_sql = "SELECT for_authors.* FROM for_authors
        			    LEFT JOIN for_rel_authors
        				ON for_authors.author_id = for_rel_authors.author_id
        			    WHERE for_rel_authors.article_id = {$get_tag}
        			    GROUP BY author_id;";
    
    $get_tags_sql = "SELECT for_tags.* FROM for_tags
                        LEFT JOIN for_rel_tags
                        ON for_tags.tag_id = for_rel_tags.tag_id
                        WHERE for_rel_tags.article_id = {$get_tag}
                        GROUP BY tag_id
                        ORDER BY for_rel_tags.prime DESC;";
    
    $get_layouts_sql = "SELECT for_layouts.* 
                        FROM for_layouts
                        WHERE article_id = {$get_tag}
                        ORDER BY `order`;";
    
    $get_issue_sql = "SELECT for_issues.* FROM for_issues
                      LEFT JOIN for_rel_issues
                      ON for_issues.issue_id = for_rel_issues.issue_id
                      WHERE for_rel_issues.article_id = {$get_tag}
                      GROUP BY issue_id;";
    
    $get_article_result = true;
    $get_author_result = true;
    $get_layouts_result = true;
    $get_tags_result = true;
    $get_issue_result = true;
    $get_imgs_result = true;
    $articles = array();
    
    /**
     * Article basic information.
     */
    
    $get_article_result = mysqli_query($link, $get_article_sql);
    
    if (! $get_article_result) {
        goto end;
    }
    
    while ($article = mysqli_fetch_assoc($get_article_result)) {
        $articles[] = $article;
    }
    
    if (isset($_GET['tag'])) {
        
        /**
         * Merge auhors.
         */
        
        $get_author_result = mysqli_query($link, $get_authors_sql);
        
        if (! $get_author_result) {
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
        }
        
        /**
         * Merge layouts.
         */
        
        $get_layouts_result = mysqli_query($link, $get_layouts_sql);
        
        if (! $get_layouts_result) {
            goto end;
        }
        
        while ($layout = mysqli_fetch_assoc($get_layouts_result)) {
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
            $articles[0]['issue'][] = $issue;
        }
    }
    
    end:
    
    if (! $get_article_result || ! $get_author_result || ! $get_tags_result ||
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