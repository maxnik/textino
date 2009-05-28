<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=uft-8" />
    <title><?php echo html::specialchars($title) ?></title>
    <?php echo html::stylesheet(array('media/css/admin', ), array('screen', )); ?>
    <?php if (isset($javascripts)) { echo $javascripts; } ?>
  </head>
  <body>
    <div class="minwidth">
      <div class="container">
        <div id="left">
	  <ul class="links">
	    <li><?php echo html::anchor('/admin/articles/index', 'Статьи') ?></li>
	    <li><?php echo html::anchor('/admin/tags/index', 'Метки') ?></li>
            <li><?php echo html::anchor('/admin/images/index', 'Картинки'); ?></li>
            <li><?php echo html::anchor('/admin/settings/index', 'Настройки'); ?></li>
	    <li><?php echo html::anchor('users/logout', 'Выход') ?></li>
	  </ul>
          <?php if (isset($tagging)) { echo $tagging; } ?>
	</div>
	<div id="right">
	  <?php echo $content; ?>
	</div>
      </div>
    </div>
  </body>
</html>
