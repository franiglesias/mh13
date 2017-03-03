// Ajax Button Update

$(".mh-ajax-btn-update").off('click').on("click", function(event) {
	$.ajax({
		dataType: "html",
		evalScripts: true,
		url: $(this).attr('href'),
		beforeSend: function(XMLHttpRequest) {
			$($(event.target).attr('mh-indicator')).fadeIn()
		},
		success: function(data, textStatus) {
			$($(event.target).attr('mh-update')).html(data);
		},
		complete: function(XMLHttpRequest, textStatus) {
			$($(event.target).attr('mh-indicator')).fadeOut();
		},
	});
	return false;
});