<h1>Закаченные через редактор картинки</h1>

<?php

View::factory('admin/images/list')
     ->bind('images', $images)
     ->render(TRUE);

?>