<?php defined('SYSPATH') or die('No direct script access.');

class Taggings_Controller extends Admin_Controller {

  public function create()
  {
    $this->auto_render = FALSE;
    if (($post = $this->input->post()) && request::is_ajax()) {
      $tagging = ORM::factory('tagging');
      if ($tagging->validate($post, TRUE)) {
	$response = View::factory('admin/taggings/list')
	  ->set('record_id', $tagging->record_id)
	  ->bind('assigned_tags', ORM::factory('record', $tagging->record_id)->tags);
	echo json_encode(array('tags' => $response->render(FALSE)));
      } else {
	echo implode(',', $post->errors());
      }
    } else {
      print 'К этому адресу допускаются только XHR POST запросы.';
    }
  }

  public function delete($tag_id = NULL, $record_id = NULL)
  {
    $this->auto_render = FALSE;
    if ((request::method() == 'post') && request::is_ajax()) {
      $db = new Database;
      $db->delete('taggings',array('tag_id' => $tag_id, 'record_id' => $record_id));
      $response = View::factory('admin/taggings/list')
	->set('record_id', $record_id)
	->bind('assigned_tags', ORM::factory('record', $record_id)->tags);
      echo json_encode(array('tags' => $response->render(FALSE)));
    } else {
      print 'К этому адресу допускаются только XHR POST запросы.';
    }
  }

  public function edit($tag_id = NULL)
  {
    $this->auto_render = FALSE;
    if ((request::method() == 'post') && request::is_ajax()) {
      $post = $this->input->post();
      $taggings = ORM::factory('tagging')
	->where(array('tag_id' => $tag_id))
	->select_list('record_id', 'position');
      foreach ($taggings as $record_id => $position) {
	$new_position = (int) $post[$record_id];
	if ($position != $new_position) {
	  Database::instance()->update('taggings', array('position' => $new_position),
				       array('tag_id' => $tag_id, 'record_id' => $record_id));
	}
      }
    } else {
      print 'К этому адресу допускаются только XHR POST запросы.';
    }
  }

}

?>