<?php

function is_leap($y)
{
  return ((($y % 4 == 0) && ($y % 100 != 0)) || ($y % 16 == 0)) ? TRUE : FALSE;
}
if ($article->published) {
  $day = date('j', $article->published);
  $month = date('n', $article->published);
  $year = date('Y', $article->published);
} else {
  $day = date('j');
  $month = date('n');
  $year = date('Y');
}
$months = array(1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
		5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
		9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря');
$month_days = array(1 => 31, 2 => array(28, 29), 3 => 31, 4 => 30,
		    5 => 31, 6 => 30, 7 => 31, 8 => 31,
		    9 => 30, 10 => 31, 11 => 30, 12 => 31);
$days_in_month = $month_days[$month];
if (is_array($days_in_month)) {
  $days_in_month = is_leap($year) ? $days_in_month[1] : $days_in_month[0];
}
$days = array();
for ($i = 1; $i <= $days_in_month; $i++) {
  $days[$i] = $i;
}

echo form::open($article->admin_publish_url(), array('class' => 'admin-form', 'id' => 'published'));
echo form::label('day', 'Дата публикации:');
echo form::dropdown('day', $days, $day);
echo form::dropdown('month', $months, $month);
echo form::dropdown('year', array(2009 => 2009, 2010 => 2010, 2011 => 2011), $year);
echo '&nbsp;';
echo form::submit('publish-article', 'Сохранить');
echo '&nbsp;';
if ($article->published) {
  echo html::anchor($article->admin_publish_url(), 'отменить публикацию',
		    array('class' => 'delete',
			  'title' => 'Не выводить эту статью на основном сайте?'));
} else {
  echo '<span class="status">Эта статья не выводится на основном сайте.</span>';
}
echo form::close();
