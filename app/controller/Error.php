<?php

namespace App\controller;

use App\core\Controller;

class Error extends Controller{
    public function index() {
        $this->view->generate('error.phtml','layout.phtml');
    }
}