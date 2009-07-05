<?php if ($articles->count() == 0): ?>
  <p>Блог еще совсем пустой. Автор не написал еще ни одного поста.</p>
<?php else: ?>
  <h1>Список всех постов блога</h1>
  <ul class="all-posts">
    <?php foreach($articles as $article): ?>
      <li><?php echo html::anchor($article->public_url(), $article->name); ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>