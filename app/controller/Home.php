<?php

namespace App\controller;

use App\core\Controller;

class Home extends Controller{
    public function index() {
        $this->view->generate('home.phtml','layout.phtml');
    }
    public function roles() {
        $this->view->generate('roles.phtml','layout.phtml');
    }
    public function logs() {
        $this->view->generate('logger.phtml','layout.phtml');
    }
}