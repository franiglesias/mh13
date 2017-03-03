// Ajax button

$('.mh-ajax-button').off('click').on('click',
	function(event) {
		var MHIndicator = $(this).attr('mh-indicator');
		var MHUpdate = $(this).attr('mh-update');
		$(MHIndicator).fadeIn();
	    $.ajax({
	        url: $(this).attr('href'),
			cache: false,
			success: function(data) {
			    $(MHUpdate).html(data);
			},
			complete: function(data) {
				$(MHIndicator).fadeOut();
			}
		});
    return false;
	});	
