<?php defined('SYSPATH') or die('No direct script access.');

class Records_Controller extends Admin_Controller {

  public function preview($record_id = NULL)
  {
    $this->auto_render = FALSE;
    $this->load_record_or_404($record_id);

    $files = Validation::factory($_FILES)
      ->add_rules('preview', 'upload::valid', 'upload::required', 'upload::type[gif,jpg,png]', 'upload::size[500K]');

    if ($files->validate()) {
      $filename = upload::save('preview', NULL, Kohana::config('upload.directory') . 'records/');
      
      Image::factory($filename)
	->resize(100, 100, Image::WIDTH)
	->save();

      $this->record->preview = basename($filename);
      $this->record->save();
    }

    View::factory('admin/records/preview_response')
      ->bind('record', $this->record)
      ->render(TRUE);
  }

  public function preview_delete($record_id = NULL)
  {
    $this->auto_render = FALSE;
    if ((request::method() == 'post') && request::is_ajax()) {
      $this->load_record_or_404($record_id);
      $this->record->preview = '';
      $this->record->save();
      echo json_encode(array('preview-form' =>
			     View::factory('admin/records/preview')
			     ->bind('record', $this->record)
			     ->render(FALSE)));
    } else {
      print 'К этому адресу допускаются только XHR POST запросы.';
    }
  }
  
  private function load_record_or_404($record_id = NULL)
  {
    $this->record = ORM::factory('record', $record_id);
    if (! $this->record->loaded) {
      throw new Kohana_404_Exception;
    }
  }
}

?>