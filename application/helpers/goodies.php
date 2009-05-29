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
}

?>
