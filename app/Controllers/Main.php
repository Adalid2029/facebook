<?php

namespace App\Controllers;

class Main extends BaseController
{

    public function index()
    {
        //$this->data['personas'] = $this->persona->findAll();
        $this->data['personas'] = array();
        return $this->templater->view('main', $this->data);
    }

    public function cargar_texto()
    {
        //return var_dump($this->request->getPost());
        $comentarios_extraidos = array();
        $archivo = fopen("datos.csv", "w+b");    // Abrir el archivo, creándolo si no existe
        if ($archivo == false)
            echo "Error al crear el archivo";
        else {
            foreach ($this->request->getPost('respuesta')['posts']['data'] as $key0 => $data) {
                if (isset($data['comments']['data'])) {
                    foreach ($data['comments']['data'] as $key1 => $comments) {
                        fwrite($archivo, $comments['message'] . PHP_EOL);
                    }
                }
            }
        }
        fclose($archivo);   // Cerrar el archivo
        $this->response->setJSON(array('gol' => 'sk'));
    }
}
