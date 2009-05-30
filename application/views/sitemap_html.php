<?php if ($records->count() == 0): ?>
  <p>Сайт еще совсем пустой. Автор не создал еще ни одной страницы.</p>
<?php else: ?>
  <ul class="records">
    <?php foreach($records as $record): ?>
      <li><?php echo html::anchor($record->public_url(), $record->name); ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>