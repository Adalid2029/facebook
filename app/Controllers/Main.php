<?php

namespace App\Controllers;

use App\Models\Querys;

class Main extends BaseController
{
    public function index()
    {
        $this->data['personas'] = $this->persona->findAll(10, 0);
        $this->data['number_people'] = count($this->persona->findAll());
        $this->data['number_posts'] = count($this->post->findAll());
        $this->data['number_comments'] = count($this->comentario->findAll());

        return $this->templater->view('main', $this->data);
    }

    public function listPeople()
    {
        $this->request->getPost('buscar_personas') == null
            ? $this->data['personas'] = $this->querys->obtenerCantidadComentarioPersonaPosgrado(60)
            : $this->data['personas'] = $this->querys->persona('search', null, null, strtolower(trim($this->request->getPost('buscar_personas'))));
        return $this->templater->view('explore/profiles', $this->data);
    }
}
