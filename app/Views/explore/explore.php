<div class="sa4d25">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="st_title"><i class="uil uil-comments"></i> Secuencias Encontradas</h2>
            </div>
        </div>
        <div class="row">

            <div class="all_msg_bg">
                <div class="row no-gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="simplebar-content-wrapper">
                            <div class="group_messages">
                                <?php if (isset($text_searched)) : ?>
                                    <?php foreach ($text_searched as $key => $value) : ?>
                                        <div class="chat__message__dt">
                                            <div class="user-status">
                                                <div class="user-avatar">
                                                    <img src="public/images/left-imgs/img-1.jpg" alt="">
                                                    <div class="msg__badge">2</div>
                                                </div>
                                                <p class="user-status-title"><span class="bold"><?= $users[$key] ?></span></p>
                                                <p class="user-status-text"><?= $value ?></p>
                                                <p class="user-status-time floaty">7 hours ago</p>
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