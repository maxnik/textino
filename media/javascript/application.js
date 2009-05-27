$(document).ready(function () {
  var post_methods = ['delete'];
  for (var index in post_methods) {
    (function (method) {
       
       $('a.' + method).live('click', function () {
	 if (!this.title || confirm(this.title)) {
	   $.ajax({
	     clickedLink: this,
	     beforeSend: function (XMLHttpRequest) {
	       $(this.clickedLink).replaceWith('<img id="busy" src="/k/media/images/busy.gif" />');
	     },
	     complete: function (XMLHttpRequest, textStatus) {
	       $('img#busy').replaceWith(this.clickedLink);
	     },
	     success: function (data, textStatus) {
	       replace_elements(data);
	     },
	     type: 'POST',
	     url: this.href,
	     dataType: 'json'
	   });
	 }
	 return false;
       }).attr('rel', 'nofollow');
       
    })(post_methods[index]);
  }
		    
  $('input#tag_something').click(function () {
    var $form = $(this).parent();
    $.ajax({
      clickedButton: this,
      beforeSend: function (XMLHttpRequest) {
	$(this.clickedButton).parent().append('<img id="busy" src="/k/media/images/busy.gif" />');
      },
      complete: function (XMLHttpRequest, textStatus) {
	$('#busy').remove();
      },
      success: function (data, textStatus) {
	replace_elements(data);
      },
      type: 'POST',
      url: $form.attr('action'),
      data: $form.serialize(),
      dataType: 'json'
    });
    return false;
  });
});

function replace_elements(elems) {
  for (var id in elems) {
    $('#' + id).replaceWith(elems[id]);
  }
}
