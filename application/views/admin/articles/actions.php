<ul id="actions">
<?php if ($article->id == 0): ?>
  <li><strong>статья удалена</strong></li>
<?php else: ?>
  <li><?php echo html::anchor($article->admin_delete_url(), 'удалить', 
			      array('class' => 'delete',
				    'title' => 'Вы уверены, что хотите удалить эту статью?')); ?></li>
  <li><?php echo html::anchor($article->admin_edit_url(), 'редактировать'); ?></li>
  <li><?php echo html::anchor($article->public_url(), 'предпросмотр'); ?></li>
<?php endif; ?>
  <li><?php echo html::anchor('/admin/articles/create', 'создать новую статью'); ?></li>
</ul>