<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=9">
    <meta name="description" content="Gambolthemes">
    <meta name="author" content="Gambolthemes">
    <title>Politic Data Mining</title>

    <!-- Favicon Icon -->
    <link href="<?= base_url('public/images/fav.png') ?>" rel="icon" type="image/png">

    <!-- Stylesheets -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
    <link href='<?= base_url('public/vendor/unicons-2.0.1/css/unicons.css') ?>' rel='stylesheet'>
    <link href="<?= base_url('public/css/vertical-responsive-menu.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/css/style.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/css/responsive.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/css/night-mode.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/css/instructor-dashboard.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/css/instructor-responsive.css') ?>" rel="stylesheet">

    <!-- Vendor Stylesheets -->
    <link href="<?= base_url('public/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/vendor/OwlCarousel/assets/owl.carousel.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/vendor/OwlCarousel/assets/owl.theme.default.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/vendor/semantic/semantic.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('public/vendor/toast-master/jquery.toast.css') ?>" rel="stylesheet" type="text/css">

</head>

<body>
    <!-- Header Start -->
    <header class="header clearfix">
        <button type="button" id="toggleMenu" class="toggle_menu">
            <i class='uil uil-bars'></i>
        </button>
        <button id="collapse_menu" class="collapse_menu">
            <i class="uil uil-bars collapse_menu--icon "></i>
            <span class="collapse_menu--label"></span>
        </button>
        <div class="main_logo" id="logo">
            <a href="index.html"><img class="img-fluid" src="<?= base_url('public/images/logo.png') ?>" alt=""></a>
            <a href="index.html"><img class="logo-inverse img-fluid" src="<?= base_url('images/ct_logo.png') ?>" alt=""></a>
        </div>
        <div class="search120 header_right">
            <div class="ui search">
                <div class="ui left icon input swdh10">
                    <input class="prompt srch10" type="text" name="text" placeholder="Buscar texto especifico, test y mas...">
                    <i class='uil uil-search-alt icon icon1'></i>
                </div>
            </div>
        </div>
        <div class="header_right">
            <ul>
                <li>
                    <a href="#" class="upload_btn" id="search_text">
                        <i class='uil uil-search-alt icon icon1'></i>
                        Buscar texto especifico</a>
                </li>
                <li>

                    <a href="index.html" class="option_links"><i class='uil uil-home-alt'></i><span class="noti_count">9+</span></a>
                </li>
                <li class="ui dropdown">
                    <a href="#" class="option_links"><i class='uil uil-envelope-alt'></i><span class="noti_count">3</span></a>
                    <div class="menu dropdown_ms">
                        <a href="#" class="channel_my item">
                            <div class="profile_link">
                                <img src="<?= base_url('public/images/left-imgs/img-6.jpg') ?>" alt="">
                                <div class="pd_content">
                                    <h6>Zoena Singh</h6>
                                    <p>Hi! Sir, How are you. I ask you one thing please explain it this video price.</p>
                                    <span class="nm_time">2 min ago</span>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="channel_my item">
                            <div class="profile_link">
                                <img src="<?= base_url('public/images/left-imgs/img-5.jpg') ?>" alt="">
                                <div class="pd_content">
                                    <h6>Joy Dua</h6>
                                    <p>Hello, I paid you video tutorial but did not play error 404.</p>
                                    <span class="nm_time">10 min ago</span>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="channel_my item">
                            <div class="profile_link">
                                <img src="<?= base_url('public/images/left-imgs/img-8.jpg') ?>" alt="">
                                <div class="pd_content">
                                    <h6>Jass</h6>
                                    <p>Thanks Sir, Such a nice video.</p>
                                    <span class="nm_time">25 min ago</span>
                                </div>
                            </div>
                        </a>
                        <a class="vbm_btn" href="instructor_messages.html">View All <i class='uil uil-arrow-right'></i></a>
                    </div>
                </li>
                <li class="ui dropdown">
                    <a href="#" class="option_links"><i class='uil uil-bell'></i><span class="noti_count">3</span></a>
                    <div class="menu dropdown_mn">
                        <a href="#" class="channel_my item">
                            <div class="profile_link">
                                <img src="images/left-imgs/img-1.jpg" alt="">
                                <div class="pd_content">
                                    <h6>Rock William</h6>
                                    <p>Like Your Comment On Video <strong>How to create sidebar menu</strong>.</p>
                                    <span class="nm_time">2 min ago</span>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="channel_my item">
                            <div class="profile_link">
                                <img src="images/left-imgs/img-2.jpg" alt="">
                                <div class="pd_content">
                                    <h6>Jassica Smith</h6>
                                    <p>Added New Review In Video <strong>Full Stack PHP Developer</strong>.</p>
                                    <span class="nm_time">12 min ago</span>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="channel_my item">
                            <div class="profile_link">
                                <img src="images/left-imgs/img-9.jpg" alt="">
                                <div class="pd_content">
                                    <p> Your Membership Approved <strong>Upload Video</strong>.</p>
                                    <span class="nm_time">20 min ago</span>
                                </div>
                            </div>
                        </a>
                        <a class="vbm_btn" href="instructor_notifications.html">View All <i class='uil uil-arrow-right'></i></a>
                    </div>
                </li>
                <li class="ui dropdown">
                    <a href="#" class="opts_account">
                        <img src="<?= $user[0]['url_imagen_facebook'] ?>" alt="">
                    </a>
                    <div class="menu dropdown_account">
                        <div class="channel_my">
                            <div class="profile_link">
                                <img src="<?= $user[0]['url_imagen_facebook'] ?>" alt="">
                                <div class="pd_content">
                                    <div class="rhte85">
                                        <h6><?= $user[0]['nombres'] . ' ' . $user[0]['apellidos'] ?></h6>
                                        <div class="mef78" title="Verify">
                                            <i class='uil uil-check-circle'></i>
                                        </div>
                                    </div>
                                    <span>gambol943@gmail.com</span>
                                </div>
                            </div>
                            <a href="my_instructor_profile_view.html" class="dp_link_12">View Instructor Profile</a>
                        </div>
                        <div class="night_mode_switch__btn">
                            <a href="#" id="night-mode" class="btn-night-mode">
                                <i class="uil uil-moon"></i> Night mode
                                <span class="btn-night-mode-switch">
                                    <span class="uk-switch-button"></span>
                                </span>
                            </a>
                        </div>
                        <a href="instructor_dashboard.html" class="item channel_item">Cursus dashbofffffard</a>
                        <a href="membership.html" class="item channel_item">Paid Memberships</a>
                        <a href="setting.html" class="item channel_item">Setting</a>
                        <a href="help.html" class="item channel_item">Help</a>
                        <a href="feedback.html" class="item channel_item">Send Feedback</a>
                        <a href="<?= base_url('finish') ?>" class="item channel_item">Sign Out</a>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <!-- Header End -->
    <!-- Left Sidebar Start -->
    <nav class="vertical_nav">
        <?= $menu ?>
    </nav>
    <!-- Left Sidebar End -->
    <!-- Body Start -->
    <div class="wrapper">
        <div class="content">
            <?= $content ?>
        </div>
        <footer class="footer mt-30">
            <?= $footer ?>
        </footer>
    </div>
    <!-- Footer Start -->
    <!-- Footer End -->
    <!-- Body End -->


    <script src="<?= base_url('public/js/vertical-responsive-menu.min.js') ?>"></script>
    <script src="<?= base_url('public/js/jquery-3.3.1.min.js') ?>"></script>
    <script src="<?= base_url('public/js/facebook.js') ?>"></script>
    <script src="<?= base_url('public/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('public/vendor/OwlCarousel/owl.carousel.js') ?>"></script>
    <script src="<?= base_url('public/vendor/semantic/semantic.min.js') ?>"></script>
    <script src="<?= base_url('public/js/custom.js') ?>"></script>
    <script src="<?= base_url('public/js/night-mode.js') ?>"></script>
    <script src="<?= base_url('public/vendor/toast-master/jquery.toast.js') ?>"></script>


</body>

</html>