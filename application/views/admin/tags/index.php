<h1>Управление метками</h1>

<?php echo html::anchor('/admin/tags/create', 'создать новую метку'); ?>

<?php if ($tags->count() == 0): ?>
  <p>На сайт не добавлена еще ни одна метка.</p>
<?php else: ?>
  <h2>Список меток на сайте</h2>
  <table border="0" class="tags">
  <?php foreach ($tags as $tag): ?>
    <tr>
      <td><?php echo html::anchor($tag->admin_show_url(), $tag->name); ?></td>
      <td><?php echo $tag->parent_tag; ?></td>
    </tr>
  <?php endforeach; ?>
  </table>
<?php endif; ?>
