<?php defined('SYSPATH') or die('No direct script access.');

$lang = array
(
 'name' => array
 (
  'required' => 'Для статьи нужно указать название.',
  'exists' => 'Запись с таким названием уже существует.'
  ),
 'slug' => array
 (
  'exists' => 'Такой параметр для ЧПУ уже существует.',
  'default' => 'Неправильный формат фрагмента ссылки'
  ),
 'summary' => array
 (
  'length' => 'Длина краткого описания статьи ограничена 3000 символов.'
 )
);

?>