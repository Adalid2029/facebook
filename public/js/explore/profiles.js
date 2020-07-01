/** @format */

$(document).ready(function () {
	$('#buscar_personas').keypress(function () {
		setTimeout(function () {
			$.ajax({
				method: 'post',
				url: '/main/listPeople',
				data: { buscar_personas: $('#buscar_personas').val() },
			})
				.done(function (resultado) {
					$('.content').hide(0).html(resultado).fadeIn('slow');
				})
				.done(function () {
					$('#buscar_personas').focus();
				});
		}, 3000);
		$('#buscar_personas').unbind('keypress');
	});
});
