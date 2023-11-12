<?php

namespace App\core;

class View {
    public function generate($content_view, $template_view = null, $data = null){
        include_once VIEW . 'layout.phtml';
    }
}