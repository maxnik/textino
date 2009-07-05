<?php defined('SYSPATH') or die('No direct scrtipt access.');

class Site_Controller extends Template_Controller {

  public $template = 'layout';

  public function __construct()
  {
    parent::__construct();

    $tag_groups = ORM::factory('tag')
      ->like('name', 'Список%', FALSE)
      ->select_list('name', 'id');

    $this->template->categories = ORM::factory('tag')
      ->select('records.*, COUNT(t.tag_id) as total_articles')
      ->join('taggings', 'taggings.record_id = records.id', '', 'LEFT')
      ->join('taggings as t', 't.tag_id = records.id', '', 'INNER')
      ->join('records as articles', 'articles.id = t.record_id AND articles.published != 0', '', 'INNER')
      ->groupby('t.tag_id')
      ->where(array('taggings.tag_id' => $tag_groups['Список разделов']))
      ->find_all();

    $this->template->tags = ORM::factory('tag')
      ->select('records.*, COUNT(t.tag_id) as total_articles')
      ->join('taggings', array('taggings.record_id' => 'records.id'), '', 'LEFT')
      ->join('taggings as t', 't.tag_id = records.id', '', 'INNER')
      ->join('records as articles', 'articles.id = t.record_id AND articles.published != 0', '', 'INNER')
      ->groupby('t.tag_id')
      ->where(array('taggings.tag_id' => $tag_groups['Список тегов']))
      ->orderby('records.name', 'asc')
      ->find_all();

    $this->template->months = ORM::factory('tag')
      ->select('records.*, COUNT(t.tag_id) as total_articles')
      ->join('taggings', 'taggings.record_id = records.id', '', 'LEFT')
      ->join('taggings as t', 't.tag_id = records.id', '', 'INNER')
      ->join('records as articles', 'articles.id = t.record_id AND articles.published != 0', '', 'INNER')
      ->groupby('t.tag_id')
      ->where(array('taggings.tag_id' => $tag_groups['Список месяцев']))
      ->orderby('records.id', 'desc')
      ->find_all();
  }
}

?>