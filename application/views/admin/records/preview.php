<?php

echo form::open_multipart($record->admin_preview_url(), array('class' => 'admin-form', 
							      'id' => 'preview-form',
							      'target' => 'upload-frame'));

echo form::label('preview', 'Превью картинка:');
?>

<?php if ($record->preview): ?>
  <img src="<?php echo $record->preview_image_url(); ?>" />
  <?php echo html::anchor($record->admin_preview_delete_url(), 'удалить',
			  array('class' => 'delete',
				'title' => 'Вы уверены, что хотите удалить эту картинку?')); ?>
<?php endif; ?>

<?php 
echo '<div>';
echo form::upload('preview');
echo '&nbsp;';
echo form::submit('upload-preview', 'Загрузить');
echo '</div>';
echo form::close(); 
?>
<iframe style="display: none" name="upload-frame"></iframe>