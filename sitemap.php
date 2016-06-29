<?php
include ('../../forsecret/db.php');

header('Content-type: application/xml');

$sitemap = new DOMDocument('1.0', 'UTF-8');
$sitemap->formatOutput = true;

$urlset = $sitemap->createElement('urlset');
$urlset = $sitemap->appendChild($urlset);
$urlset_xmlns = $sitemap->createAttribute('xmlns');
$urlset_xmlns_news = $sitemap->createAttribute('xmlns:news');

$urlset_xmlns->value = 'http://www.sitemaps.org/schemas/sitemap/0.9';
$urlset_xmlns_news->value = 'http://www.google.com/schemas/sitemap-news/0.9';

$urlset->appendChild($urlset_xmlns);
$urlset->appendChild($urlset_xmlns_news);

/**
 * TODO: Split this on two to have 1000 news but 50000 articles.
 */

$get_articles_sql = "SELECT for_articles.*, 
                            for_issues.`name` AS issue, 
                            for_issues.tag AS issue_tag 
                     FROM for_articles
                     INNER JOIN for_rel_issues ON for_articles.article_id = for_rel_issues.article_id
                     INNER JOIN for_issues ON for_issues.issue_id = for_rel_issues.issue_id
                     WHERE (subtype 
                     IN ('news', 'video', 'review', 'feature') 
                     OR (subtype = 'aside' AND priority = 'aside')) 
                     AND for_articles.`date` <= now()
                     ORDER BY date DESC
                     LIMIT 1000;";

$get_articles_result = mysqli_query($link, $get_articles_sql);

while ($article = mysqli_fetch_assoc($get_articles_result)) {
    
    /**
     * Merge tags.
     */
    
    $get_tags_sql = "SELECT for_tags.*, for_rel_tags.prime FROM for_tags
                     LEFT JOIN for_rel_tags
                     ON for_tags.tag_id = for_rel_tags.tag_id
                     WHERE for_rel_tags.article_id = {$article ['article_id']}
                     GROUP BY tag_id
                     ORDER BY for_rel_tags.prime DESC;";
    
    $get_tags_result = mysqli_query($link, $get_tags_sql);
    
    while ($tag = mysqli_fetch_assoc($get_tags_result)) {
        $article['tags'][] = $tag['en_name'];
    }
    
    $mysqlDate = strtotime($article['date']);
    $googleDate = date("c", $mysqlDate);
    $article_url = 'https://www.forplay.bg/articles/' . $article['type'] . '/' .
             $article['subtype'] . '/' . $article['article_id'] . '/' .
             $article['url'];
    
    $url = $sitemap->createElement('url');
    $loc = $sitemap->createElement('loc', $article_url);
    
    $url->appendChild($loc);
    
    if ($article['subtype'] == 'news') {
        $news = $sitemap->createElement('news:news');
        $news_publication = $sitemap->createElement('news:publication');
        $news_name = $sitemap->createElement('news:name', 'Forplay');
        $news_language = $sitemap->createElement('news:language', 'bg');
        $news_piblication_date = $sitemap->createElement(
                'news:publication_date', $googleDate);
        $news_keywords = $sitemap->createElement('news:keywords', 
                join(', ', $article['tags']));
        $news_title = $sitemap->createElement('news:title', $article['title']);
		$news_genres = $sitemap->createElement('news:genres', 'UserGenerated');
        
        $news->appendChild($news_publication);
        $news_publication->appendChild($news_name);
        $news_publication->appendChild($news_language);
		$news->appendChild($news_genres);
        $news->appendChild($news_piblication_date);
        $news->appendChild($news_keywords);
        $news->appendChild($news_title);
        $url->appendChild($news);
    }
    
    $urlset->appendChild($url);
}

$sitemap->save("sitemap.xml");

echo $sitemap->saveXML();

?>

