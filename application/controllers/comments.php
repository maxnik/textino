<?php

class Comments_Controller extends Site_Controller {

  public function create($article_id = NULL)
  {
    $this->load_article_or_404($article_id);

    $comment = ORM::factory('comment');
    $form = $comment->as_array();
    $errors = array_fill_keys(array_keys($form), NULL);

    if ($post = $this->input->post()) {
      $comment->article_id = $this->article->id;

      if ($comment->validate($post, TRUE)) {
	Session::instance()->set('status',
				 'Ваш комментарий передан на модерацию и будет опубликован после прочтения автором блога.');
	url::redirect($this->article->public_url());
      } else {
	$form = arr::overwrite($form, $post->as_array());
	$errors = arr::overwrite($errors, $post->errors('comment_errors'));
      }
    }

    $this->template->title = "Комментирование записи \"{$this->article->name}\"";
    $this->template->content = View::factory('comments/create')
      ->bind('article', $this->article)
      ->bind('builder', new Custom_form_builder($form, $errors));
  }

  private function load_article_or_404($article_id = NULL)
  {
    $this->article = ORM::factory('article')
      ->where(array('id' => $article_id,
		    'commenting !=' => 0))
      ->find_published();
    if (! $this->article->loaded) {
      throw new Kohana_404_Exception;
    }
  }
}

?>