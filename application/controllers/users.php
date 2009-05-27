<?php defined('SYSPATH') or die('No direct script access.');

class Users_Controller extends Controller
{

  public function login()
  {
    $notice = '';
    if ($this->input->post('username')) {
      $user = ORM::factory('user', $this->input->post('username'));
      if (Auth::instance()->login($user, 
				  $this->input->post('password'),
				  ! $this->input->post('public_computer'))) {
	$required_role = Session::instance()->get('required_role', FALSE);
	if (($required_role && $user->has(ORM::factory('role', $required_role))) || ! $required_role) {
	  url::redirect(Session::instance()->get('requested_url', '/users/profile'));
	} else {
	  $notice = 'У Вас нет доступа к этой части сайта.';
	}
      } else {
	$notice = 'Неправильное имя пользователя или пароль.';
      }
    }
    print $notice;
    print form::open();
    print form::label('username', 'Имя пользователя');
    print form::input('username', $this->input->post('username'));
    print form::label('password', 'Пароль');
    print form::password('password');
    print form::checkbox('public_computer', '1', $this->input->post('public_computer'));
    print form::label('public_computer', 'чужой компьютер');
    print form::submit('submit', 'Вход');
    print form::close();
  }

  public function logout()
  {
    Auth::instance()->logout();
    url::redirect('/');
  }

}

?>