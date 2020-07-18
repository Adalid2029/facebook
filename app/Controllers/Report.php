<?php

namespace App\Controllers;

class Report extends BaseController
{
    public function index()
    {
        $this->data['personas'] = $this->querys->obtenerCantidadComentarioPersona('select', null, null, 20, 'desc');
        return $this->templater->view('report/report', $this->data);
    }
    public function ajaxCantidadComentarioPersona()
    {
        if ($this->request->isAJAX()) {
            $cantidadComentarios = $this->querys->obtenerCantidadComentarioPersona('select', null, null, 5, 'desc');
            if (is_array($cantidadComentarios)) {
                return $this->response->setJSON(array('exito' => true, 'cantidad_comentarios' => $cantidadComentarios));
            } else {
                return $this->response->setJSON(json_encode(array('error' => $cantidadComentarios)));
            }
        }
    }
    public function print($id_persona)
    {
        $this->data['persona'] = $this->persona->where('id_persona', $id_persona)->findAll();
        $this->data['comentarios'] = $this->comentario->where('id_persona', $id_persona)->findAll();
        //return var_dump($this->data['persona']);
        $this->mpdf->AddPageByArray([
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
        ]);
        $this->mpdf->SetHTMLFooter(date('d-m-Y H:s'));
        $this->mpdf->WriteHTML(view('report/model', $this->data));
        $this->response->setContentType('application/pdf');
        $this->mpdf->Output();
    }
}
