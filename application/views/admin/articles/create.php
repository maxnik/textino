<h1>Создание новой статьи</h1>

<?php

echo form::open(NULL, array('class' => 'admin-form'));

$builder->input_for('name', 'Название статьи');
$builder->input_for('title', 'Заголовок окна со статьей (title)');
$builder->input_for('description', 'Описание страницы для поисковиков (description)');
$builder->input_for('keywords', 'Ключевые слова страницы для поисковиков (keywords)');
$builder->textarea_for('summary', 'Краткое описание статьи');
$builder->textarea_for('body', 'Полный текст статьи');

echo form::submit('submit', 'Создать');

echo form::close();

?>