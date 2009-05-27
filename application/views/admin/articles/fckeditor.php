<?php

print html::script(array('media/javascript/fckeditor/fckeditor'), FALSE);

?>
<script type="text/javascript">
window.onload = function () {
  var base_path = '/k/media/javascript/fckeditor/';

  var summary_editor = new FCKeditor('summary');
  summary_editor.BasePath = base_path;
  summary_editor.ToolbarSet = 'Basic';
  summary_editor.ReplaceTextarea();

  var body_editor = new FCKeditor('body');
  body_editor.BasePath = base_path;
  body_editor.ReplaceTextarea();
}

function FCKeditor_OnComplete( editorInstance )
{
	editorInstance.Events.AttachEvent( 'OnBlur', FCKeditor_OnBlur ) ;
	editorInstance.Events.AttachEvent( 'OnFocus', FCKeditor_OnFocus ) ;
}

function FCKeditor_OnBlur( editorInstance )
{
	editorInstance.ToolbarSet.Collapse() ;
}

function FCKeditor_OnFocus( editorInstance )
{
	editorInstance.ToolbarSet.Expand() ;
}

</script>
