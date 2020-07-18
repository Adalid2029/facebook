<?php

namespace App\Models;

use CodeIgniter\Model;

class Comentario extends Model
{
    protected $table = 'comentario';
    protected $primaryKey = 'id_comentario';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_api_facebook', 'id_persona', 'tipo', 'comentario', 'id_publicacion', 'creacion_comentario'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
