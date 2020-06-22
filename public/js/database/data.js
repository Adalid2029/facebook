/** @format */

$(document).ready(function () {
	$('#update_db_politic').on('click', function (e) {
		e.preventDefault();
		$.ajax({
			url: '/data/rechargeDataBasePolitic',
		}).done(function (success) {});
	});

	$('#update_db_posgrado').on('click', function (e) {
		e.preventDefault();
		alert();
	});
});
