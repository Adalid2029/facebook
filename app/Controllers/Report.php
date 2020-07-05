<?php

namespace App\Controllers;

class Report extends BaseController
{
    public function index()
    {
        $this->data['personas'] = $this->querys->obtenerCantidadComentarioPersona(20, 'desc');
        return $this->templater->view('report/report', $this->data);
    }
    public function ajaxCantidadComentarioPersona()
    {
        if ($this->request->isAJAX()) {
            $cantidadComentarios = $this->querys->obtenerCantidadComentarioPersona(5, 'desc');
            if (is_array($cantidadComentarios)) {
                return $this->response->setJSON(array('exito' => true, 'cantidad_comentarios' => $cantidadComentarios));
            } else {
                return $this->response->setJSON(json_encode(array('error' => $cantidadComentarios)));
            }
        }
    }
}
