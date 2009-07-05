<?php defined('SYSPATH') or die('No direct script access.');

class Sitemap_Controller extends Site_Controller {

  public function html()
  {
    $this->template->title = 'Карта сайта';
    $this->template->content = View::factory('sitemap_html');
    $this->template->content->articles = ORM::factory('article')
      ->orderby('published', 'asc')
      ->find_all_published();
  }
}

?>