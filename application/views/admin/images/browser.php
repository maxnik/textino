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
  <CurrentFolder path="/" url="http://localhost/k/media/upload" />
  <Files>
  <?php foreach ($images as $image): ?>
    <File name="<?php echo $image['name']; ?>" size="<?php echo $image['size']?>" 
     url="<?php echo $image['url']; ?>" />
  <?php endforeach; ?>
  </Files>
</Connector>
