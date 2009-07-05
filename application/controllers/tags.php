<?php defined('SYSPATH') or die('No direct script access.');

class Tags_Controller extends Site_Controller {

  public function __call($name, $arguments)
  {
    $this->show($name);
  }

  public function show($tag_slug = NULL)
  {
    $tag = ORM::factory('tag')->where(array('slug' => $tag_slug))->find();
    if (! $tag->loaded) {
      throw new Kohana_404_Exception;
    }

    $total_articles = ORM::factory('article')
      ->join('taggings', 'taggings.record_id = records.id', '', 'LEFT')
      ->where(array('tag_id' => $tag->id))
      ->count_all_published();
    $safepag = new Safe_pagination((int) $this->input->get('page', 1),
				   Article_Model::per_page,
				   $total_articles);

    $articles = ORM::factory('article')
      ->select('records.*, COUNT(comments.id) AS comments_count')
      ->join('taggings', 'taggings.record_id = records.id', '', 'INNER')
      ->join('comments', 'comments.article_id = records.id AND comments.published != 0', '', 'LEFT')
      ->groupby('records.id')
      ->where(array('taggings.tag_id' => $tag->id))
      ->orderby('records.published', 'desc')
      ->limit($safepag->per_page, $safepag->offset)
      ->find_all_published();

    $parent_tag = ORM::factory('tag')
      ->join('taggings', 'taggings.tag_id = records.id', '', 'INNER')
      ->where(array('taggings.record_id' => $tag->id))
      ->find();
    if (! $parent_tag->loaded) {
      throw new Kohana_404_Exception;
    }    

    if ($tag->title) {
      $this->template->title = $tag->title;
    } else {
      switch ($parent_tag->name) {
      case 'Список разделов':
	$this->template->title = "Раздел \"{$tag->name}\"";
	break;
      case 'Список тегов':
	$this->template->title = "Записи с тегом \"{$tag->name}\"";
	break;
      case 'Список месяцев':
	$this->template->title = "Архив записей: {$tag->name}";
	break;      
      }
    }
    if ($tag->description) {
      $this->template->description = $tag->description;
    }
    $this->template->content = View::factory('tags/show')
      ->bind('tag', $tag)
      ->bind('articles', $articles)
      ->bind('safepag', $safepag)
      ->set('parent_tag_name', $parent_tag->name);
  }
}

?>