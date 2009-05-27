<h1>Редактирование метки</h1>

<?php

print html::anchor($tag->admin_show_url(), 'вернуться к метке');

echo form::open(NULL, array('class' => 'admin-form'));

$builder->input_for('name', 'Название метки');
$builder->input_for('title', 'Заголовок окна страницы с меткой (title)');
$builder->input_for('description', 'Описание страницы с меткой для поисковиков (description)');
$builder->input_for('keywords', 'Ключевые слова страницы с меткой для поисковиков (keywords)');
$builder->input_for('slug', 'Часть ссылки на метку для ЧПУ');

echo form::submit('submit', 'Сохранить');

echo form::close();

?>