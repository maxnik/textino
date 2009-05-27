<?php

function admin_tagging_delete_url($tag_id, $record_id)
{
  return "/admin/taggings/delete/$tag_id/$record_id";
}

?>

<ul id="tags">
<?php if ($assigned_tags->count() == 0): ?>
  <li>меток нет</li>
<?php else: ?>
  <?php foreach ($assigned_tags as $tag): ?>
    <li>
      <?php echo html::anchor($tag->admin_show_url(), $tag->name, array('class' => 'tag-link')); ?>
      <?php echo html::anchor(admin_tagging_delete_url($tag->id, $record_id), 
			      'снять', array('class' => 'delete',
					     'title' => 'Вы уверены, что хотите снять эту метку?')); ?>
    </li>
  <?php endforeach; ?>
<?php endif; ?>
</ul>