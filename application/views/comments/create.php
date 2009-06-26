<h1>Комментирование записи <?php echo html::anchor($article->public_url(), "\"{$article->name}\""); ?></h1>

<?php View::factory('comments/form')
     ->set('article_id', $article->id)
     ->bind('builder', $builder)
     ->render(TRUE); ?>