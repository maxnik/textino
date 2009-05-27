<ul id="actions">
  <?php if ($tag->id == 0): ?>
    <li><strong>метка удалена</strong></li>
  <?php else: ?>
    <li><?php echo html::anchor($tag->admin_delete_url(), 'удалить', 
			        array('class' => 'delete',
				      'title' => 'Вы уверены, что хотите удалить эту метку?')); ?></li>
    <li><?php echo html::anchor($tag->admin_edit_url(), 'редактировать'); ?></li>
    <li><?php echo html::anchor('#', 'предпросмотр'); ?></li>
  <?php endif; ?>
  <li><?php echo html::anchor('/admin/tags/create', 'создать новую метку'); ?></li>
</ul>
