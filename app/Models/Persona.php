<?php

namespace App\Models;

use CodeIgniter\Model;

class Persona extends Model
{
    protected $table = 'persona';
    protected $primaryKey = 'id_persona';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_api_facebook',  'id_facebook', 'tipo', 'nombres', 'apellidos', 'fecha_nacimiento', 'genero', 'url_perfil_facebook', 'url_imagen_facebook'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
