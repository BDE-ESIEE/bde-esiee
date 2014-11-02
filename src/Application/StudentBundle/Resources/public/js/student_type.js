$(function() {
	var request = {};
	$('.student_type > input').on('change', function() {
		if (undefined !== request[$(this).attr('id')] && request[$(this).attr('id')].readyState < 4)
			request[$(this).attr('id')].abort();

		$(this).parent().children('i.fa-spinner').show();

		var $input = $(this);

		request[$(this).attr('id')] = $.ajax({
			dataType: "json",
			url: api_road.slice(0,-1) + $(this).val(),
			success: function(response) {
				$input.val(response.id);
				$input.parent().children('span.student-firstname').text(response.first_name);
				$input.parent().children('span.student-lastname').text(response.last_name);
				$input.parent().children('span.student-class').text('(' + response.class + ')');
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
