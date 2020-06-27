/** @format */

$(document).ready(function () {
	$('#update_db_politic').on('click', function (e) {
		e.preventDefault();
		$.ajax({
			url: '/data/rechargeDataBasePolitic',
		})
			.done(function (data) {
				if (typeof data.success !== 'undefined') {
					simpleAlert('CORRECTO', data.success, 'top-right', 'success', 6000);
				} else {
					simpleAlert('ERROR', data.error, 'top-right', 'error', 6000);
				}
			})
			.fail(function (jqXHR, textStatus) {
				simpleAlert(jqXHR.statusText, jqXHR.status, 'top-right', 'error', 3000);
				console.log(jqXHR.responseText);
			});
	});
});
