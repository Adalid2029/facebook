/** @format */

$(document).ready(function () {
	//simpleAlert('INFORMACIÓN', 'No se elimino el archivo', 'top-right', 'error', 10000);
	//simpleAlert('EXITOSO', 'Se elimino el archivo ', 'top-right', 'success', 10000);
	//simpleAlert('EXITOSO', 'Se elimino el archivo ', 'top-right', 'warning', 10000);
	//simpleAlert('EXITOSO', 'Se elimino el archivo ', 'top-right', 'info', 10000);
	verPerfiles();
	$('.live_stream').owlCarousel({
		items: 10,
		loop: false,
		margin: 10,
		nav: true,
		dots: false,
		navText: ["<i class='uil uil-angle-left'></i>", "<i class='uil uil-angle-right'></i>"],
		responsive: {
			0: {
				items: 2,
			},
			600: {
				items: 3,
			},
			1000: {
				items: 3,
			},
			1200: {
				items: 5,
			},
			1400: {
				items: 6,
			},
		},
	});
});
