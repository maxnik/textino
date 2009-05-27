<?php 
print form::open('/admin/taggings/create', array('class' => 'tagging-form'));

print form::hidden(array('record_id' => $record_id));

print form::label('tag', 'Метка для этой страницы:');
$selection = array();
if ($all_tags->count() == 0) {
  $selection[0] = 'нет меток';
} else {
  $selection[0] = 'выберите метку';
  foreach ($all_tags as $tag) {
    $selection[$tag->id] = $tag->name;
  }
}
print form::dropdown('tag_id', $selection, 'standard');
print '<br />';
print form::submit('tag_something', 'Добавить');

print form::close();

View::factory('admin/taggings/list')
     ->set('record_id', $record_id)
     ->bind('assigned_tags', $assigned_tags)
     ->render(TRUE);

?>
