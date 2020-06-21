<?php

namespace App\Controllers;

class DataBase extends BaseController
{

    public function database()
    {
        return $this->templater->view('/database/database', $this->data);
    }
}
