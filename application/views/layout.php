<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=uft-8" />
    <title><?php echo html::specialchars($title) ?></title>
    <?php echo html::stylesheet(array('media/css/site', ), array('screen', )); ?>
    <?php if (isset($javascripts)) { echo $javascripts; } ?>
  </head>
  <body>
    <div class="minwidth">
      <div class="container">
        <div id="top"><?php echo html::anchor('/', 'Название блога большими буквами'); ?></div>
        <div id="menu">
	  <ul class="categories">
	    <li><?php echo html::anchor('#', 'Одна категория постов') ?></li>
	    <li><?php echo html::anchor('#', 'Другая категория постов') ?></li>
	    <li><?php echo html::anchor('#', 'Еще одна категория постов') ?></li>
	  </ul>
	</div>
	<div id="main">
	  <?php echo $content; ?>
	</div>
      </div>
    </div>
  </body>
</html>
