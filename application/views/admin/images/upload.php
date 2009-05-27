<script type="text/javascript">

(function () {
  var d = document.domain;
  while (true) {
    try {
      var A = window.parent.document.domain;
      break;
    } catch (e) {
    }
    d = d.replace(/.*?(?:\.|$)/, '');
    if (d.length == 0)
      break;
    try {
      document.domain = d;
    } catch (e) {
      break;
    }
  }
})();
<?php print "window.parent.OnUploadCompleted($error_number, '$file_url', '$file_name', '$message'); "; ?>
</script>
