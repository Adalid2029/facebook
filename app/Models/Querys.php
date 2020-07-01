<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class Querys extends Database
{
    public $db = null;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function persona($accion, $datos, $condicion, $busqueda)
    {
        $builder = $this->db->table('persona');
        switch ($accion) {
            case 'select':
                break;
            case 'search':
                return $builder->like('nombres', $busqueda)->get()->getResultArray();
                break;
        }
    }
}
