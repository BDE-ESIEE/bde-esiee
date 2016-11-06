var request = {};
function searchStudent($input) {
	if (undefined !== request[$input.attr('id')] && request[$input.attr('id')].readyState < 4)
		request[$input.attr('id')].abort();

	$input.parent().children('i.fa-spinner').show();

	request[$input.attr('id')] = $.ajax({
		dataType: "json",
		url: api_road + $input.val(),
		success: function(response) {
			$input.trigger('studentFound', response);
			$input.val(response.id);
			$input.blur();
			var cotisant = (response.is_contributor ? 'Cotisant(e)' : 'Non cotisant(e)');
			$input.parent().children('span.student-informations').html(response.first_name + ' ' + response.last_name + ' (' + response.class + ') : <span state="' + cotisant + '">' + cotisant + '</span>');
			$input.parent().children('i.fa-spinner').hide();
		},
		error: function(response, textStatus) {
			if (textStatus != "abort")
				$input.parent().children('i.fa-spinner').hide();
		}
	});
}

$(function() {
	$('.student_type > input').on('keyup', function() {
		searchStudent($(this));
	});
	$('.student_type > input').each(function() {
		if ($(this).val().length > 0) {
			$(this).trigger('keyup');
		}
	});
});
