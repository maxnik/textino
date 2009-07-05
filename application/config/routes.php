<?php defined('SYSPATH') OR die('No direct access allowed.');

$config['_default'] = 'articles/index';
$config['admin'] = 'admin/articles';
$config['media/(.*)'] = 'media/send';
$config['sitemap'] = 'sitemap/html';
$config['sitemap.xml'] = 'services/sitemap_xml';
$config['feed.xml'] = 'services/rss';

?>