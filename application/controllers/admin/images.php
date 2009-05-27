<?php defined('SYSPATH') or die('No direct script access.');

class Images_Controller extends Admin_Controller {

  public function upload()
  {
    $this->auto_render = FALSE;

    $response = View::factory('admin/images/upload');
    echo $response->render(FALSE);
  }

}

?>