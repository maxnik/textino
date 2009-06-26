<?php $status = Session::instance()->get_once('status'); ?>
<?php if ($status): ?>
  <span class="status"><?php echo $status; ?></span>
<?php endif; ?>

<h1><?php echo $article->name; ?></h1>

<div class="post">
  <?php echo $article->body; ?>
</div>

<?php if ($article->commenting): ?>
  <?php View::factory('comments/form')
     ->bind('builder', $builder)
     ->set('article_id', $article->id)
     ->render(TRUE); ?>
<?php endif; ?>