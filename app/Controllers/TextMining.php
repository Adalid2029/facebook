<?php

namespace App\Controllers;

use TextAnalysis\Analysis\Keywords\Rake;
use TextAnalysis\Documents\TokensDocument;
use TextAnalysis\Tokenizers\WhitespaceTokenizer;
use StopWordFactory;
use TextAnalysis\Filters;

class TextMining extends BaseController
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
        foreach ($this->comentario->findAll() as $key => $value) {
            $this->get($value['comentario']);
            strpos($value['comentario'], 'elecciones') ? var_dump($value['comentario']) : null;
            //var_dump($this->get($value['comentario']));
        }
    }
    public function get($content)
    {
        foreach ($this->getContentFilters() as $contentFilter) {
            $content = $contentFilter->transform($content);
            //var_dump($content);
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
