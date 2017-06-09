$(document).ready(function() { 
	$('#output').hide();
	$(".autosave").everyTime(30000,function() {
		tinyMCE.triggerSave();
		$(this).ajaxSubmit({
			dataType: 'json', 
			success: processJson,
			global: false,
			url: $(this).attr('mh-url'),
			forceSync: true,
			beforeSerialize: function($form, options) { 
				return true;
			}
		});
	});
}); 

// Inspired by http://jamnite.blogspot.com/2009/05/cakephp-form-validation-with-ajax-using.html

// Proccess JSON response
function processJson(response, code) {
	// Prepares #output div to show alerts
	$('#output').addClass('mh-flash');
	$('#output').attr('data-alert', true);
	// Formats #output div according to the type of message
	if (response.errors != false) {
		$('#output').addClass('mh-error');
	} else {
		$('#output').addClass('mh-success');
    }
    // Ensures output is hide and the shows
	$('#output').hide().html(response.message).fadeIn('slow'); 
	// Set a time to auto hide
	setTimeout(function(){ 
      $('#output').fadeOut('slow'); 
    }, 6000); 
	// Remove current errors in fields
    $(".message").remove();
    $(".error-message").remove();
	// Put errors in place
    if (response.errors) {
        showErrors(response);
    }
    // Put new values in place
	if (response.changed) {
		updateFields(response);
    }
}

// Shows the error message in the right place 
function showErrors(data) {
	$.each(data.errors, function(fieldId, errors) {
		var element = $('#' + fieldId);
		element.addClass('error');
		$.each(errors, function(rule, message) {
			var _insert = $(document.createElement('div')).insertAfter(element);
			_insert.addClass('error-message').text(message);
		}); 
	});
}
// Update fields as needed
function updateFields(data) {
	$.each(data.changed, function(fieldId, value) {
		var element = $('#' + fieldId);
		$(element).val(value);
	});
}
