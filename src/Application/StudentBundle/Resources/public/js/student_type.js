$(function() {
	var request = {};
	$('.student_type > input').on('keyup', function() {
		if (undefined !== request[$(this).attr('id')] && request[$(this).attr('id')].readyState < 4)
			request[$(this).attr('id')].abort();

		$(this).parent().children('i.fa-spinner').show();

		var $input = $(this);

		request[$(this).attr('id')] = $.ajax({
			dataType: "json",
			url: api_road.slice(0,-1) + $(this).val(),
			success: function(response) {
				$input.val(response.id);
				var cotisant = (response.is_contributor ? 'Cotisant' : 'Non cotisant');
				$input.parent().children('span.student-informations').html(response.first_name + ' ' + response.last_name + ' (' + response.class + ') : <span state="' + cotisant + '">' + cotisant + '</span>');
				$input.parent().children('i.fa-spinner').hide();
			},
			error: function(response, textStatus) {
				if (textStatus != "abort")
					$input.parent().children('i.fa-spinner').hide();
			}
		});
	});
	$('.student_type > input').each(function() {
		if ($(this).val().length > 0) {
			$(this).trigger('change');
		}
	});
});
