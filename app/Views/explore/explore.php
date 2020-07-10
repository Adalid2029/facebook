<div class="sa4d25">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="st_title"><i class="uil uil-comments"></i> Secuencias Encontradas</h2>
            </div>
            <div class="header_right text-center">
                <div class="ui search">
                    <div class="ui left icon input swdh10">
                        <input class="prompt srch10" type="text" name="text" placeholder="Buscar texto especifico, test y mas...">
                        <i class='uil uil-search-alt icon icon1'></i>
                    </div>
                </div>
                <label for="posgrado">Pagina Posgrado</label>
                <input type="checkbox" id="posgrado" checked>
                <label for="politica">Politica Externa</label>
                <input type="checkbox" id="politica">
            </div>
            <div class="header_right">
                <ul>
                    <li>
                        <a href="#" class="btn btn-danger" id="buscar_texto">
                            <i class='uil uil-search-alt icon icon1'></i>
                            Buscar texto especifico</a>
                        <p>Resultados de la mineria <?= isset($cantidad_comentarios) ? $cantidad_comentarios : '' ?></p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="all_msg_bg">
                <div class="row no-gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="simplebar-content-wrapper">
                            <div class="group_messages">
                                <?php if (isset($comentarios)) : ?>
                                    <?php foreach ($comentarios as $key => $value) : ?>
                                        <div class="chat__message__dt">
                                            <div class="user-status">
                                                <div class="user-avatar">
                                                    <a href="<?= $url_perfiles[$key] ?>" target="_blank"><img src="<?= $imagen_perfiles[$key] ?>" alt="<?= $nombres_perfiles[$key] ?>"></a>
                                                </div>
                                                <div class="ver_post" data-target="#post">
                                                    <p class="user-status-title"><span class="bold"><?= $nombres_perfiles[$key] ?></span></p>
                                                    <p class="user-status-text"><?= $value ?></p>
                                                    <p class="user-status-time floaty"></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div id="post" class="modal vd_mdl fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div id="post-dialog" class="modal-dialog" role="document">
        <div id="post-content" class="modal-content">
            <div id="post-header" class="modal-header">
                <h5 id="post-title" class="modal-title" id="exampleModalLabel">Modal title</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="post-body" class="modal-body">
            </div>

        </div>
    </div>
</div>