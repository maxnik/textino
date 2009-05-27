<?php defined('SYSPATH') OR die('No direct access allowed.');

$config['default'] = array ('benchmark' => TRUE,
			    'persistent' => FALSE,
			    'connection' => array('type' => 'pdosqlite', 
						  'user' => '',
						  'pass' => '',
						  'host' => '',
						  'port' => FALSE,
						  'socket' => FALSE,
						  'database' => 'test.db'),
			    'character_set' => 'utf8',
			    'table_prefix' => '',
			    'object' => TRUE,
			    'cache' => FALSE,
			    'escape' => TRUE);

?>