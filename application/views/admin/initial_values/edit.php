<h1>Значения по умолчанию</h1>

<span class="status"><?php if (isset($status)) { echo $status; } ?></p>

<?php

echo form::open(NULL, array('class' => 'admin-form'));

$builder->input_for('article_title', 'Заголовок окна со статьей (title)');
$builder->textarea_for('article_description', 'Описание статьи для поисковиков (description)');
$builder->textarea_for('article_keywords', 'Ключевые слова статьи для поисковиков (keywords)');
$builder->input_for('tag_title', 'Заголовок окна с меткой (title)');
$builder->textarea_for('tag_description', 'Описание метки для поисковиков (description)');
$builder->textarea_for('tag_keywords', 'Ключевые слова метки для поисковиков (keywords)');

echo form::submit('submit', 'Сохранить');

echo form::close();

?>
