// Autocomplete fields. Autocomplete view should return an array of label, value keys
$('.mh-autocomplete').autocomplete({
	minLength: 3,
	source: function(request, response) {
		var selector = '#'+this.element[0].id;
		var url = $(selector).attr('mh-url');
		$.ajax({
			dataType: "json",
			global: false,
			url: url,
			data: {term: request.term},
			success: function(data) {
				response($.map(data, function(item) {
					return {label: item.label, value: item.value};
				}));
			},
			error:function(jqXHR, textStatus, errorThrown) {
			    alert(textStatus);
			    alert(errorThrown);
			}
		});
	},
	// updates fields with current menu selection
	focus: function (event, ui) {
		var selector = '#'+event.target.id;
		var target = '#'+$(selector).attr('mh-target');
		$(selector).val( ui.item.label );
		$(target).val( ui.item.value );
		return false
	},
	// fix the desired value and label
	select: function  (event, ui) {
		var selector = '#'+event.target.id;
		var target = '#'+$(selector).attr('mh-target');
		$(selector).val( ui.item.label );
		$(target).val( ui.item.value );
		return false;
	},
});
// End autocomplete
