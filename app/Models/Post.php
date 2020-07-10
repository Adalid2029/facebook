<?php

namespace App\Models;

use CodeIgniter\Model;

class Post extends Model
{
    protected $table = 'post';
    protected $primaryKey = 'id_post';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['texto_post', 'compartir', 'reacciones', 'reproducciones', 'imagen_post', 'id_facebook', 'id', 'tipo', 'creacion_post'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
