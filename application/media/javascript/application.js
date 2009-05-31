$(document).ready(function () {
  var post_methods = ['delete'];
  for (var index in post_methods) {
    (function (method) {
       
       $('a.' + method).live('click', function () {
	 if (!this.title || confirm(this.title)) {
	   $.ajax({
	     clickedLink: this,
	     beforeSend: function (XMLHttpRequest) {
	       $(this.clickedLink).replaceWith('<img id="busy" src="/k/media/icons/busy.gif" />');
	     },
	     complete: function (XMLHttpRequest, textStatus) {
	       $('img#busy').replaceWith(this.clickedLink);
	     },
	     success: replace_elements,
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
      beforeSend: append_busy,
      complete: remove_busy,
      success: replace_elements,
      type: 'POST',
      url: $form.attr('action'),
      data: $form.serialize(),
      dataType: 'json'
    });
    return false;
  });

  $('input#save-without-reload').click(function () {
    var $form = $(this).parent();
    $.ajax({
      clickedButton: this,
      beforeSend: function (XMLHttpRequest) {
	$('.status').remove();
	append_busy.apply(this, null);
      },
      complete: remove_busy,
      success: function (data, textStatus) {
	$('img#busy').replaceWith('<span class="status">Текст сохранен.</span>');
      },
      type: 'POST',
      url: $form.attr('action'),
      data: {'summary': FCKeditorAPI.GetInstance('summary').GetHTML(),
             'body': FCKeditorAPI.GetInstance('body').GetHTML()},
      dataType: 'json'
    });
    return false;
  });

  $('#month').live('change', function () {
    update_days(parseInt(this.value), parseInt($('#year')[0].value));
  });

  $('#year').live('change', function () {
    update_days(parseInt($('#month')[0].value), parseInt(this.value));
  });

		    
  $('input#publish-article').live('click', function () {
    var $form = $(this).parent();
    $.ajax({
      clickedButton: this,
      beforeSend: append_busy,
      complete: remove_busy,
      success: replace_elements,
      type: 'POST',
      url: $form.attr('action'),
      data: $form.serialize(),
      dataType: 'json'
    });
    return false;
  });

  $('input#upload-preview').live('click', function () {
    append_busy.apply({clickedButton: this}, null);
  });
  
});

function append_busy(XMLHttpRequest) {
  $(this.clickedButton).parent().append('<img id="busy" src="/k/media/icons/busy.gif" />');
}

function remove_busy(XMLHttpRequest, textStatus) {
  $('#busy').remove();
}

function replace_elements(data, textStatus) {
  for (var id in data) {
    $('#' + id).replaceWith(data[id]);
  }
}

function is_leap(year)
{
  return (((year % 4 == 0) && (year % 100 != 0)) || (year % 16 == 0)) ? true : false;
}

var months = [31, function (year) { return is_leap(year) ? 29 : 28; }, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

function update_days(month, year)
{
  var current_day = parseInt($('#day')[0].value);
  var maximum_day = months[month - 1];
  if (maximum_day instanceof Function) {
    maximum_day = maximum_day(year);
  }
  if (current_day > maximum_day) {
    current_day = 1;
  }
  $('select#day option').remove();
  var options = '';
  for (var i = 1; i <= maximum_day; i++) {
    var option = '<option value="' + i + '"';
    if (i == current_day) {
      option += ' selected="selected"';
    }
    option += '>' + i + '</option>';
    options += option;
  }
  $('select#day').append(options);  
}
