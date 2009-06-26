<?php

$url = isset($article_id) ? "/comments/create/{$article_id}" : NULL;
echo form::open($url, array('class' => 'custom-form comment-form'));

$builder->input_for('author', 'Ваше имя');
$builder->input_for('url', 'Ссылка, за которую не стыдно');
$builder->textarea_for('body', 'Ваш комментарий');

echo form::submit('submit', 'Ответить');
echo form::close();

?>