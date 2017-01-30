function formatTitle(title, currentArray, currentIndex, currentOpts) {
    return '<div id="tip7-title">' + (title && title.length ? '<b>' + title + '</b>' : '' ) + 'Image ' + (currentIndex + 1) + ' of ' + currentArray.length + '</div>';
}

$(document).ready(function() {
	$("a.fancyg").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false,
		'cyclic'		:   true,
		'titleShow'     :   true,
		'titlePosition': 'inside',
		'titleFormat'		: formatTitle
	});
});