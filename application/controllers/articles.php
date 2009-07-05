<?php defined('SYSPATH') or die('No direct script access.');

class Articles_Controller extends Site_Controller {

  public function index()
  {
    $total_articles = ORM::factory('article')->count_all_published();
    $safepag = new Safe_pagination((int) $this->input->get('page', 1),
				   Article_Model::per_page,
				   $total_articles);

    $articles = ORM::factory('article')
      ->select('records.*, COUNT(comments.id) AS comments_count')
      ->join('comments', 'comments.article_id = records.id AND comments.published != 0', '', 'LEFT')
      ->groupby('records.id')
      ->orderby('records.published', 'desc')
      ->limit($safepag->per_page, $safepag->offset)
      ->find_all_published();

    $this->template->title = 'Название блога такое-то';
    $this->template->description = 'Сотрудник автосалона решил завести свой блог. Буду писать про новинки автопрома.';
    $this->template->content = View::factory('articles/index')
      ->bind('articles', $articles)
      ->bind('safepag', $safepag);
  }

  public function show($article_slug = NULL)
  {
    $article = ORM::factory('article')->where(array('slug' => $article_slug))->find_published();
    if (! $article->loaded) {
      throw new Kohana_404_Exception;
    }

    $comments = ORM::factory('comment')->where(array('article_id' => $article->id))->find_all_published();

    if ($article->commenting) {
      $form = ORM::factory('comment')->as_array();
      $builder = new Custom_form_builder($form, array_fill_keys(array_keys($form), NULL));
    }

    $this->template->title = ($article->title) ? $article->title : "Название блога: {$article->name}";
    if ($article->description) {
      $this->template->description = $article->description;
    }
    $this->template->content = View::factory('articles/show')
      ->bind('article', $article)
      ->bind('comments', $comments)
      ->bind('builder', $builder);
  }

  public function __call($name, $arguments)
  {
    if ($name != 'index') {
      $this->show($name);
    } else {
      $this->index();
    }
  }
}

?>