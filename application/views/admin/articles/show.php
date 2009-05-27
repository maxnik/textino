<h1>Статья: <?php echo $article->name ?></h1>

<?php

function field_or_empty($title, $field)
{
  print '<p><h2>' . $title . ':</h2>';
  if (empty($field)) {
    print 'поле не заполнено';
  } else {
    print $field;
  }
  print '</p>';
}

View::factory('admin/articles/actions')
     ->bind('article', $article)
     ->render(TRUE);

field_or_empty('Заголовок окна со статьей (title)', $article->title);
field_or_empty('Описание страницы для поисковиков (description)', $article->description);
field_or_empty('Ключевые слова страницы для поисковиков (keywords)', $article->keywords);
field_or_empty('Краткое описание статьи', strip_tags($article->summary));
field_or_empty('Полный текст статьи', strip_tags($article->body));

?>
