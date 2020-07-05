/** @format */

$(document).ready(function () {
	$('.ver_post').on('click', function (e) {
		e.preventDefault();
		$('#post').modal({
			backdrop: false,
			keyboard: false,
			focus: false,
			show: true,
		});
		// $('#post')
		// 	.modal({
		// 		blurring: true,
		// 	})
		// 	.modal('show');
		//$('#post').modal('show');
		//parametrosModal('#post', 'Extracción', 'modal-lg', false, false);

		return;
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
	function parametrosModal(idModal, titulo, tamano, onEscape, backdrop) {
		$(idModal + '-title').html(titulo);
		$(idModal + '-dialog').addClass(tamano);
		$(idModal).modal({
			backdrop: backdrop,
			keyboard: onEscape,
			focus: false,
			show: true,
		});
	}
});
