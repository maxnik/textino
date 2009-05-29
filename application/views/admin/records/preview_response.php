<head>

<?php

print html::script(array('media/javascript/jquery-1.3.min',
			 'media/javascript/application'), FALSE);

$response = View::factory('admin/records/preview')
     ->bind('record', $record)
     ->render(FALSE);
echo goodies::respond_to_parent("$('#preview-form').replaceWith('$response')"); 

?>

</head>