<?php defined('SYSPATH') or die('No direct script access.');

class Comment_Model extends ORM {

  protected $belongs_to = array('article');

  protected $sorting = array('created' => 'asc');

  public function __construct()
  {
    parent::__construct();
    $this->url = 'http://';
  }
  
  public function validate(array & $array, $save = FALSE)
  {
    $array = Validation::factory($array)
      ->pre_filter('trim')
      ->pre_filter('htmlspecialchars')
      ->pre_filter(array($this, '_prepare_url'), 'url')
      ->add_rules('author', 'required', 'length[1, 30]')
      ->add_rules('url', 'valid::url')
      ->add_rules('body', 'required', 'length[10,1000]');
    return parent::validate($array, $save);
  }

  public function _prepare_url($url)
  {
    return ($url == 'http://') ? '' : $url;
  }

  public function save()
  {
    if ($this->id == 0) {
      $this->created = time();
    }
    return parent::save();
  }

  public function find_all_published()
  {
    $this->db->where('published != 0');
    return $this->find_all();
  }

  public function find_all_unpublished()
  {
    $this->db->where("{$this->table_name}.published = 0");
    return $this->find_all();
  }
}

?>