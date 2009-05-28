<?php defined('SYSPATH') or die('No direct script access');

class Record_Model extends ORM {

  protected $belongs_to = array('author' => 'user');

  public function _unique_name(Validation $array, $field)
  {
    $name_exists = (bool) $this->db
      ->count_records($this->table_name, array('name' => $array[$field], 'id != ' => $this->id));
    if ($name_exists) {
      $array->add_error($field, 'exists');
    }
  }

  public function _unique_slug(Validation $array, $field)
  {
    $slug_exists = (bool) $this->db
      ->count_records($this->table_name, array('slug' => $array[$field], 'id != ' => $this->id));
    if ($slug_exists) {
      $array->add_error($field, 'exists');
    }
  }

  public function find_all($limit = NULL, $offset = NULL)
  {
    if (isset($this->record_type)) {
      $this->db->where(array('type' => $this->record_type));
    }

    return parent::find_all($limit, $offset);
  }

  public function save()
  {
    $this->type = $this->record_type;
    if ($this->id == 0) {
      $this->created = time();
    } else {
      $old_name = ORM::factory('record', $this->id)->name;
    }    
    if (($this->slug == '') || ($this->name != $old_name)) {
      $this->slug = goodies::slugify($this->name);
    }
    return parent::save();
  }

  public function delete($id = NULL)
  {
    $this->db->delete('taggings', array('record_id' => $this->id));
    return parent::delete($id);
  }

  public function admin_show_url()
  {
    return "admin/{$this->type}/show/{$this->id}";
  }

  public function admin_edit_url()
  {
    return "admin/{$this->type}/edit/{$this->id}";
  }

  public function admin_delete_url()
  {
    return "admin/{$this->type}/delete/{$this->id}";
  }

  public function public_url()
  {
    return Kohana::config('config.site_domain') . "{$this->type}/{$this->slug}";
  }

  public function __get($column)
  {
    if ($column == 'tags') {
      if (! isset($this->related[$column])) {

	$this->related[$column] = ORM::factory('tag')
	  ->join('taggings', 'taggings.tag_id = records.id', '')
	  ->where(array('record_id' => $this->id))
	  ->find_all();
      }
      return $this->related[$column];
    } else {
      return parent::__get($column);
    }
  }
}

?>