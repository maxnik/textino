<ul id="images">
<?php if (count($images) == 0): ?>
  <li>нет ни одной картинки, закаченной через редактор статей</li>
<?php else: ?>
  <?php foreach ($images as $image): ?>
    <li>
      <?php echo $image['size'] . 'K'; ?>-
      <?php echo html::anchor($image['url'], $image['name']); ?>-
      <?php echo html::anchor('/admin/images/delete/' . $image['name'], 'удалить',
			      array('class' => 'delete',
				    'title' => 'Вы уверены, что хотите удалить эту картинку?')); ?>
    </li>
  <?php endforeach; ?>
<?php endif; ?>
</ul>