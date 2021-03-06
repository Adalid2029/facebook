<!-- Styles -->
<style>
    #chartdiv {
        width: 100%;
        height: 250px;
    }
</style>
<div class="sa4d25">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="st_title"><i class="uil uil-comments"></i> Perfiles de Facebook que mas comentan</h2>
            </div>
        </div>
        <div class="row">
            <div class="all_msg_bg">
                <div class="row no-gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div id="chartdiv"></div>
                    </div>
                </div>
            </div>
            <br>
            <div class="all_msg_bg">
                <div class="la5lo1">
                    <div class="row">
                        <?php foreach ($personas as $key => $value) : ?>
                            <div class="col-md-3">
                                <div class="course-overlay stream_1 mb-30 user-avatar">
                                    <a target="_blank" href="<?= base_url('report/print') . '/' . $value['id_persona'] ?>" class="crse_reviews ver_reporte">
                                        <i class="uil uil-star"></i>Reporte
                                    </a>
                                    <a href="<?= isset($value['id_facebook']) ? $value['id_facebook'] : 'https://www.facebook.com/search/top/?q=' . $value['nombres'] . ' ' . $value['apellidos'] . '&epa=SEARCH_BOX' ?>" target="_blank" class="stream_bg">
                                        <img src="<?= $value['url_imagen_facebook'] ?>" alt="">
                                        <h4><?= $value['nombres'] . ' ' . $value['apellidos'] ?></h4>
                                        <p><?= isset($value['id_facebook']) ? $value['id_facebook'] : $value['id_api_facebook'] ?><span></span></p>
                                        <div class="msg__badge"><?= $value['total_comentario'] ?></div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>