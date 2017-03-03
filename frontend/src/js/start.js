var MHCounter = 0;

// toggleClick allows to bind several functions to a click event so you can trigger every one on every click
$.fn.toggleClick=function(){
	var functions=arguments, iteration=0
	return this.click(function(){
		functions[iteration].apply(this,arguments)
		iteration= (iteration+1) %functions.length
	})
}

$.fn.scrollToMe = function(speed, callFunc) {
	var that = this;
	setTimeout(function() {
		var targetOffset = that.offset().top-10;
		$('html,body').eq(0).animate({scrollTop: targetOffset}, speed || 500, callFunc);
	},500);
	return this;
};

// Returns a two digit number right padded with 0
function pad(n){return n<10 ? '0'+n : n;}


function showMessage (message, type) {
	$('#mh-messages').append(
	  $('<div/>')
		.attr('data-alert', true)
	    .addClass("mh-flash "+type)
	    .text(message)
		.hide().slideToggle('slow').delay(3000).slideToggle('slow')
	);	
}
$(document).ready(function(){
	$(document).foundation();
	$(document).trigger('mh-refresh');	
});

$(document).ajaxComplete(function(event, xhr, settings) {
	$(document).foundation();
	$(document).trigger('mh-refresh');
});

$(document).off('mh-refresh').on('mh-refresh', function() {

// Here starts
//