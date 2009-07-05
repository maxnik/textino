<h1>Управление статьями</h1>

<?php echo html::anchor('/admin/articles/create', 'создать новую статью'); ?>

<?php if (count($articles) == 0): ?>
  <p>На сайт не добавлена еще ни одна статья.</p>
<?php else: ?>
  <h2>Список статей на сайте</h2>
  <table border="0" class="articles">
    <?php foreach ($articles as $article): ?>
      <tr>
        <td><?php echo html::anchor($article->admin_show_url(), $article->name); ?></td>
        <td class="tags"><?php 
	     if (array_key_exists($article->id, $article_tags)) {
	       $tag_links = array();
               foreach ($article_tags[$article->id] as $index => $tag_id) {
	         $tag_links[] = html::anchor("admin/tags/show/{$tag_id}", $tags[$tag_id],
					     array('class' => 'tag-link'));
               }
               echo implode(', ', $tag_links);
	     } else {
	       echo 'нет меток';
	     }
        ?></td>
        <td><?php echo ($article->published) ? date('j M Y', $article->published) : 'скрыта'; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>
