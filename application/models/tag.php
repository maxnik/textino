<?php defined('SYSPATH') or die('No direct script access.');

class Tag_Model extends Record_Model {

  protected $record_type = 'tags';
  
  protected $table_name = 'records';
  protected $sorting = array('name' => 'asc');

  public function validate(array & $params, $save = FALSE)
  {
    $params = Validation::factory($params)
      ->pre_filter('trim')
      ->add_rules('name', 'required')
      ->add_rules('title', 'length[0,1000]')
      ->add_rules('description', 'length[0,1000]')
      ->add_rules('keywords', 'length[0,1000]')
      ->add_rules('slug', 'length[0,1000]', 'alpha_dash')
      ->add_callbacks('name', array($this, '_unique_name'))
      ->add_callbacks('slug', array($this, '_unique_slug'));
    
    return parent::validate($params, $save);
  }

  public function delete($id = NULL)
  {
    $this->db->delete('taggings', array('tag_id' => $this->id));
    parent::delete($id);
  }

  public function __get($column)
  {
    if ($column == 'records') {
      if (! isset($this->related[$column])) {
	$this->related[$column] = ORM::factory('record')
	  ->join('taggings', 'taggings.record_id = records.id', '')
	  ->where(array('tag_id' => $this->id))
	  ->orderby('position', 'asc')
	  ->find_all();
      }
      return $this->related[$column];
    } else {
      return parent::__get($column);
    }
  }
}

?>