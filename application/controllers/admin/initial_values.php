<?php defined('SYSPATH') or die('No direct script access.');

class Initial_values_Controller extends Admin_Controller {

  public function edit()
  {
    $status = '';
    $initial_values = ORM::factory('initial_value')->find_all();
    $form = $errors = array();
    
    if ($post = $this->input->post()) {
      foreach ($initial_values as $initial_value) {
	$form[$initial_value->name] = $post[$initial_value->name];
	$errors[$initial_value->name] = '';

	$initial_value->value = $post[$initial_value->name];
	$initial_value->save();
      }
      $status = 'Изменения сохранены';
    } else {
      foreach ($initial_values as $initial_value) {
	$form[$initial_value->name] = $initial_value->value;
	$errors[$initial_value->name] = '';
      }
    }

    $this->template->title = 'Значения по умолчанию';
    $this->template->content = View::factory('admin/initial_values/edit')
      ->set('status', $status)
      ->bind('builder', new Custom_form_builder($form, $errors));
  }
}

?>