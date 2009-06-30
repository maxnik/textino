<ul class="admin-comments">
<?php foreach ($comments as $comment): ?>
  <li id="comment-<?php echo $comment->id; ?>" class="comment">
    <?php echo html::anchor($comment->article->admin_show_url(), "\"{$comment->article->name}\""); ?>
    от <?php echo $comment->author; ?> 
    <?php echo ($comment->url) ? html::anchor($comment->url, $comment->url) : ''; ?>
    <p><?php echo $comment->body; ?></p>
    <?php View::factory('admin/comments/actions')->bind('comment', $comment)->render(TRUE); ?>
  </li>
<?php endforeach; ?>
</ul>
<?php echo Pagination::factory(array('style' => 'punbb',
		                     'items_per_page' => $safepag->per_page,
				     'query_string' => 'page',
				     'total_items' => $safepag->total_items,
				     'auto_hide' => TRUE)); ?>  
