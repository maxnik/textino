<h1>Последние записи</h1>

<?php if ($safepag->total_items == 0): ?>
  <p>Автор еще не написал в этот блог ни одного поста.</p>
<?php else: ?>
  <?php View::factory('blog_posts')->bind('articles', $articles)->bind('safepag', $safepag)->render(TRUE); ?>
<?php endif; ?>


