<?php

namespace App\Models;

use CodeIgniter\Model;

class Publicacion extends Model
{
    protected $table = 'publicacion';
    protected $primaryKey = 'id_publicacion';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_api_facebook', 'id_persona', 'texto_post', 'tipo', 'creacion_publicacion',  'compartir', 'reproducciones', 'imagen_publicacion'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
