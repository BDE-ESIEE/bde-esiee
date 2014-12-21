$(function() {
	$('span[student-id]').each(function() {
		if ($(this).attr('student-id').length > 6)
		{
			var $span = $(this);
			$.ajax({
				dataType: "json",
				url: api_road.slice(0,-1) + $(this).attr('student-id'),
				success: function(response) {
					$span.text(response.first_name + ' ' + response.last_name);
				},
				error: function(response, textStatus) {
					$span.text('(Mauvais ID)');
				}
			});
		} else {
			$(this).text('(Non renseigné)');
		}
	});
	$('span[student-id-contributor]').each(function() {
		if ($(this).attr('student-id-contributor').length > 6)
		{
			var $span = $(this);
			$.ajax({
				dataType: "json",
				url: api_road.slice(0,-1) + $(this).attr('student-id-contributor'),
				success: function(response) {
					var cotisant = (response.is_contributor ? 'Cotisant(e)' : 'Non cotisant(e)');
					$span.html('<span state="' + cotisant + '">' + cotisant + '</span>');
				},
				error: function(response, textStatus) {
					$span.text('(Mauvais ID)');
				}
			});
		}
	});
});
