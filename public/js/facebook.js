/** @format */
window.loading = $('.spinner').hide();
$(document)
	.ajaxStart(function () {
		loading.show();
	})
	.ajaxStop(function () {
		loading.hide();
	})
	.ready(function () {
		$('nav.vertical_nav').on('click', 'a.menu--link', function (event) {
			event.preventDefault();
			event.stopPropagation();
			var content = $('.' + (event.target.getAttribute('data-dest') === null ? 'content' : event.target.getAttribute('data-dest')));
			var url = $(this).attr('href');
			if (url.substring(0, 19) === 'https://bytenew.xyz') {
				url = url.substring(20);
			}
			if (url !== '' && url !== '/') {
				$.ajax({
					method: 'POST',
					url: (url.substring(0, 1) === '/' ? '' : '/') + url,
				}).done(function (resultado) {
					content.hide(0).html(resultado).fadeIn('slow');
					$('#toggleMenu').click();
				});
			} else {
				content.html('<div class="alert alert-warning"><i class="fa fa-warning"></i> No se encuentra disponible el contenido solicitado.</div>');
			}
			if (screen.width < 768) {
				$('.mainnav-toggle').click();
			}
		});

		window.verPerfiles = function () {
			$('#ver_perfiles').on('click', function () {
				event.preventDefault();
				event.stopPropagation();
				$.ajax({
					method: 'get',
					url: '/main/listPeople',
				}).done(function (resultado) {
					$('.content').hide(0).html(resultado).fadeIn('slow');
				});
			});
		};
		verPerfiles();
		window.simpleAlert = function (title, message, position, icon, hideAfter) {
			/**
			 * title: Titúlo de alerta
			 * message:  Mensaje de la alerta
			 * icon: info, warning, success, error
			 * position : top-right, top-left
			 * hideAfter: Tiempo de alerta
			 */
			$.toast({
				heading: title,
				text: message,
				position: position,
				loaderBg: '#ff6849',
				icon: icon,
				hideAfter: hideAfter,
				stack: 6,
			});
		};
	})
	.on('keydown', function (e) {
		if ((e.which || e.keyCode) === 116) e.preventDefault();
	});
