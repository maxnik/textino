<h1>Редактирование статьи</h1>

<?php

print html::anchor($article->admin_show_url(), 'вернуться к статье');

echo form::open(NULL, array('class' => 'admin-form'));

$builder->input_for('name', 'Название статьи');
$builder->input_for('title', 'Заголовок окна со статьей (title)');
$builder->input_for('description', 'Описание страницы для поисковиков (description)');
$builder->input_for('keywords', 'Ключевые слова страницы для поисковиков (keywords)');
$builder->input_for('slug', 'Часть ссылки на статью для ЧПУ');
$builder->textarea_for('summary', 'Краткое описание статьи');
$builder->textarea_for('body', 'Полный текст статьи');

echo form::submit('submit', 'Сохранить');
echo '&nbsp;';
echo form::submit('save-without-reload', 'Сохранить текст из редакторов без перезагрузки');

echo form::close();

?>