<?php
header("Content-type: text/xml; charset=UTF-8");

require('admin/boot/sitemap.bit');

$sitemap_link = BLOG_URL.'sitemap';

if(!$settings['friendly_urls'])
	$sitemap_link .= '.php';

$last_post = $posts[0];
$updated = Date::atom($last_post['mod_date_unix']);

// ============================================================================
// Sitemap 0.9
// ============================================================================
$rss = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
$rss.= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . PHP_EOL;
$rss.= 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"' . PHP_EOL;
$rss.= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
$rss.= '<url>' . PHP_EOL;
$rss.= '<loc>'.$settings['url'].$settings['path'].'</loc>' . PHP_EOL;
$rss.= '<lastmod>'.$updated.'</lastmod>' . PHP_EOL;
$rss.= '<changefreq>daily</changefreq>' . PHP_EOL;
$rss.= '<priority>1.0</priority>' . PHP_EOL;
$rss.= '</url>' . PHP_EOL;

foreach($posts as $post)
{
	$full_link = htmlspecialchars($settings['url'].$post['permalink']);
	$date = Date::atom($post['mod_date_unix']);

	$rss.= '<url>' . PHP_EOL;
		$rss.= '<loc>'.$full_link.'</loc>' . PHP_EOL;
		$rss.= '<lastmod>'.$date.'</lastmod>' . PHP_EOL;
		$rss.= '<changefreq>daily</changefreq>' . PHP_EOL;
		$rss.= '<priority>0.9</priority>' . PHP_EOL;
	$rss.= '</url>' . PHP_EOL;
}

foreach($pages as $page)
{
	$full_link = htmlspecialchars($settings['url'].$page['permalink']);
	$date = Date::atom($page['mod_date_unix']);

	$rss.= '<url>' . PHP_EOL;
		$rss.= '<loc>'.$full_link.'</loc>' . PHP_EOL;
		$rss.= '<lastmod>'.$date.'</lastmod>' . PHP_EOL;
		$rss.= '<changefreq>daily</changefreq>' . PHP_EOL;
		$rss.= '<priority>0.8</priority>' . PHP_EOL;
	$rss.= '</url>' . PHP_EOL;
}

foreach($categories as $category)
{
	$full_link = htmlspecialchars($settings['url'].Url::category($category['slug']));

	$rss.= '<url>' . PHP_EOL;
		$rss.= '<loc>'.$full_link.'</loc>' . PHP_EOL;
		$rss.= '<changefreq>daily</changefreq>' . PHP_EOL;
		$rss.= '<priority>0.7</priority>' . PHP_EOL;
	$rss.= '</url>' . PHP_EOL;
}

foreach($tags as $tag=>$amount)
{
	$full_link = htmlspecialchars($settings['url'].Url::tag($tag));
	$amount = $amount;
	
	$rss.= '<url>' . PHP_EOL;
		$rss.= '<loc>'.$full_link.'</loc>' . PHP_EOL;
		$rss.= '<changefreq>daily</changefreq>' . PHP_EOL;
		$rss.= '<priority>0.6</priority>' . PHP_EOL;
	$rss.= '</url>' . PHP_EOL;
}

$rss.= '</urlset>';

echo $rss;

?>