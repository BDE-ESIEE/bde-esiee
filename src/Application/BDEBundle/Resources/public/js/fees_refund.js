$(function() {
    $('.student_type > input').on('studentFound', function(e, student) {
		// console.log(student);
		$.getJSON(api_clubs_road.replace('0000000', student.id), function(response) {
			// console.log(response);
			var memberOf      = _.filter(clubs, function(club) { return response.indexOf(club.id) > -1; });
			var isByOldMember = _.some(memberOf, { 'is_fee_by_old': true });
			// console.log(memberOf);

			var feesNewMember = _.fill(Array(memberOf.length), 0);
			var feesOldMember = _.fill(Array(memberOf.length), 0);
			var fee = '';
			var table = '<thead>';

			if (student.class.includes('F')) {
				fee = 'fee_apprentice';
			} else if (student.class.includes('1') || student.class.includes('2') || student.class.includes('3')) {
				fee = 'fee_e1_e3';
			} else if (student.class.includes('4')) {
				fee = 'fee_e4';
			} else {
				fee = 'fee_e5';
			}

			if (isByOldMember) {
				table += ''
					+ '<tr><th>Club</th><th>Cotisation pour les nouveaux</th><th>Cotisation pour les anciens</th></tr>'
				;
			} else {
				table += ''
					+ '<tr><th>Club</th><th>Cotisation</th></tr>'
				;
			}

			table += '</thead><tbody>';

			// console.log(fee);

			_.forEach(memberOf, function(club, i) {
				table += '<tr><td>' + club.title + '</td>';

				if (club.is_fee_by_old) {
					feesNewMember[i] = club['fee_new_member'];
					feesOldMember[i] = club['fee_old_member'];
				} else {
					feesNewMember[i] = club[fee];
					feesOldMember[i] = club[fee];
				}

				if (isByOldMember) {
					table += '<td>' + feesNewMember[i] + '</td><td>' + feesOldMember[i] + '</td>';
				} else {
					table += '<td>' + feesNewMember[i] + '</td>';
				}

				table += '</tr>';
			});

			table += '</tbody>';

			// console.log(feesNewMember, feesOldMember);

			var sumNewMember = _.reduce(feesNewMember, function(sum, fee) { return sum + fee; }, 0);
			var sumOldMember = _.reduce(feesOldMember, function(sum, fee) { return sum + fee; }, 0);
			var refundFunction = function(sum) {
				var refund = 0;
				if (sum >= 30 && sum < 40) {
					refund = _.round(sum * 0.15, 2);
				} else if (sum >= 40) {
					refund = _.round(sum * 0.20, 2);
				}
				return refund;
			};
			var refundNewMember = refundFunction(sumNewMember);
			var refundOldMember = refundFunction(sumOldMember);

			var template = 'Tu es membre de <b>${ clubsNb }</b> clubs et tu as cotisé pour un total de <b>${ sumNewMember }€</b>';

			table += '<tfoot><tr><th>Total</th>';

			if (isByOldMember) {
				table += '<th>' + sumNewMember + '</th><th>' + sumOldMember + '</th>';
				template += ' (ou <b>${ sumOldMember }€</b>)';
			} else {
				table += '<th>' + sumNewMember + '</th>';
			}

			table += '</tr></tfoot>';
			if (refundNewMember > 0 || refundOldMember > 0) {
				template += '. Par conséquent, le BDE va te rembourser <b>${ refundNewMember }€</b>';

				if (isByOldMember) {
					template += ' (ou <b>${ refundOldMember }€</b>)';
				}
			} else {
				template += '. Pour être remboursé par le BDE, il faut avoir cotisé pour au minimum <b>30€</b>';
			}

			template += '.';
			var compiled = _.template(template);
			$('div#explication').html(
				compiled({ 
					'clubsNb'         : memberOf.length, 
					'sumNewMember'    : sumNewMember, 
					'sumOldMember'    : sumOldMember, 
					'refundNewMember' : refundNewMember,
					'refundOldMember' : refundOldMember
				})
			);

			$('table#fees').html(table);

			$('#results').removeClass('hidden');
		});
	});
});
