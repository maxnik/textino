<?php

print html::script(array('media/javascript/jquery-1.3.min',
			 'media/javascript/drag_drop_sorting/core',
			 'media/javascript/drag_drop_sorting/events',
			 'media/javascript/drag_drop_sorting/css',
			 'media/javascript/drag_drop_sorting/coordinates',
			 'media/javascript/drag_drop_sorting/drag',
			 'media/javascript/drag_drop_sorting/dragsort',
			 'media/javascript/application'), FALSE);
?>
<script type="text/javascript">
var dragsort = ToolMan.dragsort();
var drag_started = false; // hack hack hack

$(document).ready(function () {

  var record_list = $('#records')[0];
  if (record_list) {
    dragsort.makeListSortable(record_list,
			      function (item) {
                                item.toolManDragGroup.verticalOnly();
			      },
		              function (item) {
                                var group = item.toolManDragGroup;
			        var element = group.element;
			        var list = element.parentNode;
			        group.register('dragstart', function () {
                                  drag_started = true;
                                });
			        group.register('dragend', function () {
				  if (drag_started) {
				    var records = list.getElementsByTagName('li');
				    var data = {};
				    var position = 1;
				    for (var i = 0; i < records.length; i++) {
				      // array index starts from 0, but position starts from 1
				      data[records[i].id] = i + 1; 
				    }
				    $.ajax({
                                      dropped: element,
                                      beforeSend: function (XMLHttpRequest) {
				        $(this.dropped).append('<img id="busy" src="/k/media/images/busy.gif" />');
                                      },
				      complete: function () {
                                        $('img#busy').remove();
                                      },
                                      type: 'POST',
				      url: '/k/admin/taggings/edit/<?php echo $tag_id; ?>',
				      data: data
				    });
				    drag_started = false;
				  }
                                });
			      });
  }
});
</script>
