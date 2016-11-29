$(function() {
	$('#refundButton').click(function(e) {
		e.preventDefault();

		$.ajax({
			url     : $('#refundButton').attr('href'),
			method  : 'PATCH',
			success : function(response) {
				if (response.success)
					$('#refundButton').addClass('disabled').text('Déjà remboursé');
			}
		})
	});

    $('.student_type > input').on('studentFound', function(e, student) {
		$('#refundButton').attr('href', $('#refundButton').attr('href').replace(/\d+/, student.id));

		$.get($('#refundButton').attr('href-check').replace(/\d+/, student.id), function(response) {
			if (response) {
				$('#refundButton').addClass('disabled').text('Déjà remboursé');
			} else {
				$('#refundButton').removeClass('disabled').text('Marquer comme remboursé');
			}
		});
    });
});
