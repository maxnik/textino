<h1>Управление метками</h1>

<?php echo html::anchor('/admin/tags/create', 'создать новую метку'); ?>

<?php if ($tags->count() == 0): ?>
  <p>На сайт не добавлена еще ни одна метка.</p>
<?php else: ?>
  <h2>Список меток на сайте</h2>
  <ul class="tags">
    <?php foreach ($tags as $tag): ?>
      <li>
        <?php echo html::anchor($tag->admin_show_url(), $tag->name); ?>
        (<?php echo html::anchor($tag->admin_edit_url(), 'редактировать') ?>)
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
