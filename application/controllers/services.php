<?php defined('SYSPATH') or die('No direct script access.');

class Services_Controller extends Controller {

  public function sitemap_xml()
  {
    $tag_group_ids = array_keys(ORM::factory('tag')
      ->like('name', 'Список%', FALSE)
      ->select_list('id', 'name'));

    $tags = ORM::factory('tag')
      ->select('records.*, MAX(articles.published) as lastmod')
      ->join('taggings', 'taggings.record_id = records.id', '', 'LEFT')
      ->join('taggings as t', 't.tag_id = records.id', '', 'INNER')
      ->join('records as articles', 'articles.id = t.record_id AND articles.published != 0', '', 'INNER')
      ->groupby('t.tag_id')
      ->in('taggings.tag_id', $tag_group_ids)
      ->find_all();

    header('Content-Type: ' . file::mime('sitemap.xml'));
    View::factory('sitemap_xml')
      ->bind('articles', ORM::factory('article')->find_all_published())
      ->bind('tags', $tags)
      ->render(TRUE);
  }

  public function rss()
  {
    header('Content-Type: ' . file::mime('rss'));
    View::factory('rss')
      ->bind('articles', ORM::factory('article')->find_all_published())
      ->set('pub_date', ORM::factory('article')
	    ->select('MAX(published) as pub_date')->find_all_published()->current()->pub_date)
      ->render(TRUE);
  }
}

?>