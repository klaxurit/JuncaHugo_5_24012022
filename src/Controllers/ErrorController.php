<?php

namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller {

    public function show404() {
        $this->twig->display('admin/errors/404.html.twig');
    }
}