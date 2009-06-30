<ul class="actions" id="comment-actions-<?php echo $comment->id; ?>">
  <li>
  <?php if ($comment->published): ?>
    <span class="status">опубликован</span>
  <?php else: ?>
    <?php echo html::anchor($comment->admin_publish_url(), 'опубликовать',
			    array('class' => 'put', 'title' => 'Выводить этот коментарий вместе со статьей?')); ?>
  <?php endif; ?>
  </li>
  <li><?php echo html::anchor($comment->admin_delete_url(), 'удалить',
			      array('class' => 'put', 'title' => 'Удалить этот комментарий?')); ?>
  </li>
</ul>