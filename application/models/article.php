<?php defined('SYSPATH') or die('No direct script access.');

class Article_Model extends Record_Model {

  protected $record_type = 'articles';

  protected $table_name = 'records';
  protected $sorting = array('created' => 'desc');

  public function validate(array & $params, $save = FALSE)
  {
    $params = Validation::factory($params)
      ->pre_filter('trim')
      ->add_rules('name', 'required')
      ->add_rules('title', 'length[0,1000]')
      ->add_rules('description', 'length[0,1000]')
      ->add_rules('keywords', 'length[0,1000]')
      ->add_rules('summary', 'length[0,3000]')
      ->add_rules('body', 'length[0,50000]')
      ->add_rules('slug', 'length[0,1000]', 'alpha_dash')
      ->add_callbacks('name', array($this, '_unique_name'))
      ->add_callbacks('slug', array($this, '_unique_slug'));

    return parent::validate($params, $save);
  }

  public function admin_publish_url()
  {
    return url::base() . "admin/articles/publish/{$this->id}";
  }

  public function admin_commenting_url()
  {
    return url::base() . "admin/articles/commenting/{$this->id}";
  }

  public function find_published()
  {
    $this->db->where(array('records.published !=' => 0, 'records.published <' => time()));
    return $this->find();
  }

  public function find_all_published()
  {
    $this->db->where(array('records.published !=' => 0, 'records.published <' => time()));
    return $this->find_all();
  }

  public function count_all_published()
  {
    return $this->db
      ->where(array('type' => 'articles',
		    'records.published !=' => 0,
		    'records.published <' => time()))
      ->count_records('records');
  }

  public function delete()
  {
    $this->db->delete('comments', array('article_id' => $this->id));
    return parent::delete();
  }
}

?>