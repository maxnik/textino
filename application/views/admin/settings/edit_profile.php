<h1>Редактирование личных данных</h1>

<span class="status"><?php if (isset($status)) { echo $status; } ?></p>

<?php

echo form::open(NULL, array('class' => 'admin-form'));

$builder->input_for('email', 'Адрес электронной почты');
$builder->password_for('password', 'Пароль');
$builder->password_for('password_confirmation', 'Подтвердите пароль');

echo form::submit('submit', 'Сохранить');

echo form::close();

?>