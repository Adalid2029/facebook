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
            $comments = array();
            $name_seller = array();
            $id_fb_seller = array();
            $image_seller = array();
            foreach ($dataPolitic as $i => $data) {
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
                    die($e->getMessage());
                    return $this->response->setJSON(array('error' => $e->getMessage()));
                }

                $id_facebook = trim($this->extractIdFacebook($data['url_profile'], 2));
                $existePersona = count($this->persona->where(['id_facebook' => $id_facebook])->findAll());
                if ($existePersona == 0) {
                    $this->insertPerson([
                        'nombres' => trim($data['name_profile']),
                        'id_facebook' => $id_facebook,
                        'url_perfil_facebook' => trim($this->extractUrlFacebook($data['url_profile'])),
                        'url_imagen_facebook' => $data['image_profile']
                    ]);
                } elseif ($existePersona == 1) {
                    $this->querys->persona(
                        'update',
                        [
                            'nombres' => trim($data['name_profile']),
                            'url_perfil_facebook' => trim($this->extractUrlFacebook($data['url_profile'])),
                            'url_imagen_facebook' => $data['image_profile']
                        ],
                        ['id_facebook' => $id_facebook]
                    );
                }
                foreach ($name_seller as $key => $name) {
                    if (count($this->persona->where(array('id_facebook' => $id_fb_seller[$key]))->findAll()) == 0) {
                        $this->insertPerson(array(
                            'nombres' => trim($name),
                            'id_facebook' => trim($id_fb_seller[$key]),
                            'url_perfil_facebook' => trim('https://www.facebook.com/' . $id_fb_seller[$key]),
                            'url_imagen_facebook' => trim($image_seller[$key])
                        ));
                    } elseif ($existePersona == 1) {
                        $this->querys->persona(
                            'update',
                            [
                                'nombres' => trim($data['name_profile']),
                                'url_perfil_facebook' => trim('https://www.facebook.com/' . $id_fb_seller[$key]),
                                'url_imagen_facebook' => trim($image_seller[$key])
                            ],
                            ['id_facebook' => $id_fb_seller[$key]]
                        );
                    }
                }
            }

            foreach ($dataPolitic as $i => $data) {

                $this->insertPostAndComments([
                    'texto_post' => trim($data['description']),
                    'reproducciones' => trim($data['reproductions']),
                    'imagen_publicacion' => trim($data['img_publication']),
                    'id_persona' => $this->querys->persona('select', null, ['id_facebook' => trim($this->extractIdFacebook($data['url_profile'], 2))])[0]['id_persona'],
                ], [
                    'comments' => $comments,
                    'id_fb_seller' => $id_fb_seller
                ]);
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
        $id_post = $this->publicacion->insert($posts);

        foreach ($comments['comments'] as $key => $comment) {
            $this->comentario->insert(array(
                'comentario' => $comments['comments'][$key],
                'id_post' => $id_post,
                'id_persona' => $this->querys->persona('select', null, ['id_facebook' => $comments['id_fb_seller'][$key]])[0]['id_persona']
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

        foreach ($data->posts->data as $keyData => $data) {
            try {
                if (count($this->persona->where(array('id_api_facebook' => $data->from->id))->findAll()) == 0) {
                    $this->persona->insert([
                        'id_api_facebook' => $data->from->id,
                        'nombres' => $data->from->name,
                        'tipo' => 'POSGRADO'
                    ]);
                }
                if (isset($data->comments)) {
                    foreach ($data->comments->data as $keyComment => $comment) {
                        if (count($this->persona->where(array('id_api_facebook' => $comment->from->id))->findAll()) == 0) {
                            $this->persona->insert([
                                'nombres' => $comment->from->name,
                                'id_api_facebook' => $comment->from->id,
                                'tipo' => 'POSGRADO'
                            ]);
                        }
                    }
                }
                if (isset($data->reactions)) {
                    foreach ($data->reactions->data as $keyReaction => $reaction) {
                        $existePersona = count($this->persona->where(array('id_api_facebook' => $reaction->id))->findAll());
                        if ($existePersona == 0) {
                            $this->persona->insert([
                                'nombres' => $reaction->name,
                                'id_api_facebook' => $reaction->id,
                                'url_imagen_facebook' => $reaction->pic_large,
                                'tipo' => 'POSGRADO'
                            ]);
                        } elseif ($existePersona == 1) {
                            $this->querys->persona(
                                'update',
                                [
                                    'url_imagen_facebook' => $reaction->pic_large,
                                    'tipo' => 'POSGRADO'
                                ],
                                ['id_api_facebook' => $reaction->id]
                            );
                        }
                    }
                }
                # Iniciamos con las publicaciones
                $cantidadPost = count($this->publicacion->where(array('id_api_facebook' => $data->id, 'tipo' => 'POSGRADO'))->findAll());
                if ($cantidadPost == 0) {
                    $idPublicacion = $this->publicacion->insert([
                        'id_api_facebook' => $data->id,
                        'id_persona' => $this->querys->persona('select', null, ['id_api_facebook' => $data->from->id])[0]['id_persona'],
                        'creacion_publicacion' => date('Y-m-d H:i', strtotime($data->created_time)),
                        'texto_post' => $data->message,
                        'compartir' => $data->shares->count,
                        'imagen_publicacion' => $data->full_picture,
                        'tipo' => 'POSGRADO'
                    ]);
                } elseif ($cantidadPost == 1) {
                    $this->querys->publicacion('update', [
                        'id_persona' => $this->querys->persona('select', null, ['id_api_facebook' => $data->from->id])[0]['id_persona'],
                        'creacion_publicacion' => date('Y-m-d H:i', strtotime($data->created_time)),
                        'texto_post' => $data->message,
                        'compartir' => $data->shares->count,
                        'imagen_publicacion' => $data->full_picture
                    ], ['id_api_facebook' => $data->id, 'tipo' => 'POSGRADO']);

                    $idPublicacion = $this->publicacion->where(array('id_api_facebook' => $data->id, 'tipo' => 'POSGRADO'))->findAll()[0]['id_publicacion'];
                }
                // if (isset($data->reactions)) {
                //     foreach ($data->reactions->data as $keyReaction => $reaction) {
                //         $existeReaccion = count($this->persona->where(array('id' => $reaction->id, 'tipo' => 'POSGRADO'))->findAll());
                //         if ($existePersona == 0) {
                //             $this->persona->insert([
                //                 'nombres' => $reaction->name,
                //                 'id' => $reaction->id,
                //                 'url_imagen_facebook' => $reaction->pic_large,
                //                 'tipo' => 'POSGRADO'
                //             ]);
                //         }
                //     }
                // }
                if (isset($data->comments)) {
                    foreach ($data->comments->data as $keyComment => $comment) {
                        if (count($this->comentario->where(array('id_api_facebook' => $comment->id, 'tipo' => 'POSGRADO'))->findAll()) == 0) {
                            $this->comentario->insert(array(
                                'id_persona' => $this->querys->persona('select', null, ['id_api_facebook' => $comment->from->id])[0]['id_persona'],
                                'id_api_facebook' => $comment->id,
                                'id_publicacion' => $idPublicacion,
                                'comentario' => $comment->message,
                                'creacion_comentario' => date('Y-m-d H:i', strtotime($comment->created_time)),
                                'tipo' => 'POSGRADO'
                            ));
                        }
                    }
                }
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        }
        return $this->response->setJSON(array('success' => 'La carga de la Base de Datos se realizo correctamente'));
    }
}
