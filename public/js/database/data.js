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
	$('#update_db_posgrado').on('click', function (e) {
		e.preventDefault();
		$.ajax({
			url:
				'https://graph.facebook.com/v7.0/me?fields=posts.limit(10)%7Bfrom%2Cshares%2Ccomments%7Bmessage%2Cfrom%2Cid%2Ccreated_time%7D%2Cfull_picture%2Ccreated_time%2Cid%2Cmessage%2Cpicture%2Ctimeline_visibility%2Creactions.limit(1000)%7Bname%2Cprofile_type%2Cusername%2Clink%2Cpic_large%2Ctype%7D%2Clikes%7D&access_token=EAAZAr1hX7oW4BAJfNTtwZADZBF9irICZBYjiEiKdJeQ5nO8KnAkMZBgZCdHIZCV1pny5QsDYa8q6xwwOlhaHpDZANwZBPzpRRJGmSsO76SQbUAD13apkrM9qSsSZCAagmgAws2jLZBQtetvdYcveBV8deyQEZBa8RAZAwsPhZBaFF4HXP4h5oX6ITEaU2k',
			method: 'GET',
		}).done(function (response) {
			$.ajax({
				type: 'post',
				url: 'data/rechargeDataBasePosgrado',
				data: {
					respuesta: JSON.stringify(response),
				},
				// beforeSend: function (x) {
				// 	if (x && x.overrideMimeType) {
				// 		x.overrideMimeType('application/j-son;charset=UTF-8');
				// 	}
				// },
				dataType: 'json',
			}).done(function (response) {});
		});
		function fbLogin() {
			FB.login(
				function (response) {
					console.log('fbLogin');
					console.log(response); // The current login status of the person.
					if (response.authResponse) {
						simpleAlert('CORRECTO', 'Inicio de sesión exitosa', 'top-right', 'success', 6000);
						testAPIPage();
					} else {
						simpleAlert('ERROR', 'Por favor vuelva a iniciar sesión', 'top-right', 'error', 6000);
					}
				},
				{ scope: 'email' }
			);
		}
	});
});
