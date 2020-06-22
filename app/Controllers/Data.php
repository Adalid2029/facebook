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
        $image_seller = array();
        $name_seller = array();
        $id_fb_seller = array();
        //return var_dump(count($this->dataPoliticModel->findAll()));
        foreach ($this->dataPoliticModel->findAll() as $data) {
            //$description[] = $data['description'];
            $html = str_get_html($data['html_comment']);
            foreach ($html->find('span._3l3x') as $ul) {
                $comments[] = trim(strip_tags($ul->innertext));
            }

            foreach ($html->find('div._4eek') as $key => $ul) {
                if ($i < count($comments)) {
                    $name_seller[] = trim($ul->find('a._6qw4')[0]->innertext);
                    $image_seller[] = trim($ul->find('img._3me-')[0]->src);

                    /**Ectraccion de id del usuario */
                    $id_user = trim($ul->find('a._3mf5')[0]->href);
                    if (strpos($id_user, '&') != false) {
                        $dat1 = substr($id_user, 1, (strpos($id_user, '&')) - 1);
                        $id_fb_seller[] = substr($dat1, strpos($dat1, '?') + 4);
                    } else {
                        $id_fb_seller[] = substr($id_user, 1, (strpos($id_user, '?')) - 1);
                    }
                    $i++;
                }
            }
        }
        //var_dump($description);
        var_dump($comments);
        var_dump($name_seller);
        var_dump($image_seller);
        var_dump($id_fb_seller);
    }
    public function rechargeDataBasePosgrado()
    {
    }
}
