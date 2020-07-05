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
    public function post($accion, $datos, $condicion, $busqueda)
    {
        $builder = $this->db->table('post');
        switch ($accion) {
            case 'select':
                break;
            case 'search':
                return $builder->like('lower(nombres)', $busqueda)->get()->getResultArray();
                break;
        }
    }
    public function obtenerPostPersonaComentario($condicion = null, $busqueda = null)
    {
        $builder = $this->db->table('post');
        $builder->select('*');
        $builder->join('persona', 'persona.id_facebook = post.id_facebook');
        $builder->join('comentario', 'post.id_post = comentario.id_post');
        return $builder->get()->getResultArray();
    }
    public function obtenerCantidadComentarioPersona($limite = 10, $orden = 'desc')
    {
        try {
            $query = $this->db->query('select fp.*, fc.* from fb_persona fp,(select fc.id_facebook, count(fc.comentario) as total_comentario from fb_comentario fc group by fc.id_facebook)fc where fp.id_facebook =fc.id_facebook order by fc.total_comentario ' . $orden . ' limit ' . $limite);
            return $query->getResultArray();
        } catch (\Exception $e) {
            die($e->getMessage());
            return $e->getMessage();
        }
    }
}
