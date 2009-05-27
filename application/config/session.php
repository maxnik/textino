<?php defined('SYSPATH') or die('No direct script access.');

$config = array (
  'driver' => 'cookie',
  'storage' => '',
  'name' => 'textino_cms_session',
  'validate' => array('user_agent'),
  'encryption' => FALSE,
  'expiration' => 0,
  'regenerate' => 3,
  'gc_probability' => 2
);

?>