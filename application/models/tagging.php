<?php defined('SYSPATH') or die('No direct script access.');

class Tagging_Model extends ORM {

  protected $sorting = array();

  public function validate(array & $params, $save = FALSE)
  {
    $params = Validation::factory($params)
      ->add_callbacks('tag_id', array($this, '_tag_exists'))
      ->add_callbacks('record_id', array($this, '_record_exists'))
      ->add_callbacks('tag_id', array($this, '_cant_tag_itself'));

    return parent::validate($params, $save);
  }

  public function _tag_exists(Validation $array, $field)
  {
    $tag = ORM::factory('tag', $array[$field]);
    if (! $tag->loaded) {
      $array->add_error($field, 'tag_doesnt_exist');
    }
  }

  public function _record_exists(Validation $array, $field)
  {
    $record = ORM::factory('record', $array[$field]);
    if (! $record->loaded) {
      $array->add_error($field, 'record_doesnt_exist');
    }
  }

  public function _cant_tag_itself(Validation $array, $field)
  {
    if ($array['tag_id'] == $array['record_id']) {
      $array->add_record($field, 'cant_tag_itself');
    }
  }

  public function save($id = NULL)
  {
    if (! $this->position) {
      $max_position = $this->db
	->where(array('tag_id' => $this->tag_id))
	->count_records('taggings');    

      $this->position = $max_position + 1;
    }
    return parent::save($id);
  }

}

?>