<h1>Создание новой метки</h1>

<?php

echo form::open(NULL, array('class' => 'admin-form'));

$builder->input_for('name', 'Название метки');
$builder->input_for('title', 'Заголовок окна страницы с меткой (title)');
$builder->input_for('description', 'Описание страницы с меткой для поисковиков (description)');
$builder->input_for('keywords', 'Ключевые слова страницы с меткой для поисковиков (keywords)');

echo form::submit('submit', 'Создать');

echo form::close();

?>