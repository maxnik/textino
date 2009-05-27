<?php defined('SYSPATH') or die('No direct script access.');

class Images_Controller extends Admin_Controller {

  public function upload()
  {
    $this->auto_render = FALSE;

    $files = Validation::factory($_FILES)
      ->add_rules('NewFile', 'upload::valid', 'upload::required', 'upload::type[gif,jpg,png,bmp]', 'upload::size[500K]');

    $response = View::factory('admin/images/upload');

    if ($files->validate()) {
      $filename = upload::save('NewFile');
      $response->error_number = 0;
      $response->file_url = 'http://' . Kohana::config('config.site_domain') . 'media/upload/' . basename($filename);
      $response->file_name = basename($filename);
      $response->message = 'Файл успешно загружен.';
    } else {
      $response->error_number = 202;
      $response->file_url = '';
      $response->file_name = '';
      $response->message = implode(', ', $files->errors());
    }
    
    echo $response->render(FALSE);
  }

  public function browser()
  {
    $this->auto_render = FALSE;

    if ($this->input->get('Command') == 'FileUpload') {
      $this->upload();
    } else {
      $site_domain = Kohana::config('config.site_domain');
      $images = array();
      $upload_path = Kohana::config('upload.directory');
      $upload_dir = opendir($upload_path);
      while ($image = readdir($upload_dir)) {
	$path = $upload_path . $image;
	if (! is_dir($path)) {
	  $size = round(filesize($path) / 1024);
	  $url = 'http://' . $site_domain . 'media/upload/' . $image;
	  $images[] = array('name' => $image, 'size' => $size, 'url' => $url);
	}
      }
      closedir($upload_dir);

      $response = View::factory('admin/images/browser')
	->bind('images', $images);
      echo $response->render(FALSE);
    }
  }

}

?>