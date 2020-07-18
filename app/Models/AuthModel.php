<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'view_usuarios';
    protected $primaryKey = 'id_api';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_persona', 'id_api_facebook', 'nombres', 'apellidos', 'url_imagen_facebook', 'clave', 'nombre_usuario', 'estado', 'nombre', 'descripcion'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
