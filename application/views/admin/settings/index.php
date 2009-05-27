<h1>Настройки</h1>

<ul class="settings">

<?php
$settings = array('Значения по умолчанию' => '/admin/initial_values/edit',
		  'Изменить личные данные' => '/admin/settings/edit_profile');
?>

<?php foreach ($settings as $setting => $url): ?>
  <li><?php echo html::anchor($url, $setting); ?></li>
<?php endforeach; ?>

</ul>