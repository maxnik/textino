<h1>Управление статьями</h1>

<?php echo html::anchor('/admin/articles/create', 'создать новую статью'); ?>

<?php if ($articles->count() == 0): ?>
  <p>На сайт не добавлена еще ни одна статья.</p>
<?php else: ?>
  <h2>Список статей на сайте</h2>
  <ul class="articles">
    <?php foreach ($articles as $article): ?>
      <li>
        <?php echo html::anchor($article->admin_show_url(), $article->name); ?>
        <?php echo date('j M Y, H:i', $article->created) ?>
	<?php echo html::anchor($article->admin_edit_url(), 'редактировать') ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
