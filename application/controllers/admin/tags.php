<?php defined('SYSPATH') or die('No direct script access.');

class Tags_Controller extends Admin_Controller {

  public function index()
  {
    $this->template->title = 'Метки';
    $tags = ORM::factory('tag')
      ->select('records.*, tags.name as parent_tag')
      ->join('taggings', 'taggings.record_id = records.id', '', 'LEFT')
      ->join('records as tags', 'tags.id = taggings.tag_id', '', 'LEFT')
      ->orderby('records.created', 'asc')
      ->find_all();
    $this->template->content = View::factory('admin/tags/index')
      ->bind('tags', $tags);
  }

  public function create()
  {
    $tag = ORM::factory('tag');
    $tag->author_id = $this->current_user->id;
    $form = $tag->as_array();
    $errors = $form;

    $initial_values = Database::instance()->select('name, value')
      ->where("name LIKE 'tag%'")
      ->get('initial_values');
    foreach ($initial_values as $initial_value) {
      $name = str_replace('tag_', '', $initial_value->name);
      $form[$name] = $initial_value->value;
    }

    if ($post = $this->input->post()) {

      if ($tag->validate($post, TRUE)) {
	$tag = ORM::factory('tag')
	  ->orderby('created', 'desc')
	  ->find();
	url::redirect($tag->admin_show_url());
      } else {
	$form = arr::overwrite($form, $post->as_array());
	$errors = arr::overwrite($errors, $post->errors('tag_errors'));
      }
    }

    $this->template->title = 'Создание новой метки';
    $this->template->content = View::factory('admin/tags/create')
      ->bind('builder', new Custom_form_builder($form, $errors));
  }

  public function show($tag_id = NULL)
  {
    $this->load_tag_or_404($tag_id);

    $this->template->title = 'Метка: ' . $this->tag->name;
    $this->template->javascripts = View::factory('admin/tags/javascripts')
      ->set('tag_id', $this->tag->id);
    $this->template->content = View::factory('admin/tags/show')
      ->bind('tag', $this->tag)
      ->bind('records', $this->tag->records);

    $all_tags_except_this = ORM::factory('tag')
      ->where(array('id != ' => $this->tag->id))
      ->orderby('created', 'asc')
      ->find_all();
    $this->template->tagging = View::factory('admin/taggings/form')
      ->set('record_id', $this->tag->id)
      ->bind('all_tags', $all_tags_except_this)
      ->bind('assigned_tags', $this->tag->tags);
  }

  public function edit($tag_id = NULL)
  {
    $this->load_tag_or_404($tag_id);

    $form = $this->tag->as_array();
    $errors = array();
    foreach ($form as $key => $value) {
      $errors[$key] = '';
    }

    if ($post = $this->input->post()) {
      if ($this->tag->validate($post, TRUE)) {
	url::redirect($this->tag->admin_show_url());
      } else {
	$form = arr::overwrite($form, $post->as_array());
	$errors = arr::overwrite($errors, $post->errors('tag_errors'));
      }
    }
    
    $this->template->title = 'Редактирование метки: ' . $this->tag->name;
    $this->template->content = View::factory('admin/tags/edit')
      ->bind('tag', $this->tag)
      ->bind('builder', new Custom_form_builder($form, $errors));
  }

  public function delete($tag_id = NULL)
  {
    $this->auto_render = FALSE;
    if ((request::method() == 'post') && request::is_ajax()) {
      $this->load_tag_or_404($tag_id);
      $this->tag->delete();

      $response = View::factory('admin/tags/actions')
	->bind('tag', $this->tag);
      echo json_encode(array('actions' => $response->render(FALSE)));
    } else {
      print 'К этому адресу допускаются только XHR POST запросы.';      
    }
  }

  private function load_tag_or_404($tag_id = NULL)
  {
    $this->tag = ORM::factory('tag', $tag_id);
    if (! $this->tag->loaded) {
      throw new Kohana_404_Exception;
    }
  }
}

?>