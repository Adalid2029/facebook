<?php

namespace App\Models;

use CodeIgniter\Model;

class DataPoliticModel extends Model
{
    protected $table = 'data_politic';
    protected $primaryKey = 'id_data_politic';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name_profile', 'url_profile', 'img_publication', 'html_comment', 'reactions', 'reproductions', 'image_profile'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
