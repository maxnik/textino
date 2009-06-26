<?php defined('SYSPATH') or die('No direct script access.');

class goodies_Core {

  public static function slugify($string)
  {
    $string = self::transliterate($string);
    $string = preg_replace('/[^a-z0-9-\s]/', '', strtolower($string));
    $string = preg_replace('/\s+/', '-', trim($string));
    return $string;
  }

  public static function transliterate($st)
  {
    $st = strtr($st, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e',
			   'ё' => 'e', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
			   'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
			   'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ы' => 'i', 'э' => 'e',
			   'А' => 'a', 'Б' => 'b', 'В' => 'v', 'Г' => 'g', 'Д' => 'd', 'Е' => 'e',
			   'Ё' => 'e', 'З' => 'z', 'И' => 'i', 'Й' => 'y', 'К' => 'k', 'Л' => 'l',
			   'М' => 'm', 'Н' => 'n', 'О' => 'o', 'П' => 'p', 'Р' => 'r', 'С' => 's',
			   'Т' => 't', 'У' => 'u', 'Ф' => 'f', 'Х' => 'h', 'Ы' => 'i', 'Э' => 'e',
			   "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", 
                           "щ"=>"shch", "ю"=>"yu", "я"=>"ya",
                           "Ж"=>"zh", "Ц"=>"ts", "Ч"=>"ch", "Ш"=>"sh", 
                           "Щ"=>"shch", "Ю"=>"yu", "Я"=>"ya",
                           "ї"=>"i", "Ї"=>"yi", "є"=>"ye", "Є"=>"ye"));
    return $st;
  }
  
  public static function respond_to_parent($script)
  {
    $script = strtr($script, array("\n" => ''));
    return <<<JAVASCRIPT
      <script type="text/javascript" charset="utf-8">  
        var loc = document.location;
        with(window.parent) { 
	  setTimeout(function () { 
	    $script
            window.loc && loc.replace('about:blank'); 
          }, 1);
	}
      </script></body></html>
JAVASCRIPT;
  }

  public static function items($num, $one, $few, $many)
  {
    if (($num % 10 == 1) &&
	($num % 100 != 11)) {
      return $one;
    } elseif (($num % 10 >= 2) && 
	      ($num % 10 <= 4) && 
	      (($num % 100 < 10) || ($num % 100 >= 20))) {
      return $few;
    } else {
      return $many;
    }
  }
  
  public static function time_from_now_in_words($timestamp_in_past)
  {
    $minutes = round((time() - $timestamp_in_past) / 60);
    $in_words = '';
    if ($minutes < 1) {
      $in_words = 'меньше<br />минуты';
    } elseif ($minutes >= 1 && $minutes <= 45) {
      $in_words = "$minutes ". goodies::items($minutes, 'минуту', 'минуты', 'минут');
    } elseif ($minutes > 45 && $minutes <= 90) {
      $in_words = 'около<br />часа';
    } elseif ($minutes > 90 && $minutes <= 1440) {
      $hours = round($minutes / 60);
      $in_words = "около<br />$hours " . goodies::items($hours, 'часа', 'часов', 'часов');
    } elseif ($minutes > 1440 && $minutes <= 2880) {
      $in_words = '1 день';
    } else {
      $days = round($minutes / 1440);
      $in_words = "$days " . goodies::items($days, 'день', 'дня', 'дней');
    }
    return $in_words;
  }

  public static function value_of_interval($a, $b)
  {
    return ($a == 0 || $b == 0) ? abs($a - $b) : round(($a + $b) / 2);
  }

  public static function empty_when_zero($value)
  {
    return ($value == 0) ? '' : $value;
  }

  public static function topic_pages_links($topic)
  {
    $fragment = '';
    $pages = ceil($topic->answers / Topic_Model::per_page);
    for ($page = 2; $page <= $pages; $page++) {
      $fragment .= html::anchor($topic->show_url() . "?page={$page}", $page, array('class' => 'topic_pages')) . ' ';
    }
    return $fragment;
  }
}

?>
