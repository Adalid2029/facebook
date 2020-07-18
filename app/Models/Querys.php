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
    public function view_usuarios($accion, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table('view_usuarios');

        switch ($accion) {
            case 'select':
                if (is_array($condicion)) {
                    return $builder->getWhere($condicion)->getResultArray();
                } else {
                    return $builder->get()->getResultArray();
                }
                break;
            case 'search':
                break;
        }
    }
    public function persona($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table('persona');
        switch ($accion) {
            case 'select':
                if (is_array($condicion)) {
                    return $builder->getWhere($condicion)->getResultArray();
                } else {
                    return $builder->get()->getResultArray();
                }
                break;
            case 'insert':
                return $builder->insert($datos) ? $this->db->insertID() : $this->db->error();
                break;
            case 'update':
                return $builder->update($datos, $condicion) ? true : $this->db->error();
                break;
            case 'search':
                return $builder->like('nombres', $busqueda)->get()->getResultArray();
                break;
        }
    }

    public function correo_electronico($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table('correo_electronico');
        switch ($accion) {
            case 'select':
                if (is_array($condicion)) {
                    return $builder->getWhere($condicion)->getResultArray();
                } else {
                    return $builder->get()->getResultArray();
                }
                break;
            case 'insert':
                return $builder->insert($datos) ? $this->db->insertID() : $this->db->error();
                break;
        }
    }
    public function usuario($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table('usuario');
        switch ($accion) {
            case 'select':
                if (is_array($condicion)) {
                    return $builder->getWhere($condicion)->getResultArray();
                } else {
                    return $builder->get()->getResultArray();
                }
                break;
            case 'insert':
                return $builder->insert($datos) ? $this->db->insertID() : $this->db->error();
                break;
        }
    }
    public function grupo_usuario($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table('grupo_usuario');
        switch ($accion) {
            case 'select':
                if (is_array($condicion)) {
                    return $builder->getWhere($condicion)->getResultArray();
                } else {
                    return $builder->get()->getResultArray();
                }
                break;
            case 'insert':
                return $builder->insert($datos) ? $this->db->insertID() : $this->db->error();
                break;
            case 'update':
                return $builder->update($datos, $condicion) ? true : $this->db->error();;
                break;
        }
    }
    public function grupo($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table('grupo');
        switch ($accion) {
            case 'select':
                if (is_array($condicion))
                    return $builder->getWhere($condicion)->getResultArray();
                else
                    return $builder->get()->getResultArray();

                break;
            case 'insert':
                return $builder->insert($datos) ? $this->db->insertID() : $this->db->error();
                break;
        }
    }
    public function publicacion($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table('publicacion');
        switch ($accion) {
            case 'select':
                break;
            case 'update':
                return $builder->update($datos, $condicion) ? true : $this->db->error();;
                break;
            case 'search':
                return $builder->like('lower(nombres)', $busqueda)->get()->getResultArray();
                break;
        }
    }
    public function obtenerPostPersonaComentario($condicion = null, $busqueda = null, $tipo)
    {
        $builder = $this->db->table('persona');
        $builder->select('*');
        $builder->join('comentario', 'comentario.id_persona = persona.id_persona');
        $builder->join('publicacion', 'publicacion.id_publicacion = comentario.id_publicacion');
        $builder->where('comentario.tipo', $tipo);
        $builder->orderBy('comentario.id_comentario', 'DESC');


        // $query = $this->db->getLastQuery();
        // echo (string) $query;
        return $builder->like('lower(comentario)', $busqueda)->get()->getResultArray();
    }
    public function obtenerPostPersonaComentarioPosgrado($condicion = null, $busqueda = null)
    {
        $builder = $this->db->table('post');
        $builder->select('*');
        $builder->join('persona', 'persona.id_facebook = post.id_facebook');
        $builder->join('comentario', 'post.id_post = comentario.id_post');
        $builder->join('persona p', 'p.id_facebook = comentario.id_facebook');
        $builder->where('persona.tipo', 'posgrado');
        $builder->orderBy('comentario.id_comentario', 'DESC');
        return $builder->like('lower(comentario)', $busqueda)->get()->getResultArray();
    }
    public function obtenerPostPersonaTodo($condicion = null, $busqueda = null)
    {
        $builder = $this->db->table('post');
        $builder->select('*');
        $builder->join('persona', 'persona.id_facebook = post.id_facebook');
        $builder->join('comentario', 'post.id_post = comentario.id_post');
        $builder->join('persona p', 'p.id_facebook = comentario.id_facebook');
        $builder->orderBy('comentario.id_comentario', 'DESC');
        return $builder->like('lower(comentario)', $busqueda)->get()->getResultArray();
    }
    // public function obtenerCantidadComentarioPersona($limite = 10, $orden = 'desc')
    // {
    //     try {
    //         $query = $this->db->query('select fp.*, fc.* from fb_persona fp,(select fc.id_facebook, count(fc.comentario) as total_comentario from fb_comentario fc group by fc.id_facebook)fc where where tipo="politica" and fp.id_facebook =fc.id_facebook order by fc.total_comentario ' . $orden . ' limit ' . $limite);
    //         return $query->getResultArray();
    //     } catch (\Exception $e) {
    //         die($e->getMessage());
    //         return $e->getMessage();
    //     }
    // }
    public function obtenerCantidadComentarioPersona($accion, $condicion = null, $busqueda = null, $limite = 10, $orden = 'desc')
    {
        try {
            switch ($accion) {
                case 'select':
                    if (is_array($condicion)) {
                        $query = $this->db->query('select fp.*, fc.* from fb_persona fp, (select fc.id_persona , count(fc.comentario) as total_comentario from fb_comentario fc group by fc.id_persona )fc where fp.id_persona = fc.id_persona order by fc.total_comentario ' . $orden . ' limit ' . $limite);
                        return $query->getResultArray();
                    } else {
                        $query = $this->db->query('select fp.*, fc.* from fb_persona fp, (select fc.id_persona , count(fc.comentario) as total_comentario from fb_comentario fc group by fc.id_persona )fc where fp.id_persona = fc.id_persona order by fc.total_comentario ' . $orden . ' limit ' . $limite);
                        return $query->getResultArray();
                    }
                    break;
                case 'search':
                    $query = $this->db->query("select fp.*, fc.*from fb_persona fp, (select fc.id_persona , count(fc.comentario) as total_comentario from fb_comentario fc group by fc.id_persona )fc where  lower(concat(COALESCE(fp.nombres,''),' ',COALESCE(fp.apellidos,''))) like lower('%" . $busqueda . "%') and fp.id_persona = fc.id_persona order by fc.total_comentario " . $orden . " limit " . $limite);
                    return $query->getResultArray();
                    break;
            }
        } catch (\Exception $e) {
            die($e->getMessage());
            return $e->getMessage();
        }
    }
}
