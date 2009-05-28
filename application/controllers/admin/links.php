<?php defined('SYSPATH') or die('No direct script access.');

class Links_Controller extends Admin_Controller {

  public function browser()
  {
    $this->auto_render = FALSE;

    if ($this->input->get('Command') == 'FileUpload') {
      View::factory('admin/images/upload')
	->set('error_number', 1)
	->set('file_url', '')
	->set('file_name', '')
	->set('message', 'Для создания статей и меток используйте соответствующие ссылки.')
	->render(TRUE);
    } else {
      $articles = ORM::factory('article')->orderby('name', 'asc')->find_all();
      $tags = ORM::factory('tag')->orderby('name', 'asc')->find_all();

      View::factory('admin/links/browser')
	->bind('articles', $articles)
	->bind('tags', $tags)
	->render(TRUE);
    }
  }
}

?>