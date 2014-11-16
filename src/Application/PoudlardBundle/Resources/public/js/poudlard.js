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
	var parallax_container = $(".backgroundPoudlard");
	/*Create the background image holder*/
	parallax_container.prepend("<div class='px_bg_holder'></div>");
	$(".px_bg_holder").css({
	    "background-image" : parallax_container.css("background-image"), /*Get the background image from parent*/
	    "background-position" : "center center",
	    "background-repeat" : "no-repeat",
	    "background-size" : "cover",
	    "position" : "absolute",
	    "height" : $(window).height(), /*Make the element size same as window*/
	    "width" : $(window).width()
	});
	/*We will remove the background at all*/
	parallax_container.css("background","none");
	parallax_container.css("overflow","hidden");/*Don't display the inner element out of it's parent*/
	$(window).scroll(function(){
	    var bg_pos = $(window).scrollTop() - parallax_container.offset().top; /*Calculate the scrollTop of the inner element*/
	    $(".px_bg_holder").css({
	        "margin-top" : bg_pos+"px"
	    });
	});
	$(window).resize(function(){
	    $(".px_bg_holder").css({
	        "height" : $(window).height(),
	        "width" : $(window).width()
	    });
	});
});