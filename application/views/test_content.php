<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=uft-8" />
    <?php echo html::stylesheet(array('media/css/site', ), array('screen', )); ?>
    <title><?php echo html::specialchars($title) ?></title>
  </head>
  <body>
    <h1>L33t Str33t</h1>
    <ul>
    <?php foreach ($links as $link => $url): ?>
      <li><?php echo html::anchor($url, $link); ?></li>
    <?php endforeach ?>
    </ul>
    <hr />
    <?php echo $content; ?>
  </body>
</html>
