<div class="sa4d25">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="section3125">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="item_title">Personas que mayormente comentan</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="ui search">
                                <div class="ui left icon input swdh10">
                                    <input class="prompt srch10" type="text" name="buscar_personas" id="buscar_personas" placeholder="Buscar personas...">
                                    <i class='uil uil-search-alt icon icon1'></i>
                                </div>
                            </div>

                        </div>
                    </div>
                    <br>
                    <div class="la5lo1">
                        <div class="row">
                            <?php foreach ($personas as $key => $value) : ?>
                                <div class="col-md-3">
                                    <div class="stream_1 mb-30 user-avatar">
                                        <a href="<?= isset($value['id_facebook']) ? $value['id_facebook'] : 'https://www.facebook.com/search/top/?q=' . $value['nombres'] . ' ' . $value['apellidos'] . '&epa=SEARCH_BOX' ?>" target="_blank" class="stream_bg">
                                            <img src="<?= $value['url_imagen_facebook'] ?>" alt="">
                                            <h4><?= $value['nombres'] . ' ' . $value['apellidos'] ?></h4>
                                            <p><?= isset($value['id_facebook']) ? $value['id_facebook'] : $value['id_api_facebook'] ?><span></span></p>
                                            <?php if (isset($value['total_comentario'])) : ?>
                                                <div class="msg__badge"><?= $value['total_comentario'] ?></div>
                                            <?php endif ?>
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
</div>