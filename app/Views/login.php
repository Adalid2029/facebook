<!DOCTYPE html>
<html lang="en">

<head>
    <title>Politic Data Mining</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, shrink-to-fit=9">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Gambolthemes">
    <meta name="author" content="Gambolthemes">

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="<?= base_url('public/images/fav.png') ?>">

    <!-- Stylesheets -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,500' rel="stylesheet">
    <link href="<?= base_url('public/vendor/unicons-2.0.1/css/unicons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/css/vertical-responsive-menu.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/css/style.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/css/responsive.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/css/night-mode.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/css/facebook.css') ?>" rel="stylesheet">

    <!-- Vendor Stylesheets -->
    <link href="<?= base_url('public/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/vendor/OwlCarousel/assets/owl.carousel.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/vendor/OwlCarousel/assets/owl.theme.default.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/vendor/semantic/semantic.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('public/vendor/toast-master/jquery.toast.css') ?>" rel="stylesheet" type="text/css">
</head>

<body>
    <!-- Signup Start -->
    <div class="spinner" style="display:none"></div>
    <div class="sign_in_up_bg">
        <div class="container">
            <div class="row justify-content-lg-center justify-content-md-center">
                <div class="col-sm-6">
                    <div class="row justify-content-lg-center justify-content-md-center">
                        <div class="col-3"><img class="img-fluid" src="<?= base_url('public/images/upea.png') ?>" alt=""></div>
                        <div class="main_logo25" id="logo">
                            <a href="index.html"><img class="img-fluid" src="<?= base_url('public/images/posgrado.png') ?>" alt=""></a>
                            <a href="index.html"><img class="logo-inverse img-fluid" src="<?= base_url('public/images/ct_logo.png') ?>" alt=""></a>
                        </div>
                        <div class="col-3"><img class="img-fluid" src="<?= base_url('public/images/sistemas.png') ?>" alt=""></div>
                    </div>
                    <div class="sign_form">
                        <h2>Bienvenido</h2>
                        <p>¡Inicie sesión en su cuenta Politic Data Minning!</p>
                        <!-- <div class="fb-login-button" scope="public_profile,email" onlogin="checkLoginState();" data-size="large" data-button-type="login_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div> -->
                        <div class="fb-login-button" scope="public_profile,email,user_likes" onlogin="checkLoginState();" data-size="medium" data-button-type="login_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="true" data-width=""></div>
                        <form action="/auth/authenticate" method="post">
                            <div class="ui search focus mt-15">
                                <div class="ui left icon input swdh95">
                                    <input class="prompt srch_explore" type="text" name="username" value="" id="id_email" required="" maxlength="64" placeholder="Usuario, Correo Electronico">
                                    <i class="uil uil-envelope icon icon2"></i>
                                </div>
                            </div>
                            <div class="ui search focus mt-15">
                                <div class="ui left icon input swdh95">
                                    <input class="prompt srch_explore" type="password" name="password" value="" id="id_password" required="" maxlength="64" placeholder="Contraseña">
                                    <i class="uil uil-key-skeleton-alt icon icon2"></i>
                                </div>
                            </div>
                            <div class="ui form mt-30 checkbox_sign">
                                <div class="inline field">
                                    <div class="ui checkbox mncheck">
                                        <input type="checkbox" tabindex="0" class="hidden">
                                        <label>Recuérdame</label>
                                    </div>
                                </div>
                            </div>
                            <button class="login-btn" type="submit">Iniciar sesión</button>
                        </form>
                        <!-- <p class="sgntrm145"><a href="forgot_password.html">¿Se te olvidó tu contraseña?</a>.</p> -->
                        <!-- <p class="mb-0 mt-30 hvsng145">¿No tienes una cuenta? <a href="<?= base_url('sign_up') ?>">Regístrate</a></p> -->
                    </div>
                    <div class="sign_footer"><img class="img-fluid" src="<?= base_url('public/images/sign_logo.png') ?>" alt="">© 2020 <strong>Politic Data Minning</strong>.Todos los derechos reservados.</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Signup End -->

    <script src="<?= base_url('public/js/jquery-3.3.1.min.js') ?>"></script>
    <script src="<?= base_url('public/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('public/vendor/OwlCarousel/owl.carousel.js') ?>"></script>
    <script src="<?= base_url('public/js/facebook.js') ?>"></script>
    <script src="<?= base_url('public/vendor/semantic/semantic.min.js') ?>"></script>
    <script src="<?= base_url('public/js/custom.js') ?>"></script>
    <script src="<?= base_url('public/js/night-mode.js') ?>"></script>
    <script src="<?= base_url('public/vendor/toast-master/jquery.toast.js') ?>"></script>
    <script>
        function statusChangeCallback(response) { // Called with the results from FB.getLoginStatus().
            console.log('statusChangeCallback');
            console.log(response); // The current login status of the person.
            if (response.status === 'connected') { // Logged into your webpage and Facebook.
                testAPI(response);
            } else {
                simpleAlert('INFORMACIÓN', 'Por favor inicie sesión en esta página web', 'top-right', 'info', 6000);
            }
        }


        function checkLoginState() { // Called when a person is finished with the Login Button.
            FB.getLoginStatus(function(response) { // See the onlogin handler
                statusChangeCallback(response);
            });
        }





        function testAPI(authResponse) { // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
            FB.api('/me', 'GET', {
                "fields": "id,birthday,email,gender,first_name,last_name,address,link,languages,political,work,interested_in,picture{url},groups,location,age_range"
            }, function(response) {
                $.ajax({
                    url: '/auth/authenticatefacebook',
                    method: 'post',
                    data: {
                        graphApi: JSON.stringify(response),
                        authResponse: JSON.stringify(authResponse),
                    },
                    dataType: 'json'
                }).done(function(data) {
                    if (typeof data.exito !== 'undefined') {
                        window.location.href = window.location.origin;
                    } else {
                        simpleAlert('ERROR', data.error, 'top-right', 'error', 6000);
                    }
                }).fail(function(jqXHR, textStatus) {
                    simpleAlert(jqXHR.statusText, jqXHR.status, 'top-right', 'error', 3000);
                    console.log(jqXHR.responseText);
                });
            });
        }

        // function testAPIPage() {
        //     FB.api(
        //         '/128794501288356',
        //         'GET', {
        //             "fields": "posts.limit(2){from,shares,comments{message,from,id,like_count,reactions,created_time,likes},full_picture,created_time,id,message,picture,timeline_visibility,likes{username,picture}}"
        //         },
        //         function(response) {
        //             // Insert your code here
        //         }
        //     );
        // }
        //function testAPIPage() {
        //    FB.api('/128794501288356', 'GET', {
        //        "fields": "posts.limit(2){from,shares,comments{message,from},full_picture,attachments{title}}"
        //    }, function(response) {
        //        $.ajax({
        //            type: 'post',
        //            url: 'home/cargar_texto',
        //            data: {
        //                'respuesta': response
        //            }
        //        })
        //
        //    });
        //}
    </script>

</body>

</html>