<?php
/**
 * \brief A simple class used to serve css, images and js files from the media directory.
 *
 * This class also compresses js and css files with gzip compression (if the browser supports it) and correctly handles
 * Last-Modified headers to prevent sending unmodified files to the client.
 *
 * The two techniques together can save a lot of bandwidth! Pre-packing javascript files with the opensource YUIcompressor
 * yelds the smallest gzip results. Use it in production!!
 *
 **/
class Media_Controller extends Controller {

  public function send() {
    $file = Router::$current_uri;
    $pos = strrpos($file, '.');
    $ext = ($pos === false) ? '' : substr($file, $pos + 1);
    
    $file = '/var/www/html/k/application/' . $file;

    if (! is_file($file)) {
      throw new Kohana_404_Exception;
    } else {
      $mtime = filemtime($file);
      $content_type = Kohana::config("mimes.$ext");
      header("Last-Modified: ".gmdate("D, d M Y H:i:s", $mtime)." GMT");
      header('Content-Type: ' . $content_type[0]);
      $oldmtime = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
      if (strtotime($oldmtime) >= $mtime) {
	header('HTTP/1.1 304 Not Modified');
      } else {
	readfile($file);
      }
    }
  }
}
?>
