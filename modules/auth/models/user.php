<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_Model extends Auth_User_Model {
	
  public function validate_edit(array & $array, $save = FALSE)
  {
    $array = Validation::factory($array)
      ->pre_filter('trim')
      ->add_rules('email', 'required', 'valid::email')
      ->add_callbacks('email', array($this, '_unique_email'))
      ->add_callbacks('password', array($this, '_check_password'));

    return ORM::validate($array, $save);
  }

  public function _unique_email(Validation & $array, $field)
  {
    $email_exists = (bool) $this->db
      ->count_records($this->table_name, array('email' => $array[$field], 'id !=' => $this->id));
    if ($email_exists) {
      $array->add_error($field, 'exists');
    }
  }

  public function _check_password(Validation & $array, $field)
  {
    if ($array['password'] != $array['password_confirmation']) {
      $array->add_error('password', 'confirm');
    }
  }

  public function __set($key, $value)
  {
    if ($key != 'password' || !empty($value)) {
      parent::__set($key, $value);
    }
  }
	
} // End User Model