<table class="table">
    <thead>
        <tr>
            <th scope="col"><img src="<?= base_url('public/images/upea.png') ?>" alt="auto" id="i2tc" /></th>
            <th scope="col"><img src="<?= base_url('public/images/posgrado.png') ?>" alt="" id="i2t" /></th>
            <th scope="col"><img src="<?= base_url('public/images/sistemas.png') ?>" alt="" id="i2tc" /></th>
        </tr>
    </thead>
</table>
<h3>Politic Data Mining</h3>
<hr>
<table class="table table-striped" cellspacing="10" cellpadding="10" style="border:1px dotted">
    <thead>
        <tr></tr>
        <tr></tr>
    </thead>
    <tbody>

        <tr>
            <th scope="col">id persona</th>
            <td scope="row"><?= $persona[0]['id_persona'] ?></td>
        </tr>
        <tr>
            <th scope="col">imagen perfil</th>
            <td><img style="width:100px; height:100px" src="<?= $persona[0]['url_imagen_facebook'] ?>" alt="<?= $persona[0]['nombres'] . ' ' . $persona[0]['apellidos'] ?>"></td>
        </tr>
        <tr>
            <th scope="col">id facebook</th>
            <td><?= $persona[0]['id_facebook'] ?></td>
        </tr>
        <tr>
            <th scope="col">url perfil</th>
            <td><?= $persona[0]['url_perfil_facebook'] ?></td>
        </tr>
        <tr>
            <th scope="col">Nombres Apellidos</th>
            <td><?= $persona[0]['nombres'] . ' ' . $persona[0]['apellidos'] ?></td>
        </tr>


    </tbody>
</table>
<br>
<hr>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Comentario</th>
            <th scope="col">id post</th>
            <th scope="col">created_at</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($comentarios as $key => $value) : ?>
            <tr>
                <th scope="row"><?= $key + 1 ?></th>
                <td><?= $value['comentario'] ?></td>
                <td><?= $value['id_publicacion'] ?></td>
                <td><?= $value['creacion_comentario'] ?></td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>


<style>
    * {
        box-sizing: border-box;
        margin: 0;
        border: 0;
    }

    .table {
        width: 100%;
    }

    tr {
        padding-bottom: 17px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }


    body {
        margin: 0;
    }

    #i2tc {
        width: 80px;
    }

    #i2t {
        height: 90px;
    }

    h1 {
        text-align: center;
    }
</style>