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
      $this->get_images();

      $response = View::factory('admin/images/browser')
	->bind('images', $this->images);
      echo $response->render(FALSE);
    }
  }

  public function index()
  {
    $this->get_images();

    $this->template->title = 'Закаченные картинки';
    $this->template->javascripts = View::factory('admin/images/javascripts');
    $this->template->content = View::factory('admin/images/index')
      ->bind('images', $this->images);
  }

  public function delete($filename = NULL)
  {
    $this->auto_render = FALSE;
    if ((request::method() == 'post') && request::is_ajax()) {
      unlink(Kohana::config('upload.directory') . $filename);

      $this->get_images();

      $response = View::factory('admin/images/list')
	->bind('images', $this->images);
      echo json_encode(array('images' => $response->render(FALSE)));
    } else {
      print 'К этому адресу допускаются только XHR POST запросы.';
    }
  }

  private function get_images()
  {
    $site_domain = Kohana::config('config.site_domain');
    $this->images = array();
    $upload_path = Kohana::config('upload.directory');
    $upload_dir = opendir($upload_path);
    while ($image = readdir($upload_dir)) {
      $path = $upload_path . $image;
      if (! is_dir($path)) {
	$size = round(filesize($path) / 1024);
	$url = 'http://' . $site_domain . 'media/upload/' . $image;
	$this->images[] = array('name' => $image, 'size' => $size, 'url' => $url);
      }
    }
    closedir($upload_dir);
  }
}

?>