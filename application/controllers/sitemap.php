<?php defined('SYSPATH') or die('No direct script access.');

class Sitemap_Controller extends Controller {

  public function xml()
  {
    header('Content-Type: ' . file::mime('sitemap.xml'));
    View::factory('sitemap_xml')
      ->bind('records', ORM::factory('record')->already_published())
      ->render(TRUE);
  }

  public function html()
  {
    View::factory('sitemap_html')
      ->bind('records', ORM::factory('record')->already_published())
      ->render(TRUE);
  }
}

?>