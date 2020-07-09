/** @format */

$(document).ready(function () {
	(function (d, s, id) {
		// Load the SDK asynchronously
		var js,
			fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s);
		js.id = id;
		js.src = 'https://connect.facebook.net/es_LA/sdk.js';
		fjs.parentNode.insertBefore(js, fjs);
	})(document, 'script', 'facebook-jssdk');

	window.fbAsyncInit = function () {
		FB.init({
			appId: 1807417096249710,
			cookie: true, // Enable cookies to allow the server to access the session.
			xfbml: true, // Parse social plugins on this webpage.
			version: 'v7.0', // Use this Graph API version for this call.
		});

		FB.getLoginStatus(function (response) {
			// Called after the JS SDK has been initialized.
			statusChangeCallback(response); // Returns the login status.
		});
	};

	$('#update_db_politic').on('click', function (e) {
		e.preventDefault();
		function statusChangeCallback(response) {
			// Called with the results from FB.getLoginStatus().
			console.log('statusChangeCallback');
			console.log(response); // The current login status of the person.
			if (response.status === 'connected') {
				// Logged into your webpage and Facebook.
				testAPIPage();
			} else {
				// Not logged into your webpage or we are unable to tell.
				fbLogin();
			}
		}

		function checkLoginState() {
			// Called when a person is finished with the Login Button.
			FB.getLoginStatus(function (response) {
				// See the onlogin handler
				statusChangeCallback(response);
			});
		}

		function testAPIPage() {
			$.ajax({
				url:
					'https://graph.facebook.com/v7.0/me?fields=posts.limit(2)%7Bfrom%2Cshares%2Ccomments%7Bmessage%2Cfrom%2Cid%2Ccreated_time%7D%2Cfull_picture%2Ccreated_time%2Cid%2Cmessage%2Cpicture%2Ctimeline_visibility%2Creactions.limit(1000)%7Bname%2Cprofile_type%2Cusername%2Clink%2Cpic_large%2Ctype%7D%2Clikes%7D&access_token=EAAZAr1hX7oW4BAAdWUnndSGmmZAPjwgGCTdCJHmu2JZCxOG1f6wvF9DLe64FMcs59sm2wkqAGyAsNu6oIwPIWmnRjEPZBBHWAB8I7G1ZC6xlOZBjNZBYw6dBZAoDkrTkNJXWTw3w9p47cMiwfotTPVcMsPJza8jLoZBes3XPrLuUZBZCAZDZD',
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
				}).done(function (response) {
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
		}
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

		checkLoginState();
	});

	$('#update_db_posgrado').on('click', function (e) {
		e.preventDefault();
		alert();
	});
});
