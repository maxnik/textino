<?php
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT') ;
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT') ;
header('Cache-Control: no-store, no-cache, must-revalidate') ;
header('Cache-Control: post-check=0, pre-check=0', false) ;
header('Pragma: no-cache') ;
header( 'Content-Type: text/xml; charset=utf-8' ) ;
echo '<?xml version="1.0" encoding="utf-8" ?>';
?> 
<Connector command="" resourceType="">
  <CurrentFolder path="/" url="http://localhost/k/" />
  <Files>
  <?php foreach ($articles as $article): ?>
    <File name="Статья: <?php echo $article->name; ?>" size="1" url="<?php echo $article->public_url(TRUE); ?>" />
  <?php endforeach; ?>
  <?php foreach ($tags as $tag): ?>
    <File name="Метка: <?php echo $tag->name; ?>" size="1" url="<?php echo $tag->public_url(TRUE); ?>" />
  <?php endforeach; ?>
  </Files>
</Connector>
