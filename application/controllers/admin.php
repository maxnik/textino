<?php defined('SYSPATH') or die('No direct script access.');

class Admin_Controller extends Template_Controller {

  public $template = 'admin/layout';

  function __construct()
  {
    parent::__construct();

    //$p = new Profiler;

    $authentic = new Auth;
    if (! $authentic->logged_in()) {
      $authentic->auto_login();
    }
    if ($authentic->logged_in('admin')) {
      $this->current_user = $authentic->get_user();
    } else {
      Session::instance()->set(array('requested_url' => '/'.url::current(),
				     'required_role' => 'admin'));
      url::redirect('/users/login');
    }
  }
}

?>