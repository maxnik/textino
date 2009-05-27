<?php defined('SYSPATH') or die('No direct script access.');

class Home_Controller extends Controller {
 
  public function index()
  {
    $user = ORM::factory('user')->where('username', 'admin')->find();
    if ($user->loaded) {
      print 'admin already exist';
    } else {
      $user = ORM::factory('user');
      $user->username = 'admin';
      $user->password = 'admin';
      $user->email = 'maxim.translator@gmail.com';
      if ($user->save()) {
	$user->add(ORM::factory('role', 'admin'));
	$user->save();
	print 'admin created';
      }
    }
    $cop = ORM::factory('user', 'copywriter');
    if ($cop->loaded) {
      print 'copywriter already exist';
    } else {
      $cop = ORM::factory('user');
      $cop->username = 'copywriter';
      $cop->password = 'password';
      $cop->email = 'copywriter@gmail.com';
      if ($cop->save()) {
	$cop->add(ORM::factory('role', 'login'));
	$cop->save();
	print 'copywriter created';
      }
    }
  }

  public function sqlitetest()
  {
    $p = new Profiler;
    echo 'testing sqlite pdo driver'.'<br />';
    $db = new Database;

    $result = $db->select()->from('t1')->get();
    echo '<h2>'.$db->last_query().'</h2><br />';
    echo '<ul>';
    foreach ($result as $row) {
      echo '<li>'.$row->name.'</li>';
    }
    echo '</ul>';
  }
}

?>