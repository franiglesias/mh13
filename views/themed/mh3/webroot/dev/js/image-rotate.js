// Image Rotate

$(".mh-image-rotate").off('click').on("click", function(event) {
	event.preventDefault();
	event.stopPropagation();
	var params = {};
	params.file = $(event.target).attr('mh-file');
	params.angle = $(event.target).attr('mh-angle');
	params.size = $(event.target).attr('mh-size');
	
	$.ajax({
		async: true,
		dataType: "html",
		url: $(this).attr('href'),
		data: params,
		global: false,
		beforeSend: function(XMLHttpRequest) {
			$($(event.target).attr('mh-indicator')).fadeIn();
		},
		success: function(data, textStatus) {
			$($(event.target).attr('mh-update')).html(data);
		},
		complete: function(XMLHttpRequest, textStatus) {
			$($(event.target).attr('mh-indicator')).fadeOut();
			showMessage('Image rotated', 'mh-success');
		},
	});
	return false;
});
