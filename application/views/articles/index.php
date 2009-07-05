<h1>Список всех постов в обратном хронологическом порядке.</h1>

<?php if ($safepag->total_items == 0): ?>
  <p>Автор еще не написал в этот блог ни одного поста.</p>
<?php else: ?>
  <ul class="blog-posts">
  <?php foreach ($articles as $article): ?>
    <li>
      <h2><?php echo html::anchor($article->public_url(), $article->name); ?></h2>
      <div class="post"><?php echo $article->summary; ?></div>
      <span class="comments-count">
        <?php if ($article->comments_count): ?>
        <?php echo "{$article->comments_count} " .
		   goodies::items($article->comments_count, 'комментарий', 'комментария', 'комментариев');?>
	<?php endif; ?>
     </span>
      <span class="post-published">
        опубликовано <?php echo ereg_replace('<br />', ' ',
					     goodies::time_from_now_in_words($article->published)); ?> назад
      </span>
    </li>
  <?php endforeach; ?>
  </ul>
  <?php echo Pagination::factory(array('style' => 'punbb',
				       'items_per_page' => $safepag->per_page,
				       'query_string' => 'page',
				       'total_items' => $safepag->total_items,
				       'auto_hide' => TRUE)); ?>
<?php endif; ?>


