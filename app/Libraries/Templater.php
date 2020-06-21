<?php

namespace App\Libraries;

use CodeIgniter\HTTP\RequestInterface;
use App\Models\AuthModel;

class Templater
{
    public $request = null;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    function login()
    {
        echo view('login');
    }

    function view($content, $data = array(), $base = "base")
    {

        if ($this->request->isAJAX()) {
            $ajax = view($content, $data);
            return css_tag($content) . $ajax . script_tag($content);
        } else {

            $data['footer'] = view('footer', $data);
            $data['menu'] = view('menu', $data);

            $data['content'] = view($content, $data);
            return view($base, $data);
        }
    }
}
