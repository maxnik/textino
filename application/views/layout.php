<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
  <head>
    <title><?php echo html::specialchars($title) ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=uft-8" />
    <meta name="description" content="<?php echo isset($description) ? $description : 'Блог обо всем'; ?>" />    
    <?php echo html::stylesheet(array('media/css/site', ), array('screen', )); ?>
    <link rel="alternate" type="application/rss+xml" href="<?php echo url::base().'feed.xml'; ?>" title="Название блога" />
  </head>
  <body>
    <div class="minwidth">
      <div class="container">
        <div id="top">
          <?php echo html::anchor('/', 'Название блога большими буквами'); ?>
          <?php echo html::anchor('/sitemap', 'Карта', array('style' => 'color: red;')); ?>            
          <?php echo html::anchor('/feed.xml', 'RSS', array('style' => 'color: pink;',
							    'type' => 'application/rss+xml')); ?>  
       </div>
        <div id="menu">
          Разделы
	  <ul class="categories">
	  <?php foreach ($categories as $category): ?>
	    <li><?php echo html::anchor($category->public_url(), $category->name) ?></li>
	  <?php endforeach; ?>
	  </ul>
          Облако тегов
	  <p>
	  <?php foreach ($tags as $tag): ?>
	    <?php $font_size =  number_format(0.6 + $tag->total_articles * 0.1, 1, '.', ''); ?>
	    <?php echo html::anchor($tag->public_url(), "{$tag->name}",
				    array('style' => "font-size: {$font_size}em;")) ?>
	  <?php endforeach; ?>
	  </p>
          Архив
	  <ul class="months">
	  <?php foreach ($months as $month): ?>
	    <li><?php echo html::anchor($month->public_url(), $month->name) ?></li>
	  <?php endforeach; ?>
	  </ul>
	</div>
	<div id="main">
	  <?php echo $content; ?>
	</div>
      </div>
    </div>
  </body>
</html>
