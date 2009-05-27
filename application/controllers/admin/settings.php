<?php

class Settings_Controller extends Admin_Controller {

  public function index()
  {
    $this->template->title = 'Настройки';
    $this->template->content = View::factory('admin/settings/index');
  }

  public function edit_profile()
  {
    $status = '';
    $form = $this->current_user->as_array();
    $errors = array();
    foreach ($form as $key => $value) {
      $errors[$key] = '';
    }

    if ($post = $this->input->post()) {
      if ($this->current_user->validate_edit($post, TRUE)) {
	$status = 'Изменения сохранены';
      } else {
	$errors = arr::overwrite($errors, $post->errors('user_errors'));
      }
      $form = arr::overwrite($form, $post->as_array());
    }
    
    $this->template->title = 'Редактирование личных данных';
    $this->template->content = View::factory('admin/settings/edit_profile')
      ->set('status', $status)
      ->bind('builder', new Custom_form_builder($form, $errors));
  }

}

?>