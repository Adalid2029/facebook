<?php

namespace App\Controllers;

class Main extends BaseController
{

    public function index()
    {
        return $this->templater->view('main', $this->data);
        $str = <<<HTML
        <h6 class="accessible_elem">Comentarios</h6><div class="_3tz_ _7790"></div><div class="_3tz_ _7794"></div><div class="_3bem"><div class=" _3bep"><div class="_4a0v _1x3z __fa"><div class="_4b0g"><div class="_5pd7"></div><div class="_5pd7"></div><div class="_5pd7"></div></div></div><div class="__fb"></div></div></div><div class="clearfix _4eez _43u6 _4jby clearfix" data-ft="{&quot;tn&quot;:&quot;[&quot;}" left="[object Object]" right="[object Object]" direction="left"><div class="_ohe lfloat"><span aria-hidden="true" class=" _3mf5 _3mg0"><img alt="Adalid Posgrado" class="_3me- _3mf1 img" src="https://scontent.flpb2-1.fna.fbcdn.net/v/t1.0-1/cp0/p32x32/84565089_137861947697124_6155892551371980800_o.jpg?_nc_cat=110&amp;_nc_sid=7206a8&amp;_nc_oc=AQnfSSPAaKZ7tkono0UPsRzy5GoSpQ9I78wrwVJnooeZ-YCRO2-E1LplelPTcJEsyII&amp;_nc_ht=scontent.flpb2-1.fna&amp;oh=55cc3055eacfb1cb1058378ca408324d&amp;oe=5F113A2F"></span></div><div class=""><div class="_42ef"><div class="_25-w"><div class="_17pg"><div class="_17pg"><div class="_1rwk"><form class=" _129h"><div class=" _3d2q _65tb _7c_r _4w79" data-visualcompletion="ignore"><div class="_5rp7"><div class="_1p1t"><div class="_1p1v" id="placeholder-4bjfh" style="white-space: pre-wrap;">Escribe un comentario...</div></div><div class="_5rpb"><div aria-describedby="placeholder-4bjfh" aria-label="Escribe un comentario..." class="notranslate _5rpu" contenteditable="true" role="textbox" spellcheck="true" style="outline: none; user-select: text; white-space: pre-wrap; overflow-wrap: break-word;"><div data-contents="true"><div class="" data-block="true" data-editor="4bjfh" data-offset-key="1kqjj-0-0"><div data-offset-key="1kqjj-0-0" class="_1mf _1mj"><span data-offset-key="1kqjj-0-0"><br data-text="true"></span></div></div></div></div></div></div></div><ul class="_1obb"><li class="_1obc"><span data-hover="tooltip"><a aria-label="Inserta un emoji" class="_1t9_ _1ta3" role="button" href="#"><div class="InsertEmoji"></div></a></span></li><li class="_1obc"><span data-hover="tooltip"><a aria-label="Adjunta una foto o un video" class="_1t9_ _7ja_" role="button" href="#"><div class=" _3n43"></div></a></span></li><li class="_1obc"><span data-hover="tooltip"><a aria-label="Publica un GIF" class="_1t9_ _1ny6" role="button" href="#"><div class="_1nyp"></div></a></span></li><li class="_1obc"><span data-hover="tooltip"><a aria-label="Publica un sticker" class="_1t9_ _2r-o" role="button" href="#"><div class="_2r-r"></div></a></span></li></ul></form></div></div></div></div></div></div></div>
        HTML;

        $comments = array();
        $image_seller = array();
        $name_seller = array();
        $id_fb_seller = array();

        $html = str_get_html($str);
        foreach ($html->find('span._3l3x') as $key => $ul) {
            $comments[] = trim(strip_tags($ul->innertext));
        }
        foreach ($html->find('div._4eek') as $key => $ul) {
            if ($key >= count($comments)) {
                break;
            } else {
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
            }
        }


        var_dump($comments);
        var_dump($name_seller);
        var_dump($image_seller);
        var_dump($id_fb_seller);
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
