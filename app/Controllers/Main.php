<?php

namespace App\Controllers;

class Main extends BaseController
{
    public function index()
    {
        // $text = 'Hola como ESTAS hola en este dia tan especial TAN';
        // $tokens = tokenize($text, \TextAnalysis\Tokenizers\PennTreeBankTokenizer::class);
        // $normalizedTokens = normalize_tokens($tokens);
        // $freqDist = freq_dist(tokenize($text));
        // $bigrams = ngrams($tokens);
        // $stemmedTokens = stem($tokens);

        // $nb = naive_bayes();
        // $nb->train('mexican', tokenize('taco nacho enchilada burrito'));
        // $nb->train('american', tokenize('hamburger burger fries pop'));
        // $nb->predict(tokenize('my favorite food is a burrito'));

        // var_dump($tokens);
        // var_dump($normalizedTokens);
        // var_dump($freqDist);
        // var_dump($bigrams);
        // var_dump($stemmedTokens);
        // var_dump($nb);
        //$this->data['personas'] = $this->persona->findAll();
        //$this->data['personas'] = array();
        //return $this->templater->view('main', $this->data);
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
