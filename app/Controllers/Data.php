<?php

namespace App\Controllers;

class Data extends BaseController
{

    public function index()
    {
        return $this->templater->view('/database/data', $this->data);
    }
    public function rechargeDataBasePolitic()
    {
        $i = 0;
        $description = array();
        $comments = array();
        $name_seller = array();
        $id_fb_seller = array();
        $image_seller = array();
        //return var_dump(count($this->dataPoliticModel->findAll()));
        //echo $this->dataPoliticModel->insertID();
        foreach ($this->dataPoliticModel->findAll() as $data) {
            $id_facebook = $this->extractIdFacebook($data['url_profile'], 2);
            if (count($this->persona->where(array('id_facebook' => $id_facebook))->findAll()) == 0) {
                $personas = [
                    'nombres' => trim($data['name_profile']),
                    'id_facebook' => trim($id_facebook),
                    'url_perfil_facebook' => trim($this->extractUrlFacebook($data['url_profile'])),
                    //'url_imagen_facebook' => $data['img_profile']
                ];
                $this->persona->insert($personas);
            }

            $html = str_get_html($data['html_comment']);
            foreach ($html->find('span._3l3x') as $ul) {
                $comments[] = trim(strip_tags($ul->innertext));
            }

            foreach ($html->find('div._4eek') as $key => $ul) {
                if ($i < count($comments)) {
                    $name_seller[] = trim($ul->find('a._6qw4')[0]->innertext);
                    $image_seller[] = trim($ul->find('img._3me-')[0]->src);

                    /**Ectraccion de id del usuario */
                    $id_fb_seller[] = $this->extractIdFacebook(trim($ul->find('a._3mf5')[0]->href), 1);
                    $i++;
                }
            }

            $this->insertPostAndComments(array(
                'texto_post' => trim($data['description']),
                'reacciones' => $this->extractReactions(trim($data['reactions'])),
                'compartir' => trim($data['reproductions']),
                'imagen_post' => trim($data['img_publication']),
                'id_persona' => trim($this->extractIdFacebook($data['url_profile'], 2)),
            ), array());
        }
        //var_dump($description);
        //var_dump($comments);
        //var_dump($name_seller);
        //var_dump($image_seller);
        //var_dump($id_fb_seller);
    }
    function insertPostAndComments($posts, $comments)
    {
        var_dump($posts);
    }
    function extractReactions($react = '')
    {
        if (strpos($react, ' ') != false) {
            return substr($react, 0, strpos($react, ' '));
        } else {
            return 0;
        }
    }
    function extractIdFacebook($link = '', $reference)
    {
        if ($reference == 1) {
            if (strpos($link, '&') != false) {
                $dat1 = substr($link, 1, (strpos($link, '&')) - 1);
                return substr($dat1, strpos($dat1, '?') + 4);
            } else {
                return substr($link, 1, (strpos($link, '?')) - 1);
            }
        } else {
            if (strpos($link, '&') != false) {
                if (strpos($link, '?fref=gs&__tn__=%2CdlC-R-R&eid=AR') != false)
                    return substr($link, 25, (strpos($link, '&') - 33));
                else
                    return substr($link, 40, (strpos($link, '&') - 40));
            } else {
                if (strpos(substr($link, 25), '?')) {
                    return substr($link, 40);
                } else
                    return substr($link, 25);
            }
        }
    }
    function extractUrlFacebook($link = '')
    {
        if (strpos($link, '&') != false) {
            return substr($link, 0, strpos($link, '&'));
        } else {
            return $link;
        }
    }
    function extractUrlImageFacebook($link = '')
    {
        if (strpos($link, '&') != false) {
            return substr($link, 0, strpos($link, '&'));
        } else {
            return $link;
        }
    }

    public function rechargeDataBasePosgrado()
    {
    }
}
