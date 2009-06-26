<div id="commenting">
  <?php if ($article->commenting): ?>
    <?php echo html::anchor($article->admin_commenting_url(), 'запретить комментирование',
			    array('class' => 'put',
				  'title' => 'Запретить читателям статьи оставлять комментарии?')); ?>
  <?php else: ?>
    <span class="status">комментирование запрещено</span>&nbsp;
    <?php echo html::anchor($article->admin_commenting_url(), 'разрешить комментирование статьи',
			    array('class' => 'put',
				  'title' => 'Разрешить читателям статьи оставлять комментарии?')); ?>
  <?php endif; ?>
</div>