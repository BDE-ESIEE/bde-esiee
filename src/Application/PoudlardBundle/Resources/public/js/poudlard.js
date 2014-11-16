$(function() {
	$('.showFullTable').click(function (e) {
		e.preventDefault();
		var house = $(this).attr('target-house');
		$('div.house-column[house!="' + house + '"]').hide('slow');
		$('div.house-table[table-house="' + house + '"]').show('slow');
		$('html, body').animate({
	        scrollTop: $("#title").offset().top
	    }, 1000);
	});
	$('.hideFullTable').click(function (e) {
		e.preventDefault();
		$('div.house-column').show('slow');
		$('div.house-table').hide('slow');
	});
	if (jQuery.browser.mobile)
		$('animate').remove();
});