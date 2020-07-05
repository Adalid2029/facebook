<div class="sa4d25">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="st_title"><i class="uil uil-apps"></i> Panel de Instructor</h2>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card_dash">
                    <div class="card_dash_left">
                        <h5>Personas</h5>
                        <h2><?= $number_people ?></h2>
                        <span class="crdbg_1"><?= date('d/m/Y') ?></span>
                    </div>
                    <div class="card_dash_right">
                        <img src="public/images/dashboard/achievement.svg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card_dash">
                    <div class="card_dash_left">
                        <h5>Publicaciones</h5>
                        <h2><?= $number_posts ?></h2>
                        <span class="crdbg_2"><?= date('d/m/Y') ?></span>
                    </div>
                    <div class="card_dash_right">
                        <img src="public/images/dashboard/graduation-cap.svg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card_dash">
                    <div class="card_dash_left">
                        <h5>Comentarios</h5>
                        <h2><?= $number_comments ?></h2>
                        <span class="crdbg_3"><?= date('d/m/Y') ?></span>
                    </div>
                    <div class="card_dash_right">
                        <img src="public/images/dashboard/online-course.svg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card_dash">
                    <div class="card_dash_left">
                        <h5>Busquedas</h5>
                        <h2>234</h2>
                        <span class="crdbg_4"><?= date('d/m/Y') ?></span>
                    </div>
                    <div class="card_dash_right">
                        <img src="public/images/dashboard/knowledge.svg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12">
                <hr>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="section3125">
                    <h4 class="item_title">Usuarios registrados</h4>
                    <a id="ver_perfiles" href="#" class="see150">Ver todo</a>
                    <div class="la5lo1">
                        <div class="owl-carousel live_stream owl-theme">
                            <?php foreach ($personas as $key => $value) : ?>
                                <div class="item">
                                    <div class="stream_1">
                                        <a href="<?= $value['url_perfil_facebook'] ?>" target="_blank" class="stream_bg">
                                            <img src="<?= $value['url_imagen_facebook'] ?>" alt="">
                                            <h4><?= $value['nombres'] . ' ' . $value['apellidos'] ?></h4>
                                            <p class="small"><?= $value['id_facebook'] ?><span></span></p>
                                        </a>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-3 col-lg-4">
                <div class="right_side">
                    <div class="fcrse_2 mb-30">
                        <div class="tutor_img">
                            <a href="<?= $user[0]['url_perfil_facebook'] ?>" target="_blank"><img src="<?= $user[0]['url_imagen_facebook'] ?>" alt=""></a>
                        </div>
                        <div class="tutor_content_dt">
                            <div class="tutor150">
                                <a href="<?= $user[0]['url_perfil_facebook'] ?>" class="tutor_name"><?= $user[0]['nombres'] . ' ' . $user[0]['apellidos'] ?></a>
                                <div class="mef78" title="Verify">
                                    <i class="uil uil-check-circle"></i>
                                </div>
                            </div>
                            <div class="tutor_cate">Web Developer, Designer, and Teacher</div>
                            <ul class="tutor_social_links">
                                <li><a href="#" class="fb"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#" class="tw"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#" class="ln"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#" class="yu"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                            <div class="tut1250">
                                <span class="vdt15">615K Students</span>
                                <span class="vdt15">12 Courses</span>
                            </div>
                            <a href="my_instructor_profile_view.html" class="prfle12link">Go To Profile</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>