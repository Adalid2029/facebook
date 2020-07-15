<?php

namespace App\Controllers;

use TextAnalysis\Analysis\Keywords\Rake;
use TextAnalysis\Documents\TokensDocument;
use TextAnalysis\Tokenizers\WhitespaceTokenizer;
use StopWordFactory;
use TextAnalysis\Filters;

class Explore extends BaseController
{
    const NGRAM_SIZE = 3;

    /**
     * @var \TextAnalysis\Interfaces\ITokenTransformation[]
     */
    protected $tokenFilters = [];

    /**
     * @var \TextAnalysis\Interfaces\ITokenTransformation[]
     */
    protected $contentFilters = [];
    public function index()
    {
        return $this->templater->view('explore/explore', $this->data);
    }
    public function analizarPost()
    {
        $comentarios = [];
        $source = 'es';
        $target = 'en';
        foreach ($this->comentario->find([1, 2, 3, 4, 5]) as $key => $com) {
            var_dump($com['comentario']);
            $comentarios[] = $this->trans->translate($source, $target, $com['comentario']);
        }
        foreach ($comentarios as $key => $com) {
            $output_text_with_emoji = $this->analyzer->getSentiment($com);
            print_r($output_text_with_emoji);
        }
        print_r($comentarios);
    }
    public function mineriaTodo()
    {
        try {
            $comentario = array();
            $nombrePerfil = array();
            $imagenPerfil = array();
            $urlPerfil = array();
            foreach ($this->querys->obtenerPostPersonaTodo(null, trim(strtolower($this->request->getPost('text')))) as $key => $value) {

                $comentario[] =  $value['comentario'];
                $nombrePerfil[] =  $value['nombres'] . $value['apellidos'];
                $imagenPerfil[] =  $value['url_imagen_facebook'];
                $urlPerfil[] = $value['url_perfil_facebook'];
            }
            $this->data['comentarios'] = $comentario;
            $this->data['nombres_perfiles'] = $nombrePerfil;
            $this->data['imagen_perfiles'] = $imagenPerfil;
            $this->data['url_perfiles'] = $urlPerfil;
            $this->data['cantidad_comentarios'] = count($comentario);
            if (count($comentario) > 0) {
                return $this->response->setJSON(array('exito' => true, 'vista' => $this->templater->view('explore/explore', $this->data)));
            } else {
                return $this->response->setJSON(array('error' => 'No se encontro ningun dato en la mineria'));
            }
        } catch (\Exception $e) {
            die($e->getMessage());
            return $this->response->setJSON(array('error' => $e->getMessage()));
        }
    }
    public function mineriaPosgrado()
    {
        try {
            $comentario = array();
            $nombrePerfil = array();
            $imagenPerfil = array();
            $urlPerfil = array();
            foreach ($this->querys->obtenerPostPersonaComentarioPosgrado(null, trim(strtolower($this->request->getPost('text')))) as $key => $value) {

                $comentario[] =  $value['comentario'];
                $nombrePerfil[] =  $value['nombres'] . $value['apellidos'];
                $imagenPerfil[] =  $value['url_imagen_facebook'];
                $urlPerfil[] = $value['url_perfil_facebook'];
            }
            $this->data['comentarios'] = $comentario;
            $this->data['nombres_perfiles'] = $nombrePerfil;
            $this->data['imagen_perfiles'] = $imagenPerfil;
            $this->data['url_perfiles'] = $urlPerfil;
            $this->data['cantidad_comentarios'] = count($comentario);
            if (count($comentario) > 0) {
                return $this->response->setJSON(array('exito' => true, 'vista' => $this->templater->view('explore/explore', $this->data)));
            } else {
                return $this->response->setJSON(array('error' => 'No se encontro ningun dato en la mineria'));
            }
        } catch (\Exception $e) {
            die($e->getMessage());
            return $this->response->setJSON(array('error' => $e->getMessage()));
        }
    }
    public function mineriaPolitica()
    {
        try {
            $comentario = array();
            $nombrePerfil = array();
            $imagenPerfil = array();
            $urlPerfil = array();
            foreach ($this->querys->obtenerPostPersonaComentario(null, trim(strtolower($this->request->getPost('text')))) as $key => $value) {

                $comentario[] =  $value['comentario'];
                $nombrePerfil[] =  $value['nombres'] . $value['apellidos'];
                $imagenPerfil[] =  $value['url_imagen_facebook'];
                $urlPerfil[] = $value['url_perfil_facebook'];
            }
            $this->data['comentarios'] = $comentario;
            $this->data['nombres_perfiles'] = $nombrePerfil;
            $this->data['imagen_perfiles'] = $imagenPerfil;
            $this->data['url_perfiles'] = $urlPerfil;
            $this->data['cantidad_comentarios'] = count($comentario);
            if (count($comentario) > 0) {
                return $this->response->setJSON(array('exito' => true, 'vista' => $this->templater->view('explore/explore', $this->data)));
            } else {
                return $this->response->setJSON(array('error' => 'No se encontro ningun dato en la mineria'));
            }
        } catch (\Exception $e) {
            die($e->getMessage());
            return $this->response->setJSON(array('error' => $e->getMessage()));
        }
    }
    public function get($content)
    {
        foreach ($this->getContentFilters() as $contentFilter) {
            $content = $contentFilter->transform($content);
        }
        return $this->getKeywordScores($content);
    }
    /**
     * 
     * @return \TextAnalysis\Interfaces\ITokenTransformation[]
     */
    public function getContentFilters()
    {
        if (empty($this->contentFilters)) {

            $lambdaFunc = function ($word) {
                return  preg_replace('/[\x00-\x1F\x80-\xFF]/u', ' ', $word);
            };

            $this->contentFilters = [
                new Filters\StripTagsFilter(),
                new Filters\LowerCaseFilter(),
                new Filters\NumbersFilter(),
                new Filters\EmailFilter(),
                new Filters\UrlFilter(),
                new Filters\PossessiveNounFilter(),
                new Filters\QuotesFilter(),
                new Filters\PunctuationFilter(),
                new Filters\CharFilter(),
                new Filters\LambdaFilter($lambdaFunc),
                new Filters\WhitespaceFilter()
            ];
        }
        return $this->contentFilters;
    }

    /**
     * 
     * @return \TextAnalysis\Interfaces\ITokenTransformation[]
     */
    public function getTokenFilters()
    {
        if (empty($this->tokenFilters)) {
            $stopwords = StopWordFactory::get('stop-words_spanish_1_es.txt');
            $this->tokenFilters = [
                new Filters\StopWordsFilter($stopwords),
            ];
        }
        return $this->tokenFilters;
    }

    /**
     * 
     * @param string $content
     * @return array
     */
    public function getKeywordScores($content)
    {
        $tokens = (new WhitespaceTokenizer())->tokenize($content);
        $tokenDoc = new TokensDocument(array_map('strval', $tokens));
        unset($tokens);

        foreach ($this->getTokenFilters() as $filter) {
            $tokenDoc->applyTransformation($filter, false);
        }

        $size = count($tokenDoc->toArray());
        if ($size < self::NGRAM_SIZE) {
            return [];
        }

        $rake = new Rake($tokenDoc, self::NGRAM_SIZE);
        return $rake->getKeywordScores();
    }
}
