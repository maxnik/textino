<h1>Комментарии, ожидающие публикации</h1>

<?php if ($comments->count() == 0): ?>
  <p>В настоящее время нет комментариев, ожидающих публикации.</p>
<?php else: ?>
  <?php View::factory('admin/comments/list')->bind('comments', $comments)->bind('safepag', $safepag)->render(TRUE); ?>
<?php endif; ?>