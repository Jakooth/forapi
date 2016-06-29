<?php
$sitemap_url_1 = "https://www.forplay.bg/sitemap.xml";
$sitemap_url_2 = "https://forplay.bg/sitemap.xml";
$sitemap_url_3 = "http://www.forplay.bg/sitemap.xml";
$sitemap_url_4 = "http://forplay.bg/sitemap.xml";

function myCurl ($url)
{
    $ch = curl_init($url);
    
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    return $httpCode;
}

$url = "http://www.google.com/webmasters/sitemaps/ping?sitemap=" . $sitemap_url_1;
$returnCode = myCurl($url);

$url = "http://www.google.com/webmasters/sitemaps/ping?sitemap=" . $sitemap_url_2;
$returnCode = myCurl($url);

$url = "http://www.google.com/webmasters/sitemaps/ping?sitemap=" . $sitemap_url_3;
$returnCode = myCurl($url);

$url = "http://www.google.com/webmasters/sitemaps/ping?sitemap=" . $sitemap_url_4;
$returnCode = myCurl($url);
?>

