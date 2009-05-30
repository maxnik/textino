<h1>Метка: <?php echo $tag->name; ?></h1>

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

View::factory('admin/tags/actions')
     ->bind('tag', $tag)
     ->render(TRUE);

field_or_empty('Заголовок окна страницы с меткой (title)', $tag->title);
field_or_empty('Описание страницы с меткой для поисковиков (description)', $tag->description);
field_or_empty('Ключевые слова страницы с меткой для поисковиков (keywords)', $tag->keywords);

View::factory('admin/records/preview')
     ->bind('record', $tag)
     ->render(TRUE);
?>


<?php if ($records->count() == 0): ?>
  <p>Нет ни одной отмеченной записи.</p>
<?php else: ?>
  <ol id="records">
  <?php foreach($records as $record): ?>
    <li id="<?php echo $record->id; ?>">
      <?php echo html::anchor($record->admin_show_url(), $record->name); ?>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>
<iframe style="display: none" name="upload-frame" />