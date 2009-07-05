<?php $status = Session::instance()->get_once('status'); ?>
<?php if ($status): ?>
  <span class="status"><?php echo $status; ?></span>
<?php endif; ?>

<h1><?php echo $article->name; ?></h1>

<div class="post">
  <?php echo $article->body; ?>
</div>

<?php if ($comments->count() != 0): ?>
Комментарии: 
<dl>
<?php foreach ($comments as $comment): ?>
  <dt>
  <?php if ($comment->url): ?>
    <noindex><?php echo html::anchor($comment->url, $comment->author, array('rel' => 'nofollow')); ?></noindex>,
  <?php else: ?>
    <?php echo $comment->author; ?>,
  <?php endif; ?>
    <?php echo ereg_replace('<br />', ' ', goodies::time_from_now_in_words($comment->created)); ?> назад
  </dt>
  <dd><?php echo $comment->body; ?></dd>
<?php endforeach; ?>
</dl>
<?php endif; ?>

<?php if ($article->commenting): ?>
  <?php View::factory('comments/form')
     ->bind('builder', $builder)
     ->set('article_id', $article->id)
     ->render(TRUE); ?>
<?php endif; ?>