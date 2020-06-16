<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=9">
    <meta name="description" content="Gambolthemes">
    <meta name="author" content="Gambolthemes">
    <title>Cursus - Sign Up</title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="images/fav.png">

    <!-- Stylesheets -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
    <link href='<?= base_url('vendor/unicons-2.0.1/css/unicons.css') ?>' rel='stylesheet'>
    <link href="<?= base_url('css/vertical-responsive-menu.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/responsive.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/night-mode.css') ?>" rel="stylesheet">

    <!-- Vendor Stylesheets -->
    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('vendor/OwlCarousel/assets/owl.carousel.css') ?>" rel="stylesheet">
    <link href="<?= base_url('vendor/OwlCarousel/assets/owl.theme.default.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('vendor/semantic/semantic.min.css') ?>" rel="stylesheet" type="text/css">

</head>

<body>
    <!-- Signup Start -->
    <div class="sign_in_up_bg">
        <div class="container">
            <div class="row justify-content-lg-center justify-content-md-center">
                <div class="col-lg-12">
                    <div class="main_logo25" id="logo">
                        <a href="index.html"><img src="<?= base_url('images/logo.svg') ?>" alt=""></a>
                        <a href="index.html"><img class="logo-inverse" src="<?= base_url('images/ct_logo.svg') ?>" alt=""></a>
                    </div>
                </div>

                <div class="col-lg-6 col-md-8">
                    <div class="sign_form">
                        <h2>Welcome to Edututs+</h2>
                        <p>Sign Up and Start Learning!</p>
                        <form>
                            <div class="ui search focus">
                                <div class="ui left icon input swdh11 swdh19">
                                    <input class="prompt srch_explore" type="text" name="name" value="" required="" placeholder="Nombres">
                                </div>
                            </div>
                            <div class="ui search focus mt-15">
                                <div class="ui left icon input swdh11 swdh19">
                                    <input class="prompt srch_explore" type="text" name="last_name" value="" required="" placeholder="Apellidos">
                                </div>
                            </div>
                            <div class="ui search focus mt-15">
                                <div class="ui left icon input swdh11 swdh19">
                                    <input class="prompt srch_explore" type="text" name="user_name" value="" required="" placeholder="Correo Electrónico">
                                </div>
                            </div>
                            <div class="ui search focus mt-15">
                                <div class="ui left icon input swdh11 swdh19">
                                    <input class="prompt srch_explore" type="email" name="emailaddress" value="" required="" placeholder="Email Address">
                                </div>
                            </div>
                            <div class="ui search focus mt-15">
                                <div class="ui left icon input swdh11 swdh19">
                                    <input class="prompt srch_explore" type="password" name="password" value="" id="id_password" required="" maxlength="64" placeholder="Password">
                                </div>
                            </div>
                            <div class="ui search focus mt-15">
                                <div class="ui left icon input swdh11 swdh19">
                                    <input class="prompt srch_explore" type="password" name="password" value="" id="id_password" required="" maxlength="64" placeholder="Password">
                                </div>
                            </div>

                            <button class="login-btn" type="submit">Next</button>
                        </form>
                        <p class="sgntrm145">Al registrarte, aceptas nuestros <a href="terms_of_use.html">Términos de uso </a> y <a href="terms_of_use.html">Política de privacidad.</a>.</p>
                        <p class="mb-0 mt-30">¿Ya tienes una cuenta? <a href="sign_in.html">Iniciar sesión</a></p>
                    </div>
                    <div class="sign_footer"><img src="<?= base_url('images/sign_logo.png') ?>" alt="">© 2020 <strong>Cursus</strong>. All Rights Reserved.</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Signup End -->

    <script src="<?= base_url('js/jquery-3.3.1.min.js') ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('vendor/OwlCarousel/owl.carousel.js') ?>"></script>
    <script src="<?= base_url('vendor/semantic/semantic.min.js') ?>"></script>
    <script src="<?= base_url('js/custom.js') ?>"></script>
    <script src="<?= base_url('js/night-mode.js') ?>"></script>

</body>

</html>