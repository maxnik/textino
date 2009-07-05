<h1>
<?php switch ($parent_tag_name): 
      case 'Список разделов': ?>
Раздел "<?php echo $tag->name; ?>"
<?php break; ?>
<?php case 'Список тегов': ?>
Записи с тегом "<?php echo $tag->name; ?>"
<?php break; ?>
<?php case 'Список месяцев': ?>
Архив записей: <?php echo $tag->name; ?>
<?php break; ?>
<?php endswitch; ?>
</h1>

<?php View::factory('blog_posts')->bind('articles', $articles)->bind('safepag', $safepag)->render(TRUE); ?>