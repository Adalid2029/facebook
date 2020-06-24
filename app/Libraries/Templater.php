<?php

namespace App\Libraries;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;

class Templater extends BaseController
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
