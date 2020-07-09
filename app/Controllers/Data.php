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
        try {
            $dataPolitic = $this->dataPoliticModel->findAll();
            foreach ($dataPolitic as $i => $data) {
                $comments = array();
                $name_seller = array();
                $id_fb_seller = array();
                $image_seller = array();

                try {
                    $html = str_get_html($data['html_comment']);

                    if (!empty($html)) {
                        foreach ($html->find('div._4eek') as $key => $ul) {
                            $name_seller[] = trim($ul->find('a._6qw4')[0]->innertext);
                            $image_seller[] = trim($ul->find('img._3me-')[0]->src);
                            $id_fb_seller[] = $this->extractIdFacebook(trim($ul->find('a._3mf5')[0]->href), 1);
                        }
                        foreach ($html->find('span._3l3x') as $ul) {
                            $comments[] = trim(strip_tags($ul->innertext));
                        }
                    }
                } catch (\Exception $e) {
                }

                $id_facebook = $this->extractIdFacebook($data['url_profile'], 2);
                if (count($this->persona->where(array('id_facebook' => $id_facebook))->findAll()) == 0) {
                    $this->insertPerson(array(
                        'nombres' => trim($data['name_profile']),
                        'id_facebook' => trim($id_facebook),
                        'url_perfil_facebook' => trim($this->extractUrlFacebook($data['url_profile'])),
                        'url_imagen_facebook' => $data['image_profile']
                    ));
                }
                foreach ($name_seller as $key => $name) {
                    if (count($this->persona->where(array('id_facebook' => $id_fb_seller[$key]))->findAll()) == 0) {
                        $this->insertPerson(array(
                            'nombres' => trim($name),
                            'id_facebook' => trim($id_fb_seller[$key]),
                            'url_perfil_facebook' => trim('https://www.facebook.com/' . $id_fb_seller[$key]),
                            'url_imagen_facebook' => trim($image_seller[$key])
                        ));
                    }
                }
            }

            foreach ($dataPolitic as $i => $data) {
                $comments = array();
                $name_seller = array();
                $id_fb_seller = array();
                $image_seller = array();
                try {
                    $html = str_get_html($data['html_comment']);

                    if (!empty($html)) {
                        foreach ($html->find('div._4eek') as $key => $ul) {
                            $name_seller[] = trim($ul->find('a._6qw4')[0]->innertext);
                            $image_seller[] = trim($ul->find('img._3me-')[0]->src);
                            $id_fb_seller[] = $this->extractIdFacebook(trim($ul->find('a._3mf5')[0]->href), 1);
                        }
                        foreach ($html->find('span._3l3x') as $ul) {
                            $comments[] = trim(strip_tags($ul->innertext));
                        }
                    }
                } catch (\Exception $e) {
                }
                $this->insertPostAndComments(array(
                    'texto_post' => trim($data['description']),
                    'reacciones' => $this->extractReactions(trim($data['reactions'])),
                    'reproducciones' => trim($data['reproductions']),
                    'imagen_post' => trim($data['img_publication']),
                    'id_facebook' => trim($this->extractIdFacebook($data['url_profile'], 2)),
                ), array(
                    'comments' => $comments,
                    'id_fb_seller' => $id_fb_seller
                ));
                $this->dataPoliticModel->delete($data['id_data_politic']);
            }
            return $this->response->setJSON(array('success' => 'La carga de la Base de Datos se realizo correctamente'));
        } catch (\Exception $e) {
            die($e->getMessage());
            return $this->response->setJSON(array('error' => $e->getMessage()));
        }
    }
    function insertPerson($persona)
    {
        $this->persona->insert($persona);
    }
    function insertPostAndComments($posts, $comments)
    {
        $id_post = $this->post->insert($posts);

        foreach ($comments['comments'] as $key => $comment) {
            $this->comentario->insert(array(
                'comentario' => $comments['comments'][$key],
                'id_post' => $id_post,
                'id_facebook' => $comments['id_fb_seller'][$key]
            ));
        }
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

        //return var_dump($this->request->getPost('respuesta'));
        $data = json_decode($this->request->getPost('respuesta'));

        foreach ($data->posts->data as $key0 => $data) {
            var_dump($data);
            // if (count($this->persona->where(array('id_facebook' => $id_facebook))->findAll()) == 0) {
            //     $this->insertPerson(array(
            //         'nombres' => trim($data['name_profile']),
            //         'id_facebook' => trim($id_facebook),
            //         'url_perfil_facebook' => trim($this->extractUrlFacebook($data['url_profile'])),
            //         'url_imagen_facebook' => $data['image_profile']
            //     ));
            // }
        }

        // foreach ($this->request->getPost('respuesta')['posts']['data'] as $key0 => $data) {
        //     if (isset($data['comments']['data'])) {
        //         foreach ($data['comments']['data'] as $key1 => $comments) {
        //             var_dump($comments['message']);
        //         }
        //     }
        // }

        return $this->response->setJSON(array('success' => 'La carga de la Base de Datos se realizo correctamente'));
    }
}
