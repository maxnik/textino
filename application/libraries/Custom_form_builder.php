<?php

class Custom_form_builder {

  public function __construct(array & $form, array & $errors)
  {
    $this->form =& $form;
    $this->errors =& $errors;
  }

  public function input_for($field, $label)
  {
    echo '<div class="label-above">';
    echo form::label($field, $label . ':');
    echo form::input($field, $this->form[$field], ' class="text-field"');
    if (! empty($this->errors[$field])) {
      echo '<div class="errors">' . $this->errors[$field] . '</div>';
    }
    echo '</div>';
  }

  public function textarea_for($field, $label)
  {
    echo '<div class="label-above">';
    echo form::label($field, $label . ':');
    echo form::textarea($field, $this->form[$field]);
    if (! empty($this->errors[$field])) {
      echo '<div class="errors">' . $this->errors[$field] . '</div>';
    }
    echo '</div>';
  }

  public function password_for($field, $label)
  {
    echo '<div class="label-above">';
    echo form::label($field, $label . ':');
    echo form::password($field, '', ' class="text-field"');
    if (! empty($this->errors[$field])) {
      echo '<div class="errors">' . $this->errors[$field] . '</div>';
    }
    echo '</div>';
  }


}

?>