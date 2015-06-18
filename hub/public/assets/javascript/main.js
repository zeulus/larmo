var selectActiveFilter = function(element) {
	$('#filters .filter-button').removeClass('active');
	element.parent().addClass('active');
};

var filterMessage = function(element) {
	if ($('.'+element.context.id).length < 1) {
		$('.message').slideDown(300).delay(300);
	} else {
		$('.message').slideUp(300).delay(400);
		$('.'+element.context.id).slideDown(300).delay(300);		
	}
};

$(document).ready(function() {

	// POC: Filtering messages
	$('#filters a').click(function() {
		selectActiveFilter($(this));
		filterMessage($(this));
	});

});