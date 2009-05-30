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

  public function already_published()
  {
    return $this->where(array('published >' => 0, 'published < ' => time()))->find_all();
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
    if (empty($this->type)) {
      $this->type = $this->record_type;
    }
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
    $this->preview_delete();
    return parent::delete($id);
  }

  private function preview_delete()
  {
    if (! empty($this->preview)) {
      $preview_path = Kohana::config('upload.directory') . 'records/' . $this->preview;
      if (is_file($preview_path)) {
	unlink($preview_path);
      }
    }
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

  public function admin_preview_url()
  {
    return url::base() . "admin/records/preview/{$this->id}";
  }

  public function admin_preview_delete_url()
  {
    return url::base() . "admin/records/preview_delete/{$this->id}";
  }

  public function preview_image_url()
  {
    return url::base() . "media/upload/records/{$this->preview}";
  }

  public function public_url($full = FALSE)
  {
    $url = $full ? url::base() : '';
    return $url . "{$this->type}/{$this->slug}";
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

  public function __set($column, $value)
  {
    if ($column == 'preview') {
      $this->preview_delete();
    }
    return parent::__set($column, $value);
  }
}

?>