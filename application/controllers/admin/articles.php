<?php defined('SYSPATH') or die('No direct script access.');

class Articles_Controller extends Admin_Controller {
 
  public function index()
  {
    $this->template->title = 'Статьи';
    $articles = ORM::factory('article')
      ->select('id, type, name, published, created')
      ->orderby('published', 'desc')
      ->find_all()
      ->as_array();

    $article_ids = array();
    foreach ($articles as $article) { $article_ids[] = $article->id; }
    $article_ids_list = implode(',', $article_ids);

    $taggings = ORM::factory('tagging')
      ->select('record_id', 'tag_id')
      ->where("record_id IN ($article_ids_list)")
      ->find_all();

    $article_tags = array();
    foreach ($taggings as $tagging) {
      if (array_key_exists($tagging->record_id, $article_tags)) {
	$article_tags[$tagging->record_id][] = $tagging->tag_id;
      } else {
	$article_tags[$tagging->record_id] = array($tagging->tag_id);
      }
    }

    $tags = ORM::factory('tag')
      ->select_list('id', 'name');

    $this->template->content = View::factory('admin/articles/index')
      ->bind('articles', $articles)
      ->bind('article_tags', $article_tags)
      ->bind('tags', $tags);
  }

  public function create()
  {
    $article = ORM::factory('article');
    $article->author_id = $this->current_user->id;
    $form = $article->as_array();
    $errors = $form;

    $initial_values = Database::instance()->select('name, value')
      ->where("name LIKE 'article%'")
      ->get('initial_values');
    foreach ($initial_values as $initial_value) {
      $name = str_replace('article_', '', $initial_value->name);
      $form[$name] = $initial_value->value;
    }

    if ($post = $this->input->post()) {

      if ($article->validate($post, TRUE)) {
	url::redirect('/admin/articles/index');
      } else {
	$form = arr::overwrite($form, $post->as_array());
	$errors = arr::overwrite($errors, $post->errors('article_errors'));
      }
    }

    $this->template->title = 'Создание новой статьи';
    $this->template->javascripts = View::factory('admin/articles/fckeditor');
    $this->template->content = View::factory('admin/articles/create')
      ->bind('builder', new Custom_form_builder($form, $errors));
  }

  public function show($article_id = NULL)
  {
    $this->load_article_or_404($article_id);

    $conditions = array('article_id' => $this->article->id);
    $total_comments = Database::instance()->where($conditions)->count_records('comments');
    $safepag = new Safe_pagination((int) $this->input->get('page', 1),
				   Comment_Model::per_page,
				   $total_comments);

    $comments = ORM::factory('comment')
      ->where($conditions)
      ->limit($safepag->per_page, $safepag->offset)
      ->find_all();

    $this->template->title = 'Статья: ' . $this->article->name;
    $this->template->javascripts = View::factory('admin/taggings/javascripts');
    $this->template->content = View::factory('admin/articles/show')
      ->bind('article', $this->article)
      ->bind('comments', $comments)
      ->bind('safepag', $safepag);

    $this->template->tagging = View::factory('admin/taggings/form')
      ->set('record_id', $this->article->id)
      ->bind('all_tags', ORM::factory('tag')->orderby('created', 'asc')->find_all())
      ->bind('assigned_tags', $this->article->tags);
  }

  public function edit($article_id = NULL)
  {
    $this->load_article_or_404($article_id);

    if ((request::method() == 'post') && request::is_ajax()) {
      $this->auto_render = FALSE;
      $this->article->summary = $this->input->post('summary');
      $this->article->body = $this->input->post('body');
      $this->article->save();
      echo json_encode(array('mmm' => ''));
    } else {
      $form = $this->article->as_array();
      $errors = array();
      foreach ($form as $key => $value) {
	$errors[$key] = '';
      }
      
      if ($post = $this->input->post()) {
	if ($this->article->validate($post, TRUE)) {
	  url::redirect($this->article->admin_show_url());
	} else {
	  $form = arr::overwrite($form, $post->as_array());
	  $errors = arr::overwrite($errors, $post->errors('article_errors'));
	}
      }

      $this->template->title = 'Редактирование статьи: ' . $this->article->name;
      $this->template->javascripts = View::factory('admin/articles/fckeditor');
      $this->template->content = View::factory('admin/articles/edit')
	->bind('article', $this->article)
	->bind('builder', new Custom_form_builder($form, $errors));
    }
  }

  public function delete($article_id = NULL)
  {
    $this->auto_render = FALSE;
    if ((request::method() == 'post') && request::is_ajax()) {
      $this->load_article_or_404($article_id);

      $response = View::factory('admin/articles/actions')
	->bind('article', $this->article->delete());
      echo json_encode(array('actions' => $response->render(FALSE)));
    } else {
      print 'К этому адресу допускаются только XHR POST запросы.';
    }
  }

  public function publish($article_id = NULL)
  {
    $this->auto_render = FALSE;
    if ((request::method() == 'post') && request::is_ajax()) {
      $this->load_article_or_404($article_id);
      $post_params = $this->input->post();
      if (empty($post_params)) {
	$this->article->published = 0;
      } else {
	$this->article->published = mktime(0, 0, 0,
					   (int) $post_params['month'],
					   (int) $post_params['day'],
					   (int) $post_params['year']);
      }
      $this->article->save();
      echo json_encode(array('published' =>
			     View::factory('admin/articles/published')
			     ->bind('article', $this->article)
			     ->render(FALSE)));
    } else {
      print 'К этому адресу допускаются только XHR POST запросы.';
    }
  }

  public function commenting($article_id = NULL)
  {
    $this->auto_render = FALSE;
    if ((request::method() == 'post') && request::is_ajax()) {
      $this->load_article_or_404($article_id);

      $this->article->commenting = ($this->article->commenting) ? 0 : 1; // Change commenting setting
      $this->article->save();

      echo json_encode(array('commenting' =>
			     View::factory('admin/articles/commenting')
			     ->bind('article', $this->article)
			     ->render(FALSE)));       
    } else {
      print 'К этому адресу допускаются только XHR POST запросы.';
    }
  }

  private function load_article_or_404($article_id = NULL)
  {
    $this->article = ORM::factory('article', $article_id);
    if (! $this->article->loaded) {
      throw new Kohana_404_Exception;
    }
  }
}

?>